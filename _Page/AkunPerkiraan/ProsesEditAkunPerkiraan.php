<?php
    //KONEKSI KE DATABASE
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_perkiraan'])){
        echo '<span class="text-danger">ID Akun Perkiraan Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['nama_perkiraan1'])){
            echo '<span class="text-danger">Nama Akun Perkiraan Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['nama_perkiraan2'])){
                echo '<span class="text-danger">Nama Akun Perkiraan Ke 2 Tidak Boleh Kosong!</span>';
            }else{
                $id_perkiraan=$_POST['id_perkiraan'];
                $nama=$_POST['nama_perkiraan1'];
                $name=$_POST['nama_perkiraan2'];
                //Lakukan Update
                $UpdateAkunPerkiraan = mysqli_query($Conn, "UPDATE akun_perkiraan SET nama='$nama', name='$name' WHERE id_perkiraan='$id_perkiraan'") or die(mysqli_error($Conn)); 
                //Apabila proses update berhasil
                if($UpdateAkunPerkiraan){
                    echo '<span class="text-success" id="NotifikasiEditAkunPerkiraanBerhasil">Success</span>';
                }else{
                    //Apabila proses update gagal
                    echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update</span>';
                }
            }
        }
    }
?>

