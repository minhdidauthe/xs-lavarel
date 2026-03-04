<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-list-ol"></i>
            Dàn Lô 6 Số Hôm Nay - {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <div class="sc-table-wrap sc-table-responsive">
            <table class="sc-khung-table sc-lrd-table">
                <thead>
                    <tr>
                        <th class="sc-lrd-th-date">Ngày</th>
                        <th class="sc-lrd-th-nums">6 Số Dàn</th>
                        <th>Kết Quả</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $row)
                    <tr class="{{ $row['hits'] > 0 ? 'sc-row-ve' : 'sc-row-khongve' }}">
                        <td class="sc-khung-td-date"><strong>{{ $row['date'] }}</strong></td>
                        <td class="sc-lrd-td-nums">
                            @foreach($danLo as $n)
                            <span class="sc-kep-badge {{ in_array($n, $row['ve']) ? 'active' : '' }}">{{ $n }}</span>
                            @endforeach
                        </td>
                        <td>
                            @if($row['hits'] > 0)
                                <span class="sc-kq-ve"><i class="fas fa-check-circle"></i> Trúng {{ $row['hits'] }} số</span>
                            @else
                                <span class="sc-kq-khongve"><i class="fas fa-xmark-circle"></i> Không về</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="sc-no-data">Chưa có dữ liệu</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="sc-soicau-note">
            <i class="fas fa-info-circle"></i> <em>Lưu ý: Con số chỉ dùng cho mục đích tham khảo. Chúc bạn may mắn!</em>
        </div>
    </div>
</section>
