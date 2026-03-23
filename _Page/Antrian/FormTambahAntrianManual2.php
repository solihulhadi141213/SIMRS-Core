<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Menangkap id_pasien
    if(!empty($_POST['id_pasien'])){
        $id_pasien = $_POST['id_pasien'];
        //Buka data pasien
        $query = mysqli_query($Conn, "SELECT*FROM pasien WHERE id_pasien='$id_pasien'");
        $data = mysqli_fetch_array($query);
        $id_pasien = $data['id_pasien'];
        $nama = $data['nama'];
        $nik = $data['nik'];
        $no_bpjs = $data['no_bpjs'];
        $kontak = $data['kontak'];

    }else{
        $id_pasien = "";
    }
?>
<script type="text/javascript" >
    $(document).ready(function(){
        
    });
</script>
<form action="javascript:void(0);" id="ProsesTambahAntrianManual" autocomplete="off">
    <div class="modal-body">   
        <div class="row">
            <div class="col-md-6 mt-2">
                <label for="nik"><dt>Metode Pembayaran</dt></label>
                <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                    <option value="">Pilih</option>
                    <option value="BPJS">BPJS</option>
                    <option value="UMUM">UMUM</option>
                </select>
            </div>
            <div class="col-md-6 mt-2">
                <label for="nik"><dt>No.RM</dt></label>
                <input type="text" readonly name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$id_pasien";?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-2">
                <label for="nik"><dt>No.KTP (NIK)</dt></label>
                <input type="text" name="nik" id="nik" class="form-control" value="<?php echo $nik;?>">
            </div>
            <div class="col-md-6 mt-2">
                <label for="nik"><dt>No.BPJS</dt></label>
                <input type="text" readonly name="nomorkartu" id="nomorkartu" class="form-control" value="<?php echo $no_bpjs;?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-2">
                <label for="nik"><dt>Nama Lengkap</dt></label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $nama;?>" required>
                <small id="NotifikasiPasien">Nama lengkap pasien</small>
            </div>
            <div class="col-md-6 mt-2">
                <label for="notelp"><dt>No.Kontak</dt></label>
                <input type="text" name="notelp" id="notelp" class="form-control" value="<?php echo $kontak;?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-2">
                <label for="poliklinik"><dt>Poliklinik</dt></label>
                <select name="poliklinik" id="poliklinik" class="form-control">
                    <option value="">Pilih</option>
                    <?php 
                        //select option poliklinik
                        $sql = "SELECT * FROM poliklinik";
                        $result = mysqli_query($Conn, $sql);
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<option value='$row[id_poliklinik]'>$row[nama]</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-6 mt-2">
                <label for="dokter"><dt>Dokter</dt></label>
                <select name="dokter" id="dokter" class="form-control">
                    <option value="">Pilih</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-2">
                <label for="tanggal"><dt>Tgl.Rencana Kunjungan</dt></label>
                <input type="date" name="tanggal1" id="tanggal1" class="form-control">
            </div>
            <div class="col-md-6 mt-2">
                <label for="jam"><dt>Jam Kunjungan</dt></label>
                <select name="jam" id="jam" class="form-control">
                    <option value="">Pilih</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-2">
                <label for="nik"><dt>Keluhan/Tujuan Kunjungan</dt></label>
                <input type="keluhan" name="keluhan" id="keluhan" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-2">
                <label for="jeniskunjungan"><dt>Jenis Kunjungan</dt></label>
                <select disabled name="jeniskunjungan" id="jeniskunjungan" class="form-control">
                    <option value="">Pilih</option>
                    <option value="1">Rujukan FKTP</option>
                    <option value="2">Rujukan Internal</option>
                    <option value="3">Kontrol</option>
                    <option value="4">Rujukan Antar RS</option>
                </select>
            </div>
            <div class="col-md-6 mt-2">
                <label for="nomorreferensi"><dt>No.Referensi</dt></label>
                <input type="text" disabled name="nomorreferensi" id="nomorreferensi" class="form-control">
            </div>
        </div>
        <div class="row m-t-25 text-left">
            <div class="col-12" id="NotifikasTambahAntrianManual">
                <span class="text-info">Pastikan data pendaftaran yang anda masukan sudah benar.</span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col col-md col-12 text-center">
                <button type="submit" class="btn btn-sm btn-primary mt-2 mr-2">
                    <i class="fa fa-save"></i> Simpan
                </button>
                <button type="button" class="btn btn-sm btn-danger mt-2 mr-2" data-dismiss="modal">
                    <i class="fa fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</form>