<?php
    //Pengaturan waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    $updatetime=date('Y-m-d H:i');
    //Validasi kelengkapan data
    if(empty($_POST['PutIdKonsultasi'])){
        echo '<span class="text-danger">ID Konsultasi Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['tanggal_jawaban'])){
            echo '<span class="text-danger">Tanggal Jawaban Konsultasi Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['jam_jawaban'])){
                echo '<span class="text-danger">Jam Jawaban Konsultasi Tidak Boleh Kosong!</span>';
            }else{
                $tanggal_jawaban=$_POST['tanggal_jawaban'];
                $jam_jawaban=$_POST['jam_jawaban'];
                $TanggalJawaban="$tanggal_jawaban $jam_jawaban";
                if(empty($_POST['penemuan'])){
                    $penemuan="";
                }else{
                    $penemuan=$_POST['penemuan'];
                    $penemuan= addslashes($penemuan);
                    $penemuan = str_replace(array("\r","\n"),"",$penemuan);
                }
                if(empty($_POST['diagnosa'])){
                    $diagnosa="";
                }else{
                    $diagnosa=$_POST['diagnosa'];
                    $diagnosa= addslashes($diagnosa);
                    $diagnosa = str_replace(array("\r","\n"),"",$diagnosa);
                }
                if(empty($_POST['saran'])){
                    $saran="";
                }else{
                    $saran=$_POST['saran'];
                    $saran= addslashes($saran);
                    $saran = str_replace(array("\r","\n"),"",$saran);
                }
                $id_konsultasi=$_POST['PutIdKonsultasi'];
                $JawabanKonsultasiArray = array(
                    "penemuan"=>"$penemuan",
                    "diagnosa"=>"$diagnosa",
                    "saran"=>"$saran"
                );
                $JsonJawabanKonsultasi = json_encode($JawabanKonsultasiArray);
                //Simpan Data Ke Database
                $UpdateJawabanKonsultasi= mysqli_query($Conn,"UPDATE konsultasi SET 
                    tanggal_jawaban='$TanggalJawaban',
                    jawaban_konsultasi='$JsonJawabanKonsultasi'
                WHERE id_konsultasi='$id_konsultasi'") or die(mysqli_error($Conn));
                if($UpdateJawabanKonsultasi){
                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Jawaban Konsultasi","Kunjungan",$SessionIdAkses,$LogJsonFile);
                    if($MenyimpanLog=="Berhasil"){
                        echo '<span class="text-success" id="NotifikasiJawabanKonsultasiBerhasil">Success</span>';
                    }else{
                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                    }
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Konsultasi</span>';
                }
            }
        }
    }
?>