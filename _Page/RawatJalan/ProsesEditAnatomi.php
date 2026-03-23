<?php
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
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
            if(empty($_POST['EditPenejelasanAnatomi'])){
                $EditPenejelasanAnatomi="";
            }else{
                $EditPenejelasanAnatomi=$_POST['EditPenejelasanAnatomi'];
                $EditPenejelasanAnatomi=str_replace("'"," ",$EditPenejelasanAnatomi);
                $EditPenejelasanAnatomi=addslashes($EditPenejelasanAnatomi);
                $EditPenejelasanAnatomi = str_replace(array("\r","\n"),"",$EditPenejelasanAnatomi);
            }
            //Variabel Lainnya
            $id_kunjungan=$_POST['id_kunjungan'];
            $KodeAnatomi=$_POST['KodeAnatomi'];
            //Buka Data Lama
            $gambar_anatomi=getDataDetail($Conn,"pemeriksaan_fisik",'id_kunjungan',$id_kunjungan,'gambar_anatomi');
            $JsonDataLama = array();
            if(!empty($gambar_anatomi)){
                $JsonGambarAnatomi =json_decode($gambar_anatomi, true);
                //Buat Data Lama
                if(!empty(count($JsonGambarAnatomi))){
                    $JumlahDataLama=count($JsonGambarAnatomi);
                    for($i=0; $i<$JumlahDataLama; $i++){
                        $KodeAnatomiList=$JsonGambarAnatomi[$i]["KodeAnatomi"];
                        $ImageAnatomi=$JsonGambarAnatomi[$i]["ImageAnatomi"];
                        $PenejlasanAnatomi=$JsonGambarAnatomi[$i]["PenejelasanAnatomi"];
                        if($KodeAnatomi==$JsonGambarAnatomi[$i]["KodeAnatomi"]){
                            $h['KodeAnatomi'] =$KodeAnatomiList;
                            $h['ImageAnatomi'] =$ImageAnatomi;
                            $h['PenejelasanAnatomi'] =$EditPenejelasanAnatomi;
                        }else{
                            $h['KodeAnatomi'] =$KodeAnatomiList;
                            $h['ImageAnatomi'] =$ImageAnatomi;
                            $h['PenejelasanAnatomi'] =$PenejlasanAnatomi;
                        }
                        array_push($JsonDataLama, $h);
                    }
                }
            }
            $JsonDataBaru= json_encode($JsonDataLama);
            $UpdatePemeriksaanFisik= mysqli_query($Conn,"UPDATE pemeriksaan_fisik SET 
                gambar_anatomi='$JsonDataBaru'
            WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
            if($UpdatePemeriksaanFisik){
                $LogJsonFile="../../_Page/Log/Log.json";
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Pemeriksaan Fisik","Kunjungan",$SessionIdAkses,$LogJsonFile);
                if($MenyimpanLog=="Berhasil"){
                    echo '<span class="text-success" id="NotifikasiEditAnatomiBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update pemeriksaan Fisik!</span><br>';
            }
        }
    }
?>
