<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/SettingFaskes.php";
    include "FungsiLaboratorium.php";

    // Validasi Data yang Wajib Terisi Atau Ada
    if(empty($_GET['id_laboratorium'])){
        echo 'ID Laboratorium Tidak Boleh Kosong!';
        exit;
    }

    // Pengaturan header
    if(empty($_GET['tampilkan_header'])){
        $tampilkan_header = "No";
    }else{
        $tampilkan_header = "Ya";
    }

    // Buat Variabel
    $id_laboratorium = $_GET['id_laboratorium'];

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
?>
    <html>
        <Header>
            <title>Cetak Laboratorium</title>
            <style type="text/css">
                body{
                    font-family: Arial, Helvetica, sans-serif;
                    color      : #000000;
                    font-size  : 12 pt;
                    margin     : 5px;
                }
                .nama_faskes {
                    font-size: 18pt;
                }
                table{
                    border-collapse: collapse;
                }
                table tr td{
                    font-size: <?php echo "$UkuranFornSettingKartuPasien";?>;
                }
                table.header tr td{
                    padding      : 3px;
                }

                table.intercept{
                    width: 100%;
                    margin-top: 6px;
                }
                table.intercept tr td{
                    height: 3px;
                }
                table.intercept .line-1{
                    border-bottom: 2px solid #000;
                }
                table.intercept .line-2{
                    border-bottom: 1px solid #000;
                }
                .judul{
                    text-align: center;
                    font-size: 14pt;
                    margin: 14px 0 8px 0; /* jarak dari garis ke judul */
                }
                table.info{
                    width: 100%;
                    margin-top: 4px;
                }
                table.info td{
                    padding: 2px 4px;
                    font-size: 11pt;
                    vertical-align: top;
                }
                table.info .label{
                    width: 32%;
                    font-weight: bold;
                }
                .title_document123 {
                    display: block;
                    text-align: center;
                    margin: 14px 0 10px 0; /* jarak antara garis dan judul */
                }
                table.tabel_pemeriksaan {
                    margin-top : 20px;
                }
                table.tabel_pemeriksaan tr td {
                    border: 1px solid #000;
                    padding      : 3px;
                }
            </style>
        </Header>
        <body>
            <table class="header" width="100%">
                <tr>
                    <td align="center">
                        <?php
                            if(!empty($logo)){
                                echo '
                                    <img src="../../assets/images/'.$logo.'" width="80px">
                                ';
                            }
                        ?>
                    </td>
                    <td>
                        <b class="nama_faskes"><?php echo $NamaFaskes; ?></b><br>
                        <?php echo "Alamat : $AlamatFaskes <br> Telp: $KontakFaskes | Email : $EmailFaskes"; ?>
                    </td>
                    <td align="right">
                        Tgl/Jam : <?php echo date('d/m/Y H:i', strtotime($data['datetime_diminta'])); ?><br>
                        <?php echo $prioritas_label; ?>
                    </td>
                </tr>
            </table>
            <table class="intercept">
                <tr>
                    <td class="line-1"></td>
                </tr>
                <tr>
                    <td class="line-2"></td>
                </tr>
            </table>
            <span class="title_document123">
                <b>LEMBAR PERMINTAAN PEMERIKSAAN LABORATORIUM</b><br>
                <small>ID : <i><?php echo $id_laboratorium; ?></i></small>
            </span>
            <table class="intercept">
                <tr>
                    <td class="line-2"></td>
                </tr>
            </table>
            <table class="info">
                <tr>
                    <td class="label">No. RM</td>
                    <td>:</td>
                    <td><?php echo $data['id_pasien']; ?></td>
                </tr>
                <tr>
                    <td class="label">Nama Pasien</td>
                    <td>:</td>
                    <td><?php echo $data['nama']; ?></td>
                </tr>
                <tr>
                    <td class="label">Gender</td>
                    <td>:</td>
                    <td><?php echo $data['gender']; ?></td>
                </tr>
                <tr>
                    <td class="label">Tanggal Lahir / Usia</td>
                    <td>:</td>
                    <td><?php echo $tanggal_lahir_format.' / '.$usia; ?></td>
                </tr>
                <tr>
                    <td class="label">Usia Saat Pemeriksaan</td>
                    <td>:</td>
                    <td><?php echo $usia; ?></td>
                </tr>
                <tr>
                    <td class="label">Tujuan</td>
                    <td>:</td>
                    <td><?php echo $data['tujuan']; ?></td>
                </tr>
                <tr>
                    <td class="label">Metode Pembayaran</td>
                    <td>:</td>
                    <td><?php echo $data['pembayaran']; ?></td>
                </tr>
                <tr>
                    <td class="label">Waktu Diminta</td>
                    <td>:</td>
                    <td><?php echo $data['datetime_diminta']; ?></td>
                </tr>
                <tr>
                    <td class="label">Dokter Pengirim</td>
                    <td>:</td>
                    <td><?php echo $data['kode_dokter_pengirim'].' - '.$data['nama_dokter_pengirim']; ?></td>
                </tr>
                <tr>
                    <td class="label">Diagnosis</td>
                    <td>:</td>
                    <td><?php echo $data['diagnosis']['code'].' | '.$data['diagnosis']['display']; ?></td>
                </tr>
                <tr>
                    <td class="label">Asal Unit/Faskes</td>
                    <td>:</td>
                    <td><?php echo $data['unit'].' / '.$data['fakses']; ?></td>
                </tr>
                <tr>
                    <td class="label">Keterangan Lain</td>
                    <td>:</td>
                    <td><?php echo $data['keterangan']; ?></td>
                </tr>
            </table>
            
            <table class="tabel_pemeriksaan" width="100%">
                <tr>
                    <td align="center"><b>No</b></td>
                    <td align="center"><b>Kategori Pemeriksaan</b></td>
                    <td align="center"><b>Nama Pemeriksaan</b></td>
                    <td align="center"><b>Metode Pemeriksaan</b></td>
                    <td align="center"><b>Service Request</b></td>
                </tr>
                <?php
                    $rincian = $result['rincian'];
                    if(empty(count($rincian))){
                        echo '
                            <tr>
                                <td align="center" colspan="5">
                                    Tidak Ada Rincian Pemeriksaan
                                </td>
                            </tr>
                        ';
                    }else{
                        $no = 1;
                        foreach ($rincian as $list_rincian){
                            echo '
                                <tr>
                                    <td align="center"><span>'.$no.'</span></td>
                                    <td align="left"><span>'.$list_rincian['category_pemeriksaan'].'</span></td>
                                    <td align="left"><span>'.$list_rincian['nama_pemeriksaan'].'</span></td>
                                    <td align="left"><span>'.$list_rincian['metode_pemeriksaan'].'</span></td>
                                    <td align="left"><span>'.$list_rincian['id_service_request'].'</span></td>
                                </tr>
                            ';
                            $no++;
                        }
                    }
                ?>
            </table>
        </body>
    </html>
