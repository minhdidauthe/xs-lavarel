<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-border-all"></i>
            Dàn Đề 3 Cang 50 Số Hôm Nay - {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <p class="sc-btl-label">Dàn đề 3 cang gồm <strong class="green">{{ count($danDe) }} số</strong> hôm nay</p>
        <div class="sc-3cang-grid">
            @foreach($danDe as $n)
            <span class="sc-3cang-badge">{{ $n }}</span>
            @endforeach
        </div>
        <div class="sc-soicau-note">
            <i class="fas fa-info-circle"></i> <em>Lưu ý: Con số chỉ dùng cho mục đích tham khảo. Chúc bạn may mắn!</em>
        </div>
    </div>
</section>
