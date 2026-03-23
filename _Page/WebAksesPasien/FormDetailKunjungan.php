<?php
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">ID Pasien Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Detail Kunjungan');
        $KirimData = array(
            'api_key' => $api_key,
            'id_kunjungan' => $id_kunjungan
        );
        $json = json_encode($KirimData);
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if(!empty($err)){
            echo '<div class="row">';
            echo '  <div class="col-md-12">';
            echo '      <span class="text-danger">'.$err.'</span>';
            echo '  </div>';
            echo '</div>';
        }else{
            $JsonData =json_decode($content, true);
            if(!empty($JsonData['metadata']['massage'])){
                $massage=$JsonData['metadata']['massage'];
            }else{
                $massage="";
            }
            if(!empty($JsonData['metadata']['code'])){
                $code=$JsonData['metadata']['code'];
            }else{
                $code="";
            }
            if($code!==200){
                echo '<div class="row">';
                echo '  <div class="col-md-12">';
                echo '      <span class="text-danger">'.$massage.'</span>';
                echo '  </div>';
                echo '</div>';
            }else{
                $id_web_pasien=$JsonData['response']['id_web_pasien'];
                if(empty($JsonData['response']['id_pasien'])){
                    $id_pasien="Tidak Ada";
                }else{
                    $id_pasien=$JsonData['response']['id_pasien'];
                }
                if(empty($JsonData['response']['nomorreferensi'])){
                    $nomorreferensi="Tidak Ada";
                }else{
                    $nomorreferensi=$JsonData['response']['nomorreferensi'];
                }
                $tanggal_daftar=$JsonData['response']['tanggal_daftar'];
                $tanggal_kunjungan=$JsonData['response']['tanggal_kunjungan'];
                $jam_kunjungan=$JsonData['response']['jam_kunjungan'];
                $kode_dokter=$JsonData['response']['kode_dokter'];
                $nama_dokter=$JsonData['response']['nama_dokter'];
                $kodepoli=$JsonData['response']['kodepoli'];
                $namapoli=$JsonData['response']['namapoli'];
                $keluhan=$JsonData['response']['keluhan'];
                $pembayaran=$JsonData['response']['pembayaran'];
                $status=$JsonData['response']['status'];
                if(empty($JsonData['response']['no_antrian'])){
                    $no_antrian="Tidak Ada";
                }else{
                    $no_antrian=$JsonData['response']['no_antrian'];
                }
                if(empty($JsonData['response']['kodebooking'])){
                    $kodebooking="Tidak Ada";
                }else{
                    $kodebooking=$JsonData['response']['kodebooking'];
                }
                if(empty($JsonData['response']['keterangan'])){
                    $keterangan="Tidak Ada";
                }else{
                    $keterangan=$JsonData['response']['keterangan'];
                }
?>
    <div class="row mb-3">
        <div class="col-md-4"><dt>NO.RM Web</dt></div>
        <div class="col-md-8"><small><?php echo "$id_web_pasien"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>ID.RM SIMRS</dt></div>
        <div class="col-md-8"><small><?php echo "$id_pasien"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>No.Referensi</dt></div>
        <div class="col-md-8"><small><?php echo "$nomorreferensi"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Tgl Daftar</dt></div>
        <div class="col-md-8"><small><?php echo "$tanggal_daftar"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Tgl Kunjungan</dt></div>
        <div class="col-md-8"><small><?php echo "$tanggal_kunjungan"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Jam Kunjungan</dt></div>
        <div class="col-md-8"><small><?php echo "$jam_kunjungan"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Kode Dokter</dt></div>
        <div class="col-md-8"><small><?php echo "$kode_dokter"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Nama Dokter</dt></div>
        <div class="col-md-8"><small><?php echo "$nama_dokter"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Kode Poli</dt></div>
        <div class="col-md-8"><small><?php echo "$kodepoli"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Nama Poli</dt></div>
        <div class="col-md-8"><small><?php echo "$namapoli"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Keluhan</dt></div>
        <div class="col-md-8"><small><?php echo "$keluhan"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Pembayaran</dt></div>
        <div class="col-md-8"><small><?php echo "$pembayaran"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Status</dt></div>
        <div class="col-md-8"><small><?php echo "$status"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>No.Antrian</dt></div>
        <div class="col-md-8"><small><?php echo "$no_antrian"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Kode Booking</dt></div>
        <div class="col-md-8"><small><?php echo "$kodebooking"; ?></small></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"><dt>Keterangan</dt></div>
        <div class="col-md-8"><small><?php echo "$keterangan"; ?></small></div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <a href="index.php?Page=WebKunjungan&Sub=DetailKunjungan&id=<?php echo $id_kunjungan; ?>" class="btn btn-sm btn-block btn-outline-dark">
                Selengkapnya <i class="ti ti-more-alt"></i>
            </a>
        </div>
    </div>
<?php }}} ?>