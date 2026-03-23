<?php
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    if(empty($_POST['id_pasien_shk'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 mb-3 text-center text-danger">';
        echo '          ID Pasien SHK Tidak Boleh Kosong';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_pasien_shk=$_POST['id_pasien_shk'];
        $GetIdPasienShk=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'id_pasien_shk');
        if(empty($GetIdPasienShk)){
            echo '  <div class="row">';
            echo '      <div class="col-md-12 mb-3 text-center text-danger">';
            echo '          Data Pasien SHK tersebut tidak ditemukan pada database';
            echo '      </div>';
            echo '  </div>';
        }else{
            $id_shk=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'id_shk');
            $id_pasien_ibu=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'id_pasien_ibu');
            $nik_ibu=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'nik_ibu');
            $nama_ibu=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'nama_ibu');
            $id_pasien_anak=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'id_pasien_anak');
            $nik_anak=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'nik_anak');
            $nama_anak=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'nama_anak');
            $tgllahir=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'tgllahir');
            $gender_anak=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'gender_anak');
            $alamat=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'alamat');
            $provinsi=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'provinsi');
            $kabkota=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'kabkota');
            $kecamatan=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'kecamatan');
            $tgl_ambil_sampel=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'tgl_ambil_sampel');
            $tgl_kirim_sampel=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'tgl_kirim_sampel');
            $tgl_lapor=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'tgl_lapor');
            $kode_perujuk=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'kode_perujuk');
            $nama_fayankes_perujuk=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'nama_fayankes_perujuk');
            $jenis_fasyankes=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'jenis_fasyankes');
            $id_akses=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'id_akses');
            //Buka Nama Petugas
            $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
            //Buka Wilayah
            $provinsi=getDataDetail($Conn,'wilayah_mendagri ','kode',$provinsi,'nama');
            $kabkota=getDataDetail($Conn,'wilayah_mendagri ','kode',$kabkota,'nama');
            $kecamatan=getDataDetail($Conn,'wilayah_mendagri ','kode',$kecamatan,'nama');
?>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>ID SHK</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $id_shk; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>ID RM Ibu</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $id_pasien_ibu; ?>
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
                <dt>ID RM Anak</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $id_pasien_anak; ?>
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
                <dt>Gender Anak</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $gender_anak; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>Alamat Domisili</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $alamat; ?>
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
            <div class="col col-md-4">
                <dt>Petugas</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $NamaPetugas; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-12">
                <a href="index.php?Page=PasienShk&&Sub=DetailPasienShk&id=<?php echo "$id_pasien_shk";?>" class="btn btn-sm btn-block btn-outline-dark">
                    <i class="ti ti-more"></i> Lihat Selengkapnya
                </a>
            </div>
        </div>
<?php }} ?>