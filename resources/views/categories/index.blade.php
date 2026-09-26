@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 lg:p-8">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Kategori</h2>

    <a href="{{ route('categories.create') }}" 
       class="inline-flex items-center px-4 py-2 mb-6 text-sm font-semibold text-white bg-primary-green rounded-xl shadow-md hover:bg-emerald-700 transition duration-200">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Tambah Kategori
    </a>

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Budget Bulanan</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($categories as $cat)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $cat->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($cat->monthly_budget ?? 0, 0, ',', '.') }}</td>

                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium w-40">
                                <a href="{{ route('categories.edit', $cat->id) }}" 
                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 transition duration-150">
                                    Edit
                                </a>

                                <form action="{{ route('categories.destroy', $cat->id) }}" 
                                      method="POST" 
                                      class="inline-block ml-2"
                                      data-confirm="delete"
                                      data-message="Yakin ingin menghapus kategori {{ $cat->name }}? Transaksi terkait mungkin terpengaruh.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 text-xs font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition duration-150">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-6 text-center text-gray-500">Belum ada kategori tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection