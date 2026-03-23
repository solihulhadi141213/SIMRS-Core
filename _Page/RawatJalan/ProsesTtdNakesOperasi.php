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
        echo '<small class="text-danger">ID Kunjungan Tindakan operasi tidak boleh kosong</small>';
    }else{
        if(empty($_POST['id_nakes_operasi'])){
            echo '<small class="text-danger">ID nakes Tindakan operasi tidak boleh kosong</small>';
        }else{
            if(empty($_POST['signature'])){
                echo '<small class="text-danger">Tanda tangan tidak boleh kosong</small>';
            }else{
                //Variabel Lainnya
                $id_kunjungan=$_POST['id_kunjungan'];
                $id_nakes_operasi=$_POST['id_nakes_operasi'];
                $data_uri=$_POST['signature'];
                $encoded_image = explode(",", $data_uri)[1];
                $decoded_image = base64_decode($encoded_image);
                //Buka Data Lama
                $pelaksana=getDataDetail($Conn,"operasi",'id_kunjungan',$id_kunjungan,'pelaksana');
                $JsonPelaksana=json_decode($pelaksana, true);
                $JsonPelaksanaBaruArray=array();
                foreach($JsonPelaksana as $ListPelaksana){
                    $IdNakesOperasi=$ListPelaksana['id_nakes_operasi'];
                    if($ListPelaksana['id_nakes_operasi']==$id_nakes_operasi){
                        $j['id_nakes_operasi']=$ListPelaksana['id_nakes_operasi'];
                        $j['kategori']=$ListPelaksana['kategori'];
                        $j['nama']=$ListPelaksana['nama'];
                        $j['sip']=$ListPelaksana['sip'];
                        $j['kontak']=$ListPelaksana['kontak'];
                        $j['kategori_identitas']=$ListPelaksana['kategori_identitas'];
                        $j['nomor_identitas']=$ListPelaksana['nomor_identitas'];
                        $j['ttd']="$encoded_image";
                        array_push($JsonPelaksanaBaruArray, $j);
                    }else{
                        $j['id_nakes_operasi']=$ListPelaksana['id_nakes_operasi'];
                        $j['kategori']=$ListPelaksana['kategori'];
                        $j['nama']=$ListPelaksana['nama'];
                        $j['sip']=$ListPelaksana['sip'];
                        $j['kontak']=$ListPelaksana['kontak'];
                        $j['kategori_identitas']=$ListPelaksana['kategori_identitas'];
                        $j['nomor_identitas']=$ListPelaksana['nomor_identitas'];
                        $j['ttd']=$ListPelaksana['ttd'];
                        array_push($JsonPelaksanaBaruArray, $j);
                    }
                }
                $JsonPelaksanaBaru= json_encode($JsonPelaksanaBaruArray);
                $Update= mysqli_query($Conn,"UPDATE operasi SET 
                    pelaksana='$JsonPelaksanaBaru'
                WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                if($Update){
                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tanda Tangan Nakes Operasi","Kunjungan",$SessionIdAkses,$LogJsonFile);
                    if($MenyimpanLog=="Berhasil"){
                        echo '<span class="text-success" id="NotifikasiTtdNakesOperasiBerhasil'.$id_nakes_operasi.'">Success</span>';
                        echo '<span class="text-success" id="UrlBackTtdNakesOperasi'.$id_nakes_operasi.'">index.php?Page=RawatJalan&Sub=Operasi&id='.$id_kunjungan.'</span>';
                    }else{
                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                    }
                }else{
                    echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update!</span><br>';
                }
            }
        }
    }
?>
