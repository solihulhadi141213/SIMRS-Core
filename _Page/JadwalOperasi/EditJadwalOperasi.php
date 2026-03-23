<?php 
    include "_Config/SimrsFunction.php";
    if(empty($_GET['id'])){ 
        echo '<div class="row">';
        echo '  <div class="col-xl-12">';
        echo '      <div class="card">';
        echo '          <div class="card-body text-center text-danger">';
        echo '              ID Jadwal operasi tidak boleh kosong!';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_operasi=$_GET['id'];
        $id_pasien=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'id_pasien');
        $nama=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'nama');
        $nopeserta=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'nopeserta');
        $tanggal_daftar=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'tanggal_daftar');
        $jam_daftar=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'jam_daftar');
        $tanggaloperasi=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'tanggaloperasi');
        $jamoperasi=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'jamoperasi');
        $jenistindakan=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'jenistindakan');
        $kodepoli=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'kodepoli');
        $namapoli=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'namapoli');
        $keterangan=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'keterangan');
        $terlaksana=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'terlaksana');
        $kodebooking=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'kodebooking');
        $lastupdate=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'lastupdate');
        //Detail Pasien
        $nik=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'nik');
        $id_ihs=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'id_ihs');
        $gender=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'gender');
        if(!empty($gender)){
            //Inisiasi gender 
            if($gender=="Laki-laki"){
                $labelGender='<label class="label label-info">Male</label>';
            }else{
                if($gender=="Perempuan"){
                    $labelGender='<label class="label label-primary">Female</label>';
                }else{
                    $labelGender='<label class="label label-danger">None</label>';
                }
            }
        }else{
            $labelGender='<span class="text-danger">Tidak Diketahui</span>';
        }
?>
    <div class="row">
        <div class="col-xl-8 col-md-8">
            <div class="card">
                <form action="javascript:void(0);" id="ProsesEditJadwalOperasi">
                    <input type="hidden" name="id_operasi" value="<?php echo $id_operasi; ?>">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10 mb-3">
                                <h4><i class="icofont-ui-calendar"></i> Form Edit Jadwal Operasi</h4>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a href="index.php?Page=JadwalOperasi&Sub=DetailJadwalOperasi&id=<?php echo "$id_operasi"; ?>" class="btn btn-sm btn-dark btn-round btn-block">
                                    <i class="ti ti-angle-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4"><label for="kodebooking">Kode Booking</label></div>
                            <div class="col-md-8">
                                <input type="text" readonly class="form-control" name="kodebooking" id="kodebooking" value="<?php echo "$kodebooking";?>" required>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4"><label for="id_pasien">No.RM</label></div>
                            <div class="col-md-8">
                                <input type="text" readonly class="form-control" name="id_pasien" id="id_pasien" value="<?php echo $id_pasien; ?>" required>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4"><label for="nama">Nama Pasien</label></div>
                            <div class="col-md-8">
                                <input type="text" readonly class="form-control" name="nama" id="nama" value="<?php echo $nama; ?>" required>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4"><label for="nopeserta">No.Kartu</label></div>
                            <div class="col-md-8">
                                <input type="text" readonly class="form-control" name="nopeserta" id="nopeserta" value="<?php echo $nopeserta; ?>" required>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4"><label for="tanggaloperasi">Tanggal Operasi</label></div>
                            <div class="col-md-4">
                                <input type="date" class="form-control" name="tanggaloperasi" id="tanggaloperasi" value="<?php echo $tanggaloperasi; ?>" required>
                                <small><label for="tanggaloperasi">Tanggal</label></small>
                            </div>
                            <div class="col-md-4">
                                <input type="time" class="form-control" name="jamoperasi" id="jamoperasi" value="<?php echo $jamoperasi; ?>" required>
                                <small><label for="jamoperasi">Jam Operasi</label></small>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4"><label for="jenistindakan">Jenis Tindakan</label></div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="jenistindakan" id="jenistindakan" value="<?php echo $jenistindakan; ?>" required>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalPencarianTindakan">
                                        <i class="ti ti-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4"><label for="kodepoli">Poliklinik</label></div>
                            <div class="col-md-8">
                                <select name="kodepoli" id="kodepoli" class="form-control" required>
                                    <option value="">Pilih</option>
                                    <?php
                                        //Menampilkan 
                                        $QryPoli= mysqli_query($Conn, "SELECT*FROM poliklinik WHERE status='Aktif' ORDER BY nama ASC");
                                        while ($DataPoli = mysqli_fetch_array($QryPoli)) {
                                            $NamaPoliklinikList = $DataPoli['nama'];
                                            $KodePoliklinikList = $DataPoli['kode'];
                                            if($kodepoli==$KodePoliklinikList){
                                                echo '<option selected value="'.$KodePoliklinikList.'">'.$NamaPoliklinikList.'</option>';
                                            }else{
                                                echo '<option value="'.$KodePoliklinikList.'">'.$NamaPoliklinikList.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4"><label for="status">Status jadwal</label></div>
                            <div class="col-md-8">
                                <select name="status" id="status" class="form-control" required>
                                    <option <?php if($terlaksana==0){echo "selected";} ?> value="0">Terdaftar</option>
                                    <option <?php if($terlaksana==1){echo "selected";} ?> value="1">Sudah Dilayani (Selesai)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4"><label for="keterangan">Keterangan</label></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="keterangan" id="keterangan" required value="<?php echo $keterangan; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mt-3" id="NotifikasiEditJadwalOperasi">
                                <span class="text-primary">Pastikan data jadwal operasi yang anda isi sudah benar</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-md btn-primary">
                            <i class="ti ti-save"></i> Simpan
                        </button>
                        <button type="reset" class="btn btn-md btn-dark">
                            <i class="ti-reload"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4><i class="ti ti-info-alt"></i> Informasi Pasien</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ol>
                                <?php
                                    echo '<li>NO.RM : <code class="text-dark">'.$id_pasien.'</code></li>';
                                    echo '<li>Nama Pasien : <code class="text-dark">'.$nama.'</code></li>';
                                    echo '<li>NIK : <code class="text-dark">'.$nik.'</code></li>';
                                    echo '<li>ID.IHS : <code class="text-dark">'.$id_ihs.'</code></li>';
                                    echo '<li>No.BPJS : <code class="text-dark">'.$nopeserta.'</code></li>';
                                    echo '<li>Gender : <code class="text-dark">'.$labelGender.'</code></li>';
                                ?>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>