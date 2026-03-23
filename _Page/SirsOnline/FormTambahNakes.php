<?php
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //Jika Ada sumber Data
    if(!empty($_POST['sumber_data'])){
        $sumber_data=$_POST['sumber_data'];
        //Explode
        $DataSumber= explode("-", $sumber_data);
        $SumberData=$DataSumber['0'];
        $NilaiSumberData=$DataSumber['1'];
        if($SumberData=="id_practitioner"){
            $id_practitioner=$NilaiSumberData;
            $nik=getDataDetail($Conn,'referensi_practitioner','id_practitioner',$id_practitioner,'nik');
            $nama=getDataDetail($Conn,'referensi_practitioner','id_practitioner',$id_practitioner,'nama');
            $id_ihs_practitioner=getDataDetail($Conn,'referensi_practitioner','id_practitioner',$id_practitioner,'id_ihs_practitioner');
            //Cari Kode Dari id_ihs_practitioner
            $kode=getDataDetail($Conn,'dokter','id_ihs_practitioner',$id_ihs_practitioner,'kode');
            if(empty($kode)){
                //Cari Kode Dari nik
                $kode=getDataDetail($Conn,'dokter','no_identitas',$nik,'kode');
            }
        }else{
            if($SumberData=="id_dokter"){
                $id_dokter=$NilaiSumberData;
                $kode=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'kode');
                $nik=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'no_identitas');
                $nama=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'nama');
                $id_ihs_practitioner=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'id_ihs_practitioner');
                if(empty($id_ihs_practitioner)){
                    $id_ihs_practitioner=getDataDetail($Conn,'referensi_practitioner','nik',$nik,'id_ihs_practitioner');
                }
            }else{
                $id_practitioner="";
                $nik="";
                $nama="";
                $id_ihs_practitioner="";
                $kode="";
            }
        }
    }else{
        $id_practitioner="";
        $nik="";
        $nama="";
        $id_ihs_practitioner="";
        $kode="";
    }
?>
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
        <input type="text" name="ihs" id="ihs" class="form-control" value="<?php echo "$id_ihs_practitioner"; ?>">
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
            <option value="">Pilih</option>
            <option value="Co Ass">Co Ass</option>
            <option value="Residen">Residen</option>
            <option value="Intership">Intership</option>
            <option value="Dokter Spesialis">Dokter Spesialis</option>
            <option value="Dokter Umum">Dokter Umum</option>
            <option value="Dokter Gigi">Dokter Gigi</option>
            <option value="Perawat">Perawat</option>
            <option value="Bidan">Bidan</option>
            <option value="Apoteker">Apoteker</option>
            <option value="Radiografer">Radiografer</option>
            <option value="Analis Lab">Analis Lab</option>
            <option value="Nakes Lainnya">Nakes Lainnya</option>
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
                        echo '<option value="'.$kebutuhan.'">';
                        echo '  '.$kebutuhan.'';
                        echo '</option>';
                        $no++;
                    }
                }
            ?>
        </select>
    </div>
</div>