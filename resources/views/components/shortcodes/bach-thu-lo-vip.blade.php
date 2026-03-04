<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-crown"></i> Bạch Thủ Lô Hôm Nay {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        @if($bachThu)
        <div class="sc-btl-highlight">
            <div class="sc-btl-num-wrap">
                <span class="sc-btl-num green">{{ $bachThu }}</span>
                @if($mirror && $mirror !== $bachThu)
                <span class="sc-btl-mirror">
                    <i class="fas fa-arrows-left-right"></i>
                    <span class="sc-btl-num blue">{{ $mirror }}</span>
                </span>
                @endif
            </div>
            <p class="sc-btl-label">Con số may mắn Bạch Thủ Lô hôm nay</p>
        </div>
        @else
        <p class="sc-no-data"><i class="fas fa-clock"></i> Đang cập nhật dữ liệu, vui lòng quay lại sau.</p>
        @endif
        <div class="sc-soicau-note">
            <i class="fas fa-info-circle"></i> <em>Lưu ý: Con số chỉ dùng cho mục đích tham khảo. Chúc bạn may mắn!</em>
        </div>
    </div>
</section>
