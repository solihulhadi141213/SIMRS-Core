<?php

    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi, Function
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '
            <tr>
                <td align="center" colspan="8">
                    <small class="text-danger">Sesi akses berakhir! Silakan login ulang!</small>
                </td>
            </tr>
        ';
        exit;
    }

    // Menangkap Hari
    if(empty($_POST['Hari'])){
        $Hari = "Senin";
    }else{
        $Hari = $_POST['Hari'];
    }

    // Menghitung Jumlah Data
    $jumlah_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_jadwal FROM jadwal_dokter WHERE hari = '$Hari'"));
    if(empty($jumlah_data)){
        echo '
            <tr>
                <td align="center" colspan="8">
                    <small class="text-danger">Data Tidak Ditemukan!</small>
                </td>
            </tr>
        ';
        exit;
    }

    // Menampilkan Data Jadwal Dokter
    $no = 1;
    $sql = "SELECT*FROM jadwal_dokter WHERE hari = '$Hari'";
    $stmt = mysqli_prepare($Conn, $sql);
    if (!$stmt) {
        echo '
            <tr>
                <td align="center" colspan="8">
                    <small class="text-danger">Data Tidak Ditemukan</small>
                </td>
            </tr>
        ';
        exit;
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($data = mysqli_fetch_assoc($result)) {
        $id_jadwal     = (int) $data['id_jadwal'];
        $id_dokter     = (int) $data['id_dokter'];
        $id_poliklinik = (int) $data['id_poliklinik'];
        $jam_mulai     = $data['jam_mulai'];
        $jam_selesai   = $data['jam_selesai'];
        $kuota_non_jkn = $data['kuota_non_jkn'];
        $kuota_jkn     = $data['kuota_jkn'];
        $time_max      = $data['time_max'];
        
        // Buka Nama Dokter Dari Tabel 'dokter'
        $nama_dokter = getDataDetail_v2($Conn, 'dokter', 'id_dokter', $id_dokter, 'nama');

        // Buka Nama Poli dari tabel 'poliklinik'
        $poliklinik = getDataDetail_v2($Conn, 'poliklinik', 'id_poliklinik', $id_poliklinik, 'poliklinik');

        // Tampilkan Data
        echo '
            <tr>
                <td class="text-center">
                    <small class="text-muted">' . $no . '</small>
                </td>
                <td class="text-left">
                    <small class="text-muted">' . $nama_dokter . '</small>
                </td>
                <td class="text-left">
                    <small class="text-muted">' . $poliklinik . '</small>
                </td>
                <td class="text-left">
                    <small class="text-muted">' . $jam_mulai . '</small>
                </td>
                <td class="text-left">
                    <small class="text-muted">' . $jam_selesai . '</small>
                </td>
                <td class="text-left">
                    <small class="text-muted">' . $kuota_non_jkn . '</small>
                </td>
                <td class="text-left">
                    <small class="text-muted">' . $kuota_jkn . '</small>
                </td>
                <td class="text-center">
                    <a href="javascript:void(0);" class="btn-sm btn-floating" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_detail" data-id="' . $id_jadwal . '">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_edit" data-id="' . $id_jadwal . '">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_hapus" data-id="' . $id_jadwal . '">
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
