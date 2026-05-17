<?php
    // ==========================================================
    // ERROR REPORTING
    // ==========================================================
    error_reporting(0);
    ini_set('display_errors', 0);

    // ==========================================================
    // HEADER JSON
    // ==========================================================
    header('Content-Type: application/json');

    // ==========================================================
    // CONNECTION & SESSION
    // ==========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // ==========================================================
    // TIMEZONE
    // ==========================================================
    date_default_timezone_set('Asia/Jakarta');

    // ==========================================================
    // VALIDASI SESSION
    // ==========================================================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Sesi akses sudah berakhir, silahkan login ulang.'
        ]);
        exit;
    }

    // ==========================================================
    // VALIDASI MANDATORY
    // ==========================================================
    $required = [
        'id_pasien'          => 'ID Pasien',
        'id_kunjungan'       => 'ID Kunjungan',
        'kategori_tindakan'  => 'Kategori Tindakan',
        'nama_tindakan'      => 'Nama Tindakan',
        'date_start'         => 'Tanggal Mulai',
        'time_start'         => 'Jam Mulai',
        'reson_reference'    => 'Jenis ICD',
        'reson_code'         => 'Diagnosis / Reason Code'
    ];

    foreach ($required as $field => $label) {

        if (empty($_POST[$field])) {

            echo json_encode([
                'status'  => 'error',
                'message' => $label . ' tidak boleh kosong.'
            ]);
            exit;
        }
    }

    // ==========================================================
    // SANITASI INPUT
    // ==========================================================
    $id_pasien               = validateAndSanitizeInput($_POST['id_pasien']);
    $id_kunjungan            = validateAndSanitizeInput($_POST['id_kunjungan']);

    $id_tindakan_referensi   = validateAndSanitizeInput($_POST['id_tindakan_referensi'] ?? '');

    $kategori_tindakan       = validateAndSanitizeInput($_POST['kategori_tindakan']);
    $nama_tindakan           = validateAndSanitizeInput($_POST['nama_tindakan']);
    $lokasi_tubuh            = validateAndSanitizeInput($_POST['lokasi_tubuh'] ?? '');

    $icd9_code               = validateAndSanitizeInput($_POST['icd9_code'] ?? '');
    $icd9_description        = validateAndSanitizeInput($_POST['icd9_description'] ?? '');

    $date_start              = validateAndSanitizeInput($_POST['date_start']);
    $time_start              = validateAndSanitizeInput($_POST['time_start']);

    $date_end                = validateAndSanitizeInput($_POST['date_end'] ?? '');
    $time_end                = validateAndSanitizeInput($_POST['time_end'] ?? '');

    $reson_reference         = validateAndSanitizeInput($_POST['reson_reference']);
    $reson_code              = validateAndSanitizeInput($_POST['reson_code']);
    $reson_display           = validateAndSanitizeInput($_POST['reson_display'] ?? '');

    $post_tindakan           = validateAndSanitizeInput($_POST['post_tindakan'] ?? '');

    // ==========================================================
    // DATETIME
    // ==========================================================
    $datetime_start = $date_start . ' ' . $time_start . ':00';

    $datetime_end = null;

    if (!empty($date_end) && !empty($time_end)) {
        $datetime_end = $date_end . ' ' . $time_end . ':00';
    }

    $datetime_now = date('Y-m-d H:i:s');

    // ==========================================================
    // VALIDASI DATETIME
    // ==========================================================
    if (!strtotime($datetime_start)) {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Format waktu mulai tidak valid.'
        ]);
        exit;
    }

    if (!empty($datetime_end)) {

        if (!strtotime($datetime_end)) {

            echo json_encode([
                'status'  => 'error',
                'message' => 'Format waktu selesai tidak valid.'
            ]);
            exit;
        }

        if (strtotime($datetime_end) < strtotime($datetime_start)) {

            echo json_encode([
                'status'  => 'error',
                'message' => 'Waktu selesai tidak boleh lebih kecil dari waktu mulai.'
            ]);
            exit;
        }
    }

    // ==========================================================
    // VALIDASI ICD
    // ==========================================================
    if (!in_array($reson_reference, ['ICD10', 'ICD11'])) {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Jenis ICD tidak valid.'
        ]);
        exit;
    }

    // ==========================================================
    // START TRANSACTION
    // ==========================================================
    mysqli_begin_transaction($Conn);

    try {

        // ======================================================
        // JIKA REFERENSI TINDAKAN KOSONG
        // MAKA BUAT REFERENSI BARU
        // ======================================================
        if (empty($id_tindakan_referensi)) {

            $status = 1;

            $sql_insert_ref = "
                INSERT INTO tindakan_referensi (
                    kategori_tindakan,
                    nama_tindakan,
                    lokasi_tubuh,
                    icd9_code,
                    icd9_description,
                    status,
                    datetime_creat,
                    author_id,
                    author_name
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?
                )
            ";

            $stmt_ref = $Conn->prepare($sql_insert_ref);

            $stmt_ref->bind_param(
                "sssssisis",
                $kategori_tindakan,
                $nama_tindakan,
                $lokasi_tubuh,
                $icd9_code,
                $icd9_description,
                $status,
                $datetime_now,
                $SessionIdAkses,
                $SessionNama
            );

            $execute_ref = $stmt_ref->execute();

            if (!$execute_ref) {
                throw new Exception('Gagal menyimpan referensi tindakan.');
            }

            $id_tindakan_referensi = $Conn->insert_id;

            $stmt_ref->close();
        }

        // ======================================================
        // INSERT TINDAKAN
        // ======================================================
        $sql = "
            INSERT INTO tindakan (
                id_pasien,
                id_kunjungan,
                id_tindakan_referensi,
                datetime_start,
                datetime_end,
                reson_reference,
                reson_code,
                reson_display,
                post_tindakan,
                datetime_creat,
                datetime_update,
                petugas_id,
                petugas_nama
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )
        ";

        $stmt = $Conn->prepare($sql);

        $stmt->bind_param(
            "iiissssssssis",
            $id_pasien,
            $id_kunjungan,
            $id_tindakan_referensi,
            $datetime_start,
            $datetime_end,
            $reson_reference,
            $reson_code,
            $reson_display,
            $post_tindakan,
            $datetime_now,
            $datetime_now,
            $SessionIdAkses,
            $SessionNama
        );

        $execute = $stmt->execute();

        if (!$execute) {
            throw new Exception('Gagal menyimpan data tindakan.');
        }

        $id_tindakan = $Conn->insert_id;

        $stmt->close();

        // ======================================================
        // COMMIT
        // ======================================================
        mysqli_commit($Conn);

        echo json_encode([
            'status'        => 'success',
            'message'       => 'Tambah tindakan berhasil.',
            'id_tindakan'   => $id_tindakan,
            'id_kunjungan'  => $id_kunjungan
        ]);
        exit;

    } catch (Exception $e) {

        // ======================================================
        // ROLLBACK
        // ======================================================
        mysqli_rollback($Conn);

        echo json_encode([
            'status'  => 'error',
            'message' => $e->getMessage()
        ]);
        exit;
    }
?>