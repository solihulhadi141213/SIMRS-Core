<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Menangkap Keyword
    if(empty($_POST['keyword'])){
        echo '<option value="">';
        echo '  Kata Kunci Tidak Boleh Kosong!';
        echo '</option>';
    }else{
        $keyword=$_POST['keyword'];
        //Jumlah Hasil Pencarian
        $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE nama like '%$keyword%'"));
        if(empty($JumlahData)){
            echo '<option value="">';
            echo '  Hasil Tidak Ditemukan!';
            echo '</option>';
        }else{
            $query = mysqli_query($Conn, "SELECT*FROM obat WHERE nama like '%$keyword%'");
            while ($data = mysqli_fetch_array($query)) {
                $id_obat= $data['id_obat'];
                $nama_obat= $data['nama'];
                echo '<option value="'.$id_obat.'">';
                echo ''.$nama_obat.'';
                echo '</option>';
            }
        }
    }
?>