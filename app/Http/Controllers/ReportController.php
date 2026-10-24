<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Purchase;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input(
            'start_date',
            now()->startOfMonth()->format('Y-m-d')
        );

        $endDate = $request->input(
            'end_date',
            now()->format('Y-m-d')
        );

        if ($startDate > $endDate) {
            [$startDate, $endDate] = [$endDate, $startDate];
        }

        $sales = Sale::with('user')
            ->where('status', 'completed')
            ->whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate)
            ->orderByDesc('sale_date')
            ->get();

        $purchases = Purchase::with('supplier')
            ->where('status', 'completed')
            ->whereDate('purchase_date', '>=', $startDate)
            ->whereDate('purchase_date', '<=', $endDate)
            ->orderByDesc('purchase_date')
            ->get();

        $products = Product::orderBy('name')->get();

        $totalSales = $sales->sum('total_amount');
        $totalPurchases = $purchases->sum('total_amount');
        $totalProducts = $products->count();

        $lowStockProducts = $products
            ->filter(function ($product) {
                return $product->stock <= $product->minimum_stock;
            });

        return view('reports.index', compact(
            'startDate',
            'endDate',
            'sales',
            'purchases',
            'products',
            'totalSales',
            'totalPurchases',
            'totalProducts',
            'lowStockProducts'
        ));
    }
}