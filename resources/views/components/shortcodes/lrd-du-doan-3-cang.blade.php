<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-dice-three"></i>
            Dự Đoán 3 Cang Hôm Nay - {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <div class="sc-table-wrap">
            <table class="sc-khung-table sc-lrd-table">
                <thead>
                    <tr>
                        <th class="sc-lrd-th-idx">#</th>
                        <th class="sc-lrd-th-num">Số 3 Cang</th>
                        <th class="sc-lrd-th-prob">Xác Suất</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($predictions as $i => $pred)
                    <tr>
                        <td class="sc-lrd-idx">{{ $i + 1 }}</td>
                        <td class="sc-lrd-num"><span class="sc-num-badge green">{{ $pred['number'] }}</span></td>
                        <td class="sc-lrd-prob">
                            <div class="sc-prob-bar"><div class="sc-prob-fill" style="width:{{ $pred['prob'] }}%"></div><span class="sc-prob-text">{{ $pred['prob'] }}%</span></div>
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
