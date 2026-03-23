<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //menangkap data
    if(empty($_POST['NoRujukan'])){
        echo '<div class="text-danger" id="NotifikasiTambahDiagnosasisBerhasil">Nomor Rujukan Tidak Boleh Kosong</div>';
    }else{
        if(empty($_POST['kategori'])){
            echo '<div class="text-danger" id="NotifikasiTambahDiagnosasisBerhasil">kategori Tidak Boleh Kosong</div>';
        }else{
            if(empty($_POST['kode'])){
                echo '<div class="text-danger" id="NotifikasiTambahDiagnosasisBerhasil">kode Tidak Boleh Kosong</div>';
            }else{
                $NoRujukan=$_POST['NoRujukan'];
                $kategori=$_POST['kategori'];
                $kode=$_POST['kode'];
                //Proses Tambahkan data
                //Input data ke database
                $Input="INSERT INTO diagnosarujukankhusus (
                    rujukan,
                    kode,
                    kategori
                ) VALUES (
                    '$NoRujukan',
                    '$kode',
                    '$kategori'
                )";
                $ProsesInput=mysqli_query($Conn, $Input);
                if($ProsesInput){
                    echo '<div class="text-danger" id="NotifikasiTambahDiagnosasisBerhasil">Berhasil</div>';
                }else{
                    echo '<div class="text-danger" id="NotifikasiTambahDiagnosasisBerhasil">Proses Gagal</div>';
                }
            }
        }
    }
?>