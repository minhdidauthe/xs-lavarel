<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-hourglass-half"></i> Lô Gan {{ $region }}@if($dai) — Đài {{ $dai }}@endif — {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>

        <style>
            .logan-cards{display:grid;grid-template-columns:repeat(5,1fr);gap:6px;padding:8px}
            .logan-card{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:10px 4px;border-radius:10px;border:1px solid #e0e0e0;background:#f8f9fa;min-height:70px;transition:transform .15s,box-shadow .15s;position:relative}
            .logan-card:hover{transform:scale(1.06);box-shadow:0 4px 12px rgba(0,0,0,.15);z-index:2}
            .logan-card .logan-rank{position:absolute;top:3px;left:6px;font-size:10px;font-weight:700;color:#aaa}
            .logan-card .logan-rank.top3{color:#ff6f00;font-size:11px}
            .logan-card-num{font-weight:800;font-size:20px;line-height:1.2}
            .logan-card-days{font-size:12px;margin-top:3px;font-weight:500}
            .logan-card-bar{width:80%;height:4px;border-radius:2px;margin-top:5px;background:#e0e0e0;overflow:hidden}
            .logan-card-bar-fill{height:100%;border-radius:2px;transition:width .3s}
            .logan-card.g0{background:linear-gradient(135deg,#880e4f,#4a148c);border-color:#4a148c}
            .logan-card.g0 .logan-card-num{color:#fff}.logan-card.g0 .logan-card-days{color:#f8bbd0}
            .logan-card.g0::after{content:"🔥";position:absolute;top:2px;right:4px;font-size:14px}
            .logan-card.g1{background:linear-gradient(135deg,#c62828,#d32f2f);border-color:#c62828}
            .logan-card.g1 .logan-card-num{color:#fff}.logan-card.g1 .logan-card-days{color:#ffcdd2}
            .logan-card.g2{background:#fbe9e7;border-color:#ef9a9a}.logan-card.g2 .logan-card-num{color:#c62828}.logan-card.g2 .logan-card-days{color:#d32f2f}
            .logan-card.g3{background:#fff3e0;border-color:#ffb74d}.logan-card.g3 .logan-card-num{color:#e65100}.logan-card.g3 .logan-card-days{color:#ef6c00}
            .logan-card.g4{background:#fff8e1;border-color:#ffe082}.logan-card.g4 .logan-card-num{color:#f57f17}.logan-card.g4 .logan-card-days{color:#f9a825}
            @media(max-width:600px){.logan-cards{grid-template-columns:repeat(4,1fr);gap:4px}.logan-card-num{font-size:17px}.logan-card{min-height:60px;padding:8px 2px}}
        </style>

        @if($type === 'dropdown' && !empty($provinces))
        <div style="text-align:center;margin:12px 0">
            <form method="get" style="display:inline-flex;align-items:center;gap:8px">
                <label style="font-weight:600;font-size:14px"><i class="fas fa-filter"></i> Chọn đài:</label>
                <select name="dai" class="sc-select" onchange="this.form.submit()" style="padding:6px 12px;border-radius:6px;border:1px solid #ccc;font-size:14px">
                    <option value="">Tất cả đài</option>
                    @foreach($provinces as $p)
                        <option value="{{ $p }}" {{ $dai === $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        @endif

        @php
            $maxGan = !empty($loGan) ? max($loGan) : 1;
            $rank = 0;
        @endphp

        <div class="logan-cards">
            @forelse($loGan as $num => $days)
            @php
                $rank++;
                $pct = $maxGan > 0 ? round($days / $maxGan * 100) : 0;
                if ($days >= 30) { $g = 'g0'; $barColor = '#880e4f'; }
                elseif ($days >= 20) { $g = 'g1'; $barColor = '#d32f2f'; }
                elseif ($days >= 15) { $g = 'g2'; $barColor = '#e53935'; }
                elseif ($days >= 10) { $g = 'g3'; $barColor = '#ff9800'; }
                else { $g = 'g4'; $barColor = '#fdd835'; }
            @endphp
            <div class="logan-card {{ $g }}" title="Hạng {{ $rank }}: Số {{ $num }} gan {{ $days }} ngày">
                <span class="logan-rank {{ $rank <= 3 ? 'top3' : '' }}">#{{ $rank }}</span>
                <span class="logan-card-num">{{ $num }}</span>
                <span class="logan-card-days">{{ $days }} ngày</span>
                <div class="logan-card-bar">
                    <div class="logan-card-bar-fill" style="width:{{ $pct }}%;background:{{ $barColor }}"></div>
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:20px;color:#999">
                <i class="fas fa-inbox" style="font-size:24px"></i>
                <p>Không có dữ liệu lô gan.</p>
            </div>
            @endforelse
        </div>

        <div class="sc-soicau-note" style="margin-top:12px">
            <i class="fas fa-info-circle"></i> <em>Top {{ count($loGan) }} lô gan lâu nhất {{ $region }}@if($dai) — Đài {{ $dai }}@endif. Màu càng đậm = gan càng lâu.</em>
        </div>
    </div>
</section>
