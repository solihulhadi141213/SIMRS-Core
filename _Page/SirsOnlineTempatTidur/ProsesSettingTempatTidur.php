<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    //Validasi Data tidak boleh Kosong
    if(empty($_POST['id_ruang_rawat'])){
        echo '<span class="text-danger">ID Ruang Rawat Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['kelas'])){
            echo '<span class="text-danger">Nama Kelas Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['id_tt'])){
                echo '<span class="text-danger">ID TT Tidak Boleh Kosong</span>';
            }else{
                $id_tt=$_POST['id_tt'];
                $id_ruang_rawat=$_POST['id_ruang_rawat'];
                $kelas=$_POST['kelas'];
                //Explode ID TT
                $explode=explode('.',$id_tt);
                $id_tt=$explode['0'];
                $tt=$explode['1'];
                //Cek apakah data tersebut sudah ada pada database sebelumnya?
                $id_ruang_rawat_sirs=getDataDetail($Conn,'ruang_rawat_sirs','id_ruang_rawat',$id_ruang_rawat,'id_ruang_rawat_sirs');
                //Hapus Di database
                if(empty($id_ruang_rawat_sirs)){
                    $entry="INSERT INTO ruang_rawat_sirs (
                        id_ruang_rawat ,
                        id_tt,
                        tt
                    ) VALUES (
                        '$id_ruang_rawat',
                        '$id_tt',
                        '$tt'
                    )";
                    $Input=mysqli_query($Conn, $entry);
                    if($Input){
                        $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Setting Tempat Tidur","Tempat Tidur SIRS Online",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            echo '<span class="text-success" id="NotifikasiSettingTempatTidurBerhasil">Success</span>';
                        }else{
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                        }
                    }else{
                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan data ke database!</span>';
                    }
                }else{
                    $Update = mysqli_query($Conn,"UPDATE ruang_rawat_sirs SET 
                        id_ruang_rawat='$id_ruang_rawat',
                        id_tt='$id_tt',
                        tt='$tt'
                    WHERE id_ruang_rawat_sirs='$id_ruang_rawat_sirs'") or die(mysqli_error($Conn)); 
                    if($Update){
                        $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Setting Tempat Tidur","Tempat Tidur SIRS Online",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            echo '<span class="text-success" id="NotifikasiSettingTempatTidurBerhasil">Success</span>';
                        }else{
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                        }
                    }else{
                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan data ke database!</span>';
                    }
                }
            }
        }
    }
?>