<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Gender Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Distribusi Jenis Kelamin</h3>
            <div class="flex items-center justify-center h-48">
                <canvas id="genderChart"></canvas>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-2 text-center">
                <div class="p-2 bg-blue-50 rounded-lg">
                    <span class="block text-xl font-bold text-blue-700">{{ $genderData['Laki-laki'] }}</span>
                    <span class="text-xs text-blue-600">Laki-laki</span>
                </div>
                <div class="p-2 bg-pink-50 rounded-lg">
                    <span class="block text-xl font-bold text-pink-700">{{ $genderData['Perempuan'] }}</span>
                    <span class="text-xs text-pink-600">Perempuan</span>
                </div>
            </div>
        </div>

        <!-- Age Groups Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 lg:col-span-2">
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Kelompok Usia Pasien</h3>
            <div class="h-64">
                <canvas id="ageChart"></canvas>
            </div>
        </div>

        <!-- Polyclinic Stats -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 lg:col-span-3">
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Kunjungan per Unit Layanan (Poli)</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($poliStats as $stat)
                    <div class="p-4 bg-indigo-50 rounded-xl border border-indigo-100 text-center shadow-sm">
                        <span class="block text-2xl font-black text-indigo-700">{{ $stat->total }}</span>
                        <span class="text-xs font-semibold text-indigo-600 uppercase">{{ $stat->nama_poli }}</span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Gender Chart
            new Chart(document.getElementById('genderChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Laki-laki', 'Perempuan'],
                    datasets: [{
                        data: [{{ $genderData['Laki-laki'] }}, {{ $genderData['Perempuan'] }}],
                        backgroundColor: ['#3B82F6', '#EC4899'],
                        hoverOffset: 4
                    }]
                },
                options: { plugins: { legend: { position: 'bottom' } } }
            });

            // Age Chart
            new Chart(document.getElementById('ageChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($ageGroups)) !!},
                    datasets: [{
                        label: 'Jumlah Pasien',
                        data: {!! json_encode(array_values($ageGroups)) !!},
                        backgroundColor: '#6366F1',
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true } }
                }
            });
        });
    </script>
</div>
