@extends('layouts.app')

@section('content')

<div class="p-4 md:p-6 lg:p-8">

    <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Dashboard Keuangan Bulan Ini</h2>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white p-5 rounded-2xl shadow-lg border border-gray-100 transform hover:scale-[1.02] transition duration-300">
            <h6 class="text-sm font-medium text-gray-500 mb-1">Total Pemasukan</h6>
            <h4 class="text-2xl font-bold text-primary-green">Rp {{ number_format($income,0,',','.') }}</h4>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-lg border border-gray-100 transform hover:scale-[1.02] transition duration-300">
            <h6 class="text-sm font-medium text-gray-500 mb-1">Total Pengeluaran</h6>
            <h4 class="text-2xl font-bold text-red-500">Rp {{ number_format($expense,0,',','.') }}</h4>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-lg border border-gray-100 transform hover:scale-[1.02] transition duration-300">
            <h6 class="text-sm font-medium text-gray-500 mb-1">Sisa Anggaran</h6>

            @php
                $isDeficit = $overallRemaining < 0;
            @endphp
            <h4 class="text-2xl font-bold {{ $isDeficit ? 'text-red-500' : 'text-primary-green' }}">
                Rp {{ number_format($overallRemaining,0,',','.') }}
            </h4>

            @if($isDeficit)
                <small class="text-red-500 font-semibold mt-1 block">
                    ⚠ Anggaran bulan ini sudah melebihi batas!
                </small>
            @else
                <small class="text-gray-500 mt-1 block h-4"></small>
            @endif
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-lg border border-gray-100 transform hover:scale-[1.02] transition duration-300">
            <h6 class="text-sm font-medium text-gray-500 mb-1">Total Transaksi</h6>
            <h4 class="text-2xl font-bold text-gray-800">{{ $transactions->total() }}</h4>
        </div>
    </div>

    {{-- CHART --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
        <h5 class="text-xl font-semibold text-gray-800 mb-4">Grafik Bulanan</h5>
        <div class="relative h-80">
            <canvas id="financeChart"></canvas>
        </div>
    </div>

    {{-- CATEGORY PROGRESS --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
        <h5 class="text-xl font-semibold text-gray-800 mb-4">Pengeluaran Per Kategori (Bulan Ini)</h5>

        <div class="space-y-4">
            @foreach ($categorySpending as $cat)
                @php 
                    $spent = $cat->transactions->sum('amount');
                    $budget = $cat->monthly_budget ?: 1;
                    $percentage = min(100, ($spent / $budget) * 100);
                    
                    if ($percentage >= 100) {
                        $progressColor = 'bg-red-500';
                        $alertText = '⚠ Sudah melewati batas!';
                        $alertColor = 'text-red-500';
                    } elseif ($percentage >= 70) {
                        $progressColor = 'bg-yellow-500';
                        $alertText = '⚠ Mendekati batas anggaran.';
                        $alertColor = 'text-yellow-600';
                    } else {
                        $progressColor = 'bg-primary-green';
                        $alertText = '';
                        $alertColor = 'text-gray-500';
                    }

                    $remaining = ($cat->monthly_budget ?? 0) - $spent;
                @endphp

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <strong class="text-gray-700">{{ $cat->name }}</strong>
                        <span class="text-sm text-gray-600 font-medium">
                            Rp {{ number_format($spent,0,',','.') }}
                            / Rp {{ number_format($cat->monthly_budget,0,',','.') }}
                        </span>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="h-3 rounded-full {{ $progressColor }}" style="width: {{ $percentage }}%;"></div>
                    </div>

                    @if($alertText)
                        <small class="{{ $alertColor }} font-medium mt-1 block">{{ $alertText }}</small>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    {{-- TRANSACTION TABLE --}}
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h5 class="text-xl font-semibold text-gray-800 mb-4">Transaksi Terbaru</h5>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Deskripsi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($transactions as $tx)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($tx->date)->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $tx->type=='income'?'bg-light-green text-primary-green':'bg-red-100 text-red-700' }}">
                                {{ ucfirst($tx->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $tx->category ? $tx->category->name : 'Tanpa Kategori' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if($tx->type == 'expense')
                                <span class="text-red-500 font-semibold">- Rp {{ number_format($tx->amount,0,',','.') }}</span>
                            @else
                                <span class="text-primary-green font-semibold">Rp {{ number_format($tx->amount,0,',','.') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tx->description }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-4">
            {{ $transactions->links('pagination::tailwind') }}
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('financeChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($months),
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: @json($incomeData),
                            backgroundColor: '#059669', // primary-green
                            borderRadius: 6,
                        },
                        {
                            label: 'Pengeluaran',
                            data: @json($expenseData),
                            backgroundColor: '#EF4444', // red-500
                            borderRadius: 6,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                usePointStyle: true,
                            }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
    });

    // Catatan: Loading screen dihilangkan karena tidak bisa menggunakan JS untuk DOM manipulasi elemen yang di-comment.
</script>
@endsection