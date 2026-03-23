<?php
    //KONEKSI KE DATABASE SQL
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    if(empty($_POST['keyword'])){
        echo '<option value="">Pilih</option>';
    }else{
        if(empty($_POST['kategori'])){
            echo '<option value="">Pilih</option>';
        }else{
            //TANGKAP VARIABEL DARI FORMULIR LOGIN.PHP
            $keyword=$_POST["keyword"];
            $kategori=$_POST["kategori"];
            echo '<option>Pilih</option>';
            $Qry = mysqli_query($Conn, "SELECT * FROM wilayah_mendagri WHERE (kategori='$kategori' )AND (kode like '%$keyword%') ORDER BY nama ASC");
            while ($Data = mysqli_fetch_array($Qry)) {
                $nama= $Data['nama'];
                $kode= $Data['kode'];
                echo '<option value="'.$kode.'">'.$nama.'</option>';
            }
        }
    }
?>