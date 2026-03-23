<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "FungsiLaboratorium.php";

    // Validasi Akses
    if(empty($_SESSION['id_akses'])){
        echo '<div class="alert alert-danger text-center">Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</div>';
        exit;
    }

    // Validasi Data yang Wajib Terisi Atau Ada
    if(empty($_POST['id_laboratorium'])){
        echo '<div class="alert alert-danger text-center">ID Laboratorium Tidak Boleh Kosong!</div>';
        exit;
    }

    // Buat Variabel
    $id_laboratorium = $_POST['id_laboratorium'];

    // Ambil token Radix
    $tokenData = getAnalyzaToken($Conn);

    if ($tokenData['status'] !== 'success') {
        echo '<div class="alert alert-danger text-center">'.$tokenData['message'].'</div>';
        exit;
    }

    $token   = $tokenData['token'];
    $baseUrl = $tokenData['base_url'];

    // Call API Pemeriksaan
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $baseUrl . "/_API/DetailPemeriksaan?id_laboratorium=$id_laboratorium",
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

    $data = $result['detail'] ?? [];

    // Jika kosong
    if (count($data) === 0) {
        echo '<div class="alert alert-danger text-center">Data Tidak Ditemukan</div>';
        exit;
    }

    // membuat variabel Dan Routing Label
    $status = $data['status'];
    $status_list = [
        'Diminta' => '<span class="badge bg-warning">Diminta</span>',
        'Ditolak' => '<span class="badge bg-danger">Ditolak</span>',
        'Dibatalkan'  => '<span class="badge bg-danger">Dibatalkan</span>',
        'Diterima'  => '<span class="badge bg-info">Diterima</span>',
        'Pengambilan Spesimen'  => '<span class="badge bg-secondary">Pengambilan Spesimen</span>',
        'Pemeriksaan Spesimen'  => '<span class="badge bg-secondary">Pemeriksaan Spesimen</span>',
        'Keluar Hasil'  => '<span class="badge bg-primary">Keluar Hasil</span>',
        'Selesai'  => '<span class="badge bg-success">Selesai</span>'
    ];
    $status_label = $status_list[$status] ?? '';

    $prioritas = $data['priority'];
    $priority_color = [
        'routine' => '<span class="badge bg-info">Biasa</code>',
        'urgent'  => '<span class="badge bg-primary">Segera</code>',
        'stat'    => '<span class="badge bg-danger">Segera</code>'
    ];
    $prioritas_label = $priority_color[$prioritas] ?? '';

    // Menghitung Usia Saat Pelayanan
    $tanggal_lahir     = $data['tanggal_lahir'];
    $tanggal_pelayanan = $data['datetime_diminta'];
    $usia = '';
    if (!empty($tanggal_lahir) && !empty($tanggal_pelayanan)) {

        try {
            $lahir      = new DateTime($tanggal_lahir);
            $pelayanan  = new DateTime($tanggal_pelayanan);

            $diff = $lahir->diff($pelayanan);

            if ($diff->y == 0 && $diff->m == 0) {
                // Kurang dari 1 bulan → hari
                $usia = $diff->d . ' Hari';
            } elseif ($diff->y == 0) {
                // Kurang dari 1 tahun → bulan
                $usia = $diff->m . ' Bulan';
            } else {
                // 1 tahun ke atas
                $usia = $diff->y . ' Tahun';
            }

        } catch (Exception $e) {
            $usia = '';
        }
    }
    $tanggal_lahir_format = date('d/m/Y', strtotime($tanggal_lahir));

    // ID Encounter
    if(empty($data['id_encounter'])){
        $id_encounter = "-";
    }else{
        $id_encounter = $data['id_encounter'];
    }

    //IHS Pasien
    if(empty($data['ihs_pasien'])){
        $ihs_pasien = "-";
    }else{
        $ihs_pasien = $data['ihs_pasien'];
    }

    // Menampilkan Data
    echo '
        <input type="hidden" name="id_laboratorium" id="get_id_laboratorium" value="'.$id_laboratorium.'">
        <div class="row mb-2 mt-2 border-1 border-top">
            <div class="col-12 text-dark">
                <dt>A. Detail Permintaan Pemeriksaan</dt>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-dark">No.RM</div>
            <div class="col-1">:</div>
            <div class="col-7 text-muted">'.$data['id_pasien'].'</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-dark">IHS Pasien</div>
            <div class="col-1">:</div>
            <div class="col-7 text-muted">'.$ihs_pasien.'</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-dark">Nama Pasien</div>
            <div class="col-1">:</div>
            <div class="col-7 text-muted">'.$data['nama'].'</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-dark">Gender</div>
            <div class="col-1">:</div>
            <div class="col-7 text-muted">'.$data['gender'].'</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-dark">Tanggal Lahir</div>
            <div class="col-1">:</div>
            <div class="col-7 text-muted">'.$tanggal_lahir_format.'</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-dark">Usia Saat Pemeriksaan</div>
            <div class="col-1">:</div>
            <div class="col-7 text-muted">'.$usia.'</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-dark">ID Kunjungan</div>
            <div class="col-1">:</div>
            <div class="col-7 text-muted">'.$data['id_kunjungan'].'</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-dark">ID Encounter</div>
            <div class="col-1">:</div>
            <div class="col-7 text-muted">'.$id_encounter.'</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-dark">Tujuan Kunjungan</div>
            <div class="col-1">:</div>
            <div class="col-7 text-muted">'.$data['tujuan'].'</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-dark">Metode Pembayaran</div>
            <div class="col-1">:</div>
            <div class="col-7 text-muted">'.$data['pembayaran'].'</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-dark">Waktu Diminta</div>
            <div class="col-1">:</div>
            <div class="col-7 text-muted">'.$data['datetime_diminta'].'</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-dark">Asal Faskes</div>
            <div class="col-1">:</div>
            <div class="col-7 text-muted">'.$data['fakses'].'</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-dark">Asal Unit/Instalasi</div>
            <div class="col-1">:</div>
            <div class="col-7 text-muted">'.$data['unit'].'</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-dark">Display Diagnosis</div>
            <div class="col-1">:</div>
            <div class="col-7 text-muted">'.$data['diagnosis']['code'].' | '.$data['diagnosis']['display'].'</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-dark">Nama Dokter Pengirim</div>
            <div class="col-1">:</div>
            <div class="col-7 text-muted">'.$data['kode_dokter_pengirim'].' - '.$data['nama_dokter_pengirim'].'</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-dark">Priority</div>
            <div class="col-1">:</div>
            <div class="col-7 text-muted">'.$prioritas_label.'</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-dark">Status</div>
            <div class="col-1">:</div>
            <div class="col-7 text-muted">'.$status_label.'</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-dark">Form System</div>
            <div class="col-1">:</div>
            <div class="col-7 text-muted">'.$data['form_system'].'</div>
        </div>
    ';
    if(!empty($data['keterangan'])){
        echo '
            <div class="row mb-2">
                <div class="col-4 text-dark">Keterangan Lainnya</div>
                <div class="col-1">:</div>
                <div class="col-7 text-muted">'.$data['keterangan'].'</div>
            </div>
        ';
    }
