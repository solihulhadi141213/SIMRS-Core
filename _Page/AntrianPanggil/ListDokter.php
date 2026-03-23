<?php
    //Koneksi Dan Tanggal
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['tanggal'])){
        echo '<option value="">Tanggal Tidak Boleh Kosong!</option>';
    }else{
        if(empty($_POST['id_poliklinik'])){
            echo '<option value="">Poliklinik Tidak Boleh Kosong!</option>';
        }else{
            $tanggal=$_POST['tanggal'];
            $id_poliklinik=$_POST['id_poliklinik'];
            $nama_hari = NamaHariJadwal($tanggal);
            //Menampilkan Poliklinik
            $stmt_poli = $Conn->prepare("SELECT DISTINCT p.id_dokter, p.kode, p.nama 
                FROM dokter p
                JOIN jadwal_dokter jd ON jd.id_dokter = p.id_dokter
                WHERE jd.hari = ? AND jd.id_poliklinik = ? ORDER BY p.nama ASC");
            $stmt_poli->bind_param("ss", $nama_hari, $id_poliklinik);
            $stmt_poli->execute();
            $result_poli = $stmt_poli->get_result();
            $jumlah_data = $result_poli->num_rows;
            //Apabila Tidak Ada Jadwal
            if(empty($jumlah_data)){
                echo '<option value="">Tidak Ada Jadwal</option>';
            }else{
                // Fetch poliklinik and associated doctors
                while ($row_poli = $result_poli->fetch_assoc()) {
                    $id_dokter = $row_poli['id_dokter'];
                    $kode_dokter = $row_poli['kode'];
                    $nama_dokter = $row_poli['nama'];
                    echo '<option value="'.$id_dokter.'">'.$nama_dokter.' ('.$kode_dokter.')</option>';
                }
            }
        }
    }
?>