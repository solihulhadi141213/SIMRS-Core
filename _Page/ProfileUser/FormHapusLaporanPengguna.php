<?php
     //Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";
    
    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Cek hasil validasi session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                Sesi Akses Sudah Berakhir! Silahkan Login Ulang!
            </div>
        ';
        exit;
    }
    //Tangkap id_akses_laporan
    if(empty($_POST['id_akses_laporan'])){
        echo '
            <div class="alert alert-danger">
                ID Laporan Tidak Boleh Kosong!
            </div>
        ';
        exit;
    }
    $id_akses_laporan=$_POST['id_akses_laporan'];
    $stmt = mysqli_prepare($Conn,"SELECT * FROM akses_laporan WHERE id_akses_laporan = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt,"i",$id_akses_laporan);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $Data = mysqli_fetch_array($result,MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);

    // Jika Data Tidak Ditemukan
    if (empty($Data['id_akses_laporan'])) {
        echo '
            <div class="alert alert-danger">
                Data Laporan Tidak Ditemukan!
            </div>
        ';
        exit;
       
    }
    $tanggal  = $Data['tanggal'];
    $judul    = $Data['judul'];
    $laporan  = $Data['laporan'];
    $response = $Data['response'] ?? '<span class="text-danger">Belum Ada</span>';
    $status   = $Data['status'];

    // Routing Status
    if($status=="Draft"){
        $label_status = '<span class="badge badge-warning"><i class="bi bi-filetype-doc"></i> Draft</span>';
    }else{
        if($status=="Terkirim"){
            $label_status = '<span class="badge badge-info"><i class="bi bi-send"></i> Terkirim</span>';
        }else{
            if($status=="Dibaca"){
                $label_status = '<span class="badge badge-primary"><i class="bi bi-eye"></i> Dibaca</span>';
            }else{
                if($status=="Selesai"){
                    $label_status = '<span class="badge badge-success"><i class="bi bi-check"></i> Selesai</span>';
                }
            }
        }
    }

    // Tampilkan Data
    echo '
        <input type="hidden" name="id_akses_laporan" value="'.$id_akses_laporan.'">
        <div class="row mb-3">
            <div class="col-4"><small>Tanggal</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text text-muted">'.date('d/m/Y H:i', strtotime($tanggal)).'</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4"><small>Judul</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text text-muted">'.$judul.'</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4"><small>Status</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text text-muted">'.$label_status.'</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    <h4>PENTING!</h4>
                    <small>Apakah anda benar-benar yakin ingin menghapus laporan tersebut?</small>
                </div>
            </div>
        </div>
    ';
?>