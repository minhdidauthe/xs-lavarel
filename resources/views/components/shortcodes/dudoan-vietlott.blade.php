<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-magic"></i> {{ $title ?? 'Dự Đoán Vietlott' }} — {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <p style="color:#aaa; text-align:center; font-size:13px; margin:8px 0">Bộ số may mắn theo thống kê tần suất</p>

        <style>
            .vl-set{display:flex;align-items:center;gap:8px;justify-content:center;padding:10px;margin:6px 12px;background:#f8f9fa;border-radius:10px;border:1px solid #e0e0e0}
            .vl-set:nth-child(odd){background:#fff8e1}
            .vl-set-idx{font-weight:700;color:#888;font-size:12px;min-width:24px}
            .vl-ball{display:inline-flex;align-items:center;justify-content:center;width:38px;height:38px;border-radius:50%;font-weight:700;font-size:15px;color:#fff;background:linear-gradient(135deg,#e53935,#c62828)}
            .vl-ball-extra{background:linear-gradient(135deg,#ff9800,#f57c00)}
            .vl-plus{color:#ccc;font-size:14px}
        </style>

        @forelse($predictions as $set)
        <div class="vl-set">
            <span class="vl-set-idx">Bộ {{ $loop->iteration }}</span>
            @foreach($set['main'] as $num)
                <span class="vl-ball">{{ str_pad($num, 2, '0', STR_PAD_LEFT) }}</span>
            @endforeach
            @if(!empty($set['extra']))
                <span class="vl-plus">+</span>
                <span class="vl-ball vl-ball-extra">{{ str_pad($set['extra'], 2, '0', STR_PAD_LEFT) }}</span>
            @endif
        </div>
        @empty
        <p class="sc-no-data" style="text-align:center;padding:20px">Đang cập nhật...</p>
        @endforelse

        <div class="sc-soicau-note" style="margin-top:12px"><i class="fas fa-info-circle"></i> Chỉ mang tính tham khảo giải trí. Không phải lời khuyên mua vé.</div>
    </div>
</section>
