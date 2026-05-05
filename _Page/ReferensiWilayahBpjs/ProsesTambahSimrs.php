<?php
    // Header Format
    header('Content-Type: application/json');

    // Connection
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";
    
    // Session Access Validation
    if (empty($SessionIdAkses)) {
        $response = [
            "status"  => "Error",
            "message" => "Sesi Akses Sudah Berakhir! Silahkan Login Ulang"
        ];
        echo json_encode($response);
        exit;
    }

    // Validasi Data Mandatory
    if (empty($_POST['kode_bpjs1'])) {
        $response = [
            "status"  => "Error",
            "message" => "Kode Provinsi BPJS Tidak Boleh Kosong!"
        ];
        echo json_encode($response);
        exit;
    }
    if (empty($_POST['kode_bpjs2'])) {
        $response = [
            "status"  => "Error",
            "message" => "Kode Kabupaten/Kota BPJS Tidak Boleh Kosong!"
        ];
        echo json_encode($response);
        exit;
    }
    if (empty($_POST['kode_bpjs3'])) {
        $response = [
            "status"  => "Error",
            "message" => "Kode Kecamatan BPJS Tidak Boleh Kosong!"
        ];
        echo json_encode($response);
        exit;
    }
    if (empty($_POST['province'])) {
        $response = [
            "status"  => "Error",
            "message" => "Pilih Provinsi Terlebih Dulu!"
        ];
        echo json_encode($response);
        exit;
    }
    if (empty($_POST['regency'])) {
        $response = [
            "status"  => "Error",
            "message" => "Pilih Kabupaten/Kota Terlebih Dulu!"
        ];
        echo json_encode($response);
        exit;
    }
    if (empty($_POST['subdistrict'])) {
        $response = [
            "status"  => "Error",
            "message" => "Pilih Kecamatan Terlebih Dulu!"
        ];
        echo json_encode($response);
        exit;
    }

    // Buat Variabel
    $kode_bpjs1  = $_POST['kode_bpjs1'];
    $kode_bpjs2  = $_POST['kode_bpjs2'];
    $kode_bpjs3  = $_POST['kode_bpjs3'];
    $province    = $_POST['province'];
    $regency     = $_POST['regency'];
    $subdistrict = $_POST['subdistrict'];

    // Memastikan province, regency dan subdistrict ada pada database
    $query = "SELECT * FROM wilayah 
          WHERE province = ? 
          AND regency = ? 
          AND subdistrict = ? 
          LIMIT 1";
    $stmt = mysqli_prepare($Conn, $query);
    if (!$stmt) {
        $response = [
            "status"  => "Error",
            "message" => "Terjadi Kesalahan Pada Saat Validasi Wilayah Yang Dipilih"
        ];
        echo json_encode($response);
        exit;
    }
    mysqli_stmt_bind_param($stmt, "sss", $province, $regency, $subdistrict);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        mysqli_stmt_close($stmt);
        $response = [
            "status"  => "Error",
            "message" => "Wilayah Yang Anda Pilih Tidak Ditemukan!"
        ];
        echo json_encode($response);
        exit;
    }
    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    $id_wilayah = htmlspecialchars($data['id_wilayah'] ?? '');

    // Update kode_bpjs1 -> Province
    $query_update_province = "UPDATE wilayah SET kode_bpjs1 = ? WHERE province = ?";
    $stmt_update_province = mysqli_prepare($Conn, $query_update_province);
    if (!$stmt_update_province) {
         $response = [
            "status"  => "Error",
            "message" => "Terjadi Kesalahan Pada Saat Update Province!"
        ];
        echo json_encode($response);
        exit;
    }
    mysqli_stmt_bind_param($stmt_update_province,"ss",$kode_bpjs1,$province);
    if (!mysqli_stmt_execute($stmt_update_province)) {
        mysqli_stmt_close($stmt_update_province);
        $response = [
            "status"  => "Error",
            "message" => "Terjadi Kesalahan Pada Saat Update Province!"
        ];
        echo json_encode($response);
        exit;
    }
    mysqli_stmt_close($stmt_update_province);

    // Update kode_bpjs2 -> Regency
    $query_update_regency = "UPDATE wilayah SET kode_bpjs2 = ? WHERE regency = ?";
    $stmt_update_regency = mysqli_prepare($Conn, $query_update_regency);
    if (!$stmt_update_regency) {
        $response = [
            "status"  => "Error",
            "message" => "Terjadi Kesalahan Pada Saat Updaate Kabupaten/Kota!"
        ];
        echo json_encode($response);
        exit;
    }
    mysqli_stmt_bind_param($stmt_update_regency,"ss",$kode_bpjs2,$regency);
    if (!mysqli_stmt_execute($stmt_update_regency)) {
        mysqli_stmt_close($stmt_update_regency);
        $response = [
            "status"  => "Error",
            "message" => "Terjadi Kesalahan Pada Saat Updaate Kabupaten/Kota!"
        ];
        echo json_encode($response);
        exit;
    }
    mysqli_stmt_close($stmt_update_regency);

    // Update kode_bpjs3 -> Subdistrict
    $query_update_subdistrict = "UPDATE wilayah SET kode_bpjs3 = ? WHERE subdistrict = ?";
    $stmt_update_subdistrict = mysqli_prepare($Conn, $query_update_subdistrict);
    if (!$stmt_update_regency) {
        $response = [
            "status"  => "Error",
            "message" => "Terjadi Kesalahan Pada Saat Updaate Kecamatan!"
        ];
        echo json_encode($response);
        exit;
    }
    mysqli_stmt_bind_param($stmt_update_subdistrict,"ss",$kode_bpjs3,$subdistrict);
    if (!mysqli_stmt_execute($stmt_update_subdistrict)) {
        mysqli_stmt_close($stmt_update_subdistrict);
        $response = [
            "status"  => "Error",
            "message" => "Terjadi Kesalahan Pada Saat Updaate Kecamatan!"
        ];
        echo json_encode($response);
        exit;
    }
    mysqli_stmt_close($stmt_update_subdistrict);


    // ================== RESPONSE DEFAULT ==================
    $response = [
        "status"  => "success",
        "message" => "Update Data Berhasil"
    ];
    echo json_encode($response);
    exit;
?>