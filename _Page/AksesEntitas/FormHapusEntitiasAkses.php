<?php
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
        exit;
    }

    // Validasi id_akses_entitas
    if(empty($_POST['id_akses_entitas'])){
        echo '
            <div class="alert alert-danger text-center">
                <small>ID Entitas Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel Dan Sanitasi
    $id_akses_entitas = validateAndSanitizeInput($_POST['id_akses_entitas']);

    // Buka Data Dengan Prepared Statment
    $sql  = "SELECT * FROM akses_entitas WHERE id_akses_entitas = ?";
    $stmt = $Conn->prepare($sql);

    // Bind parameter (tipe data integer "i")
    $stmt->bind_param("i", $id_akses_entitas);

    // Eksekusi statement
    $stmt->execute();

    // Ambil hasil query
    $result = $stmt->get_result();
    $Data = $result->fetch_assoc();

    // Simpan hasil ke variabel
    $akses = $Data['akses'] ?? null;
    $deskripsi   = $Data['deskripsi'] ?? null;

    // Tutup statement
    $stmt->close();

    // Tampilkan Data
    echo '
        <input type="hidden" name="id_akses_entitas" value="'.$id_akses_entitas.'">
        <div class="row mb-2">
            <div class="col-4"><small>Entitas Akses</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$akses.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Deskripsi</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$deskripsi.'</small></div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-center">
                <div class="alert alert-warning">
                    <b>PENTING!</b><br>
                    <small>Menghapus Entiitas Akses Akan Menyebabkan Pengguna Yang Terhubung Pada Entitas Tersebut Tidak Dapat Melakukan Akses Pada Beberapa Fitur Yang Ditentukan Sebelumny.</small><br>
                    <small><b>Apakah Anda Yakin Akan Menghapus Data Tersebut?</b></small>
                </div>
            </div>
        </div>
    ';

?>