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

    // VALIDASI id_episode_perawatan_kode
    if (empty($_POST['id_episode_perawatan_kode'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Episode Perawatan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // SANITASI INPUT
    $id_episode_perawatan_kode = validateAndSanitizeInput($_POST['id_episode_perawatan_kode']);

    // Buka Data Episode Perawatan
    $sql  = "SELECT * FROM episode_perawatan_kode WHERE id_episode_perawatan_kode = ?";
    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $id_episode_perawatan_kode);
    $stmt->execute();
    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();

    if (empty($Data)) {
        echo '
            <div class="alert alert-danger">
                <small>Data Episode Perawatan Tidak Ditemukan!</small>
            </div>
        ';
        exit;
    }

    // Tutup Statment
    $stmt->close();

    // MAPPING DATA
    $id_episode_perawatan_kode = $Data['id_episode_perawatan_kode'] ?? null;
    $episode_category           = $Data['episode_category'] ?? '-';
    $episode_name               = $Data['episode_name'] ?? '-';
    $episode_display            = $Data['episode_display'] ?? '-';
    $episode_code               = $Data['episode_code'] ?? '-';
    $episode_system             = $Data['episode_system'] ?? '-';
    $status                     = $Data['status'] ?? '-';

    echo '
        <div class="row mb-2">
            <div class="col-12">
                <small><b>A. Kategori Episode Perawatan</b></small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Kategori</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$episode_category.'</small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>Code</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$episode_code.'</small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>Display</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$episode_display.'</small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>System</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$episode_system.'</small>
            </div>
        </div>
        <hr>

        <div class="row mb-2">
            <div class="col-12">
                <small><b>B. Episode Perawatan</b></small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Episode Perawatan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$episode_name.'</small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>Code</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$episode_code.'</small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>Display</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$episode_display.'</small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>System</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$episode_system.'</small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>Status</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$status.'</small>
            </div>
        </div>
    ';

    echo '
    <div class="row">
        <div class="col-12 text-center">
            <div class="alert alert-danger">
                <small>
                    <b>PENTING!</b><br>
                    Menghapus episode perawatan referensi akan menghapus data riwayat pemeriksaan pasien. <br>
                    <b>Apakah anda akan tetap menghapus data tersebut?</b>
                </small>
            </div>
        </div>
    </div>
    <input type="hidden" name="id_episode_perawatan_kode" value="'.$id_episode_perawatan_kode.'">
';
?>