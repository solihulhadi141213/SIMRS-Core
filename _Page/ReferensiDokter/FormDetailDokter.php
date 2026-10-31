<?php
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

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
    $foto = "assets/img/No-Image.png";

    if (!empty($data['foto'])) {
        $path = "../../assets/img/Dokter/" . $data['foto'];

        if (file_exists($path)) {
            $foto = "assets/img/Dokter/" . htmlspecialchars($data['foto']);
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

    // Metadata
    $creat_by_name = val($data['creat_by_name'] ?? '');
    $creat_by_id   = $data['creat_by_id'] ?? '';
    $creat_at      = $data['creat_at'] ?? '';

    $update_by_name = val($data['update_by_name'] ?? '');
    $update_by_id   = $data['update_by_id'] ?? '';
    $update_at      = $data['update_at'] ?? '';

    // Zona waktu user
    $timezoneName = trim((string)($SessionUserTimezone ?? ''));
    if (preg_match('/^UTC([+-])(\d{2}):(\d{2})$/', $timezoneName, $timezoneOffset)) {
        $timezoneName = $timezoneOffset[1] . $timezoneOffset[2] . ':' . $timezoneOffset[3];
    }
    try {
        $userTimezone = new DateTimeZone($timezoneName !== '' ? $timezoneName : 'UTC');
    } catch (Throwable $e) {
        $userTimezone = new DateTimeZone('UTC');
    }
    $formatUtcToUser = static function ($value) use ($userTimezone) {
        if (empty($value) || $value === '0000-00-00 00:00:00') {
            return '-';
        }
        try {
            $dt = new DateTimeImmutable((string)$value, new DateTimeZone('UTC'));
            return $dt->setTimezone($userTimezone)->format('d/m/Y H:i T');
        } catch (Throwable $e) {
            return (string)$value;
        }
    };

    $creat_at_user  = $formatUtcToUser($creat_at);
    $update_at_user = $formatUtcToUser($update_at);
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
<hr>
<div class="row mb-2">
    <div class="col-12">
        <small><b>A. Informasi Umum</b></small>
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
    <div class="col-5"><small>Kategori/Spesialis</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $kategori; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Nomor Identitas (<?php echo $kategori_identitas; ?>)</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $no_identitas; ?></small>
    </div>
</div>
<div class="row mb-4">
    <div class="col-5"><small>SIP</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $SIP; ?></small>
    </div>
</div>
<hr>
<div class="row mb-2">
    <div class="col-12">
        <small><b>B. Informasi Pribadi</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Gender</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $gender; ?></small>
    </div>
</div>
<div class="row mb-4">
    <div class="col-5"><small>Tanggal Lahir</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $tgl_lahir; ?></small>
    </div>
</div>
<hr>
<div class="row mb-2">
    <div class="col-12">
        <small><b>C. Alamat Dan Kontak</b></small>
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
<div class="row mb-4">
    <div class="col-5"><small>Alamat Email</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $email; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-12">
        <small><b>D. Metadata</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Creat By</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $creat_by_name; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Creat At</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $creat_at_user; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Update By</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $update_by_name; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Update At</small></div>
    <div class="col-1 text-center"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $update_at_user; ?></small>
    </div>
</div>

