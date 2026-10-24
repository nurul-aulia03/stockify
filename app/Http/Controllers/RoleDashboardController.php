<?php

namespace App\Http\Controllers;

use App\Models\Product;

class RoleDashboardController extends Controller
{
    public function admin()
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        return redirect()->route('dashboard');
    }

    public function staff()
    {
        abort_unless(auth()->user()->role === 'staff', 403);

        return view('staff.dashboard');
    }

    public function customer()
    {
        abort_unless(auth()->user()->role === 'customer', 403);

        $products = Product::where('stock', '>', 0)
            ->latest()
            ->get();

        return view('customer.dashboard', compact('products'));
    }
}