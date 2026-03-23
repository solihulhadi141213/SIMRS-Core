<?php
    //Koneksi dan SessionLogin
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_kategori_harga'])){
        echo '<span class="text-danger">ID Kategori Harga Tidak Boleh Kosong!</span>';
    }else{
        $id_kategori_harga=$_POST['id_kategori_harga'];
        //Apakah sudah memiliki Data
        $JumlahItemKategori = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_harga WHERE id_kategori_harga='$id_kategori_harga'"));
        //Apabila punya maka tidak bisa di hapus
        if(!empty($JumlahItemKategori)){
            echo '<span class="text-danger">Kategori Harga Tidak Bisa Dihapus karena Sudah Memiliki Item!</span>';
        }else{
            //Proses hapus data
            $HapusKategoriHarga = mysqli_query($Conn, "DELETE FROM obat_kategori_harga WHERE id_kategori_harga='$id_kategori_harga'") or die(mysqli_error($Conn));
            if ($HapusKategoriHarga) {
                echo '<span class="text-success" id="NotifikasiHapusKategoriHargaBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi kesalahan ketika menghapus data!</span>';
            }
        }
    }
?>