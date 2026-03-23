<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <?php
                            if(empty($_GET['id'])){
                                echo '<div class="card-body">';
                                echo '  <div class="row mb-4">';
                                echo '      <div class="col-md-12 text-danger text-center">';
                                echo '          ID Pemeriksaan Tidak Boleh Kosong';
                                echo '      </div>';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                $id_permintaan=$_GET['id'];
                        ?>
                        <div class="card table-card">
                            <form action="javascript:void(0);" id="ProsesEditPermintaanLab">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-8 mb-3 card-title">
                                            <h4 class="text-dark">
                                                <i class="icofont-prescription"></i> Form Edit Permintaan Laboratorium
                                            </h4>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <a href="index.php?Page=Laboratorium&Sub=DetailPermintaanLab&id=<?php echo "$id_permintaan"; ?>" class="btn btn-sm btn-block btn-secondary" title="Lihat Detail Permintaan Lab">
                                                <i class="ti ti-info-alt text-white"></i> Lihat Detail
                                            </a>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <a href="index.php?Page=Laboratorium&Sub=PermintaanLab" class="btn btn-sm btn-block btn-secondary" title="kembali Ke List Permintaan Lab">
                                                <i class="ti ti-list text-white"></i> List Permintaan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                        $id_pasien=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'id_pasien');
                                        $id_kunjungan=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'id_kunjungan');
                                        $id_dokter=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'id_dokter');
                                        $tujuan=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'tujuan');
                                        $nama_pasien=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'nama_pasien');
                                        $nama_dokter=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'nama_dokter');
                                        $tanggal=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'tanggal');
                                        $faskes=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'faskes');
                                        $unit=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'unit');
                                        $prioritas=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'prioritas');
                                        $diagnosis=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'diagnosis');
                                        $keterangan_permintaan=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'keterangan_permintaan');
                                        $nama_signature=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'nama_signature');
                                        $signature=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'signature');
                                        $status=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'status');
                                        $keterangan_status=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'keterangan_status');
                                        //Pecahkan tanggal
                                        $strtotime=strtotime($tanggal);
                                        $Tanggal=date('Y-m-d',$strtotime);
                                        $Jam=date('H:i',$strtotime);
                                ?>
                                    <input type="hidden" class="form-control" name="id_permintaan" id="id_permintaan" value="<?php echo $id_permintaan; ?>">
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-md-2">
                                                <dt>Tanggal/Waktu</dt>
                                            </div>
                                            <div class="col-md-5 col-6">
                                                <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo $Tanggal; ?>">
                                                <small>Tanggal Permintaan</small>
                                            </div>
                                            <div class="col-md-5 col-6">
                                                <input type="time" class="form-control" name="waktu" id="waktu" value="<?php echo $Jam; ?>">
                                                <small>Jam Permintaan</small>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-2">
                                                <dt>RM Pasien</dt>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="id_pasien" id="id_pasien" placeholder="Nomor RM Pasien" value="<?php echo $id_pasien; ?>">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalPilihPasien">
                                                        <i class="ti-arrow-circle-up"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" readonly class="form-control" name="nama_pasien" id="nama_pasien" value="<?php echo $nama_pasien; ?>">
                                                <small>Nama Pasien</small>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-2">
                                                <dt>No.Reg</dt>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="id_kunjungan" id="id_kunjungan" placeholder="Kunjungan pasien" value="<?php echo $id_kunjungan; ?>">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalPilihKunjungan">
                                                        <i class="ti-arrow-circle-up"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" readonly class="form-control" name="jenis_kunjungan" id="jenis_kunjungan" value="<?php echo $tujuan; ?>">
                                                <small>Jenis Kunjungan</small>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-2">
                                                <dt>Dokter Pengirim</dt>
                                            </div>
                                            <div class="col-md-5">
                                                <select name="id_dokter" id="id_dokter" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <?php
                                                        $QryDokter = mysqli_query($Conn, "SELECT*FROM dokter ORDER BY nama ASC");
                                                        while ($DataDokter = mysqli_fetch_array($QryDokter)) {
                                                            $IdDokterList= $DataDokter['id_dokter'];
                                                            $NamaDokter= $DataDokter['nama'];
                                                            if($IdDokterList==$id_dokter){
                                                                echo '<option selected value="'.$IdDokterList.'">'.$NamaDokter.'</option>';
                                                            }else{
                                                                echo '<option value="'.$IdDokterList.'">'.$NamaDokter.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    <option value="Lainnya">Lainnya</option>
                                                </select>
                                                <small>Pilih Dari Referensi Dokter</small>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" readonly class="form-control" name="dokter" id="dokter"  value="<?php echo $nama_dokter; ?>">
                                                <small>Nama Dokter</small>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-2">
                                                <dt>Faskes Pemohon</dt>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="faskes" id="faskes" value="<?php echo $faskes; ?>">
                                                <small>Nama RS/Klinik/Dokter Yang Mengirim Permintaan</small>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-2">
                                                <dt>Unit/Instalasi</dt>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="unit" id="unit" value="<?php echo $unit; ?>">
                                                <small>Nama Unit/Instalasi/Divisi Yang mengajukan Permintaan Pemeriksaan</small>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-2">
                                                <dt>Prioritas</dt>
                                            </div>
                                            <div class="col-md-10">
                                                <select name="prioritas" id="prioritas" class="form-control">
                                                    <option <?php if($prioritas=="NON CITO"){echo "selected";} ?> value="NON CITO">NON CITO</option>
                                                    <option <?php if($prioritas=="CITO"){echo "selected";} ?> value="CITO">CITO</option>
                                                </select>
                                                <small>Urutan/Tingkat Kecepatan dalam melakukan pemeriksaan</small>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-2">
                                                <dt>Diagnosis/Penyakit</dt>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="diagnosis" id="diagnosis" value="<?php echo $diagnosis; ?>">
                                                <small>Diagnosis penyakit / Keterangan masalah 	</small>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-2">
                                                <dt>Keterangan</dt>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="keterangan_permintaan" id="keterangan_permintaan" value="<?php echo $keterangan_permintaan; ?>">
                                                <small>Informasi tambahan terkait permintaan pemeriksaan</small>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-2">
                                                <dt>A/N Pemohon</dt>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="nama_signature" id="nama_signature" value="<?php echo $nama_signature; ?>">
                                                <small>Atas Nama (Nama Lengkap) Pemohon</small>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-12">
                                                <div class="row mb-4">
                                                    <div class="col-md-12">
                                                        <label for="signature"><dt>Tanda Tangan Pemohon</dt></label>
                                                        <canvas id="signature-pad" class="signature-pad" width="100%">
                                                            <!-- Konten Tanda Tangan Disimpan Disini -->
                                                            <img src="<?php echo 'data:image/png;base64,' . $signature . ''; ?>" width="100%">
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
                                            <div class="col-md-12" id="NotifikasiEditPermintaan">
                                                <span class="text-primary">Pastikan Data Permintaan Sudah Sesuai</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-md btn-primary mb-3">
                                            <i class="ti ti-save"></i> Simpan
                                        </button>
                                    </div>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector">

        </div>
    </div>
</div>
