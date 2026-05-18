<?php
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi akses sudah berakhir, silakan login ulang.</small>
            </div>
        ';
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo '
            <div class="alert alert-danger text-center">
                <small>Metode request tidak valid.</small>
            </div>
        ';
        exit;
    }

    if (empty($_POST['id_praktisi'])) {
        echo '
            <div class="alert alert-danger text-center">
                <small>ID Praktisi tidak boleh kosong.</small>
            </div>
        ';
        exit;
    }

    $id_praktisi = (int) $_POST['id_praktisi'];
    $stmt = mysqli_prepare($Conn,"SELECT * FROM praktisi WHERE id_praktisi = ?");

    if (!$stmt) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Gagal menyiapkan query.</small>
            </div>
        ';
        exit;
    }
    mysqli_stmt_bind_param($stmt, "i", $id_praktisi);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$result || mysqli_num_rows($result) == 0) {
        mysqli_stmt_close($stmt);
        echo '
            <div class="alert alert-warning text-center">
                <small>Data tidak ditemukan.</small>
            </div>
        ';
        exit;
    }
    $data = mysqli_fetch_assoc($result); 
    mysqli_stmt_close($stmt);

    $id_akses         = $data['id_akses'];
    $id_dokter        = $data['id_dokter'];
    $id_practitioner  = $data['id_practitioner'];
    $tipe_praktisi    = $data['tipe_praktisi'];
    $profesi_praktisi = $data['profesi_praktisi'];
    $nama_praktisi    = $data['nama_praktisi'];
    $nik_praktisi     = $data['nik_praktisi'];
    $kontak_praktisi  = $data['kontak_praktisi'];
    $email_praktisi   = $data['email_praktisi'];

    // Selected $tipe_praktisi
    $tipe_praktisi_selected_1 = "";
    $tipe_praktisi_selected_2 = "";
    if($tipe_praktisi=="Medis"){
        $tipe_praktisi_selected_1 = "selected";
        $tipe_praktisi_selected_2 = "";
    }else{
        $tipe_praktisi_selected_1 = "";
        $tipe_praktisi_selected_2 = "selected";
    }

    // Buka Nama Akses
    $nama_akses = "";
    if(!empty($data['id_akses'])){
        $nama_akses = getDataDetail_v2($Conn, 'akses', 'id_akses', $id_akses, 'nama');
    }

    // Buka Nama Dokter
    $nama_dokter = "";
    if(!empty($data['id_dokter'])){
        $nama_dokter = getDataDetail_v2($Conn, 'dokter', 'id_dokter', $id_dokter, 'nama');
    }
?>
<input type="hidden" name="id_praktisi" value="<?php echo $id_praktisi; ?>">

<!-- Nama Lengkap -->
<div class="row mb-3">
    <div class="col-12">
        <label for="nama_praktisi_edit"><small>* Nama Lengkap</small></label>
        <input type="text" name="nama_praktisi" id="nama_praktisi_edit" class="form-control" value="<?php echo $nama_praktisi; ?>" required>
    </div>
</div>

<!-- NIK -->
<div class="row mb-3">
    <div class="col-12">
        <label for="nik_praktisi_edit"><small>* Nomor NIK/KTP</small></label>
        <div class="input-group">
            <input type="text" name="nik_praktisi" id="nik_praktisi_edit" class="form-control get_nik_value"  value="<?php echo $nik_praktisi; ?>" required>
            <button type="button" class="btn btn-sm btn-outline-dark modal_cek_nik_edit">
                <i class="bi bi-search"></i> SATUSEHAT
            </button>
        </div>
        
    </div>
</div>

<!-- Nomor Kontak -->
<div class="row mb-3">
    <div class="col-12">
        <label for="kontak_praktisi_edit"><small>Nomor Kontak</small></label>
        <input type="text" name="kontak_praktisi" id="kontak_praktisi_edit" class="form-control" placeholder="62" value="<?php echo $kontak_praktisi; ?>">
    </div>
</div>

<!-- Email -->
<div class="row mb-3">
    <div class="col-12">
        <label for="email_praktisi_edit"><small>Alamat Email</small></label>
        <input type="email" name="email_praktisi" id="email_praktisi_edit" class="form-control" placeholder="email@domain.com" value="<?php echo $email_praktisi; ?>">
    </div>
</div>

<!-- ID Practitioner -->
<div class="row mb-3">
    <div class="col-12">
        <label for="id_practitioner_edit"><small>ID Practitioner (<i>SATUSEHAT</i>)</small></label>
        <input type="text" name="id_practitioner" id="id_practitioner_edit" class="form-control" value="<?php echo $id_practitioner; ?>">
    </div>
</div>

<!-- Tipe Praktisi -->
<div class="row mb-3">
    <div class="col-12">
        <label for="tipe_praktisi_edit"><small>* Tipe Praktisi</small></label>
        <select name="tipe_praktisi" id="tipe_praktisi_edit" class="form-control" required>
            <option value="">Pilih</option>
            <option <?php echo $tipe_praktisi_selected_1 ; ?> value="Medis">Medis</option>
            <option <?php echo $tipe_praktisi_selected_2 ; ?> value="Non Medis">Non Medis</option>
        </select>
    </div>
</div>

<!-- Profesi -->
<div class="row mb-3">
    <div class="col-12" id="FormProfesiEdit">
        <label for="profesi_praktisi_edit"><small>* Profesi Praktisi</small></label>
        <select name="profesi_praktisi" id="profesi_praktisi_edit" class="form-select" required>
            <option selected value="<?php echo $profesi_praktisi; ?>"><?php echo $profesi_praktisi; ?></option>
            <option value="">Pilih Profesi</option>
        </select>
    </div>
</div>

<!-- ID Akses -->
<div class="row mb-3">
    <div class="col-12" id="FormAksesEdit">
        <label for="id_akses_edit"><small>ID Akses</small></label>
        <select name="id_akses" id="id_akses_edit" class="form-select">
            <?php
                if(!empty($data['id_akses'])){
                   echo '<option selected value="'.$id_akses.'">'.$nama_akses.'</option>';
                }
            ?>
            <option value="">Pilih Akses</option>
        </select>
        <small>
            <small class="text-muted">
                Hanya apabila praktisi/SDM bersangkutan memiliki akses SIMRS
            </small>
        </small>
    </div>
</div>

<!-- ID Dokter -->
<div class="row mb-3">
    <div class="col-12" id="FormDokterEdit">
        <label for="id_dokter_edit"><small>ID Dokter</small></label>
        <select name="id_dokter" id="id_dokter_edit" class="form-select">
            <?php
                if(!empty($data['id_dokter'])){
                   echo '<option selected value="'.$id_dokter.'">'.$nama_dokter.'</option>';
                }
            ?>
            <option value="">Pilih Dokter</option>
        </select>
        <small>
            <small class="text-muted">
                Hanya apabila praktisi/SDM bersangkutan adalah seorang dokter.
            </small>
        </small>
    </div>
</div>