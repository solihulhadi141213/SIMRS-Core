<?php
    if(empty($_POST['id_web_unit_karyawan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">ID Anggota Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_web_unit_karyawan=$_POST['id_web_unit_karyawan'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Detail Anggota');
        $KirimData = array(
            'api_key' => $api_key,
            'id_web_unit_karyawan' => $id_web_unit_karyawan
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
                $id_web_unit_karyawan=$JsonData['response']['id_web_unit_karyawan'];
                $id_unit_instalasi=$JsonData['response']['id_unit_instalasi'];
                $nama_karyawan=$JsonData['response']['nama_karyawan'];
                $posisi_jabatan=$JsonData['response']['posisi_jabatan'];
                $sk_jabatan=$JsonData['response']['sk_jabatan'];
                $updatetime=$JsonData['response']['updatetime'];
                $url_foto=$JsonData['response']['url_foto'];
?>
    <input type="hidden" id="id_web_unit_karyawan" name="id_web_unit_karyawan" value="<?php echo "$id_web_unit_karyawan";?>">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="nama_karyawan">Nama Anggota</label>
                <input type="text" id="nama_karyawan" name="nama_karyawan" class="form-control" value="<?php echo "$nama_karyawan";?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="posisi_jabatan">Posisi Jabatan</label>
                <input type="text" id="posisi_jabatan" name="posisi_jabatan" class="form-control" class="form-control" value="<?php echo "$posisi_jabatan";?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="sk_jabatan">SK Jabatan</label>
                <input type="text" id="sk_jabatan" name="sk_jabatan" class="form-control" class="form-control" value="<?php echo "$sk_jabatan";?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="foto">Foto</label>
                <input type="file" id="foto" name="foto" class="form-control">
                <small>Maksimal file 2 mb (jpg, jpeg, png & gif)</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3" id="NotifikasiEditAnggota">
                <small class="text-primary">Pastikan informasi anggota unit yang anda input sudah sesuai</small>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <button type="submit" class="btn btn-md btn btn-success">
            <i class="ti ti-save"></i> Simpan
        </button>
        <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php }}} ?>