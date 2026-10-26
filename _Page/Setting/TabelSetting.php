<?php
    $JumlahSetting = 0;
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '<tr><td align="center" colspan="7"><small class="text-danger">Sesi Akses Berakhir! Silahkan Login Ulang!</small></td></tr>';
        exit;
    }

    $stmt = $Conn->prepare("
        SELECT id_setting, setting_name, base_url, hospital_name, logo, status
        FROM setting
        ORDER BY id_setting DESC
    ");
    $stmt->execute();
    $result = $stmt->get_result();
    $JumlahSetting = $result->num_rows;

    if ($JumlahSetting === 0) {
        echo '<tr><td align="center" colspan="7"><small class="text-muted">Data Pengaturan Aplikasi Tidak Ditemukan</small></td></tr>';
    } else {
        $escape = static function ($value): string {
            return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
        };
        $no = 1;
        while ($data = $result->fetch_assoc()) {
            $idSetting = (int) $data['id_setting'];
            $statusLabel = (int) $data['status'] === 1
                ? '<small class="text-success">Aktif</small>'
                : '<small class="text-danger">Tidak Aktif</small>';
            $logoName = basename((string) $data['logo']);
            $logoPath = 'assets/img/logo/no-image.jpg';
            if ($logoName !== '') {
                if (is_file(__DIR__ . '/../../assets/img/logo/' . $logoName)) {
                    $logoPath = 'assets/img/logo/' . rawurlencode($logoName);
                } elseif (is_file(__DIR__ . '/../../assets/images/' . $logoName)) {
                    $logoPath = 'assets/images/' . rawurlencode($logoName);
                } elseif (is_file(__DIR__ . '/../../_File/Setting/' . $logoName)) {
                    $logoPath = '_File/Setting/' . rawurlencode($logoName);
                }
            }

            echo '
                <tr>
                    <td class="text-center"><small class="text-muted">' . $no . '</small></td>
                    <td><a href="javascript:void(0);" class="modal_detail_setting" data-id="' . $idSetting . '"><small class="text-primary text-decoration-underline">' . $escape($data['setting_name']) . '</small></a></td>
                    <td><small><code class="text-muted">' . $escape($data['base_url']) . '</code></small></td>
                    <td><small class="text-muted">' . $escape($data['hospital_name']) . '</small></td>
                    <td><img class="img-fluid" src="' . $escape($logoPath) . '" alt="Logo ' . $escape($data['hospital_name']) . '" width="48" height="48"></td>
                    <td class="text-center">' . $statusLabel . '</td>
                    <td class="text-center">
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="p-2 text-dark" data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu shadow">
                                <li><a href="javascript:void(0);" class="dropdown-item modal_detail_setting" data-id="' . $idSetting . '"><i class="bi bi-info-circle"></i> Detail</a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item edit_setting" data-id="' . $idSetting . '"><i class="bi bi-pencil"></i> Edit</a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item modal_hapus_setting" data-id="' . $idSetting . '"><i class="bi bi-trash"></i> Hapus</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            ';
            $no++;
        }
    }

    $stmt->close();
?>
<script>
    var JumlahSetting = <?php echo $JumlahSetting; ?>;
    $('#page_info').html('Data : ' + JumlahSetting + ' Record');
</script>
