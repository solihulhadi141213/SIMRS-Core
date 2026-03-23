<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <?php
                            //Tangkap id_rad
                            if(empty($_GET['id'])){
                                echo '  <div class="card">';
                                echo '      <div class="card-body text-center text-danger mb-3">';
                                echo '         ID Radiologi Tidak Boleh Kosong!.';
                                echo '      </div>';
                                echo '  </div>';
                            }else{
                                $id_rad=$_GET['id'];
                                if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'id_pasien'))){
                                    echo '  <div class="card">';
                                    echo '      <div class="card-body text-center text-danger mb-3">';
                                    echo '         ID Radiologi Tidak Valid atau tidak terdaftar!.';
                                    echo '      </div>';
                                    echo '  </div>';
                                }else{
                                    $id_pasien=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'id_pasien');
                                    $id_kunjungan=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'id_kunjungan');
                                    $NamaPasien=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'nama');
                                    $WaktuRadiologi=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'waktu');
                                    //melakukan explode waktu
                                    $explode = explode(" " , $WaktuRadiologi);
                                    $TanggalLayanan=$explode[0];
                                    $JamLayanan=$explode[1];

                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'asal_kiriman'))){
                                        $AsalKiriman="";
                                    }else{
                                        $AsalKiriman=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'asal_kiriman');
                                    }
                                    
                                    $PermintaanPemeriksaan=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'permintaan_pemeriksaan');
                                    $AlatPemeriksa=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'alat_pemeriksa');
                                    $StatusPemeriksa=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'status_pemeriksaan');
                                    $JenisPembayaran=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'jenis_pembayaran');
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_pengirim'))){
                                        $DokterPengirim="";
                                    }else{
                                        $DokterPengirim=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_pengirim');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_penerima'))){
                                        $DokterPenerima="";
                                    }else{
                                        $DokterPenerima=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_penerima');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'radiografer'))){
                                        $RadioGrafer="";
                                    }else{
                                        $RadioGrafer=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'radiografer');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kesan'))){
                                        $Kesan="";
                                    }else{
                                        $Kesan=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kesan');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'klinis'))){
                                        $KlinisPasien='';
                                    }else{
                                        $KlinisPasien=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'klinis');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'selesai'))){
                                        $WaktuSelesai='';
                                    }else{
                                        $WaktuSelesai=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'selesai');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kv'))){
                                        $kv='';
                                    }else{
                                        $kv=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kv');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'ma'))){
                                        $ma='';
                                    }else{
                                        $ma=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'ma');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'sec'))){
                                        $sec='';
                                    }else{
                                        $sec=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'sec');
                                    }
                        ?>
                            <form action="javascript:void(0);" id="ProsesEditPendaftaranRadiologi">
                                <input type="hidden" id="id_rad" name="id_rad" value="<?php echo "$id_rad"; ?>">
                                <div class="card table-card">
                                    <div class="card-header border-info">
                                        <div class="row">
                                            <div class="col-md-10 mb-3">
                                                <h4 class="text-dark">
                                                    <i class="icofont-prescription"></i> Form Edit Pendaftaran Radiologi
                                                </h4>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <a href="index.php?Page=Radiologi&Sub=DetailRadiologi&id=<?php echo "$id_rad"; ?>" class="btn btn-md btn-block btn-secondary" title="Kembali Ke Halaman Data Radiologi">
                                                    <i class="ti ti-angle-left"></i> Kembali
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-md-3">
                                                <label for="id_pasien"><dt>No.RM & ID REG</dt></label>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <input type="text" name="id_pasien" id="id_pasien" class="form-control" placeholder="Nomor RM" value="<?php echo "$id_pasien"; ?>">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalPilihPasien">
                                                        <i class="ti-arrow-circle-up"></i> RM
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input type="text" name="id_kunjungan" id="id_kunjungan" class="form-control" placeholder="ID Kunjungan" value="<?php echo "$id_kunjungan"; ?>">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalPilihKunjungan">
                                                        <i class="ti-arrow-circle-up"></i> REG
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-3">
                                                <label for="nama"><dt>Nama Lengkap Pasien</dt></label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="nama" id="nama" class="form-control" value="<?php echo "$NamaPasien"; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-3 mb-2">
                                                <label for="tanggal"><dt>Tanggal & Waktu Pemeriksaan</dt></label>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo "$TanggalLayanan"; ?>">
                                                <small>Tanggal</small>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <input type="time" name="jam" id="jam" class="form-control" value="<?php echo "$JamLayanan"; ?>">
                                                <small>Waktu/Jam</small>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-3">
                                                <label for="asal_kiriman"><dt>Asal Kiriman</dt></label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="asal_kiriman" id="asal_kiriman" class="form-control" list="ListAsalKiriman" value="<?php echo "$AsalKiriman"; ?>">
                                                <datalist id="ListAsalKiriman">
                                                    <?php
                                                        //menampilkan list asal_kiriman
                                                        $QryAsal = mysqli_query($Conn, "SELECT DISTINCT asal_kiriman FROM radiologi ORDER BY asal_kiriman ASC");
                                                        while ($DataAsal = mysqli_fetch_array($QryAsal)) {
                                                            if(!empty($DataAsal['asal_kiriman'])){
                                                                $ListAsal= $DataAsal['asal_kiriman'];
                                                                echo '<option value="'.$ListAsal.'">';
                                                            }
                                                        }
                                                    ?>
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-3">
                                                <label for="permintaan_pemeriksaan"><dt>Permintaan Pemeriksaan</dt></label>
                                            </div>
                                            <div class="col-md-9">
                                                <textarea name="permintaan_pemeriksaan" id="permintaan_pemeriksaan" class="form-control" cols="30" rows="3"><?php echo "$PermintaanPemeriksaan"; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-3">
                                                <label for="alat_pemeriksa"><dt>Alat/Pesawat Pemeriksaan</dt></label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="alat_pemeriksa" id="alat_pemeriksa" class="form-control" list="ListAlat" value="<?php echo "$AlatPemeriksa"; ?>">
                                                <datalist id="ListAlat">
                                                    <?php
                                                        //menampilkan list alat_pemeriksa
                                                        $QryAlat = mysqli_query($Conn, "SELECT DISTINCT alat_pemeriksa FROM radiologi ORDER BY alat_pemeriksa ASC");
                                                        while ($DataAlat = mysqli_fetch_array($QryAlat)) {
                                                            if(!empty($DataAlat['alat_pemeriksa'])){
                                                                $ListAlat= $DataAlat['alat_pemeriksa'];
                                                                echo '<option value="'.$ListAlat.'">';
                                                            }
                                                        }
                                                    ?>
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-3">
                                                <label for="dokter_pengirim"><dt>Dokter Pengirim</dt></label>
                                            </div>
                                            <div class="col-md-9">
                                                <select name="dokter_pengirim" id="dokter_pengirim" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <?php
                                                        //menampilkan list dokter
                                                        $QryDokter = mysqli_query($Conn, "SELECT*FROM dokter ORDER BY nama ASC");
                                                        while ($DataDokter = mysqli_fetch_array($QryDokter)) {
                                                            if(!empty($DataDokter['nama'])){
                                                                $NamaDokter= $DataDokter['nama'];
                                                                if($DokterPengirim==$NamaDokter){
                                                                    echo '<option selected value="'.$NamaDokter.'">'.$NamaDokter.'</option>';
                                                                }else{
                                                                    echo '<option value="'.$NamaDokter.'">'.$NamaDokter.'</option>';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-3">
                                                <label for="dokter_penerima"><dt>Dokter Penerima</dt></label>
                                            </div>
                                            <div class="col-md-9">
                                                <select name="dokter_penerima" id="dokter_penerima" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <?php
                                                        //menampilkan list dokter
                                                        $QryDokter = mysqli_query($Conn, "SELECT*FROM dokter ORDER BY nama ASC");
                                                        while ($DataDokter = mysqli_fetch_array($QryDokter)) {
                                                            if(!empty($DataDokter['nama'])){
                                                                $NamaDokter= $DataDokter['nama'];
                                                                if($DokterPenerima==$NamaDokter){
                                                                    echo '<option selected value="'.$NamaDokter.'">'.$NamaDokter.'</option>';
                                                                }else{
                                                                    echo '<option value="'.$NamaDokter.'">'.$NamaDokter.'</option>';
                                                                }
                                                                
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-3">
                                                <label for="kv_mk_sec"><dt>Faktor KV/MK/Sec</dt></label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="kv" id="kv" class="form-control" value="<?php echo "$kv"; ?>">
                                                <small>Faktor KV (*Radiografer)</small>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="ma" id="ma" class="form-control" value="<?php echo "$ma"; ?>">
                                                <small>Faktor MA (*Radiografer)</small>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="sec" id="sec" class="form-control" value="<?php echo "$sec"; ?>">
                                                <small>Faktor Sec (*Radiografer)</small>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-3">
                                                <label for="jenis_pembayaran"><dt>Metode Pembayaran</dt></label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="jenis_pembayaran" id="jenis_pembayaran" class="form-control" list="ListPembayaran" value="<?php echo "$JenisPembayaran"; ?>">
                                                <datalist id="ListPembayaran">
                                                    <?php
                                                        //menampilkan list jenis_pembayaran
                                                        $QryPembayaran = mysqli_query($Conn, "SELECT DISTINCT jenis_pembayaran FROM radiologi ORDER BY jenis_pembayaran ASC");
                                                        while ($DataPembayaran = mysqli_fetch_array($QryPembayaran)) {
                                                            if(!empty($DataPembayaran['jenis_pembayaran'])){
                                                                $ListPembayaran= $DataPembayaran['jenis_pembayaran'];
                                                                echo '<option value="'.$ListPembayaran.'">';
                                                            }
                                                        }
                                                    ?>
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-3">
                                                
                                            </div>
                                            <div class="col-md-9">
                                                <dt>Keterangan Penting :</dt>
                                                <ol>
                                                    <li>
                                                        Pendaftaran ini memerlukan verifikasi petugas radiografer.
                                                    </li>
                                                    <li>
                                                        Status data pemeriksaan saat mengisi form ini dinyatakan sebagai <i>Terdaftar</i>. 
                                                    </li>
                                                    <li>
                                                        Untuk menyelesaikan pelayanan Radiologi membutuhkan verifikasi dari dokter penerima.
                                                    </li>
                                                </ol>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-3">
                                                
                                            </div>
                                            <div class="col-md-9" id="NotifikasiEditPendaftaranRadiologi">
                                                <span class="text-primary">Pastikan Data Dan Informasi Pendaftaran Sudah Sesuai</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-md btn-primary mb-3" id="TombolSimpanRadiologi">
                                            <i class="ti ti-save"></i> Simpan
                                        </button>
                                        <button type="reset" class="btn btn-md btn-inverse mb-3">
                                            <i class="ti ti-reload"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </form>
                        <?php }} ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector">

        </div>
    </div>
</div>