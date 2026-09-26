@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 lg:p-8 flex justify-center">
    <div class="w-full max-w-xl">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Tambah Transaksi Baru</h2>

        <div class="bg-white shadow-xl rounded-2xl p-6 md:p-8">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf

                <!-- Tanggal -->
                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" 
                           id="date" 
                           name="date" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-primary-green focus:border-primary-green transition duration-150" 
                           value="{{ old('date', date('Y-m-d')) }}">
                    @error('date')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis -->
                <div class="mb-4">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Transaksi</label>
                    <select id="type" name="type" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-primary-green focus:border-primary-green transition duration-150">
                        <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="mb-4">
                    <label for="category-select" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select id="category-select" name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-primary-green focus:border-primary-green transition duration-150">
                        <option value="">Tanpa Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                        <option value="__new__">--- Buat Kategori Baru ---</option>
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
                           placeholder="Contoh: 50000" 
                           value="{{ old('amount') }}">
                    @error('amount')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (Opsional)</label>
                    <textarea id="description" name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-primary-green focus:border-primary-green transition duration-150" placeholder="Contoh: Beli kopi dan roti saat meeting">{{ old('description') }}</textarea>
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
                            class="px-4 py-2 text-sm font-semibold text-white bg-primary-green rounded-xl shadow-md hover:bg-emerald-700 transition duration-150">
                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
 
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var sel = document.getElementById('category-select');
        if(!sel) return;
        
        sel.addEventListener('change', function(e){
            if(this.value === '__new__'){
                // Navigasi ke halaman buat kategori
                window.location.href = "{{ route('categories.create') }}";
            }
        });
    });
</script>

@endsection