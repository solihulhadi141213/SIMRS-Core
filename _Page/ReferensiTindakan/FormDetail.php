<?php
    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // VALIDASI SESSION
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // VALIDASI id_tindakan_referensi
    if (empty($_POST['id_tindakan_referensi'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Referensi Tindakan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // VALIDASI kategori
    if (empty($_POST['kategori'])) {
        echo '
            <div class="alert alert-danger">
                <small>Kategori Detail Tindakan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // SANITASI INPUT
    $id_tindakan_referensi = validateAndSanitizeInput($_POST['id_tindakan_referensi']);
    $kategori              = validateAndSanitizeInput($_POST['kategori']);

    // Buka Data Referensi Tindakan
    $sql  = "SELECT * FROM tindakan_referensi WHERE id_tindakan_referensi = ?";
    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $id_tindakan_referensi);
    $stmt->execute();
    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();

    if (empty($Data)) {
        echo '
            <div class="alert alert-danger">
                <small>Data Referensi Tindakan Tidak Ditemukan!</small>
            </div>
        ';
        exit;
    }

    // Tutup Statment
     $stmt->close();

    // MAPPING DATA
    $id_tindakan_referensi     = $Data['id_tindakan_referensi'] ?? null;
    $kategori_tindakan         = $Data['kategori_tindakan'] ?? '-';
    $kategori_tindakan_code    = $Data['kategori_tindakan_code'] ?? '-';
    $kategori_tindakan_display = $Data['kategori_tindakan_display'] ?? '-';
    $kategori_tindakan_system  = $Data['kategori_tindakan_system'] ?? '-';
    $nama_tindakan             = $Data['nama_tindakan'] ?? '-';
    $nama_tindakan_code        = $Data['nama_tindakan_code'] ?? '-';
    $nama_tindakan_display     = $Data['nama_tindakan_display'] ?? '-';
    $nama_tindakan_system      = $Data['nama_tindakan_system'] ?? '-';
    $lokasi_tubuh              = $Data['lokasi_tubuh'] ?? '-';
    $lokasi_tubuh_code         = $Data['lokasi_tubuh_code'] ?? '-';
    $lokasi_tubuh_display      = $Data['lokasi_tubuh_display'] ?? '-';
    $lokasi_tubuh_system       = $Data['lokasi_tubuh_system'] ?? '-';
    $icd9_code                 = $Data['icd9_code'] ?? '-';
    $icd9_description          = $Data['icd9_description'] ?? '-';
    $status                    = $Data['status'] ?? '-';
    $datetime_creat            = $Data['datetime_creat'] ?? '-';
    $author_id                 = $Data['author_id'] ?? '-';
    $author_name               = $Data['author_name'] ?? '-';

    // Label Status
    if($status==1){
        $label_status = '
            <span class="px-2 py-1 bg-success-subtle text-success rounded-2">
                <small>Active</small>
            </span>
        ';
    }else{
        $label_status = '
            <span class="px-2 py-1 bg-danger-subtle text-danger rounded-2">
                <small>Deleted</small>
            </span>
        ';
    }

    // Menampilkan Detail Berdasarkan Kategori
    $no = 0;

    // All
    if($kategori=="All" || $kategori=="kategori_tindakan"){
        $no = $no+1;
        echo '
            <div class="row mb-2">
                <div class="col-12">
                    <small><b>'.$no.'. Kategori Tindakan</b></small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Kategori Tindakan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$kategori_tindakan.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small><i>Code</i></small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$kategori_tindakan_code.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small><i>Display</i></small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$kategori_tindakan_display.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small><i>System</i></small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$kategori_tindakan_system.'</small>
                </div>
            </div>
            <hr>
        ';
    }

    // Nama Tindakan
    if($kategori=="All" || $kategori=="nama_tindakan"){
        $no = $no+1;
        echo '
            <div class="row mb-2">
                <div class="col-12">
                    <small><b>'.$no.'. Nama / Jenis Tindakan</b></small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Nama Tindakan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$nama_tindakan.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small><i>Code</i></small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$nama_tindakan_code.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small><i>Display</i></small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$nama_tindakan_display.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small><i>System</i></small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$nama_tindakan_system.'</small>
                </div>
            </div>
            <hr>
        ';
    }

    // Lokasi Tubuh
    if($kategori=="All" || $kategori=="lokasi_tubuh"){
        $no = $no+1;
        echo '
            <div class="row mb-2">
                <div class="col-12">
                    <small><b>'.$no.'. Lokasi Tubuh (Body Site)</b></small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Nama Lokasi Tubuh <i>(Body Site)</i></small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$lokasi_tubuh.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small><i>Code</i></small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$lokasi_tubuh_code.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small><i>Display</i></small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$lokasi_tubuh_display.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small><i>System</i></small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$lokasi_tubuh_system.'</small>
                </div>
            </div>
            <hr>
        ';
    }

    // ICD9
    if($kategori=="All" || $kategori=="icd9"){
        $no = $no+1;
        echo '
            <div class="row mb-2">
                <div class="col-12">
                    <small><b>'.$no.'. ICD9</b></small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Kode ICD</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$icd9_code.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Deskripsi</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$icd9_description.'</small>
                </div>
            </div>
            <hr>
        ';
    }

    // Metadata
    $no = $no+1;
    echo '
        <div class="row mb-2">
            <div class="col-12">
                <small><b>'.$no.'. Metadata</b></small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Author</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$author_name.'</small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Datetime Creat</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$datetime_creat.'</small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Status</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$label_status.'</small>
            </div>
        </div>
    ';
?>
