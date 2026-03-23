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
        'Diminta' => '<span class="badge bg-inverse">Diminta</span>',
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

    //Dokter Penerima
    if(empty($data['kode_dokter_penerima'])){
        $kode_dokter_penerima = "-";
    }else{
        $kode_dokter_penerima = $data['kode_dokter_penerima'];
    }
    if(empty($data['ihs_dokter_penerima'])){
        $ihs_dokter_penerima = "-";
    }else{
        $ihs_dokter_penerima = $data['ihs_dokter_penerima'];
    }
    if(empty($data['nama_dokter_penerima'])){
        $nama_dokter_penerima = "-";
    }else{
        $nama_dokter_penerima = $data['nama_dokter_penerima'];
    }

    //Diagnosis
    if(empty($data['diagnosis']['code'])){
        $diagnosis_code = "-";
    }else{
        $diagnosis_code = $data['diagnosis']['code'];
    }
    if(empty($data['diagnosis']['display'])){
        $diagnosis_display = "-";
    }else{
        $diagnosis_display = $data['diagnosis']['display'];
    }
    if(empty($data['diagnosis']['system'])){
        $diagnosis_system = "-";
    }else{
        $diagnosis_system = $data['diagnosis']['system'];
    }

    // Log Aktivitas
    if(empty($data['datetime_diminta'])){
        $datetime_diminta = "-";
    }else{
        $datetime_diminta = date('d/m/Y H:i', strtotime($data['datetime_diminta']));
    }
    if(empty($data['datetime_diterima'])){
        $datetime_diterima = "-";
    }else{
        $datetime_diterima = date('d/m/Y H:i', strtotime($data['datetime_diterima']));
    }
    if(empty($data['datetime_spesimen'])){
        $datetime_spesimen = "-";
    }else{
        $datetime_spesimen = date('d/m/Y H:i', strtotime($data['datetime_spesimen']));
    }
    if(empty($data['datetime_hasil'])){
        $datetime_hasil = "-";
    }else{
        $datetime_hasil = date('d/m/Y H:i', strtotime($data['datetime_hasil']));
    }

    // Status Puasa
    if(empty($data['puasa'])){
        $status_puasa = "Tidak";
    }else{
        $status_puasa = 'Ya';
    }

    // Routing Tombol Tambah Rincian
    if($data['status']=="Diminta"){
        $tombol_tambah_rincian = '
            <button type="button" class="btn btn-icon btn-sm btn-outline-secondary modal_tambah_rincian" data-id="'.$id_laboratorium.'">
                <i class="ti ti-plus"></i>
            </button>
        ';
    }else{
        $tombol_tambah_rincian = '';
    }

    // Keterangan Lainnya
    if(empty($data['keterangan'])){
        $keterangan = "-";
    }else{
        $keterangan = $data['keterangan'];
    }
    if(empty($data['alasan'])){
        $alasan = "-";
    }else{
        $alasan = $data['alasan'];
    }
    if(empty($data['form_system'])){
        $form_system = "-";
    }else{
        $form_system = $data['form_system'];
    }
