<section class="container sc-section">
    <div class="sc-kqxs-box">
        <div class="sc-kqxs-header">
            <div>
                <i class="fas fa-trophy"></i>
                <strong>KQXS {{ $region === 'MB' ? 'Miền Bắc' : ($region === 'MN' ? 'Miền Nam' : 'Miền Trung') }}</strong>
            </div>
            <span>{{ $result->date->format('d/m/Y') }} &middot; {{ $result->province }}</span>
        </div>
        <table class="sc-kqxs-table compact">
            <tbody>
                @foreach(['special' => 'Giải ĐB', 'first' => 'Giải nhất', 'second' => 'Giải nhì', 'third' => 'Giải ba', 'fourth' => 'Giải tư', 'fifth' => 'Giải năm', 'sixth' => 'Giải sáu', 'seventh' => 'Giải bảy', 'eighth' => 'Giải tám'] as $key => $label)
                    @if(!empty($result->prizes[$key]))
                    <tr class="{{ $key === 'special' ? 'sc-row-db' : '' }}">
                        <td class="sc-prize-label">{{ $label }}</td>
                        <td class="sc-prize-value {{ $key === 'special' ? 'sc-db' : ($key === 'first' ? 'sc-g1' : ($key === 'seventh' ? 'sc-g7' : '')) }}">
                            @php $prizes = is_array($result->prizes[$key]) ? $result->prizes[$key] : [$result->prizes[$key]]; @endphp
                            @if(count($prizes) > 2)
                            <div class="sc-nums-grid {{ count($prizes) >= 6 ? 'g6' : (count($prizes) >= 4 ? 'g4' : 'g3') }}">
                                @foreach($prizes as $num)<span>{{ $num }}</span>@endforeach
                            </div>
                            @else
                                @foreach($prizes as $num){{ $num }}@if(!$loop->last)&nbsp;&nbsp;&nbsp;&nbsp;@endif @endforeach
                            @endif
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</section>
