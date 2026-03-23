<form action="javascript:void(0);" method="POST" id="ProsesPendaftaranOnline" autocomplete="off">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mt-4">
                <label for="nik"><dt>No.KTP (NIK)</dt></label>
                <input type="text" name="nik" id="nik" class="form-control">
            </div>
            <div class="col-md-4 mt-4">
                <label for="nomorkartu"><dt>No.BPJS</dt></label>
                <input type="text" name="nomorkartu" id="nomorkartu" class="form-control">
            </div>
            <div class="col-md-4 mt-4">
                <label for="nik"><dt>Nama Lengkap</dt></label>
                <input type="text" name="nama" id="nama" class="form-control">
                <small id="NotifikasiPasien">Nama lengkap pasien</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mt-4">
                <label for="notelp"><dt>No.Kontak</dt></label>
                <input type="text" name="notelp" id="notelp" class="form-control">
            </div>
            <div class="col-md-4 mt-4">
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
            <div class="col-md-4 mt-4">
                <label for="dokter"><dt>Dokter</dt></label>
                <select name="dokter" id="dokter" class="form-control">
                    <option value="">Pilih</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mt-4">
                <label for="tanggal"><dt>Tgl.Kunjungan</dt></label>
                <input type="date" name="tanggal" id="tanggal" class="form-control">
            </div>
            <div class="col-md-4 mt-4">
                <label for="jam"><dt>Jam Kunjungan</dt></label>
                <select name="jam" id="jam" class="form-control">
                    <option value="">Pilih</option>
                </select>
            </div>
            <div class="col-md-4 mt-4">
                <label for="nik"><dt>Keluhan/Tujuan Kunjungan</dt></label>
                <input type="keluhan" name="keluhan" id="keluhan" class="form-control">
            </div>
        </div>
        <div class="row m-t-25 text-left">
            <div class="col-12" id="NotifikasiPendaftaranOnline">
                <span class="text-info">Pastikan data pendaftaran yang anda masukan sudah benar.</span>
            </div>
        </div>
        <div class="row m-t-30">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Simpan Pendaftaran</button>
            </div>
        </div>
        
    </div>
</form>