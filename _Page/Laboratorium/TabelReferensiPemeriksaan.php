<?php
    
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";
    
    //inisiasi Variabe;
    $html       = "";

    // VValidasi Sesi Akses
    if (empty($SessionIdAkses)) {
        echo json_encode([
            "status" => "error",
            "html"   => '
                <tr>
                    <td colspan="5" class="text-center text-danger">
                        <small>Sesi akses sudah berakhir. Silakan login ulang.</small>
                    </td>
                </tr>
            '
        ]);
        exit;
    }

    // Buka Pengaturan Analyza yang aktif
    $status_setting = 1;
    $query          = "SELECT * FROM setting_analyza WHERE status = ?";
    $stmt           = mysqli_prepare($Conn, $query);
    if (!$stmt) {
        echo json_encode([
            "status" => "error",
            "html"   => '
                <tr>
                    <td colspan="5" class="text-center text-danger">
                        <small>Gagal <i>prepare query</i> saat membuka setting koneksi Analyza</small>
                    </td>
                </tr>
            '
        ]);
        exit;
    }
    mysqli_stmt_bind_param($stmt, "i", $status_setting);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$result || mysqli_num_rows($result) == 0) {
        echo json_encode([
            "status" => "error",
            "html"   => '
                <tr>
                    <td colspan="5" class="text-center text-danger">
                        <small>Gagal <i>prepare query</i> saat membuka setting koneksi Analyza</small>
                    </td>
                </tr>
            '
        ]);
        exit;
    }
    $data = mysqli_fetch_assoc($result);

    // Status badge
    $base_url   = $data['base_url'];
    $username   = $data['username'];
    $password   = $data['password'];
    $token      = $data['token'];
    $creat_at   = $data['creat_at'];
    $expired_at = $data['expired_at'];

    // Validasi Expired Token
    $Now = date('Y-m-d H:i:s');
    if ($expired_at <= $Now) {

        // Buat Token Baru

        // Tentukan Url
        $url_request = "$base_url/_API/GenerateToken.php";

        // CURL REQUEST
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url_request,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query([
                'username' => $username,
                'password' => $password
            ]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded'
            ],
        ));

        $response = curl_exec($curl);
        $curl_error = curl_error($curl);

        // Validasi CURL Error
        if ($curl_error) {
            echo json_encode([
                "status" => "error",
                "html"   => '
                    <tr>
                        <td colspan="5" class="text-center text-danger">
                            <small>Gagal menghubungi API!<br>Error: '.$curl_error.'</small>
                        </td>
                    </tr>
                '
            ]);
            exit;
        }

        // Decode JSON
        $response_array = json_decode($response, true);

        // Validasi JSON Response
        if (!$response_array) {
            echo json_encode([
                "status" => "error",
                "html"   => '
                    <tr>
                        <td colspan="5" class="text-center text-danger">
                           <small>Response API tidak valid!<br>Raw Response: '.$response.'</small>
                        </td>
                    </tr>
                '
            ]);
            exit;
        }

        // Validasi status sukses
        if ($response_array['status'] !== 'success') {
            echo json_encode([
                "status" => "error",
                "html"   => '
                    <tr>
                        <td colspan="5" class="text-center text-danger">
                           <small>Gagal membuat token!<br>Pesan: '.$response_array['message'].'</small>
                        </td>
                    </tr>
                '
            ]);
            exit;
        }

        // Ambil data token
        $token      = $response_array['token'];
        $created_at = date('Y-m-d H:i:s', strtotime($response_array['created_at']));
        $expired_at = date('Y-m-d H:i:s', strtotime($response_array['token_expired_at']));

        // UPDATE DATABASE
        $Update = $Conn->prepare("
            UPDATE setting_analyza 
            SET token = ?, creat_at = ?, expired_at = ?, status = 1
            WHERE status = ?
        ");
        $Update->bind_param("sssi", $token, $created_at, $expired_at, $status_setting);
        if (!$Update->execute()) {

            echo json_encode([
                "status" => "error",
                "html"   => '
                    <tr>
                        <td colspan="5" class="text-center text-danger">
                           <small>Gagal menyimpan token ke database!<br>Error: '.$Conn->error.'</small>
                        </td>
                    </tr>
                '
            ]);
            $Update->close();
            mysqli_stmt_close($stmt);
            exit;
        }
        $Update->close();
        mysqli_stmt_close($stmt);
    }
   
    // Request List Pemeriksaan
    $url_request = $base_url . '/_API/ReferensiPemeriksaan.php';
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL            => $url_request,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => '',
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => 'GET',

        // Bearer Token
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $token,
            'Accept: application/json'
        ],
    ]);

    $response = curl_exec($curl);
    $curl_error = curl_error($curl);
    $http_code  = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    // Apabila CURL Error
    if ($curl_error) {
        echo json_encode([
            "status" => "error",
            "html"   => '
                <tr>
                    <td colspan="5" class="text-center text-danger">
                        <small>Gagal Menyiapkan CURL!<br>Error: '.$curl_error.'</small>
                    </td>
                </tr>
            '
        ]);
        exit;
    }

    // Extract data $response
    $response_array = json_decode($response, true);
    if (!is_array($response_array)) {
        echo json_encode([
            "status" => "error",
            "html"   => '
                <tr>
                    <td colspan="5" class="text-center text-danger">
                        <small>Response API tidak valid.</small>
                    </td>
                </tr>
            '
        ]);
        exit;
    }

    $status  = $response_array['status'];
    $message = $response_array['message'];
    $data    = $response_array['data'];

    // Jika Response Bukan success
    if($status!=='success'){
        echo json_encode([
            "status" => "error",
            "html"   => '
                <tr>
                    <td colspan="5" class="text-center text-danger">
                        <small>Data Tidak Ditampilkan!<br>Error: '.$message.'</small>
                    </td>
                </tr>
            '
        ]);
        exit;
    }

    $no = 1;
    foreach ($data AS $data_kategori) {

        $category_pemeriksaan = $data_kategori['category_pemeriksaan'];
        $list_by_category     = $data_kategori['list_by_category'];
       
        $html .= '
            <tr>
                <td>
                    <input type="checkbox" class="cehck_all_sub" id="cehck_all_sub'.$no.'" data-category="'.htmlspecialchars($category_pemeriksaan, ENT_QUOTES).'">
                </td>
                <td align="left" colspan="3">
                    <label for="cehck_all_sub'.$no.'">
                        <small><b>'.$category_pemeriksaan.'</b></small>
                    </label>
                </td>
            </tr>
        ';

        foreach ($list_by_category AS $list_sub) {
            $id_referensi_pemeriksaan = $list_sub['id_referensi_pemeriksaan'];
            $nama_pemeriksaan         = $list_sub['nama_pemeriksaan'];
            $code_pemeriksaan         = $list_sub['code_pemeriksaan'];
            $display_pemeriksaan      = $list_sub['display_pemeriksaan'];
            $unit                     = $list_sub['unit'];

            $html .= '
                <tr>
                    <td></td>
                    <td class="text-center">
                        <input type="checkbox" name="id_referensi_pemeriksaan[]" class="checkbox_pemeriksaan" data-category="'.htmlspecialchars($category_pemeriksaan, ENT_QUOTES).'" id="id_referensi_pemeriksaan'.$id_referensi_pemeriksaan.'" value="'.(int)$id_referensi_pemeriksaan.'">
                    </td>
                    <td class="text-left">
                        <label for="id_referensi_pemeriksaan'.$id_referensi_pemeriksaan.'">
                            <small>'.htmlspecialchars($nama_pemeriksaan).'</small>
                        </label>
                    </td>
                    <td class="text-left">
                        <small><i>'.htmlspecialchars($display_pemeriksaan).'</i></small>
                    </td>
                </tr>
            ';
        }

        $no++;
    }
    
      
    echo json_encode([
        "status"     => "success",
        "html"       => $html
    ]);
?>
