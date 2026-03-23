<?php
    // Mulai sesi jika belum dimulai
    session_start();
    // Include koneksi ke database dan fungsi global
    include_once '../../_Config/Connection.php';
    include_once '../../_Config/SimrsFunction.php';
    // Set timezone dan header untuk output JSON
    date_default_timezone_set('Asia/Jakarta');
    $datetime_creat=date('Y-m-d H:i:s');
    $datetime_update=date('Y-m-d H:i:s');
    header('Content-Type: application/json');
    // Cek apakah data yang diperlukan dikirim via POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ambil api_name dan password dari POST
        $id_api_access = isset($_POST['id_api_access']) ? trim($_POST['id_api_access']) : '';
        $api_name = isset($_POST['api_name']) ? trim($_POST['api_name']) : '';
        $api_description = isset($_POST['api_description']) ? trim($_POST['api_description']) : '';
        $client_id = isset($_POST['client_id']) ? trim($_POST['client_id']) : '';
        $client_key = isset($_POST['client_key']) ? trim($_POST['client_key']) : '';
        $expired_duration = isset($_POST['expired_duration']) ? trim($_POST['expired_duration']) : '';
        // Validasi input
        if (empty($id_api_access)) {
            echo json_encode([
                'status' => 400,
                'message' => 'ID API Key tidak boleh kosong.'
            ]);
            exit;
        }
        if (empty($api_name)) {
            echo json_encode([
                'status' => 400,
                'message' => 'Nama API Key tidak boleh kosong.'
            ]);
            exit;
        }
        if (empty($client_id)) {
            echo json_encode([
                'status' => 400,
                'message' => 'Client ID tidak boleh kosong.'
            ]);
            exit;
        }
        if (empty($client_key)) {
            echo json_encode([
                'status' => 400,
                'message' => 'Client Key tidak boleh kosong.'
            ]);
            exit;
        }
        if (empty($expired_duration)) {
            echo json_encode([
                'status' => 400,
                'message' => 'Durasi Expired tidak boleh kosong.'
            ]);
            exit;
        }
        //Membersihkan Variabel
        $id_api_access=validateAndSanitizeInput($id_api_access);
        $api_name=validateAndSanitizeInput($api_name);
        $api_description=validateAndSanitizeInput($api_description);
        $client_id=validateAndSanitizeInput($client_id);
        $client_key=validateAndSanitizeInput($client_key);
        //Simpan Data
        $UpdateApiKey = mysqli_query($Conn,"UPDATE api_access SET 
            api_name='$api_name',
            api_description='$api_description',
            client_id='$client_id',
            client_key='$client_key',
            expired_duration='$expired_duration',
            datetime_update='$datetime_update'
        WHERE id_api_access='$id_api_access'") or die(mysqli_error($Conn)); 
        if($UpdateApiKey){
            // Respons jika login berhasil
            echo json_encode([
                'status' => 200,
                'message' => 'Success'
            ]);
        }else{
            // Respons jika login berhasil
            echo json_encode([
                'status' => 500,
                'message' => 'Terjadi kesalahan pada saat menyimpan data.'
            ]);
        }
    } else {
        // Respons jika metode request bukan POST
        echo json_encode([
            'status' => 405,
            'message' => 'Metode request tidak diizinkan.'
        ]);
    }
    // Tutup koneksi
    $Conn->close();
?>