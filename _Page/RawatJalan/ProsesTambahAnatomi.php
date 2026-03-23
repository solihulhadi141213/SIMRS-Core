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
        //Validasi anatomi tidak boleh kosong
        if(empty($_POST['anatomi'])){
            echo '<small class="text-danger">Gambar tidak boleh kosong</small>';
        }else{
            if(empty($_POST['PenejelasanAnatomi'])){
                $PenejelasanAnatomiBaru="";
            }else{
                $PenejelasanAnatomiBaru=$_POST['PenejelasanAnatomi'];
                $PenejelasanAnatomiBaru=str_replace('"'," ",$PenejelasanAnatomiBaru);
                $PenejelasanAnatomiBaru=addslashes($PenejelasanAnatomiBaru);
                $PenejelasanAnatomiBaru = str_replace(array("\r","\n"),"",$PenejelasanAnatomiBaru);
            }
            //Variabel Lainnya
            $id_kunjungan=$_POST['id_kunjungan'];
            $data_uri=$_POST['anatomi'];
            $encoded_image = explode(",", $data_uri)[1];
            $decoded_image = base64_decode($encoded_image);
            //Buat Unique Key
            $Timestamp=strtotime($now);
            $KodeAnatomiBaru="$id_kunjungan-$Timestamp";
            //Generate File
            $fileName = ''.$KodeAnatomiBaru.'.jpg';
            $Path = '../../assets/images/Anatomi/Hasil/'.$fileName.'';
            $ifp = fopen( $Path, 'wb' ); 
            fwrite( $ifp, $decoded_image );
            fclose( $ifp ); 
            //Buka Data Lama
            $gambar_anatomi=getDataDetail($Conn,"pemeriksaan_fisik",'id_kunjungan',$id_kunjungan,'gambar_anatomi');
            $JsonDataLama = array();
            if(!empty($gambar_anatomi)){
                $JsonGambarAnatomi =json_decode($gambar_anatomi, true);
                //Buat Data Lama
                if(!empty(count($JsonGambarAnatomi))){
                    $JumlahDataLama=count($JsonGambarAnatomi);
                    for($i=0; $i<$JumlahDataLama; $i++){
                        $KodeAnatomi=$JsonGambarAnatomi[$i]["KodeAnatomi"];
                        $ImageAnatomi=$JsonGambarAnatomi[$i]["ImageAnatomi"];
                        $PenejlasanAnatomi=$JsonGambarAnatomi[$i]["PenejelasanAnatomi"];
                        $h['KodeAnatomi'] =$KodeAnatomi;
                        $h['ImageAnatomi'] =$ImageAnatomi;
                        $h['PenejelasanAnatomi'] =$PenejlasanAnatomi;
                        array_push($JsonDataLama, $h);
                    }
                }
            }
            
            $JsonDataBaru=Array (
                "KodeAnatomi" => $KodeAnatomiBaru,
                "PenejelasanAnatomi" => $PenejelasanAnatomiBaru,
                "ImageAnatomi" => $fileName,
            );
            array_push($JsonDataLama, $JsonDataBaru);
            $JsonDataBaru= json_encode($JsonDataLama);
            $UpdatePemeriksaanFisik= mysqli_query($Conn,"UPDATE pemeriksaan_fisik SET 
                gambar_anatomi='$JsonDataBaru'
            WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
            if($UpdatePemeriksaanFisik){
                $now=date('Y-m-d H:i:s');
                $LogJsonFile="../../_Page/Log/Log.json";
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Pemeriksaan Fisik","Kunjungan",$SessionIdAkses,$LogJsonFile);
                if($MenyimpanLog=="Berhasil"){
                    echo '<span class="text-success" id="NotifikasiTambahAnatomiBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update pemeriksaan Fisik!</span><br>';
            }
        }
    }
?>
