<?php
date_default_timezone_set('Asia/Jakarta');

include "../../_Config/Connection.php";
include "../../_Config/SimrsFunction.php";
include "../../_Config/Session.php";

header('Content-Type: application/json');

// ================= VALIDASI SESSION
if (empty($SessionIdAkses)) {
    echo json_encode(['status'=>'error','message'=>'Session habis']);
    exit;
}

// ================= PARAMETER BATCH
$offset = isset($_POST['offset']) ? (int)$_POST['offset'] : 0;
$limit  = isset($_POST['limit']) ? (int)$_POST['limit'] : 5;

// ================= FUNCTION CURL RETRY
function curlRequest($url, $headers, $payload){
    $retry = 3;

    for($i=0; $i<$retry; $i++){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $result = curl_exec($ch);
        $err    = curl_error($ch);
        curl_close($ch);

        if($result !== false){
            return $result;
        }

        usleep(500000); // retry delay
    }

    return false;
}

// ================= AMBIL SETTING BPJS
$q = mysqli_query($Conn,"SELECT * FROM setting_bpjs WHERE status=1 LIMIT 1");
$setting = mysqli_fetch_assoc($q);

if(empty($setting)){
    echo json_encode(['status'=>'error','message'=>'Setting BPJS belum ada']);
    exit;
}

$consid = $setting['consid'];
$secret = $setting['secret_key'];
$user_key = $setting['user_key'];
$url_aplicare = $setting['url_aplicare'];
$kode_ppk = $setting['kode_ppk'];

// ================= SIGNATURE
date_default_timezone_set('UTC');
$timestamp = time();
$signature = base64_encode(hash_hmac('sha256',$consid."&".$timestamp,$secret,true));

$headers = [
    "X-cons-id: $consid",
    "X-timestamp: $timestamp",
    "X-signature: $signature",
    "user_key: $user_key",
    "Content-Type: Application/JSON"
];

// ================= TOTAL DATA
$total_q = mysqli_query($Conn,"SELECT COUNT(*) as total FROM rr_ruang_rawat WHERE status=1");
$total = mysqli_fetch_assoc($total_q)['total'];

// ================= AMBIL DATA BATCH
$q = mysqli_query($Conn,"
    SELECT r.*, k.kelas, k.kode_kelas
    FROM rr_ruang_rawat r
    JOIN rr_kelas_rawat k ON r.id_kelas_rawat=k.id_kelas_rawat
    WHERE r.status=1
    LIMIT $offset,$limit
");

$html = '';
$no = $offset + 1;

while($row = mysqli_fetch_assoc($q)){

    $id_ruang = $row['id_ruang_rawat'];
    $nama_ruang = $row['ruang_rawat'];
    $kelas = $row['kelas'];
    $kode_kelas = $row['kode_kelas'];

    // ================= HITUNG TT (OPTIMASI)
    $tt = mysqli_fetch_assoc(mysqli_query($Conn,"
        SELECT 
            SUM(pria=1) as pria,
            SUM(wanita=1) as wanita,
            SUM(bebas=1) as bebas
        FROM rr_tempat_tidur
        WHERE id_ruang_rawat='$id_ruang' AND status=1
    "));

    $kapasitas = $tt['pria'] + $tt['wanita'] + $tt['bebas'];

    // ================= INSERT KE APLICARE
    $url = "$url_aplicare/rest/bed/create/$kode_ppk";

    $payload = json_encode([
        "kodekelas"=>$kode_kelas,
        "koderuang"=>"RSES-RR-$id_ruang",
        "namaruang"=>$nama_ruang,
        "kapasitas"=>$kapasitas,
        "tersedia"=>$kapasitas,
        "tersediapria"=>$tt['pria'],
        "tersediawanita"=>$tt['wanita'],
        "tersediapriawanita"=>$tt['bebas']
    ]);

    $res = curlRequest($url,$headers,$payload);

    if($res === false){
        $notif = '<small class="text-danger">Timeout</small>';
    }else{
        $json = json_decode($res,true);
        $notif = '<small class="text-success">'.$json['metadata']['message'].'</small>';
    }

    // ================= OUTPUT ROW
    $html .= "
    <tr>
        <td class='text-center'><small>$no</small></td>
        <td><small>$nama_ruang</small></td>
        <td><small>RSES-RR-$id_ruang</small></td>
        <td><small>$kelas</small></td>
        <td><small>$kode_kelas</small></td>
        <td class='text-center'><small>{$tt['pria']}</small></td>
        <td class='text-center'><small>{$tt['wanita']}</small></td>
        <td class='text-center'><small>{$tt['bebas']}</small></td>
        <td class='text-center'><small>$kapasitas</small></td>
        <td class='text-center'>$notif</td>
    </tr>
    ";

    usleep(300000); // DELAY WAJIB
    $no++;
}

// ================= RESPONSE
echo json_encode([
    'status'=>'success',
    'html'=>$html,
    'total'=>$total
]);