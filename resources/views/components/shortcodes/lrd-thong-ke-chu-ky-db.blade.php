<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-sync-alt"></i> Chu Kỳ Giải Đặc Biệt {{ $region }}</h2>
    <table class="sc-table">
        <thead><tr><th>Số ĐB</th><th>Chu kỳ TB (ngày)</th><th>Nhận định</th></tr></thead>
        <tbody>
            @forelse($chuKy as $num => $avgDays)
            <tr>
                <td><span class="sc-badge sc-badge-hot">{{ $num }}</span></td>
                <td>~{{ round($avgDays) }} ngày/lần</td>
                <td>
                    @if($avgDays <= 30)
                        <span class="sc-kq-ve">Hay về</span>
                    @elseif($avgDays <= 60)
                        <span class="sc-kq-cho">Trung bình</span>
                    @else
                        <span class="sc-kq-khongve">Ít về</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="sc-no-data">Chưa có dữ liệu.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if(!empty($spNums))
    <div style="margin-top:12px">
        <strong>Giải ĐB gần đây:</strong>
        <div class="sc-nums">
            @foreach(array_slice($spNums, 0, 10) as $n)
                <span class="sc-badge sc-badge-hot">{{ $n }}</span>
            @endforeach
        </div>
    </div>
    @endif
</section>
