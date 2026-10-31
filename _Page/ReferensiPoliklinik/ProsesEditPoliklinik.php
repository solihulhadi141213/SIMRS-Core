
<?php
    header('Content-Type: application/json; charset=utf-8');

    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Fungsi response JSON
    function SendResponse($status, $message)
    {
        echo json_encode([
            'status'  => $status,
            'message' => $message
        ], JSON_UNESCAPED_UNICODE);

        exit;
    }

    // Validasi sesi
    if (empty($SessionIdAkses)) {
        SendResponse('error', 'Sesi akses berakhir, silakan login ulang.');
    }

    // Validasi metode request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        SendResponse('error', 'Metode request tidak valid.');
    }

    // Ambil data POST
    $id_poliklinik = (int) ($_POST['id_poliklinik'] ?? 0);
    $poliklinik    = trim($_POST['poliklinik'] ?? '');
    $kode          = trim($_POST['kode'] ?? '');
    $status        = isset($_POST['status']) ? 1 : 0;
    $updatetime    = date('Y-m-d H:i:s');

    // Validasi input
    if ($id_poliklinik <= 0) {
        SendResponse('error', 'ID poliklinik tidak valid.');
    }

    if ($poliklinik === '') {
        SendResponse('error', 'Nama poliklinik tidak boleh kosong.');
    }

    if ($kode === '') {
        SendResponse('error', 'Kode poli tidak boleh kosong.');
    }

    if (mb_strlen($poliklinik) > 255) {
        SendResponse('error', 'Nama poliklinik terlalu panjang.');
    }

    if (mb_strlen($kode) > 255) {
        SendResponse('error', 'Kode poli terlalu panjang.');
    }

    try {

        // Ambil data lama sekaligus validasi keberadaan data
        $stmtData = mysqli_prepare(
            $Conn,
            "SELECT poliklinik, kode
            FROM poliklinik
            WHERE id_poliklinik = ?
            LIMIT 1"
        );

        if (!$stmtData) {
            throw new Exception('Gagal menyiapkan validasi data.');
        }

        mysqli_stmt_bind_param($stmtData, "i", $id_poliklinik);
        mysqli_stmt_execute($stmtData);

        $resultData = mysqli_stmt_get_result($stmtData);
        $dataLama = mysqli_fetch_assoc($resultData);

        mysqli_stmt_close($stmtData);

        if (!$dataLama) {
            SendResponse('error', 'Data poliklinik tidak ditemukan.');
        }

        // Validasi duplikasi nama poliklinik
        if ($poliklinik !== trim($dataLama['poliklinik'])) {

            $stmtCheck = mysqli_prepare(
                $Conn,
                "SELECT id_poliklinik
                FROM poliklinik
                WHERE poliklinik = ?
                AND id_poliklinik != ?
                LIMIT 1"
            );

            if (!$stmtCheck) {
                throw new Exception('Gagal menyiapkan validasi nama poliklinik.');
            }

            mysqli_stmt_bind_param(
                $stmtCheck,
                "si",
                $poliklinik,
                $id_poliklinik
            );

            mysqli_stmt_execute($stmtCheck);

            $resultCheck = mysqli_stmt_get_result($stmtCheck);
            $duplikat = mysqli_num_rows($resultCheck) > 0;

            mysqli_stmt_close($stmtCheck);

            if ($duplikat) {
                SendResponse('error', 'Nama poliklinik sudah digunakan.');
            }
        }

        // Update data poliklinik
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

        // Simpan log aktivitas
        SaveLog(
            $Conn,
            (int) $SessionIdAkses,
            (string) $SessionNama,
            'Edit Referensi Poliklinik',
            [
                'id_poliklinik' => $id_poliklinik,
                'poliklinik'    => $poliklinik,
                'kode'          => $kode,
                'status'        => $status
            ]
        );

        // Response berhasil
        SendResponse('success', 'Data poliklinik berhasil diperbarui.');

    } catch (Throwable $e) {

        error_log(
            'Update Poliklinik Error: ' . $e->getMessage()
        );

        SendResponse('error', 'Terjadi kesalahan saat memperbarui data poliklinik.');
    }
