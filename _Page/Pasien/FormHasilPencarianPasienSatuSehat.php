<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Menangkap DasarPencarianPasienSatuSehat
    if(empty($_POST['DasarPencarianPasienSatuSehat'])){
        echo '<div class="row">';
        echo '<div class="col-md-12 text-center"><span class="text-danger">Anda Harus Memilih Dasar Pencarian Terlebih Dulu</span></div>';
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
            $DasarPencarianPasienSatuSehat=$_POST['DasarPencarianPasienSatuSehat'];
            if($DasarPencarianPasienSatuSehat=="NIK"){
                if(empty($_POST['nik_pasien'])){
                    $ValidasiPencarian="Nik Pasien Tidak Boleh Kosong!";
                }else{
                    $ValidasiPencarian="Valid";
                    $NikPasien=$_POST['nik_pasien'];
                }
            }else{
                if($DasarPencarianPasienSatuSehat=="NIK Ibu"){
                    if(empty($_POST['nik_ibu'])){
                        $ValidasiPencarian="NIK Ibu Pasien Tidak Boleh Kosong!";
                    }else{
                        $ValidasiPencarian="Valid";
                        $nik_ibu=$_POST['nik_ibu'];
                    }
                }else{
                    if($DasarPencarianPasienSatuSehat=="Nama Pasien"){
                        if(empty($_POST['nama_pasien'])){
                            $ValidasiPencarian="Nama Pasien Tidak Boleh Kosong!";
                        }else{
                            if(empty($_POST['tanggal_lahir'])){
                                $ValidasiPencarian="Tanggal Lahir Pasien Tidak Boleh Kosong!";
                            }else{
                                if(empty($_POST['nik_pasien'])){
                                    $ValidasiPencarian="NIK Pasien Tidak Boleh Kosong!";
                                }else{
                                    $ValidasiPencarian="Valid";
                                    $nama_pasien=$_POST['nama_pasien'];
                                    $tanggal_lahir=$_POST['tanggal_lahir'];
                                    $nik_pasien=$_POST['nik_pasien'];
                                }
                            }
                        }
                    }else{
                        if($DasarPencarianPasienSatuSehat=="ID Pasien"){
                            if(empty($_POST['IdPasien'])){
                                $ValidasiPencarian="ID Pasien Tidak Boleh Kosong!";
                            }else{
                                $ValidasiPencarian="Valid";
                                $IdPasien=$_POST['IdPasien'];
                            }
                        }else{
                            $ValidasiPencarian="Dasar Pencarian Tidak Valid";
                        }
                    }
                }
            }
            if($ValidasiPencarian!=="Valid"){
                echo '<div class="row">';
                echo '<div class="col-md-12 text-center"><span class="text-danger">'.$ValidasiPencarian.'</span></div>';
                echo '</div>';
            }else{
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
                    if($DasarPencarianPasienSatuSehat=="NIK"){
                        $response=PatientByNik($baseurl_satusehat,$Token,$NikPasien);
                    }else{
                        if($DasarPencarianPasienSatuSehat=="NIK Ibu"){
                            $response=PatientByNikIbu($baseurl_satusehat,$Token,$nik_ibu);
                        }else{
                            if($DasarPencarianPasienSatuSehat=="Nama Pasien"){
                                $response=PatientByName($baseurl_satusehat,$Token,$nama_pasien,$tanggal_lahir,$nik_pasien);
                            }else{
                                if($DasarPencarianPasienSatuSehat=="ID Pasien"){
                                    $response=PatientById($baseurl_satusehat,$Token,$IdPasien);
                                }else{
                                    $response="";
                                }
                            }
                        }
                    }
                    if(empty($response)){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center"><span class="text-danger">Terjadi Kesalahan Konseksi Dengan Server Satu Sehat</span></div>';
                        echo '</div>';
                    }else{
                        // echo "$response";
                        //json_decode
                        $json_decode =json_decode($response, true);
                        if($DasarPencarianPasienSatuSehat=="ID Pasien"){
                            if(empty($json_decode['id'])){
                                echo '<div class="row">';
                                echo '  <div class="col-md-12 text-center"><span class="text-danger">Data Pasien Tidak Ditemukan</span></div>';
                                echo '</div>';
                            }else{
                                if(!empty($json_decode['active'])){
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-4"><dt>Active</dt></div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$json_decode['active'].'</small></div>';
                                    echo '</div>';
                                }
                                if(!empty($json_decode['id'])){
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-4"><dt>ID IHS/Pasien</dt></div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$json_decode['id'].'</small></div>';
                                    echo '</div>';
                                }
                                if(!empty($json_decode['identifier'])){
                                    $identifier=$json_decode['identifier'];
                                    if(!empty(count($identifier))){
                                        $no=1;
                                        foreach($identifier as $value_identifier){
                                            $system=$value_identifier['system'];
                                            $use=$value_identifier['use'];
                                            $value=$value_identifier['value'];
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-4"><dt>Identifier '.$no.'</dt></div>';
                                            echo '  <div class="col-md-8 text-left"><small>'.$system.'<br>'.$value.'('.$use.')</small></div>';
                                            echo '</div>';
                                            $no++;
                                        }
                                    }
                                }
                                if(!empty($json_decode['link'])){
                                    $link=$json_decode['link'];
                                    if(!empty(count($link))){
                                        $no=1;
                                        foreach($link as $ValueLink){
                                            $other=$ValueLink['other'];
                                            $reference=$other['reference'];
                                            $type=$ValueLink['type'];
                                            echo '<div class="row mb-3">';
                                            echo '  <div class="col-md-4"><dt>Link '.$no.'</dt></div>';
                                            echo '  <div class="col-md-8 text-left"><small>'.$reference.'<br>'.$type.'</small></div>';
                                            echo '</div>';
                                            $no++;
                                        }
                                    }
                                }
                                if(!empty($json_decode['meta'])){
                                    if(!empty($json_decode['meta']['lastUpdated'])){
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>Last Update</dt></div>';
                                        echo '  <div class="col-md-8 text-left"><small>'.$json_decode['meta']['lastUpdated'].'</small></div>';
                                        echo '</div>';
                                    }
                                    if(!empty($json_decode['meta']['versionId'])){
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-4"><dt>Version ID</dt></div>';
                                        echo '  <div class="col-md-8 text-left"><small>'.$json_decode['meta']['versionId'].'</small></div>';
                                        echo '</div>';
                                    }
                                }
                                if(!empty($json_decode['resourceType'])){
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-4"><dt>Resource Type</dt></div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$json_decode['resourceType'].'</small></div>';
                                    echo '</div>';
                                }
                            }
                        }else{
                            if(empty($json_decode['entry'])){
                                echo '<div class="row">';
                                echo '  <div class="col-md-12 text-center"><span class="text-danger">Data Pasien Tidak Ditemukan</span></div>';
                                echo '</div>';
                                echo '<div class="row">';
                                echo '  <div class="col-md-12 text-center"><textarea class="form-control" row="6" col="6">'.$response.'</textarea></div>';
                                echo '</div>';
                            }else{
                                if(empty(count($json_decode['entry']))){
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-12 text-center"><span class="text-danger">Data Pasien Tidak Ditemukan</span></div>';
                                    echo '</div>';
                                }else{
                                    foreach($json_decode['entry'] as $ValueLink){
                                        echo '<div class="row">';
                                        echo '  <div class="col-md-12 mb-3 table table-responsive">';
                                        echo '      <table class="table table-bordered">';
                                        echo '          <tbody>';
                                        if(!empty($ValueLink['fullUrl'])){
                                            echo '<tr>';
                                            echo '  <td colspan="3"><small>'.$ValueLink['fullUrl'].'</small></td>';
                                            echo '</tr>';
                                        }
                                        if(!empty($ValueLink['resource'])){
                                            $resource=$ValueLink['resource'];
                                            if(!empty($resource['active'])){
                                                echo '<tr>';
                                                echo '  <td><dt>Active</dt></td>';
                                                echo '  <td colspan="2"><small>'.$resource['active'].'</small></td>';
                                                echo '</tr>';
                                            }
                                            if(!empty($resource['address'])){
                                                foreach($resource['address'] as $ValueAddress){
                                                    if(!empty($ValueAddress['city'])){
                                                        echo '<tr>';
                                                        echo '  <td><dt>City</dt></td>';
                                                        echo '  <td colspan="2"><small>'.$ValueAddress['city'].'</small></td>';
                                                        echo '</tr>';
                                                    }
                                                    if(!empty($ValueAddress['country'])){
                                                        echo '<tr>';
                                                        echo '  <td><dt>Country</dt></td>';
                                                        echo '  <td colspan="2"><small>'.$ValueAddress['country'].'</small></td>';
                                                        echo '</tr>';
                                                    }
                                                    if(!empty($ValueAddress['extension'])){
                                                        $noExt=1;
                                                        foreach($ValueAddress['extension'] as $ValueExt){
                                                            $Extension=$ValueExt['extension'];
                                                            $url=$ValueExt['url'];
                                                            $noExt2=1;
                                                            foreach($ValueExt['extension'] as $ValueExt2){
                                                                $url2=$ValueExt2['url'];
                                                                $valueCode=$ValueExt2['valueCode'];
                                                                echo '<tr>';
                                                                echo '  <td><dt>'.$url2.'</dt></td>';
                                                                echo '  <td colspan="2"><small>'.$valueCode.'</small></td>';
                                                                echo '</tr>';
                                                                $noExt2++;
                                                            }
                                                            $noExt++;
                                                        }
                                                    }
                                                    if(!empty($ValueAddress['line'])){
                                                        $noLine=1;
                                                        foreach($ValueAddress['line'] as $ValueLine){
                                                            echo '<tr>';
                                                            echo '  <td><dt>Line '.$noLine.'</dt></td>';
                                                            echo '  <td colspan="2"><small>'.$ValueLine.'</small></td>';
                                                            echo '</tr>';
                                                            $noLine++;
                                                        }
                                                    }
                                                    if(!empty($ValueAddress['use'])){
                                                        echo '<tr>';
                                                        echo '  <td><dt>Use</dt></td>';
                                                        echo '  <td colspan="2"><small>'.$ValueAddress['use'].'</small></td>';
                                                        echo '</tr>';
                                                    }
                                                }
                                            }
                                            if(!empty($resource['birthDate'])){
                                                echo '<tr>';
                                                echo '  <td><dt>Birth Date</dt></td>';
                                                echo '  <td colspan="2"><small>'.$resource['birthDate'].'</small></td>';
                                                echo '</tr>';
                                            }
                                            if(!empty($resource['communication'])){
                                                foreach($resource['communication'] as $Valuecommunication){
                                                    foreach($Valuecommunication['language']['coding'] as $language){
                                                        $code_leng=$language['code'];
                                                        $display_leng=$language['display'];
                                                        $system_leng=$language['system'];
                                                        echo '<tr>';
                                                        echo '  <td><dt>Language-Coding</dt></td>';
                                                        echo '  <td colspan="2"><small>'.$display_leng.' ('.$code_leng.')</small></td>';
                                                        echo '</tr>';
                                                        $noExt2++;
                                                    }
                                                    $noExt++;
                                                }
                                                if(!empty($Valuecommunication['language']['text'])){
                                                    echo '<tr>';
                                                        echo '  <td><dt>Language Text</dt></td>';
                                                        echo '  <td colspan="2"><small>'.$Valuecommunication['language']['text'].'</small></td>';
                                                        echo '</tr>';
                                                }
                                            }
                                            if(!empty($resource['extension'])){
                                                foreach($resource['extension'] as $ValueExtension){
                                                    $url=$ValueExtension['url'];
                                                    $valueCode=$ValueExtension['valueCode'];
                                                    echo '<tr>';
                                                    echo '  <td><dt>Extension</dt></td>';
                                                    echo '  <td colspan="2"><small>'.$valueCode.'</small></td>';
                                                    echo '</tr>';
                                                }
                                                if(!empty($Valuecommunication['language']['text'])){
                                                    echo '<tr>';
                                                        echo '  <td><dt>Language Text</dt></td>';
                                                        echo '  <td colspan="2"><small>'.$Valuecommunication['language']['text'].'</small></td>';
                                                        echo '</tr>';
                                                }
                                            }
                                            if(!empty($resource['gender'])){
                                                echo '<tr>';
                                                echo '  <td><dt>Gender</dt></td>';
                                                echo '  <td colspan="2"><small>'.$resource['gender'].'</small></td>';
                                                echo '</tr>';
                                            }
                                            if(!empty($resource['id'])){
                                                echo '<tr>';
                                                echo '  <td><dt>ID</dt></td>';
                                                echo '  <td colspan="2"><small>'.$resource['id'].'</small></td>';
                                                echo '</tr>';
                                            }
                                            if(!empty($resource['identifier'])){
                                                $no=1;
                                                foreach($resource['identifier'] as $ValueIdentifier){
                                                    $system=$ValueIdentifier['system'];
                                                    $use=$ValueIdentifier['use'];
                                                    $value=$ValueIdentifier['value'];
                                                    echo '<tr>';
                                                    echo '  <td><dt>Identifier '.$no.'</dt></td>';
                                                    echo '  <td colspan="2"><small>'.$ValueIdentifier['system'].'<br>'.$ValueIdentifier['value'].' ('.$ValueIdentifier['use'].')</small></td>';
                                                    echo '</tr>';
                                                    $no++;
                                                }
                                            }
                                            if(!empty($resource['link'])){
                                                $no=1;
                                                foreach($resource['link'] as $ValueLink){
                                                    $reference=$ValueLink['other']['reference'];
                                                    $type=$ValueLink['type'];
                                                    echo '<tr>';
                                                    echo '  <td><dt>Link '.$no.'</dt></td>';
                                                    echo '  <td colspan="2"><small>'.$ValueLink['other']['reference'].'<br>'.$ValueLink['type'].'</small></td>';
                                                    echo '</tr>';
                                                    $no++;
                                                }
                                            }
                                            if(!empty($resource['name'])){
                                                foreach($resource['name'] as $ValueName){
                                                    $text=$ValueName['text'];
                                                    $use=$ValueName['use'];
                                                    echo '<tr>';
                                                    echo '  <td><dt>Name</dt></td>';
                                                    echo '  <td colspan="2"><small>'.$ValueName['text'].'('.$ValueName['use'].')</small></td>';
                                                    echo '</tr>';
                                                    $no++;
                                                }
                                            }
                                            if(!empty($resource['meta'])){
                                                if(!empty($resource['meta']['lastUpdated'])){
                                                    echo '<tr>';
                                                    echo '  <td><dt>Last Update</dt></td>';
                                                    echo '  <td colspan="2"><small>'.$resource['meta']['lastUpdated'].'</small></td>';
                                                    echo '</tr>';
                                                }
                                                if(!empty($resource['meta']['versionId'])){
                                                    echo '<tr>';
                                                    echo '  <td><dt>Version ID</dt></td>';
                                                    echo '  <td colspan="2"><small>'.$resource['meta']['versionId'].'</small></td>';
                                                    echo '</tr>';
                                                }
                                            }
                                            if(!empty($resource['resourceType'])){
                                                echo '<tr>';
                                                echo '  <td><dt>Type</dt></td>';
                                                echo '  <td colspan="2"><small>'.$resource['resourceType'].'</small></td>';
                                                echo '</tr>';
                                            }
                                        }
                                        echo '          </tbody>';
                                        echo '      </table>';
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