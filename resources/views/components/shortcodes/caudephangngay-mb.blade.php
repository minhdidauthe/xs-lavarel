<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-star"></i>
            Cầu Đẹp Hằng Ngày XSMB - {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>

        <div class="sc-cau-group">
            <div class="sc-cau-label"><i class="fas fa-circle-dot green"></i> Cầu Lô Đẹp Hôm Nay</div>
            <div class="sc-cau-items">
                @foreach($cauLoto as $pair)
                <div class="sc-cau-pair">
                    @foreach($pair as $n)
                    <span class="sc-btl-num">{{ $n }}</span>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>

        <div class="sc-cau-group">
            <div class="sc-cau-label"><i class="fas fa-gem red"></i> Cầu Kép Hôm Nay</div>
            <div class="sc-stl-wrap">
                @foreach($cauKep as $k)
                <span class="sc-btl-num red">{{ $k }}</span>
                @endforeach
            </div>
        </div>

        <div class="sc-cau-group">
            <div class="sc-cau-label"><i class="fas fa-calculator blue"></i> Tổng Đặc Biệt Đẹp</div>
            <div class="sc-stl-wrap">
                @foreach($cauTong as $t)
                <span class="sc-num-badge blue">Tổng {{ $t }}</span>
                @endforeach
            </div>
        </div>

        <div class="sc-soicau-note">
            <i class="fas fa-info-circle"></i> <em>Lưu ý: Con số chỉ dùng cho mục đích tham khảo. Chúc bạn may mắn!</em>
        </div>
    </div>
</section>
