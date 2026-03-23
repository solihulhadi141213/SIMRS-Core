<?php
    //Zona Waktu
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    //ModePencarianDiagnosa
    if(!empty($_POST['ModePencarianDiagnosa'])){
        $ModePencarianDiagnosa=$_POST['ModePencarianDiagnosa'];
    }else{
        $ModePencarianDiagnosa="";
    }
?>
<?php
    if(empty($keyword)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger"><dt>Kata Kunci Tidak Boleh Kosong!</dt> Silahkan isi kata kunci pencarian terlebih Dulu</div>';
        echo '</div>';
    }else{
        if(empty($ModePencarianDiagnosa)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger"><dt>Mode/Sumber Pencarian Tidak Boleh Kosong!</dt> Silahkan pilih mode pencarian terlebih dulu</div>';
            echo '</div>';
        }else{
            if($ModePencarianDiagnosa=="SIMRS"){
                $JumlahHasilPencarian = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM diagnosa WHERE kode like '%$keyword%' OR long_des like '%$keyword%' OR short_des like '%$keyword%'"));
                if(empty($JumlahHasilPencarian)){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center text-danger"><dt>Pencarian Diagnosa Dari SIMRS Tidak Ditemukan!</dt> Silahkan gunakan kata kunci lain untuk memperoleh hasil pencarian lebih baik</div>';
                    echo '</div>';
                }else{
                    echo '<div class="row">';
                    echo '  <div class="col-md-12">';
                    echo '      <dt>Hasil Pencarian Resource SIMRS</dt>';
                    echo '  </div>';
                    echo '  <div class="col col-md-12 pre-scrollable">';
                    echo '      <div  class="list-group">';
                    $QryPencarian = mysqli_query($Conn, "SELECT*FROM diagnosa WHERE kode like '%$keyword%' OR long_des like '%$keyword%' OR short_des like '%$keyword%' ORDER BY kode ASC LIMIT 100");
                    while ($DataPencarian = mysqli_fetch_array($QryPencarian)) {
                        $kode= $DataPencarian['kode'];
                        $short_des= $DataPencarian['short_des'];
                        echo '  <a href="javascript:void(0);" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#ModalKonfirmasiDiagnosa" data-id="'.$kode.' - '.$short_des.'">';
                        echo '      <dt>'.$kode.'</dt>'.$short_des.'';
                        echo '  </a>';
                    }
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }
            }else{
                $ResponseData=referensiDiagnosaVclaim($url_vclaim,$consid,$secret_key,$user_key,$keyword);
                if(empty($ResponseData)){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center text-danger"><dt>Pencarian Diagnosa Dari BPJS Tidak Ditemukan!</dt> Silahkan gunakan kata kunci lain untuk memperoleh hasil pencarian lebih baik</div>';
                    echo '</div>';
                }else{
                    $ambil_json =json_decode($ResponseData, true);
                    if(empty($ambil_json["metaData"]["code"])){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center text-danger"><dt>Terjadi Kesalahan Pada Service BPJS!</dt> '.$ResponseData.'</div>';
                        echo '</div>';
                    }else{
                        if($ambil_json["metaData"]["code"]!=="200"){
                            $PesanKesalahan=$ambil_json["metaData"]["message"];
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 text-center text-danger"><dt>Terjadi Kesalahan Pada Service BPJS!</dt> '.$PesanKesalahan.'</div>';
                            echo '</div>';
                        }else{
                            if(empty($ambil_json["response"])){
                                echo '<div class="row">';
                                echo '  <div class="col-md-12 text-center text-danger"><dt>Terjadi Kesalahan Pada Service BPJS!</dt> '.$ResponseData.'</div>';
                                echo '</div>';
                            }else{
                                $string=$ambil_json["response"];
                                $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                $key="$consid$secret_key$timestamp";
                                $FileDeskripsi=stringDecrypt("$key", "$string");
                                $FileDekompresi=decompress("$FileDeskripsi");
                                $FileDekompresiJson =json_decode($FileDekompresi, true);
                                if(empty($FileDekompresiJson['diagnosa'])){
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-12 text-center text-danger"><dt>Terjadi Kesalahan Pada Service BPJS!</dt> '.$ResponseData.'</div>';
                                    echo '</div>';
                                }else{
                                    $diagnosa=$FileDekompresiJson['diagnosa'];
                                    $JumlahDiagnosa=count($diagnosa);
                                    if(empty($JumlahDiagnosa)){
                                        echo '<div class="row">';
                                        echo '  <div class="col-md-12 text-center text-danger"><dt>Tidak Ada Data Yang Ditampilkan!</dt> Hasil Pencarian Tidak Ditemukan</div>';
                                        echo '</div>';
                                    }else{
                                        echo '<div class="row">';
                                        echo '  <div class="col-md-12">';
                                        echo '      <dt>Hasil Pencarian Resource BPJS</dt>';
                                        echo '  </div>';
                                        echo '  <div class="col col-md-12 pre-scrollable">';
                                        echo '      <div  class="list-group">';
                                        foreach($diagnosa as $data_list){
                                            $kode= $data_list['kode'];
                                            $nama= $data_list['nama'];
                                            $Explode = explode("-" , $nama);
                                            $DiagnosaNama=$Explode[1];
                                            $Explode2 = explode(" " , $DiagnosaNama);
                                            $DiagnosaNama=$Explode2[1];
                                            echo '  <a href="javascript:void(0);" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#ModalKonfirmasiDiagnosa" data-id="'.$nama.'">';
                                            echo '      <dt>'.$kode.'</dt>'.$DiagnosaNama.'';
                                            echo '  </a>';
                                        }
                                        echo '      </div>';
                                        echo '  </div>';
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