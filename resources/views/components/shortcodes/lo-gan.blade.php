<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-fire"></i> Lô Gan — Chưa Về Lâu Nhất</h2>
    <div style="display:grid; grid-template-columns: repeat(5, 1fr); gap:8px; padding:14px">
        @foreach($loGan as $num => $daysSince)
        <div style="text-align:center; padding:10px 4px; border:1px solid #eee; border-radius:8px; background:#fafafa">
            <span class="sc-badge sc-badge-hot" style="font-size:16px; padding:6px 12px">{{ str_pad($num, 2, '0', STR_PAD_LEFT) }}</span>
            <span style="display:block; font-size:11px; color:#888; margin-top:4px">{{ $daysSince }} ngày</span>
        </div>
        @endforeach
    </div>
</section>
