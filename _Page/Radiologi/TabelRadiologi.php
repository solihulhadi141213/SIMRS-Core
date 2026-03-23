<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "FungsiRadiologi.php";

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
    $short_by   = $_POST['short_by'] ?? "id_radiologi";
    $order_by   = $_POST['order_by'] ?? "DESC";
   
    // Ambil token Radix
    $tokenData = getRadixToken($Conn);

    if ($tokenData['status'] !== 'success') {
        echo '<div class="alert alert-danger">'.$tokenData['message'].'</div>';
        exit;
    }

    $token   = $tokenData['token'];
    $baseUrl = $tokenData['base_url'];

    // Call API Pemeriksaan
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $baseUrl . "/_API/ListOrder?keyword_by=$keyword_by&keyword=$keyword&limit=$limit&page=$page&short_by=$short_by&order_by=$order_by",
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
        echo '<div class="alert alert-danger">Terjadi Kesalahan pada saat meminta data dari Radix</div>';
        exit;
    }

    if ($result['status'] !== 'success') {
        echo '<div class="alert alert-danger">Terjadi Kesalahan pada saat meminta data dari Radix <br> <i>'.$result['message'].'</i></div>';
        exit;
    }

    $data = $result['data'] ?? [];

    // Jika kosong
    if (count($data) === 0) {
        echo '<div class="alert alert-inverse">Data Tidak Ditemukan</div>';
        exit;
    }

    // Render Table Rows
    $no = 1 + (($page - 1) * $limit);

    foreach ($data as $row) {
        if(empty($row['nama_dokter_penerima'])){
            $dokter_penerima = $row['nama_dokter_penerima'];
        }else{
            $dokter_penerima = "-";
        }
        if(empty($dokter_penerima)){
            $dokter_penerima = "-";
        }

        // Prioritas
        $prioritas = $row['priority'];
        $priority_color = [
            'routine' => '<code class="text-muted">Biasa</code>',
            'urgent'  => '<code class="text-primary">Segera</code>',
            'stat'    => '<code class="text-gawat">Segera</code>'
        ];
        $prioritas_label = $priority_color[$prioritas] ?? '';

        //Status
        $status = $row['status_pemeriksaan'];
        $status_list = [
            'Diminta' => '<code class="text-inverse">Diminta</code>',
            'Dikerjakan'  => '<code class="text-info">Dikerjakan</code>',
            'Hasil'  => '<code class="text-primary">Hasil</code>',
            'Selesai'  => '<code class="text-success">Selesai</code>',
            'Batal'  => '<code class="text-danger">Batal</code>'
        ];
        $status_label = $status_list[$status] ?? '';
        // Tampilkan Data
        echo '
            <div class="card">
                <div class="card-header border-info">
                    <div class="row">
                        <div class="col-10">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalDetail" data-id="'.$row['id_radiologi'].'">
                                <dt class="text-primary">'.$no.'. '.$row['nama_pasien'].'</dt>
                            </a>
                        </div>
                        <div class="col-2 text-right">
                            <div class="btn-group dropdown-split-inverse">
                                <a href="javascript:void(0);" data-toggle="dropdown">
                                    <i class="icofont-navigation-menu"></i>
                                </a>
                                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#ModalDetail" data-id="'.$row['id_radiologi'].'">
                                        <i class="ti ti-info-alt"></i> Detail
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapus" data-id="'.$row['id_radiologi'].'">
                                        <i class="ti-trash"></i> Hapus / Batalkan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-info">
                    <div class="row">
                        <div class="col-md-6">
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
                                <div class="col-4 text-dark">Modalitas</div>
                                <div class="col-1">:</div>
                                <div class="col-7 text-muted">'.$row['alat_pemeriksa'].'</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-2">
                                <div class="col-4 text-dark"><i>Priority</i></div>
                                <div class="col-1">:</div>
                                <div class="col-7 text-muted">'.$prioritas_label.'</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-dark">Pemeriksaan</div>
                                <div class="col-1">:</div>
                                <div class="col-7 text-muted">'.$row['permintaan_pemeriksaan'][0]['nama_pemeriksaan'].'</div>
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

    $pagination = $result['pagination'];
    echo "
        <script>
            $('#page_info_rad').html('{$pagination['current_page']} / {$pagination['total_pages']}');
            $('#total_page').val('{$pagination['total_pages']}');
        </script>
    ";
    
?>
