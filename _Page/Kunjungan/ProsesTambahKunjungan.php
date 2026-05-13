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

    $kelas                     = validate($_POST['kelas'] ?? '');
    $ruang_rawat               = validate($_POST['ruang_rawat'] ?? '');
    $tempat_tidur              = validate($_POST['tempat_tidur'] ?? '');

    $pembayaran_metode         = validate($_POST['pembayaran_metode'] ?? '');
    $pembayaran_penanggung     = validate($_POST['pembayaran_penanggung'] ?? '');

    $kontak_darurat_nomor      = validate($_POST['kontak_darurat_nomor'] ?? '');
    $kontak_darurat_nama       = validate($_POST['kontak_darurat_nama'] ?? '');
    $kontak_darurat_hubungan   = validate($_POST['kontak_darurat_hubungan'] ?? '');

    $datetime_daftar = $date_daftar . ' ' . $time_daftar . ':00';

    // =============================================
    // DEFAULT STATUS
    // =============================================
    $status = "Terdaftar";

    // =============================================
    // NORMALISASI INTEGER NULL
    // =============================================
    $id_dokter = !empty($id_dokter) ? (int)$id_dokter : NULL;
    $dpjp_id = !empty($dpjp_id) ? (int)$dpjp_id : NULL;
    $id_poliklinik = !empty($id_poliklinik) ? (int)$id_poliklinik : NULL;

    // =============================================
    // VALIDASI
    // =============================================
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
    // VALIDASI PASIEN
    // =============================================
    $query_pasien = mysqli_prepare($Conn, "
        SELECT id_pasien FROM pasien 
        WHERE id_pasien = ?
    ");

    mysqli_stmt_bind_param($query_pasien, "i", $id_pasien);
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
    // UPDATE DATA PASIEN
    // =============================================
    $update_pasien = mysqli_prepare($Conn, "
        UPDATE pasien SET
            nik = ?,
            no_bpjs = ?,
            id_ihs = ?,
            updated_at = NOW()
        WHERE id_pasien = ?
    ");

    mysqli_stmt_bind_param(
        $update_pasien,
        "sssi",
        $nik,
        $no_bpjs,
        $id_ihs,
        $id_pasien
    );

    mysqli_stmt_execute($update_pasien);

    // =============================================
    // INSERT KUNJUNGAN
    // =============================================
    $query = "
        INSERT INTO kunjungan (
            id_encounter,
            id_pasien,
            sep,
            prioritas,
            keluhan,
            jenis_kunjungan,
            id_dokter,
            kode_dokter,
            dokter,
            dpjp_id,
            dpjp_kode,
            dpjp_nama,
            id_poliklinik,
            kode_poliklinik,
            poliklinik,
            kelas,
            ruang_rawat,
            tempat_tidur,
            pembayaran_metode,
            pembayaran_penanggung,
            kontak_darurat_nomor,
            kontak_darurat_nama,
            kontak_darurat_hubungan,
            status,
            petugas_id,
            petugas_nama,
            datetime_daftar
        ) VALUES (
            ?,?,?,?,?,?,
            ?,?,?,?,
            ?,?,?,?,
            ?,?,?,?,
            ?,?,?,?,
            ?,?,?,?,
            ?
        )
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
        "sissssissississsssssssssiss",

        $id_encounter,
        $id_pasien,
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

        $status,
        $SessionIdAkses,
        $SessionNama,
        $datetime_daftar
    );

    // =============================================
    // EKSEKUSI
    // =============================================
    if (mysqli_stmt_execute($stmt)) {

        echo json_encode([
            "status" => "success",
            "message" => "Kunjungan berhasil ditambahkan."
        ]);

    } else {

        echo json_encode([
            "status" => "error",
            "message" => mysqli_stmt_error($stmt)
        ]);
    }
?>