<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-plus"></i> Tambah Kunjungan Pasien</a>
                    </h5>
                    <p class="m-b-0">Tambah Kunjungan Pasien Dari Data Website.</p>
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
                            <div class="card table-card">
                                <form action="javascript:void(0);" id="ProsesTambahKunjungan">
                                    <div class="card-header border-info">
                                        <div class="row">
                                            <div class="col-md-10 mb-3">
                                                <h4>Form Tambah Kunjungan</h4>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <a href="index.php?Page=WebKunjungan" class="btn btn-md btn-block btn-secondary">
                                                    <i class="ti ti-angle-left"></i> Kembali
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label for="id_web_pasien">No.RM Web</label>
                                                <input type="text" readonly class="form-control" name="id_web_pasien" id="id_web_pasien" value="<?php echo "$id_web_pasien";?>">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="id_pasien">No.RM SIMRS</label>
                                                <input type="text" readonly class="form-control" name="id_pasien" id="id_pasien" value="<?php echo "$id_pasien";?>">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="nomorreferensi">No.Referensi</label>
                                                <input type="text" class="form-control" name="nomorreferensi" id="nomorreferensi">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="tanggal_daftar">Tanggal Daftar</label>
                                                <input type="date" class="form-control" name="tanggal_daftar" id="tanggal_daftar" value="<?php echo date('Y-m-d') ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-md-3 mb-3">
                                                <label for="tanggal_kunjungan">Rencana Kunjungan</label>
                                                <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" class="form-control">
                                            </div>
                                            <div class="col col-md-3 mb-3">
                                                <label for="kodepoli">Poliklinik</label>
                                                <select name="kodepoli" id="kodepoli" class="form-control">
                                                    <?php
                                                        //Tampilkan Poliklinik
                                                        $UrlListPoli=getServiceUrl('List Poliklinik');
                                                        $KirimData = array(
                                                            'api_key' => $api_key,
                                                            'page' => "1",
                                                            'limit' => "100",
                                                            'short_by' => "DESC",
                                                            'order_by' => "nama",
                                                            'keyword_by' => "status",
                                                            'keyword' => "Aktif",
                                                        );
                                                        $Metode ="POST";
                                                        $ResponsePoli =GetResponseApis($UrlListPoli,$KirimData,$Metode);
                                                        $KodeResponse=$ResponsePoli['metadata']['code'];
                                                        $PesanResponse=$ResponsePoli['metadata']['massage'];
                                                        if($KodeResponse==200){
                                                            $JumlahPoli=count($ResponsePoli['response']['list']);
                                                            if(!empty($JumlahPoli)){
                                                                echo '<option value="">Pilih</option>';
                                                                $ListPoli=$ResponsePoli['response']['list'];
                                                                foreach ($ListPoli as $value){
                                                                    $KodePoli=$value['kode'];
                                                                    $NamaPoli=$value['nama'];
                                                                    echo '<option value="'.$KodePoli.'">'.$NamaPoli.'</option>';
                                                                }
                                                            }
                                                        }else{
                                                            echo '<option value="">'.$massage.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col col-md-3 mb-3">
                                                <label for="kode_dokter">Dokter</label>
                                                <select name="kode_dokter" id="kode_dokter" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <?php
                                                        //Tampilkan Kode Dokter
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col col-md-3 mb-3">
                                                <label for="jam_kunjungan">Jam Kunjungan</label>
                                                <select name="jam_kunjungan" id="jam_kunjungan" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <?php
                                                        //Tampilkan Kode Dokter
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-md-3 mb-3">
                                                <label for="pembayaran">UMUM/BPJS?</label>
                                                <select name="pembayaran" id="pembayaran" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <option value="BPJS">BPJS</option>
                                                    <option value="UMUM">UMUM</option>
                                                </select>
                                            </div>
                                            <div class="col col-md-3 mb-3">
                                                <label for="status">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                                                    <option value="Terdaftar">Terdaftar</option>
                                                    <option value="Pulang">Pulang</option>
                                                    <option value="Meninggal">Meninggal</option>
                                                    <option value="Batal">Batal</option>
                                                </select>
                                            </div>
                                            <div class="col col-md-3 mb-3">
                                                <label for="no_antrian">No.Antrian</label>
                                                <input type="text" name="no_antrian" id="no_antrian" class="form-control">
                                            </div>
                                            <div class="col col-md-3 mb-3">
                                                <label for="kodebooking">Kode Booking</label>
                                                <input type="text" name="kodebooking" id="kodebooking" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-md-6 mb-3">
                                                <label for="keluhan">Keluhan Penyakit</label>
                                                <input type="text" name="keluhan" id="keluhan" class="form-control">
                                            </div>
                                            <div class="col col-md-6 mb-3">
                                                <label for="keterangan">Keterangan</label>
                                                <input type="text" name="keterangan" id="keterangan" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-md-12 mb-3" id="NotifikasiTambahKunjungan">
                                                <span class="text-primary">Pastikan Form Kunjungan Terisi Dengan Benar</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <button type="submit" class="btn btn-md btn-success">
                                                    <i class="ti ti-save"></i> Simpan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php 
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>