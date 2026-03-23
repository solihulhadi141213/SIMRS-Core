<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    //Menangkap id_kunjungan
    if(empty($_POST['id_kunjungan'])){
        $Valid="Maaf ID Kunjungan Tidak Boleh Kosong!";
    }else{
        $id_kunjungan = $_POST['id_kunjungan'];
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
            $Valid="Terjadi kesalahan koneksi dengan web <br> Keterangan : $err";
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
                $Valid="Terjadi kesalahan menerima data dari web <br> Keterangan : $massage";
            }else{
                $Valid="Valid";
                $id_web_pasien=$JsonData['response']['id_web_pasien'];
                if(empty($JsonData['response']['id_pasien'])){
                    //Melakukan Pencarian id_pasien pada data pasien
                    $urlAksesPasien=getServiceUrl2('Detail Pasien');
                    $ResponseDetailAksesPasien=GetAksesPasien($api_key,$urlAksesPasien,$id_web_pasien);
                    $ResponseDetailAksesPasienDecode =json_decode($ResponseDetailAksesPasien, true);
                    if($ResponseDetailAksesPasienDecode['metadata']['code']!==200){
                        $id_pasien="";
                    }else{
                        if(empty($ResponseDetailAksesPasienDecode['response']['id_pasien'])){
                            $id_pasien="";
                        }else{
                            $id_pasien=$ResponseDetailAksesPasienDecode['response']['id_pasien'];
                        }
                    }
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
                //Buka data pasien
                $urlDetailPasien=getServiceUrl2('Detail Pasien');
                $KirimDataPasien2 = array(
                    'api_key' => $api_key,
                    'id_web_pasien' => $id_web_pasien
                );
                $Metode="POST";
                $ResponsePasien=GetResponseApis($urlDetailPasien,$KirimDataPasien2,$Metode);
                $KodeResponse=$ResponsePasien['metadata']['code'];
                $NamaPasien=$ResponsePasien['response']['nama'];
                $nik=$ResponsePasien['response']['nik'];
                $bpjs=$ResponsePasien['response']['bpjs'];
                $kontak=$ResponsePasien['response']['kontak'];
            }
        }
    }
    if($Valid!=="Valid"){
?>
    <div class="modal-body">
        <div class="row m-t-25 text-center">
            <div class="col-12">
                <h1 class="ti ti-na"></h1>
                <span class="text-danger">
                    <?php echo $Valid;?>
                </span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col col-md col-12 text-center">
                <button type="button" class="btn btn-sm btn-secondary mt-2 mr-2" data-dismiss="modal">
                    <i class="fa fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php }else{ ?>
    
    <form action="javascript:void(0);" id="ProsesAddToAntrian" autocomplete="off">
        <input type="hidden" name="id_kunjungan" id="id_kunjungan" value="<?php echo "$id_kunjungan"; ?>">
        <input type="hidden" name="id_web_pasien" id="id_web_pasien" value="<?php echo "$id_web_pasien"; ?>">
        <input type="hidden" name="tanggal_daftar" id="tanggal_daftar" value="<?php echo "$tanggal_daftar"; ?>">
        <div class="modal-body"> 
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="metode_pembayaran">Pembayaran</label>
                </div>
                <div class="col-md-8">
                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                        <option <?php if($pembayaran==""){echo "selected";} ?> value="">Pilih</option>
                        <option <?php if($pembayaran=="BPJS"){echo "selected";} ?> value="BPJS">BPJS</option>
                        <option <?php if($pembayaran=="UMUM"){echo "selected";} ?> value="UMUM">UMUM</option>
                    </select>
                </div>
            </div> 
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="id_pasien">No.RM</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$id_pasien";?>" required>
                </div>
            </div>  
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="nik">No.KTP (NIK)</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="nik" id="nik" class="form-control" value="<?php echo $nik;?>">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="nomorkartu">No.BPJS</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="nomorkartu" id="nomorkartu" class="form-control" value="<?php echo $bpjs;?>">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="nama">Nama Lengkap</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="nama" id="nama" class="form-control" value="<?php echo "$NamaPasien";?>" required>
                    <small id="NotifikasiPasien">Nama lengkap pasien</small>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="notelp">No.Kontak</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="notelp" id="notelp" class="form-control" value="<?php echo $kontak;?>">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="notelp">Poliklinik</label>
                </div>
                <div class="col-md-8">
                    <select name="poliklinik" id="poliklinik" class="form-control">
                        <option value="">Pilih</option>
                        <?php 
                            //select option poliklinik
                            $SqlPoliklinik = "SELECT * FROM poliklinik";
                            $ResultPoliklinik = mysqli_query($Conn, $SqlPoliklinik);
                            while($DataPoliklinik = mysqli_fetch_assoc($ResultPoliklinik)){
                                $id_poliklinik=$DataPoliklinik['id_poliklinik'];
                                $KodePoliklinik=$DataPoliklinik['kode'];
                                $NamaPoliklinik=$DataPoliklinik['nama'];
                                if($kodepoli==$KodePoliklinik){
                                    echo "<option selected value='$id_poliklinik'>$NamaPoliklinik</option>";
                                }else{
                                    echo "<option value='$id_poliklinik'>$NamaPoliklinik</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="dokter">Dokter</label>
                </div>
                <div class="col-md-8">
                    <select name="dokter" id="dokter" class="form-control">
                        <?php 
                            //select option poliklinik
                            $SqlDokter = "SELECT * FROM dokter";
                            $ResultDokter = mysqli_query($Conn, $SqlDokter);
                            while($DataDokter = mysqli_fetch_assoc($ResultDokter)){
                                $id_dokter=$DataDokter['id_dokter'];
                                $KodeDokter=$DataDokter['kode'];
                                $NamaDokter=$DataDokter['nama'];
                                if($kode_dokter==$KodeDokter){
                                    echo "<option selected value='$id_dokter'>$NamaDokter</option>";
                                }else{
                                    echo "<option value='$id_dokter'>$NamaDokter</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="tanggal1">Tgl.Kunjungan</label>
                </div>
                <div class="col-md-8">
                    <input type="date" name="tanggal1" id="tanggal1" class="form-control" value="<?php echo $tanggal_kunjungan;?>">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="jam">Jam Kunjungan</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="jam" id="jam" class="form-control" value="<?php echo $jam_kunjungan;?>">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="keluhan">Keluhan</label>
                </div>
                <div class="col-md-8">
                    <input type="keluhan" name="keluhan" id="keluhan" class="form-control" value="<?php echo $keluhan;?>">
                    <small>Keluhan/Tujuan Kunjungan</small>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="jeniskunjungan">Jenis Kunjungan</label>
                </div>
                <div class="col-md-8">
                    <select name="jeniskunjungan" id="jeniskunjungan" class="form-control">
                        <option value="">Pilih</option>
                        <option value="1">Rujukan FKTP</option>
                        <option value="2">Rujukan Internal</option>
                        <option value="3">Kontrol</option>
                        <option value="4">Rujukan Antar RS</option>
                    </select>
                    <small>Untuk pasien BPJS harus diisi</small>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="nomorreferensi">No.Referensi</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="nomorreferensi" id="nomorreferensi" class="form-control" value="<?php echo $nomorreferensi;?>">
                    <small>Untuk pasien BPJS harus diisi</small>
                </div>
            </div>
            <div class="row m-t-25 text-left">
                <div class="col-12" id="NotifikasiAddToAntrian">
                    <span class="text-info">Pastikan data pendaftaran antrian yang anda masukan sudah benar.</span>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-danger">
            <div class="row">
                <div class="col col-md col-12 text-center">
                    <button type="submit" class="btn btn-md btn-primary mt-2 mr-2">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn-secondary mt-2 mr-2" data-dismiss="modal">
                        <i class="fa fa-times"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </form>
<?php } ?>