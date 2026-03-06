<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-crown"></i> Đọc Thủ Đề Kép VIP Hôm Nay {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <p style="color:#aaa; text-align:center; font-size:13px; margin:8px 0">Dự đoán số kép sẽ xuất hiện trong giải đặc biệt hôm nay</p>
        <div class="sc-btl-highlight">
            <div class="sc-nums" style="justify-content:center">
                @forelse($docDeKep as $num)
                    <span class="sc-badge sc-badge-kep" style="font-size:1.3rem; width:44px; height:44px; line-height:44px">{{ $num }}</span>
                @empty
                    <p class="sc-no-data">Đang cập nhật...</p>
                @endforelse
            </div>
        </div>
        <div class="sc-soicau-note"><i class="fas fa-info-circle"></i> Chỉ mang tính tham khảo.</div>
    </div>
</section>
