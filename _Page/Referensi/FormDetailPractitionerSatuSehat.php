<?php
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id
    if(empty($_POST['id'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-danger text-center">';
        echo '      ID Practitioner Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        //Setting Koneksi
        $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
        if(empty($SettingSatuSehat)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-danger text-center">';
            echo '      Tidak Ada Setting Satu Sehat Yang Aktif!';
            echo '  </div>';
            echo '</div>';
        }else{
            $id=$_POST['id'];
            //1. Generate Token
            $Token=GenerateTokenSatuSehat($Conn);
            if(empty($Token)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-danger text-center">';
                echo '      Terjadi Kesalahan Pada Saat Melakukan Generate Token';
                echo '  </div>';
                echo '</div>';
            }else{
                //Inisiasi BaseURL
                $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
                $response=PractitionerById($baseurl_satusehat,$Token,$id);
                $JsonData =json_decode($response, true);
                if(empty($JsonData['id'])){
                    echo $response;
                }else{
                    $birthDate=$JsonData['birthDate'];
                    $gender=$JsonData['gender'];
                    $id=$JsonData['id'];
                    
                    $lastUpdated=$JsonData['meta']['lastUpdated'];
                    $versionId=$JsonData['meta']['versionId'];
                    $qualification=$JsonData['qualification'];
                    $resourceType=$JsonData['resourceType'];
                    $telecom=$JsonData['telecom'];
                    //Format Last Update
                    $strtotime=strtotime($lastUpdated);
                    $lastUpdated=date('d/m/Y H:i:s',$strtotime);
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4"><dt>ID Practitioner</dt></div>';
                    echo '  <div class="col-md-8 text-left">'.$id.'</div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4"><dt>Update Terakhir</dt></div>';
                    echo '  <div class="col-md-8 text-left">'.$lastUpdated.'</div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4"><dt>Version ID</dt></div>';
                    echo '  <div class="col-md-8 text-left">'.$versionId.'</div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4"><dt>Tgl.Lahir</dt></div>';
                    echo '  <div class="col-md-8 text-left">'.$birthDate.'</div>';
                    echo '</div>';
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-4"><dt>Resource Type</dt></div>';
                    echo '  <div class="col-md-8 text-left">'.$resourceType.'</div>';
                    echo '</div>';
                    if(!empty($JsonData['name'])){
                        $name=$JsonData['name'];
                        $Jumlahname=count($name);
                        if(!empty($Jumlahname)){
                            foreach($name as $value_entry){
                                $name_text=$value_entry['text'];
                                $name_use=$value_entry['use'];
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-4"><dt>Nama Lengkap</dt></div>';
                                echo '  <div class="col-md-8 text-left">'.$name_text.' ('.$name_use.')</div>';
                                echo '</div>';
                            }
                        }
                    }
                    if(!empty($JsonData['address'])){
                        $address=$JsonData['address'];
                        $Jumlahaddress=count($address);
                        if(!empty($Jumlahaddress)){
                            foreach($address as $value_entry){
                                $city=$value_entry['city'];
                                $country=$value_entry['country'];
                                if(!empty($value_entry['postalCode'])){
                                    $postalCode=$value_entry['postalCode'];
                                }else{
                                    $postalCode='<span class="text-danger">Tidak Ada</span>';
                                }
                                
                                $alamat_use=$value_entry['use'];
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-4"><dt>Alamat</dt></div>';
                                echo '  <div class="col-md-8 text-left">'.$city.' ('.$country.')</div>';
                                echo '</div>';
                                if(!empty($value_entry['line'])){
                                    $line=$value_entry['line'];
                                    foreach($line as $value_line){
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>Jalan</dt></div>';
                                        echo '  <div class="col-md-8 text-left">'.$value_line.'</div>';
                                        echo '</div>';
                                    }
                                }
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-4"><dt>Kode Pos</dt></div>';
                                echo '  <div class="col-md-8 text-left">'.$postalCode.'</div>';
                                echo '</div>';
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-4"><dt>Pengguna</dt></div>';
                                echo '  <div class="col-md-8 text-left">'.$alamat_use.'</div>';
                                echo '</div>';
                                if(!empty($value_entry['extension'])){
                                    $extension=$value_entry['extension'];
                                    foreach($extension as $value_extension){
                                        if(!empty($value_extension['extension'])){
                                            $extension2=$value_extension['extension'];
                                            foreach($extension2 as $value_extension2){
                                                $extension2_url=$value_extension2['url'];
                                                $extension2_valueCode=$value_extension2['valueCode'];
                                                if($extension2_url=="province"){
                                                    $LabelExtension="Provinsi";
                                                    $LabelValue=getDataDetail($Conn,'wilayah_mendagri','kode',$extension2_valueCode,'nama');
                                                }else{
                                                    if($extension2_url=="city"){
                                                        $LabelExtension="Kabupaten/Kota";
                                                        $LabelValue=getDataDetail($Conn,'wilayah_mendagri','kode',$extension2_valueCode,'nama');
                                                    }else{
                                                        if($extension2_url=="district"){
                                                            $LabelExtension="Kecamatan";
                                                            $LabelValue=getDataDetail($Conn,'wilayah_mendagri','kode',$extension2_valueCode,'nama');
                                                        }else{
                                                            if($extension2_url=="village"){
                                                                $LabelExtension="Desa/Kelurahan";
                                                                $LabelValue=getDataDetail($Conn,'wilayah_mendagri','kode',$extension2_valueCode,'nama');
                                                            }else{
                                                                if($extension2_url=="rt"){
                                                                    $LabelExtension="RT";
                                                                    $LabelValue=$extension2_valueCode;
                                                                }else{
                                                                    if($extension2_url=="rw"){
                                                                        $LabelExtension="RW";
                                                                        $LabelValue=$extension2_valueCode;
                                                                    }else{
                                                                        $LabelExtension=$extension2_url;
                                                                        $LabelValue=$extension2_valueCode;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                echo '<div class="row mb-3">';
                                                echo '  <div class="col-md-4"><dt>'.$LabelExtension.'</dt></div>';
                                                echo '  <div class="col-md-8 text-left">'.$LabelValue.'</div>';
                                                echo '</div>';
                                            }
                                        }
                                        if(!empty($value_extension['url'])){
                                            $url=$value_extension['url'];
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-4"><dt>URL</dt></div>';
                                            echo '  <div class="col-md-8 text-left">'.$url.'</div>';
                                            echo '</div>';
                                        }
                                    }

                                }
                                
                            }
                        }
                    }
                    if(!empty($JsonData['identifier'])){
                        $identifier=$JsonData['identifier'];
                        foreach($identifier as $value_identifier){
                            if(!empty($value_identifier['use'])){
                                $identifier_use=$value_identifier['use'];
                            }else{
                                $identifier_use="";
                            }
                            if(!empty($value_identifier['value'])){
                                $identifier_value=$value_identifier['value'];
                            }else{
                                $identifier_value="";
                            }
                            if(!empty($value_identifier['system'])){
                                $identifier_system=$value_identifier['system'];
                                if($identifier_system=="https://fhir.kemkes.go.id/id/nakes-his-number"){
                                    $IdentifyName="HIS";
                                }else{
                                    if($identifier_system=="https://fhir.kemkes.go.id/id/nik"){
                                        $IdentifyName="NIK";
                                    }else{
                                        $IdentifyName="None";
                                    }
                                }
                            }else{
                                $identifier_system="";
                                $IdentifyName="None";
                            }
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>'.$IdentifyName.'</dt></div>';
                            echo '  <div class="col-md-8 text-left"><small>'.$identifier_value.' ('.$identifier_use.')</small></div>';
                            echo '</div>';
                        }
                    }
                    if(!empty($JsonData['telecom'])){
                        foreach($telecom as $value_telecom){
                            $telcom_system=$value_telecom['system'];
                            $telcom_use=$value_telecom['use'];
                            $telcom_value=$value_telecom['value'];
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>'.$telcom_system.' ('.$telcom_use.')</dt></div>';
                            echo '  <div class="col-md-8 text-left">'.$telcom_value.'</div>';
                            echo '</div>';
                        }
                    }
                    if(!empty($type)){
                        $code = $type[0]["coding"][0]["code"];
                        $display = $type[0]["coding"][0]["display"];
                        $system = $type[0]["coding"][0]["system"];
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt>Type Coding</dt></div>';
                        echo '  <div class="col-md-8 text-left">'.$display.' ('.$code.')</div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-4"><dt>System</dt></div>';
                        echo '  <div class="col-md-8 text-left">'.$system.'</div>';
                        echo '</div>';
                    }
                    echo '<textarea class="form-control">'.$response.'</textarea>';
                }
            }
        }
    }
?>