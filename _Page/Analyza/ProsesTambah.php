<?php
    // Koneksi dan Function
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');

    // Validasi Session Akses
    if(empty($_SESSION['id_akses'])){
        echo json_encode([
            'status' => 'error',
            'message' => 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang!'
        ]);
        exit;
    }

    // ==========================
    // AMBIL & SANITASI INPUT
    // ==========================
    $setting_name = isset($_POST['setting_name']) 
        ? trim(htmlspecialchars($_POST['setting_name'])) 
        : '';

    $base_url = isset($_POST['base_url']) 
        ? trim(htmlspecialchars($_POST['base_url'])) 
        : '';

    $setting_username = isset($_POST['setting_username']) 
        ? trim(htmlspecialchars($_POST['setting_username'])) 
        : '';

    $setting_password = isset($_POST['setting_password']) 
        ? trim(htmlspecialchars($_POST['setting_password'])) 
        : '';

    $setting_status = isset($_POST['setting_status']) 
        ? (int) $_POST['setting_status'] 
        : 0;

    // ==========================
    // VALIDASI INPUT
    // ==========================

    // 1. Nama koneksi
    if ($setting_name == '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Nama koneksi tidak boleh kosong!'
        ]);
        exit;
    }

    // 2. URL
    if ($base_url == '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'URL API tidak boleh kosong!'
        ]);
        exit;
    }

    if ($setting_username == '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Username tidak boleh kosong!'
        ]);
        exit;
    }

    if ($setting_password == '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Password tidak boleh kosong!'
        ]);
        exit;
    }

    if (!filter_var($base_url, FILTER_VALIDATE_URL)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Format URL Analyza tidak valid!'
        ]);
        exit;
    }

    // Mulai transaksi untuk memastikan konsistensi data
    $Conn->begin_transaction();

    try {
        // ==========================
        // NONAKTIFKAN SEMUA KONEKSI LAIN JIKA STATUS = 1
        // ==========================
        if ($setting_status == 1) {
            $sql_deactivate = "UPDATE setting_analyza SET status = 0";
            $stmt_deactivate = $Conn->prepare($sql_deactivate);
            
            if (!$stmt_deactivate) {
                throw new Exception('Gagal menyiapkan query untuk menonaktifkan koneksi lain!');
            }
            
            if (!$stmt_deactivate->execute()) {
                throw new Exception('Gagal menonaktifkan koneksi lain!');
            }
            
            $stmt_deactivate->close();
        }
        
        // ==========================
        // SIMPAN DATA BARU KE DATABASE
        // ==========================
        $sql_insert = "
            INSERT INTO setting_analyza 
            (
                setting_name ,
                base_url ,
                username ,
                password ,
                status
            ) 
            VALUES (?, ?, ?, ?, ?)
        ";
        
        $stmt_insert = $Conn->prepare($sql_insert);
        
        if (!$stmt_insert) {
            throw new Exception('Gagal menyiapkan query untuk menyimpan data!');
        }
        
        $stmt_insert->bind_param(
            "ssssi",
            $setting_name ,
            $base_url ,
            $setting_username ,
            $setting_password ,
            $setting_status
        );
        
        if (!$stmt_insert->execute()) {
            throw new Exception('Gagal menyimpan data ke database!');
        }
        
        // Commit transaksi jika semua berhasil
        $Conn->commit();
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Koneksi berhasil disimpan.'
        ]);
        
        $stmt_insert->close();
        
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi error
        $Conn->rollback();
        
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
        exit;
    }
?>