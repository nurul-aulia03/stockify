<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchaseItem;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $search = request('search');

        $purchases = Purchase::with(['supplier', 'user'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('purchase_number', 'like', '%' . $search . '%')
                      ->orWhereHas('supplier', function ($supplierQuery) use ($search) {
                          $supplierQuery->where('name', 'like', '%' . $search . '%');
                      });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('purchases.index', compact('purchases', 'search'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();

        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('purchases.create', compact(
            'suppliers',
            'products'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'purchase_date' => ['required', 'date'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::whereKey($validated['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if (!$product->is_active) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'product_id' => 'Produk ini sedang tidak aktif.',
                ]);
            }

            $quantity = (int) $validated['quantity'];
            $unitPrice = (float) $validated['unit_price'];
            $subtotal = $quantity * $unitPrice;

            $purchase = Purchase::create([
                'purchase_number' => 'PO-' . now()->format('YmdHis') . '-' . random_int(100, 999),
                'supplier_id' => $validated['supplier_id'],
                'user_id' => auth()->id(),
                'purchase_date' => $validated['purchase_date'],
                'total_amount' => $subtotal,
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
            ]);

            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
            ]);

            $stockBefore = $product->stock;
            $product->increment('stock', $quantity);
            $product->refresh();

            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'movement_type' => 'purchase',
                'quantity' => $quantity,
                'stock_before' => $stockBefore,
                'stock_after' => $product->stock,
                'reference_type' => 'purchase',
                'reference_id' => $purchase->id,
                'notes' => 'Pembelian ' . $purchase->purchase_number,
            ]);
        });

        return redirect()->route('purchases.index')
            ->with('success', 'Pembelian berhasil disimpan dan stok produk bertambah.');
    }
}