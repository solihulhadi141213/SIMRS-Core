<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Kunjungan Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        //Buka Detail Anamnesis
        $id_pasien=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'id_pasien');
        $id_akses=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'id_akses');
        $tanggal=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'tanggal');
        $nama_pasien=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'nama_pasien');
        $nama_petugas=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'nama_petugas');
        $keluhan_utama=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'keluhan_utama');
        $riwayat_penyakit=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_penyakit');
        $riwayat_alergi=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_alergi');
        $riwayat_pengobatan=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_pengobatan');
        $habitus_kebiasaan=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'habitus_kebiasaan');
        //Format Tanggal
        $strtotime=strtotime($tanggal);
        $FormatTanggal=date('Y-m-d', $strtotime);
        $FormatJam=date('H:i', $strtotime);
        //Decode Json
        $JsonNamaPetugas =json_decode($nama_petugas, true);
        $JsonKeluhanUtama =json_decode($keluhan_utama, true);
        $JsonRiwayatPenyakit =json_decode($riwayat_penyakit, true);
        $JsonRiwayatAlergi =json_decode($riwayat_alergi, true);
        $JsonRiwayatPengobatan =json_decode($riwayat_pengobatan, true);
        $JsonHabitusKebiasaan=json_decode($habitus_kebiasaan, true);
        //Petugas
        $PetugasEntry=$JsonNamaPetugas['petugas_entry']['nama'];
        $dokter=$JsonNamaPetugas['dokter']['nama'];
        $perawat=$JsonNamaPetugas['perawat']['nama'];
?>
    <div class="modal-body">
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>A. Informasi Pasien & Kunjungan</dt>
            </div>
            <div class="col-md-4 mb-2">A.1 ID.Kunjungan</div>
            <div class="col-md-8 mb-2">
                <input type="text" readonly name="id_kunjungan" id="id_kunjungan" class="form-control" value="<?php echo "$id_kunjungan"; ?>">
            </div>
            <div class="col-md-4 mb-2">A.2 No.RM</div>
            <div class="col-md-8 mb-2">
                <input type="text" readonly name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$id_pasien"; ?>">
            </div>
            <div class="col-md-4 mb-2">A.3 Nama Pasien</div>
            <div class="col-md-8 mb-2">
                <input type="text" readonly name="nama_pasien" id="nama_pasien" class="form-control" value="<?php echo "$nama_pasien"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>B. Tanggal & Waktu Pencatatan</dt>
            </div>
            <div class="col-md-4 mb-2">B.1 Tanggal</div>
            <div class="col-md-8 mb-2">
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo "$FormatTanggal"; ?>">
            </div>
            <div class="col-md-4 mb-2">B.2 Jam</div>
            <div class="col-md-8 mb-2">
                <input type="time" name="jam" id="jam" class="form-control" value="<?php echo "$FormatJam"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>C. Informasi Petugas/Nakes</dt>
            </div>
            <div class="col-md-4 mb-2">C.1 Petugas Entry</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="petugas_entry" id="petugas_entry" class="form-control" value="<?php echo "$PetugasEntry"; ?>">
            </div>
            <div class="col-md-4 mb-2">C.2 Dokter</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="dokter" id="dokter" class="form-control" value="<?php echo "$dokter"; ?>">
            </div>
            <div class="col-md-4 mb-2">C.2 Perawat</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="perawat" id="perawat" class="form-control" value="<?php echo "$perawat"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiEditAnamnesis">
                <span class="text-primary">Pastikan informasi anamnesa sudah terisi dengan lengkap dan benar.</span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-primary mr-3">
            <i class="ti ti-save"></i> Simpan
        </button>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>