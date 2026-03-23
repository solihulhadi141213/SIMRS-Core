<?php
    // Koneksi dan Session Login
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // Validasi input
    if (empty($_POST['id_pasien'])) {
        echo '<i id="NotifikasiHapusPasienBerhasil">ID Pasien Tidak Boleh Kosong</i>';
    }else{
        // Ambil ID pasien
        $id_pasien = $_POST['id_pasien'];
        // Persiapkan query untuk mengambil data pasien
        $QryPasien = $Conn->prepare("SELECT gambar FROM pasien WHERE id_pasien = ?");
        $QryPasien->bind_param("s", $id_pasien);
        $QryPasien->execute();
        $result = $QryPasien->get_result();
        if ($result->num_rows > 0) {
            $DataPasien = $result->fetch_assoc();
            $GambarPasien = $DataPasien['gambar'];
            // Hapus file gambar jika ada
            if (!empty($GambarPasien)) {
                $LinkGambar = "../../assets/images/pasien/$GambarPasien";
                if (file_exists($LinkGambar)) {
                    if (!unlink($LinkGambar)) {
                        echo '<span class="text-danger">Error: Gagal Menghapus File Foto Pasien!</span>';
                        exit;
                    }
                }
            }
            // Hapus data pasien dari database
            $HapusPasien = $Conn->prepare("DELETE FROM pasien WHERE id_pasien = ?");
            $HapusPasien->bind_param("s", $id_pasien);
            if ($HapusPasien->execute()) {
                echo '<span class="text-info" id="NotifikasiHapusPasienBerhasil">Success</span>';
            } else {
                echo '<span class="text-danger">Error: Gagal Menghapus Data Pasien di Database!</span>';
            }
            // Tutup statement
            $HapusPasien->close();
        } else {
            echo '<i id="NotifikasiHapusPasienBerhasil">Data Pasien Tidak Ditemukan</i>';
        }
        // Tutup statement dan koneksi
        $QryPasien->close();
        $Conn->close();
    }
?>
