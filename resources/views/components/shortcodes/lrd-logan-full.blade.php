<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-table"></i> Bảng Lô Gan Đầy Đủ {{ $reg }} (00–99)</h2>
    <div class="sc-logan-full-grid">
        @foreach($loGanAll as $num => $days)
        <div class="sc-logan-cell {{ $days >= 15 ? 'very-hot' : ($days >= 7 ? 'hot' : '') }}">
            <span class="sc-num">{{ $num }}</span>
            <span class="sc-days">{{ $days }}n</span>
        </div>
        @endforeach
    </div>
    <p class="sc-note"><i class="fas fa-info-circle"></i> Màu đỏ: gan ≥15 ngày | Màu cam: gan ≥7 ngày</p>
</section>
