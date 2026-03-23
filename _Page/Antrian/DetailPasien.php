<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //id_pasien
    if(empty($_POST['id_pasien'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <span class="text-danger">ID Pasien Tidak Boleh Kosong!!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_pasien=$_POST['id_pasien'];
        $id_pasien =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'id_pasien');
        if(empty($id_pasien)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center">';
            echo '      <span class="text-danger">ID Pasien Tidak Valid Atau Tidak Ditemukan Pada Database!</span>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_ihs =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'id_ihs');
            $nama =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'nama');
            $tanggal_daftar =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'tanggal_daftar');
            $nik =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'nik');
            $no_bpjs =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'no_bpjs');
            $gender =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'gender');
            $tempat_lahir =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'tempat_lahir');
            $tanggal_lahir =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'tanggal_lahir');
            $propinsi =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'propinsi');
            $kabupaten =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'kabupaten');
            $kecamatan =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'kecamatan');
            $desa =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'desa');
            $alamat =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'alamat');
            $alamat =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'alamat');
            $kontak =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'kontak');
            $kontak_darurat =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'kontak_darurat');
            $penanggungjawab =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'penanggungjawab');
            $golongan_darah =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'golongan_darah');
            $perkawinan =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'perkawinan');
            $pekerjaan =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'pekerjaan');
            $gambar =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'gambar');
            $status =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'status');
            $id_pasien_relasi =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'id_pasien_relasi');
            $status_relasi =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'status_relasi');
            $id_akses =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'id_akses');
            $nama_petugas =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'nama_petugas');
            $updatetime =getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'updatetime');
?>
    <div class="row mb-2">
        <div class="col-md-4"><dt>No.RM</dt></div>
        <div class="col-md-8"><small><?php echo "$id_pasien"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>ID IHS</dt></div>
        <div class="col-md-8"><small><?php echo "$id_ihs"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>Nama Lengkap</dt></div>
        <div class="col-md-8"><small><?php echo "$nama"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>Tanggal Daftar</dt></div>
        <div class="col-md-8"><small><?php echo "$tanggal_daftar"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>NIK</dt></div>
        <div class="col-md-8"><small><?php echo "$nik"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>BPJS</dt></div>
        <div class="col-md-8"><small><?php echo "$no_bpjs"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>TTL</dt></div>
        <div class="col-md-8"><small><?php echo "$tempat_lahir, $tanggal_lahir"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>Provinsi</dt></div>
        <div class="col-md-8"><small><?php echo "$propinsi"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>Kabupaten/Kota</dt></div>
        <div class="col-md-8"><small><?php echo "$kabupaten"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>Kecamatan</dt></div>
        <div class="col-md-8"><small><?php echo "$kecamatan"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>Desa/Kelurahan</dt></div>
        <div class="col-md-8"><small><?php echo "$desa"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>Alamat</dt></div>
        <div class="col-md-8"><small><?php echo "$alamat"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>Kontak Utama</dt></div>
        <div class="col-md-8"><small><?php echo "$kontak"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>Kontak Darurat</dt></div>
        <div class="col-md-8"><small><?php echo "$kontak_darurat"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>Penanggung Jawab</dt></div>
        <div class="col-md-8"><small><?php echo "$penanggungjawab"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>Golongan Darah</dt></div>
        <div class="col-md-8"><small><?php echo "$golongan_darah"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>Status Perkawinan</dt></div>
        <div class="col-md-8"><small><?php echo "$perkawinan"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>Pekerjaan</dt></div>
        <div class="col-md-8"><small><?php echo "$pekerjaan"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>Status pasien</dt></div>
        <div class="col-md-8"><small><?php echo "$status"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>Petugas Pencatat</dt></div>
        <div class="col-md-8"><small><?php echo "$nama_petugas"; ?></small></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-4"><dt>Update Time</dt></div>
        <div class="col-md-8"><small><?php echo "$updatetime"; ?></small></div>
    </div>
<?php }} ?>