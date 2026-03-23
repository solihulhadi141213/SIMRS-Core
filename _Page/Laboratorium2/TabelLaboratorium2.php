<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "FungsiLaboratorium.php";

    // Validasi Akses
    if(empty($_SESSION['id_akses'])){
        echo '<div class="alert alert-danger">Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</div>';
        exit;
    }
    
    // Menangkap Data Filter Dari Form
    $limit      = $_POST['limit'] ?? 10;
    $page       = $_POST['page'] ?? 1;
    $keyword_by = $_POST['keyword_by'] ?? "";
    $keyword    = $_POST['keyword'] ?? "";
    $short_by   = $_POST['short_by'] ?? "datetime_diminta";
    $order_by   = $_POST['order_by'] ?? "DESC";
   
    // Ambil token Analyza
    $tokenData = getAnalyzaToken($Conn);

    if ($tokenData['status'] !== 'success') {
        echo '<div class="alert alert-danger">'.$tokenData['message'].'</div>';
        exit;
    }

    $token   = $tokenData['token'];
    $baseUrl = $tokenData['base_url'];

    // Call API Pemeriksaan
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $baseUrl . "/_API/ListPemeriksaan?keyword_by=$keyword_by&keyword=$keyword&limit=$limit&page=$page&short_by=$short_by&order_by=$order_by",
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
        echo '<div class="alert alert-danger">Terjadi Kesalahan pada saat meminta data dari Analyza</div>';
        exit;
    }

    if ($result['status'] !== 'success') {
        echo '<div class="alert alert-danger">Terjadi Kesalahan pada saat meminta data dari Analyza <br> <i>'.$result['message'].'</i></div>';
        exit;
    }

    $data = $result['data_list'] ?? [];

    // Jika kosong
    if (count($data) === 0) {
        echo '<div class="alert alert-danger text-center">Data Tidak Ditemukan</div>';
        exit;
    }

    // Render Table Rows
    $no = 1 + (($page - 1) * $limit);

    foreach ($data as $row) {
        if(empty($row['nama_petugas'])){
            $nama_petugas = "-";
        }else{
            $nama_petugas = $row['nama_petugas'];
        }

        // Prioritas
        $prioritas = $row['priority'];
        $priority_color = [
            'routine' => '<span class="badge bg-info">Biasa</code>',
            'urgent'  => '<span class="badge bg-primary">Segera</code>',
            'stat'    => '<span class="badge bg-danger">Segera</code>'
        ];
        $prioritas_label = $priority_color[$prioritas] ?? '';

        //Status
        $status = $row['status'];
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

        // Apabila status masih diminta maka user masih bisa membatalkan dan mengubah permintaan
        $tombol_lanjutan = '';
        if($status=="Diminta"){
            $tombol_lanjutan = '
                <a class="dropdown-item modal_edit_pemeriksaan" href="javascript:void(0);" data-id="'.$row['id_laboratorium'].'">
                    <i class="ti-pencil"></i> Ubah
                </a>
                <a class="dropdown-item modal_hapus_pemeriksaan" href="javascript:void(0);" data-id="'.$row['id_laboratorium'].'">
                    <i class="ti-trash"></i> Hapus / Batalkan
                </a>
            ';
        }
        // Tampilkan Data
        echo '
            <div class="card">
                <div class="card-header border-info">
                    <div class="row">
                        <div class="col-10">
                            <a href="javascript:void(0);" class="modal_detail" data-id="'.$row['id_laboratorium'].'">
                                <dt class="text-primary">'.$no.'. '.$row['nama'].'</dt>
                            </a>
                            <small class="text text-muted">ID.'.$row['id_laboratorium'].'</small>
                        </div>
                        <div class="col-2 text-right">
                            <div class="btn-group dropdown-split-inverse">
                                <a href="javascript:void(0);" data-toggle="dropdown">
                                    <i class="icofont-navigation-menu"></i>
                                </a>
                                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a href="javascript:void(0);" class="dropdown-item modal_detail" data-id="'.$row['id_laboratorium'].'">
                                        <i class="ti ti-info-alt"></i> Detail
                                    </a>
                                    '.$tombol_lanjutan.'
                                    <a class="dropdown-item modal_cetak_pemeriksaan" href="javascript:void(0);" data-id="'.$row['id_laboratorium'].'">
                                        <i class="ti-printer"></i> Cetak
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-info">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row mb-2">
                                <div class="col-4 text-dark">No.RM</div>
                                <div class="col-1">:</div>
                                <div class="col-7 text-muted">'.$row['id_pasien'].'</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-dark">Tanggal</div>
                                <div class="col-1">:</div>
                                <div class="col-7 text-muted">'.date('d/m/Y H:i T', strtotime($row['datetime_diminta'])).'</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-dark">Petugas</div>
                                <div class="col-1">:</div>
                                <div class="col-7 text-muted">'.$nama_petugas.'</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row mb-2">
                                <div class="col-4 text-dark">Tujuan</div>
                                <div class="col-1">:</div>
                                <div class="col-7 text-muted">'.$row['tujuan'].'</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-dark">Asal Kiriman</div>
                                <div class="col-1">:</div>
                                <div class="col-7 text-muted">'.$row['unit'].'</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-dark">Pembayaran</div>
                                <div class="col-1">:</div>
                                <div class="col-7 text-muted">'.$row['pembayaran'].'</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row mb-2">
                                <div class="col-4 text-dark">Sumber Data</div>
                                <div class="col-1">:</div>
                                <div class="col-7 text-muted">'.$row['form_system'].'</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-dark"><i>Priority</i></div>
                                <div class="col-1">:</div>
                                <div class="col-7 text-muted">'.$prioritas_label.'</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-dark">Status</div>
                                <div class="col-1">:</div>
                                <div class="col-7">'.$status_label.'</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
        $no++;
    }

    echo "
        <script>
            $('#page_info_rad').html('{$result['current_page']} / {$result['total_page']}');
            $('#total_page').val('{$result['total_page']}');
        </script>
    ";
    
?>
