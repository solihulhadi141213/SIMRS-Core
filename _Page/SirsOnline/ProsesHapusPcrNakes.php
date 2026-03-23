<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Validasi Data tidak boleh Kosong
    if(empty($_POST['id_pcr_nakes'])){
        echo '<span class="text-danger">ID PCR Nakes Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['HapusJugaDiSirsOnline'])){
            $HapusJugaDiSirsOnline="No";
        }else{
            $HapusJugaDiSirsOnline=$_POST['HapusJugaDiSirsOnline'];
        }
        $id_pcr_nakes=$_POST['id_pcr_nakes'];
        //Hapus Di database
        $HapusPcrNakes = mysqli_query($Conn, "DELETE FROM pcr_nakes WHERE id_pcr_nakes='$id_pcr_nakes'") or die(mysqli_error($Conn));
        if($HapusPcrNakes) {
            if($HapusJugaDiSirsOnline=="Ya"){
                //Buka Pengaturan SIRS Online
                $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
                $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
                $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
                //Buka Data tanggal
                $tanggal=getDataDetail($Conn,'pcr_nakes','id_pcr_nakes',$id_pcr_nakes,'tanggal');
                $HapusDataSirsOnline=HapusDataPcrNakes($x_id_rs,$password_sirs_online,$url_sirs_online,'fo/index.php/Pasien/pcr_nakes',$tanggal);
                $response = json_decode($HapusDataSirsOnline, true);
                $status=$response['PCRNakes'][0]['status'];
                if($status=="200"){
                    $_SESSION['NotifikasiSwal']="Hapus PCR Nakes Berhasil";
                    echo '<span class="text-success" id="NotifikasiHapusPcrNakesBerhasil">Success</span>';
                }else{
                    echo "$HapusDataSirsOnline";
                }
            }else{
                $_SESSION['NotifikasiSwal']="Hapus PCR Nakes Berhasil";
                echo '<span class="text-success" id="NotifikasiHapusPcrNakesBerhasil">Success</span>';
            }
        }else{
            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menghapus PCR Nakes</span>';
        }
    }
?>