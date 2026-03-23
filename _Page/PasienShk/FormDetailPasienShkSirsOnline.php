<?php
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //Tangkap id_antrian
    if(empty($_POST['id_shk'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 mb-3 text-center text-danger">';
        echo '          ID SHK Tidak Boleh Kosong';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_shk=$_POST['id_shk'];
        $id_pasien_shk=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'id_pasien_shk');
        $tgl_ambil_sampel=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'tgl_ambil_sampel');
        //Buka Data Pasien SHK
        $response=DetailPasienShk($x_id_rs,$password_sirs_online,$url_sirs_online,$id_shk,$tgl_ambil_sampel);
        if(empty($response)){
            echo '  <div class="row">';
            echo '      <div class="col-md-12 mb-3 text-center text-danger">';
            echo '          Tidak ada Response Dari SIRS Online';
            echo '      </div>';
            echo '  </div>';
        }else{
            $data = json_decode($response, true);
            if(empty($data['shk'])){
                echo '  <div class="row">';
                echo '      <div class="col-md-12 mb-3 text-center text-danger">';
                echo '          Tidak ada Response Dari SIRS Online <br> Response: <textarea class="form-control">'.$response.'</textarea>';
                echo '      </div>';
                echo '  </div>';
            }else{
                $GetIdShk = $data['shk']['0']['id_shk'];
                $koders = $data['shk']['0']['koders'];
                $namars = $data['shk']['0']['namars'];
                $nik_ibu = $data['shk']['0']['nik_ibu'];
                $nama_ibu = $data['shk']['0']['nama_ibu'];
                $nik_anak = $data['shk']['0']['nik_anak'];
                $nama_anak = $data['shk']['0']['nama_anak'];
                $tgllahir = $data['shk']['0']['tgllahir'];
                $dom_alamat = $data['shk']['0']['dom_alamat'];
                $tgl_ambil_sampel = $data['shk']['0']['tgl_ambil_sampel'];
                $tgl_kirim_sampel = $data['shk']['0']['tgl_kirim_sampel'];
                $tgl_terima_sampel = $data['shk']['0']['tgl_terima_sampel'];
                $tgl_pemeriksaan = $data['shk']['0']['tgl_pemeriksaan'];
                $tgl_hasil = $data['shk']['0']['tgl_hasil'];
                $nama_fayankes_perujuk = $data['shk']['0']['nama_fayankes_perujuk'];
                $tgl_lapor = $data['shk']['0']['tgl_lapor'];
                $kode_perujuk = $data['shk']['0']['kode_perujuk'];
?>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>ID SHK</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $GetIdShk; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>Kode RS</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $koders; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>Nama RS</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $namars; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>NIK Ibu</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $nik_ibu; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>Nama Ibu</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $nama_ibu; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>NIK Anak</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $nik_anak; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>Nama Anak</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $nama_anak; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>Tanggal Lahir</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $tgllahir; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>Alamat Domisili</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $dom_alamat; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>Tgl. Ambil Sample</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $tgl_ambil_sampel; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>Tgl. Kirim Sample</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $tgl_kirim_sampel; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>Tgl. Terima Sample</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $tgl_terima_sampel; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>Tgl. Periksa</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $tgl_pemeriksaan; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>Tgl. Hasil</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $tgl_hasil; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>Fasyankes Perujuk</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $nama_fayankes_perujuk; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>Kode Perujuk</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $kode_perujuk; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>Tgl. Lapor</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $tgl_lapor; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-12">
                <a href="index.php?Page=PasienShk&&Sub=DetailPasienShk&id=<?php echo "$id_pasien_shk";?>" class="btn btn-sm btn-block btn-outline-dark">
                    <i class="ti ti-more"></i> Lihat Selengkapnya
                </a>
            </div>
        </div>
<?php }}} ?>