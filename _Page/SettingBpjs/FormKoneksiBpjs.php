<?php
    include "../../vendor/autoload.php";

    // Zona Waktu
    date_default_timezone_set('UTC');

    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Validasi Sesi
    if (empty($SessionIdAkses)) {
        echo '<div class="alert alert-danger">Sesi Akses Sudah Berakhir! Silahkan Login Ulang.</div>';
        exit;
    }

    // Validasi ID
    if (empty($_POST['id_setting_bpjs'])) {
        echo '<div class="alert alert-danger">ID tidak valid.</div>';
        exit;
    }

    $id = intval($_POST['id_setting_bpjs']);

    // Ambil data
    $stmt = $Conn->prepare("SELECT * FROM setting_bpjs WHERE id_setting_bpjs = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo '<div class="alert alert-warning">Data tidak ditemukan.</div>';
        exit;
    }
    $data = $result->fetch_assoc();

    // Buat Variabel
    $nama_setting_bpjs = $data['nama_setting_bpjs'] ?? '';
    $consid            = $data['consid'] ?? '';
    $user_key          = $data['user_key'] ?? '';
    $user_key_antrol   = $data['user_key_antrol'] ?? '';
    $secret_key        = $data['secret_key'] ?? '';
    $kode_ppk          = $data['kode_ppk'] ?? '';
    $url_vclaim        = $data['url_vclaim'] ?? '';
    $url_aplicare      = $data['url_aplicare'] ?? '';
    $url_antrol        = $data['url_antrol'] ?? '';
    $url_icare         = $data['url_icare'] ?? '';
    $status            = $data['status'] ?? '';

    // Timestamp
    $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));

    //Signature
    $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
    
    // base64 encode…
    $encodedSignature = base64_encode($signature);
    
    // urlencodedSignature
    $urlencodedSignature = urlencode($encodedSignature);
?>
<div class="row mb-2">
    <div class="col-12">
        <small><b># Detail Pengaturan</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Profil Pengaturan</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-secondary"><?php echo $nama_setting_bpjs; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small><i>Cons ID</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-secondary"><?php echo $consid; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small><i>User Key</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <input type="text" readonly class="form-control form-control-sm bg-light" value="<?php echo $consid; ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small><i>User Key (Antrol)</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <input type="text" readonly class="form-control form-control-sm bg-light" value="<?php echo $user_key_antrol; ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small><i>Secret Key</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-secondary"><?php echo $secret_key; ?></small>
    </div>
</div>
<div class="row mt-4 mb-2">
    <div class="col-12">
        <small><b># Timestamp & Signature</b></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small><i>Timestamp</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-secondary"><?php echo $timestamp; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small><i>X-Signature</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <input type="text" readonly class="form-control form-control-sm bg-light" value="<?php echo $urlencodedSignature; ?>">
    </div>
</div>

<!-- Uji Coba Dengan Get Kunjungan -->
<div class="row mt-4 mb-2">
    <div class="col-12">
        <small><b># Get Kunjungan Rawat Inap</b></small>
    </div>
</div>
<?php
    $tanggal         = date('Y-m-d');
    $jenis_pelayanan = 1;
    $url_service     = "$url_vclaim/Monitoring/Kunjungan/Tanggal/$tanggal/JnsPelayanan/$jenis_pelayanan";

    // Mulai CURL
    $ch = curl_init();
    $headers = array(
        'X-signature: '.$encodedSignature.'',
        'X-timestamp: '.$timestamp.'' ,
        'X-cons-id: '.$consid .'',
        'user_key: '.$user_key.'',
        'Content-Type:Application/x-www-form-urlencoded'         
    ); 
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL, "$url_service");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_HEADER, 0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $content = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    $ambil_json =json_decode($content, true);
    $response = $ambil_json['response'];

    //Proses decode dan dekompresi
    //--membuat key
    $key="$consid$secret_key$timestamp";
    //--masukan ke fungsi
    $FileDeskripsi=stringDecrypt("$key", "$response");
    $FileDekompresi=decompress("$FileDeskripsi");
?>
<div class="row mb-2">
    <div class="col-5"><small><i>Tanggal Pelayanan</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-secondary"><?php echo $tanggal; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small><i>Jenis Pelayanan</i></small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <small class="text text-secondary"><?php echo $jenis_pelayanan; ?></small>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-12">
        <label for="response"><small><i>Response</i></small></label>
        <textarea name="response" id="response" class="form-control" row="10"><?php echo $content; ?></textarea>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-12">
        <label for="Decrypt"><small><i>Decrypt</i></small></label>
        <textarea name="Decrypt" id="Decrypt" class="form-control" row="10"><?php echo $FileDekompresi; ?></textarea>
    </div>
</div>
