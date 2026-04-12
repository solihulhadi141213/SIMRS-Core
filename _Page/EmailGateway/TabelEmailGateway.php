<?php
    // Inisiasai $JumlahEmailGateway
    $JumlahEmailGateway = 0;

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
    $QryEmailGateway = mysqli_query($Conn, "SELECT id_setting_email_gateway FROM setting_email_gateway");
    $JumlahEmailGateway = mysqli_num_rows($QryEmailGateway);
    if(empty($JumlahEmailGateway)){
        echo '
            <tr>
                <td align="center" colspan="6">
                    <small class="text text-danger">API Key Tidak Ditemukan</small>
                </td>
            </tr>
        ';
        exit;
    }
    $no = 1;
    $query = mysqli_query($Conn, "SELECT * FROM setting_email_gateway");
    while ($data = mysqli_fetch_array($query)) {
        $id_setting_email_gateway = $data['id_setting_email_gateway'];
        $status = $data['status'];

        // Routing Status
        if($status==1){
            $label_status = '<span class="text text-success">Aktif</span>';
        }else{
            $label_status = '<span class="text text-danger">No Aktif</span>';
        }
        // Menampilkan Data
        echo '
            <tr>
                <td class="text-center">
                    <small class="text text-muted">'.$no.'</small>
                </td>
                <td class="text-left">
                    <a href="javascript:void(0);" class="modal_detail_email_gateway" data-id="'.$data['id_setting_email_gateway'].'">
                        <small class="text text-primary text-decoration-underline">'.$data['email_gateway'].'</small>
                    </a>
                </td>
                <td class="text-left">
                    <small class="text text-muted">'.$data['url_provider'].'</small>
                </td>
                <td class="text-left">
                    <small class="text text-muted">'.$data['port_gateway'].'</small>
                </td>
                <td class="text-center">
                    <small>'.$label_status.'</small>
                </td>
                <td class="text-center">
                    <a href="javascript:void(0);" class="p-2 text-dark" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_detail_email_gateway" data-id="'.$data['id_setting_email_gateway'].'">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_edit_email_gateway" data-id="'.$data['id_setting_email_gateway'].'">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_kirim_email" data-id="'.$data['id_setting_email_gateway'].'">
                                <i class="bi bi-send"></i> Kirim Email
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_hapus_email_gateway" data-id="'.$data['id_setting_email_gateway'].'">
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
    var JumlahEmailGateway = <?php echo $JumlahEmailGateway; ?>;
    $('#page_info').html('Data : '+JumlahEmailGateway+' Record');
</script>