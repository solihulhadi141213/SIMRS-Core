<?php
    //Koneksi Dan Tanggal
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['tanggal'])){
        echo '<option value="">Tanggal Tidak Boleh Kosong!</option>';
    }else{
        $tanggal=$_POST['tanggal'];
        $nama_hari = NamaHariJadwal($tanggal);
        //Menampilkan Poliklinik
        $stmt_poli = $Conn->prepare("SELECT DISTINCT p.id_poliklinik, p.kode, p.nama 
            FROM poliklinik p
            JOIN jadwal_dokter jd ON jd.id_poliklinik = p.id_poliklinik
            WHERE jd.hari = ? ORDER BY p.nama ASC");
        $stmt_poli->bind_param("s", $nama_hari);
        $stmt_poli->execute();
        $result_poli = $stmt_poli->get_result();
        $jumlah_data = $result_poli->num_rows;
        //Apabila Tidak Ada Jadwal
        if(empty($jumlah_data)){
            echo '<option value="">Tidak Ada Jadwal</option>';
        }else{
            // Fetch poliklinik and associated doctors
            while ($row_poli = $result_poli->fetch_assoc()) {
                $id_poliklinik = $row_poli['id_poliklinik'];
                $kode_poli = $row_poli['kode'];
                $nama_poli = $row_poli['nama'];
                echo '<option value="'.$id_poliklinik.'">'.$nama_poli.' ('.$kode_poli.')</option>';
            }
        }
    }
?>