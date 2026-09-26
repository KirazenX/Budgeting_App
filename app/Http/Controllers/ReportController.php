<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $months = [];
        $incomeChart = [];
        $expenseChart = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthName = Carbon::now()->subMonths($i)->format('M Y');
            $months[] = $monthName;

            $incomeChart[] = Transaction::where('user_id', $userId)
                ->where('type', 'income')
                ->whereMonth('date', Carbon::now()->subMonths($i)->month)
                ->whereYear('date', Carbon::now()->subMonths($i)->year)
                ->sum('amount');

            $expenseChart[] = Transaction::where('user_id', $userId)
                ->where('type', 'expense')
                ->whereMonth('date', Carbon::now()->subMonths($i)->month)
                ->whereYear('date', Carbon::now()->subMonths($i)->year)
                ->sum('amount');
        }

        return view('reports.index', compact('months', 'incomeChart', 'expenseChart'));
    }

}
