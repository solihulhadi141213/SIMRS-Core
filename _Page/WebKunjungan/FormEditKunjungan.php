<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-pencil"></i> Edit Kunjungan Pasien</a>
                    </h5>
                    <p class="m-b-0">Edit Kunjungan Pasien Dari Data Website.</p>
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
                                $id_kunjungan=$_GET['id'];
                                $url=getServiceUrl('Detail Kunjungan');
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
                                            $id_pasien="";
                                        }else{
                                            $id_pasien=$JsonData['response']['id_pasien'];
                                        }
                                        if(empty($JsonData['response']['nomorreferensi'])){
                                            $nomorreferensi="";
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
                                            $no_antrian="";
                                        }else{
                                            $no_antrian=$JsonData['response']['no_antrian'];
                                        }
                                        if(empty($JsonData['response']['kodebooking'])){
                                            $kodebooking="";
                                        }else{
                                            $kodebooking=$JsonData['response']['kodebooking'];
                                        }
                                        if(empty($JsonData['response']['keterangan'])){
                                            $keterangan="";
                                        }else{
                                            $keterangan=$JsonData['response']['keterangan'];
                                        }
                        ?>
                            <div class="card table-card">
                                <form action="javascript:void(0);" id="ProsesEditKunjungan">
                                    <input type="hidden" id="id_kunjungan" name="id_kunjungan" value="<?php echo "$id_kunjungan"; ?>">
                                    <div class="card-header border-info">
                                        <div class="row">
                                            <div class="col-md-8 mb-3">
                                                <dt>Form Tambah Kunjungan</dt>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <a href="index.php?Page=WebKunjungan" class="btn btn-md btn-block btn-secondary">
                                                    <i class="ti ti-angle-left"></i> Kembali
                                                </a>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <a href="index.php?Page=WebKunjungan&Sub=DetailKunjungan&id=<?php echo "$id_kunjungan"; ?>" class="btn btn-md btn-block btn-secondary">
                                                    <i class="ti ti-info-alt"></i> Detail Kunjungan
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
                                                <input type="text" class="form-control" name="nomorreferensi" id="nomorreferensi" value="<?php echo "$nomorreferensi";?>">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="tanggal_daftar">Tanggal Daftar</label>
                                                <input type="date" class="form-control" name="tanggal_daftar" id="tanggal_daftar" value="<?php echo "$tanggal_daftar";?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-md-3 mb-3">
                                                <label for="tanggal_kunjungan">Rencana Kunjungan</label>
                                                <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" class="form-control" value="<?php echo "$tanggal_kunjungan";?>">
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
                                                                    if($kodepoli==$KodePoli){
                                                                        echo '<option selected value="'.$KodePoli.'">'.$NamaPoli.'</option>';
                                                                    }else{
                                                                        echo '<option value="'.$KodePoli.'">'.$NamaPoli.'</option>';
                                                                    }
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
                                                    <?php
                                                        //Tampilkan Kode Dokter Berdasarkan Poliklinik
                                                        $UrlListDokter=getServiceUrl('List Dokter By Kode Poli');
                                                        $KirimData = array(
                                                            'api_key' => $api_key,
                                                            'kode' => $kodepoli
                                                        );
                                                        $Metode ="POST";
                                                        $ResponseDokter =GetResponseApis($UrlListDokter,$KirimData,$Metode);
                                                        $KodeResponse=$ResponseDokter['metadata']['code'];
                                                        $PesanResponse=$ResponseDokter['metadata']['massage'];
                                                        if($KodeResponse==200){
                                                            $JumlahDokter=count($ResponseDokter['response']['list']);
                                                            if(!empty($JumlahDokter)){
                                                                echo '<option value="">Pilih</option>';
                                                                $ListDokter=$ResponseDokter['response']['list'];
                                                                foreach ($ListDokter as $value){
                                                                    $KodeDokter=$value['kode'];
                                                                    $NamaDokter=$value['nama'];
                                                                    if($kode_dokter==$KodeDokter){
                                                                        echo '<option selected value="'.$KodeDokter.'">'.$NamaDokter.'</option>';
                                                                    }else{
                                                                        echo '<option value="'.$KodeDokter.'">'.$NamaDokter.'</option>';
                                                                    }
                                                                }
                                                            }else{
                                                                echo '<option value="">Tidak Ada Dokter</option>';
                                                            }
                                                        }else{
                                                            echo '<option value="">'.$massage.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col col-md-3 mb-3">
                                                <label for="jam_kunjungan">Jam Kunjungan</label>
                                                <select name="jam_kunjungan" id="jam_kunjungan" class="form-control">
                                                    <?php
                                                        //Tampilkan Kode Dokter
                                                        $UrlListJadwal=getServiceUrl('Jadwal Tanggal Dokter');
                                                        $KirimData = array(
                                                            'api_key' => $api_key,
                                                            'kode' => $kode_dokter,
                                                            'tanggal' => $tanggal_kunjungan
                                                        );
                                                        $Metode ="POST";
                                                        $ResponseJadwal =GetResponseApis($UrlListJadwal,$KirimData,$Metode);
                                                        $KodeResponse=$ResponseJadwal['metadata']['code'];
                                                        $PesanResponse=$ResponseJadwal['metadata']['massage'];
                                                        if($KodeResponse==200){
                                                            $JumlahJadwal=count($ResponseJadwal['response']['list']);
                                                            if(!empty($JumlahJadwal)){
                                                                echo '<option value="">Pilih</option>';
                                                                $ListDokter=$ResponseJadwal['response']['list'];
                                                                foreach ($ListDokter as $value){
                                                                    $id_jadwal=$value['id_jadwal'];
                                                                    $hari=$value['hari'];
                                                                    $jam=$value['jam'];
                                                                    if($jam_kunjungan==$jam){
                                                                        echo '<option selected value="'.$jam.'">'.$jam.' ('.$hari.')</option>';
                                                                    }else{
                                                                        echo '<option value="'.$jam.'">'.$jam.' ('.$hari.')</option>';
                                                                    }
                                                                }
                                                            }else{
                                                                echo '<option value="">Tidak Ada Jadwal</option>';
                                                            }
                                                        }else{
                                                            echo '<option value="">'.$massage.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-md-3 mb-3">
                                                <label for="pembayaran">UMUM/BPJS?</label>
                                                <select name="pembayaran" id="pembayaran" class="form-control">
                                                    <option <?php if($pembayaran==""){echo "selected";} ?> value="">Pilih</option>
                                                    <option <?php if($pembayaran=="BPJS"){echo "selected";} ?> value="BPJS">BPJS</option>
                                                    <option <?php if($pembayaran=="UMUM"){echo "selected";} ?> value="UMUM">UMUM</option>
                                                </select>
                                            </div>
                                            <div class="col col-md-3 mb-3">
                                                <label for="status">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option <?php if($status==""){echo "selected";} ?> value="">Pilih</option>
                                                    <option <?php if($status=="Menunggu Verifikasi"){echo "selected";} ?> value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                                                    <option <?php if($status=="Terdaftar"){echo "selected";} ?> value="Terdaftar">Terdaftar</option>
                                                    <option <?php if($status=="Pulang"){echo "selected";} ?> value="Pulang">Pulang</option>
                                                    <option <?php if($status=="Meninggal"){echo "selected";} ?> value="Meninggal">Meninggal</option>
                                                    <option <?php if($status=="Batal"){echo "selected";} ?> value="Batal">Batal</option>
                                                </select>
                                            </div>
                                            <div class="col col-md-3 mb-3">
                                                <label for="no_antrian">No.Antrian</label>
                                                <input type="text" name="no_antrian" id="no_antrian" class="form-control" value="<?php echo "$no_antrian";?>">
                                            </div>
                                            <div class="col col-md-3 mb-3">
                                                <label for="kodebooking">Kode Booking</label>
                                                <input type="text" name="kodebooking" id="kodebooking" class="form-control" value="<?php echo "$kodebooking";?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-md-6 mb-3">
                                                <label for="keluhan">Keluhan Penyakit</label>
                                                <input type="text" name="keluhan" id="keluhan" class="form-control" value="<?php echo "$keluhan";?>">
                                            </div>
                                            <div class="col col-md-6 mb-3">
                                                <label for="keterangan">Keterangan</label>
                                                <input type="text" name="keterangan" id="keterangan" class="form-control" value="<?php echo "$keterangan";?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-md-12 mb-3" id="NotifikasiEditKunjungan">
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