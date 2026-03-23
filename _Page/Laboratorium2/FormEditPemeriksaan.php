<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/SettingFaskes.php";
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

    // Variabel Detail
    $detail = $result['detail'] ?? [];

    // Variabel Detail
    $id_pasien            = $detail['id_pasien'];
    $id_kunjungan         = $detail['id_kunjungan'];
    $ihs_pasien           = $detail['ihs_pasien'];
    $id_encounter         = $detail['id_encounter'];
    $nama                 = $detail['nama'];
    $gender               = $detail['gender'];
    $tanggal_lahir        = $detail['tanggal_lahir'];
    $tujuan               = $detail['tujuan'];
    $pembayaran           = $detail['pembayaran'];
    $fakses               = $detail['fakses'];
    $unit                 = $detail['unit'];
    $priority             = $detail['priority'];
    $kode_dokter_pengirim = $detail['kode_dokter_pengirim'];
    $ihs_dokter_pengirim  = $detail['ihs_dokter_pengirim'];
    $nama_dokter_pengirim = $detail['nama_dokter_pengirim'];
    $kode_petugas         = $detail['kode_petugas'];
    $ihs_petugas          = $detail['ihs_petugas'];
    $nama_petugas         = $detail['nama_petugas'];
    $nama_diagnosis       = $detail['diagnosis']['display'];
    $kode_diagnosis       = $detail['diagnosis']['code'];
    $system_diagnosis     = $detail['diagnosis']['system'];
    $keterangan           = $detail['keterangan'];
    $datetime_diminta     = $detail['datetime_diminta'];

    // Select Gender
    if($gender=="Laki-laki"){
        $select_gender_1 = "selected";
        $select_gender_2 = "";
    }else{
        $select_gender_1 = "";
        $select_gender_2 = "selected";
    }

    // Select Tujuan
    if($tujuan=="Rajal"){
        $select_tujuan_1 = "selected";
        $select_tujuan_2 = "";
    }else{
        $select_tujuan_1 = "";
        $select_tujuan_2 = "selected";
    }

    // Select Priority
    if($priority=="routine"){
        $select_priority_1 = "selected";
        $select_priority_2 = "";
        $select_priority_3 = "";
    }else{
        if($priority=="urgent"){
            $select_priority_1 = "";
            $select_priority_2 = "selected";
            $select_priority_3 = "";
        }else{
            if($priority=="stat"){
                $select_priority_1 = "";
                $select_priority_2 = "";
                $select_priority_3 = "selected";
            }else{
                $select_priority_1 = "";
                $select_priority_2 = "";
                $select_priority_3 = "";
            }
        }
    }
    
    // Menampilkan Data
    echo '<input type="hidden" name="id_laboratorium" value="'.$id_laboratorium.'">';
    echo '<input type="hidden" name="kode_petugas" value="'.$kode_petugas.'">';
    echo '<input type="hidden" name="ihs_petugas" value="'.$ihs_petugas.'">';
    echo '<input type="hidden" name="nama_petugas" value="'.$nama_petugas.'">';
