<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-th"></i> Nuôi Lô Kép Khung {{ $days }} Ngày — {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        @if(!empty($loKep))
        <div style="margin:12px 0; text-align:center">
            <strong>Lô kép nuôi hôm nay:</strong>
            <div class="sc-nums" style="justify-content:center; margin-top:8px">
                @foreach($loKep as $num)
                    <span class="sc-badge sc-badge-kep">{{ $num }}</span>
                @endforeach
            </div>
        </div>
        @endif
        <table class="sc-table">
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>Lô kép nuôi</th>
                    <th>Lô kép về trong ngày</th>
                    <th>Kết quả</th>
                </tr>
            </thead>
            <tbody>
                @forelse($khungData as $item)
                @php
                    $kepVe = [];
                    foreach ($item['nums'] as $n) {
                        if (strlen($n) == 2 && $n[0] === $n[1]) $kepVe[] = $n;
                    }
                @endphp
                <tr class="{{ $item['status'] === 've' ? 'sc-row-ve' : ($item['status'] === 'khong_ve' ? 'sc-row-khongve' : 'sc-row-cho') }}">
                    <td style="white-space:nowrap"><strong>{{ $item['date'] }}</strong></td>
                    <td>
                        <div class="sc-nums" style="flex-wrap:wrap; justify-content:center">
                            @foreach($item['soNuoi'] as $n)
                                <span class="sc-badge sc-badge-kep" style="font-size:12px">{{ $n }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        @if($item['status'] === 'cho')
                            <span style="color:#999">—</span>
                        @elseif(!empty($kepVe))
                            <div class="sc-nums" style="flex-wrap:wrap; justify-content:center">
                                @foreach($kepVe as $n)
                                    <span class="sc-badge sc-badge-hot" style="font-size:12px">{{ $n }}</span>
                                @endforeach
                            </div>
                        @else
                            <span style="color:#999">Không có kép</span>
                        @endif
                    </td>
                    <td>
                        @if($item['status'] === 've')
                            <span class="sc-kq-ve"><i class="fas fa-check-circle"></i> Về rồi ✓</span>
                        @elseif($item['status'] === 'khong_ve')
                            <span class="sc-kq-khongve"><i class="fas fa-times-circle"></i> Không về ✗</span>
                        @else
                            <span class="sc-kq-cho"><i class="fas fa-clock"></i> Đang chờ...</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="sc-no-data">Chưa có dữ liệu.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="sc-soicau-note">
            <i class="fas fa-info-circle"></i> <em>Lưu ý: Con số chỉ dùng cho mục đích tham khảo. Chúc bạn may mắn!</em>
        </div>
    </div>
</section>
