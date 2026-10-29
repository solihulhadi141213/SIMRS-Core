<?php
    error_reporting(0);
    ini_set('display_errors', 0);

    ob_start();

    header('Content-Type: application/json; charset=utf-8');

    $response = [
        'status'  => 'error',
        'message' => 'Terjadi kesalahan yang tidak diketahui.'
    ];

    $jsonSent = false;

    register_shutdown_function(function () use (&$response, &$jsonSent) {
        if (!$jsonSent) {
            ob_end_clean();
            header('Content-Type: application/json; charset=utf-8');
        }
    });

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    if (empty($Conn) || $Conn->connect_error) {
        $response['message'] = 'Koneksi database gagal.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    $id_imunisasi_referensi = (int) ($_POST['id_imunisasi_referensi'] ?? 0);
    $nama_vaksin     = trim(validateAndSanitizeInput($_POST['nama_vaksin'] ?? ''));
    $kode_cvx        = trim(validateAndSanitizeInput($_POST['kode_cvx'] ?? ''));
    $kode_kemenkes   = trim(validateAndSanitizeInput($_POST['kode_kemenkes'] ?? ''));
    $display_vaksin  = trim(validateAndSanitizeInput($_POST['display_vaksin'] ?? ''));
    $system_vaksin   = trim(validateAndSanitizeInput($_POST['system_vaksin'] ?? ''));
    $target_penyakit = trim(validateAndSanitizeInput($_POST['target_penyakit'] ?? ''));
    $status          = (int) ($_POST['status'] ?? 1);

    if (!$id_imunisasi_referensi) {
        $response['message'] = 'ID referensi imunisasi tidak valid.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    if ($nama_vaksin === '') {
        $response['message'] = 'Nama Vaksin wajib diisi.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }

    if (!in_array($status, [0, 1])) {
        $status = 1;
    }

    $stmtExisting = mysqli_prepare($Conn, "SELECT id_imunisasi_referensi FROM imunisasi_referensi WHERE id_imunisasi_referensi = ? LIMIT 1");
    if (!$stmtExisting) {
        $response['message'] = 'Gagal menyiapkan query validasi data.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }
    mysqli_stmt_bind_param($stmtExisting, 'i', $id_imunisasi_referensi);
    mysqli_stmt_execute($stmtExisting);
    $resultExisting = mysqli_stmt_get_result($stmtExisting);
    if (mysqli_num_rows($resultExisting) === 0) {
        mysqli_stmt_close($stmtExisting);
        $response['message'] = 'Data referensi imunisasi tidak ditemukan.';
        $jsonSent = true;
        ob_end_flush();
        exit;
    }
    mysqli_stmt_close($stmtExisting);

    $where = "WHERE id_imunisasi_referensi != ?";
    $params = [$id_imunisasi_referensi];
    $types = 'i';

    if ($nama_vaksin !== '') {
        $where .= " AND nama_vaksin = ?";
        $params[] = $nama_vaksin;
        $types .= 's';
    }
    if ($kode_cvx !== '') {
        $where .= " AND kode_cvx = ?";
        $params[] = $kode_cvx;
        $types .= 's';
    }
    if ($kode_kemenkes !== '') {
        $where .= " AND kode_kemenkes = ?";
        $params[] = $kode_kemenkes;
        $types .= 's';
    }
    if ($display_vaksin !== '') {
        $where .= " AND display_vaksin = ?";
        $params[] = $display_vaksin;
        $types .= 's';
    }
    if ($system_vaksin !== '') {
        $where .= " AND system_vaksin = ?";
        $params[] = $system_vaksin;
        $types .= 's';
    }
    if ($target_penyakit !== '') {
        $where .= " AND target_penyakit = ?";
        $params[] = $target_penyakit;
        $types .= 's';
    }

    $queryCek = "SELECT id_imunisasi_referensi FROM imunisasi_referensi $where LIMIT 1";
    $stmtCek = mysqli_prepare($Conn, $queryCek);
    if (!$stmtCek) {
        $response['message'] = 'Gagal menyiapkan query validasi duplikat.';
        echo json_encode($response);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }
    mysqli_stmt_bind_param($stmtCek, $types, ...$params);
    mysqli_stmt_execute($stmtCek);
    $resultCek = mysqli_stmt_get_result($stmtCek);
    if (mysqli_num_rows($resultCek) > 0) {
        mysqli_stmt_close($stmtCek);
        $response['message'] = 'Data referensi imunisasi sudah tersedia dengan kriteria yang sama.';
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $jsonSent = true;
        ob_end_flush();
        exit;
    }
    mysqli_stmt_close($stmtCek);

    mysqli_begin_transaction($Conn);

    try {
        $queryUpdate = "
            UPDATE imunisasi_referensi SET
                nama_vaksin = ?,
                kode_cvx = ?,
                kode_kemenkes = ?,
                display_vaksin = ?,
                system_vaksin = ?,
                target_penyakit = ?,
                status = ?
            WHERE id_imunisasi_referensi = ?
        ";

        $stmtUpdate = mysqli_prepare($Conn, $queryUpdate);
        if (!$stmtUpdate) {
            throw new Exception('Gagal menyiapkan query update.');
        }

        $typesUpdate = 'ssssssii';
        $paramsUpdate = [
            $nama_vaksin,
            $kode_cvx !== '' ? $kode_cvx : null,
            $kode_kemenkes !== '' ? $kode_kemenkes : null,
            $display_vaksin !== '' ? $display_vaksin : null,
            $system_vaksin !== '' ? $system_vaksin : null,
            $target_penyakit !== '' ? $target_penyakit : null,
            $status,
            $id_imunisasi_referensi
        ];

        mysqli_stmt_bind_param($stmtUpdate, $typesUpdate, ...$paramsUpdate);

        if (!mysqli_stmt_execute($stmtUpdate)) {
            throw new Exception('Gagal menyimpan perubahan data ke database.');
        }

        mysqli_stmt_close($stmtUpdate);
        mysqli_commit($Conn);

        $response['status']  = 'success';
        $response['message'] = 'Data referensi imunisasi berhasil diperbarui.';

    } catch (Exception $e) {
        mysqli_rollback($Conn);
        $response['message'] = $e->getMessage();
    } catch (Throwable $e) {
        mysqli_rollback($Conn);
        $response['message'] = 'Terjadi kesalahan sistem: ' . $e->getMessage();
    }

    $jsonEncoded = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($jsonEncoded === false) {
        $response['message'] = 'Gagal mengkodekan respons JSON.';
        $jsonEncoded = json_encode($response);
    }

    echo $jsonEncoded;
    $jsonSent = true;
    ob_end_flush();
?>
