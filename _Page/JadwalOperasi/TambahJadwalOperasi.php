<?php 
    if(!empty($_GET['id_pasien'])){ 
        $id_pasien=$_GET['id_pasien'];
        //Buka Detail Pasien
        $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$id_pasien'")or die(mysqli_error($Conn));
        $DataPasien = mysqli_fetch_array($QryPasien);
        if(!empty($DataPasien['id_ihs'])){
            $id_ihs= $DataPasien['id_ihs'];
        }else{
            $id_ihs='<span class="text-danger">Tidak Ada</span>';
        }
        if(!empty($DataPasien['nik'])){
            $nik= $DataPasien['nik'];
        }else{
            $nik='<span class="text-danger">Tidak Ada</span>';
        }
        if(!empty($DataPasien['no_bpjs'])){
            $no_bpjs= $DataPasien['no_bpjs'];
        }else{
            $no_bpjs='<span class="text-danger">Tidak Ada</span>';
        }
        $nama= $DataPasien['nama'];
        if(!empty($DataPasien['gender'])){
            $gender= $DataPasien['gender'];
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
            $gender="";
            $labelGender='<span class="text-danger">Tidak Diketahui</span>';
        }
        //Generate Kode Booking
        //Nilai paling besar
        $max = "SELECT MAX(id_operasi ) AS max FROM jadwal_operasi";
        //Query
        $hasil = mysqli_query($Conn,$max);
        //Mengambil data
        $data = mysqli_fetch_array($hasil);
        //Menjadikan data
        $id_operasi = $data['max'];
        $IdOperasiBaru=$id_operasi+1;
        //zero padding
        $IdOperasiBaru = sprintf("%03s", $IdOperasiBaru);
        //zero padding for $SessionIdAkses
        $SessionIdAksesBaru = sprintf("%03s", $SessionIdAkses);
        $KodeBooking="$SessionIdAksesBaru$IdOperasiBaru";
?>
    <div class="row">
        <div class="col-xl-8 col-md-8">
            <div class="card">
                <form action="javascript:void(0);" id="ProsesTambahJadwalOperasi">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10 mb-3">
                                <h4><i class="icofont-ui-calendar"></i> Form Tambah Jadwal Operasi</h4>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a href="index.php?Page=JadwalOperasi" class="btn btn-sm btn-dark btn-round btn-block">
                                    <i class="ti ti-angle-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4"><label for="kodebooking">Kode Booking</label></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="kodebooking" id="kodebooking" value="<?php echo "$KodeBooking";?>" required>
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
                                <input type="text" readonly class="form-control" name="nopeserta" id="nopeserta" value="<?php echo $DataPasien['no_bpjs']; ?>" required>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4"><label for="tanggaloperasi">Tanggal Operasi</label></div>
                            <div class="col-md-4">
                                <input type="date" class="form-control" name="tanggaloperasi" id="tanggaloperasi" value="<?php echo date('Y-m-d'); ?>" required>
                                <small><label for="tanggaloperasi">Tanggal</label></small>
                            </div>
                            <div class="col-md-4">
                                <input type="time" class="form-control" name="jamoperasi" id="jamoperasi" value="<?php echo date('H:i'); ?>" required>
                                <small><label for="jamoperasi">Jam Operasi</label></small>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4"><label for="jenistindakan">Jenis Tindakan</label></div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="jenistindakan" id="jenistindakan" required>
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
                                            $NamaPoliklinik = $DataPoli['nama'];
                                            $KodePoliklinik = $DataPoli['kode'];
                                            echo '<option value="'.$KodePoliklinik.'">'.$NamaPoliklinik.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4"><label for="status">Status jadwal</label></div>
                            <div class="col-md-8">
                                <select name="status" id="status" class="form-control" required>
                                    <option value="0">Terdaftar</option>
                                    <option value="1">Sudah Dilayani (Selesai)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4"><label for="keterangan">Keterangan</label></div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="keterangan" id="keterangan" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mt-3" id="NotifikasiTambahJadwalOperasi">
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
                                    echo '<li>No.BPJS : <code class="text-dark">'.$no_bpjs.'</code></li>';
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