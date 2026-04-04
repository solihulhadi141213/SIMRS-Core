<?php
    //Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";
    
    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Validasi Sessi Akses
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger">
                <small class="text text-danger">Sesi Akses Berakhir! Silahkan Login Ulang!</small>
            </tr>
            <script>
                $("#page_laporan_kesalahan").html("0 / 0");
                $("#prev_btn_laporan_kesalahan").prop("disabled", true);
                $("#next_btn_laporan_kesalahan").prop("disabled", true);
            </script>
        ';
        exit;
    }

    $limit = 5;

    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $limit;
    }else{
        $page="1";
        $posisi = 0;
    }

    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses_laporan FROM akses_laporan WHERE id_akses='$SessionIdAkses'"));
    if(empty($jml_data)){
        echo '
            <div class="alert alert-danger">
                <small class="text text-danger">Belum ada laporan yang anda buat!</small>
            </tr>
            <script>
                $("#page_laporan_kesalahan").html("0 / 0");
                $("#prev_btn_laporan_kesalahan").prop("disabled", true);
                $("#next_btn_laporan_kesalahan").prop("disabled", true);
            </script>
        ';
        exit;
    }
    echo '<ol class="list-group list-group-numbered mb-0">';
    $no = 1;
    $QryLaporan = mysqli_query($Conn, "SELECT*FROM akses_laporan WHERE id_akses='$SessionIdAkses' ORDER BY id_akses_laporan DESC LIMIT $posisi, $limit");
    while ($DataLaporan = mysqli_fetch_array($QryLaporan)) {
        $id_akses_laporan = $DataLaporan['id_akses_laporan'];
        $tanggal          = $DataLaporan['tanggal'];
        $judul            = $DataLaporan['judul'];
        $status           = $DataLaporan['status'];
        if($status=="Terkirim"){
            $label_status = '
                <small class="text-danger" title="Terkirim">
                    <small>
                        <i class="bi bi-send"></i> Terkirim
                    </small>
                </small>
            ';
        }
        if($status=="Dibaca"){
            $label_status = '
                <small class="text-primary" title="Dibaca">
                    <small>
                        <i class="bi bi-eye"></i> Dibaca
                    </small>
                </small>
            ';
        }
         if($status=="Selesai"){
            $label_status = '
                <small class="text-success" title="Selesai">
                    <small>
                        <i class="bi bi-check-circle"></i> Selesai
                    </small>
                </small>
            ';
        }
        echo '
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="text-primary">
                        <a href="javascript:coid(0);" class="text-primary">'.$judul.'</a>
                    </div>
                    <small>
                        <small class="text-muted">
                            '.date('d/m/Y H:i', strtotime($tanggal)).'
                        </small> 
                        <small class="text-muted">
                            ('.$status.')
                        </small> 
                    </small>
                </div>
                <div class="text-end">
                    <a href="javascript:coid(0);" class="p-2" data-bs-toggle="dropdown" aria-expanded="false" title="Option">
                        <i class="bi bi-three-dots-vertical"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        ';
    }
    echo '</ol>';

?>