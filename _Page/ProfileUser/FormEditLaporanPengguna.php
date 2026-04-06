<?php
     //Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";
    
    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Cek hasil validasi session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                Sesi Akses Sudah Berakhir! Silahkan Login Ulang!
            </div>
        ';
        exit;
    }
    //Tangkap id_akses_laporan
    if(empty($_POST['id_akses_laporan'])){
        echo '
            <div class="alert alert-danger">
                ID Laporan Tidak Boleh Kosong!
            </div>
        ';
        exit;
    }
    $id_akses_laporan=$_POST['id_akses_laporan'];
    $stmt = mysqli_prepare($Conn,"SELECT * FROM akses_laporan WHERE id_akses_laporan = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt,"i",$id_akses_laporan);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $Data = mysqli_fetch_array($result,MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);

    // Jika Data Tidak Ditemukan
    if (empty($Data['id_akses_laporan'])) {
        echo '
            <div class="alert alert-danger">
                Data Laporan Tidak Ditemukan!
            </div>
        ';
        exit;
       
    }
    $tanggal  = $Data['tanggal'];
    $judul    = $Data['judul'];
    $laporan  = $Data['laporan'];
    $response = $Data['response'] ?? '<span class="text-danger">Belum Ada</span>';
    $status   = $Data['status'];

    // Check Status lama
    $checkedDraft     = ($status == 'Draft') ? 'checked' : '';
    $checkedTerkirim  = ($status == 'Terkirim') ? 'checked' : '';

    // Tampilkan Data
    echo '
        <input type="hidden" name="id_akses_laporan" id="id_akses_laporan_edit" value="'.$id_akses_laporan.'">
        <div class="row mb-3">
            <div class="col-12">
                <label for="judul_laporan_edit"><small>Judul Laporan</small></label>
                <input type="text" name="judul_laporan" id="judul_laporan_edit" class="form-control" placeholder="Contoh : Tidak Bisa Login" value="'.$judul.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label><small>Isi Laporan</small></label>
                <div id="isi_laporan_editor_edit" style="height: 250px;"></div>
                 <input type="hidden" name="isi_laporan" id="isi_laporan_edit" value="'.htmlspecialchars($laporan, ENT_QUOTES).'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <small>Status Laporan</small>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status_laporan" id="status_laporan_1_edit" value="Draft" '.$checkedDraft.'>
                    <label class="form-check-label" for="status_laporan_1_edit">
                        <small class="text text-muted">Simpan Sebagai Draft</small>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status_laporan" id="status_laporan_2_edit" value="Terkirim" '.$checkedTerkirim.'>
                    <label class="form-check-label" for="status_laporan_2_edit">
                        <small class="text text-muted">Langsung Kirim Laporan</small>
                    </label>
                </div>
            </div>
        </div>
    ';
?>