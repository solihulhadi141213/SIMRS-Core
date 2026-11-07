<?php
    // Inisiasai $JumlahApiKey
    $JumlahApiKey = 0;

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
                <td align="center" colspan="8">
                    <small class="text text-danger">Sesi Akses Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
        ';
        exit;
    }
    
    // Jumlah Data
    // Prepared Statement: count API key records.
    $stmtCount = mysqli_prepare($Conn, "SELECT id_api_key FROM api_key");
    mysqli_stmt_execute($stmtCount);
    $QryApiKey = mysqli_stmt_get_result($stmtCount);
    $JumlahApiKey = mysqli_num_rows($QryApiKey);
    mysqli_stmt_close($stmtCount);
    if(empty($JumlahApiKey)){
        echo '
            <tr>
                <td align="center" colspan="8">
                    <small class="text text-danger">API Key Tidak Ditemukan</small>
                </td>
            </tr>
        ';
        exit;
    }
    $no = 1;
    // Prepared Statement: fetch API key records.
    $stmtKeys = mysqli_prepare($Conn, "SELECT * FROM api_key");
    mysqli_stmt_execute($stmtKeys);
    $query = mysqli_stmt_get_result($stmtKeys);
    while ($data = mysqli_fetch_array($query)) {
        $id_api_key = $data['id_api_key'];
        
        // Hitung Log Token
        // Prepared Statement: count API token logs for this key.
        $stmtTokenCount = mysqli_prepare($Conn, "SELECT id_api_token FROM api_token WHERE id_api_key=?");
        mysqli_stmt_bind_param($stmtTokenCount, 's', $id_api_key);
        mysqli_stmt_execute($stmtTokenCount);
        $tokenRows = mysqli_stmt_get_result($stmtTokenCount);
        $log_token = mysqli_num_rows($tokenRows);
        mysqli_stmt_close($stmtTokenCount);
        if ($log_token >= 1000000) {
            $log_token_show = round($log_token / 1000000, 1) . ' M';
        } elseif ($log_token >= 1000) {
            $log_token_show = round($log_token / 1000, 1) . ' K';
        } else {
            $log_token_show = $log_token;
        }

        // Menampilkan Data
        echo '
            <tr>
                <td class="text-center">
                    <small class="text text-muted">'.$no.'</small>
                </td>
                <td class="text-left">
                    <a href="javascript:void(0);" class="modal_detail_api_key" data-id="'.$data['id_api_key'].'">
                        <small class="text text-primary text-decoration-underline">'.$data['api_name'].'</small>
                    </a>
                </td>
                <td class="text-left">
                    <small class="text text-muted">'.$data['client_id'].'</small>
                </td>
                <td class="text-left">
                    <small class="text text-muted">'.$data['expired_duration'].' Hour</small>
                </td>
                <td class="text-left">
                    <small class="text text-muted">'.date('d/m/Y H:i', strtotime($data['datetime_creat'])).'</small>
                </td>
                <td class="text-left">
                    <small class="text text-muted">'.date('d/m/Y H:i', strtotime($data['datetime_update'])).'</small>
                </td>
                <td class="text-center">
                    <small class="text text-muted">'.$log_token_show.'</small>
                </td>
                <td class="text-center">
                    <a href="javascript:void(0);" class="p-2 text-dark" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_detail_api_key" data-id="'.$data['id_api_key'].'">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_edit_api_key" data-id="'.$data['id_api_key'].'">
                                <i class="bi bi-pencil"></i> Edit Credential
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_regenerate_client_key" data-id="'.$data['id_api_key'].'">
                                <i class="bi bi-repeat"></i> Regenerate Client Key
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_hapus_log_token" data-id="'.$data['id_api_key'].'">
                                <i class="bi bi-clock-history"></i> Hapus Log Token
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_hapus_api_key" data-id="'.$data['id_api_key'].'">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
        ';
        $no++;
    }
    mysqli_stmt_close($stmtKeys);
?>
<script>
    var JumlahApiKey = <?php echo $JumlahApiKey; ?>;
    $('#page_info').html('Data : '+JumlahApiKey+' Record');
</script>