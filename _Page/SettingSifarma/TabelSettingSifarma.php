<?php
    $JumlahSifarma = 0;

    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '
            <tr>
                <td align="center" colspan="6">
                    <small class="text text-danger">Sesi akses berakhir! Silakan login ulang!</small>
                </td>
            </tr>
        ';
        exit;
    }

    $QrySifarma = mysqli_query($Conn, "SELECT id_setting_sifarma FROM setting_sifarma");
    $JumlahSifarma = mysqli_num_rows($QrySifarma);

    if (empty($JumlahSifarma)) {
        echo '
            <tr>
                <td align="center" colspan="6">
                    <small class="text text-danger">Setting Sifarma tidak ditemukan</small>
                </td>
            </tr>
        ';
        exit;
    }

    $no = 1;
    $query = mysqli_query($Conn, "SELECT * FROM setting_sifarma ORDER BY id_setting_sifarma DESC");
    while ($data = mysqli_fetch_array($query)) {
        $status = $data['status'] ?? 0;

        if ($status == 1) {
            $label_status = '
                <span class="px-2 py-1 bg-success-subtle text-success rounded-1">
                    <i class="bi bi-check"></i>
                </span>
            ';
        } else {
            $label_status = '
                <span class="px-2 py-1 bg-danger-subtle text-danger rounded-1">
                    <i class="bi bi-x-circle"></i>
                </span>
            ';
        }

        echo '
            <tr>
                <td class="text-center">
                    <small class="text text-muted">'.$no.'</small>
                </td>
                <td class="text-left">
                    <a href="javascript:void(0);" class="modal_detail_setting_sifarma" data-id="'.$data['id_setting_sifarma'].'">
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
                            <a href="javascript:void(0);" class="dropdown-item modal_detail_setting_sifarma" data-id="'.$data['id_setting_sifarma'].'">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_koneksi_setting_sifarma" data-id="'.$data['id_setting_sifarma'].'">
                                <i class="bi bi-arrow-left-right"></i> Uji Coba Koneksi
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_edit_setting_sifarma" data-id="'.$data['id_setting_sifarma'].'">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_hapus_setting_sifarma" data-id="'.$data['id_setting_sifarma'].'">
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
    var JumlahSifarma = <?php echo $JumlahSifarma; ?>;
    $('#page_info').html('Data : ' + JumlahSifarma + ' Record');
</script>
