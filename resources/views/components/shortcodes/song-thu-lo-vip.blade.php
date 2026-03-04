<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-star"></i> Song Thủ Lô Hôm Nay {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        @if(count(array_filter($pairs, fn($p) => $p['so'])) > 0)
        <div class="sc-stl-wrap">
            @foreach($pairs as $i => $p)
            @if($p['so'])
            <div class="sc-stl-pair">
                <span class="sc-stl-num green">{{ $p['so'] }}</span>
                @if($p['dao'])
                <span class="sc-stl-arrow"><i class="fas fa-arrows-left-right"></i></span>
                <span class="sc-stl-num blue">{{ $p['dao'] }}</span>
                @endif
            </div>
            @if(!$loop->last && $loop->index < count($pairs) - 1)<span class="sc-stl-sep">—</span>@endif
            @endif
            @endforeach
        </div>
        <div class="sc-stl-desc">
            <i class="fas fa-circle-info"></i>
            Mỗi cặp gồm số và số đảo (ví dụ: 27 ↔ 72). Chơi cả cặp để tối ưu xác suất.
        </div>
        @else
        <p class="sc-no-data"><i class="fas fa-clock"></i> Đang cập nhật dữ liệu, vui lòng quay lại sau.</p>
        @endif
        <div class="sc-soicau-note">
            <i class="fas fa-info-circle"></i> <em>Lưu ý: Con số chỉ dùng cho mục đích tham khảo. Chúc bạn may mắn!</em>
        </div>
    </div>
</section>