?>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 mb-2">
                <h4 class="text text-muted">
                    # Informasi Umum
                </h4>
            </div>
            <div class="col-md-6 mb-2 text-right">
                <div class="icon-btn">
                    <button type="button" class="btn btn-icon btn-outline-secondary kembali_ke_data_laboratorium" title="Kembali Ke Halaman Utama">
                        <i class="icofont-rounded-double-left"></i>
                    </button>
                     <button type="button" class="btn btn-icon btn-outline-secondary reload_detail_pemeriksaan" title="Reload Halaman">
                        <i class="ti ti-reload"></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-outline-secondary modal_cetak_pemeriksaan" data-id="<?php echo $id_laboratorium; ?>" title="Cetak Bukti Permintaan">
                        <i class="ti ti-printer"></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-outline-secondary modal_edit_pemeriksaan" data-id="<?php echo $id_laboratorium; ?>" title="Ubah Informasi Pemeriksaan Laboratorium">
                        <i class="ti-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-outline-secondary modal_hapus_pemeriksaan" data-id="<?php echo $id_laboratorium; ?>" title="Hapus Informasi Pemeriksaan Laboratorium">
                        <i class="ti-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?php
                    echo '
                        <div class="row mb-2 mt-3 border-1 border-top">
                            <div class="col-12 text-dark">
                                <dt>A. Identitas Pasien</dt>
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
                        <div class="row mb-3">
                            <div class="col-4 text-dark">Usia Saat Pemeriksaan</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$usia.'</div>
                        </div>
                    ';
                    echo '
                        <div class="row mb-2 mt-3 border-1 border-top">
                            <div class="col-12 text-dark">
                                <dt>B. Informasi Kunjungan</dt>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-dark">ID. Kunjungan</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$data['id_kunjungan'].'</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-dark">ID. Encounter</div>
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
                            <div class="col-4 text-dark">Faskes</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$data['fakses'].'</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 text-dark">Unit / Instalasi</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$data['unit'].'</div>
                        </div>
                    ';
                    echo '
                        <div class="row mb-2 mt-3 border-1 border-top">
                            <div class="col-12 text-dark">
                                <dt><i>C. Reson Code</i></dt>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-dark"><i>Code</i></div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$diagnosis_code.'</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-dark"><i>Description</i></div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$diagnosis_display.'</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 text-dark"><i>System</i></div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$diagnosis_system.'</div>
                        </div>
                    ';
                    echo '
                        <div class="row mb-2 mt-3 border-1 border-top">
                            <div class="col-12 text-dark">
                                <dt>D. Permintaan Pemeriksaan</dt>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-dark">ID.Laboratorium</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$id_laboratorium.'</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-dark">Tanggal Permintaan</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.date('d/m/Y H:i', strtotime($data['datetime_diminta'])).'</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 text-dark">Status Puasa</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$status_puasa.'</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 text-dark">Priority</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$prioritas_label.'</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 text-dark">Status Pemeriksaan</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$status_label.'</div>
                        </div>
                    ';
                ?>

            </div>
            <div class="col-md-6">
                <?php
                    echo '
                        <div class="row mb-2 mt-3 border-1 border-top">
                            <div class="col-12 text-dark">
                                <dt>E. Dokter Pengirim</dt>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-dark">Nama Dokter</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$data['nama_dokter_pengirim'].'</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-dark">Kode Dokter</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$data['kode_dokter_pengirim'].'</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-dark">IHS Dokter</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$data['ihs_dokter_pengirim'].'</div>
                        </div>
                    ';
                    echo '
                        <div class="row mb-2 mt-3 border-1 border-top">
                            <div class="col-12 text-dark">
                                <dt>F. Dokter Penerima</dt>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-dark">Nama Dokter</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$nama_dokter_penerima.'</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-dark">Kode Dokter</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$kode_dokter_penerima.'</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-dark">IHS Dokter</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$ihs_dokter_penerima.'</div>
                        </div>
                    ';
                    echo '
                        <div class="row mb-2 mt-3 border-1 border-top">
                            <div class="col-12 text-dark">
                                <dt>G. Log Pemeriksaan</dt>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-dark">Diminta</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$datetime_diminta.'</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-dark">Diterima</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$datetime_diterima.'</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-dark">Spesimen</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$datetime_spesimen.'</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 text-dark">Hasil</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$datetime_hasil.'</div>
                        </div>
                    ';
                    echo '
                        <div class="row mb-2 mt-3 border-1 border-top">
                            <div class="col-12 text-dark">
                                <dt>H. Informasi Lainnya</dt>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-dark">Keterangan Tambahan</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$keterangan.'</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-dark">Alasan Pembatalan</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$alasan.'</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 text-dark">Form System</div>
                            <div class="col-1">:</div>
                            <div class="col-7 text-muted">'.$form_system.'</div>
                        </div>
                    ';
                    echo '
                        <div class="row mb-2 mt-3 border-1 border-top">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <dt>PENTING!</dt>
                                    <small>
                                        Untuk memahami sistem yang berjalan pada halaman ini, ada beberapa hal yang perlu anda ketahui :<br>
                                        <ol>
                                            <li>
                                                Perubahan dan pembatalan permintaan pemeriksaan hanya bisa dilakukan apabila petugas laboratorium belum menerima, membatalkan atau memproses permintaan.
                                            </li>
                                            <li>
                                                Demi keamanan data dan informasi, output cetak hasil hanya dilakukan pada aplikasi <i>Analyza</i> dan  diterbitkan oleh unit laboratorium.
                                            </li>
                                            <li>
                                                Pengisian hasil dan parameter lain, hanya dilakukan oleh petugas <i>Laboratorium</i> pada aplikasi <i>Analyza</i>
                                            </li>
                                        </ol>
                                    </small>
                                </div>
                            </div>
                        </div>
                    ';
                ?>
            </div>
        </div>
    </div>
