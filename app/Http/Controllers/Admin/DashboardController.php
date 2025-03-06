<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total users count
        $totalUsers = User::count();
        
        // Get new users in last 30 days
        $newUsers = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        
        // Get average monthly income
        $averageIncome = User::avg('salary');
        
        // Get most common spending categories
        $topCategories = Category::select('categories.name', DB::raw('COUNT(expenses.id) as count'))
            ->leftJoin('expenses', 'categories.id', '=', 'expenses.category_id')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('count')
            ->limit(5)
            ->get();
        
        // Get inactive users (no activity in last 2 months)
        $inactiveUsers = User::whereDoesntHave('expenses', function($query) {
            $query->where('created_at', '>=', Carbon::now()->subMonths(2));
        })->get();
        
        // Get monthly spending trends
        $monthlySpending = Expense::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(amount) as total')
        )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'newUsers',
            'averageIncome',
            'topCategories',
            'inactiveUsers',
            'monthlySpending'
        ));
    }
} 