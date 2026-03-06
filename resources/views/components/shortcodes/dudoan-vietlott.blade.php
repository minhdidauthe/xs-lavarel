<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-magic"></i> Dự Đoán Vietlott Hôm Nay {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <p style="color:#aaa; text-align:center; font-size:13px; margin:8px 0">Bộ số may mắn theo thống kê tần suất</p>
        <div class="sc-nums" style="justify-content:center; margin:16px 0">
            @forelse($predictions as $num)
                <span class="sc-badge sc-badge-hot" style="font-size:1.1rem; width:40px; height:40px; line-height:40px">{{ str_pad($num, 2, '0', STR_PAD_LEFT) }}</span>
            @empty
                <p class="sc-no-data">Đang cập nhật...</p>
            @endforelse
        </div>
        <div class="sc-soicau-note"><i class="fas fa-info-circle"></i> Chỉ mang tính tham khảo giải trí. Không phải lời khuyên mua vé.</div>
    </div>
</section>
