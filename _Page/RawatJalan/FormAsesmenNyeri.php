<div class="row mb-3">
    <div class="col-md-4 mb-2">
        H.2 Lokasi Nyeri<br>
    </div>
    <div class="col-md-8 mb-2">
        <input type="text" class="form-control" id="lokasi_nyeri" name="lokasi_nyeri">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4 mb-2">
        H.3 Penyebab Nyeri<br>
    </div>
    <div class="col-md-8 mb-2">
        <input type="text" class="form-control" id="penyebab_nyeri" name="penyebab_nyeri">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4 mb-2">
        H.4 Durasi Nyeri<br>
    </div>
    <div class="col-md-8 mb-2">
        <input type="text" class="form-control" id="durasi_nyeri" name="durasi_nyeri">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4 mb-2">
        H.5 Frekuensi Nyeri<br>
    </div>
    <div class="col-md-8 mb-2">
        <input type="text" class="form-control" id="frekuensi_nyeri" name="frekuensi_nyeri">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12 mb-2">
        H.3 Skala Nyeri
    </div>
    <div class="col-md-4 mb-2">
        H.3.1 Skala VAS<br>
        <small><i>Visual Analog Scale</i></small>
    </div>
    <div class="col-md-8 mb-2">
        <input type="range" class="form-control form-range" min="0" max="10" step="0.1" id="skala_vas" name="skala_vas" value="0">
        <small>Skor: <span id="ValueSkalaVas">0</span></small>
    </div>
    <div class="col-md-4 mb-2">
        H.3.2 Skala NRS<br>
        <small><i>Numeric Rating Scale</i></small>
    </div>
    <div class="col-md-8 mb-2">
        <input type="range" class="form-control form-range" min="0" max="10" step="1" id="skala_nrs" name="skala_nrs" value="0">
        <small>Skor: <span id="ValueSkalaNrs">0</span></small>
    </div>
    <div class="col-md-4 mb-2">
        H.3.3 Skala VRS<br>
        <small><i>Verbal Rating Scale</i></small>
    </div>
    <div class="col-md-8 mb-2">
        <input type="range" class="form-control form-range" min="0" max="10" step="2" id="skala_vrs" name="skala_vrs" value="0">
        <small>Skor: <span id="ValueSkalaVrs">0</span></small>
    </div>
    <div class="col-md-4 mb-2">
        H.3.4 Skala WBPRS<br>
        <small><i>Wong Baker Pain Rating Scale</i></small>
    </div>
    <div class="col-md-8 mb-2">
        <ul>
            <li>
                <input type="radio" name="skala_wbps" id="skala_wbps0" value="0">
                <label for="skala_wbps0"><i class="icofont-wink-smile icofont-2x"></i> <small>0 Tidak Sakit</small></label>
            </li>
            <li>
                <input type="radio" name="skala_wbps" id="skala_wbps2" value="2">
                <label for="skala_wbps2"><i class="icofont-slightly-smile icofont-2x"></i> <small>2 Sedikit Sakit</small></label>
            </li>
            <li>
                <input type="radio" name="skala_wbps" id="skala_wbps4" value="4">
                <label for="skala_wbps4"><i class="icofont-expressionless icofont-2x"></i> <small>4 Agak Mengganggu</small></label>
            </li>
            <li>
                <input type="radio" name="skala_wbps" id="skala_wbps6" value="6">
                <label for="skala_wbps6"><i class="icofont-sad icofont-2x"></i> <small>6 Mengganggu Aktivitas</small></label>
            </li>
            <li>
                <input type="radio" name="skala_wbps" id="skala_wbps8" value="8">
                <label for="skala_wbps8"><i class="icofont-worried icofont-2x"></i> <small>8 Sangat Mengganggu</small></label>
            </li>
            <li>
                <input type="radio" name="skala_wbps" id="skala_wbps10" value="10">
                <label for="skala_wbps10"><i class="icofont-crying icofont-2x"></i> <small>10 Tak Tertahankan</small></label>
            </li>
        </ul>
    </div>
    <div class="col-md-12">
        H.3.5 Skala NIPS<br>
        <small><i>Neonatal Infant Pain Scale</i></small>
    </div>
    <div class="col-md-4"> <label for="skala_nips1"><small>Facial Expression</small></label></div>
    <div class="col-md-8">
        <select name="skala_nips1" id="skala_nips1" class="form-control">
            <option value="0">Relaxed</option>
            <option value="1">Grimace</option>
        </select>
    </div>
    <div class="col-md-4"> <label for="skala_nips2"><small>Cry</small></label></div>
    <div class="col-md-8">
        <select name="skala_nips2" id="skala_nips2" class="form-control">
            <option value="0">No Cry</option>
            <option value="1">Whimper (mild moaning or intermittent)</option>
            <option value="2">Vigorous crying or silent cry (based on facial movements if intubated)</option>
        </select>
    </div>
    <div class="col-md-4"> <label for="skala_nips3"><small>Breathing Pattern</small></label></div>
    <div class="col-md-8">
        <select name="skala_nips3" id="skala_nips3" class="form-control">
            <option value="0">Relaxed</option>
            <option value="1">Change in breathing (irregular, increased, gagging, breath holding)</option>
        </select>
    </div>
    <div class="col-md-4"><label for="skala_nips4"><small>Arms</small></label></div>
    <div class="col-md-8">
        <select name="skala_nips4" id="skala_nips4" class="form-control">
            <option value="0">Relaxed</option>
            <option value="1">Flexed/extended (tense straight arms, rigid and/or rapid extension)</option>
        </select>
    </div>
    <div class="col-md-4"><label for="skala_nips5"><small>Legs</small></label></div>
    <div class="col-md-8">
        <select name="skala_nips5" id="skala_nips5" class="form-control">
            <option value="0">Relaxed</option>
            <option value="1">Flexed/extended (tense straight legs, rigid and/or rapid extension)</option>
        </select>
    </div>
    <div class="col-md-4"><label for="skala_nips6"><small>State Of Arousal</small></label></div>
    <div class="col-md-8">
        <select name="skala_nips6" id="skala_nips6" class="form-control">
            <option value="0">Sleeping/awake (quiet, peaceful, settled)</option>
            <option value="1">Fussy (alert, restless, and thrashing)</option>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        H.3.6 Pemeriksa
    </div>
    <div class="col-md-8">
        <input type="text" id="nakes_nyeri" name="nakes_nyeri" class="form-control">
        <small>Nama Nakes Yang Memeriksa</small>
    </div>
</div>