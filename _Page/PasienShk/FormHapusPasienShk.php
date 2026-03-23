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
        <input type="hidden" name="id_pasien_shk" value="<?php echo $id_pasien_shk; ?>">
        <input type="hidden" name="id_shk" value="<?php echo $id_shk; ?>">
        <div class="row mb-3"> 
            <div class="col col-md-12">
                Apakah anda yakin akan menghapus pasien SHK berikut ini?
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>ID Pasien SHK</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $id_pasien_shk; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-4">
                <dt>ID SHK</dt>
            </div>
            <div class="col col-md-8">
                <?php echo $id_shk; ?>
            </div>
        </div>
        <div class="row mb-3"> 
            <div class="col col-md-12">
                <dt>Hapus di SIRS online?</dt>
            </div>
            <div class="col col-md-12">
                <ul>
                    <li>
                        <input type="radio" checked name="HapusPasienShkSirsOnline" id="HapusPasienShkSirsOnline_Ya" value="Ya">
                        <label for="HapusPasienShkSirsOnline_Ya">Ya, Hapus juga</label>
                    </li>
                    <li>
                        <input type="radio" name="HapusPasienShkSirsOnline" id="HapusPasienShkSirsOnline_Tidak" value="Tidak">
                        <label for="HapusPasienShkSirsOnline_Tidak">Tidak, Biarkan saja</label>
                    </li>
                </ul>
            </div>
        </div>
<?php }} ?>