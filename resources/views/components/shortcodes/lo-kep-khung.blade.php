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
                    <th>Lô kép về</th>
                    <th>Kết quả</th>
                </tr>
            </thead>
            <tbody>
                @forelse($khungData as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item['date'])->format('d/m') }}</td>
                    <td>
                        <div class="sc-nums" style="flex-wrap:wrap">
                            @foreach($item['numbers'] as $n)
                                <span class="sc-badge sc-badge-kep" style="font-size:11px">{{ $n }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        @if($item['hit'])
                            <span class="sc-kq-ve">✓ Về</span>
                        @else
                            <span class="sc-kq-khongve">✗ Không về</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="sc-no-data">Chưa có dữ liệu.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
