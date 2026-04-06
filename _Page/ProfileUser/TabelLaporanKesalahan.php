<?php
    // Zona Waktu
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
            </div>
            <script>
                $("#page_info_laporan_kesalahan").html("0 / 0");
                $("#prev_btn_laporan_kesalahan").prop("disabled", true);
                $("#next_btn_laporan_kesalahan").prop("disabled", true);
            </script>
        ';
        exit;
    }

    $limit = 5;

    // --- PERBAIKAN LOGIKA PAGE (PENTING!) ---
    // Pastikan page adalah integer, minimal bernilai 1
    if(!empty($_POST['page'])){
        $page = (int)$_POST['page'];
        if($page < 1) { $page = 1; } // Proteksi jika input 0 atau negatif
    } else {
        $page = 1;
    }
    
    $posisi = ($page - 1) * $limit;

    // Hitung Jumlah Data
    $query_jml = mysqli_query($Conn, "SELECT id_akses_laporan FROM akses_laporan WHERE id_akses='$SessionIdAkses'");
    $jml_data = mysqli_num_rows($query_jml);

    if($jml_data == 0){
        echo '
            <div class="alert alert-danger text-center">
                <small>Belum ada laporan yang anda buat!</small>
            </div>
            <script>
                $("#page_info_laporan_kesalahan").html("0 / 0");
                $("#prev_btn_laporan_kesalahan").prop("disabled", true);
                $("#next_btn_laporan_kesalahan").prop("disabled", true);
            </script>
        ';
        exit;
    }

    $JmlHalaman = ceil($jml_data / $limit); 

    echo '<ol class="list-group list-group-numbered mb-0">';
    
    // SQL Query dengan LIMIT yang sudah aman (tidak negatif)
    $QryLaporan = mysqli_query($Conn, "SELECT * FROM akses_laporan WHERE id_akses='$SessionIdAkses' ORDER BY id_akses_laporan DESC LIMIT $posisi, $limit");

    while ($DataLaporan = mysqli_fetch_array($QryLaporan)) {
        $id_akses_laporan = $DataLaporan['id_akses_laporan'];
        $tanggal          = $DataLaporan['tanggal'];
        $judul            = $DataLaporan['judul'];
        $status           = $DataLaporan['status'];
        
        // Tentukan Label Status Berdasarkan Nilai Database
        $label_status = '<small class="text-muted">('.$status.')</small>';
        if($status == "Draft"){
            $label_status = '
                <a href="javascript:void(0);" class="p-2 text-dark" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"></i>
                </a>
                <ul class="dropdown-menu shadow">
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_edit_laporan_pengguna" data-id="'.$id_akses_laporan.'">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_hapus_laporan_pengguna" data-id="'.$id_akses_laporan.'">
                            <i class="bi bi-trash"></i> Hapus / Batalkan
                        </a>
                    </li>
                </ul>
            ';
        }else{
            if($status == "Terkirim") { 
                $label_status = '<span class="badge bg-info"><i class="bi bi-send"></i> Terkirim</small>';
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

        echo '
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="text-primary">
                        <a href="javascript:void(0);" class="text-primary modal_detail_laporan_kesalahan" data-id="'.$id_akses_laporan.'">
                            '.htmlspecialchars($judul).'
                        </a>
                    </div>
                    <small>
                        <small class="text-muted">'.date('d/m/Y H:i', strtotime($tanggal)).'</small> 
                    </small>
                </div>
                <div class="text-end">
                    '.$label_status.'
                </div>
            </li>';
    }
    echo '</ol>';
?>

<script>
    // Create Javascript Variables
    var page_count = <?php echo (int)$JmlHalaman; ?>;
    var current_page = <?php echo (int)$page; ?>;
    
    // Put Into Paging Element
    $('#page_info_laporan_kesalahan').html(current_page + ' / ' + page_count);
    
    // Set Paging Button State
    if(current_page <= 1){
        $('#prev_btn_laporan_kesalahan').prop('disabled', true);
    } else {
        $('#prev_btn_laporan_kesalahan').prop('disabled', false);
    }
    
    if(current_page >= page_count){
        $('#next_btn_laporan_kesalahan').prop('disabled', true);
    } else {
        $('#next_btn_laporan_kesalahan').prop('disabled', false);
    }
</script>