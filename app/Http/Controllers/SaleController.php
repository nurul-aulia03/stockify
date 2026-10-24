<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    public function index()
    {
        $search = request('search');

        $sales = Sale::with('user')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('sale_number', 'like', '%' . $search . '%')
                      ->orWhere('customer_name', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('sales.index', compact('sales', 'search'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'customer_name' => 'nullable|string|max:150',
            'payment_method' => 'required|in:Cash,Transfer,QRIS',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::whereKey($validated['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $quantity = (int) $validated['quantity'];

            if ($product->stock < $quantity) {
                throw ValidationException::withMessages([
                    'quantity' => 'Stok produk tidak mencukupi.',
                ]);
            }

            $stockBefore = (int) $product->stock;
            $stockAfter = $stockBefore - $quantity;
            $unitPrice = (float) $product->selling_price;
            $subtotal = $unitPrice * $quantity;

            $sale = Sale::create([
                'sale_number' => 'SALE-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4)),
                'user_id' => auth()->id(),
                'sale_date' => now()->toDateString(),
                'total_amount' => $subtotal,
                'customer_name' => $validated['customer_name'] ?? 'Pelanggan Umum',
                'payment_method' => $validated['payment_method'],
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
            ]);

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
            ]);

            $product->stock = $stockAfter;
            $product->save();

            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'movement_type' => 'out',
                'quantity' => $quantity,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'reference_type' => 'sale',
                'reference_id' => $sale->id,
                'notes' => 'Penjualan ' . $sale->sale_number,
            ]);
        });

        return redirect()
            ->route('sales.index')
            ->with('success', 'Transaksi penjualan berhasil disimpan.');
    }
}