<div>
    <div class="relative h-[300px]">
        <canvas id="allocationChart"></canvas>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const rawData = @json($alokasi);
        const allocationNames = rawData.map(a => a.nama);
        const allocationPercentages = rawData.map(a => a.persentase);

        // Hitung total
        const total = allocationPercentages.reduce((sum, val) => sum + val, 0);
        if (total < 100) {
            allocationNames.push('Sisa');
            allocationPercentages.push(100 - total);
        }

        // Daftar warna yang bisa digunakan
        const presetColors = [
            'rgb(75, 192, 192)',
            'rgb(54, 162, 235)',
            'rgb(255, 206, 86)',
            'rgb(255, 99, 132)',
            'rgb(153, 102, 255)',
            'rgb(255, 159, 64)',
        ];

        // Buat warna untuk masing-masing item
        const backgroundColors = allocationNames.map((name, index) => {
            if (name.toLowerCase() === 'sisa') {
                // Jika "Sisa"
                return 'rgb(192, 192, 192)';
            }
            // Jika jumlah item belum melebihi preset
            if (index < presetColors.length) {
                return presetColors[index];
            }
            // Jika jumlah item melebihi jumlah preset, buat warna random
            return `hsl(${Math.floor(Math.random() * 360)}, 70%, 60%)`;
        });

        const ctx = document.getElementById('allocationChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: allocationNames,
                datasets: [{
                    label: 'Persentase Alokasi',
                    data: allocationPercentages,
                    backgroundColor: backgroundColors,
                    hoverOffset: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                return `${label}: ${value}%`;
                            }
                        }
                    },
                    legend: {
                        position: 'bottom',
                    },
                },
            },
        });
    </script>
    @endpush
</div>
