<?php
    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // Validasi ID Kunjungan
    if (empty($_POST['id_kunjungan'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Kunjungan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // Validasi form
    if (empty($_POST['from'])) {
        echo '
            <div class="alert alert-danger">
                <small>Asal Permintaan Perubahan Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Sanitasi Input
    $id_kunjungan = validateAndSanitizeInput($_POST['id_kunjungan']);
    $from         = validateAndSanitizeInput($_POST['from']);

    // Buka Data Dengan Prepared Statement + JOIN
    $sql = "
        SELECT 
            kunjungan.*,

            pasien.nama AS nama_pasien,
            pasien.nik,
            pasien.id_ihs,
            pasien.no_bpjs,
            pasien.gender,
            pasien.tempat_lahir,
            pasien.tanggal_lahir

        FROM kunjungan
        LEFT JOIN pasien 
            ON kunjungan.id_pasien = pasien.id_pasien

        WHERE kunjungan.id_kunjungan = ?
    ";

    $stmt = $Conn->prepare($sql);

    // Bind parameter
    $stmt->bind_param("i", $id_kunjungan);

    // Eksekusi
    $stmt->execute();

    // Ambil hasil
    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();

    // Simpan hasil ke variabel
    $id_pasien               = $Data['id_pasien'] ?? null;
    $id_encounter            = $Data['id_encounter'] ?? null;
    $sep                     = $Data['sep'] ?? null;
    $prioritas               = $Data['prioritas'] ?? null;
    $keluhan                 = $Data['keluhan'] ?? null;
    $jenis_kunjungan         = $Data['jenis_kunjungan'] ?? null;
    $id_dokter               = $Data['id_dokter'] ?? null;
    $kode_dokter             = $Data['kode_dokter'] ?? null;
    $dokter                  = $Data['dokter'] ?? null;
    $dpjp_id                 = $Data['dpjp_id'] ?? null;
    $dpjp_kode               = $Data['dpjp_kode'] ?? null;
    $dpjp_nama               = $Data['dpjp_nama'] ?? null;
    $id_poliklinik           = $Data['id_poliklinik'] ?? null;
    $kode_poliklinik         = $Data['kode_poliklinik'] ?? null;
    $poliklinik              = $Data['poliklinik'] ?? null;
    $kelas                   = $Data['kelas'] ?? null;
    $ruang_rawat             = $Data['ruang_rawat'] ?? null;
    $tempat_tidur            = $Data['tempat_tidur'] ?? null;
    $pembayaran_metode       = $Data['pembayaran_metode'] ?? null;
    $pembayaran_penanggung   = $Data['pembayaran_penanggung'] ?? null;
    $kontak_darurat_nomor    = $Data['kontak_darurat_nomor'] ?? null;
    $kontak_darurat_nama     = $Data['kontak_darurat_nama'] ?? null;
    $kontak_darurat_hubungan = $Data['kontak_darurat_hubungan'] ?? null;
    $cara_keluar             = $Data['cara_keluar'] ?? null;
    $status                  = $Data['status'] ?? null;
    $petugas_id              = $Data['petugas_id'] ?? null;
    $petugas_nama            = $Data['petugas_nama'] ?? null;
    $datetime_daftar         = $Data['datetime_daftar'] ?? null;
    $datetime_pelayanan      = $Data['datetime_pelayanan'] ?? null;
    $datetime_selesai        = $Data['datetime_selesai'] ?? null;

    // Pasien
    $nama_pasien   = $Data['nama_pasien'] ?? null;
    $nik           = $Data['nik'] ?? null;
    $id_ihs        = $Data['id_ihs'] ?? null;
    $no_bpjs       = $Data['no_bpjs'] ?? null;
    $gender        = $Data['gender'] ?? null;
    $tempat_lahir  = $Data['tempat_lahir'] ?? null;
    $tanggal_lahir = $Data['tanggal_lahir'] ?? null;

    // Hitung Usia
    $usia_sekarang = hitungUsia($tanggal_lahir);
    $usia_pelayanan = hitungUsia($tanggal_lahir, $datetime_daftar);

    // Waktu Pelayanan
    if(!empty($datetime_daftar)){
        $tanggal_daftar = date('Y-m-d', strtotime($datetime_daftar));
        $jam_daftar     = date('H:i', strtotime($datetime_daftar));
    }else{
        $tanggal_daftar = "";
        $jam_daftar     = "";
    }
    

    // Prioritas
    if($prioritas=="Normal"){
        $select_normal    = "checked";
        $select_urgent    = "";
        $select_emergency = "";
    }else{
        if($prioritas=="Urgent"){
            $select_normal    = "";
            $select_urgent    = "checked";
            $select_emergency = "";
        }else{
            if($prioritas=="Emergency"){
                $select_normal    = "";
                $select_urgent    = "";
                $select_emergency = "checked";
            }
        }
    }

    // Jenis Kunjungan
    if($jenis_kunjungan=="Rajal"){
        $select_rajal    = "checked";
        $select_ranap    = "";
    }else{
        $select_rajal    = "";
        $select_ranap    = "checked";
    }

    // Tutup statement
    $stmt->close();

    // Mencari kelas, ruangan dan tempat tidur
    $id_kelas_rawat  = "";
    $id_ruang_rawat  = "";
    $id_tempat_tidur = "";
    
    if(!empty($kelas)){
        $id_kelas_rawat  = getDataDetail_v2($Conn, 'rr_kelas_rawat', 'kelas', $kelas, 'id_kelas_rawat');
    }
    if(!empty($ruang_rawat)){
        $id_ruang_rawat  = getDataDetail_v2($Conn, 'rr_ruang_rawat', 'ruang_rawat', $ruang_rawat, 'id_ruang_rawat');
    }
    if(!empty($tempat_tidur)){
        $id_tempat_tidur = getDataDetail_v2($Conn, 'rr_tempat_tidur', 'tempat_tidur', $tempat_tidur, 'id_tempat_tidur');
    }
    
    // Metode Pembayaran
    if($pembayaran_metode=="UMUM"){
        $select_pembayaran_umum     = "checked";
        $select_pembayaran_asuransi = "";
    }else{
        if($pembayaran_metode=="ASURANSI"){
            $select_pembayaran_umum     = "";
            $select_pembayaran_asuransi = "checked";
        }else{
            $select_pembayaran_umum     = "";
            $select_pembayaran_asuransi = "";
        }
    }
?>
    <input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan; ?>">
    <input type="hidden" name="from" value="<?php echo $from; ?>">
    <div class="row mb-3">
        <div class="col-12">
            <small><b>A. Identitas Pasien (Rekam Medis)</b></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="id_pasien_edit"><small>* Nomor Rekam Medis (RM)</small></label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="id_pasien" id="id_pasien_edit" class="form-control" value="<?php echo $id_pasien; ?>" required>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-4">
            <label for="nama_edit"><small>* Nama Pasien</small></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="nama" id="nama_edit" class="form-control" value="<?php echo $nama_pasien; ?>" required>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-4">
            <label for="nik_edit"><small>NIK (Nomor KTP)</small></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="nik" id="nik_edit" class="form-control" value="<?php echo $nik; ?>">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-4">
            <label for="no_bpjs_edit"><small>Nomor Kartu BPJS</small></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="no_bpjs" id="no_bpjs_edit" class="form-control" value="<?php echo $no_bpjs; ?>">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-4">
            <label for="id_ihs_edit"><small><i>IHS (Indonesia Health Services)</i></small></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="id_ihs" id="id_ihs_edit" class="form-control" value="<?php echo $id_ihs; ?>">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="alert alert-info">
                <small><b>Penting!</b> Mengubah data ini akan memperbaharui data pasien. Lakukan perubahan data tersebut dengan bijak.</small>
            </div>
        </div>
    </div>

    <hr>

    <div class="row mb-3 mt-3">
        <div class="col-12">
            <small><b>B. Informasi Kunjungan</b></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="prioritas_edit"><small>* Prioritas Tindakan</small></label>
        </div>
        <div class="col-md-8">
            <div class="d-flex flex-wrap gap-3 mb-4 mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="prioritas" id="prioritas_edit_normal" value="Normal" <?php echo $select_normal; ?> >
                    <label class="form-check-label" for="prioritas_edit_normal">
                        <small>Normal</small>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="prioritas" id="prioritas_edit_urgent" value="Urgent" <?php echo $select_urgent; ?> >
                    <label class="form-check-label" for="prioritas_edit_urgent">
                        <small>Urgent</small>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="prioritas" id="prioritas_edit_emergency" value="Emergency" <?php echo $select_emergency; ?> >
                    <label class="form-check-label" for="prioritas_edit_emergency">
                        <small>Emergency</small>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-4">
            <label for="jenis_kunjungan"><small>* Tujuan Kunjungan</small></label>
        </div>
        <div class="col-md-8">
            <div class="d-flex flex-wrap gap-3 mb-4 mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kunjungan" id="jenis_kunjungan_edit_rajal" value="Rajal" <?php echo $select_rajal; ?> >
                    <label class="form-check-label" for="jenis_kunjungan_edit_rajal">
                        <small>Rawat Jalan (Rajal)</small>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kunjungan" id="jenis_kunjungan_edit_ranap" value="Ranap" <?php echo $select_ranap; ?> >
                    <label class="form-check-label" for="jenis_kunjungan_edit_ranap">
                        <small>Rawat Inap (Ranap)</small>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label for="keluhan_edit"><small>* Keluhan Utama (<i>Chief Complaint</i>)</small></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="keluhan" id="keluhan_edit" class="form-control" value="<?php echo $keluhan; ?>" required>
            <small>
                <small class="text-muted">Jelaskan secara singkat padat dan lengkap mengenai keluhan utama pasien saat mendaftar.</small>
            </small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="datetime_daftar"><small>* Tanggal & Waktu Pendaftaran</small></label>
        </div>
        <div class="col-md-8">
            <div class="input-group">
                <input type="date" class="form-control" name="date_daftar" id="date_daftar_edit" value="<?php echo $tanggal_daftar; ?>" required>
                <input type="time" class="form-control" name="time_daftar" id="time_daftar_edit" value="<?php echo $jam_daftar; ?>" required>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label for="id_encounter_edit"><small><i>ID Encounter (SATUSEHAT)</i></small></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="id_encounter" id="id_encounter_edit" class="form-control" value="<?php echo $id_encounter; ?>">
            <small><small class="text-muted">hanya jika sebelumnya sudah dibuatkan ID Encounter</small></small>
        </div>
    </div>

    <hr>

    <div class="row mb-3 mt-3">
        <div class="col-12">
            <small><b>C. Dokter Penerima</b></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="id_dokter_edit"><small>ID Dokter (SIMRS)</small></label>
        </div>
        <div class="col-md-8">
            <select name="id_dokter" id="id_dokter_edit" class="form-control">
                <option value="">Pilih Dokter</option>
                <?php
                    $sql_dokter = "SELECT * FROM dokter WHERE status=1 ORDER BY nama ASC";
                    $stmt_dokter = mysqli_prepare($Conn, $sql_dokter);
                    if ($stmt_dokter) {
                        mysqli_stmt_execute($stmt_dokter);
                        $result_dokter = mysqli_stmt_get_result($stmt_dokter);
                        while ($data_dokter = mysqli_fetch_assoc($result_dokter)) {
                            if(!empty($data_dokter['nama'])){
                                $nama_list = $data_dokter['nama'];
                                $kode_list = $data_dokter['kode'];
                                $id_dokter_list = $data_dokter['id_dokter'];
                                if($id_dokter_list==$id_dokter){
                                    echo '<option selected value="' . htmlspecialchars($id_dokter_list) . '" kode="' . htmlspecialchars($kode_list) . '" nama="' . htmlspecialchars($nama_list) . '">'. htmlspecialchars($nama_list) .'</option>';
                                }else{
                                    echo '<option value="' . htmlspecialchars($id_dokter_list) . '" kode="' . htmlspecialchars($kode_list) . '" nama="' . htmlspecialchars($nama_list) . '">'. htmlspecialchars($nama_list) .'</option>';
                                }
                            }
                        }
                        mysqli_stmt_close($stmt_dokter);
                    } else {
                        echo '<option value="">Gagal memuat data</option>';
                    }
                ?>
                <!-- Load Data Dokter -->
            </select>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="kode_dokter_edit"><small>* Kode Dokter (HFIS)</small></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="kode_dokter" id="kode_dokter_edit" class="form-control" value="<?php echo $kode_dokter; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="dokter_edit"><small>* Nama Dokter</small></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="dokter" id="dokter_edit" class="form-control" value="<?php echo $dokter; ?>">
        </div>
    </div>

    <hr>

    <div class="row mb-3 mt-3">
        <div class="col-12">
            <small><b>E. Dokter DPJP</b></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="dpjp_id"><small>ID Dokter (SIMRS)</small></label>
        </div>
        <div class="col-md-8">
            <select name="dpjp_id" id="dpjp_id" class="form-control">
                <option value="">Pilih Dokter</option>
                <?php
                    $sql_dokter_dpjp = "SELECT * FROM dokter WHERE status=1 ORDER BY nama ASC";
                    $stmt_dokter_dpjp = mysqli_prepare($Conn, $sql_dokter_dpjp);
                    if ($stmt_dokter_dpjp) {
                        mysqli_stmt_execute($stmt_dokter_dpjp);
                        $result_dokter_dpjp = mysqli_stmt_get_result($stmt_dokter_dpjp);
                        while ($data_dokter_dpjp = mysqli_fetch_assoc($result_dokter_dpjp)) {
                            if(!empty($data_dokter_dpjp['nama'])){
                                $nama_dpjp_list = $data_dokter_dpjp['nama'];
                                $kode_dpjp_list = $data_dokter_dpjp['kode'];
                                $id_dokter_dpjp_list = $data_dokter_dpjp['id_dokter'];
                                if($id_dokter_dpjp_list==$dpjp_id){
                                    echo '<option selected value="' . htmlspecialchars($id_dokter_dpjp_list) . '" kode="' . htmlspecialchars($kode_dpjp_list) . '" nama="' . htmlspecialchars($nama_dpjp_list) . '">'. htmlspecialchars($nama_dpjp_list) .'</option>';
                                }else{
                                    echo '<option value="' . htmlspecialchars($id_dokter_dpjp_list) . '" kode="' . htmlspecialchars($kode_dpjp_list) . '" nama="' . htmlspecialchars($nama_dpjp_list) . '">'. htmlspecialchars($nama_dpjp_list) .'</option>';
                                }
                            }
                        }
                        mysqli_stmt_close($stmt_dokter_dpjp);
                    } else {
                        echo '<option value="">Gagal memuat data</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="dpjp_kode_edit"><small>Kode Dokter (HFIS)</small></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="dpjp_kode" id="dpjp_kode_edit" class="form-control" value="<?php echo $dpjp_kode; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="dpjp_nama_edit"><small>Nama Dokter</small></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="dpjp_nama" id="dpjp_nama_edit" class="form-control" value="<?php echo $dpjp_nama; ?>">
        </div>
    </div>

    <hr>

    <div class="row mb-3 mt-3">
        <div class="col-12">
            <small><b>F. Poliklinik</b></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="id_poliklinik_edit"><small>ID Poliklinik (SIMRS)</small></label>
        </div>
        <div class="col-md-8">
            <select name="id_poliklinik" id="id_poliklinik_edit" class="form-control">
                <option value="">Pilih Poliklinik</option>
                <?php
                    $sql_poliklinik = "SELECT * FROM poliklinik WHERE status=1 ORDER BY poliklinik ASC";
                    $stmt_poliklinik = mysqli_prepare($Conn, $sql_poliklinik);
                    if ($stmt_poliklinik) {
                        mysqli_stmt_execute($stmt_poliklinik);
                        $result_poliklinik = mysqli_stmt_get_result($stmt_poliklinik);
                        while ($data_poliklinik = mysqli_fetch_assoc($result_poliklinik)) {
                            if(!empty($data_poliklinik['poliklinik'])){
                                $id_poliklinik_list   = $data_poliklinik['id_poliklinik'];
                                $poliklinik_list      = $data_poliklinik['poliklinik'];
                                $kode_poliklinik_list = $data_poliklinik['kode'];
                                
                                if($id_poliklinik_list==$id_poliklinik){
                                    echo '<option selected value="' . htmlspecialchars($id_poliklinik_list) . '" kode="' . htmlspecialchars($kode_poliklinik_list) . '" nama="' . htmlspecialchars($poliklinik_list) . '">'. htmlspecialchars($poliklinik_list) .'</option>';
                                }else{
                                    echo '<option value="' . htmlspecialchars($id_poliklinik_list) . '" kode="' . htmlspecialchars($kode_poliklinik_list) . '" nama="' . htmlspecialchars($poliklinik_list) . '">'. htmlspecialchars($poliklinik_list) .'</option>';
                                }
                            }
                        }
                        mysqli_stmt_close($stmt_poliklinik);
                    } else {
                        echo '<option value="">Gagal memuat data</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="kode_poliklinik_edit"><small>Kode Poliklinik (BPJS)</small></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="kode_poliklinik" id="kode_poliklinik_edit" class="form-control" value="<?php echo $kode_poliklinik; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="poliklinik_edit"><small>Nama Poliklinik</small></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="poliklinik" id="poliklinik_edit" class="form-control" value="<?php echo $poliklinik; ?>">
        </div>
    </div>

    <hr>

    <div class="row mb-3 mt-3">
        <div class="col-12">
            <small><b>G. Kelas / Ruang Inap (Pasien Rawat Inap)</b></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="kelas_edit"><small>Kelas Inap</small></label>
        </div>
        <div class="col-md-8">
            <select name="id_kelas_rawat" id="kelas_edit" class="form-control">
                <option value="">Pilih</option>
                <?php
                    $sql_kelas = "SELECT * FROM rr_kelas_rawat WHERE status=1 ORDER BY kelas ASC";
                    $stmt_kelas = mysqli_prepare($Conn, $sql_kelas);
                    if ($stmt_kelas) {
                        mysqli_stmt_execute($stmt_kelas);
                        $result_kelas = mysqli_stmt_get_result($stmt_kelas);
                        while ($data_kelas = mysqli_fetch_assoc($result_kelas)) {
                            $id_kelas_rawat_list = $data_kelas['id_kelas_rawat'];
                            $kelas_list          = $data_kelas['kelas'];
                            
                            if($id_kelas_rawat_list==$id_kelas_rawat){
                                echo '<option selected value="'.$id_kelas_rawat_list.'">'.$kelas_list.'</option>';
                            }else{
                                echo '<option value="'.$id_kelas_rawat_list.'">'.$kelas_list.'</option>';
                            }
                        }
                        mysqli_stmt_close($stmt_kelas);
                    } else {
                        echo '<option value="">Gagal memuat data</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="ruang_rawat_edit"><small>Ruangan</small></label>
        </div>
        <div class="col-md-8">
            <select name="id_ruang_rawat" id="ruang_rawat_edit" class="form-control">
                <option value="">Pilih</option>
                <?php
                    $sql_ruang = "SELECT * FROM rr_ruang_rawat WHERE id_kelas_rawat='$id_kelas_rawat' AND status=1 ORDER BY ruang_rawat ASC";
                    $stmt_ruang = mysqli_prepare($Conn, $sql_ruang);
                    if ($stmt_ruang) {
                        mysqli_stmt_execute($stmt_ruang);
                        $result_ruangan = mysqli_stmt_get_result($stmt_ruang);
                        while ($data_ruangan = mysqli_fetch_assoc($result_ruangan)) {
                            $id_ruang_rawat_list = $data_ruangan['id_ruang_rawat'];
                            $ruang_rawat_list    = $data_ruangan['ruang_rawat'];
                            
                            if($id_ruang_rawat_list==$id_ruang_rawat){
                                echo '<option selected value="'.$id_ruang_rawat_list.'">'.$ruang_rawat_list.'</option>';
                            }else{
                                echo '<option value="'.$id_ruang_rawat_list.'">'.$ruang_rawat_list.'</option>';
                            }
                        }
                        mysqli_stmt_close($stmt_ruang);
                    } else {
                        echo '<option value="">Gagal memuat data</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="tempat_tidur_edit"><small>Tempat Tidur</small></label>
        </div>
        <div class="col-md-8">
            <select name="id_tempat_tidur" id="tempat_tidur_edit" class="form-control">
                <option value="">Pilih</option>
                <?php
                    $sql_tt = "SELECT * FROM rr_tempat_tidur WHERE id_ruang_rawat='$id_ruang_rawat' AND status=1 ORDER BY tempat_tidur ASC";
                    $stmt_tt = mysqli_prepare($Conn, $sql_tt);
                    if ($stmt_tt) {
                        mysqli_stmt_execute($stmt_tt);
                        $result_tt = mysqli_stmt_get_result($stmt_tt);
                        while ($data_tt = mysqli_fetch_assoc($result_tt)) {
                            $id_tempat_tidur_list = $data_tt['id_tempat_tidur'];
                            $tempat_tidur_list    = $data_tt['tempat_tidur'];
                            
                            if($id_tempat_tidur_list==$id_tempat_tidur){
                                echo '<option selected value="'.$id_tempat_tidur_list.'">'.$tempat_tidur_list.'</option>';
                            }else{
                                echo '<option value="'.$id_tempat_tidur_list.'">'.$tempat_tidur_list.'</option>';
                            }
                        }
                        mysqli_stmt_close($stmt_tt);
                    } else {
                        echo '<option value="">Gagal memuat data</option>';
                    }
                ?>
            </select>
        </div>
    </div>

    <hr>

    <div class="row mb-3 mt-3">
        <div class="col-12">
            <small><b>H. Pembayaran Dan Penjaminan</b></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="pembayaran_metode_edit"><small>* Metode Pembayaran</small></label>
        </div>
        <div class="col-md-8">
            <div class="d-flex flex-wrap gap-3 mb-4 mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="pembayaran_metode" id="pembayaran_metode_edit_umum" value="UMUM" <?php echo $select_pembayaran_umum; ?> >
                    <label class="form-check-label" for="pembayaran_metode_edit_umum">
                        <small>UMUM</small>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="pembayaran_metode" id="pembayaran_metode_edit_asuransi" value="ASURANSI" <?php echo $select_pembayaran_asuransi; ?>>
                    <label class="form-check-label" for="pembayaran_metode_edit_asuransi">
                        <small>ASURANSI</small>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="pembayaran_penanggung_edit"><small>Penanggung Pembayaran</small></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="pembayaran_penanggung" id="pembayaran_penanggung_edit" class="form-control" value="<?php echo "$pembayaran_penanggung"; ?>">
            <small>
                <small class="text-muted">Khusus untuk pasien umum, diisi dengan nama penjamin pembayaran</small>
            </small>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label for="sep_edit"><small>SEP (Surat Eligibilitas Peserta)</small></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="sep" id="sep_edit" class="form-control" value="<?php echo "$sep"; ?>">
            <small><small class="text-muted">hanya jika sebelumnya sudah dibuatkan SEP</small></small>
        </div>
    </div>

    <hr>

    <div class="row mb-3 mt-3">
        <div class="col-12">
            <small><b>I. Kontak Darurat</b></small>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="kontak_darurat_nomor_edit"><small>Nomor Kontak</small></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="kontak_darurat_nomor" id="kontak_darurat_nomor_edit" class="form-control" value="<?php echo $kontak_darurat_nomor; ?>" placeholder="+62">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="kontak_darurat_nama_edit"><small>Nama Pemilik Kontak</small></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="kontak_darurat_nama" id="kontak_darurat_nama_edit" class="form-control" value="<?php echo $kontak_darurat_nama; ?>">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4">
            <label for="kontak_darurat_hubungan_edit"><small>Hubungan Dengan Pasien</small></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="kontak_darurat_hubungan" id="kontak_darurat_hubungan_edit" class="form-control" value="<?php echo $kontak_darurat_hubungan; ?>" placeholder="Ayah, Ibu, Kakak, DLL">
            <small>
                <small class="text-muted">
                    Jika pasien tidak memiliki kontak darurat lainnya : 
                </small>
            </small>
        </div>
    </div>
<script>
    $('#ButtonEdit').prop('disabled', false);
</script>