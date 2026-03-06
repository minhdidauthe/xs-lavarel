<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-moon"></i> Tra Cứu Số Mơ — Giải Mã Giấc Mơ
        </div>
        <div class="sc-tool-wrap">
            <div class="sc-tool-row">
                <input type="text" id="so-mo-input" class="sc-input" placeholder="Nhập từ khoá (vd: rắn, tiền, chó...)" style="flex:1" onkeydown="if(event.key==='Enter')traSoMo()">
                <button onclick="traSoMo()" class="sc-btn">Tra Cứu</button>
            </div>
            <div id="so-mo-result" style="margin-top:12px"></div>
        </div>
    </div>
</section>
<script>
const soMoDB = {
    'ran': ['12','21','51','15'], 'con ran': ['12','21'], 'tien': ['00','11','68','86'],
    'cho': ['10','01','16','61'], 'meo': ['02','20','35','53'], 'ca': ['04','40','38','83'],
    'nuoc': ['26','62','18','81'], 'lua': ['33','77','47','74'], 'chet': ['05','50','53','35'],
    'dam cuoi': ['36','63','23','32'], 'con so': ['88','99','00'], 'nguoi than': ['41','14'],
    'trung so': ['00','11','88'], 'nha': ['44','09','90'], 'xe': ['17','71','55'],
    'bay': ['72','27','62','26'], 'boi': ['67','76','38'], 'an com': ['43','34'],
};
function traSoMo() {
    const kw = document.getElementById('so-mo-input').value.trim().toLowerCase();
    const el = document.getElementById('so-mo-result');
    if (!kw) { el.innerHTML = '<span style="color:red">Vui lòng nhập từ khoá</span>'; return; }
    let found = null;
    for (const [key, nums] of Object.entries(soMoDB)) {
        if (kw.includes(key) || key.includes(kw)) { found = {key, nums}; break; }
    }
    if (found) {
        el.innerHTML = `<strong>Mơ thấy "${found.key}" → nên đánh số:</strong><div class="sc-nums" style="margin-top:8px">${found.nums.map(n=>`<span class="sc-badge sc-badge-hot">${n}</span>`).join('')}</div>`;
    } else {
        el.innerHTML = `<span style="color:#aaa">Không tìm thấy "${kw}". Thử từ khoá khác.</span>`;
    }
}
</script>
