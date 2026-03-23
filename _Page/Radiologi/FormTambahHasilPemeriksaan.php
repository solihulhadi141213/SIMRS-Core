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
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'radiografer'))){
                                        $RadioGrafer='<small class="text-muted">Tidak Ada</small>';
                                    }else{
                                        $RadioGrafer=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'radiografer');
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
                        <form action="javascript:void(0);" id="ProsesTambahHasilPemeriksaan">
                            <input type="hidden" id="GetIdRad" name="GetIdRad" value="<?php echo "$id_rad";?>">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-10 mb-3">
                                            <h4 class="text-dark">
                                                <i class="icofont-prescription"></i> Form Tambah Hasil Pemeriksaan
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
                                    <div class="row mb-4">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="ParamaeterPemeriksaan">Parameter Pemeriksaan</label>
                                                    <input type="text" class="form-control" name="ParamaeterPemeriksaan" id="ParamaeterPemeriksaan">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="keterangan">*Keterangan/Catatan</label>
                                                    <input type="text" class="form-control" name="keterangan" id="keterangan">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="HasilPemeriksaan">Hasil Analisis</label>
                                                    <textarea name="HasilPemeriksaan" id="HasilPemeriksaan" class="form-control" cols="30" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 table table-responsive">
                                            <table class="table table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td>ID.PASIEN</td>
                                                        <td>:</td>
                                                        <td><?php echo "$id_pasien"; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>ID.REG</td>
                                                        <td>:</td>
                                                        <td><?php echo "$id_kunjungan"; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>ID.RAD</td>
                                                        <td>:</td>
                                                        <td><?php echo "$id_rad"; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>NAMA</td>
                                                        <td>:</td>
                                                        <td><?php echo "$NamaPasien"; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>TANGGAL</td>
                                                        <td>:</td>
                                                        <td><?php echo "$WaktuRadiologi"; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>PEMERIKSAAN</td>
                                                        <td>:</td>
                                                        <td><?php echo "$PermintaanPemeriksaan"; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12" id="NotifikasiHasilPemeriksaan">
                                            <span class="text-primary">Pastikan Data Dan Informasi Pendaftaran Sudah Sesuai</span>
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