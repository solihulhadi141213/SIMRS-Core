<?php
    
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";
    
    //inisiasi Variabe;
    $JmlHalaman = 0;
    $page       = 1;
    $total_page = 1;
    $total_data = 0;
    $html       = "";

    // VValidasi Sesi Akses
    if (empty($SessionIdAkses)) {
        echo json_encode([
            "status" => "error",
            "html"   => '
                <tr>
                    <td colspan="8" class="text-center text-danger">
                        <small>Sesi akses sudah berakhir. Silakan login ulang.</small>
                    </td>
                </tr>
            ',
            "page" => 1,
            "total_page" => 1,
            "total_data" => 0
        ]);
        exit;
    }

    //limit
    $page       = $_POST['page'] ?? 1;
    $limit      = $_POST['limit'] ?? 10;
    $order_by   = $_POST['order_by'] ?? 'datetime_diminta';
    $short_by   = $_POST['short_by'] ?? 'DESC';
    $keyword_by = $_POST['keyword_by'] ?? '';
    $keyword    = trim($_POST['keyword'] ?? '');

    // Buka Pengaturan Analyza yang aktif
    $status_setting = 1;
    $query          = "SELECT * FROM setting_analyza WHERE status = ?";
    $stmt           = mysqli_prepare($Conn, $query);
    if (!$stmt) {
        echo json_encode([
            "status" => "error",
            "html"   => '
                <tr>
                    <td colspan="8" class="text-center text-danger">
                        <small>Gagal <i>prepare query</i> saat membuka setting koneksi Analyza</small>
                    </td>
                </tr>
            ',
            "page" => 1,
            "total_page" => 1,
            "total_data" => 0
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
                    <td colspan="8" class="text-center text-danger">
                        <small>Gagal <i>prepare query</i> saat membuka setting koneksi Analyza</small>
                    </td>
                </tr>
            ',
            "page" => 1,
            "total_page" => 1,
            "total_data" => 0
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
        curl_close($curl);

        // Validasi CURL Error
        if ($curl_error) {
            echo json_encode([
                "status" => "error",
                "html"   => '
                    <tr>
                        <td colspan="8" class="text-center text-danger">
                            <small>Gagal menghubungi API!<br>Error: '.$curl_error.'</small>
                        </td>
                    </tr>
                ',
                "page" => 1,
                "total_page" => 1,
                "total_data" => 0
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
                        <td colspan="8" class="text-center text-danger">
                           <small>Response API tidak valid!<br>Raw Response: '.$response.'</small>
                        </td>
                    </tr>
                ',
                "page" => 1,
                "total_page" => 1,
                "total_data" => 0
            ]);
            exit;
        }

        // Validasi status sukses
        if ($response_array['status'] !== 'success') {
            echo json_encode([
                "status" => "error",
                "html"   => '
                    <tr>
                        <td colspan="8" class="text-center text-danger">
                           <small>Gagal membuat token!<br>Pesan: '.$response_array['message'].'</small>
                        </td>
                    </tr>
                ',
                "page" => 1,
                "total_page" => 1,
                "total_data" => 0
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
                        <td colspan="8" class="text-center text-danger">
                           <small>Gagal menyimpan token ke database!<br>Error: '.$Conn->error.'</small>
                        </td>
                    </tr>
                ',
                "page" => 1,
                "total_page" => 1,
                "total_data" => 0
            ]);
            $Update->close();
            mysqli_stmt_close($stmt);
            exit;
        }
        $Update->close();
        mysqli_stmt_close($stmt);
    }
   
    //Atur Page dan limit
    $page  = (int)$page;
    $limit = (int)$limit;
    if ($page <= 0) {
        $page = 1;
    }
    if ($limit <= 0) {
        $limit = 10;
    }
    $posisi = ($page - 1) * $limit;

    // Request List Pemeriksaan
    $url_request = $base_url . '/_API/ListPemeriksaan.php?' . http_build_query([
        'limit'      => $limit,
        'order_by'   => $order_by,
        'short_by'   => $short_by,
        'keyword_by' => $keyword_by,
        'keyword'    => $keyword,
        'page'       => $page
    ]);

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
     curl_close($curl);

    // Apabila CURL Error
    if ($curl_error) {
        echo json_encode([
            "status" => "error",
            "html"   => '
                <tr>
                    <td colspan="8" class="text-center text-danger">
                        <small>Gagal Menyiapkan CURL!<br>Error: '.$curl_error.'</small>
                    </td>
                </tr>
            ',
            "page" => 1,
            "total_page" => 1,
            "total_data" => 0
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
                    <td colspan="8" class="text-center text-danger">
                        <small>Response API tidak valid.</small>
                    </td>
                </tr>
            ',
            "page" => 1,
            "total_page" => 1,
            "total_data" => 0
        ]);
        exit;
    }

    $status         = $response_array['status'];
    $message        = $response_array['message'];
    $limit          = $response_array['limit'];
    $current_page   = $response_array['current_page'];
    $total_page     = $response_array['total_page'];
    $data_list      = $response_array['data_list'];
    $jumlah_data    = $response_array['jumlah_data'];

    // Jika Response Bukan success
    if($status!=='success'){
        echo json_encode([
            "status" => "error",
            "html"   => '
                <tr>
                    <td colspan="8" class="text-center text-danger">
                        <small>Data Tidak Ditampilkan!<br>Error: '.$message.'</small>
                    </td>
                </tr>
            ',
            "page" => 1,
            "total_page" => 1,
            "total_data" => 0
        ]);
        exit;
    }

    $no = 1+$posisi;
    foreach ($data_list AS $record) {

        $id_laboratorium      = $record['id_laboratorium'];
        $id_pasien            = $record['id_pasien'];
        $nama                 = $record['nama'];
        $priority             = $record['priority'];
        $nama_dokter_pengirim = $record['nama_dokter_pengirim'];
        $status               = $record['status'];
        $datetime_diminta     = $record['datetime_diminta'];

        // priority
        if($priority=="routine"){
            $label_priority = '<span class="badge badge-success">Biasa</span>';
        }else{
            if($priority=="urgent"){
                $label_priority = '<span class="badge badge-warning">Segera</span>';
            }else{
                $label_priority = '<span class="badge badge-danger">Darurat</span>';
            }
        }

        // Status
        if($status=="Diminta"){
            $label_status = '
                <a href="javascript:void(0);" class="modal_terima_pemeriksaan" data-id="'.$id_laboratorium.'">
                    <span class="badge bg-danger">Diminta</span>
                </a>
            ';
        }else{
            if($status=="Ditolak"||$status=="Dibatalkan"){
                $label_status = '<span class="badge bg-secondary" title="Pemeriksaan Dibatalkan">Batal</span>';
            }else{
                if($status=="Diterima"){
                    $label_status = '<span class="badge bg-info" title="Pemeriksaan Diterima">Diterima</span>';
                }else{
                    if($status=="Pengambilan Spesimen"){
                        $label_status = '<span class="badge bg-warning" title="Pengambilan Spesimen">Diterima</span>';
                    }else{
                        if($status=="Pemeriksaan Spesimen"){
                            $label_status = '<span class="badge bg-primary" title="Pemeriksaan Spesimen">Diterima</span>';
                        }else{
                            if($status=="Keluar Hasil"){
                                $label_status = '<span class="badge bg-success" title="Keluar Hasil">Diterima</span>';
                            }else{
                                if($status=="Selesai"){
                                    $label_status = '<span class="badge bg-success" title="Selesai">Selesai</span>';
                                }else{
                                    $label_status = '<span class="badge bg-dark">None</span>';
                                }
                            }
                            
                        }
                    }
                }
            }
        }


        $html .= '
            <tr>
                <td align="center"><small>'.$no.'</small></td>
                <td align="left"><small>'.$id_pasien.'</small></td>
                <td align="left">
                    <a href="javascript:void(0);" class="modal_detail text-primary" data-id="'.$id_laboratorium.'">
                        <small>'.$nama.'</small>
                    </a>
                </td>
                <td align="left"><small>'.$datetime_diminta.'</small></td>
                <td align="left"><small>'.$nama_dokter_pengirim.'</small></td>
                <td align="center"><small>'.$label_priority.'</small></td>
                <td align="center"><small>'.$label_status.'</small></td>
                <td align="center">
                    <a href="javascript:void(0);" class="btn-sm btn-floating" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                        <li class="dropdown-header text-start">
                            <h6>Option</h6>
                        </li>
                        <li>
                            <a class="dropdown-item modal_detail" href="javascript:void(0)" data-id="'.$id_laboratorium.'">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item modal_edit" href="javascript:void(0)" data-id="'.$id_laboratorium.'">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item modal_hapus" href="javascript:void(0)" data-id="'.$id_laboratorium.'">
                                <i class="bi bi-x"></i> Hapus
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
        ';
        $no++;
    }
    
      
    echo json_encode([
        "status"     => "success",
        "html"       => $html,
        "page"       => $current_page,
        "total_page" => $total_page,
        "total_data" => $jumlah_data
    ]);
?>
