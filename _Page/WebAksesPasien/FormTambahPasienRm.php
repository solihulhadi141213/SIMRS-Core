<?php 
    if(empty($_POST['id_web_pasien'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12">';
        echo '          <span class="text-danger">ID Pasien Web Tidak Boleh Kosong!</span>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        date_default_timezone_set('Asia/Jakarta');
        $id_web_pasien=$_POST['id_web_pasien'];
        include "../../_Config/Connection.php";
        include "../../_Config/SettingKoneksiWeb.php";
        include "../../_Config/WebFunction.php";
        $url=getServiceUrl2('Detail Pasien');
        $KirimData = array(
            'api_key' => $api_key,
            'id_web_pasien' => $id_web_pasien
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
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12">';
            echo '          <span class="text-danger">'.$err.'</span>';
            echo '      </div>';
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
                echo '<div class="modal-body">';
                echo '  <div class="row">';
                echo '      <div class="col-md-12">';
                echo '          <span class="text-danger">'.$massage.'</span>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $id_web_pasien=$JsonData['response']['id_web_pasien'];
                $tanggal_daftar=$JsonData['response']['tanggal_daftar'];
                if(empty($JsonData['response']['nik'])){
                    $nik="";
                }else{
                    $nik=$JsonData['response']['nik'];
                }
                if(empty($JsonData['response']['bpjs'])){
                    $bpjs="";
                }else{
                    $bpjs=$JsonData['response']['bpjs'];
                }
                $nama=$JsonData['response']['nama'];
                //Format tanggal
                $strtotime=strtotime($tanggal_daftar);
                $Tanggal=date('d/m/Y H:i',$strtotime);
                if(empty($JsonData['response']['propinsi'])){
                    $propinsi="";
                }else{
                    $propinsi=$JsonData['response']['propinsi'];
                }
                if(empty($JsonData['response']['kabupaten'])){
                    $kabupaten="";
                }else{
                    $kabupaten=$JsonData['response']['kabupaten'];
                }
                if(empty($JsonData['response']['kecamatan'])){
                    $kecamatan="";
                }else{
                    $kecamatan=$JsonData['response']['kecamatan'];
                }
                if(empty($JsonData['response']['desa'])){
                    $desa="";
                }else{
                    $desa=$JsonData['response']['desa'];
                }
                if(empty($JsonData['response']['alamat'])){
                    $alamat="";
                }else{
                    $alamat=$JsonData['response']['alamat'];
                }
                if(empty($JsonData['response']['tepat_lahir'])){
                    $tepat_lahir="";
                }else{
                    $tepat_lahir=$JsonData['response']['tepat_lahir'];
                }
                if(empty($JsonData['response']['tanggal_lahir'])){
                    $tanggal_lahir="";
                }else{
                    $tanggal_lahir=$JsonData['response']['tanggal_lahir'];
                }
                if(empty($JsonData['response']['kontak'])){
                    $kontak="";
                }else{
                    $kontak=$JsonData['response']['kontak'];
                }
                if(empty($JsonData['response']['email'])){
                    $email="";
                }else{
                    $email=$JsonData['response']['email'];
                }
                if(empty($JsonData['response']['password'])){
                    $password="";
                }else{
                    $password=$JsonData['response']['password'];
                }
                if(empty($JsonData['response']['gol_darah'])){
                    $gol_darah="";
                }else{
                    $gol_darah=$JsonData['response']['gol_darah'];
                }
                if(empty($JsonData['response']['sex'])){
                    $sex="";
                }else{
                    $sex=$JsonData['response']['sex'];
                }
                if(empty($JsonData['response']['pekerjaan'])){
                    $pekerjaan="";
                }else{
                    $pekerjaan=$JsonData['response']['pekerjaan'];
                }
                if(empty($JsonData['response']['perkawinan'])){
                    $perkawinan="";
                }else{
                    $perkawinan=$JsonData['response']['perkawinan'];
                }
                if(empty($JsonData['response']['token'])){
                    $token="";
                }else{
                    $token=$JsonData['response']['token'];
                }
                if(empty($JsonData['response']['status'])){
                    $status="";
                }else{
                    $status=$JsonData['response']['status'];
                }
                if(empty($JsonData['response']['updatetime'])){
                    $updatetime="";
                }else{
                    $updatetime=$JsonData['response']['updatetime'];
                    $strtotime2=strtotime($updatetime);
                    $updatetime=date('d/m/Y H:i',$strtotime2);
                }
                $foto_profile=$JsonData['response']['foto_profile'];
                //Membuat RM Terbaru
                $Qry=mysqli_query($Conn, "SELECT max(id_pasien) as maksimal FROM pasien")or die(mysqli_error($Conn));
                while($Hasil=mysqli_fetch_array($Qry)){
                    $NilaiMaxRm=$Hasil['maksimal'];
                }
                $MaxRm=$NilaiMaxRm+1;
?>
<form action="javascript:void(0);" id="ProsesTambahPasien">
    <input type="hidden" id="id_web_pasien" name="id_web_pasien" value="<?php echo "$id_web_pasien"; ?>">
    <input type="hidden" id="email" name="email" value="<?php echo "$email"; ?>">
    <input type="hidden" id="password" name="password" value="<?php echo "$password"; ?>">
    <input type="hidden" id="token" name="token" value="<?php echo "$token"; ?>">
    <input type="hidden" id="status_web" name="status_web" value="<?php echo "$status"; ?>">
    <div class="modal-body">
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="id_pasien"><dt>Nomor RM</dt></label>
            </div>
            <div class="col-md-8">
                <div class="input-group">
                    <input type="text" readonly name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$MaxRm";?>" required>
                    <button type="button" class="btn btn-sm btn-secondary" id="ReloadIdPasien" title="Reload Ulang Nomor RM">
                        <i class="ti ti-reload"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="nik"><dt>Nomor KTP (NIK)</dt></label>
            </div>
            <div class="col-md-8">
                <div class="input-group">
                    <input type="text" name="nik" id="nik" class="form-control" value="<?php echo "$nik";?>">
                    <button type="button" class="btn btn-sm btn-secondary" id="CekNik" title="Cek Nomor NIK di SIMRS" value="Tampilkan">
                        <i class="ti ti-angle-down"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12" id="HasilCekNik">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for=""><dt>Nomor Kartu (BPJS)</dt></label>
            </div>
            <div class="col-md-8">
                <div class="input-group">
                    <input type="text" name="no_bpjs" id="no_bpjs" class="form-control" value="<?php echo "$bpjs";?>">
                    <button type="button" class="btn btn-sm btn-secondary" id="CekBpjs" title="Cek Nomor BPJS Di SIMRS" value="Tampilkan">
                        <i class="ti ti-angle-down"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12" id="HasilCekBpjs">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="tanggal_daftar"><dt>Tanggal Daftar</dt></label>
            </div>
            <div class="col-md-8">
                <input type="date" name="tanggal_daftar" id="tanggal_daftar" class="form-control" value="<?php echo $tanggal_daftar;?>">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="nama"><dt>Nama Pasien</dt></label>
            </div>
            <div class="col-md-8">
                <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $nama;?>">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="gender"><dt>Gender</dt></label>
            </div>
            <div class="col-md-8">
                <select id="gender" name="gender" class="form-control" required>
                    <option <?php if($sex==""){echo "selected";} ?> value="">Pilih</option>
                    <option <?php if($sex=="Laki-laki"){echo "selected";} ?> value="Laki-laki">Laki-laki</option>
                    <option <?php if($sex=="Perempuan"){echo "selected";} ?> value="Perempuan">Perempuan</option>
                </select>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="tempat_lahir"><dt>Tempat, Tanggal Lahir</dt></label>
            </div>
            <div class="col-md-4">
                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="<?php echo $tepat_lahir;?>">
                <small>Tempat Lahir</small>
            </div>
            <div class="col-md-4">
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="<?php echo $tanggal_lahir;?>">
                <small>Tanggal Lahir</small>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="propinsi"><dt>Propinsi</dt></label>
            </div>
            <div class="col-md-8">
                <select id="propinsi" name="propinsi" class="form-control">
                    <option value="">Pilih</option>
                    <?php
                        //Arraykan propinsi
                        $QryPropinsi = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Propinsi' ORDER BY propinsi ASC");
                        while ($DataPropinsi = mysqli_fetch_array($QryPropinsi)) {
                            $ListProvinsi= $DataPropinsi['propinsi'];
                            if($propinsi==$ListProvinsi){
                                echo '<option selected value="'.$ListProvinsi.'">'.$ListProvinsi.'</option>';
                            }else{
                                echo '<option value="'.$ListProvinsi.'">'.$ListProvinsi.'</option>';
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="kabupaten"><dt>Kabupaten/Kota</dt></label>
            </div>
            <div class="col-md-8">
                <select id="kabupaten" name="kabupaten" class="form-control">
                    <option value="">Pilih</option>
                    <?php
                        if(!empty($propinsi)){
                            //Arraykan Kabupaten
                            $QryKabupaten = mysqli_query($Conn, "SELECT DISTINCT kabupaten FROM wilayah WHERE propinsi='$propinsi' ORDER BY kabupaten ASC");
                            while ($DataKabupaten = mysqli_fetch_array($QryKabupaten)) {
                                if(!empty($DataKabupaten['kabupaten'])){
                                    $ListKabupaten= $DataKabupaten['kabupaten'];
                                    if($ListKabupaten==$kabupaten){
                                        echo '<option selected value="'.$ListKabupaten.'">'.$ListKabupaten.'</option>';
                                    }else{
                                        echo '<option value="'.$ListKabupaten.'">'.$ListKabupaten.'</option>';
                                    }
                                }
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="kecamatan"><dt>Kecamatan</dt></label>
            </div>
            <div class="col-md-8">
                <select id="kecamatan" name="kecamatan" class="form-control">
                    <option value="">Pilih</option>
                    <?php
                        if(!empty($kabupaten)){
                            $QryKecamatan = mysqli_query($Conn, "SELECT DISTINCT kecamatan FROM wilayah WHERE kabupaten='$kabupaten' ORDER BY kecamatan ASC");
                            while ($DataKecamatan = mysqli_fetch_array($QryKecamatan)) {
                                if(!empty($DataKecamatan['kecamatan'])){
                                    $ListKecamatan= $DataKecamatan['kecamatan'];
                                    if($ListKecamatan==$kecamatan){
                                        echo '<option selected value="'.$ListKecamatan.'">'.$ListKecamatan.'</option>';
                                    }else{
                                        echo '<option value="'.$ListKecamatan.'">'.$ListKecamatan.'</option>';
                                    }
                                }
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="desa"><dt>Desa/Kelurahan</dt></label>
            </div>
            <div class="col-md-8">
                <select id="desa" name="desa" class="form-control">
                    <option value="">Pilih</option>
                    <?php
                        if(!empty($kecamatan)){
                            $QryDesa = mysqli_query($Conn, "SELECT DISTINCT id_wilayah, desa FROM wilayah WHERE kecamatan='$kecamatan' ORDER BY desa ASC");
                            while ($DataDesa = mysqli_fetch_array($QryDesa)) {
                                if(!empty($DataDesa['desa'])){
                                    $ListDesa= $DataDesa['desa'];
                                    if($ListDesa==$desa){
                                        echo '<option selected value="'.$ListDesa.'">'.$ListDesa.'</option>';
                                    }else{
                                        echo '<option value="'.$ListDesa.'">'.$ListDesa.'</option>';
                                    }
                                }
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="alamat"><dt>Alamat</dt></label>
            </div>
            <div class="col-md-8">
                <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo $alamat;?>" required>
                <small>Keterangan Jalan/RT/RW</small>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="kontak"><dt>No.Kontak</dt></label>
            </div>
            <div class="col-md-8">
                <input type="text" name="kontak" id="kontak" class="form-control" placeholder="+62" value="<?php echo $kontak;?>">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="kontak_darurat"><dt>No.Kontak (Darurat)</dt></label>
            </div>
            <div class="col-md-8">
                <input type="text" name="kontak_darurat" id="kontak_darurat" class="form-control" placeholder="+62">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="penanggungjawab"><dt>Penanggung Jawab</dt></label>
            </div>
            <div class="col-md-8">
                <input type="text" name="penanggungjawab" id="penanggungjawab" class="form-control">
                <small>Saran: Nama pemilik nomor darurat</small>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="golongan_darah"><dt>Golongan Darah</dt></label>
            </div>
            <div class="col-md-8">
                <select id="golongan_darah" name="golongan_darah" class="form-control">
                    <option <?php if($gol_darah==""){echo "selected";} ?> value="">Pilih</option>
                    <option <?php if($gol_darah=="A"){echo "selected";} ?> value="A">A</option>
                    <option <?php if($gol_darah=="B"){echo "selected";} ?> value="B">B</option>
                    <option <?php if($gol_darah=="AB"){echo "selected";} ?> value="AB">AB</option>
                    <option <?php if($gol_darah=="O"){echo "selected";} ?> value="O">O</option>
                </select>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="perkawinan"><dt>Status Pernikahan</dt></label>
            </div>
            <div class="col-md-8">
                <select id="perkawinan" name="perkawinan" class="form-control">
                    <option <?php if($perkawinan==""){echo "selected";} ?> value="">Pilih</option>
                    <option <?php if($perkawinan=="Lajang"){echo "selected";} ?> value="Lajang">Lajang</option>
                    <option <?php if($perkawinan=="Menikah"){echo "selected";} ?> value="Menikah">Menikah</option>
                    <option <?php if($perkawinan=="Janda"){echo "selected";} ?> value="Janda">Janda</option>
                    <option <?php if($perkawinan=="Duda"){echo "selected";} ?> value="Duda">Duda</option>
                </select>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="pekerjaan"><dt>Pekerjaan</dt></label>
            </div>
            <div class="col-md-8">
                <select id="pekerjaan" name="pekerjaan" class="form-control">
                    <option <?php if($pekerjaan==""){echo "selected";} ?> value="">Pilih</option>
                    <option <?php if($pekerjaan=="Tidak Bekerja"){echo "selected";} ?> value="Tidak Bekerja">Tidak Bekerja</option>
                    <option <?php if($pekerjaan=="Karyawan Swasta"){echo "selected";} ?> value="Karyawan Swasta">Karyawan Swasta</option>
                    <option <?php if($pekerjaan=="PNS"){echo "selected";} ?> value="PNS">PNS/TNI/Polri</option>
                    <option <?php if($pekerjaan=="Wirausaha"){echo "selected";} ?> value="Wirausaha">Wirausaha</option>
                </select>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="status"><dt>Status Pasien</dt></label>
            </div>
            <div class="col-md-8">
                <select id="status" name="status" class="form-control" required>
                    <option value="">Pilih</option>
                    <option value="Aktiv">Aktiv</option>
                    <option value="Non-Aktiv">Non-Aktiv</option>
                    <option value="Meninggal">Meninggal</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3" id="NotifikasiTambahPasien">
                <span class="text-primary">Pastikan data dan informasi pasien sudah sesuai</span>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-md btn-inverse mt-2 mr-2">
                    <i class=""></i> Simpan
                </button>
                <button type="button" class="btn btn-md btn-light mt-2 mr-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</form>
<?php }}} ?>