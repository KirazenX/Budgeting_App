@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 lg:p-8">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Daftar Transaksi</h2>

    <!-- Add Transaction Button -->
    <a href="{{ route('transactions.create') }}" 
       class="inline-flex items-center px-4 py-2 mb-6 text-sm font-semibold text-white bg-primary-green rounded-xl shadow-md hover:bg-emerald-700 transition duration-200">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Tambah Transaksi
    </a>

    <!-- Table Card -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($transactions as $trx)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}</td>
                            
                            <!-- Transaction Type Badge -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($trx->type === 'income')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-light-green text-primary-green">
                                        Pemasukan
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-700">
                                        Pengeluaran
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $trx->category->name ?? '-' }}</td>
                            
                            <!-- Amount Display -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                @if($trx->type === 'income')
                                    <span class="text-primary-green">+ Rp {{ number_format($trx->amount,0,',','.') }}</span>
                                @else
                                    <span class="text-red-500">- Rp {{ number_format($trx->amount,0,',','.') }}</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $trx->description ?? '-' }}</td>

                            <!-- Action Buttons -->
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium w-40">
                                <a href="{{ route('transactions.edit', $trx->id) }}" 
                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 transition duration-150">
                                   Edit
                                </a>

                                <form action="{{ route('transactions.destroy', $trx->id) }}" 
                                      method="POST" 
                                      class="inline-block ml-2" 
                                      data-confirm="delete"
                                      data-message="Hapus transaksi tanggal {{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }} sebesar Rp {{ number_format($trx->amount,0,',','.') }}?">
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
                            <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                                Belum ada transaksi tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-4 p-4">
            {{ $transactions->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection