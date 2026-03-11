<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-chart-bar"></i> Thống Kê Tần Suất — {{ $days }} Ngày</h2>
    <div style="display:grid; grid-template-columns: repeat(10, 1fr); gap:4px; padding:12px">
        @foreach($frequency as $num => $count)
        <div style="text-align:center; padding:6px 2px; border:1px solid #eee; border-radius:6px; background:#fafafa">
            <span style="display:block; font-size:13px; font-weight:800; color:#333">{{ str_pad($num, 2, '0', STR_PAD_LEFT) }}</span>
            <span style="display:block; font-size:10px; color:#3366cc; font-weight:700; margin-top:2px">{{ $count }}x</span>
        </div>
        @endforeach
    </div>
</section>
