<div class="shortcode-thongke glass-card rounded-2xl overflow-hidden my-6">
    <div class="p-4 bg-blue-500/10 border-b border-blue-500/10">
        <h3 class="font-black text-blue-400 text-sm uppercase tracking-widest">
            <i class="fas fa-chart-bar mr-2"></i> THỐNG KÊ TẦN SUẤT — {{ $days }} NGÀY
        </h3>
    </div>
    <div class="p-4">
        <div class="grid grid-cols-5 sm:grid-cols-10 gap-2">
            @foreach($frequency as $num => $count)
                <div class="text-center p-2 rounded-lg bg-white/5 hover:bg-blue-500/10 transition">
                    <span class="block text-sm font-black text-white">{{ str_pad($num, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="block text-[10px] text-blue-400 font-bold mt-1">{{ $count }}x</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
