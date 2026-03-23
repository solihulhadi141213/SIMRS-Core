<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    $tgllapor=date('Y-m-d H:i:s');
    if(empty($_POST['tanggal'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
        echo '      Tanggal Laporan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $tanggal=$_POST['tanggal'];
        //Buka Pengaturan SIRS Online
        $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
        $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
        $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
        //Request Data
        $response=DataPcrNakes($x_id_rs,$password_sirs_online,$url_sirs_online,'GET',$tanggal);
        $php_array = json_decode($response, true);
        if(!empty($php_array['PCRNakes'])){
            $DataPcrNakes=$php_array['PCRNakes'];
            $JumlahData=count($DataPcrNakes);
        }else{
            $DataPcrNakes="";
            $JumlahData=0;
        }
        foreach ($DataPcrNakes as $array_data) {
            //Buka data json
            $tanggal = $array_data['tanggal'];
            $jumlah_tenaga_dokter_umum = $array_data['jumlah_tenaga_dokter_umum'];
            $sudah_periksa_dokter_umum = $array_data['sudah_periksa_dokter_umum'];
            $hasil_pcr_dokter_umum = $array_data['hasil_pcr_dokter_umum'];
            $jumlah_tenaga_dokter_spesialis = $array_data['jumlah_tenaga_dokter_spesialis'];
            $sudah_periksa_dokter_spesialis = $array_data['sudah_periksa_dokter_spesialis'];
            $hasil_pcr_dokter_spesialis = $array_data['hasil_pcr_dokter_spesialis'];
            $jumlah_tenaga_dokter_gigi = $array_data['jumlah_tenaga_dokter_gigi'];
            $sudah_periksa_dokter_gigi = $array_data['sudah_periksa_dokter_gigi'];
            $hasil_pcr_dokter_gigi = $array_data['hasil_pcr_dokter_gigi'];
            $jumlah_tenaga_residen = $array_data['jumlah_tenaga_residen'];
            $sudah_periksa_residen = $array_data['sudah_periksa_residen'];
            $hasil_pcr_residen = $array_data['hasil_pcr_residen'];
            $jumlah_tenaga_perawat = $array_data['jumlah_tenaga_perawat'];
            $sudah_periksa_perawat = $array_data['sudah_periksa_perawat'];
            $hasil_pcr_perawat = $array_data['hasil_pcr_perawat'];
            $jumlah_tenaga_bidan = $array_data['jumlah_tenaga_bidan'];
            $sudah_periksa_bidan = $array_data['sudah_periksa_bidan'];
            $hasil_pcr_bidan = $array_data['hasil_pcr_bidan'];
            $jumlah_tenaga_apoteker = $array_data['jumlah_tenaga_apoteker'];
            $sudah_periksa_apoteker = $array_data['sudah_periksa_apoteker'];
            $hasil_pcr_apoteker = $array_data['hasil_pcr_apoteker'];
            $jumlah_tenaga_radiografer = $array_data['jumlah_tenaga_radiografer'];
            $sudah_periksa_radiografer = $array_data['sudah_periksa_radiografer'];
            $hasil_pcr_radiografer = $array_data['hasil_pcr_radiografer'];
            $jumlah_tenaga_analis_lab = $array_data['jumlah_tenaga_analis_lab'];
            $sudah_periksa_analis_lab = $array_data['sudah_periksa_analis_lab'];
            $hasil_pcr_analis_lab = $array_data['hasil_pcr_analis_lab'];
            $jumlah_tenaga_co_ass = $array_data['jumlah_tenaga_co_ass'];
            $sudah_periksa_co_ass = $array_data['sudah_periksa_co_ass'];
            $hasil_pcr_co_ass = $array_data['hasil_pcr_co_ass'];
            $jumlah_tenaga_internship = $array_data['jumlah_tenaga_internship'];
            $sudah_periksa_internship = $array_data['sudah_periksa_internship'];
            $hasil_pcr_internship = $array_data['hasil_pcr_internship'];
            $jumlah_tenaga_nakes_lainnya = $array_data['jumlah_tenaga_nakes_lainnya'];
            $sudah_periksa_nakes_lainnya = $array_data['sudah_periksa_nakes_lainnya'];
            $hasil_pcr_nakes_lainnya = $array_data['hasil_pcr_nakes_lainnya'];
            $rekap_jumlah_tenaga = $array_data['rekap_jumlah_tenaga'];
            $rekap_jumlah_sudah_diperiksa = $array_data['rekap_jumlah_sudah_diperiksa'];
            $rekap_jumlah_hasil_pcr = $array_data['rekap_jumlah_hasil_pcr'];
            $tgllapor = $array_data['tgllapor'];
?>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="tanggal_laporan">Tanggal</label>
        </div>
        <div class="col-md-8">
            <input type="date" name="tanggal_laporan" id="tanggal_laporan" class="form-control" value="<?php echo $tanggal; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <dt>Dokter Umum</dt>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jumlah_tenaga_dokter_umum">Jumlah</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="jumlah_tenaga_dokter_umum" id="jumlah_tenaga_dokter_umum" class="form-control" value="<?php echo $jumlah_tenaga_dokter_umum; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="sudah_periksa_dokter_umum">Diperiksa</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="sudah_periksa_dokter_umum" id="sudah_periksa_dokter_umum" class="form-control" value="<?php echo $sudah_periksa_dokter_umum; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="hasil_pcr_dokter_umum">Hasil PCR</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="hasil_pcr_dokter_umum" id="hasil_pcr_dokter_umum" class="form-control" value="<?php echo $hasil_pcr_dokter_umum; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <dt>Dokter Spesialis</dt>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jumlah_tenaga_dokter_spesialis">Jumlah</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="jumlah_tenaga_dokter_spesialis" id="jumlah_tenaga_dokter_spesialis" class="form-control" value="<?php echo $jumlah_tenaga_dokter_spesialis; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="sudah_periksa_dokter_spesialis">Diperiksa</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="sudah_periksa_dokter_spesialis" id="sudah_periksa_dokter_spesialis" class="form-control" value="<?php echo $sudah_periksa_dokter_spesialis; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="hasil_pcr_dokter_spesialis">Hasil PCR</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="hasil_pcr_dokter_spesialis" id="hasil_pcr_dokter_spesialis" class="form-control" value="<?php echo $hasil_pcr_dokter_spesialis; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <dt>Dokter Gigi</dt>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jumlah_tenaga_dokter_gigi">Jumlah</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="jumlah_tenaga_dokter_gigi" id="jumlah_tenaga_dokter_gigi" class="form-control" value="<?php echo $jumlah_tenaga_dokter_gigi; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="sudah_periksa_dokter_gigi">Diperiksa</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="sudah_periksa_dokter_gigi" id="sudah_periksa_dokter_gigi" class="form-control" value="<?php echo $sudah_periksa_dokter_gigi; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="hasil_pcr_dokter_gigi">Hasil PCR</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="hasil_pcr_dokter_gigi" id="hasil_pcr_dokter_gigi" class="form-control" value="<?php echo $hasil_pcr_dokter_gigi; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <dt>Tenaga Residen</dt>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jumlah_tenaga_residen">Jumlah</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="jumlah_tenaga_residen" id="jumlah_tenaga_residen" class="form-control" value="<?php echo $jumlah_tenaga_residen; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="sudah_periksa_residen">Diperiksa</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="sudah_periksa_residen" id="sudah_periksa_residen" class="form-control" value="<?php echo $sudah_periksa_residen; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="hasil_pcr_residen">Hasil PCR</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="hasil_pcr_residen" id="hasil_pcr_residen" class="form-control" value="<?php echo $hasil_pcr_residen; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <dt>Tenaga Perawat</dt>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jumlah_tenaga_perawat">Jumlah</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="jumlah_tenaga_perawat" id="jumlah_tenaga_perawat" class="form-control" value="<?php echo $jumlah_tenaga_perawat; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="sudah_periksa_perawat">Diperiksa</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="sudah_periksa_perawat" id="sudah_periksa_perawat" class="form-control" value="<?php echo $sudah_periksa_perawat; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="hasil_pcr_perawat">Hasil PCR</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="hasil_pcr_perawat" id="hasil_pcr_perawat" class="form-control" value="<?php echo $hasil_pcr_perawat; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <dt>Bidan</dt>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jumlah_tenaga_bidan">Jumlah</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="jumlah_tenaga_bidan" id="jumlah_tenaga_bidan" class="form-control" value="<?php echo $jumlah_tenaga_bidan; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="sudah_periksa_bidan">Diperiksa</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="sudah_periksa_bidan" id="sudah_periksa_bidan" class="form-control" value="<?php echo $sudah_periksa_bidan; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="hasil_pcr_bidan">Hasil PCR</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="hasil_pcr_bidan" id="hasil_pcr_bidan" class="form-control" value="<?php echo $hasil_pcr_bidan; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <dt>Apoteker</dt>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jumlah_tenaga_apoteker">Jumlah</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="jumlah_tenaga_apoteker" id="jumlah_tenaga_apoteker" class="form-control" value="<?php echo $jumlah_tenaga_apoteker; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="sudah_periksa_apoteker">Diperiksa</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="sudah_periksa_apoteker" id="sudah_periksa_apoteker" class="form-control" value="<?php echo $sudah_periksa_apoteker; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="hasil_pcr_apoteker">Hasil PCR</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="hasil_pcr_apoteker" id="hasil_pcr_apoteker" class="form-control" value="<?php echo $hasil_pcr_apoteker; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <dt>Radiografer</dt>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jumlah_tenaga_radiografer">Jumlah</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="jumlah_tenaga_radiografer" id="jumlah_tenaga_radiografer" class="form-control" value="<?php echo $jumlah_tenaga_radiografer; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="sudah_periksa_radiografer">Diperiksa</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="sudah_periksa_radiografer" id="sudah_periksa_radiografer" class="form-control" value="<?php echo $sudah_periksa_radiografer; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="hasil_pcr_radiografer">Hasil PCR</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="hasil_pcr_radiografer" id="hasil_pcr_radiografer" class="form-control" value="<?php echo $hasil_pcr_radiografer; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <dt>Analis Lab</dt>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jumlah_tenaga_analis_lab">Jumlah</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="jumlah_tenaga_analis_lab" id="jumlah_tenaga_analis_lab" class="form-control" value="<?php echo $jumlah_tenaga_analis_lab; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="sudah_periksa_analis_lab">Diperiksa</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="sudah_periksa_analis_lab" id="sudah_periksa_analis_lab" class="form-control" value="<?php echo $sudah_periksa_analis_lab; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="hasil_pcr_analis_lab">Hasil PCR</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="hasil_pcr_analis_lab" id="hasil_pcr_analis_lab" class="form-control" value="<?php echo $hasil_pcr_analis_lab; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <dt>Co Ass</dt>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jumlah_tenaga_co_ass">Jumlah</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="jumlah_tenaga_co_ass" id="jumlah_tenaga_co_ass" class="form-control" value="<?php echo $jumlah_tenaga_co_ass; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="sudah_periksa_co_ass">Diperiksa</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="sudah_periksa_co_ass" id="sudah_periksa_co_ass" class="form-control" value="<?php echo $sudah_periksa_co_ass; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="hasil_pcr_co_ass">Hasil PCR</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="hasil_pcr_co_ass" id="hasil_pcr_co_ass" class="form-control" value="<?php echo $hasil_pcr_co_ass; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <dt>Tenaga Interenship</dt>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jumlah_tenaga_internship">Jumlah</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="jumlah_tenaga_internship" id="jumlah_tenaga_internship" class="form-control" value="<?php echo $jumlah_tenaga_internship; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="sudah_periksa_internship">Diperiksa</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="sudah_periksa_internship" id="sudah_periksa_internship" class="form-control" value="<?php echo $sudah_periksa_internship; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="hasil_pcr_internship">Hasil PCR</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="hasil_pcr_internship" id="hasil_pcr_internship" class="form-control" value="<?php echo $hasil_pcr_internship; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <dt>Tenaga Lainnya</dt>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jumlah_tenaga_nakes_lainnya">Jumlah</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="jumlah_tenaga_nakes_lainnya" id="jumlah_tenaga_nakes_lainnya" class="form-control" value="<?php echo $jumlah_tenaga_nakes_lainnya; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="sudah_periksa_nakes_lainnya">Diperiksa</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="sudah_periksa_nakes_lainnya" id="sudah_periksa_nakes_lainnya" class="form-control" value="<?php echo $sudah_periksa_nakes_lainnya; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="hasil_pcr_nakes_lainnya">Hasil PCR</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="hasil_pcr_nakes_lainnya" id="hasil_pcr_nakes_lainnya" class="form-control" value="<?php echo $hasil_pcr_nakes_lainnya; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <dt>Rekapitulasi</dt>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="rekap_jumlah_tenaga">Jumlah Tenaga</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="rekap_jumlah_tenaga" id="rekap_jumlah_tenaga" class="form-control" value="<?php echo $rekap_jumlah_tenaga; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="rekap_jumlah_sudah_diperiksa">Jumlah Diperiksa</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="rekap_jumlah_sudah_diperiksa" id="rekap_jumlah_sudah_diperiksa" class="form-control" value="<?php echo $rekap_jumlah_sudah_diperiksa; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="rekap_jumlah_hasil_pcr">Jumlah Hasil PCR</label>
        </div>
        <div class="col-md-8">
            <input type="text" name="rekap_jumlah_hasil_pcr" id="rekap_jumlah_hasil_pcr" class="form-control" value="<?php echo $rekap_jumlah_hasil_pcr; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <dt>Keterangan : </dt>
        </div>
        <div class="col-md-8">
            <span id="NotifikasiEditPcrNakesSirsOnline">Pastikan data laporan yang anda input sudah sesuai</span>
        </div>
    </div>
<?php }} ?>