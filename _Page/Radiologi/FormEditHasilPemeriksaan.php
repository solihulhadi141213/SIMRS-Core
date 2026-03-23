<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <?php
                            if(empty($_GET['id_rad'])){
                                echo '  <div class="card table-card">';
                                echo '      <div class="row">';
                                echo '          <div class="col-md-12 text-center text-danger">';
                                echo '              ID Radiologi Tidak Boleh Kosong!';
                                echo '          </div>';
                                echo '      </div>';
                                echo '  </div>';
                            }else{
                                if(empty($_GET['id_rincian'])){
                                    echo '  <div class="card table-card">';
                                    echo '      <div class="row">';
                                    echo '          <div class="col-md-12 text-center text-danger">';
                                    echo '              ID Hasil Pemeriksaan Tidak Boleh Kosong!';
                                    echo '          </div>';
                                    echo '      </div>';
                                    echo '  </div>';
                                }else{
                                    $id_rad=$_GET['id_rad'];
                                    $id_rincian=$_GET['id_rincian'];
                                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'id_rad'))){
                                        echo '  <div class="card table-card">';
                                        echo '      <div class="row">';
                                        echo '          <div class="col-md-12 text-center text-danger">';
                                        echo '              ID Radiologi Tidak Valid Atau Tidak Ada Pada Database!';
                                        echo '          </div>';
                                        echo '      </div>';
                                        echo '  </div>';
                                    }else{
                                        if(empty(getDataDetail($Conn,'radiologi_rincian','id_rincian',$id_rincian,'id_rincian'))){
                                            echo '  <div class="card table-card">';
                                            echo '      <div class="row">';
                                            echo '          <div class="col-md-12 text-center text-danger">';
                                            echo '              ID Hasil Pemeriksaan Tidak Valid Atau Tidak Ada Pada Database!';
                                            echo '          </div>';
                                            echo '      </div>';
                                            echo '  </div>';
                                        }else{
                                            //Apakah Data Radiologi Ada?
                                            $id_pasien=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'id_pasien');
                                            $id_kunjungan=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'id_kunjungan');
                                            $NamaPasien=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'nama');
                                            $WaktuRadiologi=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'waktu');
                                            $PermintaanPemeriksaan=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'permintaan_pemeriksaan');
                                            //Membuka Hasil Pemeriksaan
                                            $pemeriksaan=getDataDetail($Conn,'radiologi_rincian','id_rincian',$id_rincian,'pemeriksaan');
                                            $keterangan=getDataDetail($Conn,'radiologi_rincian','id_rincian',$id_rincian,'keterangan');
                                            $hasil=getDataDetail($Conn,'radiologi_rincian','id_rincian',$id_rincian,'hasil');
                        ?>
                            <form action="javascript:void(0);" id="ProsesEditHasilPemeriksaan">
                                <input type="hidden" id="GetIdRincian" name="GetIdRincian" value="<?php echo "$id_rincian";?>">
                                <input type="hidden" id="GetIdRad" name="GetIdRad" value="<?php echo "$id_rad";?>">
                                <div class="card table-card">
                                    <div class="card-header border-info">
                                        <div class="row">
                                            <div class="col-md-10 mb-3">
                                                <h4 class="text-dark">
                                                    <i class="icofont-prescription"></i> Form Edit Hasil Pemeriksaan
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
                                                        <label for="EditParamaeterPemeriksaan">Parameter Pemeriksaan</label>
                                                        <input type="text" class="form-control" name="EditParamaeterPemeriksaan" id="EditParamaeterPemeriksaan" value="<?php echo "$pemeriksaan"; ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="EditKeterangan">*Keterangan/Catatan</label>
                                                        <input type="text" class="form-control" name="EditKeterangan" id="EditKeterangan" value="<?php echo "$keterangan"; ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="EditHasilPemeriksaan">Hasil Analisis</label>
                                                        <textarea name="EditHasilPemeriksaan" id="EditHasilPemeriksaan" class="form-control" cols="30" rows="3"><?php echo "$hasil"; ?></textarea>
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
                                            <div class="col-md-12" id="NotifikasiEditHasilPemeriksaan">
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
                        <?php }}}} ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector">

        </div>
    </div>
</div>