<?php
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi id_kunjungan tidak boleh kosong
    if(empty($_POST['id_kunjungan'])){
        echo '<small class="text-danger">ID Kunjungan tidak boleh kosong</small>';
    }else{
        //Validasi KodeAnatomi tidak boleh kosong
        if(empty($_POST['KodeAnatomi'])){
            echo '<small class="text-danger">Kode Anatomi tidak boleh kosong</small>';
        }else{
            //Variabel Lainnya
            $id_kunjungan=$_POST['id_kunjungan'];
            $KodeAnatomi=$_POST['KodeAnatomi'];
            //Buka Data Lama
            $gambar_anatomi=getDataDetail($Conn,"pemeriksaan_fisik",'id_kunjungan',$id_kunjungan,'gambar_anatomi');
            if(!empty($gambar_anatomi)){
                $JsonGambarAnatomi =json_decode($gambar_anatomi, true);
                //Buat Data Lama
                if(!empty(count($JsonGambarAnatomi))){
                    $JumlahDataLama2=count($JsonGambarAnatomi);
                    $JumlahDataLama=count($JsonGambarAnatomi);
                    //Hapus file
                    for($kl=0; $kl<$JumlahDataLama2; $kl++){
                        $KodeAnatomiList2=$JsonGambarAnatomi[$kl]["KodeAnatomi"];
                        $ImageAnatomi2=$JsonGambarAnatomi[$kl]["ImageAnatomi"];
                        if($KodeAnatomi==$KodeAnatomiList2){
                            $UrlFile='../../assets/images/Anatomi/Hasil/'.$ImageAnatomi2.'';
                            unlink($UrlFile);
                        }
                    }
                    //Apabila data hanya satu
                    if($JumlahDataLama==1){
                        $JsonDataBaru="";
                    }else{
                        $JsonDataLama = array();
                        for($i=0; $i<$JumlahDataLama; $i++){
                            $KodeAnatomiList=$JsonGambarAnatomi[$i]["KodeAnatomi"];
                            $ImageAnatomi=$JsonGambarAnatomi[$i]["ImageAnatomi"];
                            $PenejlasanAnatomi=$JsonGambarAnatomi[$i]["PenejelasanAnatomi"];
                            if($KodeAnatomi!==$KodeAnatomiList){
                                $h['KodeAnatomi'] =$KodeAnatomiList;
                                $h['ImageAnatomi'] =$ImageAnatomi;
                                $h['PenejelasanAnatomi'] =$PenejlasanAnatomi;
                                array_push($JsonDataLama, $h);
                            }
                        }
                        $JsonDataBaru= json_encode($JsonDataLama);
                    }
                }else{
                    $JsonDataBaru="";
                }
            }else{
                $JsonDataBaru="";
            }
            $UpdatePemeriksaanFisik= mysqli_query($Conn,"UPDATE pemeriksaan_fisik SET 
                gambar_anatomi='$JsonDataBaru'
            WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
            if($UpdatePemeriksaanFisik){
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Pemeriksaan Anatomi","Kunjungan",$SessionIdAkses,$LogJsonFile);
                if($MenyimpanLog=="Berhasil"){
                    echo '<img src="'.$UrlFile.'">';
                    echo '<span class="text-success" id="NotifikasiHapusAnatomiBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update pemeriksaan Fisik!</span><br>';
            }
        }
    }
?>
