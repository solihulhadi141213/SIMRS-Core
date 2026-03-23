<?php
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi id_resep tidak boleh kosong
    if(empty($_POST['id_resep'])){
        echo '<small class="text-danger">ID Resep tidak boleh kosong</small>';
    }else{
        //Validasi signature tidak boleh kosong
        if(empty($_POST['signature'])){
            echo '<small class="text-danger">Tanda Tangan tidak boleh kosong</small>';
        }else{
            //Variabel Lainnya
            $id_resep=$_POST['id_resep'];
            $data_uri=$_POST['signature'];
            $encoded_image = explode(",", $data_uri)[1];
            //Buka Json pengkajian
            $pengkajian=getDataDetail($Conn,"resep",'id_resep',$id_resep,'pengkajian');
            $JsonPengkajian=json_decode($pengkajian, true);
            //Buka data pengkajian
            $Pengkajian1=$JsonPengkajian['pengkajian1']['value'];
            $Pengkajian2=$JsonPengkajian['pengkajian2']['value'];
            $Pengkajian3=$JsonPengkajian['pengkajian3']['value'];
            $Pengkajian4=$JsonPengkajian['pengkajian4']['value'];
            $Pengkajian5=$JsonPengkajian['pengkajian5']['value'];
            $Pengkajian6=$JsonPengkajian['pengkajian6']['value'];
            $Pengkajian7=$JsonPengkajian['pengkajian7']['value'];
            $Pengkajian8=$JsonPengkajian['pengkajian8']['value'];
            $Pengkajian9=$JsonPengkajian['pengkajian9']['value'];
            $Pengkajian10=$JsonPengkajian['pengkajian10']['value'];
            $Pengkajian11=$JsonPengkajian['pengkajian11']['value'];
            $Pengkajian12=$JsonPengkajian['pengkajian12']['value'];
            $Pengkajian13=$JsonPengkajian['pengkajian13']['value'];
            $KeteranganPengkajian1=$JsonPengkajian['pengkajian1']['keterangan'];
            $KeteranganPengkajian2=$JsonPengkajian['pengkajian2']['keterangan'];
            $KeteranganPengkajian3=$JsonPengkajian['pengkajian3']['keterangan'];
            $KeteranganPengkajian4=$JsonPengkajian['pengkajian4']['keterangan'];
            $KeteranganPengkajian5=$JsonPengkajian['pengkajian5']['keterangan'];
            $KeteranganPengkajian6=$JsonPengkajian['pengkajian6']['keterangan'];
            $KeteranganPengkajian7=$JsonPengkajian['pengkajian7']['keterangan'];
            $KeteranganPengkajian8=$JsonPengkajian['pengkajian8']['keterangan'];
            $KeteranganPengkajian9=$JsonPengkajian['pengkajian9']['keterangan'];
            $KeteranganPengkajian10=$JsonPengkajian['pengkajian10']['keterangan'];
            $KeteranganPengkajian11=$JsonPengkajian['pengkajian11']['keterangan'];
            $KeteranganPengkajian12=$JsonPengkajian['pengkajian12']['keterangan'];
            $KeteranganPengkajian13=$JsonPengkajian['pengkajian13']['keterangan'];
            $petugas_pengkajian=$JsonPengkajian['petugas_pengkajian'];
            //Membuat Json
            $PengkajianArray1 = array(
                "value"=>"$Pengkajian1",
                "keterangan"=>"$KeteranganPengkajian1"
            );
            $PengkajianArray2 = array(
                "value"=>"$Pengkajian2",
                "keterangan"=>"$KeteranganPengkajian2"
            );
            $PengkajianArray3 = array(
                "value"=>"$Pengkajian3",
                "keterangan"=>"$KeteranganPengkajian3"
            );
            $PengkajianArray4 = array(
                "value"=>"$Pengkajian4",
                "keterangan"=>"$KeteranganPengkajian4"
            );
            $PengkajianArray5 = array(
                "value"=>"$Pengkajian5",
                "keterangan"=>"$KeteranganPengkajian5"
            );
            $PengkajianArray6 = array(
                "value"=>"$Pengkajian6",
                "keterangan"=>"$KeteranganPengkajian6"
            );
            $PengkajianArray7 = array(
                "value"=>"$Pengkajian7",
                "keterangan"=>"$KeteranganPengkajian7"
            );
            $PengkajianArray8 = array(
                "value"=>"$Pengkajian8",
                "keterangan"=>"$KeteranganPengkajian8"
            );
            $PengkajianArray9 = array(
                "value"=>"$Pengkajian9",
                "keterangan"=>"$KeteranganPengkajian9"
            );
            $PengkajianArray10 = array(
                "value"=>"$Pengkajian10",
                "keterangan"=>"$KeteranganPengkajian10"
            );
            $PengkajianArray11 = array(
                "value"=>"$Pengkajian11",
                "keterangan"=>"$KeteranganPengkajian11"
            );
            $PengkajianArray12 = array(
                "value"=>"$Pengkajian12",
                "keterangan"=>"$KeteranganPengkajian12"
            );
            $PengkajianArray13 = array(
                "value"=>"$Pengkajian13",
                "keterangan"=>"$KeteranganPengkajian13"
            );
            $PengkajianArray = array(
                "pengkajian1"=>$PengkajianArray1,
                "pengkajian2"=>$PengkajianArray2,
                "pengkajian3"=>$PengkajianArray3,
                "pengkajian4"=>$PengkajianArray4,
                "pengkajian5"=>$PengkajianArray5,
                "pengkajian6"=>$PengkajianArray6,
                "pengkajian7"=>$PengkajianArray7,
                "pengkajian8"=>$PengkajianArray8,
                "pengkajian9"=>$PengkajianArray9,
                "pengkajian10"=>$PengkajianArray10,
                "pengkajian11"=>$PengkajianArray11,
                "pengkajian12"=>$PengkajianArray12,
                "pengkajian13"=>$PengkajianArray13,
                "petugas_pengkajian"=>$petugas_pengkajian,
                "ttd_pengkaji"=>$encoded_image,
            );
            $PengkajianJson= json_encode($PengkajianArray);
            $UpdateResep= mysqli_query($Conn,"UPDATE resep SET 
                pengkajian='$PengkajianJson'
            WHERE id_resep='$id_resep'") or die(mysqli_error($Conn));
            if($UpdateResep){
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Tanda Tangan Pengkaji","Kunjungan",$SessionIdAkses);
                if($MenyimpanLog=="Berhasil"){
                    echo '<span class="text-success" id="NotifikasiTtdPengkajiBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update tanda tangan pengkaji!</span><br>';
            }
        }
    }
?>
