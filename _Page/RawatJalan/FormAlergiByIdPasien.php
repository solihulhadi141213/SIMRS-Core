<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Kunjungan Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
        $nama=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'nama');
        //Cek ihs Pasien
        $id_ihs=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'id_ihs');
        if(empty($id_ihs)){
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          Pasien belum memiliki ID IHS';
            echo '      </div>';
            echo '  </div>';
        }else{
            $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
            $Token=GenerateTokenSatuSehat($Conn);
            $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
            if(empty($SettingSatuSehat)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-danger text-center">';
                echo '      Tidak Ada Setting Satu Sehat Yang Aktif!';
                echo '  </div>';
                echo '</div>';
            }else{
                if(empty($Token)){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-danger text-center">';
                    echo '      Gagal Melakukan Generate Token!';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    if(empty($baseurl_satusehat)){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-danger text-center">';
                        echo '      Tidak Ada Base URL Satu Sehat!';
                        echo '  </div>';
                        echo '</div>';
                    }else{
?>
    <div class="row mb-3">
        <div class="col-md-12 mb-2">
            <dt>1. Informasi Pasien & Kunjungan</dt>
        </div>
        <div class="col-md-4 mb-2">1.1 ID.Kunjungan</div>
        <div class="col-md-8 mb-2">
            <input type="text" name="id_kunjungan" id="id_kunjungan" class="form-control" value="<?php echo "$id_kunjungan"; ?>">
        </div>
        <div class="col-md-4 mb-2">1.2 No.RM</div>
        <div class="col-md-8 mb-2">
            <input type="text" name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$id_pasien"; ?>">
        </div>
        <div class="col-md-4 mb-2">1.3 Nama Pasien</div>
        <div class="col-md-8 mb-2">
            <input type="text" name="nama_pasien" id="nama_pasien" class="form-control" value="<?php echo "$nama"; ?>">
        </div>
    </div>
<?php }}}}} ?>