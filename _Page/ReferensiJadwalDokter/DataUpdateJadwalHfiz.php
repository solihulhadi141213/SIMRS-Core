<?php
    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi, Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi Akses Sudah Berakhir! Silahkan LOGIN ulang!</small>
            </div>
        ';
        exit;
    }

    // Menangkap Data Dari Form
    if(empty($_POST['id_poliklinik'])){
        echo '
            <div class="alert alert-danger text-center">
                <small>Silahkan Pilih Poliklinik Terlebih Dulu</small>
            </div>
        ';
        exit;
    }

    if(empty($_POST['id_dokter'])){
        echo '
            <div class="alert alert-danger text-center">
                <small>Silahkan Pilih Dokter Terlebih Dulu</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel Dan Sanitasi
    $id_poliklinik = validateAndSanitizeInput($_POST['id_poliklinik']);
    $id_dokter     = validateAndSanitizeInput($_POST['id_dokter']);

    // Tampilkan Data Jadwal Menggunakan Prepared Statment
    $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT id_jadwal FROM jadwal_dokter WHERE id_dokter='$id_dokter' AND id_poliklinik='$id_poliklinik'"));
    
    //Kondisi jika data jadwal dokter kosong
    if(empty($JumlahData)){
        echo '
            <div class="alert alert-warning text-center">
                <small>Data Tidak Ditemukan</small>
            </div>
        ';
        exit;
    }else{
        
        //Tampilkan Data Dengan Prepared Statment
        $no = 1;
        $sql = "SELECT*FROM jadwal_dokter WHERE id_dokter='$id_dokter' AND id_poliklinik='$id_poliklinik'";
        $stmt = mysqli_prepare($Conn, $sql);
        if (!$stmt) {
            echo '
                <div class="alert alert-warning text-center">
                    <small>Data Tidak Ditemukan</small>
                </div>
            ';
            exit;
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($data = mysqli_fetch_assoc($result)) {
            $id_jadwal     = (int) $data['id_jadwal'];
            $id_dokter     = (int) $data['id_dokter'];
            $id_poliklinik = (int) $data['id_poliklinik'];
            $hari          = $data['hari'];
            $jam_mulai     = $data['jam_mulai'];
            $jam_selesai   = $data['jam_selesai'];
            $kuota_non_jkn = $data['kuota_non_jkn'];
            $kuota_jkn     = $data['kuota_jkn'];
            $time_max      = $data['time_max'];
            
            // Buka Nama Dokter Dari Tabel 'dokter'
            $nama_dokter = getDataDetail_v2($Conn, 'dokter', 'id_dokter', $id_dokter, 'nama');

            // Buka Nama Poli dari tabel 'poliklinik'
            $poliklinik = getDataDetail_v2($Conn, 'poliklinik', 'id_poliklinik', $id_poliklinik, 'poliklinik');

            echo '
                <div class="row mb-3 border-1 border-top">
                    <div class="col-12 mb-2 mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-5"><small>Hari</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-6"><small class="text text-muted">'.$hari.'</small></div>
                                </div>
                                <div class="row">
                                    <div class="col-5"><small>Jam Mulai</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-6"><small class="text text-muted">'.$jam_mulai.'</small></div>
                                </div>
                                <div class="row">
                                    <div class="col-5"><small>Jam Selesai</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-6"><small class="text text-muted">'.$jam_selesai.'</small></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-5"><small>Kuota Non JKN</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-6"><small class="text text-muted">'.$kuota_non_jkn.'</small></div>
                                </div>
                                <div class="row">
                                    <div class="col-5"><small>Kuota JKN</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-6"><small class="text text-muted">'.$kuota_jkn.'</small></div>
                                </div>
                                <div class="row">
                                    <div class="col-5"><small>Time Max</small></div>
                                    <div class="col-1"><small>:</small></div>
                                    <div class="col-6"><small class="text text-muted">'.$time_max.'</small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';

        }
    }
?>