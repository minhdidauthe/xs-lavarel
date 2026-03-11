<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-table"></i> Bảng Lô Gan Đầy Đủ {{ $reg }} (00–99) — {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>

        <style>
            .logan-grid{display:grid;grid-template-columns:repeat(10,1fr);gap:4px;padding:8px}
            .logan-cell{position:relative;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:6px 2px;border-radius:6px;border:1px solid #e0e0e0;background:#f8f9fa;min-height:52px;transition:transform .15s,box-shadow .15s}
            .logan-cell:hover{transform:scale(1.08);box-shadow:0 2px 8px rgba(0,0,0,.15);z-index:2}
            .logan-num{font-weight:700;font-size:15px;line-height:1.2}
            .logan-days{font-size:11px;color:#666;margin-top:2px}
            .logan-cell.lv0{background:#e8f5e9;border-color:#a5d6a7}.logan-cell.lv0 .logan-num{color:#2e7d32}
            .logan-cell.lv1{background:#fff8e1;border-color:#ffe082}.logan-cell.lv1 .logan-num{color:#f57f17}
            .logan-cell.lv2{background:#fff3e0;border-color:#ffb74d}.logan-cell.lv2 .logan-num{color:#e65100}
            .logan-cell.lv3{background:#fbe9e7;border-color:#ef9a9a}.logan-cell.lv3 .logan-num{color:#c62828}
            .logan-cell.lv4{background:linear-gradient(135deg,#d32f2f,#b71c1c);border-color:#b71c1c}.logan-cell.lv4 .logan-num{color:#fff}.logan-cell.lv4 .logan-days{color:#ffcdd2}
            .logan-cell.lv5{background:linear-gradient(135deg,#880e4f,#4a148c);border-color:#4a148c}.logan-cell.lv5 .logan-num{color:#fff;font-size:16px}.logan-cell.lv5 .logan-days{color:#f8bbd0}
            .logan-cell.lv5::after{content:"🔥";position:absolute;top:-4px;right:-2px;font-size:12px}
            .logan-legend{display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin:12px 0;font-size:12px}
            .logan-legend-item{display:flex;align-items:center;gap:4px}
            .logan-legend-dot{width:14px;height:14px;border-radius:3px;border:1px solid #ccc}
            .logan-header-row{display:grid;grid-template-columns:repeat(10,1fr);gap:4px;padding:0 8px;margin-bottom:2px}
            .logan-header-cell{text-align:center;font-size:11px;font-weight:600;color:#888}
            @media(max-width:600px){
                .logan-grid{grid-template-columns:repeat(5,1fr);gap:3px}
                .logan-header-row{grid-template-columns:repeat(5,1fr)}
                .logan-num{font-size:13px}
                .logan-cell{min-height:44px;padding:4px 2px}
            }
        </style>

        {{-- Summary --}}
        @php
            $sorted = $loGanAll;
            arsort($sorted);
            $top10 = array_slice($sorted, 0, 10, true);
            $totalGan15 = count(array_filter($loGanAll, fn($d) => $d >= 15));
        @endphp
        <div style="display:flex;flex-wrap:wrap;gap:12px;justify-content:center;margin:12px 0">
            <div style="background:#fff3e0;border:1px solid #ffb74d;border-radius:8px;padding:8px 16px;text-align:center">
                <div style="font-size:12px;color:#e65100">Tổng số gan ≥15 ngày</div>
                <div style="font-size:22px;font-weight:700;color:#e65100">{{ $totalGan15 }}</div>
            </div>
            <div style="background:#fbe9e7;border:1px solid #ef9a9a;border-radius:8px;padding:8px 16px;text-align:center">
                <div style="font-size:12px;color:#c62828">Top gan lâu nhất</div>
                <div style="display:flex;gap:4px;margin-top:4px;flex-wrap:wrap;justify-content:center">
                    @foreach(array_slice($top10, 0, 5, true) as $n => $d)
                        <span class="sc-badge sc-badge-cold" style="font-size:12px">{{ $n }} ({{ $d }}n)</span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Legend --}}
        <div class="logan-legend">
            <div class="logan-legend-item"><div class="logan-legend-dot" style="background:#e8f5e9"></div> 0–4 ngày</div>
            <div class="logan-legend-item"><div class="logan-legend-dot" style="background:#fff8e1"></div> 5–9 ngày</div>
            <div class="logan-legend-item"><div class="logan-legend-dot" style="background:#fff3e0"></div> 10–14 ngày</div>
            <div class="logan-legend-item"><div class="logan-legend-dot" style="background:#fbe9e7"></div> 15–24 ngày</div>
            <div class="logan-legend-item"><div class="logan-legend-dot" style="background:#d32f2f"></div> 25–39 ngày</div>
            <div class="logan-legend-item"><div class="logan-legend-dot" style="background:linear-gradient(135deg,#880e4f,#4a148c)"></div> 40+ ngày</div>
        </div>

        {{-- Grid 10 columns: 00-09, 10-19, ..., 90-99 --}}
        <div class="logan-header-row">
            @for($c = 0; $c <= 9; $c++)
                <div class="logan-header-cell">x{{ $c }}</div>
            @endfor
        </div>
        <div class="logan-grid">
            @for($i = 0; $i <= 99; $i++)
                @php
                    $num = str_pad((string)$i, 2, '0', STR_PAD_LEFT);
                    $d = $loGanAll[$num] ?? 0;
                    if ($d >= 40) $lv = 'lv5';
                    elseif ($d >= 25) $lv = 'lv4';
                    elseif ($d >= 15) $lv = 'lv3';
                    elseif ($d >= 10) $lv = 'lv2';
                    elseif ($d >= 5) $lv = 'lv1';
                    else $lv = 'lv0';
                @endphp
                <div class="logan-cell {{ $lv }}" title="Số {{ $num }}: gan {{ $d }} ngày">
                    <span class="logan-num">{{ $num }}</span>
                    <span class="logan-days">{{ $d }}n</span>
                </div>
            @endfor
        </div>

        <div class="sc-soicau-note" style="margin-top:12px">
            <i class="fas fa-info-circle"></i> <em>Bảng lô gan đầy đủ 100 số ({{ $reg }}). Màu càng đậm = gan càng lâu. Hover/chạm để xem chi tiết.</em>
        </div>
    </div>
</section>
