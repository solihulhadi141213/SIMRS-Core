<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    if(empty($_POST['id_tt'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
        echo '      ID Tempat Tidur Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_tt=$_POST['id_tt'];
        //Buka detail pengaturan
        $response_referensi=DataTtSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'GET');
        if(empty($response_referensi)){
            echo '<div class="row">';
            echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
            echo '      Tidak ada response dari SIRS Online <br>Keterangan: '.$response_referensi.'';
            echo '  </div>';
            echo '</div>';
        }else{
            $php_array = json_decode($response_referensi, true);
            $ReferensiTt=$php_array['fasyankes'];
            $JumlahData=count($ReferensiTt);
            if(empty($JumlahData)){
                echo '<div class="row">';
                echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
                echo '      Tidak ada yang ditampilkan dari SIRS Online <br>Keterangan: '.$response_referensi.'';
                echo '  </div>';
                echo '</div>';
            }else{
                foreach ($ReferensiTt as $item) {
                    // Tambahkan setiap elemen ke dalam array PHP
                    $IdTtList= $item['id_tt'];
                    if($IdTtList==$id_tt){
                        $tt= $item['tt'];
                        $ruang= $item['ruang'];
                        $kode_siranap= $item['kode_siranap'];
                        $jumlah_ruang= $item['jumlah_ruang'];
                        $jumlah= $item['jumlah'];
                        $terpakai= $item['terpakai'];
                        $terpakai_suspek= $item['terpakai_suspek'];
                        $terpakai_konfirmasi= $item['terpakai_konfirmasi'];
                        $antrian= $item['antrian'];
                        $prepare= $item['prepare'];
                        $prepare_plan= $item['prepare_plan'];
                        $kosong= $item['kosong'];
                        $covid= $item['covid'];
                        $id_t_tt= $item['id_t_tt'];
                        $tglupdate= $item['tglupdate'];

?>
    <input type="hidden" name="id_t_tt" value="<?php echo "$id_t_tt"; ?>">
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>ID TT</dt>
        </div>
        <div class="col-md-8">
            <?php echo $IdTtList; ?>
        </div>
    </div>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>ID Record</dt>
        </div>
        <div class="col-md-8">
            <?php echo $id_t_tt; ?>
        </div>
    </div>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>Nama TT</dt>
        </div>
        <div class="col-md-8">
            <?php echo $tt; ?>
        </div>
    </div>
    <div class="row mb-3 sub-title">
        <div class="col-md-4">
            <dt>Ruangan</dt>
        </div>
        <div class="col-md-8">
            <?php echo $ruang; ?>
        </div>
    </div>
<?php }}}}} ?>