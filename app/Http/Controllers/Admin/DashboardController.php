<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();
        $monthStart = Carbon::now()->startOfMonth();

        // ── KPI Stats ────────────────────────────────────────────
        $stats = [
            'total_users'       => User::count(),
            'total_products'    => Product::count(),
            'total_categories'  => Category::count(),
            'total_orders'      => Order::count(),
            'total_revenue'     => Order::where('status', 'completed')->sum('total_amount'),
            'new_users_today'   => User::whereDate('created_at', $today)->count(),
            'new_users_week'    => User::where('created_at', '>=', $weekStart)->count(),
            'pending_orders'    => Order::where('status', 'pending')->count(),
            'completed_orders'  => Order::where('status', 'completed')->count(),
            'out_of_stock'      => Product::where('stock', 0)->count(),
            'active_products'   => Product::where('is_active', true)->count(),
        ];

        // ── Orders by Status ──────────────────────────────────────
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $allStatuses = ['pending', 'paid', 'shipped', 'completed', 'cancelled'];
        foreach ($allStatuses as $s) {
            $ordersByStatus[$s] = $ordersByStatus[$s] ?? 0;
        }

        // ── Recent Activity ───────────────────────────────────────
        $latestOrders   = Order::with('user')
            ->latest()
            ->take(6)
            ->get();

        $latestUsers    = User::latest()->take(5)->get();

        $latestProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();

        // ── Alerts ────────────────────────────────────────────────
        // Low stock: products with stock > 0 but <= threshold
        $lowStockProducts = Product::where('stock', '>', 0)
            ->where('stock', '<=', 5)
            ->where('is_active', true)
            ->orderBy('stock')
            ->take(5)
            ->get();

        // Orders pending for more than 48 hours
        $stalePendingOrders = Order::where('status', 'pending')
            ->where('created_at', '<', now()->subHours(48))
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        // Recent cancellations (last 7 days)
        $recentCancellations = Order::where('status', 'cancelled')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        // ── Chart Data (last 30 days) ─────────────────────────────
        $last30Days = collect(range(29, 0))->map(fn($i) => Carbon::today()->subDays($i)->format('Y-m-d'));

        // Orders per day
        $ordersPerDay = Order::where('created_at', '>=', Carbon::today()->subDays(29))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date');

        // Revenue per day (completed orders)
        $revenuePerDay = Order::where('status', 'completed')
            ->where('created_at', '>=', Carbon::today()->subDays(29))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('sum(total_amount) as total'))
            ->groupBy('date')
            ->pluck('total', 'date');

        // User signups per day
        $usersPerDay = User::where('created_at', '>=', Carbon::today()->subDays(29))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date');

        $chartLabels  = $last30Days->map(fn($d) => Carbon::parse($d)->format('M d'))->values();
        $chartOrders  = $last30Days->map(fn($d) => $ordersPerDay[$d] ?? 0)->values();
        $chartRevenue = $last30Days->map(fn($d) => $revenuePerDay[$d] ?? 0)->values();
        $chartUsers   = $last30Days->map(fn($d) => $usersPerDay[$d] ?? 0)->values();

        return view('admin.dashboard', compact(
            'stats',
            'ordersByStatus',
            'latestOrders',
            'latestUsers',
            'latestProducts',
            'lowStockProducts',
            'stalePendingOrders',
            'recentCancellations',
            'chartLabels',
            'chartOrders',
            'chartRevenue',
            'chartUsers',
        ));
    }
}