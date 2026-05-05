<?php
    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Helper Bridging
    include "../../_Config/HelperBridging.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small class="text-danger"> Sesi Akses Sudah Berakhir! Silahkan Login Ulang.</small>
            </div>
        ';
        exit;
    }
    if(empty($_POST['nama_prov'])){
        echo '
            <div class="alert alert-danger text-center">
                <small class="text-danger"> Nama Provinsi Tidak Boleh Kosong</small>
            </div>
        ';
        exit;
    }
    if(empty($_POST['kode_prov'])){
        echo '
            <div class="alert alert-danger text-center">
                <small class="text-danger"> Kode Provinsi Tidak Boleh Kosong</small>
            </div>
        ';
        exit;
    }
    if(empty($_POST['nama_kab'])){
        echo '
            <div class="alert alert-danger text-center">
                <small class="text-danger"> Nama Kabupaten Tidak Boleh Kosong</small>
            </div>
        ';
        exit;
    }
    if(empty($_POST['kode_kab'])){
        echo '
            <div class="alert alert-danger text-center">
                <small class="text-danger"> Kode Kabupaten Tidak Boleh Kosong</small>
            </div>
        ';
        exit;
    }
    if(empty($_POST['nama_kec'])){
        echo '
            <div class="alert alert-danger text-center">
                <small class="text-danger"> Nama Kecamatan Tidak Boleh Kosong</small>
            </div>
        ';
        exit;
    }
    if(empty($_POST['kode_kec'])){
        echo '
            <div class="alert alert-danger text-center">
                <small class="text-danger"> Kode Kecamatan Tidak Boleh Kosong</small>
            </div>
        ';
        exit;
    }

    // AMBIL KEYWORD
    $nama_prov = trim($_POST['nama_prov'] ?? '');
    $kode_prov = trim($_POST['kode_prov'] ?? '');
    $nama_kab  = trim($_POST['nama_kab'] ?? '');
    $kode_kab  = trim($_POST['kode_kab'] ?? '');
    $nama_kec  = trim($_POST['nama_kec'] ?? '');
    $kode_kec  = trim($_POST['kode_kec'] ?? '');

    // Mencari Data Di SIMRS
    $province    = getDataDetail_v2($Conn, 'wilayah', 'kode_bpjs1', $kode_prov, 'province');
    $regency     = getDataDetail_v2($Conn, 'wilayah', 'kode_bpjs2', $kode_kab, 'regency');
    $subdistrict = getDataDetail_v2($Conn, 'wilayah', 'kode_bpjs3', $kode_kec, 'subdistrict');
?>

<input type="hidden" name="kode_bpjs1" value="<?php echo $kode_prov; ?>">
<input type="hidden" name="kode_bpjs2" value="<?php echo $kode_kab; ?>">
<input type="hidden" name="kode_bpjs3" value="<?php echo $kode_kec; ?>">

<div class="row mb-2">
    <div class="col-5"><small>Provinsi</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $nama_prov; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Kabupaten / Kota</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $nama_kab; ?></small></div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Kecamatan</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6"><small class="text-muted"><?php echo $nama_kec; ?></small></div>
</div>
<hr>
<div class="row mb-3 mt-3">
    <div class="col-12">
        <label for="province"><small>Provinsi</small></label>
        <select name="province" id="province" class="form-control">
            <option value="">Pilih</option>
            <?php
                $query_prov = mysqli_query($Conn, "SELECT DISTINCT province FROM wilayah ORDER BY province asc");
                while ($data_prov = mysqli_fetch_array($query_prov)) {
                    $province_list = $data_prov['province'];

                    if($province_list==$province){
                         echo '<option selected value="'.$province_list.'">'.$province_list.'</option>';
                    }else{
                         echo '<option value="'.$province_list.'">'.$province_list.'</option>';
                    }
                }
            ?>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="regency"><small>Kabupaten / Kota</small></label>
        <select name="regency" id="regency" class="form-control">
            <option value="">Pilih</option>
            <?php
                if(!empty($province)){
                    $query_kab = mysqli_query($Conn, "SELECT DISTINCT regency FROM wilayah WHERE province='$province' ORDER BY regency ASC");
                    while ($data_kab = mysqli_fetch_array($query_kab)) {
                        $regency_list = $data_kab['regency'];

                        if($regency_list==$regency){
                            echo '<option selected value="'.$regency_list.'">'.$regency_list.'</option>';
                        }else{
                            echo '<option value="'.$regency_list.'">'.$regency_list.'</option>';
                        }
                    }
                }
            ?>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="subdistrict"><small>Kecamatan</small></label>
        <select name="subdistrict" id="subdistrict" class="form-control">
            <option value="">Pilih</option>
            <?php
                if(!empty($regency)){
                    $query_kec = mysqli_query($Conn, "SELECT DISTINCT subdistrict FROM wilayah WHERE regency='$regency' ORDER BY subdistrict ASC");
                    while ($data_kec = mysqli_fetch_array($query_kec)) {
                        $subdistrict_list = $data_kec['subdistrict'];

                        if($subdistrict_list==$subdistrict){
                            echo '<option selected value="'.$subdistrict_list.'">'.$subdistrict_list.'</option>';
                        }else{
                            echo '<option value="'.$subdistrict_list.'">'.$subdistrict_list.'</option>';
                        }
                    }
                }
            ?>
        </select>
    </div>
</div>