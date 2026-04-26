<?php
     // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi, Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Validasi Sesi Akses
    if (empty($SessionIdAkses)) {
        echo '
            <tr>
                <td colspan="9" class="text-center">
                    <small class="text-danger">Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
        ';
        exit;
    }

    // Ambil semua ruangan Yang Aktif
    $status = 1;
    $stmt_ruangan = $Conn->prepare("SELECT * FROM rr_ruang_rawat WHERE status = ? ORDER BY ruang_rawat ASC");
    $stmt_ruangan->bind_param("i", $status);
    $stmt_ruangan->execute();
    $result_ruangan = $stmt_ruangan->get_result();
    $ruangan_list = [];
    while ($row = $result_ruangan->fetch_assoc()) {
        $ruangan_list[] = $row;
    }
    $jumlah_ruangan = count($ruangan_list);
    $stmt_ruangan->close();

    // Jika Tidak Ada
    if(empty($jumlah_ruangan)){
        echo '
            <tr>
                <td colspan="10" class="text-center">
                    <small class="text-danger">Data Ruang Rawat Tidak Ada</small>
                </td>
            </tr>
        ';
        exit;
    }
    $no = 1;
    foreach ($ruangan_list as $ruang):
        $id_ruang_rawat   = $ruang['id_ruang_rawat'];
        $id_kelas_rawat   = $ruang['id_kelas_rawat'];
        $ruang_rawat      = htmlspecialchars($ruang['ruang_rawat']);
        $status_ruangan   = $ruang['status'];
        $updatetime_ruang = $ruang['updatetime'];
        $updatetime_format_ruang = date('d/m/Y H:i:s', strtotime($updatetime_ruang));

        // Buka Nama kelas Dan Kode kelas
        $kelas      = getDataDetail_v2($Conn, 'rr_kelas_rawat', 'id_kelas_rawat', $id_kelas_rawat, 'kelas');
        $kode_kelas = getDataDetail_v2($Conn, 'rr_kelas_rawat', 'id_kelas_rawat', $id_kelas_rawat, 'kode_kelas');

        // Menghitung Jumlah Kapasitas Tempat Tidur Yang Aktif
        $kapasitas_pria   = mysqli_num_rows(mysqli_query($Conn, "SELECT id_tempat_tidur FROM rr_tempat_tidur WHERE id_ruang_rawat='$id_ruang_rawat' AND pria=1 AND status=1"));
        $kapasitas_wanita = mysqli_num_rows(mysqli_query($Conn, "SELECT id_tempat_tidur FROM rr_tempat_tidur WHERE id_ruang_rawat='$id_ruang_rawat' AND wanita=1 AND status=1"));
        $kapasitas_bebas  = mysqli_num_rows(mysqli_query($Conn, "SELECT id_tempat_tidur FROM rr_tempat_tidur WHERE id_ruang_rawat='$id_ruang_rawat' AND bebas=1 AND status=1"));

        

        // Ketersediaan TT Untuk Pria
        $kapasitas_pria = 0;
        $tersedia_pria  = 0;
        $query_tt_pria = mysqli_query($Conn, "SELECT id_tempat_tidur FROM rr_tempat_tidur WHERE id_ruang_rawat='$id_ruang_rawat' AND pria=1 AND status=1");
        while ($data_tt_pria = mysqli_fetch_array($query_tt_pria)) {
            if(!empty($data_tt_pria['id_tempat_tidur'])){
                $kapasitas_pria  = $kapasitas_pria + 1;
                $id_tempat_tidur = $data_tt_pria['id_tempat_tidur'];

                // Cek Ada pasien Tidak
                $pasien_pria     = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE id_kasur='$id_tempat_tidur' AND status='Pending'"));
                if(empty($pasien_pria)){
                    $tersedia_pria = $tersedia_pria + 1;
                }else{
                    $tersedia_pria = $tersedia_pria + 0;
                }
            }
        }

        // Ketersediaan TT Untuk Wanita
        $kapasitas_wanita = 0;
        $tersedia_wanita  = 0;
        $query_tt_wanita = mysqli_query($Conn, "SELECT id_tempat_tidur FROM rr_tempat_tidur WHERE id_ruang_rawat='$id_ruang_rawat' AND wanita=1 AND status=1");
        while ($data_tt_wanita = mysqli_fetch_array($query_tt_wanita)) {
            if(!empty($data_tt_wanita['id_tempat_tidur'])){
                $kapasitas_wanita  = $kapasitas_wanita + 1;
                $id_tempat_tidur = $data_tt_wanita['id_tempat_tidur'];

                // Cek Ada pasien Tidak
                $pasien_wanita     = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE id_kasur='$id_tempat_tidur' AND status='Pending'"));
                if(empty($pasien_wanita)){
                    $tersedia_wanita = $tersedia_wanita + 1;
                }else{
                    $tersedia_wanita = $tersedia_wanita + 0;
                }
            }
        }

        // Ketersediaan TT Untuk Bebas
        $kapasitas_bebas = 0;
        $tersedia_bebas  = 0;
        $query_tt_bebas = mysqli_query($Conn, "SELECT id_tempat_tidur FROM rr_tempat_tidur WHERE id_ruang_rawat='$id_ruang_rawat' AND bebas=1 AND status=1");
        while ($data_tt_bebas = mysqli_fetch_array($query_tt_bebas)) {
            if(!empty($data_tt_bebas['id_tempat_tidur'])){
                $kapasitas_bebas  = $kapasitas_bebas + 1;
                $id_tempat_tidur = $data_tt_bebas['id_tempat_tidur'];

                // Cek Ada pasien Tidak
                $pasien_bebas     = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE id_kasur='$id_tempat_tidur' AND status='Pending'"));
                if(empty($pasien_bebas)){
                    $tersedia_bebas = $tersedia_bebas + 1;
                }else{
                    $tersedia_bebas = $tersedia_bebas + 0;
                }
            }
        }

        // Akumulasi Kapasitas
        $kapasitas = $kapasitas_pria + $kapasitas_wanita + $kapasitas_bebas;

        echo '
            <tr>
                <td class="text-center">
                    <small class="text-muted">'.$no.'</small>
                </td>
                <td class="text-left">
                    <small class="text-muted">'.$ruang_rawat.'</small>
                </td>
                <td class="text-left">
                    <small class="text-muted">RSES-RR-'.$id_ruang_rawat.'</small>
                </td>
                <td class="text-left">
                    <small class="text-muted">'.$kelas.'</small>
                </td>
                <td class="text-left">
                    <small class="text-muted">'.$kode_kelas.'</small>
                </td>
                <td class="text-center">
                    <small class="text-muted">'.$tersedia_pria.'</small>
                </td>
                <td class="text-center">
                    <small class="text-muted">'.$tersedia_wanita.'</small>
                </td>
                <td class="text-center">
                    <small class="text-muted">'.$tersedia_bebas.'</small>
                </td>
                <td class="text-center">
                    <small class="text-muted">'.$kapasitas.'</small>
                </td>
                <td class="text-center">
                    <small class="text-muted">None</small>
                </td>
            </tr>
        ';
    $no ++;
    endforeach; 

?>