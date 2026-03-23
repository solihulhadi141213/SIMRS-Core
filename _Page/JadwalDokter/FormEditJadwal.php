<?php
    //koneksi
    include "../../_Config/Connection.php";
    //Menangkap id_jadwal
    if(empty($_POST['id_jadwal'])){
        echo "ID Tidak Bisa Ditangkap";
    }else{
        $id_jadwal=$_POST['id_jadwal'];
        //Membuka jadwal
        $QryJadwal = mysqli_query($Conn,"SELECT * FROM jadwal_dokter WHERE id_jadwal='$id_jadwal'")or die(mysqli_error($Conn));
        $DtaaJadwal = mysqli_fetch_array($QryJadwal);
        $id_dokter= $DtaaJadwal['id_dokter'];
        $id_poliklinik= $DtaaJadwal['id_poliklinik'];
        $dokter= $DtaaJadwal['dokter'];
        $poliklinik= $DtaaJadwal['poliklinik'];
        $hari= $DtaaJadwal['hari'];
        $jam= $DtaaJadwal['jam'];
        $kuota_non_jkn= $DtaaJadwal['kuota_non_jkn'];
        $kuota_jkn= $DtaaJadwal['kuota_jkn'];
        $time_max= $DtaaJadwal['time_max'];
        $Pecah = explode("-" , $jam);
        $JamAwal=$Pecah['0'];
        $JamAkhir=$Pecah['1'];
?>

<form action="javascript:void(0);" method="POST" id="ProsesEditJadwalDokter" autocomplete="off">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="hari"><dt>ID Jadwal</dt></label>
                <input type="text" readonly name="id_jadwal" id="id_jadwal" class="form-control" value="<?php echo "$id_jadwal"; ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="hari"><dt>Hari</dt></label>
                <select name="hari" id="hari" class="form-control" required>
                    <option <?php if($hari=="Senin"){echo "selected";} ?> value="Senin">Senin</option>
                    <option <?php if($hari=="Selasa"){echo "selected";} ?> value="Selasa">Selasa</option>
                    <option <?php if($hari=="Rabu"){echo "selected";} ?> value="Rabu">Rabu</option>
                    <option <?php if($hari=="Kamis"){echo "selected";} ?> value="Kamis">Kamis</option>
                    <option <?php if($hari=="Jumat"){echo "selected";} ?> value="Jumat">Jumat</option>
                    <option <?php if($hari=="Sabtu"){echo "selected";} ?> value="Sabtu">Sabtu</option>
                    <option <?php if($hari=="Minggu"){echo "selected";} ?> value="Minggu">Minggu</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="jam"><dt>Waktu Mulai</dt></label>
                <input type="time" name="jam1" id="jam1" class="form-control" value="<?php echo "$JamAwal"; ?>" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="jam"><dt>Waktu Akhir</dt></label>
                <input type="time" name="jam2" id="jam2" class="form-control" value="<?php echo "$JamAkhir"; ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="id_dokter"><dt>Dokter</dt></label>
                <select name="id_dokter" id="id_dokter" class="form-control" required>
                    <option value="">Pilih</option>
                    <?php
                        //Menampilkan data dokter
                        $QryDokter= mysqli_query($Conn, "SELECT*FROM dokter ORDER BY nama ASC");
                        while ($DataDokter = mysqli_fetch_array($QryDokter)) {
                            $IdDokter= $DataDokter['id_dokter'];
                            $namaDokter= $DataDokter['nama'];
                            if($id_dokter==$IdDokter){
                                echo '<option selected value="'.$IdDokter.'">'.$namaDokter.'</option>';
                            }else{
                                echo '<option value="'.$IdDokter.'">'.$namaDokter.'</option>';
                            }
                            
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="id_poliklinik"><dt>Poliklinik</dt></label>
                <select name="id_poliklinik" id="id_poliklinik" class="form-control" required>
                    <option value="">Pilih</option>
                    <?php
                        //Menampilkan data dokter
                        $QryPoli= mysqli_query($Conn, "SELECT*FROM poliklinik ORDER BY nama ASC");
                        while ($DataPoli = mysqli_fetch_array($QryPoli)) {
                            $IdPoliklinik= $DataPoli['id_poliklinik'];
                            $NamaPoli= $DataPoli['nama'];
                            if($id_poliklinik==$IdPoliklinik){
                                echo '<option selected value="'.$IdPoliklinik.'">'.$NamaPoli.'</option>';
                            }else{
                                echo '<option value="'.$IdPoliklinik.'">'.$NamaPoli.'</option>';
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="kuota"><dt>Kuota Non-JKN</dt></label>
                <input type="number" min="0" name="kuota_non_jkn" id="kuota_non_jkn" class="form-control" value="<?php echo "$kuota_non_jkn"; ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="kuota"><dt>Kuota JKN</dt></label>
                <input type="number" min="0" name="kuota_jkn" id="kuota_jkn" class="form-control" value="<?php echo "$kuota_jkn"; ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="kuota"><dt>Pendaftaran Terakhir (Menit)</dt></label>
                <input type="number" min="60" name="time_max" id="time_max" class="form-control" value="<?php echo "$time_max"; ?>" required>
                <small>Untuk mengetahui berapa menit toleransi waktu pasien dapat mendaftar.</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3" id="NotifikasiEditJadwal">
                <p class="text-primary">Pastikan data yang anda input sudah benar</p>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <button type="submit" class="btn btn-md btn-inverse mr-2 mt-2"> <i class="ti-save"></i> Simpan</button>
        <button type="button" class="btn btn-md btn-danger mr-2 mt-2" data-toggle="modal" data-target="#ModalDeleteJadwalDokter"> <i class="ti-trash"></i> Hapus</button>
        <button type="button" class="btn btn-md btn-light mr-2 mt-2" data-dismiss="modal"> <i class="ti-close"></i> Tutup</button>
    </div>
</form>
<?php } ?>