<?php
    // Inisiasai $JumlahSetting
    $JumlahSetting = 0;

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
                <td align="center" colspan="7">
                    <small class="text text-danger">Sesi Akses Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
        ';
        exit;
    }
    
    // Jumlah Data
    $QrySetting = mysqli_query($Conn, "SELECT id_setting FROM setting");
    $JumlahSetting = mysqli_num_rows($QrySetting);
    if(empty($JumlahSetting)){
        echo '
            <tr>
                <td align="center" colspan="7">
                    <small class="text text-danger">data Pengaturan Aplikasi Tidak Ditemukan</small>
                </td>
            </tr>
        ';
        exit;
    }
    $no = 1;
    $query = mysqli_query($Conn, "SELECT * FROM setting");
    while ($data = mysqli_fetch_array($query)) {
        if($data['status']==1){
            $label_status = '<small class="text-success">Active</small>';
        }else{
            $label_status = '<small class="text-danger">No Active</small>';
        }
        echo '
            <tr>
                <td class="text-center">
                    <small class="text text-muted">'.$no.'</small>
                </td>
                <td class="text-left">
                    <a href="javascript:void(0);" class="modal_detail_setting" data-id="'.$data['id_setting'].'">
                        <small class="text text-primary text-decoration-underline">'.$data['setting_name'].'</small>
                    </a>
                </td>
                <td class="text-left">
                    <small class="text text-muted">'.$data['aplication_name'].'</small>
                </td>
                <td class="text-left">
                    <small><code class="text text-muted">'.$data['base_url'].'</code></small>
                </td>
                <td class="text-left">
                    <small class="text text-muted">'.$data['hospital_name'].'</small>
                </td>
                <td class="text-center">
                    <small class="">'.$label_status.'</small>
                </td>
                <td class="text-center">
                    <a href="javascript:void(0);" class="p-2 text-dark" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_detail_setting" data-id="'.$data['id_setting'].'">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item edit_setting" data-id="'.$data['id_setting'].'">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_hapus_setting" data-id="'.$data['id_setting'].'">
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
    var JumlahSetting = <?php echo $JumlahSetting; ?>;
    $('#page_info').html('Data : '+JumlahSetting+' Record');
</script>