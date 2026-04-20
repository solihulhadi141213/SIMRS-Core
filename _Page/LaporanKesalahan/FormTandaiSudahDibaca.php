<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    // Validasi session
    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger">Sesi berakhir</div>';
        exit;
    }

    // Ambil ID
    $id_akses_laporan = $_POST['id_akses_laporan'] ?? '';

    if (empty($id_akses_laporan)) {
        echo '<div class="alert alert-danger text-center">ID Laporan Tidak Boleh Kosng!</div>';
        exit;
    }

    // Buka Data Dengan Prepared Statment
    $stmt = $Conn->prepare("SELECT * FROM akses_laporan WHERE id_akses_laporan = ?");
    $stmt->bind_param("i", $id_akses_laporan);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    // Jika Data Tidak Ditemukan
    if (!$data) {
        echo '<div class="alert alert-danger text-center">Data tidak ditemukan</div>';
        exit;
    }

    // Buat Variabel
    $id_akses = $data['id_akses'] ?? '-';
    $judul    = $data['judul'] ?? '-';
    $laporan  = $data['laporan'] ?? '-';
    $response = $data['response'] ?? '-';
    $tanggal  = date('d/m/Y H:i', strtotime($data['tanggal']));
    $status   = $data['status'];
    
    if($status=="Terkirim"){
        $label_status = '<span class="py-1 px-2 bg-warning rounded-2"><small>Terkirim</small></span>';
    }else{
        if($status=="Dibaca"){
            $label_status = '<span class="py-1 px-2 bg-info rounded-2"><small>Dibaca</small></span>';
        }else{
            if($status=="Selesai"){
                $label_status = '<span class="py-1 px-2 bg-success rounded-2"><small>Selesai</small></span>';
            }else{
                if($status=="Draft"){
                    $label_status = '<span class="py-1 px-2 bg-secondary text-white rounded-2"><small>Draft</small></span>';
                }else{
                    $label_status = '<span class="py-1 px-2 bg-dark rounded-2"><small>None</small></span>';
                }
            }
        }
    }

    // Nama User
    $nama = getDataDetail_v2($Conn, 'akses', 'id_akses', $id_akses, 'nama')
?>
<input type="hidden" name="id_akses_laporan" value="<?php echo $id_akses_laporan; ?>">
<div class="row mb-3">
    <div class="col-5"><small>Nama Pengguna</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $nama; ?></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>Tanggal</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $tanggal; ?></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-5"><small>Judul Laporan</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-muted"><?php echo $judul; ?></small>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="alert alert-info text-center">
            <b>PENTING!</b><br>
            <small>
                Pengguna / User akan mengetahui bahwa laporannya sudah dibaca.<br>
                <b>Apakah anda yakin akan memperbaharui status laporan ini?</b>
            </small>
        </div>
    </div>
</div>

