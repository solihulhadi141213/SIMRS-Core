<?php
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi akses sudah berakhir, silakan login ulang.</small>
            </div>
        ';
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo '
            <div class="alert alert-danger text-center">
                <small>Metode request tidak valid.</small>
            </div>
        ';
        exit;
    }

    if (empty($_POST['id_praktisi'])) {
        echo '
            <div class="alert alert-danger text-center">
                <small>ID Praktisi tidak boleh kosong.</small>
            </div>
        ';
        exit;
    }

    $id_praktisi = (int) $_POST['id_praktisi'];
    $stmt = mysqli_prepare($Conn,"SELECT * FROM praktisi WHERE id_praktisi = ?");

    if (!$stmt) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Gagal menyiapkan query.</small>
            </div>
        ';
        exit;
    }
    mysqli_stmt_bind_param($stmt, "i", $id_praktisi);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$result || mysqli_num_rows($result) == 0) {
        mysqli_stmt_close($stmt);
        echo '
            <div class="alert alert-warning text-center">
                <small>Data tidak ditemukan.</small>
            </div>
        ';
        exit;
    }
    $data = mysqli_fetch_assoc($result); 
    mysqli_stmt_close($stmt);

    $id_akses         = $data['id_akses'] ?? '-';
    $id_dokter        = $data['id_dokter'] ?? '-';
    $tipe_praktisi    = $data['tipe_praktisi'] ?? '-';
    $profesi_praktisi = $data['profesi_praktisi'] ?? '-';
    $nama_praktisi    = $data['nama_praktisi'] ?? '-';
    $nik_praktisi     = $data['nik_praktisi'] ?? '-';
    $kontak_praktisi  = $data['kontak_praktisi'] ?? '-';
    $email_praktisi   = $data['email_praktisi'] ?? '-';

    echo '
        <div class="row mb-2">
            <div class="col-4"><small>Nama Praktisi</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$nama_praktisi.'</small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Tipe</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$tipe_praktisi.'</small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Profesi</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$profesi_praktisi.'</small>
            </div>
        </div>
    ';
?>

<input type="hidden" name="id_praktisi" value="<?php echo $id_praktisi; ?>">

<div class="row mb-3">
    <div class="col-12">
        <div class="alert alert-warning text-center">
            <small>
                <b>PENTING!!</b><br>
                Data praktisi yang sudah dihapus tidak akan bisa dikembalikan lagi.<br>
                Menghapus data ini tidak akan mengubah dokumen apapun pada rekam medis elektronik.
            </small>
        </div>
    </div>
</div>