?>
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="id_pasien_edit">No.RM</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="id_pasien" id="id_pasien_edit" class="form-control" placeholder="Nomor RM" value="<?php echo $id_pasien; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="ihs_pasien_edit"><dt>IHS Pasien</dt></label>
        </div>
        <div class="col-md-9">
            <input type="text" name="ihs_pasien" id="ihs_pasien_edit" class="form-control" placeholder="IHS Satu Sehat" value="<?php echo $ihs_pasien; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="id_kunjungan_edit"><dt>ID Kunjungan</dt></label>
        </div>
        <div class="col-md-9">
            <input type="text" name="id_kunjungan" id="id_kunjungan_edit" class="form-control" placeholder="ID Kunjungan" value="<?php echo $id_kunjungan; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="id_encounter_edit"><dt>ID Encounter</dt></label>
        </div>
        <div class="col-md-9">
            <input type="text" name="id_encounter" id="id_encounter_edit" class="form-control" placeholder="Encounter Satu Sehat" value="<?php echo $id_encounter; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="nama_edit"><dt>Nama Lengkap Pasien</dt></label>
        </div>
        <div class="col-md-9">
            <input type="text" name="nama" id="nama_edit" class="form-control" value="<?php echo $nama; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="gender_edit"><dt>Gender</dt></label>
        </div>
        <div class="col-md-9">
            <select name="gender" id="gender_edit" class="form-control">
                <option value="">Pilih</option>
                <option <?php echo $select_gender_1; ?> value="Laki-laki">Laki-laki</option>
                <option <?php echo $select_gender_2; ?> value="Perempuan">Perempuan</option>
            </select>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="tanggal_lahir_edit"><dt>Tanggal Lahir</dt></label>
        </div>
        <div class="col-md-9">
            <input type="date" name="tanggal_lahir" id="tanggal_lahir_edit" class="form-control" value="<?php echo $tanggal_lahir; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3 mb-2">
            <label for="tanggal_edit"><dt>Tanggal & Waktu Permintaan</dt></label>
        </div>
        <div class="col-md-6 mb-2">
            <input type="date" name="tanggal" id="tanggal_edit" value="<?php echo date('Y-m-d'); ?>" class="form-control" value="<?php echo $tanggal_lahir; ?>">
            <small>Tanggal</small>
        </div>
        <div class="col-md-3 mb-2">
            <input type="time" name="jam" id="jam_edit" class="form-control" value="<?php echo date('H:i'); ?>">
            <small>Waktu/Jam</small>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="tujuan_edit"><dt>Kategori Kunjungan</dt></label>
        </div>
        <div class="col-md-9">
            <select name="tujuan" id="tujuan_edit" class="form-control">
                <option value="">Pilih</option>
                <option <?php echo $select_tujuan_1; ?> value="Rajal">Rajal</option>
                <option <?php echo $select_tujuan_2; ?> value="Ranap">Ranap</option>
            </select>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="fakses_edit"><dt>Nama Faskes</dt></label>
        </div>
        <div class="col-md-9">
            <input type="text" name="fakses" id="fakses_edit" class="form-control" value="<?php echo $NamaFaskes; ?>">
            <span class="text-muted">Nama Fasilitas Kesehatan Yang Mengirimkan Permintaan Pemeriksaan</span>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="unit_edit"><dt>Unit / Instalasi</dt></label>
        </div>
        <div class="col-md-9">
            <input type="text" name="unit" id="unit_edit" class="form-control" value="<?php echo $unit; ?>">
            <span class="text-muted">Nama Unit/Instalasi yang meminta pemeriksaan</span>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="pembayaran_edit"><dt>Metode Pembayaran</dt></label>
        </div>
        <div class="col-md-9">
            <input type="text" name="pembayaran" id="pembayaran_edit" class="form-control" value="<?php echo $pembayaran; ?>">
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="dokter_pengirim_edit"><dt>Dokter Pengirim</dt></label>
        </div>
        <div class="col-md-9">
            <select name="dokter_pengirim" id="dokter_pengirim_edit" class="form-control">
                <option value="">Pilih</option>
                <?php
                    //menampilkan list dokter
                    $QryDokter = mysqli_query($Conn, "SELECT id_dokter, nama, kode FROM dokter ORDER BY nama ASC");
                    while ($DataDokter = mysqli_fetch_array($QryDokter)) {
                        if(!empty($DataDokter['nama'])){
                            if($kode_dokter_pengirim==$DataDokter['kode']){
                                echo '<option selected value="'.$DataDokter['id_dokter'].'">'.$DataDokter['nama'].'</option>';
                            }else{
                                echo '<option value="'.$DataDokter['id_dokter'].'">'.$DataDokter['nama'].'</option>';
                            }
                        }
                    }
                ?>
            </select>
            <span class="text text-muted">
                Permintaan pemeriksaan laboratorium harus melalui rekomendasi dokter.
            </span>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="priority_edit"><dt><i>Priority</i></dt></label>
        </div>
        <div class="col-md-9">
            <select name="priority" id="priority_edit" class="form-control">
                <option value="">Pilih</option>
                <option <?php echo "$select_priority_1"; ?> value="routine">Biasa</option>
                <option <?php echo "$select_priority_2"; ?> value="urgent">Segera</option>
                <option <?php echo "$select_priority_3"; ?> value="stat">Gawat</option>
            </select>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="diagnosis_edit"><dt><i>Diagnosis</i></dt></label>
        </div>
        <div class="col-md-9">
            <div class="input-group">
                <select name="diagnosis" id="diagnosis_edit" class="form-control select2">
                    <option value="">-- Pilih --</option>
                    <option selected value="<?php echo "$kode_diagnosis|$nama_diagnosis"; ?>"><?php echo "$kode_diagnosis|$nama_diagnosis"; ?></option>
                </select>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="keterangan_edit"><dt>Keterangan Lainnya</dt></label>
        </div>
        <div class="col-md-9">
            <input type="text" name="keterangan" id="keterangan_edit" class="form-control" value="<?php echo "$keterangan"; ?>">
        </div>
    </div>