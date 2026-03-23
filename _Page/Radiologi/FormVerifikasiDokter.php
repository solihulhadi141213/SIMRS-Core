<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <?php
                            if(empty($_GET['id'])){
                                echo '  <div class="card table-card">';
                                echo '      <div class="row">';
                                echo '          <div class="col-md-12 text-center text-danger">';
                                echo '              ID Radiologi Tidak Boleh Kosong!';
                                echo '          </div>';
                                echo '      </div>';
                                echo '  </div>';
                            }else{
                                $id_rad=$_GET['id'];
                                if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'id_rad'))){
                                    echo '  <div class="card table-card">';
                                    echo '      <div class="row">';
                                    echo '          <div class="col-md-12 text-center text-danger">';
                                    echo '              ID Radiologi Tidak Valid Atau Tidak Ada Pada Database!';
                                    echo '          </div>';
                                    echo '      </div>';
                                    echo '  </div>';
                                }else{
                                    //Apakah Data Radiologi Ada?
                                    $id_pasien=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'id_pasien');
                                    $id_kunjungan=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'id_kunjungan');
                                    $NamaPasien=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'nama');
                                    $WaktuRadiologi=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'waktu');
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'asal_kiriman'))){
                                        $AsalKiriman='<small class="text-muted">Tidak Ada</small>';
                                    }else{
                                        $AsalKiriman=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'asal_kiriman');
                                    }
                                    
                                    $PermintaanPemeriksaan=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'permintaan_pemeriksaan');
                                    $AlatPemeriksa=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'alat_pemeriksa');
                                    $StatusPemeriksa=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'status_pemeriksaan');
                                    $JenisPembayaran=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'jenis_pembayaran');
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_pengirim'))){
                                        $DokterPengirim='<small class="text-muted">Tidak Ada</small>';
                                    }else{
                                        $DokterPengirim=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_pengirim');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_penerima'))){
                                        $DokterPenerima='<small class="text-muted">Tidak Ada</small>';
                                    }else{
                                        $DokterPenerima=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_penerima');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kesan'))){
                                        $Kesan='';
                                    }else{
                                        $Kesan=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kesan');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'klinis'))){
                                        $KlinisPasien='';
                                    }else{
                                        $KlinisPasien=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'klinis');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'selesai'))){
                                        $WaktuSelesai='<small class="text-muted">Belum Diatur</small>';
                                    }else{
                                        $WaktuSelesai=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'selesai');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kv'))){
                                        $kv='<small class="text-muted">None</small>';
                                    }else{
                                        $kv=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kv');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'ma'))){
                                        $ma='<small class="text-muted">None</small>';
                                    }else{
                                        $ma=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'ma');
                                    }
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'sec'))){
                                        $sec='<small class="text-muted">None</small>';
                                    }else{
                                        $sec=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'sec');
                                    }
                        ?>
                        <form action="javascript:void(0);" id="ProsesVerifikasiDokter">
                            <input type="hidden" id="GetIdRad" name="GetIdRad" value="<?php echo "$id_rad";?>">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-10 mb-3">
                                            <h4 class="text-dark">
                                                <i class="icofont-prescription"></i> Form Verifikasi Dokter
                                            </h4>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <a href="index.php?Page=Radiologi&Sub=DetailRadiologi&id=<?php echo "$id_rad";?>" class="btn btn-md btn-block btn-secondary" title="Kembali Ke Halaman Detail Radiologi">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    Saya atas nama <i><?php echo $SessionNama;?></i> pada tanggal <i><?php echo date('Y-m-d');?></i> 
                                                    telah menandatangani dokumen digital berupa <i>Hasil Pemeriksaan Radiologi</i> dengan ID <i><?php echo $id_rad;?></i>--
                                                    dengan ketentuan sebagai berikut:
                                                    <p>
                                                        <ol>
                                                            <li>
                                                                Saya menyatakan bahwa tanda tangan digital ini sah dan sahih, 
                                                                karena memenuhi persyaratan hukum yang berlaku untuk tanda 
                                                                tangan elektronik sesuai dengan undang-undang yang berlaku di negara ini.
                                                            </li>
                                                            <li>
                                                                Saya mengakui bahwa data yang disajikan dalam dokumen ini adalah valid 
                                                                dan akurat berdasarkan analisa dan verifikasi yang dilakukan. 
                                                                Data tersebut telah dikumpulkan dari sumber yang terpercaya dan diperiksa 
                                                                untuk kesalahan atau ketidaksesuaian sebelum disajikan.
                                                            </li>
                                                            <li>
                                                                Tanda tangan digital ini telah dihasilkan menggunakan proses tanda tangan secara digital pada layar sebagai --
                                                                pengakuan yang sah atas dokumen dan dapat diverifikasi secara independen.
                                                            </li>
                                                        </ol>
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="id_rad"><dt>ID.Rad</dt></label>
                                                    <input type="text" readonly class="form-control" name="id_rad" id="id_rad" value="<?php echo $id_rad;?>">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="tanggal"><dt>Tanggal</dt></label>
                                                    <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d');?>">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="jam"><dt>Jam</dt></label>
                                                    <input type="time" class="form-control" name="jam" id="jam" value="<?php echo date('H:i');?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="nama"><dt>Nama Dokter</dt></label>
                                                    <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $SessionNama;?>">
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="row mb-4">
                                                <div class="col-md-12">
                                                    <label for="signature"><dt>Tanda Tangan Disini</dt></label>
                                                    <canvas id="signature-pad" class="signature-pad" width="100%">
                                                        <!-- Konten Tanda Tangan Disimpan Disini -->
                                                    </canvas>
                                                </div>
                                                <div class="col-md-12 text-center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-outline-dark" id="change-color" title="Ubah Warna Tinta">
                                                            <span class="ti-palette"></span>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-dark" id="undo" title="Undo">
                                                            <span class="ti-back-left"></span>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-dark" id="clear" title="Batalkan Semua">
                                                            <span class="ti-eraser"></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="row mb-4">
                                        <div class="col-md-12" id="NotifikasiVerifikasiDokter">
                                            <span class="text-primary">Pastikan Data Dan Informasi Verifikasi Radiologi Sudah Sesuai</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-md btn-primary mb-3">
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