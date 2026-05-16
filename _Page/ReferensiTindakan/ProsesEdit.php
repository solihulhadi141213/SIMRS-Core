<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Sesi akses sudah berakhir. Silahkan login ulang."
        ]);
        exit;
    }

    $id_tindakan_referensi    = validateAndSanitizeInput($_POST['id_tindakan_referensi'] ?? '');
    $kategori_tindakan         = validateAndSanitizeInput($_POST['kategori_tindakan'] ?? '');
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

    if (empty($id_tindakan_referensi)) {
        echo json_encode([
            "status"  => "error",
            "message" => "ID Referensi Tindakan Tidak Boleh Kosong!"
        ]);
        exit;
    }

    if (empty($kategori_tindakan)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Kategori Tindakan Tidak Boleh Kosong!"
        ]);
        exit;
    }

    if (empty($nama_tindakan)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Nama Tindakan Tidak Boleh Kosong!"
        ]);
        exit;
    }

    if (empty($lokasi_tubuh)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Lokasi Tubuh Tidak Boleh Kosong!"
        ]);
        exit;
    }

    $queryCheck = "
        SELECT id_tindakan_referensi
        FROM tindakan_referensi
        WHERE nama_tindakan = ?
            AND id_tindakan_referensi <> ?
        LIMIT 1
    ";

    $stmtCheck = mysqli_prepare($Conn, $queryCheck);

    if (!$stmtCheck) {
        echo json_encode([
            "status"  => "error",
            "message" => "Prepare validasi data gagal."
        ]);
        exit;
    }

    mysqli_stmt_bind_param($stmtCheck, "si", $nama_tindakan, $id_tindakan_referensi);
    mysqli_stmt_execute($stmtCheck);
    $resultCheck = mysqli_stmt_get_result($stmtCheck);
    $duplicateData = mysqli_fetch_assoc($resultCheck);
    mysqli_stmt_close($stmtCheck);

    if (!empty($duplicateData)) {
        echo json_encode([
            "status"  => "error",
            "message" => "Referensi Tindakan Tersebut Sudah Terdaftar!"
        ]);
        exit;
    }

    $id_body_site = getDataDetail_v2(
        $Conn,
        'body_site',
        'body_site_nama',
        $lokasi_tubuh,
        'id_body_site'
    );

    $datetime_update = date('Y-m-d H:i:s');

    mysqli_begin_transaction($Conn);

    try {
        $queryUpdate = "
            UPDATE tindakan_referensi SET
                kategori_tindakan = ?,
                kategori_tindakan_code = ?,
                kategori_tindakan_display = ?,
                kategori_tindakan_system = ?,
                nama_tindakan = ?,
                nama_tindakan_code = ?,
                nama_tindakan_display = ?,
                nama_tindakan_system = ?,
                lokasi_tubuh = ?,
                lokasi_tubuh_code = ?,
                lokasi_tubuh_display = ?,
                lokasi_tubuh_system = ?,
                icd9_code = ?,
                icd9_description = ?
            WHERE id_tindakan_referensi = ?
        ";

        $stmt = mysqli_prepare($Conn, $queryUpdate);

        if (!$stmt) {
            throw new Exception('Prepare statement update tindakan_referensi gagal.');
        }

        mysqli_stmt_bind_param(
            $stmt,
            "ssssssssssssssi",
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
            $id_tindakan_referensi
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Gagal update tindakan_referensi.');
        }

        mysqli_stmt_close($stmt);

        if (empty($id_body_site)) {
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
                $datetime_update,
                $datetime_update,
                $SessionIdAkses,
                $SessionNama
            );

            if (!mysqli_stmt_execute($stmtBody)) {
                throw new Exception('Gagal insert body_site.');
            }

            mysqli_stmt_close($stmtBody);
        }

        mysqli_commit($Conn);

        echo json_encode([
            "status"  => "success",
            "message" => "Edit Referensi Tindakan Berhasil!"
        ]);
    } catch (Exception $e) {
        mysqli_rollback($Conn);

        echo json_encode([
            "status"  => "error",
            "message" => $e->getMessage()
        ]);
    }
?>
