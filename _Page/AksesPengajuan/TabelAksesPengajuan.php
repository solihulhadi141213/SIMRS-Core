<?php
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // ===============================
    // VALIDASI SESSION
    // ===============================
    if (empty($SessionIdAkses)) {
        echo '
            <tr>
                <td align="center" colspan="6">
                    <small class="text-danger">Sesi Akses Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
            <script>
                $("#page_info").html("0/0");
                $("#previous_page").prop("disabled", true);
                $("#next_page").prop("disabled", true);
            </script>
        ';
        exit;
    }

    // Default
    $JmlHalaman = 0;

    // ===============================
    // INPUT
    // ===============================
    $keyword_by = $_POST['keyword_by'] ?? '';
    $keyword    = $_POST['keyword'] ?? '';
    $batas      = (int) ($_POST['batas'] ?? 10);
    $page       = (int) ($_POST['page'] ?? 1);
    $ShortBy    = strtoupper($_POST['ShortBy'] ?? 'DESC');
    $OrderBy    = $_POST['OrderBy'] ?? 'id_akses_pengajuan';


    // ===============================
    // VALIDASI
    // ===============================
    $batas = in_array($batas, [5,10,25,50,100,250,500]) ? $batas : 10;
    $page  = ($page > 0) ? $page : 1;
    $posisi = ($page - 1) * $batas;

    // 🔥 Mapping OrderBy (frontend → database)
    $order_map = [
        'id_akses_pengajuan' => 'a.id_akses_pengajuan',
        'nama'               => 'a.nama',
        'email'              => 'a.email',
        'status'             => 'a.status',
        'tanggal'            => 'a.tanggal'
    ];
    $OrderBy = $order_map[$OrderBy] ?? 'a.id_akses_pengajuan';

    // validasi sort
    $ShortBy = in_array($ShortBy, ['ASC','DESC']) ? $ShortBy : 'DESC';

    // ===============================
    // WHERE
    // ===============================
    $where = "";
    $params = [];
    $types = "";

    if (!empty($keyword)) {

        if ($keyword_by === 'nama') {
            $where = " WHERE a.nama LIKE ?";
            $params[] = "%$keyword%";
            $types .= "s";

        } elseif ($keyword_by === 'email') {
            $where = " WHERE a.email LIKE ?";
            $params[] = "%$keyword%";
            $types .= "s";

        } elseif ($keyword_by === 'tanggal') {
            $where = " WHERE DATE(a.tanggal) = ?";
            $params[] = $keyword;
            $types .= "s";

        } elseif ($keyword_by === 'status') {
            $where = " WHERE a.status LIKE ?";
            $params[] = "%$keyword%";
            $types .= "s";

        } else {
            // fallback search
            $where = " WHERE a.nama LIKE ? OR a.email LIKE ? OR a.tanggal LIKE ? OR a.status LIKE ?";
            $params = ["%$keyword%", "%$keyword%", "%$keyword%", "%$keyword%"];
            $types = "ssss";
        }
    }

    // ===============================
    // COUNT
    // ===============================
    $sql_count = "SELECT COUNT(*) as total FROM akses_pengajuan a $where";
    $stmt_count = mysqli_prepare($Conn, $sql_count);

    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt_count, $types, ...$params);
    }

    mysqli_stmt_execute($stmt_count);
    $result_count = mysqli_stmt_get_result($stmt_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $jml_data = $row_count['total'];

    if ($jml_data == 0) {
        $JmlHalaman = 0;
        $page = 0;
        echo '
            <tr>
                <td colspan="6" class="text-center">
                    <small class="text-danger">Data Tidak Ditemukan</small>
                </td>
            </tr>
        ';
    }else{

        $JmlHalaman = ceil($jml_data / $batas);
        $no = 1 + $posisi;

        // ===============================
        // QUERY DATA (JOIN FIX N+1)
        // ===============================
        $sql = "SELECT a.* FROM akses_pengajuan a $where ORDER BY $OrderBy $ShortBy LIMIT ?, ?";
        $stmt = mysqli_prepare($Conn, $sql);

        // bind dinamis
        if (!empty($params)) {
            $params[] = $posisi;
            $params[] = $batas;
            $types .= "ii";
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        } else {
            mysqli_stmt_bind_param($stmt, "ii", $posisi, $batas);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // ===============================
        // RENDER
        // ===============================
        while ($data = mysqli_fetch_assoc($result)) {

            $id_akses_pengajuan = $data['id_akses_pengajuan'];
            $nama               = htmlspecialchars($data['nama'] ?? '');
            $email              = htmlspecialchars($data['email'] ?? '');
            $status             = htmlspecialchars($data['status'] ?? '');
            if($status=="Pending"){
                $label_status = '<span class="py-1 px-2 bg-warning rounded-2"><small>Pending</small></span>';
            }else{
                if($status=="Ditolak"){
                    $label_status = '<span class="py-1 px-2 bg-danger rounded-2"><small>Ditolak</small></span>';
                }else{
                    if($status=="Diterima"){
                        $label_status = '<span class="py-1 px-2 bg-success rounded-2"><small>Diterima</small></span>';
                    }else{
                        $label_status = '<span class="py-1 px-2 bg-dark rounded-2"><small>None</small></span>';
                    }
                }
            }

            $tanggal = !empty($data['tanggal']) 
                ? date('d/m/Y H:i', strtotime($data['tanggal'])) 
                : '-';
            // Mencari ID akses
            $id_akses = getDataDetail_v2($Conn, 'akses', 'id_akses_pengajuan', $id_akses_pengajuan, 'id_akses');

            // Routing Label Nama Berdasarkan Ada/Tidak nya id_askes
            if(empty($id_akses)){
                $label_nama = '
                    <a href="javascript:void(0);" class="text-decoration-underline text-muted modal_detail" data-id="'.$id_akses_pengajuan.'">
                        <small>'.$nama.'</small>
                    </a>
                ';
            }else{
                $label_nama = '
                    <a href="javascript:void(0);" class="text-decoration-underline text-primary modal_detail" data-id="'.$id_akses_pengajuan.'">
                        <small>'.$nama.'</small>
                    </a>
                ';
            }

            // Routing Opsi 'Hubungkan Akun'
            $opsi_hubungkan_akun = '';
            $opsi_terima_pengajuan = '';

            // Jika Belum Memiliki id_askes dan Status Diterima
            if($status=="Diterima"){
                if(empty($id_akses)){
                    $opsi_hubungkan_akun = '
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_hubungkan_akun" data-id="'.$id_akses_pengajuan.'">
                                <i class="bi bi-arrow-left-right"></i> Hubungkan Akun
                            </a>
                        <li>
                    ';
                }
            }
            if($status=="Pending"){
                $opsi_terima_pengajuan = '
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item modal_terima_tolak" data-id="'.$id_akses_pengajuan.'">
                            <i class="bi bi-send"></i> Terima / Tolak
                        </a>
                    <li>
                ';
            }

            echo "
                <tr>
                    <td class='text-center'><small class='text-muted'>{$no}</small></td>
                    <td>{$label_nama}</td>
                    <td><small class='text-muted'>{$email}</small></td>
                    <td><small class='text-muted'>{$tanggal}</small></td>
                    <td class='text-center'>{$label_status}</td>
                    <td class='text-center'>
                        <a href='javascript:void(0);' class='btn-floating btn-sm' data-bs-toggle='dropdown'>
                            <i class='bi bi-three-dots-vertical'></i>
                        </a>
                        <ul class='dropdown-menu shadow'>
                            <li>
                                <a href='javascript:void(0);' class='dropdown-item modal_detail' data-id='{$id_akses_pengajuan}'>
                                    <i class='bi bi-info-circle'></i> Detail
                                </a>
                            </li>
                            <li>
                                <a href='javascript:void(0);' class='dropdown-item modal_edit' data-id='{$id_akses_pengajuan}'>
                                    <i class='bi bi-pencil'></i> Edit
                                </a>
                            </li>
                            {$opsi_hubungkan_akun}
                            {$opsi_terima_pengajuan}
                            <li>
                                <a href='javascript:void(0);' class='dropdown-item modal_hapus' data-id='{$id_akses_pengajuan}'>
                                    <i class='bi bi-trash'></i> Hapus
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
            ";

            $no++;
        }
    }
?>

<script>
    var keyword = '<?php echo $keyword; ?>';
    var keyword_by = '<?php echo $keyword_by; ?>';
    var page_count = <?php echo isset($JmlHalaman) ? $JmlHalaman : 0; ?>;
    var curent_page = <?php echo $page; ?>;

    $('#page_info').html(curent_page + ' / ' + page_count);
    $('#previous_page').prop('disabled', curent_page == 1 || curent_page == 0);
    $('#next_page').prop('disabled', curent_page >= page_count);

    // Reset highlight card
    $('.stat-card').removeClass('bg-secondary-subtle');

    // =========================
    // Highlight Card
    // =========================
    if (keyword_by === 'status') {

        if (keyword === 'Pending') {
            $('#jumlah_pending').closest('.stat-card').addClass('bg-secondary-subtle');
        }

        if (keyword === 'Ditolak') {
            $('#jumlah_ditolak').closest('.stat-card').addClass('bg-secondary-subtle');
        }

        if (keyword === 'Diterima') {
            $('#jumlah_diterima').closest('.stat-card').addClass('bg-secondary-subtle');
        }

        if (keyword === '') {
            $('#jumlah_total').closest('.stat-card').addClass('bg-secondary-subtle');
        }
    }

</script>
