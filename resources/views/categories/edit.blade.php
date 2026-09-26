@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 lg:p-8 flex justify-center">
    <div class="w-full max-w-xl">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Edit Kategori</h2>

        <div class="bg-white shadow-xl rounded-2xl p-6 md:p-8">
            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama Kategori -->
                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-primary-green focus:border-primary-green transition duration-150" 
                           value="{{ old('name', $category->name) }}">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Budget Bulanan -->
                <div class="mb-6">
                    <label for="monthly_budget" class="block text-sm font-medium text-gray-700 mb-2">Budget Bulanan (Rp)</label>
                    <input type="number" 
                           id="monthly_budget" 
                           name="monthly_budget" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-primary-green focus:border-primary-green transition duration-150" 
                           value="{{ old('monthly_budget', $category->monthly_budget) }}">
                    @error('monthly_budget')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Aksi -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('categories.index') }}" 
                       class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-200 rounded-xl hover:bg-gray-300 transition duration-150">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-semibold text-white bg-yellow-500 rounded-xl shadow-md hover:bg-yellow-600 transition duration-150">
                        Update Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection