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

    // Validasi id_akses_fitur
    if(empty($_POST['id_akses_fitur'])){
        echo '
            <div class="alert alert-danger text-center">
                <small>ID Fitur Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel Dan Sanitasi
    $id_akses_fitur = validateAndSanitizeInput($_POST['id_akses_fitur']);

    // Buka Data Dengan Prepared Statment
    $sql  = "SELECT * FROM  akses_fitur WHERE id_akses_fitur = ?";
    $stmt = $Conn->prepare($sql);

    // Bind parameter (tipe data integer "i")
    $stmt->bind_param("i", $id_akses_fitur);

    // Eksekusi statement
    $stmt->execute();

    // Ambil hasil query
    $result = $stmt->get_result();
    $Data = $result->fetch_assoc();

    // Simpan hasil ke variabel
    $nama_fitur = $Data['nama_fitur'] ?? null;
    $kategori   = $Data['kategori'] ?? null;
    $kode       = $Data['kode'] ?? null;
    $keterangan = $Data['keterangan'] ?? null;

    // Tutup statement
    $stmt->close();

    // Tampilkan Data
    echo '
        <input type="hidden" name="id_akses_fitur" value="'.$id_akses_fitur.'">
        <div class="row mb-3">
            <div class="col-12">
                <label for="nama_fitur_edit"><small>Nama Fitur</small></label>
                <input type="text" name="nama_fitur" id="nama_fitur_edit" class="form-control" value="'.$nama_fitur.'" placeholder="Contoh : Laporan" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="kategori_edit"><small>Kategori</small></label>
                <select name="kategori" id="kategori_edit" class="form-control" required>
                    <option value="'.htmlspecialchars($kategori).'" selected>
                        '.htmlspecialchars($kategori).'
                    </option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="kode_edit"><small>Kode Akses</small></label>
                <div class="input-group">
                    <input type="text" name="kode" id="kode_edit" class="form-control" value="'.$kode.'" required>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="GenerateKodeEdit">
                        <i class="bi bi-arrow-repeat"></i> Generate
                    </button>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="keterangan_edit"><small>Keterangan</small></label>
                <textarea name="keterangan" id="keterangan_edit" class="form-control" required>'.$keterangan.'</textarea>
            </div>
        </div>
    ';

?>