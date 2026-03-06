<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-link"></i> Công Cụ Ghép Lô Xiên
        </div>
        <div class="sc-tool-wrap">
            <div class="sc-tool-row">
                <input type="text" id="xien-nums" class="sc-input" placeholder="Nhập các số lô (vd: 12 34 56 78)" style="flex:1">
                <select id="xien-type" class="sc-select">
                    <option value="2">Xiên 2</option>
                    <option value="3">Xiên 3</option>
                    <option value="4">Xiên 4</option>
                </select>
                <button onclick="ghepxien()" class="sc-btn">Ghép Xiên</button>
            </div>
            <div id="xien-result" style="margin-top:12px"></div>
        </div>
    </div>
</section>
<script>
function ghepxien() {
    const raw   = document.getElementById('xien-nums').value.trim();
    const k     = parseInt(document.getElementById('xien-type').value);
    const el    = document.getElementById('xien-result');
    const nums  = raw.split(/\s+/).filter(Boolean).map(n => n.padStart(2,'0'));
    if (nums.length < k) { el.innerHTML='<span style="color:red">Cần ít nhất '+k+' số</span>'; return; }
    const combos = [];
    const comb = (start, cur) => {
        if (cur.length === k) { combos.push([...cur]); return; }
        for (let i = start; i < nums.length; i++) comb(i+1, [...cur, nums[i]]);
    };
    comb(0, []);
    el.innerHTML = '<strong>'+combos.length+' tổ hợp xiên '+k+':</strong><div class="sc-tk-grid" style="margin-top:8px">'
        + combos.map(c=>'<div class="sc-tk-item">'+c.join(' — ')+'</div>').join('') + '</div>';
}
</script>
