<div class="shortcode-logan glass-card rounded-2xl overflow-hidden my-6">
    <div class="p-4 bg-red-500/10 border-b border-red-500/10">
        <h3 class="font-black text-red-400 text-sm uppercase tracking-widest">
            <i class="fas fa-fire mr-2"></i> LÔ GAN — CHƯA VỀ LÂU NHẤT
        </h3>
    </div>
    <div class="p-4">
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
            @foreach($loGan as $num => $daysSince)
                <div class="text-center p-3 rounded-xl bg-white/5 border border-red-500/10 hover:border-red-500/30 transition">
                    <span class="block text-xl font-black text-red-400">{{ str_pad($num, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="block text-[10px] text-gray-500 mt-1">{{ $daysSince }} ngày</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
