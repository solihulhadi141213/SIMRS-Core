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
    $from = validateAndSanitizeInput($_POST['from']);

    // Buka Data Dengan Prepared Statement + JOIN
    $sql = "SELECT status FROM kunjungan WHERE id_kunjungan = ?";
    $stmt = $Conn->prepare($sql);

    // Bind parameter
    $stmt->bind_param("i", $id_kunjungan);

    // Eksekusi
    $stmt->execute();

    // Ambil hasil
    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();

    // Simpan hasil ke variabel
    $status = $Data['status'] ?? null;

    // Tutup statement
    $stmt->close();

    // Routing Status
    if($status == "Terdaftar"){
        $status_terdaftar = 'checked';
        $status_selesai   = '';
        $status_batal     = '';
        $status_meninggal = '';
    }else{
        if($status == "Selesai"){
            $status_terdaftar = '';
            $status_selesai   = 'checked';
            $status_batal     = '';
            $status_meninggal = '';
        }else{
            if($status == "Batal"){
                $status_terdaftar = '';
                $status_selesai   = '';
                $status_batal     = 'checked';
                $status_meninggal = '';
            }else{
                if($status == "Meninggal"){
                    $status_terdaftar = '';
                    $status_selesai   = '';
                    $status_batal     = '';
                    $status_meninggal = 'checked';
                }else{
                    $status_terdaftar = '';
                    $status_selesai   = '';
                    $status_batal     = '';
                    $status_meninggal = '';
                }
            }
        }
    }

    
?>
<input type="hidden" name="id_kunjungan" value="<?php echo $id_kunjungan; ?>">
<input type="hidden" name="from" value="<?php echo $from; ?>">
<div class="row mb-3">
    <div class="col-12">
        <div class="alert alert-warning text-center">
            <small>
                <b>PENTING!</b><br>
                Melakukan perubahan status kunjungan pada halaman ini tidak akan melengkapi dokumen pelengkap yang seharusnya. 
                Hubungi petugas rekam medis yang bertanggung jawab memastikan kelengkapan data sebelum melakukan perubahan.
            </small>
        </div>
    </div>
</div>
<div class="form-check mb-3">
    <input class="form-check-input" type="radio" name="status" id="status_terdaftar" value="Terdaftar" <?php echo $status_terdaftar; ?> >
    <label class="form-check-label" for="status_terdaftar">
        <b>Terdaftar</b><br>
        <small class="text-muted">
            Pasien didaftarkan oleh petugas pada saat pertama kali kunjungan. 
            Status kunjungan tidak akan berubah sampai petugas melakukan update pada data kunjungan sesuai pelayanan yang diterima.
        </small>
    </label>
</div>
<div class="form-check mb-3">
    <input class="form-check-input" type="radio" name="status" id="status_selesai" value="Selesai" <?php echo $status_selesai; ?> >
    <label class="form-check-label" for="status_selesai">
        <b>Selesai</b><br>
        <small class="text-muted">
            Pasien telah menerima pelayanan dan diijinkan pulang. 
            Untuk pasien rawat inap, petugas akan membuatkan resume pulang beserta keterangan status kepulangan pasien.
        </small>
    </label>
</div>
<div class="form-check mb-3">
    <input class="form-check-input" type="radio" name="status" id="status_batal" value="Batal" <?php echo $status_batal; ?> >
    <label class="form-check-label" for="status_batal">
        <b>Batal</b><br>
        <small class="text-muted">
            Pasien telah menerima pelayanan dan diijinkan pulang. 
            Untuk pasien rawat inap, petugas akan membuatkan resume pulang beserta keterangan status kepulangan pasien.
        </small>
    </label>
</div>
<div class="form-check mb-3">
    <input class="form-check-input" type="radio" name="status" id="status_meninggal" value="Meninggal" <?php echo $status_meninggal; ?> >
    <label class="form-check-label" for="status_meninggal">
        <b>Meninggal</b><br>
        <small class="text-muted">
            Pasien telah meninggal dunia. 
            Petugas akan membuatkan informasi tanggal, jam meninggal dunia dan keterangan lainnya berdasarkan pernyataan dokter.
        </small>
    </label>
</div>