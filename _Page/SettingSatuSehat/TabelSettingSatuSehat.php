<?php
    // Inisiasai $JumlahSatuSehat
    $JumlahSatuSehat = 0;

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
            <tr>
                <td align="center" colspan="6">
                    <small class="text text-danger">Sesi Akses Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
        ';
        exit;
    }
    
    // Jumlah Data
    $QrySatuSehat = mysqli_query($Conn, "SELECT id_setting_satusehat FROM setting_satusehat");
    $JumlahSatuSehat = mysqli_num_rows($QrySatuSehat);
    if(empty($JumlahSatuSehat)){
        echo '
            <tr>
                <td align="center" colspan="6">
                    <small class="text text-danger">Setting Satu Sehat Tidak Ditemukan</small>
                </td>
            </tr>
        ';
        exit;
    }
    $no = 1;
    $query = mysqli_query($Conn, "SELECT * FROM setting_satusehat");
    while ($data = mysqli_fetch_array($query)) {
        $id_setting_satusehat = $data['id_setting_satusehat'];
        $status               = $data['status_setting_satusehat'];

        // Routing Status
        if($status==1){
            $label_status = '<span class="px-2 py-1 bg-success-subtle text-success rounded-1"><small>Aktif</small></span>';
        }else{
            $label_status = '<span class="px-2 py-1 bg-danger-subtle text-danger rounded-1"><small>No Aktif</small></span>';
        }
        // Menampilkan Data
        echo '
            <tr>
                <td class="text-center">
                    <small class="text text-muted">'.$no.'</small>
                </td>
                <td class="text-left">
                    <a href="javascript:void(0);" class="modal_detail_setting_satusehat" data-id="'.$data['id_setting_satusehat'].'">
                        <small class="text text-primary text-decoration-underline">'.$data['nama_setting_satusehat'].'</small>
                    </a>
                </td>
                <td class="text-left">
                    <small class="text text-muted">'.$data['url_satusehat'].'</small>
                </td>
                <td class="text-left">
                    <small class="text text-muted">'.$data['client_key'].'</small>
                </td>
                <td class="text-center">
                    <small>'.$label_status.'</small>
                </td>
                <td class="text-center">
                    <a href="javascript:void(0);" class="btn-sm btn-floating" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_detail_setting_satusehat" data-id="'.$data['id_setting_satusehat'].'">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_koneksi_setting_satusehat" data-id="'.$data['id_setting_satusehat'].'">
                                <i class="bi bi-arrow-left-right"></i> Uji Coba Koneksi
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_edit_setting_satusehat" data-id="'.$data['id_setting_satusehat'].'">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_hapus_setting_satusehat" data-id="'.$data['id_setting_satusehat'].'">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
        ';
        $no++;
    }
?>
<script>
    var JumlahSatuSehat = <?php echo $JumlahSatuSehat; ?>;
    $('#page_info').html('Data : '+JumlahSatuSehat+' Record');
</script>