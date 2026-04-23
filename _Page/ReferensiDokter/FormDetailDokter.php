<?php
    include "../../_Config/Connection.php";

    if (empty($_POST['id_dokter'])) {
        echo '<div class="alert alert-danger">ID Dokter tidak valid</div>';
        exit;
    }

    $id_dokter = $_POST['id_dokter'];

    // Helper function (ANTI KOSONG + XSS SAFE)
    function val($data) {
        return (!empty($data) && trim($data) !== '') 
            ? htmlspecialchars($data) 
            : '-';
    }

    // Ambil data dokter
    $stmt = mysqli_prepare($Conn, "SELECT * FROM dokter WHERE id_dokter = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_dokter);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo '<div class="alert alert-danger">Data dokter tidak ditemukan</div>';
        exit;
    }

    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    // Ambil data (pakai helper)
    $nama                = val($data['nama'] ?? '');
    $id_ihs_practitioner = val($data['id_ihs_practitioner'] ?? '');
    $kode                = val($data['kode'] ?? '');
    $gender              = val($data['gender'] ?? '');
    $kategori            = val($data['kategori'] ?? '');
    $kategori_identitas  = val($data['kategori_identitas'] ?? '');
    $no_identitas        = val($data['no_identitas'] ?? '');
    $alamat              = (!empty($data['alamat'])) 
                            ? nl2br(htmlspecialchars($data['alamat'])) 
                            : '-';
    $kontak              = val($data['kontak'] ?? '');
    $email               = val($data['email'] ?? '');
    $SIP                 = val($data['SIP'] ?? '');

    // Default foto
    $foto = "assets/images/no-image.png";

    if (!empty($data['foto'])) {
        $path = "../../assets/images/Dokter/" . $data['foto'];

        if (file_exists($path)) {
            $foto = "assets/images/Dokter/" . htmlspecialchars($data['foto']);
        }
    }

    // Format tanggal
    $tgl_lahir = (!empty($data['tanggal_lahir']) && $data['tanggal_lahir'] != '0000-00-00')
        ? date('d/m/Y', strtotime($data['tanggal_lahir']))
        : '-';

    // Status
    $status = ($data['status'] == 1)
        ? '<span class="badge bg-success">Aktif</span>'
        : '<span class="badge bg-danger">Nonaktif</span>';
?>
<div class="row mb-3">
    <div class="col-md-12 text-center mb-3">
        <img 
            src="<?php echo $foto; ?>" 
            class="shadow-sm"
            style="
                width:200px;
                height:200px;
                border-radius:50%;
                object-fit:cover;
            "
        >
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Nama Dokter</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $nama; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>ID Practitioner</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $id_ihs_practitioner; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Kode Dokter</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $kode; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Gender</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $gender; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Tanggal Lahir</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $tgl_lahir; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Kategori</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $kategori; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Kategori Identitas</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $kategori_identitas; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Nomor Identitas</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $no_identitas; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Alamat</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $alamat; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Nomor Kontak</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $kontak; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Alamat Email</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $email; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>SIP</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $SIP; ?></small>
    </div>
</div>

