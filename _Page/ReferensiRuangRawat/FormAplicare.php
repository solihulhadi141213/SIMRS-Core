<?php
    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Koneksi, Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Buka Pengaturan Bridging BPJS yang Aktif
    $stmt = mysqli_prepare($Conn,"SELECT * FROM setting_bpjs WHERE status = 1 ORDER BY id_setting_bpjs DESC LIMIT 1");
    if (!$stmt) {
        echo '
            <tr>
                <td colspan="10" class="text-center">
                    <small class="text-danger">Pengaturan Bridging BPJS Belum Diatur.</small>
                </td>
            </tr>
        ';
        exit;
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $setting = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    if (empty($setting)) {
        echo '
            <tr>
                <td colspan="10" class="text-center">
                    <small class="text-danger">Pengaturan Bridging BPJS Belum Diatur.</small>
                </td>
            </tr>
        ';
        exit;
    }

    // Buat Variabelnya
    $consid          = trim($setting['consid'] ?? '');
    $user_key        = trim($setting['user_key'] ?? '');
    $user_key_antrol = trim($setting['user_key_antrol'] ?? '');
    $secret_key      = trim($setting['secret_key'] ?? '');
    $kode_ppk        = trim($setting['kode_ppk'] ?? '');
    $url_aplicare    = $setting['url_aplicare'];

    // UTC
    date_default_timezone_set('UTC');

    // TIMESTAMP
    $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
    
    //SIGNATURE
    $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
    
    // base64 encode…
    $encodedSignature = base64_encode($signature);

    // Endpoint
    $url = "$url_aplicare/rest/bed/read/$kode_ppk/0/100";

    // INISIASI CULR
    $ch=curl_init();
    $headers = array(
        'X-signature: '.$encodedSignature.'',
        'X-timestamp: '.$timestamp.'' ,
        'X-cons-id: '.$consid .'',
        'user_key: '.$user_key.'',
        'Content-Type: Application/JSON',          
        'Accept: Application/JSON'     
    ); 
    $headers = array(
        'X-signature: '.$encodedSignature.'',
        'X-timestamp: '.$timestamp.'' ,
        'X-cons-id: '.$consid .'',
        'user_key: '.$user_key.'',
        'Content-Type: Application/JSON',          
        'Accept: Application/JSON'
    );
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, "$url");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_HEADER, 0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $content = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    // Jika Ada Masalah pada Content Response
    if($content==false){
        echo '
            <tr>
                <td colspan="10" class="text-center">
                    <small class="text-danger">Ada masalah Pada Koneksi <br> <pre>'.$err.'</pre></small>
                </td>
            </tr>
        ';
        exit;
    }

    // Decode JSON
    $data =json_decode($content, true);
    if(empty($data["response"]["list"])){
        echo '
            <tr>
                <td colspan="10" class="text-center">
                    <small class="text-danger">Data Ketersediaan Ruangan Aplicare Tidak Ditemukan</small>
                </td>
            </tr>
        ';
        exit;
    }

    // Inisiasi List
    $list       = $data["response"]["list"];

    // Hitung Total Data
    $totalitems = $data["metadata"]["totalitems"];

    // Jika Data Tidak Ada
    if(empty($totalitems)){
        echo '
            <tr>
                <td colspan="10" class="text-center">
                    <small class="text-danger">Belum Ada Data Ketersediaan Ruangan Pada Aplicare.</small>
                </td>
            </tr>
        ';
        exit;
    }

    // Inisiasai Jumlah Total
    $total_pria      = 0;
    $total_wanita    = 0;
    $total_bebas     = 0;
    $total_kapasitas = 0;
    // Tampilkan Data Dengan Looping
    for($a=0; $a<$totalitems; $a++){
        $tersedia           = $list[$a]['tersedia'];
        $kodekelas          = $list[$a]['kodekelas'];
        $namakelas          = $list[$a]['namakelas'];
        $tersediapria       = $list[$a]['tersediapria'];
        $tersediawanita     = $list[$a]['tersediawanita'];
        $koderuang          = $list[$a]['koderuang'];
        $tersediapriawanita = $list[$a]['tersediapriawanita'];
        $namaruang          = $list[$a]['namaruang'];
        $rownumber          = $list[$a]['rownumber'];
        $kapasitas          = $list[$a]['kapasitas'];
        $lastupdate         = $list[$a]['lastupdate'];

        // Hitung Total
        $total_pria      = $total_pria + $tersediapria;
        $total_wanita    = $total_wanita + $tersediawanita;
        $total_bebas     = $total_bebas + $tersediapriawanita;
        $total_kapasitas = $total_kapasitas + $kapasitas;

        echo '
            <tr>
                <td class="text-center"><small>'.$a.'</small></td>
                <td class="text-left"><small>'.$namaruang.'</small></td>
                <td class="text-left"><small>'.$koderuang.'</small></td>
                <td class="text-left"><small>'.$namakelas.'</small></td>
                <td class="text-left"><small>'.$kodekelas.'</small></td>
                <td class="text-center"><small>'.$tersediapria.'</small></td>
                <td class="text-center"><small>'.$tersediawanita.'</small></td>
                <td class="text-center"><small>'.$tersediapriawanita.'</small></td>
                <td class="text-center"><small>'.$kapasitas.'</small></td>
                <td class="text-center"><small>'.$lastupdate.'</small></td>
            </tr>
        ';
    }
    echo '
        <tr>
            <td class="text-center"></td>
            <td class="text-left" colspan="4">
                <small><b>JUMLAH TOTAL</b></small>
            </td>
            <td class="text-center"><small><b>'.$total_pria.'</b></small></td>
            <td class="text-center"><small><b>'.$total_wanita.'</b></small></td>
            <td class="text-center"><small><b>'.$total_bebas.'</b></small></td>
            <td class="text-center"><small><b>'.$total_kapasitas.'</b></small></td>
            <td class="text-center"></td>
        </tr>
    ';
?>