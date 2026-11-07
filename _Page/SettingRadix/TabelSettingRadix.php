<?php
    // Inisiasai $JumlahRadix
    $JumlahRadix = 0;

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
    // Prepared Statement: count Radix settings.
    $stmtCount = mysqli_prepare($Conn, "SELECT id_setting_radix FROM setting_radix");
    mysqli_stmt_execute($stmtCount);
    $QryRadix = mysqli_stmt_get_result($stmtCount);
    $JumlahRadix = mysqli_num_rows($QryRadix);
    mysqli_stmt_close($stmtCount);
    if(empty($JumlahRadix)){
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
    // Prepared Statement: fetch Radix settings.
    $stmt = mysqli_prepare($Conn, "SELECT * FROM setting_radix ORDER BY id_setting_radix DESC");
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);
    while ($data = mysqli_fetch_array($query)) {
        $id_setting_radix = $data['id_setting_radix'];
        $status               = $data['status'];

        // Routing Status
        if($status==1){
            $label_status = '
                <span class="px-2 py-1 bg-success-subtle text-success rounded-1">
                    <i class="bi bi-check"></i>
                </span>
            ';
        }else{
            $label_status = '
                <span class="px-2 py-1 bg-danger-subtle text-danger rounded-1">
                    <i class="bi bi-x-circle"></i>
                </span>
            ';
        }
        // Menampilkan Data
        echo '
            <tr>
                <td class="text-center">
                    <small class="text text-muted">'.$no.'</small>
                </td>
                <td class="text-left">
                    <a href="javascript:void(0);" class="modal_detail_setting_radix" data-id="'.$data['id_setting_radix'].'">
                        <small class="text text-primary text-decoration-underline">'.$data['setting_name'].'</small>
                    </a>
                </td>
                <td class="text-left">
                    <small class="text text-muted">'.$data['base_url'].'</small>
                </td>
                <td class="text-left">
                    <small class="text text-muted">'.$data['username'].'</small>
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
                            <a href="javascript:void(0);" class="dropdown-item modal_detail_setting_radix" data-id="'.$data['id_setting_radix'].'">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_koneksi_setting_radix" data-id="'.$data['id_setting_radix'].'">
                                <i class="bi bi-arrow-left-right"></i> Uji Coba Koneksi
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_edit_setting_radix" data-id="'.$data['id_setting_radix'].'">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_hapus_setting_radix" data-id="'.$data['id_setting_radix'].'">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
        ';
        $no++;
    }
    mysqli_stmt_close($stmt);
?>
<script>
    var JumlahRadix = <?php echo $JumlahRadix; ?>;
    $('#page_info').html('Data : '+JumlahRadix+' Record');
</script>