<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-layer-group"></i> Dàn Đề Hằng Ngày — {{ $count }} Số — {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <div style="padding:12px">
            <div class="sc-nums" style="flex-wrap:wrap; justify-content:center; gap:6px">
                @forelse($numbers as $n)
                    <span class="sc-badge sc-badge-hot" style="font-size:13px">{{ $n }}</span>
                @empty
                    <p class="sc-no-data">Đang cập nhật...</p>
                @endforelse
            </div>
        </div>
        <div class="sc-soicau-note"><i class="fas fa-info-circle"></i> Dàn {{ $count }} số dựa trên thống kê tần suất 30 ngày. Chỉ mang tính tham khảo.</div>
    </div>
</section>
