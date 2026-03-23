<?php
    //Pengaturan waktu
    date_default_timezone_set('UTC');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    //Membuat fungsi
    include "../../vendor/autoload.php";
    //Inisiasi masing-masing variabel
    if(empty($_POST['id_approval'])){
        $id_approval="";
        echo '<span class="text-danger">ID Approval Tidak Bisa Ditangkap Oleh Sistem</span><br>';
    }else{
        $id_approval=$_POST['id_approval'];
        //Membuka data approval
        //Buka data Pasien
        $Qry = mysqli_query($Conn,"SELECT * FROM approval WHERE id_approval='$id_approval'")or die(mysqli_error($Conn));
        $Data = mysqli_fetch_array($Qry);
        $id_akses= $Data['id_akses'];
        $noKartu= $Data['noKartu'];
        $tglSep= $Data['tglSep'];
        $jnsPelayanan= $Data['jnsPelayanan'];
        $jnsPengajuan= $Data['jnsPengajuan'];
        $keterangan= $Data['keterangan'];
        $user= $Data['user'];
        $status= $Data['status'];
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        //Creat Signature
        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        //Membuat header
        $headers = array(
            'X-signature: '.$encodedSignature.'',
            'X-timestamp: '.$timestamp.'' ,
            'X-cons-id: '.$consid .'',
            'user_key: '.$user_key.'',
            'Content-Type:Application/x-www-form-urlencoded'         
        ); 
        if(!empty($jnsPengajuan)){
            $arr = array("request" =>
                array("t_sep"=>
                    array(
                        "noKartu"=> "$noKartu",
                        "tglSep"=> "$tglSep",
                        "jnsPelayanan"=> "$jnsPelayanan",
                        "jnsPengajuan"=> "$jnsPengajuan",
                        "keterangan"=>"$keterangan",
                        "user"=>"dhiforester"
                    )
                )
            );
        }else{
            $arr = array("request" =>
                array("t_sep"=>
                    array(
                        "noKartu"=> "$noKartu",
                        "tglSep"=> "$tglSep",
                        "jnsPelayanan"=> "$jnsPelayanan",
                        "keterangan"=>"$keterangan",
                        "user"=>"dhiforester"
                    )
                )
            );
        }
        $json = json_encode($arr);
        //Membuat URL
        $TanggalSekarang=date('Y-m-d');
        $URLUtama=$url_vclaim;
        $URLKatalog="Sep/aprovalSEP";
        $url="$URLUtama$URLKatalog";
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
        $code=$ambil_json["metaData"]["code"];
        $message=$ambil_json["metaData"]["message"];
        $string=$ambil_json["response"];
        if($code=="200"){
            if(!empty($string)){
                //Melakukan update status approval
                $UpdateApproval= mysqli_query($Conn,"UPDATE approval SET 
                    status='Acc'
                WHERE id_approval='$id_approval'") or die(mysqli_error($Conn));
                if($UpdateApproval){
                    echo '<span class="text-info" id="NotifikasiApproveBerhasil">Berhasil</span><br>';
                }else{
                    echo '<span class="text-danger">Update pengajuan approval gagal!!</span><br>';
                }
            }
        }else{
            echo '<span class="text-danger">Maaf, kirim Acc approval gagal!!</span><br>';
            echo '<span class="text-danger">Keterangan :'.$message.'<br>';
        }
    }
?>