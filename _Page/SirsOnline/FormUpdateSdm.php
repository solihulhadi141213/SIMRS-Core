<?php
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //Jika Ada sumber Data
    if(empty($_POST['id_kebutuhan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Kebutuhan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kebutuhan=$_POST['id_kebutuhan'];
        $response_referensi=DataSdmSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'GET');
        $php_array = json_decode($response_referensi, true);
        $DataSdm=$php_array['sdm'];
        $JumlahData=count($DataSdm);
        if(empty($JumlahData)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      '.$DataSdm.'';
            echo '  </div>';
            echo '</div>';
        }else{
            $no=1;
            foreach ($DataSdm as $item) {
                if($id_kebutuhan==$item['id_kebutuhan']){
                    // Tambahkan setiap elemen ke dalam array PHP
                    $IdkebutuhanList= $item['id_kebutuhan'];
                    $NamaKebutuhanList= $item['kebutuhan'];
                    $JumlahEksisting= $item['jumlah_eksisting'];
                    $Jumlah= $item['jumlah'];
                    $JumlahDiterima= $item['jumlah_diterima'];
                    $TanggalUpdate= $item['tglupdate'];
                    $JumlahSimrs = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE referensi_sdm='$NamaKebutuhanList'"));
?>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="id_kebutuhan">ID Kebutuhan</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="id_kebutuhan" id="id_kebutuhan" class="form-control" value="<?php echo "$IdkebutuhanList"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="kebutuhan">Referensi SDM</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="kebutuhan" id="kebutuhan" class="form-control" value="<?php echo "$NamaKebutuhanList"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="JumlahEksisting">Jumlah Eksisting</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="JumlahEksisting" id="JumlahEksisting" class="form-control" value="<?php echo "$JumlahEksisting"; ?>">
            <small>
                Berdasarkan data rekap SIMRS menunjukan bahwa data eksisting sekarang ada sebanyak <?php echo "$JumlahSimrs Orang"; ?>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jumlah">Jumlah</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="jumlah" id="jumlah" class="form-control" value="<?php echo "$Jumlah"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jumlah_diterima">Jumlah Diterima</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="jumlah_diterima" id="jumlah_diterima" class="form-control" value="<?php echo "$JumlahDiterima"; ?>">
        </div>
    </div>
<?php }}}} ?>