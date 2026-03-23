<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    if(empty($_POST['id_nakes'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
        echo '      ID Nakes Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_nakes=$_POST['id_nakes'];
        $ihs=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'ihs');
        $nik=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'nik');
        $kode=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'kode');
        $nama=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'nama');
        $kategori=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'kategori');
        $referensi_sdm=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'referensi_sdm');
        $id_akses=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'id_akses');
        //Detail Petugas
        $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
?>
    <input type="hidden" name="id_nakes" id="id_nakes" class="form-control" value="<?php echo "$id_nakes"; ?>">
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="nama">Nama Lengkap</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="nama" id="nama" class="form-control" value="<?php echo "$nama"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="nik">NIK</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="nik" id="nik" class="form-control" value="<?php echo "$nik"; ?>">
            <small>* Jika Ada (Untuk Menghubungkan Dengan Satu Sehat)</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="ihs">ID Practitioner</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="ihs" id="ihs" class="form-control" value="<?php echo "$ihs"; ?>">
            <small>* Jika Ada (Untuk Menghubungkan Dengan Satu Sehat)</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="kode">Kode Dokter</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="kode" id="kode" class="form-control" value="<?php echo "$kode"; ?>">
            <small>* Dari Referensi Dokter SIMRS</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="kategori">Kategori Nakes</label>
        </div>
        <div class="col-md-8">
            <select name="kategori" id="kategori" class="form-control">
                <option <?php if($kategori==""){echo "selected";} ?> value="">Pilih</option>
                <option <?php if($kategori=="Co Ass"){echo "selected";} ?> value="Co Ass">Co Ass</option>
                <option <?php if($kategori=="Residen"){echo "selected";} ?> value="Residen">Residen</option>
                <option <?php if($kategori=="Intership"){echo "selected";} ?> value="Intership">Intership</option>
                <option <?php if($kategori=="Dokter Spesialis"){echo "selected";} ?> value="Dokter Spesialis">Dokter Spesialis</option>
                <option <?php if($kategori=="Dokter Umum"){echo "selected";} ?> value="Dokter Umum">Dokter Umum</option>
                <option <?php if($kategori=="Dokter Gigi"){echo "selected";} ?> value="Dokter Gigi">Dokter Gigi</option>
                <option <?php if($kategori=="Perawat"){echo "selected";} ?> value="Perawat">Perawat</option>
                <option <?php if($kategori=="Bidan"){echo "selected";} ?> value="Bidan">Bidan</option>
                <option <?php if($kategori=="Apoteker"){echo "selected";} ?> value="Apoteker">Apoteker</option>
                <option <?php if($kategori=="Radiografer"){echo "selected";} ?> value="Radiografer">Radiografer</option>
                <option <?php if($kategori=="Analis Lab"){echo "selected";} ?> value="Analis Lab">Analis Lab</option>
                <option <?php if($kategori=="Nakes Lainnya"){echo "selected";} ?> value="Nakes Lainnya">Nakes Lainnya</option>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="referensi_sdm">Referensi SDM</label>
        </div>
        <div class="col-md-8">
            <select name="referensi_sdm" id="referensi_sdm" class="form-control">
                <option value="">Pilih</option>
                <?php
                    $response_referensi=ReferensiSdmSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'GET');
                    $php_array = json_decode($response_referensi, true);
                    $ReferensiSdmSirsOnline=$php_array['kebutuhan_sdm'];
                    $JumlahData=count($ReferensiSdmSirsOnline);
                    if(!empty($JumlahData)){
                        $no=1;
                        foreach ($ReferensiSdmSirsOnline as $item) {
                            // Tambahkan setiap elemen ke dalam array PHP
                            $id_kebutuhan= $item['id_kebutuhan'];
                            $kebutuhan= $item['kebutuhan'];
                            if($kebutuhan=="$referensi_sdm"){
                                echo '<option selected value="'.$kebutuhan.'">';
                                echo '  '.$kebutuhan.'';
                                echo '</option>';
                            }else{
                                echo '<option value="'.$kebutuhan.'">';
                                echo '  '.$kebutuhan.'';
                                echo '</option>';
                            }
                        }
                    }
                ?>
            </select>
        </div>
    </div>
<?php } ?>