<?php
    //Zona Waktu
    date_default_timezone_set('UTC');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    include "../../_Config/SimrsFunction.php";
    //keyword
    if(empty($_POST['Referensi'])){
        echo '<span class="text-danger">Referensi Data Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['Keyword'])){
            echo '<span class="text-danger">Keyword Tidak Boleh Kosong!</span>';
        }else{
            $Referensi=$_POST['Referensi'];
            $Keyword=$_POST['Keyword'];
            $characterCount = strlen($Keyword);
            if($characterCount<3){
                echo '<span class="text-danger">Agar proses pencarian berlangsung secara efektif, maka Keyword Minimal 3 Karakter</span>';
            }else{
                echo 'Silahkan pilih diantara hasil pencarian berikut :';
                if($Referensi=="BPJS"){
                    $IdSettingBridging=getDataDetail($Conn,'bridging','status','Aktiv','id_bridging');
                    $consid=getDataDetail($Conn,'bridging','status','Aktiv','consid');
                    $user_key=getDataDetail($Conn,'bridging','status','Aktiv','user_key');
                    $secret_key=getDataDetail($Conn,'bridging','status','Aktiv','secret_key');
                    $kode_ppk=getDataDetail($Conn,'bridging','status','Aktiv','kode_ppk');
                    $url_vclaim=getDataDetail($Conn,'bridging','status','Aktiv','url_vclaim');
                    $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                    $key="$consid$secret_key$timestamp";
                    $ResponseData=referensiDiagnosaVclaim($url_vclaim,$consid,$secret_key,$user_key,$Keyword);
                    if(!empty($ResponseData)){
                        $ambil_json =json_decode($ResponseData, true);
                        if(!empty($ambil_json["metaData"]["code"])){
                            if($ambil_json["metaData"]["code"]=="200"){
                                if(!empty($ambil_json["response"])){
                                    $string=$ambil_json["response"];
                                    $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                    $key="$consid$secret_key$timestamp";
                                    $FileDeskripsi=stringDecrypt("$key", "$string");
                                    $FileDekompresi=decompress("$FileDeskripsi");
                                    $FileDekompresiJson =json_decode($FileDekompresi, true);
                                    if(empty($FileDekompresiJson['diagnosa'])){
                                        $diagnosa="";
                                    }else{
                                        $diagnosa=$FileDekompresiJson['diagnosa'];
                                    }
                                    if(!empty($diagnosa)){
                                        $JumlahDiagnosa=count($diagnosa);
                                        if(!empty($JumlahDiagnosa)){
                                            echo '<ol>';
                                            $no=1;
                                            foreach($diagnosa as $data_list){
                                                $kode= $data_list['kode'];
                                                $nama= $data_list['nama'];
                                                $Explode = explode("-" , $nama);
                                                $DiagnosaNama=$Explode[1];
                                                $Explode2 = explode(" " , $DiagnosaNama);
                                                $DiagnosaNama=$Explode2[1];
                                                echo '<li class="mb-2">';
                                                echo '  <a href="javascript:void(0);" class="text-primary PilihMedicationRequestDiagnosa" value="'.$nama.'" data_code="'.$kode.'">'.$kode.'</a>';
                                                echo '  <small>'.$nama.'</small>';
                                                echo '</li>';
                                                $no++;
                                            }
                                            echo '</ol>';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }else{
                    echo '<ol>';
                        $no=1;
                        $query = mysqli_query($Conn, "SELECT*FROM diagnosa WHERE (versi='ICD10') AND (kode like '%$Keyword%' OR long_des like '%$Keyword%' OR short_des like '%$Keyword%') LIMIT 20");
                        while ($data = mysqli_fetch_array($query)) {
                            $id_diagnosa= $data['id_diagnosa'];
                            $kode= $data['kode'];
                            $long_des= $data['long_des'];
                            $short_des= $data['short_des'];
                            $versi= $data['versi'];
                            echo '<li class="mb-2">';
                            echo '  <a href="javascript:void(0);" class="text-primary PilihMedicationRequestDiagnosa" value="'.$short_des.'" data_code="'.$kode.'">'.$kode.'</a>';
                            echo '  <small>'.$short_des.'</small>';
                            echo '</li>';
                            $no++;
                        }
                    echo '</ol>';
                }
            }
        }
    }
?>
<script>
    $(document).on('click', '.PilihMedicationRequestDiagnosa', function(){
        var diagnose_name = $(this).attr("value"); 
        var diagnose_code = $(this).attr("data_code"); 
        $('#MedicationRequestreasonCode_code').val(diagnose_code);
        $('#MedicationRequestreasonCode_display').val(diagnose_name);
        //Tutup
        $('#MeedicationRequestDiagnosaList').html('');
    });
</script>