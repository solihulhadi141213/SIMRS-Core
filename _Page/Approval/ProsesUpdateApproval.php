<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    if(empty($_POST['id_approval'])){
        echo '<span class="text-danger">ID Approval Tidak Boleh Kosong!</span>';
    }else{
        $id_approval=$_POST['id_approval'];
        //Buka Approval
        $id_akses=getDataDetail($Conn,'approval',"id_approval",$id_approval,'id_akses');
        $noKartu=getDataDetail($Conn,'approval',"id_approval",$id_approval,'noKartu');
        $tglSep=getDataDetail($Conn,'approval',"id_approval",$id_approval,'tglSep');
        $jnsPelayanan=getDataDetail($Conn,'approval',"id_approval",$id_approval,'jnsPelayanan');
        $jnsPengajuan=getDataDetail($Conn,'approval',"id_approval",$id_approval,'jnsPengajuan');
        $keterangan=getDataDetail($Conn,'approval',"id_approval",$id_approval,'keterangan');
        $user=getDataDetail($Conn,'approval',"id_approval",$id_approval,'user');
        $status=getDataDetail($Conn,'approval',"id_approval",$id_approval,'status');
        //Buat JSON Header
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type:Application/x-www-form-urlencoded'         
        );
        $t_sep = array(
            "noKartu"=> "$noKartu",        
            "tglSep"=> "$tglSep",        
            "jnsPelayanan"=> "$jnsPelayanan",
            "keterangan"=> "$keterangan",        
            "user"=> "$user" 
        );
        $request = array(
            "t_sep"=> $t_sep,
        );
        $arr = array(
            "request"=> $request,
        );
        $json = json_encode($arr);
        $url="$url_vclaim/Sep/aprovalSEP";
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $ambil_json =json_decode($content, true);
        if(empty($content)){
            echo '<span class="text-danger">Tidak ada response dari WS BPJS!</span>';
        }else{
            if(empty($ambil_json['metaData'])){
                echo '<span class="text-danger">'.$content.'</span>';
            }else{
                if($ambil_json['metaData']['code']!=="200"){
                    echo '<span class="text-danger">Keterangan : '.$ambil_json['metaData']['message'].'</span>';
                }else{
                    //Update Ke Database Lokal
                    $UpdateApproval = mysqli_query($Conn,"UPDATE approval SET 
                        status='$PasswordEnkripsi'
                    WHERE id_approval='Approval'") or die(mysqli_error($Conn)); 
                    if($UpdateApproval){
                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Approval","Approval",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            echo '<span class="text-success" id="NotifikasiUpdateApprovalBerhasil">Success</span>';
                        }else{
                            echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan data log!</span>';
                        }
                    }else{
                        echo '<span class="text-danger">Terjadi kesalahan pada saat update data approval!</span>';
                    }
                }
            }
        }
    }
?>