<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_pasien
    if(empty($_POST['id_pasien'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 mb-3 text-center">';
        echo '          Data ID Pasien Tidak Boleh Kosong. Silahkan Isi No.RM Ibu terlebih dulu';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_pasien=$_POST['id_pasien'];
        //Buka data Pasien
        $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$id_pasien'")or die(mysqli_error($Conn));
        $DataPasien = mysqli_fetch_array($QryPasien);
        $id_pasien= $DataPasien['id_pasien'];
        $noRm=sprintf("%07d", $id_pasien);
        $tanggal_daftar= $DataPasien['tanggal_daftar'];
        if(!empty($DataPasien['propinsi'])){
            $propinsi= $DataPasien['propinsi'];
        }else{
            $propinsi='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['kabupaten'])){
            $kabupaten= $DataPasien['kabupaten'];
        }else{
            $kabupaten='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['kecamatan'])){
            $kecamatan= $DataPasien['kecamatan'];
        }else{
            $kecamatan='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['desa'])){
            $desa= $DataPasien['desa'];
        }else{
            $desa='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['alamat'])){
            $alamat= $DataPasien['alamat'];
        }else{
            $alamat='<span class="text-danger">Tidak Diketahui</span>';
        }
?>
    <div class="row mb-3">
        <div class="col-md-4">
            <dt>No.RM</dt>
        </div>
        <div class="col-md-6">
            <?php echo $id_pasien; ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <dt>ALAMAT</dt>
        </div>
        <div class="col-md-6">
            <?php echo $alamat; ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <dt>PROVINSI</dt>
        </div>
        <div class="col-md-6">
            <?php echo $propinsi; ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <dt>KABUPATEN</dt>
        </div>
        <div class="col-md-6">
            <?php echo $kabupaten; ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <dt>KECAMATAN</dt>
        </div>
        <div class="col-md-6">
            <?php echo $kecamatan; ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <dt>DESA/KEL</dt>
        </div>
        <div class="col-md-6">
            <?php echo $desa; ?>
        </div>
    </div>
<?php } ?>