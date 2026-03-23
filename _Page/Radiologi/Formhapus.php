<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "FungsiRadiologi.php";

    // Validasi Akses
    if(empty($_SESSION['id_akses'])){
        echo '<div class="alert alert-danger text-center">Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</div>';
        exit;
    }

    // Validasi Data yang Wajib Terisi Atau Ada
    if(empty($_POST['id_radiologi'])){
        echo '<div class="alert alert-danger text-center">ID Radiologi Tidak Boleh Kosong!</div>';
        exit;
    }

    // Buat Variabel
    $id_radiologi = $_POST['id_radiologi'];
    // Ambil token Radix
    $tokenData = getRadixToken($Conn);

    if ($tokenData['status'] !== 'success') {
        echo '<div class="alert alert-danger text-center">'.$tokenData['message'].'</div>';
        exit;
    }

    $token   = $tokenData['token'];
    $baseUrl = $tokenData['base_url'];

    // Call API Pemeriksaan
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $baseUrl . "/_API/ListOrder?keyword_by=id_radiologi&keyword=$id_radiologi&limit=1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $token"
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    $result = json_decode($response, true);

    // Validasi API Response
    if (empty($result)) {
        echo '<div class="alert alert-danger text-center">Gagal Mengambil Data</div>';
        exit;
    }
    if ($result['status'] !== 'success') {
        echo '<div class="alert alert-danger text-center">'.$result['message'].'</div>';
        exit;
    }

    $data = $result['data'] ?? [];

    // Jika kosong
    if (count($data) === 0) {
        echo '<div class="alert alert-danger text-center">Data Tidak Ditemukan</div>';
        exit;
    }

    foreach ($data as $row) {

    // Menampilkan Data
        echo '
            <input type="hidden" name="id_radiologi" value="'.$row['id_radiologi'].'">
            <div class="row mb-2">
                <div class="col-4 text-dark">ID Radiologi</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['id_radiologi'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Accession Number</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['accession_number'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Tanggal</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['datetime_diminta'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Priority</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['priority'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Asal Kiriman</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['asal_kiriman'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Modality</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['alat_pemeriksa'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Dokter Pengirim</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['nama_dokter_pengirim'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Status</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['status_pemeriksaan'].'</div>
            </div>
        ';
        if($row['status_pemeriksaan']!=="Diminta"){
            echo '
                 <div class="row mb-2">
                    <div class="col-12">
                        <div class="alert alert-danger">
                            Data Pemeriksaan Ini Tidak Bisa Dibatalkan / Dihapus Karena Sudah Melalui Moderasi Petugas Radiologi!
                        </div>
                    </div>
                </div>
                <script>$("#ButtonHapus").hide();</script>
            ';
        }else{
            echo '
                 <div class="row mb-2">
                    <div class="col-12">
                        <div class="alert alert-info">
                            Apakah Anda Yakin Akan Menghapus / Membatalkan Pemeriksaan Ini?
                        </div>
                    </div>
                </div>
                <script>$("#ButtonHapus").show();</script>
            ';
        }
    }
?>