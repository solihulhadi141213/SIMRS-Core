<?php
    header('Content-Type: application/json');

    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    // =============================================
    // VALIDASI SESSION
    // =============================================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            "status" => "error",
            "message" => "Sesi login sudah berakhir."
        ]);
        exit;
    }

    // =============================================
    // FUNCTION AMAN
    // =============================================
    function validate($data){
        return htmlspecialchars(trim($data));
    }

    // =============================================
    // AMBIL DATA
    // =============================================
    $id_kunjungan              = validate($_POST['id_kunjungan'] ?? '');
    $form                      = validate($_POST['from'] ?? '');

    $id_pasien                 = validate($_POST['id_pasien'] ?? '');
    $nama                      = validate($_POST['nama'] ?? '');
    $nik                       = validate($_POST['nik'] ?? '');
    $no_bpjs                   = validate($_POST['no_bpjs'] ?? '');
    $id_ihs                    = validate($_POST['id_ihs'] ?? '');

    $prioritas                 = validate($_POST['prioritas'] ?? '');
    $jenis_kunjungan           = validate($_POST['jenis_kunjungan'] ?? '');
    $keluhan                   = validate($_POST['keluhan'] ?? '');

    $date_daftar               = validate($_POST['date_daftar'] ?? '');
    $time_daftar               = validate($_POST['time_daftar'] ?? '');

    $sep                       = validate($_POST['sep'] ?? '');
    $id_encounter              = validate($_POST['id_encounter'] ?? '');

    $id_dokter                 = validate($_POST['id_dokter'] ?? '');
    $kode_dokter               = validate($_POST['kode_dokter'] ?? '');
    $dokter                    = validate($_POST['dokter'] ?? '');

    $dpjp_id                   = validate($_POST['dpjp_id'] ?? '');
    $dpjp_kode                 = validate($_POST['dpjp_kode'] ?? '');
    $dpjp_nama                 = validate($_POST['dpjp_nama'] ?? '');

    $id_poliklinik             = validate($_POST['id_poliklinik'] ?? '');
    $kode_poliklinik           = validate($_POST['kode_poliklinik'] ?? '');
    $poliklinik                = validate($_POST['poliklinik'] ?? '');

    $id_kelas_rawat            = validate($_POST['id_kelas_rawat'] ?? '');
    $id_ruang_rawat            = validate($_POST['id_ruang_rawat'] ?? '');
    $id_tempat_tidur           = validate($_POST['id_tempat_tidur'] ?? '');

    $pembayaran_metode         = validate($_POST['pembayaran_metode'] ?? '');
    $pembayaran_penanggung     = validate($_POST['pembayaran_penanggung'] ?? '');

    $kontak_darurat_nomor      = validate($_POST['kontak_darurat_nomor'] ?? '');
    $kontak_darurat_nama       = validate($_POST['kontak_darurat_nama'] ?? '');
    $kontak_darurat_hubungan   = validate($_POST['kontak_darurat_hubungan'] ?? '');

    $datetime_daftar = $date_daftar . ' ' . $time_daftar . ':00';

    // =============================================
    // NORMALISASI INTEGER NULL
    // =============================================
    $id_dokter       = !empty($id_dokter) ? (int)$id_dokter : NULL;
    $dpjp_id         = !empty($dpjp_id) ? (int)$dpjp_id : NULL;
    $id_poliklinik   = !empty($id_poliklinik) ? (int)$id_poliklinik : NULL;

    $id_kelas_rawat  = !empty($id_kelas_rawat) ? (int)$id_kelas_rawat : NULL;
    $id_ruang_rawat  = !empty($id_ruang_rawat) ? (int)$id_ruang_rawat : NULL;
    $id_tempat_tidur = !empty($id_tempat_tidur) ? (int)$id_tempat_tidur : NULL;

    // =============================================
    // VALIDASI
    // =============================================
    if (empty($id_kunjungan)) {
        echo json_encode([
            "status" => "error",
            "message" => "ID Kunjungan tidak boleh kosong."
        ]);
        exit;
    }

    if (empty($id_pasien)) {
        echo json_encode([
            "status" => "error",
            "message" => "Nomor RM tidak boleh kosong."
        ]);
        exit;
    }

    if (empty($nama)) {
        echo json_encode([
            "status" => "error",
            "message" => "Nama pasien tidak boleh kosong."
        ]);
        exit;
    }

    if (empty($keluhan)) {
        echo json_encode([
            "status" => "error",
            "message" => "Keluhan utama wajib diisi."
        ]);
        exit;
    }

    if (empty($prioritas)) {
        echo json_encode([
            "status" => "error",
            "message" => "Prioritas tindakan wajib dipilih."
        ]);
        exit;
    }

    if (empty($jenis_kunjungan)) {
        echo json_encode([
            "status" => "error",
            "message" => "Jenis kunjungan wajib dipilih."
        ]);
        exit;
    }

    if (empty($pembayaran_metode)) {
        echo json_encode([
            "status" => "error",
            "message" => "Metode pembayaran wajib dipilih."
        ]);
        exit;
    }

    // =============================================
    // VALIDASI DATA KUNJUNGAN
    // =============================================
    $validasi_kunjungan = mysqli_prepare($Conn, "
        SELECT id_kunjungan 
        FROM kunjungan
        WHERE id_kunjungan = ?
    ");

    mysqli_stmt_bind_param(
        $validasi_kunjungan,
        "i",
        $id_kunjungan
    );

    mysqli_stmt_execute($validasi_kunjungan);

    $result_kunjungan = mysqli_stmt_get_result($validasi_kunjungan);

    if (mysqli_num_rows($result_kunjungan) == 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Data kunjungan tidak ditemukan."
        ]);
        exit;
    }

    // =============================================
    // VALIDASI PASIEN
    // =============================================
    $query_pasien = mysqli_prepare($Conn, "
        SELECT id_pasien 
        FROM pasien 
        WHERE id_pasien = ?
    ");

    mysqli_stmt_bind_param(
        $query_pasien,
        "i",
        $id_pasien
    );

    mysqli_stmt_execute($query_pasien);

    $result_pasien = mysqli_stmt_get_result($query_pasien);

    if (mysqli_num_rows($result_pasien) == 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Pasien tidak ditemukan."
        ]);
        exit;
    }

    // =============================================
    // AMBIL NAMA KELAS / RUANG / TT
    // =============================================
    $kelas = NULL;
    $ruang_rawat = NULL;
    $tempat_tidur = NULL;

    // Kelas
    if (!empty($id_kelas_rawat)) {

        $query_kelas = mysqli_prepare($Conn, "
            SELECT kelas 
            FROM rr_kelas_rawat
            WHERE id_kelas_rawat = ?
        ");

        mysqli_stmt_bind_param(
            $query_kelas,
            "i",
            $id_kelas_rawat
        );

        mysqli_stmt_execute($query_kelas);

        $result_kelas = mysqli_stmt_get_result($query_kelas);
        $data_kelas = mysqli_fetch_assoc($result_kelas);

        $kelas = $data_kelas['kelas'] ?? NULL;
    }

    // Ruangan
    if (!empty($id_ruang_rawat)) {

        $query_ruang = mysqli_prepare($Conn, "
            SELECT ruang_rawat
            FROM rr_ruang_rawat
            WHERE id_ruang_rawat = ?
        ");

        mysqli_stmt_bind_param(
            $query_ruang,
            "i",
            $id_ruang_rawat
        );

        mysqli_stmt_execute($query_ruang);

        $result_ruang = mysqli_stmt_get_result($query_ruang);
        $data_ruang = mysqli_fetch_assoc($result_ruang);

        $ruang_rawat = $data_ruang['ruang_rawat'] ?? NULL;
    }

    // Tempat Tidur
    if (!empty($id_tempat_tidur)) {

        $query_tt = mysqli_prepare($Conn, "
            SELECT tempat_tidur
            FROM rr_tempat_tidur
            WHERE id_tempat_tidur = ?
        ");

        mysqli_stmt_bind_param(
            $query_tt,
            "i",
            $id_tempat_tidur
        );

        mysqli_stmt_execute($query_tt);

        $result_tt = mysqli_stmt_get_result($query_tt);
        $data_tt = mysqli_fetch_assoc($result_tt);

        $tempat_tidur = $data_tt['tempat_tidur'] ?? NULL;
    }

    // =============================================
    // UPDATE PASIEN
    // =============================================
    $update_pasien = mysqli_prepare($Conn, "
        UPDATE pasien SET
            nama = ?,
            nik = ?,
            no_bpjs = ?,
            id_ihs = ?,
            updated_at = NOW()
        WHERE id_pasien = ?
    ");

    mysqli_stmt_bind_param(
        $update_pasien,
        "ssssi",
        $nama,
        $nik,
        $no_bpjs,
        $id_ihs,
        $id_pasien
    );

    mysqli_stmt_execute($update_pasien);

    // =============================================
    // UPDATE KUNJUNGAN
    // =============================================
    $query = "
        UPDATE kunjungan SET

            id_encounter = ?,
            sep = ?,
            prioritas = ?,
            keluhan = ?,
            jenis_kunjungan = ?,

            id_dokter = ?,
            kode_dokter = ?,
            dokter = ?,

            dpjp_id = ?,
            dpjp_kode = ?,
            dpjp_nama = ?,

            id_poliklinik = ?,
            kode_poliklinik = ?,
            poliklinik = ?,

            kelas = ?,
            ruang_rawat = ?,
            tempat_tidur = ?,

            pembayaran_metode = ?,
            pembayaran_penanggung = ?,

            kontak_darurat_nomor = ?,
            kontak_darurat_nama = ?,
            kontak_darurat_hubungan = ?,

            datetime_daftar = ?

        WHERE id_kunjungan = ?
    ";

    $stmt = mysqli_prepare($Conn, $query);

    if (!$stmt) {
        echo json_encode([
            "status" => "error",
            "message" => mysqli_error($Conn)
        ]);
        exit;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "sssssissississsssssssssi",

        $id_encounter,
        $sep,
        $prioritas,
        $keluhan,
        $jenis_kunjungan,

        $id_dokter,
        $kode_dokter,
        $dokter,

        $dpjp_id,
        $dpjp_kode,
        $dpjp_nama,

        $id_poliklinik,
        $kode_poliklinik,
        $poliklinik,

        $kelas,
        $ruang_rawat,
        $tempat_tidur,

        $pembayaran_metode,
        $pembayaran_penanggung,

        $kontak_darurat_nomor,
        $kontak_darurat_nama,
        $kontak_darurat_hubungan,

        $datetime_daftar,

        $id_kunjungan
    );

    // =============================================
    // EKSEKUSI
    // =============================================
    if (mysqli_stmt_execute($stmt)) {

        echo json_encode([
            "status"  => "success",
            "message" => "Data kunjungan berhasil diperbarui.",
            "form"    => $form
        ]);

    } else {

        echo json_encode([
            "status"  => "error",
            "message" => mysqli_stmt_error($stmt)
        ]);
    }
?>