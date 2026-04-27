<?php
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

if (empty($SessionIdAkses)) {
    echo '<div class="alert alert-danger text-center"><small>Sesi berakhir</small></div>';
    exit;
}
?>

<div class="row mb-3">
    <div class="col-4">
        <label><small>Versi ICD</small></label>
    </div>
    <div class="col-8">
        <select name="icd_version" class="form-control">
            <option value="ICD9">ICD9</option>
            <option value="ICD10" selected>ICD10</option>
            <option value="ICD11">ICD11</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-4">
        <label><small>Format File</small></label>
    </div>
    <div class="col-8">
        <select name="format" class="form-control">
            <option value="excel">Excel (.xlsx)</option>
            <option value="csv">CSV</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-4">
        <label><small>Batas Data</small></label>
    </div>
    <div class="col-8">
        <select name="limit" class="form-control">
            <option value="100">100</option>
            <option value="500">500</option>
            <option value="1000">1000</option>
            <option value="all">Semua</option>
        </select>
    </div>
</div>

<div class="alert alert-info">
    <small>Silahkan pilih parameter download data ICD.</small>
</div>