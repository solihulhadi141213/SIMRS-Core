<?php
    // Header JSON
    header('Content-Type: application/json');

    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Sesi akses sudah berakhir. Silahkan login ulang."
        ]);
        exit;
    }

    // Tangkap Data
    $kategori_tindakan         = $_POST['kategori_tindakan'] ?? '';
    $kategori_tindakan_code    = validateAndSanitizeInput($_POST['kategori_tindakan_code'] ?? '');
    $kategori_tindakan_display = validateAndSanitizeInput($_POST['kategori_tindakan_display'] ?? '');
    $kategori_tindakan_system  = validateAndSanitizeInput($_POST['kategori_tindakan_system'] ?? '');

    $nama_tindakan             = validateAndSanitizeInput($_POST['nama_tindakan'] ?? '');
    $nama_tindakan_code        = validateAndSanitizeInput($_POST['nama_tindakan_code'] ?? '');
    $nama_tindakan_display     = validateAndSanitizeInput($_POST['nama_tindakan_display'] ?? '');
    $nama_tindakan_system      = validateAndSanitizeInput($_POST['nama_tindakan_system'] ?? '');

    $lokasi_tubuh              = validateAndSanitizeInput($_POST['lokasi_tubuh'] ?? '');
    $lokasi_tubuh_code         = validateAndSanitizeInput($_POST['lokasi_tubuh_code'] ?? '');
    $lokasi_tubuh_display      = validateAndSanitizeInput($_POST['lokasi_tubuh_display'] ?? '');
    $lokasi_tubuh_system       = validateAndSanitizeInput($_POST['lokasi_tubuh_system'] ?? '');

    $icd9_code                 = validateAndSanitizeInput($_POST['icd9_code'] ?? '');
    $icd9_description          = validateAndSanitizeInput($_POST['icd9_description'] ?? '');

    // Validasi Mandatory
    if(empty($kategori_tindakan)){
        echo json_encode([
            "status"  => "error",
            "message" => "Kategori Tindakan Tidak Boleh Kosong!"
        ]);
        exit;
    }

    if(empty($nama_tindakan)){
        echo json_encode([
            "status"  => "error",
            "message" => "Nama Tindakan Tidak Boleh Kosong!"
        ]);
        exit;
    }

    if(empty($lokasi_tubuh)){
        echo json_encode([
            "status"  => "error",
            "message" => "Lokasi Tubuh Tidak Boleh Kosong!"
        ]);
        exit;
    }

    // Validasi Duplikat Nama Tindakan
    $id_tindakan_referensi = getDataDetail_v2(
        $Conn,
        'tindakan_referensi',
        'nama_tindakan',
        $nama_tindakan,
        'id_tindakan_referensi'
    );

    if(!empty($id_tindakan_referensi)){
        echo json_encode([
            "status"  => "error",
            "message" => "Referensi Tindakan Tersebut Sudah Terdaftar!"
        ]);
        exit;
    }

    // Cek Body Site
    $id_body_site = getDataDetail_v2(
        $Conn,
        'body_site',
        'body_site_nama',
        $lokasi_tubuh,
        'id_body_site'
    );

    // Status
    $status = 1;

    // Datetime
    $datetime_creat  = date('Y-m-d H:i:s');
    $datetime_update = date('Y-m-d H:i:s');

    // ==========================
    // MULAI TRANSACTION
    // ==========================
    mysqli_begin_transaction($Conn);

    try {

        // ==========================
        // INSERT tindakan_referensi
        // ==========================
        $query = "INSERT INTO tindakan_referensi (
            kategori_tindakan,
            kategori_tindakan_code,
            kategori_tindakan_display,
            kategori_tindakan_system,
            nama_tindakan,
            nama_tindakan_code,
            nama_tindakan_display,
            nama_tindakan_system,
            lokasi_tubuh,
            lokasi_tubuh_code,
            lokasi_tubuh_display,
            lokasi_tubuh_system,
            icd9_code,
            icd9_description,
            status,
            datetime_creat,
            author_id,
            author_name
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($Conn, $query);

        if (!$stmt) {
            throw new Exception('Prepare statement tindakan_referensi gagal.');
        }

        mysqli_stmt_bind_param(
            $stmt,
            "ssssssssssssssisss",
            $kategori_tindakan,
            $kategori_tindakan_code,
            $kategori_tindakan_display,
            $kategori_tindakan_system,
            $nama_tindakan,
            $nama_tindakan_code,
            $nama_tindakan_display,
            $nama_tindakan_system,
            $lokasi_tubuh,
            $lokasi_tubuh_code,
            $lokasi_tubuh_display,
            $lokasi_tubuh_system,
            $icd9_code,
            $icd9_description,
            $status,
            $datetime_creat,
            $SessionIdAkses,
            $SessionNama
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Gagal insert tindakan_referensi.');
        }

        mysqli_stmt_close($stmt);

        // ==========================
        // INSERT body_site
        // ==========================
        if(empty($id_body_site)){

            $queryBodySite = "INSERT INTO body_site (
                body_site_nama,
                body_site_display,
                body_site_code,
                body_site_system,
                datetime_creat,
                datetime_update,
                author_id,
                author_name
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmtBody = mysqli_prepare($Conn, $queryBodySite);

            if (!$stmtBody) {
                throw new Exception('Prepare statement body_site gagal.');
            }

            mysqli_stmt_bind_param(
                $stmtBody,
                "ssssssis",
                $lokasi_tubuh,
                $lokasi_tubuh_display,
                $lokasi_tubuh_code,
                $lokasi_tubuh_system,
                $datetime_creat,
                $datetime_update,
                $SessionIdAkses,
                $SessionNama
            );

            if (!mysqli_stmt_execute($stmtBody)) {
                throw new Exception('Gagal insert body_site.');
            }

            mysqli_stmt_close($stmtBody);
        }

        // ==========================
        // COMMIT
        // ==========================
        mysqli_commit($Conn);

        echo json_encode([
            "status"  => "success",
            "message" => "Tambah Referensi Tindakan Berhasil!"
        ]);

    } catch (Exception $e) {

        // ==========================
        // ROLLBACK
        // ==========================
        mysqli_rollback($Conn);

        echo json_encode([
            "status"  => "error",
            "message" => $e->getMessage()
        ]);
    }
?>