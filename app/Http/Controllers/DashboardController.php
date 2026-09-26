<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $currentYear  = now()->year;
        $currentMonth = now()->month;

        $transactions = Transaction::where('user_id', $userId)
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->orderBy('date', 'desc')
            ->paginate(10)
            ->withQueryString();


        $income = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->sum('amount');

        $expense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->sum('amount');

        $months = collect(range(1, 12))->map(fn($m) =>
            Carbon::create()->month($m)->format('M')
        )->toArray();

        $incomeRaw = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->selectRaw('MONTH(date) as m, SUM(amount) as total')
            ->groupBy('m')
            ->pluck('total', 'm')
            ->toArray();

        $expenseRaw = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->selectRaw('MONTH(date) as m, SUM(amount) as total')
            ->groupBy('m')
            ->pluck('total', 'm')
            ->toArray();

        $incomeData = [];
        $expenseData = [];

        for ($i = 1; $i <= 12; $i++) {
            $incomeData[] = (float) ($incomeRaw[$i] ?? 0);
            $expenseData[] = (float) ($expenseRaw[$i] ?? 0);
        }


        $categorySpending = Category::with(['transactions' => function($q) {
            $q->whereMonth('date', now()->month)
              ->whereYear('date', now()->year)
              ->where('type', 'expense');
        }])
        ->where('user_id', $userId)
        ->get();

        $totalBudget = Category::where('user_id', $userId)->sum('monthly_budget');

        $totalUsed = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->sum('amount');

        $overallRemaining = $income - $expense;

        $isDeficit = $overallRemaining < 0;

        $overallPercentUsed = $totalBudget > 0
            ? min(100, ($totalUsed / $totalBudget) * 100)
            : 0;

        return view('dashboard.index', compact(
            'transactions',
            'income',
            'expense',
            'months',
            'incomeData',
            'expenseData',
            'categorySpending',
            'totalBudget',
            'totalUsed',
            'overallRemaining',
            'overallPercentUsed',
            'isDeficit',
        ));
    }
}
