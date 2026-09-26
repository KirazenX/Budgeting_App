@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 lg:p-8 flex justify-center">
    <div class="w-full max-w-xl">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Edit Transaksi</h2>

        <div class="bg-white shadow-xl rounded-2xl p-6 md:p-8">

            <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Tanggal -->
                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" 
                           id="date" 
                           name="date" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-primary-green focus:border-primary-green transition duration-150" 
                           value="{{ old('date', $transaction->date) }}">
                    @error('date')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis -->
                <div class="mb-4">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Transaksi</label>
                    <select id="type" name="type" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-primary-green focus:border-primary-green transition duration-150">
                        <option value="income" {{ old('type', $transaction->type)=='income' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="expense" {{ old('type', $transaction->type)=='expense' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select id="category_id" name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-primary-green focus:border-primary-green transition duration-150">
                        <option value="">Tanpa Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" 
                                {{ old('category_id', $transaction->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jumlah -->
                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Jumlah (Rp)</label>
                    <input type="number" 
                           id="amount" 
                           name="amount" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-primary-green focus:border-primary-green transition duration-150" 
                           value="{{ old('amount', $transaction->amount) }}">
                    @error('amount')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (Opsional)</label>
                    <textarea id="description" name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-primary-green focus:border-primary-green transition duration-150" >{{ old('description', $transaction->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Aksi -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('transactions.index') }}" 
                       class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-200 rounded-xl hover:bg-gray-300 transition duration-150">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-semibold text-white bg-yellow-500 rounded-xl shadow-md hover:bg-yellow-600 transition duration-150">
                        Update Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection