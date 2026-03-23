<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i:s');
    //Validasi Form Data
    if(empty($_POST['id_setting_satusehat'])){
        $id_setting_satusehat="";
    }else{
        $id_setting_satusehat=$_POST['id_setting_satusehat'];
    }
    if(empty($_POST['status'])){
        $status="Non-Active";
    }else{
        $status=$_POST['status'];
    }
    if(empty($_POST['nama_setting'])){
        echo '<span class="text-danger">Nama Setting Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['oauth_baseurl'])){
            echo '<span class="text-danger">OAuth Baseurl Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['baseurl'])){
                echo '<span class="text-danger">Base URL Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['consent_url'])){
                    echo '<span class="text-danger">Consent URL Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['organization_id'])){
                        echo '<span class="text-danger">Organization ID Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['client_key'])){
                            echo '<span class="text-danger">Client Key Tidak Boleh Kosong</span>';
                        }else{
                            if(empty($_POST['secret_key'])){
                                echo '<span class="text-danger">Secret Key Tidak Boleh Kosong</span>';
                            }else{
                                //Bentuk variabel
                                $nama_setting=$_POST['nama_setting'];
                                $oauth_baseurl=$_POST['oauth_baseurl'];
                                $baseurl=$_POST['baseurl'];
                                $consent_url=$_POST['consent_url'];
                                $organization_id=$_POST['organization_id'];
                                $client_key=$_POST['client_key'];
                                $secret_key=$_POST['secret_key'];
                                //Mulai CURL
                                $UrlKirim="$oauth_baseurl/accesstoken?grant_type=client_credentials";
                                //Start CURL
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                CURLOPT_URL => ''.$UrlKirim.'',
                                CURLOPT_SSL_VERIFYPEER => false,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_HEADER => 0,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => 'client_id='.$client_key.'&client_secret='.$secret_key.'',
                                CURLOPT_HTTPHEADER => array(
                                    'Content-Type: application/x-www-form-urlencoded'
                                ),
                                ));
                                $GetResponse = curl_exec($curl);
                                curl_close($curl);
                                if(empty($GetResponse)){
                                    echo '<span class="text-danger">Tidak ada response sama sekali</span>';
                                }else{
                                    //Ekstract Token
                                    $JsonData =json_decode($GetResponse, true);
                                    if(empty($JsonData['status'])){
                                        echo '<span class="text-danger">'.$GetResponse.'</span>';
                                    }else{
                                        $refresh_token_expires_in=$JsonData['refresh_token_expires_in'];
                                        $api_product_list=$JsonData['api_product_list'];
                                        $api_product_list_json=$JsonData['api_product_list_json'];
                                        $organization_name=$JsonData['organization_name'];
                                        $developer_email=$JsonData['developer.email'];
                                        $token_type=$JsonData['token_type'];
                                        $issued_at=$JsonData['issued_at'];
                                        $client_id=$JsonData['client_id'];
                                        $access_token=$JsonData['access_token'];
                                        $application_name=$JsonData['application_name'];
                                        $scope=$JsonData['scope'];
                                        $expires_in=$JsonData['expires_in'];
                                        $refresh_count=$JsonData['refresh_count'];
                                        $status=$JsonData['status'];
                                        $ListApi=implode(", ", $api_product_list_json);
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Expired</dt></div>';
                                        echo '  <div class="col-md-6 text-left"><small>'.$refresh_token_expires_in.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>API Product List</dt></div>';
                                        echo '  <div class="col-md-6 text-left"><small>'.$api_product_list.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>API List (Json)</dt></div>';
                                        echo '  <div class="col-md-6 text-left"><small>'.$ListApi.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Organization Name</dt></div>';
                                        echo '  <div class="col-md-6 text-left"><small>'.$organization_name.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Developer Email</dt></div>';
                                        echo '  <div class="col-md-6 text-left"><small>'.$developer_email.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Token Type</dt></div>';
                                        echo '  <div class="col-md-6 text-left"><small>'.$token_type.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Issued At</dt></div>';
                                        echo '  <div class="col-md-6 text-left"><small>'.$issued_at.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Client ID</dt></div>';
                                        echo '  <div class="col-md-6 text-left"><small>'.$client_id.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Access Token</dt></div>';
                                        echo '  <div class="col-md-6 text-left"><small>'.$access_token.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Aplication Name</dt></div>';
                                        echo '  <div class="col-md-6 text-left"><small>'.$application_name.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Scope</dt></div>';
                                        echo '  <div class="col-md-6 text-left"><small>'.$scope.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Expires in</dt></div>';
                                        echo '  <div class="col-md-6 text-left"><small>'.$expires_in.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Refresh Count</dt></div>';
                                        echo '  <div class="col-md-6 text-left"><small>'.$refresh_count.'</small></div>';
                                        echo '</div>';
                                        echo '<div class="row mb-3">';
                                        echo '  <div class="col-md-6"><dt>Status</dt></div>';
                                        echo '  <div class="col-md-6 text-left"><small>'.$status.'</small></div>';
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