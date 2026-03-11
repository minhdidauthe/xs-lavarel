<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-trophy"></i> Cao Thủ Mở Bát Hôm Nay — {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>

        <style>
            .ctmb-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;padding:12px}
            .ctmb-card{background:linear-gradient(135deg,#fff9c4,#fff3e0);border:1px solid #ffe082;border-radius:12px;padding:12px 8px;text-align:center;transition:transform .15s,box-shadow .15s}
            .ctmb-card:hover{transform:translateY(-3px);box-shadow:0 4px 14px rgba(255,152,0,.25)}
            .ctmb-rank{font-size:11px;color:#ff8f00;font-weight:700;margin-bottom:4px}
            .ctmb-num{font-size:24px;font-weight:800;color:#e65100;line-height:1.2}
            .ctmb-label{font-size:11px;color:#888;margin-top:4px}
            .ctmb-freq{font-size:10px;color:#bbb;margin-top:2px}
            .ctmb-card:nth-child(1){background:linear-gradient(135deg,#fff176,#ffb74d);border-color:#ffa726}
            .ctmb-card:nth-child(1) .ctmb-num{color:#bf360c;font-size:28px}
            .ctmb-card:nth-child(1)::before{content:"👑";display:block;font-size:16px}
            .ctmb-card:nth-child(2){background:linear-gradient(135deg,#ffe0b2,#ffcc80);border-color:#ffb74d}
            .ctmb-card:nth-child(2) .ctmb-num{font-size:26px}
            .ctmb-extra{display:flex;gap:4px;justify-content:center;margin-top:6px;flex-wrap:wrap}
            .ctmb-extra-tag{font-size:10px;background:#fff;border:1px solid #ddd;border-radius:4px;padding:1px 6px;color:#555}
            @media(max-width:600px){.ctmb-grid{grid-template-columns:repeat(2,1fr);gap:8px}.ctmb-num{font-size:20px}}
        </style>

        @if($type === '1')
        {{-- Type 1: Lô + Đề --}}
        <p style="text-align:center;color:#888;font-size:13px;margin:8px 0">Dự đoán Lô/Đề dựa trên tần suất thống kê</p>
        <div class="ctmb-grid">
            @forelse($caoThu as $item)
            <div class="ctmb-card">
                <div class="ctmb-rank">#{{ $loop->iteration }}</div>
                <div class="ctmb-num">{{ $item['lo'] }}</div>
                <div class="ctmb-label">Lô/Đề</div>
                <div class="ctmb-freq">{{ $item['freq'] }} lần/30 ngày</div>
            </div>
            @empty
            <div style="grid-column:1/-1" class="sc-no-data">Đang cập nhật...</div>
            @endforelse
        </div>
        @else
        {{-- Type 2: BTL/STL --}}
        <p style="text-align:center;color:#888;font-size:13px;margin:8px 0">Dự đoán BTL/STL kết hợp đầu đuôi ĐB</p>
        <div class="ctmb-grid">
            @forelse($caoThu as $item)
            <div class="ctmb-card">
                <div class="ctmb-rank">#{{ $loop->iteration }}</div>
                <div class="ctmb-num">{{ $item['lo'] }}</div>
                <div class="ctmb-extra">
                    <span class="ctmb-extra-tag">BTL: {{ $item['btl'] }}</span>
                    <span class="ctmb-extra-tag">STL: {{ $item['stl'] }}</span>
                </div>
                <div class="ctmb-freq">{{ $item['freq'] }} lần/30 ngày</div>
            </div>
            @empty
            <div style="grid-column:1/-1" class="sc-no-data">Đang cập nhật...</div>
            @endforelse
        </div>
        @endif

        <div class="sc-soicau-note"><i class="fas fa-info-circle"></i> Dự đoán theo thống kê tần suất. Chỉ mang tính tham khảo.</div>
    </div>
</section>
