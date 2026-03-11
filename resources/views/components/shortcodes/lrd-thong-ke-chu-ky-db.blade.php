<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-sync-alt"></i> Chu Kỳ Giải Đặc Biệt {{ $region }} — 60 Ngày Gần Nhất
        </div>

        @if(!empty($spNums))
        <div style="margin:12px 0">
            <strong>Giải ĐB gần đây:</strong>
            <div class="sc-nums" style="flex-wrap:wrap; margin-top:8px">
                @foreach(array_slice($spNums, 0, 15) as $n)
                    <span class="sc-badge sc-badge-hot" style="font-size:12px" title="{{ $n['full'] }}">{{ $n['so'] }} <small>({{ $n['date'] }})</small></span>
                @endforeach
            </div>
        </div>
        @endif

        <table class="sc-table">
            <thead>
                <tr>
                    <th>Số ĐB (2 số cuối)</th>
                    <th>Số lần lặp</th>
                    <th>Chu kỳ TB</th>
                    <th>Nhận định</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sorted = collect($chuKy)->map(function($gaps, $num) {
                        $avg = count($gaps) > 0 ? array_sum($gaps) / count($gaps) : 0;
                        return ['num' => $num, 'gaps' => $gaps, 'avg' => $avg, 'count' => count($gaps)];
                    })->sortBy('avg')->values();
                @endphp
                @forelse($sorted as $item)
                <tr>
                    <td><span class="sc-badge sc-badge-hot" style="font-size:14px">{{ $item['num'] }}</span></td>
                    <td><strong>{{ $item['count'] + 1 }}</strong> lần về</td>
                    <td>~<strong>{{ round($item['avg'], 1) }}</strong> ngày/lần</td>
                    <td>
                        @if($item['avg'] <= 10)
                            <span class="sc-kq-ve"><i class="fas fa-fire"></i> Rất hay về</span>
                        @elseif($item['avg'] <= 20)
                            <span class="sc-kq-ve">Hay về</span>
                        @elseif($item['avg'] <= 40)
                            <span class="sc-kq-cho">Trung bình</span>
                        @else
                            <span class="sc-kq-khongve">Ít về</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="sc-no-data">Chưa có dữ liệu chu kỳ.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="sc-soicau-note">
            <i class="fas fa-info-circle"></i> <em>Chu kỳ tính dựa trên khoảng cách giữa các lần 2 số cuối giải ĐB lặp lại trong 60 ngày qua.</em>
        </div>
    </div>
</section>
