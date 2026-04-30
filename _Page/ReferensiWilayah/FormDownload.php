<?php
echo '
<div class="row mb-3">
    <div class="col-md-6 mb-3">
        <label><small>Provinsi</small></label>
        <input type="text" name="province" class="form-control" placeholder="Contoh: Jawa Barat">
    </div>

    <div class="col-md-6 mb-3">
        <label><small>Kabupaten / Kota</small></label>
        <input type="text" name="regency" class="form-control" placeholder="Contoh: Kuningan">
    </div>

    <div class="col-md-6 mb-3">
        <label><small>Kecamatan</small></label>
        <input type="text" name="subdistrict" class="form-control" placeholder="Contoh: Cigugur">
    </div>

    <div class="col-md-6 mb-3">
        <label><small>Desa / Kelurahan</small></label>
        <input type="text" name="village" class="form-control" placeholder="Contoh: Cisantana">
    </div>

    <div class="col-md-6 mb-3">
        <label><small>Tipe Desa</small></label>
        <select name="tipe_level4" class="form-control">
            <option value="">- Semua -</option>
            <option value="Desa">Desa</option>
            <option value="Kelurahan">Kelurahan</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label><small>Format File</small></label>
        <select name="format" class="form-control" required>
            <option value="excel">Excel (.xlsx)</option>
            <option value="csv">CSV</option>
        </select>
    </div>
</div>

<div class="alert alert-info">
    <small>
        Anda dapat mengosongkan filter untuk download seluruh data wilayah.
    </small>
</div>
';