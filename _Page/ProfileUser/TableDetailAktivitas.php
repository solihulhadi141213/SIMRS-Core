<?php
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
                <td align="center" colspan="4">
                    <small class="text text-danger">Sesi Akses Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
        ';
        exit;
    }

    // Validasi kategori Tidak Boleh Kosong
    if(empty($_POST['kategori'])){
        echo '
            <tr>
                <td align="center" colspan="4">
                    <small class="text text-danger">Tentukan Kategori Data Terlebih Dulu!</small>
                </td>
            </tr>
        ';
        exit;
    }

     // Validasi periode Tidak Boleh Kosong
    if(empty($_POST['periode'])){
        echo '
            <tr>
                <td align="center" colspan="4">
                    <small class="text text-danger">Tentukan Periode Data Terlebih Dulu!</small>
                </td>
            </tr>
        ';
        exit;
    }

    $kategori = $_POST['kategori'];
    $periode  = $_POST['periode'];

    // PASIEN
    echo '<table class="table table-striped table-hover">';
    if($kategori=="Pasien"){
        echo '
            <thead>
                <tr>
                    <td class="text-center"><small><b>No</b></small></td>
                    <td class="text-left"><small><b>ID Pasien</b></small></td>
                    <td class="text-left"><small><b>Tanggal Data</b></small></td>
                    <td class="text-left"><small><b>Nama Pasien</b></small></td>
                </tr>
            </thead>
        ';
        echo '<tbody>';
        $no = 1;
        $query = mysqli_query($Conn, "SELECT id_pasien, registered_at, nama FROM pasien WHERE id_akses='$SessionIdAkses' AND registered_at LIKE '%$periode%'");
        while ($data = mysqli_fetch_array($query)) {
            echo '
                <tr>
                    <td class="text-center"><small class="text text-muted">'.$no.'</small></td>
                    <td class="text-left"><small class="text text-muted">'.$data['id_pasien'].'</small></td>
                    <td class="text-left"><small class="text text-muted">'.$data['registered_at'].'</small></td>
                    <td class="text-left"><small class="text text-muted">'.$data['nama'].'</small></td>
                </tr>
            ';
            $no++;
        }
        echo '</tbody>';
    }

    // KUNJUNGAN
    if($kategori=="Kunjungan"){

        echo '
            <thead>
                <tr>
                    <td class="text-center"><small><b>No</b></small></td>
                    <td class="text-left"><small><b>ID Pasien</b></small></td>
                    <td class="text-left"><small><b>ID Kunjungan</b></small></td>
                    <td class="text-left"><small><b>Tanggal</b></small></td>
                    <td class="text-left"><small><b>Nama Pasien</b></small></td>
                    <td class="text-left"><small><b>Rajal/Ranap</b></small></td>
                </tr>
            </thead>
        ';
        echo '<tbody>';
        $no = 1;
        $sql = "
            SELECT 
                ku.id_pasien,
                ku.id_kunjungan,
                ku.datetime_daftar,
                ku.jenis_kunjungan,

                p.nama

            FROM kunjungan ku

            LEFT JOIN pasien p
                ON ku.id_pasien = p.id_pasien

            WHERE 
                ku.petugas_id = ?
                AND ku.datetime_daftar LIKE ?
        ";

        $stmt = $Conn->prepare($sql);

        $like_periode = "%$periode%";

        $stmt->bind_param(
            "is",
            $SessionIdAkses,
            $like_periode
        );

        $stmt->execute();

        $result = $stmt->get_result();

        while ($data = $result->fetch_assoc()) {

            echo '
                <tr>
                    <td class="text-center">
                        <small class="text text-muted">'.$no.'</small>
                    </td>

                    <td class="text-left">
                        <small class="text text-muted">'.$data['id_pasien'].'</small>
                    </td>

                    <td class="text-left">
                        <small class="text text-muted">'.$data['id_kunjungan'].'</small>
                    </td>

                    <td class="text-left">
                        <small class="text text-muted">'.$data['datetime_daftar'].'</small>
                    </td>

                    <td class="text-left">
                        <small class="text text-muted">'.$data['nama'].'</small>
                    </td>

                    <td class="text-left">
                        <small class="text text-muted">'.$data['jenis_kunjungan'].'</small>
                    </td>
                </tr>
            ';

            $no++;
        }
        echo '</tbody>';
    }

    echo '</table>';
?>