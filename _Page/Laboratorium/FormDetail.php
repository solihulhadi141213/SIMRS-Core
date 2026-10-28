<?php
    
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // VValidasi Sesi Akses
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>
                    <b>Opss!</b> Sesi Akses Sudah Berakhir! Silahkan Login Ulang!
                </small>
            </div>
        ';
        exit;
    }

    // Validasi id_laboratorium
    if(empty($_POST['id_laboratorium'])){
        echo '
            <div class="alert alert-danger text-center">
                <small>
                    <b>Opss!</b> ID Laboratorium Tidak Boleh Kosong
                </small>
            </div>
        ';
        exit;
    }

    //limit
    $id_laboratorium       = $_POST['id_laboratorium'];
   
    // Buka Pengaturan Analyza yang aktif
    $status_setting = 1;
    $query          = "SELECT * FROM setting_analyza WHERE status = ?";
    $stmt           = mysqli_prepare($Conn, $query);
    if (!$stmt) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Gagal <i>prepare query</i> saat membuka setting koneksi Analyza</small>
            </div>
        ';
        exit;
    }
    mysqli_stmt_bind_param($stmt, "i", $status_setting);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$result || mysqli_num_rows($result) == 0) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Gagal <i>prepare query</i> saat membuka setting koneksi Analyza</small>
            </div>
        ';
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
            echo '
                <div class="alert alert-danger text-center">
                    <small>Gagal menghubungi API!<br>Error: '.$curl_error.'</small>
                </div>
            ';
            exit;
        }

        // Decode JSON
        $response_array = json_decode($response, true);

        // Validasi JSON Response
        if (!$response_array) {
            echo '
                <div class="alert alert-danger text-center">
                    <small>Response API tidak valid!<br>Raw Response: '.$response.'</small>
                </div>
            ';
            exit;
        }

        // Validasi status sukses
        if ($response_array['status'] !== 'success') {
            echo '
                <div class="alert alert-danger text-center">
                    <small>Gagal membuat token!<br>Pesan: '.$response_array['message'].'</small>
                </div>
            ';
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
            echo '
                <div class="alert alert-danger text-center">
                    <small>Gagal menyimpan token ke database!<br>Error: '.$Conn->error.'</small>
                </div>
            ';
            $Update->close();
            mysqli_stmt_close($stmt);
            exit;
        }
        $Update->close();
        mysqli_stmt_close($stmt);
    }


    // Request List Pemeriksaan
    $url_request = $base_url . '/_API/DetailPemeriksaan.php?' . http_build_query([
        'id_laboratorium'      => $id_laboratorium
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

    // Apabila CURL Error
    if ($curl_error) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Gagal Menyiapkan CURL!<br>Error: '.$curl_error.'</small>
            </div>
        ';
        exit;
    }

    // Extract data $response
    $response_array = json_decode($response, true);
    if (!is_array($response_array)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Response API tidak valid.</small>
            </div>
        ';
        exit;
    }

    $status  = $response_array['status'];
    $message = $response_array['message'];
    $detail  = $response_array['detail'];
    $rincian = $response_array['rincian'];

    // Jika Response Bukan success
    if($status!=='success'){
        echo '
            <div class="alert alert-danger text-center">
                <small>Data Tidak Ditampilkan!<br>Error: '.$message.'</small>
            </div>
        ';
        exit;
    }

    // Identitas pasien
    // echo ''.$response.'';
    echo '
        <div class="row mb-2">
            <div class="col-12">
                <small>
                    <b>A. Identitas Pasien</b>
                </small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>No.RM</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['id_pasien'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>IHS Pasien</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['ihs_pasien'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Nama Lengkap</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['nama'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Gender</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['gender'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Tanggal Lahir</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['tanggal_lahir'].'</small></div>
        </div>

        <div class="row mt-3 mb-2">
            <div class="col-12">
                <small>
                    <b>B. Informasi Kunjungan</b>
                </small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>ID Kunjungan</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['id_kunjungan'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>ID Encounter</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['id_encounter'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Tujuan Kunjungan</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['tujuan'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Pembayaran</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['pembayaran'].'</small></div>
        </div>

        <div class="row mt-3 mb-2">
            <div class="col-12">
                <small>
                    <b>C. Permintaan Laboratorium</b>
                </small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Faskes</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['fakses'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Poli/Unit/Ruangan</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['unit'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small><i>Priority</i></small></div>
            <div class="col-7"><small class="text-muted">'.$detail['priority'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Petugas Laboratorium</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['nama_petugas'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Dokter Pengirim</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['nama_dokter_pengirim'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Dokter Penerima</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['nama_dokter_penerima'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Diagnosis</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['diagnosis']['code'].' - '.$detail['diagnosis']['display'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Keterangan</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['keterangan'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Status Permintaan</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['status'].'</small></div>
        </div>
        <div class="row mt-3 mb-2">
            <div class="col-12">
                <small>
                    <b>D. Waktu Pelayanan</b>
                </small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Diminta</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['datetime_diminta'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Diterima</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['datetime_diterima'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Pengambilan Spesimen</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['datetime_spesimen'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Keluar Hasil</small></div>
            <div class="col-7"><small class="text-muted">'.$detail['datetime_hasil'].'</small></div>
        </div>
        <div class="row mt-3 mb-2">
            <div class="col-12">
                <small>
                    <b>E. Rincian Pemeriksaan</b>
                </small>
            </div>
        </div>
    ';
?>
<div class="row">
    <div class="col-12">
        <div class="table table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th><small><b>No</b></small></th>
                        <th><small><b>Pemeriksaan</b></small></th>
                        <th><small><b>Kategori</b></small></th>
                        <th><small><b>Hasil</b></small></th>
                        <th><small><b>Interpertasi</b></small></th>
                        <th><small><b>Kesimpulan</b></small></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($rincian)){
                            echo '
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <small class="text-danger">Tidak Ada Rincian</small>
                                    </td>
                                </tr>
                            ';
                        }else{
                            $no = 1;
                            foreach ($rincian as $rincian_list) {
                                echo '
                                    <tr>
                                        <td class="text-center"><small class="text-muted">'.$no.'</small></td>
                                        <td class="text-left"><small class="text-muted">'.$rincian_list['nama_pemeriksaan'].'</small></td>
                                        <td class="text-left"><small class="text-muted">'.$rincian_list['category_pemeriksaan'].'</small></td>
                                        <td class="text-left"><small class="text-muted">'.$rincian_list['hasil'].' '.$rincian_list['unit_code'].'</small></td>
                                        <td class="text-left"><small class="text-muted">'.$rincian_list['interpertasi'].'</small></td>
                                        <td class="text-left"><small class="text-muted">'.$rincian_list['conclusion'].'</small></td>
                                    </tr>
                                ';
                                $no++;
                            }
                        }
                    ?>
                </tbody>
                
            </table>
        </div>
    </div>
</div>
