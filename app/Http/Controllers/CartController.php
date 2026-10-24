<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $products = Product::whereIn('id', array_keys($cart))
            ->get()
            ->keyBy('id');

        $items = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            if (!isset($products[$productId])) {
                continue;
            }

            $product = $products[$productId];
            $subtotal = $product->selling_price * $quantity;
            $total += $subtotal;

            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
        }

        return view('customer.cart', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if (!$product->is_active || $product->stock < 1) {
            return back()->withErrors([
                'cart' => 'Produk sedang tidak tersedia.',
            ]);
        }

        $cart = session()->get('cart', []);
        $quantity = ($cart[$product->id] ?? 0)
            + (int) $request->quantity;

        if ($quantity > $product->stock) {
            return back()->withErrors([
                'cart' => 'Jumlah melebihi stok yang tersedia.',
            ]);
        }

        $cart[$product->id] = $quantity;
        session()->put('cart', $cart);

        return redirect()->route('customer.cart')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if (!$product->is_active || $request->quantity > $product->stock) {
            return back()->withErrors([
                'cart' => 'Jumlah melebihi stok atau produk tidak tersedia.',
            ]);
        }

        $cart = session()->get('cart', []);
        $cart[$product->id] = (int) $request->quantity;
        session()->put('cart', $cart);

        return back()->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        unset($cart[$product->id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.cart')
                ->withErrors(['cart' => 'Keranjang masih kosong.']);
        }

        try {
            $this->createOrder($request, $cart);
        } catch (\RuntimeException $e) {
            return redirect()->route('customer.cart')
                ->withErrors(['cart' => $e->getMessage()]);
        }

        session()->forget('cart');

        return redirect()->route('customer.cart')
            ->with('success', 'Checkout berhasil! Pesananmu sudah tersimpan.');
    }

    public function checkoutDirect(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $this->createOrder($request, [
                $product->id => (int) $validated['quantity'],
            ]);
        } catch (\RuntimeException $e) {
            return back()->withErrors(['checkout' => $e->getMessage()]);
        }

            return redirect()->route('customer.dashboard')
            ->with('success', 'Checkout langsung berhasil! Pesananmu sudah tersimpan.');
    }

    private function createOrder(Request $request, array $cart): Order
    {
        return DB::transaction(function () use ($request, $cart) {
            $total = 0;
            $orderItems = [];

            foreach ($cart as $productId => $quantity) {
                $product = Product::whereKey($productId)
                    ->lockForUpdate()
                    ->first();

                if (
                    !$product ||
                    !$product->is_active ||
                    $quantity < 1 ||
                    $product->stock < $quantity
                ) {
                    throw new \RuntimeException(
                        'Stok tidak mencukupi atau produk tidak tersedia. Periksa kembali produk.'
                    );
                }

                $price = $product->selling_price;
                $subtotal = $price * $quantity;
                $total += $subtotal;

                $orderItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ];
            }

            $order = Order::create([
                'user_id' => $request->user()->id,
                'order_number' => 'ORD-' . now()->format('YmdHis')
                    . '-' . Str::upper(Str::random(4)),
                'total_amount' => $total,
                'status' => 'pending',
            ]);

            foreach ($orderItems as $item) {
                $product = $item['product'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            return $order;
        });
    }
}