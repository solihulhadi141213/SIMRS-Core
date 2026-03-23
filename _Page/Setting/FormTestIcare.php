<?php
    //koneksi dan session
    include "../../vendor/autoload.php";
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Menangkap Variabel
    if(empty($_POST['consid'])){
        $consid="";
    }else{
        $consid=$_POST['consid'];
    }
    if(empty($_POST['cons_id_antrol'])){
        $cons_id_antrol="";
    }else{
        $cons_id_antrol=$_POST['cons_id_antrol'];
    }
    if(empty($_POST['user_key'])){
        $user_key="";
    }else{
        $user_key=$_POST['user_key'];
    }
    if(empty($_POST['user_key_antrol'])){
        $user_key_antrol="";
    }else{
        $user_key_antrol=$_POST['user_key_antrol'];
    }
    if(empty($_POST['secret_key'])){
        $secret_key="";
    }else{
        $secret_key=$_POST['secret_key'];
    }
    if(empty($_POST['secret_key_antrol'])){
        $secret_key_antrol="";
    }else{
        $secret_key_antrol=$_POST['secret_key_antrol'];
    }
    if(empty($_POST['kode_ppk'])){
        $kode_ppk="";
    }else{
        $kode_ppk=$_POST['kode_ppk'];
    }
    if(empty($_POST['url_vclaim'])){
        $url_vclaim="";
    }else{
        $url_vclaim=$_POST['url_vclaim'];
    }
    if(empty($_POST['url_aplicare'])){
        $url_aplicare="";
    }else{
        $url_aplicare=$_POST['url_aplicare'];
    }
    if(empty($_POST['url_antrol'])){
        $url_antrol="";
    }else{
        $url_antrol=$_POST['url_antrol'];
    }
    if(empty($_POST['url_faskes'])){
        $url_faskes="";
    }else{
        $url_faskes=$_POST['url_faskes'];
    }
    if(empty($_POST['url_icare'])){
        $url_icare="";
    }else{
        $url_icare=$_POST['url_icare'];
    }
    if(empty($_POST['kategori_ppk'])){
        $kategori_ppk="";
    }else{
        $kategori_ppk=$_POST['kategori_ppk'];
    }
    // Computes the timestamp
    date_default_timezone_set('UTC');
    $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
    //Creat Signature
    $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
    // base64 encode…
    $encodedSignature = base64_encode($signature);
?>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="x_cons_id">Const ID</label>
        <input type="text" name="x_cons_id" class="form-control" value="<?php echo "$consid"; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="secret_key">Secret Key</label>
        <input type="text" name="secret_key" class="form-control" value="<?php echo "$secret_key"; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="user_key">User Key</label>
        <input type="text" name="user_key" class="form-control" value="<?php echo "$user_key"; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="x_timestamp">X-Timestamp</label>
        <input type="text" name="x_timestamp" class="form-control" value="<?php echo "$timestamp"; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="x_signature">X-Signature</label>
        <input type="text" name="x_signature" class="form-control" value="<?php echo "$encodedSignature"; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="url_icare">URL i-Care</label>
        <input type="text" name="url_icare" class="form-control" value="<?php echo "$url_icare"; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="nomor_kartu">Nomor Kartu</label>
        <input type="text" name="nomor_kartu" id="nomor_kartu" class="form-control">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <label for="kode_dokter">Kode Dokter</label>
        <input type="text" name="kode_dokter" id="kode_dokter" class="form-control">
    </div>
</div>
<div id="HasilProsesICare">

</div>
