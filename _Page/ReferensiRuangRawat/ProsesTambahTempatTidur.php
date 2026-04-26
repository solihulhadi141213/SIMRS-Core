<?php
    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi, Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Header JSON
    header('Content-Type: application/json');

    // =====================
    // VALIDASI SESSION
    // =====================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Session login tidak valid, silahkan login ulang.'
        ]);
        exit;
    }

    // =====================
    // VALIDASI METHOD
    // =====================
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Metode request tidak valid.'
        ]);
        exit;
    }

    // =====================
    // AMBIL & SANITASI DATA
    // =====================
    $id_ruang_rawat = !empty($_POST['id_ruang_rawat']) 
        ? validateAndSanitizeInput($_POST['id_ruang_rawat']) 
        : '';

    $tempat_tidur = !empty($_POST['tempat_tidur']) 
        ? strtoupper(trim(validateAndSanitizeInput($_POST['tempat_tidur'])))
        : '';

    $kategori = !empty($_POST['kategori_tempat_tidur']) 
        ? $_POST['kategori_tempat_tidur'] 
        : '';

    $status = !empty($_POST['status']) ? 1 : 0;

    // =====================
    // VALIDASI INPUT
    // =====================
    if (empty($id_ruang_rawat)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID ruang rawat tidak valid.'
        ]);
        exit;
    }

    if (empty($tempat_tidur)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Nama tempat tidur tidak boleh kosong.'
        ]);
        exit;
    }

    if (empty($kategori)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Kategori tempat tidur wajib dipilih.'
        ]);
        exit;
    }

    // =====================
    // KONVERSI KATEGORI
    // =====================
    $pria   = 0;
    $wanita = 0;
    $bebas  = 0;

    if (isset($_POST['kategori_tempat_tidur'])) {
        if ($_POST['kategori_tempat_tidur'] == 'pria') {
            $pria = 1;
        } elseif ($_POST['kategori_tempat_tidur'] == 'wanita') {
            $wanita = 1;
        } elseif ($_POST['kategori_tempat_tidur'] == 'bebas') {
            $bebas = 1;
        }
    }

    // =====================
    // AMBIL id_kelas_rawat DARI RUANG
    // =====================
    $getKelas = $Conn->prepare("
        SELECT id_kelas_rawat 
        FROM rr_ruang_rawat 
        WHERE id_ruang_rawat = ?
    ");
    $getKelas->bind_param("i", $id_ruang_rawat);
    $getKelas->execute();
    $resultKelas = $getKelas->get_result();

    if ($resultKelas->num_rows == 0) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Ruang rawat tidak ditemukan.'
        ]);
        exit;
    }

    $dataKelas = $resultKelas->fetch_assoc();
    $id_kelas_rawat = $dataKelas['id_kelas_rawat'];
    $getKelas->close();

    // =====================
    // CEK DUPLIKAT
    // =====================
    $cek = $Conn->prepare("
        SELECT id_tempat_tidur 
        FROM rr_tempat_tidur 
        WHERE tempat_tidur = ? 
        AND id_ruang_rawat = ?
    ");
    $cek->bind_param("si", $tempat_tidur, $id_ruang_rawat);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Nama tempat tidur sudah ada di ruangan ini.'
        ]);
        exit;
    }
    $cek->close();

    // =====================
    // INSERT DATA
    // =====================
    $updatetime = date('Y-m-d H:i:s');

    try {

        $stmt = $Conn->prepare("
            INSERT INTO rr_tempat_tidur (
                id_kelas_rawat,
                id_ruang_rawat,
                tempat_tidur,
                pria,
                wanita,
                bebas,
                status,
                updatetime
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param("iisiiiis",
            $id_kelas_rawat,
            $id_ruang_rawat,
            $tempat_tidur,
            $pria,
            $wanita,
            $bebas,
            $status,
            $updatetime
        );

        if ($stmt->execute()) {

            echo json_encode([
                'status'           => 'success',
                'message'          => 'Tempat tidur berhasil ditambahkan.',
                'id_ruang_rawat'   => $id_ruang_rawat,
                'id_kelas_rawat'   => $id_kelas_rawat
            ]);

        } else {

            echo json_encode([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data.'
            ]);
        }

        $stmt->close();

    } catch (Exception $e) {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
?>