?>
<div class="row mb-3 mt-3 border-1 border-top">
    <div class="col-10">
        <dt>B. Rincian Pemeriksaan</dt>
    </div>
    <div class="col-2">
        <?php
            if($data['status']=="Diminta"){
                echo '
                    <button type="button" class="btn btn-sm btn-info btn-block modal_tambah_rincian" data-id="'.$id_laboratorium.'">
                        <i class="ti ti-plus"></i> Tambah
                    </button>
                ';
            }else{
                echo '
                    <button type="button" disabled class="btn btn-sm btn-outline-dark btn-block">
                        <i class="ti ti-plus"></i> Tambah
                    </button>
                ';
            }
        ?>
        
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="table table-responsive">
            <table class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <td class="text-center"><dt>No</dt></td>
                        <td class="text-center"><dt>Kategori</dt></td>
                        <td class="text-center"><dt>Pemeriksaan</dt></td>
                        <td class="text-center"><dt>Hasil</dt></td>
                        <td class="text-center"><dt>Interpertasi</dt></td>
                        <td class="text-center"><dt>Opsi</dt></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $rincian = $result['rincian'];
                        $no = 1;
                        foreach ($rincian as $list_rincian){
                            echo '
                                <tr>
                                    <td class="text-center"><span>'.$no.'</span></td>
                                    <td class="text-left"><span>'.$list_rincian['category_pemeriksaan'].'</span></td>
                                    <td class="text-left"><span>'.$list_rincian['nama_pemeriksaan'].'</span></td>
                                    <td class="text-left"><span>'.$list_rincian['hasil'].'</span></td>
                                    <td class="text-left"><span>'.$list_rincian['interpertasi'].'</span></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-icon btn-outline-secondary modal_hapus_rincian" data-id_laboratorium_rincian="'.$list_rincian['id_laboratorium_rincian'].'" data-id_laboratorium="'.$list_rincian['id_laboratorium'].'">
                                            <i class="ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            ';
                            $no++;
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
