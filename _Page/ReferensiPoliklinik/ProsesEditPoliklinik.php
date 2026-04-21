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

    $id_poliklinik = (int) ($_POST['id_poliklinik'] ?? 0);
    $poliklinik    = trim($_POST['poliklinik'] ?? '');
    $kode          = trim($_POST['kode'] ?? '');
    $status        = isset($_POST['status']) ? 1 : 0;
    $updatetime    = date('Y-m-d H:i:s');

    if (empty($id_poliklinik)) {
        $response['message'] = 'ID poliklinik tidak valid.';
        echo json_encode($response);
        exit;
    }

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
        $stmtExist = mysqli_prepare(
            $Conn,
            "SELECT id_poliklinik
             FROM poliklinik
             WHERE id_poliklinik = ?"
        );

        if (!$stmtExist) {
            throw new Exception('Gagal menyiapkan validasi data.');
        }

        mysqli_stmt_bind_param($stmtExist, "i", $id_poliklinik);
        mysqli_stmt_execute($stmtExist);
        $resultExist = mysqli_stmt_get_result($stmtExist);

        if (!$resultExist || mysqli_num_rows($resultExist) === 0) {
            mysqli_stmt_close($stmtExist);
            $response['message'] = 'Data poliklinik tidak ditemukan.';
            echo json_encode($response);
            exit;
        }
        $dataLama = mysqli_fetch_assoc($resultExist);
        mysqli_stmt_close($stmtExist);

        $namaLama = trim($dataLama['poliklinik'] ?? '');
        $kodeLama = trim($dataLama['kode'] ?? '');

        if ($poliklinik !== $namaLama) {
            $stmtCheckNama = mysqli_prepare(
                $Conn,
                "SELECT id_poliklinik
                 FROM poliklinik
                 WHERE poliklinik = ?
                 AND id_poliklinik != ?"
            );

            if (!$stmtCheckNama) {
                throw new Exception('Gagal menyiapkan validasi nama poliklinik.');
            }

            mysqli_stmt_bind_param($stmtCheckNama, "si", $poliklinik, $id_poliklinik);
            mysqli_stmt_execute($stmtCheckNama);
            $resultCheckNama = mysqli_stmt_get_result($stmtCheckNama);

            if ($resultCheckNama && mysqli_num_rows($resultCheckNama) > 0) {
                mysqli_stmt_close($stmtCheckNama);
                $response['message'] = 'Nama poliklinik sudah digunakan.';
                echo json_encode($response);
                exit;
            }
            mysqli_stmt_close($stmtCheckNama);
        }

        

        $stmtUpdate = mysqli_prepare(
            $Conn,
            "UPDATE poliklinik SET
                poliklinik = ?,
                kode = ?,
                status = ?,
                updatetime = ?
             WHERE id_poliklinik = ?"
        );

        if (!$stmtUpdate) {
            throw new Exception('Gagal menyiapkan query update data.');
        }

        mysqli_stmt_bind_param(
            $stmtUpdate,
            "ssisi",
            $poliklinik,
            $kode,
            $status,
            $updatetime,
            $id_poliklinik
        );

        if (!mysqli_stmt_execute($stmtUpdate)) {
            mysqli_stmt_close($stmtUpdate);
            throw new Exception('Gagal memperbarui data poliklinik.');
        }

        mysqli_stmt_close($stmtUpdate);

        $response['status'] = 'success';
        $response['message'] = 'Data poliklinik berhasil diperbarui.';
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);
?>
