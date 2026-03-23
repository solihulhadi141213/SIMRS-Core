<?php
    //Memanggil Fungsi
    include "_Config/SimrsFunction.php";
    include "_Config/FungsiSirsOnline.php";
?>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <?php
                    if(empty($_GET['id'])){
                        echo '<div class="row">';
                        echo '  <div class="col-xl-12 col-md-12">';
                        echo '      <div class="card">';
                        echo '          <div class="card-body text-center text-danger">';
                        echo '              ID SHK Tidak Boleh Kosong!';
                        echo '          </div>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        $id_pasien_shk=$_GET['id'];
                        //Cek apakah id tersebut angka atau bukan
                        if(!preg_match("/^[0-9]*$/", $id_pasien_shk)){
                            echo '<div class="row">';
                            echo '  <div class="col-xl-12 col-md-12">';
                            echo '      <div class="card">';
                            echo '          <div class="card-body text-center text-danger">';
                            echo '              ID SHK Hanya Boleh Angka!';
                            echo '          </div>';
                            echo '      </div>';
                            echo '  </div>';
                            echo '</div>';
                        }else{
                            //Bukka Atribut SHK
                            $id_shk=getDataDetail($Conn,'pasien_shk','id_pasien_shk',$id_pasien_shk,'id_shk');
                            $id_pasien_ibu=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'id_pasien_ibu');
                            $nik_ibu=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'nik_ibu');
                            $nama_ibu=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'nama_ibu');
                            $id_pasien_anak=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'id_pasien_anak');
                            $nik_anak=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'nik_anak');
                            $nama_anak=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'nama_anak');
                            $tgllahir=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'tgllahir');
                            $gender_anak=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'gender_anak');
                            $alamat=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'alamat');
                            $provinsi=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'provinsi');
                            $kabkota=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'kabkota');
                            $kecamatan=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'kecamatan');
                            $tgl_ambil_sampel=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'tgl_ambil_sampel');
                            $tgl_kirim_sampel=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'tgl_kirim_sampel');
                            $tgl_lapor=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'tgl_lapor');
                            $kode_perujuk=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'kode_perujuk');
                            $nama_fayankes_perujuk=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'nama_fayankes_perujuk');
                            $jenis_fasyankes=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'jenis_fasyankes');
                            $id_akses=getDataDetail($Conn,'pasien_shk','id_shk',$id_shk,'id_akses');
                            //Buka Nama Petugas
                            $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
                            //Buka Wilayah
                            $provinsi=getDataDetail($Conn,'wilayah_mendagri ','kode',$provinsi,'nama');
                            $kabkota=getDataDetail($Conn,'wilayah_mendagri ','kode',$kabkota,'nama');
                            $kecamatan=getDataDetail($Conn,'wilayah_mendagri ','kode',$kecamatan,'nama');
                ?>
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-7 mb-3">
                                            <h4>
                                                <i class="ti ti-info-alt"></i> Detail Pasian SHK
                                            </h4>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="index.php?Page=PasienShk" class="btn btn-sm btn-block btn-secondary">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-sm btn-block btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                                                Option    
                                            </button>
                                            <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalEditPasienShk" data-id="<?php echo $id_pasien_shk; ?>">
                                                    <i class="ti-pencil"></i> Edit
                                                </a>
                                                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusPasienShk" data-id="<?php echo $id_pasien_shk; ?>">
                                                    <i class="ti-trash"></i> Hapus
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3"> 
                                        <div class="col col-md-4">
                                            <dt>ID SHK</dt>
                                        </div>
                                        <div class="col col-md-8" id="GetNilaiIdShk">
                                            <?php echo $id_shk; ?>
                                        </div>
                                    </div>
                                    <div class="row mb-3"> 
                                        <div class="col col-md-4">
                                            <dt>ID RM Ibu</dt>
                                        </div>
                                        <div class="col col-md-8">
                                            <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailPasienByRm" data-id="<?php echo $id_pasien_ibu; ?>">
                                                <?php echo $id_pasien_ibu; ?>
                                            </a>
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
                                            <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailPasienByRm" data-id="<?php echo $id_pasien_anak; ?>">
                                                <?php echo $id_pasien_anak; ?>
                                            </a>
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
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-9 mb-3">
                                            <h4>
                                                <i class="icofont-laboratory"></i> Lab Pasian SHK
                                            </h4>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <button type="button" class="btn btn-sm btn-block btn-info" id="TombolTampilkanLabPasienShk"><i class="ti ti-angle-down"></i> Tampilkan</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body bg-light" id="TampilkanLabPasienShk">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            Silahkan Klik Tombol <i class="text-info">Tampilkan</i> Untuk Menampilkan Data Hasil Lab Pasian SHK
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                        }
                    }
                ?>
                
            </div>
        </div>
    </div>
</div>