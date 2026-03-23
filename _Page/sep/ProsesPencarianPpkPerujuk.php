<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    //keyword
    if(empty($_POST['KeywordPencarianPpk'])){
        echo '<div class="list-group-item list-group-item-action">';
        echo '  <span class="text-danger">Isi Terlebih Dulu Kata Kunci Untuk Memulai Pencarian PPK.</span>';
        echo '</div>';
    }else{
        if(empty($_POST['tipe_faskes_ppk'])){
            echo '<div class="list-group-item list-group-item-action">';
            echo '  <span class="text-danger">Pilih Salah Satu Jenis/Tipe PPK</span>';
            echo '</div>';
        }else{
            $keyword=$_POST['KeywordPencarianPpk'];
            $JenisFaskes=$_POST['tipe_faskes_ppk'];
            $url="$url_vclaim/referensi/faskes/$keyword/$JenisFaskes";
            $Response=PencarianPpk($url_vclaim,$consid,$secret_key,$user_key,$url);
            if(empty($Response)){
                echo '<div class="list-group-item list-group-item-action">';
                echo '  <span class="text-danger">Pilih Salah Satu Jenis/Tipe PPK</span>';
                echo '</div>';
            }else{
                $ambil_json =json_decode($Response, true);
                if(empty($ambil_json["metaData"]["code"])){
                    echo '<div class="list-group-item list-group-item-action">';
                    echo '  <span class="text-danger"><dt>Terjadi Kesalahan Pada Service BPJS!</dt> '.$Response.'</span>';
                    echo '</div>';
                }else{
                    if($ambil_json["metaData"]["code"]!=="200"){
                        $PesanKesalahan=$ambil_json["metaData"]["message"];
                        echo '<div class="list-group-item list-group-item-action">';
                        echo '  <span class="text-danger"><dt>Terjadi Kesalahan Pada Service BPJS!</dt> '.$PesanKesalahan.'</span>';
                        echo '</div>';
                    }else{
                        if(empty($ambil_json["response"])){
                            echo '<div class="list-group-item list-group-item-action">';
                            echo '  <span class="text-danger"><dt>Terjadi Kesalahan Pada Service BPJS!</dt> '.$Response.'</span>';
                            echo '</div>';
                        }else{
                            $string=$ambil_json["response"];
                            //Proses decode dan dekompresi
                            //--membuat key
                            $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                            $key="$consid$secret_key$timestamp";
                            //--masukan ke fungsi
                            $FileDeskripsi=stringDecrypt("$key", "$string");
                            $FileDekompresi=decompress("$FileDeskripsi");
                            $FileDekompresiJson =json_decode($FileDekompresi, true);
                            //--konveris json to raw
                            if(empty(json_decode($FileDekompresi, true))){
                                echo '<div class="list-group-item list-group-item-action">';
                                echo '  <span class="text-danger"><dt>Proses Decrypt Gagal!</dt> Terjadi kesalahan pada saat melakukan proses deskripsi</span>';
                                echo '</div>';
                            }else{
                                if(empty($FileDekompresiJson['faskes'])){
                                    echo '<div class="list-group-item list-group-item-action">';
                                    echo '  <span class="text-danger"><dt>Tidak ada faskes yang ditemukan!</dt> '.$PesanKesalahan.'</span>';
                                    echo '</div>';
                                }else{
                                    $JsonData =json_decode($FileDekompresi, true);
                                    $list=$JsonData['faskes'];
                                    $Jumlah=count($list);
                                    for($a=0; $a<$Jumlah; $a++){
                                        $kode=$list[$a]['kode'];
                                        $nama=$list[$a]['nama'];
                                        echo '<div class="list-group-item list-group-item-action">';
                                        echo '  <a href="javascript:void(0);" class="text-primary"><dt class="SetKodePpkPerujuk">'.$kode.'</dt></a>';
                                        echo '  '.$nama.'';
                                        echo '</div>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    } 
?>
<script>
    //Ketika Dipilih PPK Perujuk
    $(".SetKodePpkPerujuk").click(function() {
        //Menangkap Data
        var KodePpkPerujukTerpilih = $(this).html();
        //Masukan ke Form
        $('#rujukan_dari').val(KodePpkPerujukTerpilih);
        //Tutup Modal
        $('#ModalPencarianPpkPerujuk').modal('hide');
    });
</script>