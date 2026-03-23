<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    //keyword
    if(empty($_POST['KeywordDiagnosa'])){
        echo '<div class="list-group-item list-group-item-action">';
        echo '  <span class="text-danger">Isi Terlebih Dulu Kata Kunci Untuk Memulai Pencarian.</span>';
        echo '</div>';
    }else{
        $keyword=$_POST['KeywordDiagnosa'];
        $url="$url_vclaim/referensi/diagnosa/$keyword";
        $Response=PencarianPpk($url_vclaim,$consid,$secret_key,$user_key,$url);
        if(empty($Response)){
            echo '<div class="list-group-item list-group-item-action">';
            echo '  <span class="text-danger">Tidak ada response dari service bridging BPJS.</span>';
            echo '</div>';
        }else{
            $ambil_json =json_decode($Response, true);
            if(empty($ambil_json["metaData"]["code"])){
                echo '<div class="list-group-item list-group-item-action">';
                echo '  <span class="text-danger">Kode kesalahan tidak diketahui.</span>';
                echo '  <div class="pre-scrollable">'.$Response.'</div>';
                echo '</div>';
            }else{
                if($ambil_json["metaData"]["code"]!=="200"){
                    $PesanKesalahan=$ambil_json["metaData"]["message"];
                    echo '<div class="list-group-item list-group-item-action">';
                    echo '  <span class="text-danger">Kode kesalahan tidak diketahui.</span>';
                    echo '  <div class="pre-scrollable">'.$PesanKesalahan.'</div>';
                    echo '</div>';
                }else{
                    if(empty($ambil_json["response"])){
                        echo '<div class="list-group-item list-group-item-action">';
                        echo '  <span class="text-danger">Proses berhasil namun response tidak ada.</span>';
                        echo '  <div class="pre-scrollable">'.$PesanKesalahan.'</div>';
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
                            echo '  <span class="text-danger">Terjadi kesalahan pada saat proses deskripsi.</span>';
                            echo '</div>';
                        }else{
                            if(empty($FileDekompresiJson['diagnosa'])){
                                echo '<div class="list-group-item list-group-item-action">';
                                echo '  <span class="text-danger">Diagnosa tidak ditemukan.</span>';
                                echo '</div>';
                            }else{
                                $list=$FileDekompresiJson['diagnosa'];
                                $Jumlah=count($list);
                                for($a=0; $a<$Jumlah; $a++){
                                    $kode=$list[$a]['kode'];
                                    $nama=$list[$a]['nama'];
                                    echo '<div class="list-group-item list-group-item-action">';
                                    echo '  <a href="javascript:void(0);" class="text-primary"><dt class="SetDiagnosaSep">'.$kode.'</dt></a>';
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
?>
<script>
    //Ketika Dipilih PPK Perujuk
    $(".SetDiagnosaSep").click(function() {
        //Menangkap Data
        var DiagnosaTerpilih = $(this).html();
        //Masukan ke Form
        $('#diagAwal').val(DiagnosaTerpilih);
        //Tutup Modal
        $('#ModalCariDiagnosa').modal('hide');
    });
</script>