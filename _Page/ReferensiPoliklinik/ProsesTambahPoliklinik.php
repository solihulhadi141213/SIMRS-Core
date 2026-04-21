<?php
    header('Content-Type: application/json');

    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan.'
    ];

    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi akses berakhir, silakan login ulang.';
        echo json_encode($response);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['message'] = 'Metode request tidak valid.';
        echo json_encode($response);
        exit;
    }

    $poliklinik = trim($_POST['poliklinik'] ?? '');
    $kode       = trim($_POST['kode'] ?? '');
    $status     = isset($_POST['status']) ? 1 : 0;
    $updatetime = date('Y-m-d H:i:s');

    if ($poliklinik === '') {
        $response['message'] = 'Nama poliklinik tidak boleh kosong.';
        echo json_encode($response);
        exit;
    }

    if ($kode === '') {
        $response['message'] = 'Kode poli tidak boleh kosong.';
        echo json_encode($response);
        exit;
    }

    if (mb_strlen($poliklinik) > 255) {
        $response['message'] = 'Nama poliklinik terlalu panjang.';
        echo json_encode($response);
        exit;
    }

    if (mb_strlen($kode) > 255) {
        $response['message'] = 'Kode poli terlalu panjang.';
        echo json_encode($response);
        exit;
    }

    try {
        $stmtCheckNama = mysqli_prepare(
            $Conn,
            "SELECT id_poliklinik
             FROM poliklinik
             WHERE poliklinik = ?"
        );

        if (!$stmtCheckNama) {
            throw new Exception('Gagal menyiapkan validasi nama poliklinik.');
        }

        mysqli_stmt_bind_param($stmtCheckNama, "s", $poliklinik);
        mysqli_stmt_execute($stmtCheckNama);
        $resultCheckNama = mysqli_stmt_get_result($stmtCheckNama);

        if ($resultCheckNama && mysqli_num_rows($resultCheckNama) > 0) {
            mysqli_stmt_close($stmtCheckNama);
            $response['message'] = 'Nama poliklinik sudah digunakan.';
            echo json_encode($response);
            exit;
        }
        mysqli_stmt_close($stmtCheckNama);

        $stmtCheckKode = mysqli_prepare(
            $Conn,
            "SELECT id_poliklinik
             FROM poliklinik
             WHERE kode = ?"
        );

        if (!$stmtCheckKode) {
            throw new Exception('Gagal menyiapkan validasi kode poli.');
        }

        mysqli_stmt_bind_param($stmtCheckKode, "s", $kode);
        mysqli_stmt_execute($stmtCheckKode);
        $resultCheckKode = mysqli_stmt_get_result($stmtCheckKode);

        if ($resultCheckKode && mysqli_num_rows($resultCheckKode) > 0) {
            mysqli_stmt_close($stmtCheckKode);
            $response['message'] = 'Kode poli sudah digunakan.';
            echo json_encode($response);
            exit;
        }
        mysqli_stmt_close($stmtCheckKode);

        $stmtInsert = mysqli_prepare(
            $Conn,
            "INSERT INTO poliklinik (
                poliklinik,
                kode,
                status,
                updatetime
            ) VALUES (?, ?, ?, ?)"
        );

        if (!$stmtInsert) {
            throw new Exception('Gagal menyiapkan query simpan data.');
        }

        mysqli_stmt_bind_param(
            $stmtInsert,
            "ssis",
            $poliklinik,
            $kode,
            $status,
            $updatetime
        );

        if (!mysqli_stmt_execute($stmtInsert)) {
            mysqli_stmt_close($stmtInsert);
            throw new Exception('Gagal menyimpan data poliklinik.');
        }

        mysqli_stmt_close($stmtInsert);

        $response['status'] = 'success';
        $response['message'] = 'Data poliklinik berhasil disimpan.';
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);
?>
