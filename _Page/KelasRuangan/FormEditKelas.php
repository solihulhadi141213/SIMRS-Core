<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap variabel
    if(empty($_POST['id_ruang_rawat'])){
        echo "<span class='text-danger'>Maaf ID Ruangan Tidak Bisa Ditangkap!!</span>";
    }else{
        $id_ruang_rawat=$_POST['id_ruang_rawat'];
        //Membuka detail database
        $Qry = mysqli_query($Conn,"SELECT * FROM ruang_rawat WHERE id_ruang_rawat='$id_ruang_rawat'")or die(mysqli_error($Conn));
        $Data = mysqli_fetch_array($Qry);
        $GetkodeKelas = $Data['kodekelas'];
        $kelas = $Data['kelas'];
?>
<form action="javascript:void(0);" method="POST" id="ProsesEditKelas" autocomplete="off">
    <input type="hidden" name="id_ruang_rawat" id="id_ruang_rawat" value="<?php echo "$id_ruang_rawat"; ?>">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="kategori"><dt>Kategori</dt></label>
                <input type="text" readonly name="kategori" id="kategori" class="form-control" value="kelas">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="kode"><dt>Kode Kelas</dt></label>
                <select name="kodekelas" id="kodekelas" class="form-control" required>
                    <option value="">Pilih</option>
                    <?php
                        //Menampilkan data kelas dan kode kelas
                        include "../../_Config/Connection.php";
                        include "../../_Config/Session.php";
                        include "../../_Config/SettingBridging.php";
                        //Arraykan data
                        $url ="$url_aplicare/rest/ref/kelas";
                        //KONFIGURASI
                        date_default_timezone_set('UTC');
                        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                        //Creat Signature
                        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
                        // base64 encode…
                        $encodedSignature = base64_encode($signature);
                        $ch=curl_init();
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
                        $data =json_decode($content, true);
                        if(empty($data["response"]["list"])){
                            $list="";
                        }else{
                            $list=$data["response"]["list"];
                        }
                        $totalitems=$data["metadata"]["totalitems"];
                        if($content==false){
                            echo "Maaf, Tidak ada koneksi!! $send $data2 $data";
                        }else{
                            if(empty($totalitems)){
                                echo '<option>Tidak ada data</option>';
                            }else{
                                for($a=0; $a<$totalitems; $a++){
                                    $kodekelas=$list[$a]['kodekelas'];
                                    $namakelas=$list[$a]['namakelas'];
                                    if($GetkodeKelas==$kodekelas){
                                        echo '<option selected value="'.$kodekelas.'">'.$namakelas.'</option>';
                                    }else{
                                        echo '<option value="'.$kodekelas.'">'.$namakelas.'</option>';
                                    }
                                }
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="kelas"><dt>Nama Kelas</dt></label>
                <input type="text" name="kelas" id="kelas" class="form-control" value="<?php echo "$kelas"; ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3" id="NotifikasiEditKelas">
                <p class="text-primary">Pastikan data yang anda input sudah benar</p>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <button type="submit" class="btn btn-md btn-inverse mr-2 mt-2"> <i class="ti-save"></i> Simpan</button>
        <button type="button" class="btn btn-md btn-light mr-2 mt-2" data-dismiss="modal"> <i class="ti-close"></i> Tutup</button>
    </div>
</form>
<?php } ?>