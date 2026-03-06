<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-clock"></i> Đuôi Giải ĐB Gan Lâu Chưa Về {{ $region }}</h2>
    <table class="sc-table">
        <thead><tr><th>Đuôi ĐB</th><th>Gan (ngày)</th><th>Trạng thái</th></tr></thead>
        <tbody>
            @forelse($dbGan as $num => $days)
            <tr>
                <td><span class="sc-badge {{ $days >= 20 ? 'sc-badge-hot' : 'sc-badge-cold' }}">{{ $num }}</span></td>
                <td>{{ $days }} ngày</td>
                <td>
                    @if($days >= 30) <span class="sc-kq-ve">Rất gan</span>
                    @elseif($days >= 15) <span class="sc-kq-cho">Đang gan</span>
                    @else <span class="sc-kq-khongve">Bình thường</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="sc-no-data">Chưa có dữ liệu.</td></tr>
            @endforelse
        </tbody>
    </table>
</section>
