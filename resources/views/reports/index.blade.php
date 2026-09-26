@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 lg:p-8">
    <h3 class="text-3xl font-extrabold text-gray-800 mb-6">Laporan Keuangan</h3>

    <div class="bg-white shadow-xl rounded-2xl p-6 mb-8">
        <h4 class="text-xl font-semibold text-gray-800 mb-4">Grafik Keuangan Bulanan</h4>
        <div class="relative h-96">
            <canvas id="financeChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById('financeChart').getContext('2d');

    // Warna konsisten dengan tema aplikasi
    const primaryGreen = '#059669'; // primary-green
    const red500 = '#EF4444'; // red-500

    const financeChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [
                {
                    label: "Pemasukan",
                    data: @json($incomeChart),
                    tension: 0.4,
                    borderWidth: 3,
                    borderColor: primaryGreen,
                    backgroundColor: 'rgba(5, 150, 105, 0.15)', // Light fill for green
                    fill: true,
                    pointRadius: 5,
                    pointBackgroundColor: primaryGreen,
                    pointHoverRadius: 8,
                },
                {
                    label: "Pengeluaran",
                    data: @json($expenseChart),
                    tension: 0.4,
                    borderWidth: 3,
                    borderColor: red500,
                    backgroundColor: 'rgba(239, 68, 68, 0.15)', // Light fill for red
                    fill: true,
                    pointRadius: 5,
                    pointBackgroundColor: red500,
                    pointHoverRadius: 8,
                }
            ]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    labels: {
                        font: { size: 14 },
                        color: "#4B5563", // gray-600
                        usePointStyle: true,
                    }
                },
                tooltip: {
                    backgroundColor: primaryGreen,
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: { weight: 'bold' },
                    bodyFont: { size: 14 },
                    callbacks: {
                        label: function(ctx) {
                            let value = ctx.raw.toLocaleString('id-ID');
                            return `${ctx.dataset.label}: Rp ${value}`;
                        }
                    }
                }
            },

            scales: {
                y: {
                    ticks: {
                        callback: value => 'Rp ' + value.toLocaleString('id-ID'),
                        color: "#6B7280", // gray-500
                        font: { size: 13 }
                    },
                    grid: {
                        color: "rgba(0,0,0,0.08)"
                    }
                },
                x: {
                    ticks: {
                        color: "#6B7280",
                        font: { size: 13 }
                    },
                    grid: { display: false }
                }
            },

            animation: {
                duration: 1200,
                easing: 'easeOutQuart'
            }
        }
    });
});
</script>
@endsection