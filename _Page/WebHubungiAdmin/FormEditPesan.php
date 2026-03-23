<?php
    if(empty($_POST['id_pesan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">ID Pesan Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_pesan=$_POST['id_pesan'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Detail Hubungi Admin');
        $KirimData = array(
            'api_key' => $api_key,
            'id_pesan' => $id_pesan
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
                $tanggal=$JsonData['response']['tanggal'];
                $nama_pengirim=$JsonData['response']['nama_pengirim'];
                $email_pengirim=$JsonData['response']['email_pengirim'];
                $kontak=$JsonData['response']['kontak'];
                $kategori=$JsonData['response']['kategori'];
                $subjek=$JsonData['response']['subjek'];
                $pesan=$JsonData['response']['pesan'];
                $pesan_balasan=$JsonData['response']['pesan_balasan'];
                $status=$JsonData['response']['status'];
?>
    <input type="hidden" id="id_pesan" name="id_pesan" value="<?php echo "$id_pesan"; ?>">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="nama_pengirim">Nama Pengirim</label>
                <input type="text" name="nama_pengirim" id="nama_pengirim" class="form-control" value="<?php echo "$nama_pengirim" ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="email_pengirim">Email</label>
                <input type="email" name="email_pengirim" id="email_pengirim" class="form-control" value="<?php echo "$email_pengirim" ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="kontak">Kontak</label>
                <input type="text" name="kontak" id="kontak" class="form-control" value="<?php echo "$kontak" ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="kategori">Kategori</label>
                <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo "$kategori" ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="subjek">Subjek</label>
                <input type="text" name="subjek" id="subjek" class="form-control" value="<?php echo "$subjek" ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="pesan">Isi Pesan</label>
                <textarea name="pesan" id="pesan" cols="30" rows="3" class="form-control"><?php echo "$pesan" ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="pesan_balasan">Pesan Balasan</label>
                <textarea name="pesan_balasan" id="pesan_balasan" cols="30" rows="3" class="form-control"><?php echo "$pesan_balasan" ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option <?php if($status==""){ echo "selected";} ?> value="">Pilih</option>
                    <option <?php if($status=="Pending"){ echo "selected";} ?> value="Pending">Pending</option>
                    <option <?php if($status=="Dibaca"){ echo "selected";} ?> value="Dibaca">Dibaca</option>
                    <option <?php if($status=="Dibalas"){ echo "selected";} ?> value="Dibalas">Dibalas</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3" id="NotifikasiEditPesan">
                <span class="text-primary">Pastikan Data Pesan Sudah Benar</span>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-success">
        <button type="submit" class="btn btn-md btn btn-primary">
            <i class="ti ti-save"></i> Simpan
        </button>
        <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php }}} ?>