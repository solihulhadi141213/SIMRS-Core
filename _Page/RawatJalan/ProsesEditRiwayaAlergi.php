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
    if(empty($_POST['PutIdKunjungan'])){
        echo '<small class="text-danger">ID Kunjungan tidak boleh kosong</small>';
    }else{
        //Validasi KategoriAlergy tidak boleh kosong
        if(empty($_POST['KategoriAlergy'])){
            echo '<small class="text-danger">Kategori Alergi tidak boleh kosong</small>';
        }else{
            $id_kunjungan=$_POST['PutIdKunjungan'];
            $kategori=$_POST['KategoriAlergy'];
            $riwayat_alergi=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_alergi');
            $JsonRiwayatAlergi =json_decode($riwayat_alergi, true);
            //Buka Data Lama
            $ListAlergiMakanan=$JsonRiwayatAlergi['makanan'];
            $ListAlergiMinuman=$JsonRiwayatAlergi['minuman'];
            $ListAlergiObat=$JsonRiwayatAlergi['obat'];
            $ListAlergiLainnya=$JsonRiwayatAlergi['lainnya'];
            //Buat Array
            if(empty($_POST['JenisZat'])){
                $JsonArray="";
                $JenisZat="";
                $JumlahData="0";
            }else{
                $JenisZat=$_POST['JenisZat'];
                $JsonArray = array();
                $JumlahData=count($JenisZat);
                for($i=0; $i<$JumlahData; $i++){
                    if(!empty($_POST['JenisZat'][$i])){
                        $JenisZatList=$_POST['JenisZat'][$i];
                        if(!empty($_POST['Reaksi'][$i])){
                            $Reaksi=$_POST['Reaksi'][$i];
                        }else{
                            $Reaksi="";
                        }
                        $h['JenisZat'] =$JenisZatList;
                        $h['Reaksi'] =$Reaksi;
                    }
                    array_push($JsonArray, $h);
                }
            }
            //Buat JSON
            if($kategori=="Makanan"){
                $riwayat_alergi=Array (
                    "obat" => $ListAlergiObat,
                    "makanan" => $JsonArray,
                    "minuman" => $ListAlergiMinuman,
                    "lainnya" => $ListAlergiLainnya
                );
            }else{
                if($kategori=="Minuman"){
                    $riwayat_alergi=Array (
                        "obat" => $ListAlergiObat,
                        "makanan" => $ListAlergiMakanan,
                        "minuman" => $JsonArray,
                        "lainnya" => $ListAlergiLainnya
                    );
                }else{
                    if($kategori=="Obat"){
                        $riwayat_alergi=Array (
                            "obat" => $JsonArray,
                            "makanan" => $ListAlergiMakanan,
                            "minuman" => $ListAlergiMinuman,
                            "lainnya" => $ListAlergiLainnya
                        );
                    }else{
                        $riwayat_alergi=Array (
                            "obat" => $ListAlergiObat,
                            "makanan" => $ListAlergiMakanan,
                            "minuman" => $ListAlergiMinuman,
                            "lainnya" => $JsonArray
                        );
                    }
                }
            }
            $JsonRiwayatAlergi= json_encode($riwayat_alergi);
            //Simpan Data
            $UpdateRiwayatAlergi= mysqli_query($Conn,"UPDATE anamnesis SET 
                riwayat_alergi='$JsonRiwayatAlergi'
            WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
            if($UpdateRiwayatAlergi){
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Ubah Anamnesis ","Kunjungan",$SessionIdAkses,$LogJsonFile);
                echo '<span class="text-success" id="NotifikasiEditRiwayaAlergiBerhasil">Success</span>';
            }else{
                $ValidasiProses="Terjadi kesalahan pada saat menyimpan data Riwayat Alergi";
                echo '<span class="text-danger">'. $ValidasiProses.'</span>';
            }
        }
    }
?>
