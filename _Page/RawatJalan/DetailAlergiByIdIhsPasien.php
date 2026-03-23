<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
    $Token=GenerateTokenSatuSehat($Conn);
    $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Kunjungan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
        $id_ihs=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'id_ihs');
        if(empty($id_ihs)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      <code>Pasien tersebut belum memiliki ID IHS</code>';
            echo '  </div>';
            echo '</div>';
        }else{
            //Buka data Alergi dari satu sehat
            $response=AllergyIntoleranceByIdIhs($baseurl_satusehat,$Token,$id_ihs);
            if(empty($response)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center text-danger">';
                echo '      <code>Tidak ada response dari satu sehat!</code>';
                echo '  </div>';
                echo '</div>';
            }else{
                $json_decode =json_decode($response, true);
                if(empty($json_decode['entry'])){
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12 text-center text-danger">';
                    echo '      <code>Data tidak ditemukan pada satu sehat!</code>';
                    echo '  </div>';
                    echo '</div>';
                    echo '<div class="row">';
                    echo '  <div class="col-md-12">';
                    echo '      <textarea class="form-control">'.$response.'</textarea>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12 sub-title">';
                    echo '      Berikut ini adalah data riwayat alergi pasien dari resource satu sehat berdasarkan ID IHS pasien';
                    echo '  </div>';
                    echo '</div>';
                    $entry=$json_decode['entry'];
                    $resourceType=$json_decode['resourceType'];
                    $total=$json_decode['total'];
                    $type=$json_decode['type'];
                    echo '<div class="row mb-3">';
                    echo '  <div class="col-md-12 sub-title">';
                    echo '      <ol>';
                    echo '          <li class="mb-3">Resource Type : <code class="text-secondary">'.$resourceType.'</code></li>';
                    echo '          <li class="mb-3">Total Data : <code class="text-secondary">'.$total.'</code></li>';
                    echo '          <li class="mb-3">Type : <code class="text-secondary">'.$type.'</code></li>';
                    echo '      </ol>';
                    echo '  </div>';
                    echo '</div>';
                    $no=1;
                    foreach($entry as $list_entry){
                        $id=$list_entry['resource']['id'];
                        $fullUrl=$list_entry['fullUrl'];
                        $recordedDate=$list_entry['resource']['recordedDate'];
                        $resourceType=$list_entry['resource']['resourceType'];
                        $encounter_reference=$list_entry['resource']['encounter']['reference'];
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-12 sub-title">';
                        echo '  <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalDetailAlergi" data-id="'.$id.'">'.$no.'. '.$id.' <i class="ti ti-new-window"></i></a>';
                        echo '      <ol>';
                        echo '          <li>URL : <code class="text-secondary">'.$fullUrl.'</code></li>';
                        echo '          <li>Date : <code class="text-secondary">'.$recordedDate.'</code></li>';
                        echo '          <li>Type : <code class="text-secondary">'.$resourceType.'</code></li>';
                        echo '          <li>Encounter : <code class="text-secondary">'.$encounter_reference.'</code></li>';
                        echo '      </ol>';
                        echo '  </div>';
                        echo '</div>';
                        $no++;
                    }
                    echo '<div class="row">';
                    echo '  <div class="col-md-12">';
                    echo '      <label>Raw Data</label>';
                    echo '      <textarea class="form-control">'.$response.'</textarea>';
                    echo '  </div>';
                    echo '</div>';
                }
            }
        }
    }
?>