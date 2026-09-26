<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->paginate(10); 

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $categories = Category::where('user_id', auth()->id())->get();
        return view('transactions.create', compact('categories'));
    }

    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) abort(403);

        $categories = Category::where('user_id', auth()->id())->get();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) abort(403);

        $data = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string|max:1000',
        ]);

        if (!empty($data['category_id'])) {
            $cat = Category::where('id', $data['category_id'])
                            ->where('user_id', auth()->id())
                            ->first();
            if (!$cat) return redirect()->back()->withErrors(['category_id' => 'Kategori tidak valid.']);
        }

        $transaction->update($data);

        return redirect()->route('transactions.index')->with('success', 'Transaksi diupdate.');
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) abort(403);

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi dihapus.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:1',
            'date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        Transaction::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'date' => $request->date
        ]);

        return redirect()->route('transactions.index');
    }
}