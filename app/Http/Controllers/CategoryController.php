<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function edit(Category $category)
    {
        if ($category->user_id !== auth()->id()) abort(403);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if ($category->user_id !== auth()->id()) abort(403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'monthly_budget' => 'nullable|numeric|min:0',
        ]);

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Kategori diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->user_id !== auth()->id()) abort(403);

        if ($category->transactions()->exists()) {
            return redirect()->route('categories.index')->with('error', 'Kategori memiliki transaksi. Hapus transaksi dulu atau pindahkan.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori dihapus.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'monthly_budget' => 'required|numeric|min:0'
        ]);

        Category::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'monthly_budget' => $request->monthly_budget,
        ]);

        return redirect()->route('categories.index');
    }
}

