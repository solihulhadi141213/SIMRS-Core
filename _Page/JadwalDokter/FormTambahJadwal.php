<?php
    //koneksi
    include "../../_Config/Connection.php";
?>

<form action="javascript:void(0);" method="POST" id="ProsesTambahJadwal" autocomplete="off">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="hari"><dt>Hari</dt></label>
                <select name="hari" id="hari" class="form-control" required>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                    <option value="Minggu">Minggu</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="jam"><dt>Waktu Mulai</dt></label>
                <input type="time" name="jam1" id="jam1" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="jam"><dt>Waktu Akhir</dt></label>
                <input type="time" name="jam2" id="jam2" class="form-control" required>
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
                            $id_dokter= $DataDokter['id_dokter'];
                            $nama= $DataDokter['nama'];
                            echo '<option value="'.$id_dokter.'">'.$nama.'</option>';
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
                            $id_poliklinik= $DataPoli['id_poliklinik'];
                            $NamaPoli= $DataPoli['nama'];
                            echo '<option value="'.$id_poliklinik.'">'.$NamaPoli.'</option>';
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="kuota"><dt>Kuota Non-JKN</dt></label>
                <input type="number" min="0" name="kuota_non_jkn" id="kuota_non_jkn" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="kuota"><dt>Kuota JKN</dt></label>
                <input type="number" min="0" name="kuota_jkn" id="kuota_jkn" class="form-control" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="kuota"><dt>Pendaftaran Terakhir (Menit)</dt></label>
                <input type="number" min="60" name="time_max" id="time_max" class="form-control" value="720" required>
                <small>Untuk mengetahui berapa menit toleransi waktu pasien dapat mendaftar.</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3" id="NotifikasiTambahJadwal">
                <p class="text-primary">Pastikan data yang anda input sudah benar</p>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <button type="submit" class="btn btn-md btn-inverse mr-2 mt-2"> <i class="ti-save"></i> Simpan</button>
        <button type="button" class="btn btn-md btn-light mr-2 mt-2" data-dismiss="modal"> <i class="ti-close"></i> Tutup</button>
    </div>
</form>