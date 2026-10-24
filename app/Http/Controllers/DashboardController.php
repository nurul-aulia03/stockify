<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Purchase;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total seluruh produk
        $totalProducts = Product::count();

        // Total penjualan yang selesai
        $totalSales = Sale::where('status', 'completed')
            ->sum('total_amount');

        // Produk dengan stok 5 unit atau kurang
        $lowStock = Product::where('stock', '<=', 5)->count();

        // Total penjualan hari ini
        $salesToday = Sale::where('status', 'completed')
            ->whereDate('sale_date', today())
            ->sum('total_amount');

        // Grafik penjualan selama 7 hari terakhir
        $salesChart = collect(range(6, 0))
            ->map(function ($daysAgo) {
                $date = today()->subDays($daysAgo);

                return [
                    'label' => $date->format('d/m'),
                    'total' => (float) Sale::where('status', 'completed')
                        ->whereDate('sale_date', $date)
                        ->sum('total_amount'),
                ];
            });

        // Lima produk terlaris
        $bestSellingProducts = SaleItem::select(
                'product_id',
                DB::raw('SUM(quantity) as total_quantity')
            )
            ->whereHas('sale', function ($query) {
                $query->where('status', 'completed');
            })
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        // Lima transaksi penjualan terbaru
        $recentSales = Sale::with('user')
            ->where('status', 'completed')
            ->latest()
            ->take(5)
            ->get();

        // Lima transaksi pembelian terbaru
        $recentPurchases = Purchase::with('supplier')
            ->where('status', 'completed')
            ->latest()
            ->take(5)
            ->get();

        // Lima aktivitas perubahan stok terbaru
        $recentMovements = StockMovement::with('product')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalSales',
            'lowStock',
            'salesToday',
            'salesChart',
            'bestSellingProducts',
            'recentSales',
            'recentPurchases',
            'recentMovements'
        ));
    }
}