<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-pencil"></i> Form Edit Akun Pasien</a>
                    </h5>
                    <p class="m-b-0">Edit akun akses pasien pada website.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <form action="javascript:void(0);" id="ProsesEditPasien">
                            <?php
                                if(empty($_GET['id'])){
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-12">';
                                    echo '      <span class="text-danger">ID Tidak Boleh Kosong!</span>';
                                    echo '  </div>';
                                    echo '</div>';
                                }else{
                                    include "_Config/SettingKoneksiWeb.php";
                                    include "_Config/WebFunction.php";
                                    $id_web_pasien=$_GET['id'];
                                    $url=getServiceUrl('Detail Pasien');
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
                                            $tanggal_daftar=$JsonData['response']['tanggal_daftar'];
                                            if(empty($JsonData['response']['id_pasien'])){
                                                $id_pasien="";
                                            }else{
                                                $id_pasien=$JsonData['response']['id_pasien'];
                                            }
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
                                            $password=$JsonData['response']['password'];
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
                            ?>
                                <input type="hidden" name="id_web_pasien" id="id_web_pasien" value="<?php echo "$id_web_pasien"; ?>">
                                <input type="hidden" name="password2" id="password2" value="<?php echo "$password"; ?>">
                                <div class="card table-card">
                                    <div class="card-header border-info">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <dt>Form Tambah Akun Akses Pasien</dt>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="index.php?Page=WebAksesPasien" class="btn btn-sm btn-block btn-secondary">
                                                    <i class="ti ti-angle-left"></i> Kembali
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label for="id_pasien">No.RM</label>
                                                <input type="text" name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$id_pasien"; ?>">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="nik">NIK</label>
                                                <input type="text" name="nik" id="nik" class="form-control" value="<?php echo "$nik"; ?>">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="bpjs">No.BPJS</label>
                                                <input type="text" name="bpjs" id="bpjs" class="form-control" value="<?php echo "$bpjs"; ?>">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="tanggal_daftar">Tanggal Daftar</label>
                                                <input type="date" name="tanggal_daftar" id="tanggal_daftar" class="form-control" value="<?php echo "$tanggal_daftar"; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label for="nama">Nama Lengkap</label>
                                                <input type="text" name="nama" id="nama" class="form-control" value="<?php echo "$nama"; ?>">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="kontak">Kontak</label>
                                                <input type="text" name="kontak" id="kontak" class="form-control" value="<?php echo "$kontak"; ?>">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" id="email" class="form-control" value="<?php echo "$email"; ?>">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="password">Password</label>
                                                <input type="password" name="password" id="password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label for="propinsi"><dt>Propinsi</dt></label>
                                                <select id="propinsi" name="propinsi" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <?php
                                                        //Arraykan propinsi
                                                        $QryPropinsi = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Propinsi' ORDER BY propinsi ASC");
                                                        while ($DataPropinsi = mysqli_fetch_array($QryPropinsi)) {
                                                            $ListPropinsi= $DataPropinsi['propinsi'];
                                                            if($ListPropinsi==$propinsi){
                                                                echo '<option selected value="'.$ListPropinsi.'">'.$ListPropinsi.'</option>';
                                                            }else{
                                                                echo '<option value="'.$ListPropinsi.'">'.$ListPropinsi.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="kabupaten"><dt>Kabupaten/Kota</dt></label>
                                                <select id="kabupaten" name="kabupaten" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <?php
                                                        //Arraykan Kabupaten
                                                        $QryKabupaten = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Kabupaten' AND propinsi='$propinsi' ORDER BY kabupaten ASC");
                                                        while ($DataKabupaten = mysqli_fetch_array($QryKabupaten)) {
                                                            $KabupatenList= $DataKabupaten['kabupaten'];
                                                            if($kabupaten==$KabupatenList){
                                                                echo '<option selected value="'.$KabupatenList.'">'.$KabupatenList.'</option>';
                                                            }else{
                                                                echo '<option value="'.$KabupatenList.'">'.$KabupatenList.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="kecamatan"><dt>Kecamatan</dt></label>
                                                <select id="kecamatan" name="kecamatan" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <?php
                                                        //Arraykan Kecamatan
                                                        $QryKecamatan = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Kecamatan' AND propinsi='$propinsi' AND kabupaten='$kabupaten' ORDER BY kecamatan ASC");
                                                        while ($DataKecamatan = mysqli_fetch_array($QryKecamatan)) {
                                                            $KecamatanList= $DataKecamatan['kecamatan'];
                                                            if($kecamatan==$KecamatanList){
                                                                echo '<option selected value="'.$KecamatanList.'">'.$KecamatanList.'</option>';
                                                            }else{
                                                                echo '<option value="'.$KecamatanList.'">'.$KecamatanList.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="desa"><dt>Desa/Kelurahan</dt></label>
                                                <select id="desa" name="desa" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <?php
                                                        //Arraykan Desa
                                                        $QryDesa = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='desa' AND propinsi='$propinsi' AND kabupaten='$kabupaten' AND kecamatan='$kecamatan' ORDER BY desa ASC");
                                                        while ($DataDesa = mysqli_fetch_array($QryDesa)) {
                                                            $DesaList= $DataDesa['desa'];
                                                            if($DesaList==$desa){
                                                                echo '<option selected value="'.$DesaList.'">'.$DesaList.'</option>';
                                                            }else{
                                                                echo '<option value="'.$DesaList.'">'.$DesaList.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="alamat">Alamat Selengkapnya</label>
                                                <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo "$alamat"; ?>">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="tepat_lahir">Tempat Lahir</label>
                                                <input type="text" name="tepat_lahir" id="tepat_lahir" class="form-control" value="<?php echo "$tepat_lahir"; ?>">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="<?php echo "$tanggal_lahir"; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label for="gol_darah">Golongan Darah</label>
                                                <select id="gol_darah" name="gol_darah" class="form-control">
                                                    <option <?php if($gol_darah==""){echo "selected";} ?> value="">Pilih</option>
                                                    <option <?php if($gol_darah=="A"){echo "selected";} ?> value="A">A</option>
                                                    <option <?php if($gol_darah=="B"){echo "selected";} ?> value="B">B</option>
                                                    <option <?php if($gol_darah=="AB"){echo "selected";} ?> value="AB">AB</option>
                                                    <option <?php if($gol_darah=="O"){echo "selected";} ?> value="O">O</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="sex">Jenis Kelamin</label>
                                                <select id="sex" name="sex" class="form-control" required>
                                                    <option <?php if($sex==""){echo "selected";} ?> value="">Pilih</option>
                                                    <option <?php if($sex=="Laki-laki"){echo "selected";} ?> value="Laki-laki">Laki-laki</option>
                                                    <option <?php if($sex=="Perempuan"){echo "selected";} ?> value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="pekerjaan">Pekerjaan</label>
                                                <select id="pekerjaan" name="pekerjaan" class="form-control">
                                                    <option <?php if($pekerjaan==""){echo "selected";} ?> value="">Pilih</option>
                                                    <option <?php if($pekerjaan=="Tidak Bekerja"){echo "selected";} ?> value="Tidak Bekerja">Tidak Bekerja</option>
                                                    <option <?php if($pekerjaan=="Karyawan Swasta"){echo "selected";} ?> value="Karyawan Swasta">Karyawan Swasta</option>
                                                    <option <?php if($pekerjaan=="PNS"){echo "selected";} ?> value="PNS">PNS/TNI/Polri</option>
                                                    <option <?php if($pekerjaan=="Wirausaha"){echo "selected";} ?> value="Wirausaha">Wirausaha</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="perkawinan">Status Perkawinan</label>
                                                <select id="perkawinan" name="perkawinan" class="form-control">
                                                    <option <?php if($perkawinan==""){echo "selected";} ?> value="">Pilih</option>
                                                    <option <?php if($perkawinan=="Lajang"){echo "selected";} ?> value="Lajang">Lajang</option>
                                                    <option <?php if($perkawinan=="Menikah"){echo "selected";} ?> value="Menikah">Menikah</option>
                                                    <option <?php if($perkawinan=="Janda"){echo "selected";} ?> value="Janda">Janda</option>
                                                    <option <?php if($perkawinan=="Duda"){echo "selected";} ?> value="Duda">Duda</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label for="status">Status Akun</label>
                                                <select id="status" name="status" class="form-control">
                                                    <option <?php if($status==""){echo "selected";} ?> value="">Pilih</option>
                                                    <option <?php if($status=="Active"){echo "selected";} ?> value="Active">Active</option>
                                                    <option <?php if($status=="Pending"){echo "selected";} ?> value="Pending">Pending</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="token">Token</label>
                                                <input type="text" name="token" id="token" class="form-control" value="<?php echo "$token"; ?>">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="foto_profile">Foto</label>
                                                <input type="file" name="foto_profile" id="foto_profile" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-md-12 mb-3">
                                                <span class="text-primary" id="NotifikasiEditPasien">Pastikan semua data Artikel sudah terisi dengan benar</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-md btn-primary">
                                            <i class="ti ti-save"></i> Simpan
                                        </button>
                                    </div>
                                </div>
                            <?php 
                                        }
                                    }
                                }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>