</div>
<div class="card table-card">
    <div class="card-header">
        <div class="row">
            <div class="col-8">
                <h4 class="text text-muted">
                    # Rincian Pemeriksaan
                </h4>
            </div>
            <div class="col-4 text-right icon-btn">
                <?php echo $tombol_tambah_rincian; ?>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table table-responsive">
            <table class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <td class="text-center"><dt>No</dt></td>
                        <td class="text-center"><dt>Kategori</dt></td>
                        <td class="text-center"><dt>Pemeriksaan</dt></td>
                        <td class="text-center"><dt>Hasil</dt></td>
                        <td class="text-center"><dt>Interpertasi</dt></td>
                        <td class="text-center"><dt><i>Conclusion</i></dt></td>
                        <td class="text-center"><dt><i>Keterangan</i></dt></td>
                        <td class="text-center"><dt>Opsi</dt></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $rincian = $result['rincian'];
                        if(empty(count($rincian))){
                            echo '
                                <tr>
                                    <td class="text-center" colspan="8">
                                        <span class="text-danger">Tidak Ada Rincian Pemeriksaan</span>
                                    </td>
                                </tr>
                            ';
                        }else{
                            $no = 1;
                            foreach ($rincian as $list_rincian){
                                echo '
                                    <tr>
                                        <td class="text-center"><span>'.$no.'</span></td>
                                        <td class="text-left"><span>'.$list_rincian['category_pemeriksaan'].'</span></td>
                                        <td class="text-left"><span>'.$list_rincian['nama_pemeriksaan'].'</span></td>
                                        <td class="text-left"><span>'.$list_rincian['hasil'].'</span></td>
                                        <td class="text-left"><span>'.$list_rincian['interpertasi'].'</span></td>
                                        <td class="text-left"><span>'.$list_rincian['conclusion'].'</span></td>
                                        <td class="text-left"><span>'.$list_rincian['keterangan'].'</span></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline-danger modal_hapus_rincian" data-id_laboratorium_rincian="'.$list_rincian['id_laboratorium_rincian'].'" data-id_laboratorium="'.$list_rincian['id_laboratorium'].'">
                                                <i class="ti-close"></i>
                                            </button>
                                        </td>
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

<div class="card table-card">
    <div class="card-header">
        <div class="row">
            <div class="col-12">
                <h4 class="text text-muted">
                    # Spesimen
                </h4>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table table-responsive">
            <table class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <td class="text-center"><dt>No</dt></td>
                        <td class="text-center"><dt>Tanggal/Jam</dt></td>
                        <td class="text-center"><dt>Spesimen</dt></td>
                        <td class="text-center"><dt>Metode</dt></td>
                        <td class="text-center"><dt><i>Body Site</i></dt></td>
                        <td class="text-center"><dt><i>Container</i></dt></td>
                        <td class="text-center"><dt><i>Quantity</i></dt></td>
                        <td class="text-center"><dt><i>Collector</i></dt></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $spesimen = $result['spesimen'];
                        if(empty(count($spesimen))){
                            echo '
                                <tr>
                                    <td class="text-center" colspan="8">
                                        <span class="text-danger">Tidak Ada Data/Informasi Spesimen</span>
                                    </td>
                                </tr>
                            ';
                        }else{
                            $no = 1;
                            foreach ($spesimen as $list_spesimen){
                                echo '
                                    <tr>
                                        <td class="text-center"><span>'.$no.'</span></td>
                                        <td class="text-left"><span>'.$list_spesimen['datetime_spesimen'].'</span></td>
                                        <td class="text-left"><span>'.$list_spesimen['nama_spesimen'].'</span></td>
                                        <td class="text-left"><span>'.$list_spesimen['nama_metode_sample'].'</span></td>
                                        <td class="text-left"><span>'.$list_spesimen['bodysite_nama'].'</span></td>
                                        <td class="text-left"><span>'.$list_spesimen['nama_container'].'</span></td>
                                        <td class="text-left">
                                            '.$list_spesimen['quantity_value'].' '.$list_spesimen['quantity_unit'].'
                                        </td>
                                        <td class="text-left"><span>'.$list_spesimen['collector_name'].'</span></td>
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
