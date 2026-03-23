<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
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
<form action="javascript:void(0);" id="ProsesTambahJadwalOperasi">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-4 mt-3">
                <label for="id_pasien"><dt>No.RM</dt></label>
                <input type="text" class="form-control" name="id_pasien" id="id_pasien" data-toggle="modal" data-target="#ModalPasien" required>
            </div>
            <div class="col-md-4 mt-3">
                <label for="id_pasien"><dt>Nama Pasien</dt></label>
                <input type="text" class="form-control" name="nama" id="nama" data-toggle="modal" data-target="#ModalPasien" required>
            </div>
            <div class="col-md-4 mt-3">
                <label for="id_pasien"><dt>No.Kartu</dt></label>
                <input type="text" class="form-control" name="nopeserta" id="nopeserta" data-toggle="modal" data-target="#ModalPasien" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mt-3">
                <label for="tanggaloperasi"><dt>Tanggal Operasi</dt></label>
                <input type="date" class="form-control" name="tanggaloperasi" id="tanggaloperasi" required>
            </div>
            <div class="col-md-4 mt-3">
                <label for="jamoperasi"><dt>Jam Operasi</dt></label>
                <input type="time" class="form-control" name="jamoperasi" id="jamoperasi" required>
            </div>
            <div class="col-md-4 mt-3">
                <label for="jenistindakan"><dt>Jenis Tindakan</dt></label>
                <input type="text" class="form-control" name="jenistindakan" id="jenistindakan" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mt-3">
                <label for="kodepoli"><dt>Kode Poli</dt></label>
                <input type="text" class="form-control" name="kodepoli" id="kodepoli" data-toggle="modal" data-target="#ModalPilihPoli" required>
            </div>
            <div class="col-md-4 mt-3">
                <label for="namapoli"><dt>Nama Poli</dt></label>
                <input type="text" class="form-control" name="namapoli" id="namapoli" data-toggle="modal" data-target="#ModalPilihPoli" required>
            </div>
            <div class="col-md-4 mt-3">
                <label for="namapoli"><dt>Status</dt></label>
                <select name="status" id="status" class="form-control" required>
                    <option value="0">Terdaftar</option>
                    <option value="1">Sudah Dilayani (Selesai)</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mt-3">
                <label for="keterangan"><dt>Keterangan</dt></label>
                <input type="text" class="form-control" name="keterangan" id="keterangan" required>
            </div>
            <div class="col-md-4 mt-3">
                <label for="kodebooking"><dt>Kode Booking</dt></label>
                <input type="text" class="form-control" name="kodebooking" id="kodebooking" value="<?php echo "$KodeBooking";?>" required>
                <small class="text-primary">Kode ini diperoleh dari sistem</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mt-3" id="NotifikasiTambahJadwalOperasi">
                <span class="text-primary">Pastikan data jadwal operasi yang anda isi sudah benar</span>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <button type="submit" class="btn btn-md btn-inverse btn-round">
            <i class="ti ti-save"></i> Simpan
        </button>
        <button type="button" class="btn btn-md btn-danger btn-round" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
</form>