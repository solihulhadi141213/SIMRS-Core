<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(!empty($SessionIdAkses)){
        if(!empty($_POST['JenisTransaksi'])){
            $JenisTransaksi=$_POST['JenisTransaksi'];
            if($JenisTransaksi=="Pemasukan"){
                $KodeAwal="PND";
            }else{
                if($JenisTransaksi=="Pembelian"){
                    $KodeAwal="PMB";
                }else{
                    if($JenisTransaksi=="Pengeluaran"){
                        $KodeAwal="PNG";
                    }else{
                        $KodeAwal="ERROR $JenisTransaksi";
                    }
                }
            }
            //Randome String
            $Randome=generateStrongCode("6");
            //Mencari Nilai Terbesar Pada Data Transaksi
            $QryTransaksi=mysqli_query($Conn, "SELECT MAX(id_transaksi) as id_transaksi FROM transaksi WHERE id_akses='$SessionIdAkses'")or die(mysqli_error($Conn));
            while($HasilKode=mysqli_fetch_array($QryTransaksi)){
                $NilaiTertinggi=$HasilKode['id_transaksi'];
            }
            $NilaiTertinggi=$NilaiTertinggi+1;
            $kode_dasar=sprintf("%07d", $NilaiTertinggi);
            $kode_user=sprintf("%03d", $SessionIdAkses);
            $kode="$KodeAwal$kode_user$kode_dasar";
            //Cek Apakah Kode Tersebut Sudah Ada Pada Database?
            $KodeTransaksi=getDataDetail($Conn,'transaksi','kode',$kode,'kode');
            if(empty($KodeTransaksi)){
                echo "$kode";
            }else{
                echo "";
            }
        }
    }
?>
