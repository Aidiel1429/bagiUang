<div>
    <div class="relative h-[300px]">
        <canvas id="incomeExpenseChart"></canvas>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('incomeExpenseChart').getContext('2d');
            const incomeExpenseChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: [12000000, 15000000, 10000000, 18000000, 14000000, 16000000, 15000000, 17000000, 13000000, 19000000, 20000000, 21000000],
                            backgroundColor: '#10B981',
                            barPercentage: 0.5,
                            categoryPercentage: 0.6
                        },
                        {
                            label: 'Pengeluaran',
                            data: [8000000, 9000000, 7000000, 12000000, 10000000, 11000000, 12000000, 13000000, 9000000, 14000000, 15000000, 16000000],
                            backgroundColor: '#EF4444',
                            barPercentage: 0.5,
                            categoryPercentage: 0.6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': Rp ' + context.raw.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 11
                                },
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            },
                            grid: {
                                color: '#e5e7eb'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
</div>
