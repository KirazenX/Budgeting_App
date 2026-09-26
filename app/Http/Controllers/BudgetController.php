<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $selectedYear = (int) $request->query('year', now()->year);
        $selectedMonth = (int) $request->query('month', now()->month);
        if ($selectedMonth < 1 || $selectedMonth > 12) {
            $selectedMonth = now()->month;
        }
        if ($selectedYear < 1970 || $selectedYear > 2100) {
            $selectedYear = now()->year;
        }

        $categories = Category::where('user_id', $userId)->get();

        foreach ($categories as $cat) {
            $cat->used = Transaction::where('user_id', $userId)
                ->where('category_id', $cat->id)
                ->where('type', 'expense')
                ->whereYear('date', $selectedYear)
                ->whereMonth('date', $selectedMonth)
                ->sum('amount');
        }

        return view('budgets.index', compact('categories', 'selectedMonth', 'selectedYear'));
    }
}
