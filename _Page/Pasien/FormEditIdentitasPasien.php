<?php
    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";
    
    // Validasi id_pasien
    if(empty($_POST['id_pasien'])){
        echo '
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <small>ID Pasien Tidak Boleh Kosong!</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Validasi Field
    if(empty($_POST['field'])){
        echo '
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger text-center">
                        <small>Field Tidak Boleh Kosong!</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }

    // Buat Variabel
    $id_pasien = $_POST['id_pasien'];
    $field     = $_POST['field'];

    // Query Detail Pasien
    $query = "SELECT * FROM pasien WHERE id_pasien = ? LIMIT 1";
    $stmt = mysqli_prepare($Conn, $query);

    // Debug Query Prepare
    if (!$stmt) {
        echo '
            <div class="alert alert-danger">
                <small>Gagal mempersiapkan query : '.mysqli_error($Conn).'</small>
            </div>
        ';
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id_pasien);

    // Debug Execute
    if (!mysqli_stmt_execute($stmt)) {
        echo '
            <div class="alert alert-danger">
                <small>Gagal menjalankan query : '.mysqli_stmt_error($stmt).'</small>
            </div>
        ';
        exit;
    }

    $result = mysqli_stmt_get_result($stmt);

    // Validasi Data
    if (mysqli_num_rows($result) == 0) {
        echo '
            <div class="alert alert-danger">
                <small>Data pasien tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    // Fetch Data
    $row = mysqli_fetch_assoc($result);

    // Routing Label
    $label_value = "";
    if($field=="nik"){
        $label_value = "NIK Pasien";
        $curent_value = $row['nik'];
    }
    if($field=="no_bpjs"){
        $label_value = "No.BPJS";
        $curent_value = $row['no_bpjs'];
    }
    if($field=="id_ihs"){
        $label_value = "IHS SATU SEHAT";
        $curent_value = $row['id_ihs'];
    }

    // Tampilkan Form
    echo '
        <input type="hidden" name="id_pasien" value="'.$id_pasien.'">
        <input type="hidden" name="field" value="'.$field.'">

        <div class="row mb-2">
            <div class="col-4"><small>Nomor RM Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$id_pasien.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$row['nama'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Jenis Kelamin</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$row['gender'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Status</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text-muted">'.$row['status'].'</small></div>
        </div>
        <hr>

        <div class="row">
            <div class="col-12">
                <label for="value_field"><small>'.$label_value.'</small></label>
                <input type="text" name="value_field" id="value_field" class="form-control" value="'.$curent_value.'">
            </div>
        </div>
    ';
?>
