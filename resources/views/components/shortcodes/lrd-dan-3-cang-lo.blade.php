<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-th"></i>
            Dàn 3 Cang Lô Hôm Nay - {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <p class="sc-btl-label">Dàn <strong class="green">{{ count($dan3Cang) }} số 3 cang</strong> theo phân tích hôm nay</p>
        <div class="sc-3cang-grid">
            @foreach($dan3Cang as $n)
            <span class="sc-3cang-badge">{{ $n }}</span>
            @endforeach
        </div>
        <div class="sc-soicau-note">
            <i class="fas fa-info-circle"></i> <em>Lưu ý: Con số chỉ dùng cho mục đích tham khảo. Chúc bạn may mắn!</em>
        </div>
    </div>
</section>
