<section class="container sc-section">
    <div class="sc-soicau-box" style="padding:0;overflow:hidden">
        <div class="sc-soicau-header" style="background:linear-gradient(135deg,#C30000,#FF3D3D);color:#fff;text-transform:uppercase;letter-spacing:.8px">
            <i class="fas fa-redo-alt"></i> Quay Thử Xổ Số {{ $region }} {{ $province ? "— $province" : '' }} — Hôm Nay
        </div>

        <style>
            .qt-sc .qt-btn{background:linear-gradient(135deg,#C30000,#FF3D3D);color:#fff;border:none;padding:10px 36px;font-size:14px;font-weight:800;border-radius:999px;cursor:pointer;text-transform:uppercase;letter-spacing:.8px;transition:all .2s;box-shadow:0 4px 20px rgba(255,61,61,.35)}
            .qt-sc .qt-btn:hover:not(:disabled){transform:translateY(-1px);box-shadow:0 6px 28px rgba(255,61,61,.5)}
            .qt-sc .qt-btn:disabled{background:#ccc;color:#888;box-shadow:none;cursor:not-allowed}
            .qt-sc .qt-table{width:100%;border-collapse:collapse;font-size:13px;margin-top:8px}
            .qt-sc .qt-table td{border:1px solid #e8e8e8;padding:8px 10px;vertical-align:middle;text-align:center}
            .qt-sc .qt-prize{background:#f5f5f5;font-weight:700;color:#888;width:48px;font-size:12px}
            .qt-sc .qt-row-alt{background:#fafafa}
            .qt-sc .qt-num{font-weight:800;font-size:18px;color:#333;letter-spacing:1.5px;display:inline-block}
            .qt-sc .qt-db .qt-num{font-size:26px;color:#c62828}
            .qt-sc .qt-spinner{display:inline-block;width:18px;height:18px;border:2.5px solid #ddd;border-top-color:#c62828;border-radius:50%;animation:qtspin .7s linear infinite}
            @keyframes qtspin{to{transform:rotate(360deg)}}
            @keyframes qtroll{0%{opacity:0;transform:translateY(-6px)}100%{opacity:1;transform:translateY(0)}}
            .qt-sc .qt-revealed{animation:qtroll .2s ease-out}
            .qt-sc .qt-views{display:flex;gap:16px;align-items:center;flex-wrap:wrap;padding:8px 14px;font-size:13px;color:#666}
            .qt-sc .qt-views label{cursor:pointer;display:flex;align-items:center;gap:4px}
            .qt-sc .qt-views input[type=radio]{accent-color:#c62828}
            .qt-sc .qt-loto-head{display:flex}
            .qt-sc .qt-loto-head div{flex:1;background:#fffde7;border:1px solid #e8e8e8;padding:6px;font-size:12px;text-align:center;font-weight:700;color:#888}
            .qt-sc .qt-loto-title{background:#fff8e1;text-align:center;font-weight:700;color:#888;padding:6px;border:1px solid #e8e8e8;font-size:12px}
            .qt-sc .qt-loto-table{width:100%;border-collapse:collapse}
            .qt-sc .qt-loto-table td{border:1px solid #e8e8e8;padding:5px 8px;font-size:12px;text-align:center;vertical-align:top}
            .qt-sc .qt-loto-pfx{font-weight:700;background:#f5f5f5;color:#888;width:28px}
            .qt-sc .qt-loto-nums{text-align:left;color:#333;font-weight:600}
            .qt-sc .qt-loto-nums span{display:inline-block;margin:1px 3px}
            .qt-sc .qt-rtab{display:inline-block;border:1px solid #ddd;background:#f5f5f5;padding:4px 14px;font-size:12px;border-radius:20px;cursor:pointer;color:#888;text-decoration:none;transition:all .15s;margin:2px}
            .qt-sc .qt-rtab:hover{border-color:#c62828;color:#c62828}
            .qt-sc .qt-rtab.active{background:linear-gradient(135deg,#C30000,#FF3D3D);color:#fff;border-color:transparent}
        </style>

        <div class="qt-sc">
            <div style="text-align:center;padding:14px">
                <button class="qt-btn" id="qtBtnSc" onclick="qtStartSc()">Bắt Đầu Quay</button>
                <div style="margin-top:8px">
                    <a href="/quay-thu" class="qt-rtab {{ $region === 'MB' ? 'active' : '' }}">Miền Bắc</a>
                    <a href="/quay-thu/mn" class="qt-rtab {{ $region === 'MN' ? 'active' : '' }}">Miền Nam</a>
                    <a href="/quay-thu/mt" class="qt-rtab {{ $region === 'MT' ? 'active' : '' }}">Miền Trung</a>
                </div>
            </div>

            <div style="overflow-x:auto">
                <table class="qt-table" id="qtTableSc">
                    <tbody>
                    @if($region === 'MB')
                        <tr><td class="qt-prize">ĐB</td><td class="qt-db" colspan="6"><span class="qt-cell" data-p="db"><span class="qt-spinner"></span></span></td></tr>
                        <tr class="qt-row-alt"><td class="qt-prize">G1</td><td colspan="6"><span class="qt-cell" data-p="g1"><span class="qt-spinner"></span></span></td></tr>
                        <tr><td class="qt-prize">G2</td><td colspan="3"><span class="qt-cell" data-p="g2a"><span class="qt-spinner"></span></span></td><td colspan="3"><span class="qt-cell" data-p="g2b"><span class="qt-spinner"></span></span></td></tr>
                        <tr class="qt-row-alt"><td class="qt-prize" rowspan="2">G3</td><td><span class="qt-cell" data-p="g3a"><span class="qt-spinner"></span></span></td><td><span class="qt-cell" data-p="g3b"><span class="qt-spinner"></span></span></td><td><span class="qt-cell" data-p="g3c"><span class="qt-spinner"></span></span></td><td><span class="qt-cell" data-p="g3d"><span class="qt-spinner"></span></span></td><td><span class="qt-cell" data-p="g3e"><span class="qt-spinner"></span></span></td><td><span class="qt-cell" data-p="g3f"><span class="qt-spinner"></span></span></td></tr>
                        <tr class="qt-row-alt"></tr>
                        <tr><td class="qt-prize">G4</td><td><span class="qt-cell" data-p="g4a"><span class="qt-spinner"></span></span></td><td><span class="qt-cell" data-p="g4b"><span class="qt-spinner"></span></span></td><td><span class="qt-cell" data-p="g4c"><span class="qt-spinner"></span></span></td><td colspan="3"><span class="qt-cell" data-p="g4d"><span class="qt-spinner"></span></span></td></tr>
                        <tr class="qt-row-alt"><td class="qt-prize" rowspan="2">G5</td><td><span class="qt-cell" data-p="g5a"><span class="qt-spinner"></span></span></td><td><span class="qt-cell" data-p="g5b"><span class="qt-spinner"></span></span></td><td><span class="qt-cell" data-p="g5c"><span class="qt-spinner"></span></span></td><td><span class="qt-cell" data-p="g5d"><span class="qt-spinner"></span></span></td><td><span class="qt-cell" data-p="g5e"><span class="qt-spinner"></span></span></td><td><span class="qt-cell" data-p="g5f"><span class="qt-spinner"></span></span></td></tr>
                        <tr class="qt-row-alt"></tr>
                        <tr><td class="qt-prize">G6</td><td colspan="2"><span class="qt-cell" data-p="g6a"><span class="qt-spinner"></span></span></td><td colspan="2"><span class="qt-cell" data-p="g6b"><span class="qt-spinner"></span></span></td><td colspan="2"><span class="qt-cell" data-p="g6c"><span class="qt-spinner"></span></span></td></tr>
                        <tr class="qt-row-alt"><td class="qt-prize">G7</td><td><span class="qt-cell" data-p="g7a"><span class="qt-spinner"></span></span></td><td><span class="qt-cell" data-p="g7b"><span class="qt-spinner"></span></span></td><td><span class="qt-cell" data-p="g7c"><span class="qt-spinner"></span></span></td><td colspan="3"><span class="qt-cell" data-p="g7d"><span class="qt-spinner"></span></span></td></tr>
                    @else
                        <tr><td class="qt-prize">ĐB</td><td class="qt-db" colspan="6"><span class="qt-cell" data-p="db"><span class="qt-spinner"></span></span></td></tr>
                        <tr class="qt-row-alt"><td class="qt-prize">G1</td><td colspan="6"><span class="qt-cell" data-p="g1"><span class="qt-spinner"></span></span></td></tr>
                        <tr><td class="qt-prize">G2</td><td colspan="6"><span class="qt-cell" data-p="g2"><span class="qt-spinner"></span></span></td></tr>
                        <tr class="qt-row-alt"><td class="qt-prize">G3</td><td colspan="3"><span class="qt-cell" data-p="g3a"><span class="qt-spinner"></span></span></td><td colspan="3"><span class="qt-cell" data-p="g3b"><span class="qt-spinner"></span></span></td></tr>
                        <tr><td class="qt-prize" rowspan="3">G4</td><td colspan="2"><span class="qt-cell" data-p="g4a"><span class="qt-spinner"></span></span></td><td colspan="2"><span class="qt-cell" data-p="g4b"><span class="qt-spinner"></span></span></td><td colspan="2"><span class="qt-cell" data-p="g4c"><span class="qt-spinner"></span></span></td></tr>
                        <tr><td colspan="2"><span class="qt-cell" data-p="g4d"><span class="qt-spinner"></span></span></td><td colspan="2"><span class="qt-cell" data-p="g4e"><span class="qt-spinner"></span></span></td><td colspan="2"><span class="qt-cell" data-p="g4f"><span class="qt-spinner"></span></span></td></tr>
                        <tr><td colspan="6"><span class="qt-cell" data-p="g4g"><span class="qt-spinner"></span></span></td></tr>
                        <tr class="qt-row-alt"><td class="qt-prize">G5</td><td colspan="6"><span class="qt-cell" data-p="g5"><span class="qt-spinner"></span></span></td></tr>
                        <tr><td class="qt-prize">G6</td><td colspan="2"><span class="qt-cell" data-p="g6a"><span class="qt-spinner"></span></span></td><td colspan="2"><span class="qt-cell" data-p="g6b"><span class="qt-spinner"></span></span></td><td colspan="2"><span class="qt-cell" data-p="g6c"><span class="qt-spinner"></span></span></td></tr>
                        <tr class="qt-row-alt"><td class="qt-prize">G7</td><td colspan="6"><span class="qt-cell" data-p="g7"><span class="qt-spinner"></span></span></td></tr>
                        <tr><td class="qt-prize">G8</td><td colspan="6"><span class="qt-cell" data-p="g8"><span class="qt-spinner"></span></span></td></tr>
                    @endif
                    </tbody>
                </table>
            </div>

            <div class="qt-views">
                <label><input type="radio" name="qtViewSc" value="full" checked onchange="qtViewSc(this.value)"> Đầy đủ</label>
                <label><input type="radio" name="qtViewSc" value="2" onchange="qtViewSc(this.value)"> 2 số</label>
                <label><input type="radio" name="qtViewSc" value="3" onchange="qtViewSc(this.value)"> 3 số</label>
            </div>

            <div>
                <div class="qt-loto-head">
                    @for($i = 0; $i <= 9; $i++)<div>{{ $i }}</div>@endfor
                </div>
                <div class="qt-loto-title">Lô tô</div>
                <table class="qt-loto-table"><tbody id="qtLotoBodySc"></tbody></table>
            </div>
        </div>

        <div class="sc-soicau-note" style="margin:8px 14px 14px"><i class="fas fa-info-circle"></i> <em>Kết quả quay thử ngẫu nhiên, chỉ mang tính giải trí.</em></div>
    </div>
</section>

<script>
(function(){
    var region = @json($region);
    var PRIZES_SC = region === 'MB' ? [
        {p:'g7a',d:2},{p:'g7b',d:2},{p:'g7c',d:2},{p:'g7d',d:2},
        {p:'g6a',d:3},{p:'g6b',d:3},{p:'g6c',d:3},
        {p:'g5a',d:4},{p:'g5b',d:4},{p:'g5c',d:4},{p:'g5d',d:4},{p:'g5e',d:4},{p:'g5f',d:4},
        {p:'g4a',d:4},{p:'g4b',d:4},{p:'g4c',d:4},{p:'g4d',d:4},
        {p:'g3a',d:5},{p:'g3b',d:5},{p:'g3c',d:5},{p:'g3d',d:5},{p:'g3e',d:5},{p:'g3f',d:5},
        {p:'g2a',d:5},{p:'g2b',d:5},
        {p:'g1',d:5},{p:'db',d:5}
    ] : [
        {p:'g8',d:2},{p:'g7',d:3},
        {p:'g6a',d:4},{p:'g6b',d:4},{p:'g6c',d:4},
        {p:'g5',d:4},
        {p:'g4a',d:5},{p:'g4b',d:5},{p:'g4c',d:5},{p:'g4d',d:5},{p:'g4e',d:5},{p:'g4f',d:5},{p:'g4g',d:5},
        {p:'g3a',d:5},{p:'g3b',d:5},
        {p:'g2',d:5},{p:'g1',d:5},{p:'db',d:6}
    ];

    var resSc={}, viewMode='full', spinning=false, timers=[];

    function rnd(d){return String(Math.floor(Math.random()*Math.pow(10,d))).padStart(d,'0');}
    function disp(v){if(!v)return'';return viewMode==='2'?v.slice(-2):viewMode==='3'?v.slice(-3):v;}

    window.qtStartSc = function(){
        if(spinning) return;
        timers.forEach(clearTimeout); timers=[];
        document.querySelectorAll('#qtTableSc .qt-cell').forEach(function(el){el.innerHTML='<span class="qt-spinner"></span>';el.dataset.v='';});
        resSc={}; document.getElementById('qtLotoBodySc').innerHTML='';
        spinning=true;
        var btn=document.getElementById('qtBtnSc');
        btn.textContent='ĐANG QUAY...'; btn.disabled=true;
        PRIZES_SC.forEach(function(pr,i){
            timers.push(setTimeout(function(){
                var v=rnd(pr.d); resSc[pr.p]=v;
                var el=document.querySelector('#qtTableSc .qt-cell[data-p="'+pr.p+'"]');
                if(el){el.dataset.v=v;el.innerHTML='<span class="qt-num qt-revealed">'+disp(v)+'</span>';}
                buildLoto();
                if(i===PRIZES_SC.length-1){spinning=false;btn.textContent='QUAY LẠI';btn.disabled=false;}
            },(i+1)*220));
        });
    };

    window.qtViewSc = function(mode){
        viewMode=mode;
        document.querySelectorAll('#qtTableSc .qt-cell').forEach(function(el){
            var v=el.dataset.v;if(v){var n=el.querySelector('.qt-num');if(n)n.textContent=disp(v);}
        });
        buildLoto();
    };

    function buildLoto(){
        var tbody=document.getElementById('qtLotoBodySc');
        if(!Object.keys(resSc).length){tbody.innerHTML='';return;}
        var g={}; for(var i=0;i<=9;i++)g[i]=[];
        var vals=Object.keys(resSc).map(function(k){return resSc[k];});
        vals.map(function(v){return v.slice(-2);}).forEach(function(t){g[parseInt(t[0],10)].push(t);});
        var h='';
        for(var d=0;d<=4;d++){
            var d2=d+5;
            h+='<tr><td class="qt-loto-pfx">'+d+'</td><td class="qt-loto-nums">'+g[d].map(function(n){return '<span>'+n+'</span>';}).join(' ')+'</td><td class="qt-loto-pfx">'+d2+'</td><td class="qt-loto-nums">'+g[d2].map(function(n){return '<span>'+n+'</span>';}).join(' ')+'</td></tr>';
        }
        tbody.innerHTML=h;
    }
})();
</script>
