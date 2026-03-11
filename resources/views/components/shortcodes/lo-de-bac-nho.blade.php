<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-medal"></i> {{ $type === '2' ? 'Đề' : 'Lô' }} Bạc Nhớ — Ít Về Nhất {{ $days }} Ngày {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <p style="color:#aaa; font-size:13px; text-align:center; padding:8px 10px">Những số lâu ngày chưa xuất hiện — cơ hội quay lại?</p>
        <div class="sc-nums" style="justify-content:center; flex-wrap:wrap; padding:6px 14px 14px; gap:8px">
            @forelse($bacNho as $num => $count)
                <span class="sc-badge sc-badge-cold" title="{{ $count }} lần trong {{ $days }} ngày">{{ $num }}</span>
            @empty
                <p class="sc-no-data">Đang cập nhật...</p>
            @endforelse
        </div>
        <div class="sc-soicau-note"><i class="fas fa-info-circle"></i> Chỉ mang tính tham khảo.</div>
    </div>
</section>
