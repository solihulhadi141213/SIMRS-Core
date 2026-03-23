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
            <div class="row mb-2">
                <div class="col-12 text-dark">
                    <dt>A. Informasi Pasien</dt>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">No.RM</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['id_pasien'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Nama Pasien</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['nama_pasien'].'</div>
            </div>

            <div class="row mb-2 mt-3 border-1 border-top">
                <div class="col-12 text-dark">
                    <dt>B. Informasi Kunjungan</dt>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">ID Kunjungan</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['id_kunjungan'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Kunjungan</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['tujuan'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Pembayaran</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['pembayaran'].'</div>
            </div>

            <div class="row mb-2 mt-3 border-1 border-top">
                <div class="col-12 text-dark">
                    <dt>C. Informasi Radiologi</dt>
                </div>
            </div>
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
                <div class="col-4 text-dark">Keterangan</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['pesan'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Status</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['status_pemeriksaan'].'</div>
            </div>
            
            <div class="row mb-2 mt-3 border-1 border-top">
                <div class="col-12 text-dark">
                    <dt>D. Dokter Pengirim</dt>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Nama Dokter</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['nama_dokter_pengirim'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Kode Dokter</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['kode_dokter_pengirim'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">IHS Dokter</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['ihs_dokter_pengirim'].'</div>
            </div>

            <div class="row mb-2 mt-3 border-1 border-top">
                <div class="col-12 text-dark">
                    <dt>E. Dokter Penerima</dt>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Nama Dokter</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['nama_dokter_penerima'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Kode Dokter</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['kode_dokter_penerima'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">IHS Dokter</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['ihs_dokter_penerima'].'</div>
            </div>

            <div class="row mb-2 mt-3 border-1 border-top">
                <div class="col-12 text-dark">
                    <dt>F. Klinis Pasien</dt>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Klinis</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['klinis'][0]['nama_klinis'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Kategori</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['klinis'][0]['kategori'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Code</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['klinis'][0]['snomed_code'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Display</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['klinis'][0]['snomed_display'].'</div>
            </div>

            <div class="row mb-2 mt-3 border-1 border-top">
                <div class="col-12 text-dark">
                    <dt>G. Permintaan Pemeriksaan</dt>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Pemeriksaan</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['permintaan_pemeriksaan'][0]['nama_pemeriksaan'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Deskripsi</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['permintaan_pemeriksaan'][0]['pemeriksaan_description'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Code</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['permintaan_pemeriksaan'][0]['pemeriksaan_code'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">System</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['permintaan_pemeriksaan'][0]['pemeriksaan_sys'].'</div>
            </div>

            <div class="row mb-2 mt-3 border-bottom-inverse border-top">
                <div class="col-12 text-dark">
                    <dt>H. Body Site</dt>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Deskripsi</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['permintaan_pemeriksaan'][0]['bodysite_description'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">Code</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['permintaan_pemeriksaan'][0]['bodysite_code'].'</div>
            </div>
            <div class="row mb-2">
                <div class="col-4 text-dark">System</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$row['permintaan_pemeriksaan'][0]['bodysite_sys'].'</div>
            </div>
        ';
    }
?>