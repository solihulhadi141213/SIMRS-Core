<?php
    // Inisiasai $JumlahGoogleCredential
    $JumlahGoogleCredential = 0;

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
                <td align="center" colspan="5">
                    <small class="text text-danger">Sesi Akses Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
        ';
        exit;
    }
    
    // Jumlah Data
    $QryGoogleCredential = mysqli_query($Conn, "SELECT id_setting_google FROM setting_google");
    $JumlahGoogleCredential = mysqli_num_rows($QryGoogleCredential);
    if(empty($JumlahGoogleCredential)){
        echo '
            <tr>
                <td align="center" colspan="5">
                    <small class="text text-danger">Google Credential Tidak Ditemukan</small>
                </td>
            </tr>
        ';
        exit;
    }
    $no = 1;
    $query = mysqli_query($Conn, "SELECT * FROM setting_google");
    while ($data = mysqli_fetch_array($query)) {
        $id_setting_google = $data['id_setting_google'];
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
                    <a href="javascript:void(0);" class="modal_detail_google_credential" data-id="'.$data['id_setting_google'].'">
                        <small class="text text-primary text-decoration-underline">'.$data['credential_env'].'</small>
                    </a>
                </td>
                <td class="text-left">
                    <small class="text text-muted">'.$data['client_id'].'</small>
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
                            <a href="javascript:void(0);" class="dropdown-item modal_detail_google_credential" data-id="'.$data['id_setting_google'].'">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_edit_google_credential" data-id="'.$data['id_setting_google'].'">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_hapus_google_credential" data-id="'.$data['id_setting_google'].'">
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
    var JumlahGoogleCredential = <?php echo $JumlahGoogleCredential; ?>;
    $('#page_info').html('Data : '+JumlahGoogleCredential+' Record');
</script>