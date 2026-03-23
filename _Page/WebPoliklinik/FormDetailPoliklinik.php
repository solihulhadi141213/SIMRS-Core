<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    include "../../_Page/WebPoliklinik/WebPoliklinikFunction.php";
    $url=urlService('Detail Poliklinik');
    if(empty($_POST['id_poliklinik'])){
        echo '<span class="text-danger">ID Poliklinik Tidak Boleh Kosong</span>';
    }else{
        $id_poliklinik=$_POST['id_poliklinik'];
        $JsonDataDetail=getDetailPoliklinik($api_key,$url,$id_poliklinik);
        $massage=$JsonDataDetail['metadata']['massage'];
        if($massage=="Berhasil"){
            $kode=$JsonDataDetail['response']['kode'];
            $nama=$JsonDataDetail['response']['nama'];
            $deskripsi=$JsonDataDetail['response']['deskripsi'];
            $status=$JsonDataDetail['response']['status'];
            $last_update=$JsonDataDetail['response']['last_update'];

?>
    <div class="container pre-scrollable">
        <div class="row mb-3">
            <div class="col-md-4">
                <dt>Kode Poli</dt>
            </div>
            <div class="col-md-8">
                <?php echo "$kode";?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <dt>Nama Poli</dt>
            </div>
            <div class="col-md-8">
                <?php echo "$nama";?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <dt>Status</dt>
            </div>
            <div class="col-md-8">
                <?php echo "$status";?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <dt>Update Terakhir</dt>
            </div>
            <div class="col-md-8">
                <?php echo "$last_update";?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <dt>Deskripsi</dt>
            </div>
            <div class="col-md-8">
                <?php echo "$deskripsi";?>
            </div>
        </div>
    </div>
<?php }} ?>