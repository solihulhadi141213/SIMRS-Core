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

    // SANITASI INPUT
    $id_tindakan_referensi = validateAndSanitizeInput($_POST['id_tindakan_referensi']);

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

    // Menampilkan Detail 
    echo '
        <input type="hidden" name="id_tindakan_referensi" value="'.$id_tindakan_referensi.'">
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
        <div class="row mb-2">
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <small>
                        <b>PENTING</b><br>
                        Proses ini hanya mengembalikan status data referensi dan tidak akan mempengaruhi data lain yang berhubungan.
                    </small>
                </div>
            </div>
        </div>
    ';

    
?>
