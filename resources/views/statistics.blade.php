@extends('layouts.app')

@section('title', 'Thống Kê Xổ Số Chuyên Sâu - SOICAU7777')

@section('content')
<main class="max-w-7xl mx-auto px-4 py-12">
    <div class="mb-10 border-b border-white/5 pb-8">
        <h1 class="text-4xl font-black text-white uppercase tracking-tighter">THỐNG KÊ <span class="text-gradient">CHUYÊN SÂU</span> 📊</h1>
        <p class="text-gray-500 mt-2 font-bold text-xs uppercase tracking-widest italic">Phân tích nhịp loto, tần suất và lô gan Miền Bắc</p>
    </div>

    <!-- Chart Section -->
    <div class="glass-card rounded-3xl p-8 mb-8">
        <h3 class="text-xl font-black text-white mb-8 uppercase flex items-center gap-3">
            <i class="fas fa-chart-bar text-yellow-500"></i> BIỂU ĐỒ TẦN SUẤT LOTO (30 NGÀY)
        </h3>
        <div class="h-[400px] w-full">
            <canvas id="freqChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Tần Suất Xuất Hiện (Dạng list) -->
        <div class="glass-card rounded-3xl p-8">
            <h3 class="text-xl font-black text-white mb-6 uppercase flex items-center gap-3">
                <i class="fas fa-list-ol text-green-500"></i> TOP 10 SỐ VỀ NHIỀU
            </h3>
            <div class="space-y-4">
                @foreach($frequency as $item)
                <div class="flex items-center gap-4">
                    <span class="ball ball-blue w-10 h-10 flex-shrink-0">{{ $item['number'] }}</span>
                    <div class="flex-1 h-2 bg-white/5 rounded-full overflow-hidden">
                        <div class="h-full gradient-brand" style="width: {{ ($item['count'] / $frequency[0]['count']) * 100 }}%"></div>
                    </div>
                    <span class="text-xs font-black text-white w-12 text-right">{{ $item['count'] }} lần</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Thống Kê Lô Gan -->
        <div class="glass-card rounded-3xl p-8">
            <h3 class="text-xl font-black text-white mb-6 uppercase flex items-center gap-3">
                <i class="fas fa-fire-alt text-red-500"></i> TOP LÔ GAN CỰC ĐẠI
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black text-gray-500 uppercase tracking-widest border-b border-white/5">
                            <th class="pb-4">Con số</th>
                            <th class="pb-4">Số ngày chưa về</th>
                            <th class="pb-4 text-right">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($waiting as $item)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition">
                            <td class="py-4 font-black text-white text-lg">{{ $item['number'] }}</td>
                            <td class="py-4"><span class="text-red-500 font-bold">{{ $item['days'] }} ngày</span></td>
                            <td class="py-4 text-right">
                                <span class="px-2 py-1 bg-red-500/10 text-red-500 text-[9px] font-black rounded-full uppercase">Gan cao</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('freqChart').getContext('2d');
    const data = @json($frequency);
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.map(item => item.number),
            datasets: [{
                label: 'Số lần về',
                data: data.map(item => item.count),
                backgroundColor: 'rgba(255, 61, 61, 0.5)',
                borderColor: '#FF3D3D',
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: '#FF3D3D'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: { color: '#666', font: { weight: 'bold' } }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#fff', font: { weight: 'bold' } }
                }
            }
        }
    });
</script>
@endsection
