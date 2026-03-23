<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_antrian
    if(empty($_POST['id_antrian'])){
        $id_antrian=$_POST['id_antrian'];
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          ID Antrian Tidak Boleh Kosong';
        echo '      </div>';
        echo '  </div>';
    }else{
        $GetIdAntrian=$_POST['id_antrian'];
        //Buka data Antrian
        $id_antrian=getDataDetail($Conn,'antrian','id_antrian',$GetIdAntrian,'id_antrian');
        if(empty($id_antrian)){
            echo '  <div class="row">';
            echo '      <div class="col-md-6 mb-3">';
            echo '          ID Antrian Tidak Valid Atau Tidak Ditemukan Pada Database!';
            echo '      </div>';
            echo '  </div>';
        }else{
            $id_kunjungan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'id_kunjungan');
            $no_antrian=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'no_antrian');
            $kodebooking=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kodebooking');
            $id_pasien=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'id_pasien');
            $nama_pasien=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nama_pasien');
            $nomorkartu=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nomorkartu');
            $nik=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nik');
            $notelp=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'notelp');
            $nomorreferensi=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nomorreferensi');
            $jenisreferensi=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'jenisreferensi');
            $jenisrequest=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'jenisrequest');
            $polieksekutif=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'polieksekutif');
            $tanggal_daftar=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'tanggal_daftar');
            $tanggal_kunjungan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'tanggal_kunjungan');
            $jam_kunjungan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'jam_kunjungan');
            $jam_checkin=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'jam_checkin');
            $kode_dokter=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kode_dokter');
            $nama_dokter=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nama_dokter');
            $kodepoli=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kodepoli');
            $namapoli=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'namapoli');
            $kelas=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kelas');
            $keluhan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'keluhan');
            $pembayaran=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'pembayaran');
            $no_rujukan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'no_rujukan');
            $status=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'status');
            $sumber_antrian=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'sumber_antrian');
            $ws_bpjs=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'ws_bpjs');
            //Routing
            if($pembayaran=="UMUM"){
                $jenispasien="NON JKN";
            }else{
                $jenispasien="JKN";
            }
            $pasienbaru=0;
            //Pecahkan jam kunjungan
            $JamPraktek = explode("-", $jam_kunjungan);
            $JamPraktekAwal =$JamPraktek[0];
            $JamPraktekAkhir =$JamPraktek[1];
?>
            <div class="row mb-3"> 
                <div class="col col-md-4">
                    <label for="kodebooking">Kode Booking</label>
                </div>
                <div class="col col-md-8">
                    <input type="text" name="kodebooking" id="kodebooking" class="form-control" value="<?php echo $kodebooking; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col col-md-4">
                    <label for="jenispasien">Jenis pasien</label>
                </div>
                <div class="col col-md-8">
                    <select name="jenispasien" id="jenispasien" class="form-control">
                        <option <?php if($pembayaran=="UMUM"){echo "selected";} ?> value="NON JKN">NON JKN</option>
                        <option <?php if($pembayaran=="BPJS"){echo "selected";} ?> value="JKN">JKN</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col col-md-4">
                    <label for="nik">NIK</label>
                </div>
                <div class="col col-md-8">
                    <input type="text" name="nik" id="nik" class="form-control" value="<?php echo $nik; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col col-md-4">
                    <label for="kodepoli">Kode Poli</label>
                </div>
                <div class="col col-md-8">
                    <input type="text" name="kodepoli" id="kodepoli" class="form-control" value="<?php echo $kodepoli; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col col-md-4">
                    <label for="namapoli">Nama Poli</label>
                </div>
                <div class="col col-md-8">
                    <input type="text" name="namapoli" id="namapoli" class="form-control" value="<?php echo $namapoli; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col col-md-4">
                    <label for="pasienbaru">Pasien Baru?</label>
                </div>
                <div class="col col-md-8">
                    <select name="pasienbaru" id="pasienbaru" class="form-control">
                        <option <?php if($jenisrequest=="0"){echo "selected";} ?> value="0">Tidak</option>
                        <option <?php if($jenisrequest=="1"){echo "selected";} ?> value="1">Ya</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col col-md-4">
                    <label for="norm">No.RM</label>
                </div>
                <div class="col col-md-8">
                    <input type="text" name="norm" id="norm" class="form-control" value="<?php echo $id_pasien; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col col-md-4">
                    <label for="tanggalperiksa">Tanggal Periksa</label>
                </div>
                <div class="col col-md-8">
                    <input type="date" name="tanggalperiksa" id="tanggalperiksa" class="form-control" value="<?php echo $tanggal_kunjungan; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col col-md-4">
                    <label for="kodedokter">Kode Dokter</label>
                </div>
                <div class="col col-md-8">
                    <input type="text" name="kodedokter" id="kodedokter" class="form-control" value="<?php echo $kode_dokter; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col col-md-4">
                    <label for="namadokter">Nama Dokter</label>
                </div>
                <div class="col col-md-8">
                    <input type="text" name="namadokter" id="namadokter" class="form-control" value="<?php echo $nama_dokter; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col col-md-4">
                    <label for="mulai_praktek">Jawal Praktek Awal</label>
                </div>
                <div class="col col-md-4">
                    <input type="date" name="tanggal_praktek_mulai" id="tanggal_praktek_mulai" class="form-control" value="<?php echo $tanggal_kunjungan; ?>">
                    <label for="tanggal_praktek_mulai"><small>Tanggal Mulai</small></label>
                </div>
                <div class="col col-md-4">
                    <input type="time" name="jam_praktek_mulai" id="jam_praktek_mulai" class="form-control" value="<?php echo $JamPraktekAwal; ?>">
                    <label for="jam_praktek_mulai"><small>Jam Mulai</small></label>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col col-md-4">
                    <label for="mulai_praktek">Jawal Praktek Akhir</label>
                </div>
                <div class="col col-md-4">
                    <input type="date" name="tanggal_praktek_akhir" id="tanggal_praktek_akhir" class="form-control" value="<?php echo $tanggal_kunjungan; ?>">
                    <label for="tanggal_praktek_akhir"><small>Tanggal Akhir</small></label>
                </div>
                <div class="col col-md-4">
                    <input type="time" name="jam_praktek_akhir" id="jam_praktek_akhir" class="form-control" value="<?php echo $JamPraktekAkhir; ?>">
                    <label for="jam_praktek_akhir"><small>Jam Mulai</small></label>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col col-md-4">
                    <label for="jeniskunjungan">Jenis Kunjungan</label>
                </div>
                <div class="col col-md-8">
                    <select name="jeniskunjungan" id="jeniskunjungan" class="form-control">
                        <option <?php if($jenisreferensi=="1"){echo "selected";} ?> value="1">Rujukan FKTP</option>
                        <option <?php if($jenisreferensi=="2"){echo "selected";} ?> value="2">Rujukan Internal</option>
                        <option <?php if($jenisreferensi=="3"){echo "selected";} ?> value="3">Kontrol</option>
                        <option <?php if($jenisreferensi=="4"){echo "selected";} ?> value="4">Rujukan Antar RS</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col col-md-4">
                    <label for="nomorreferensi">Nomor Referensi</label>
                </div>
                <div class="col col-md-8">
                    <input type="text" name="nomorreferensi" id="nomorreferensi" class="form-control" value="<?php echo $nomorreferensi; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col col-md-4">
                    <label for="nomorantrean">Nomor Antrian</label>
                </div>
                <div class="col col-md-8">
                    <input type="text" name="nomorantrean" id="nomorantrean" class="form-control" value="<?php echo $no_antrian; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col col-md-4">
                    <label for="angkaantrean">Angka Antrian</label>
                </div>
                <div class="col col-md-8">
                    <input type="text" name="angkaantrean" id="angkaantrean" class="form-control" value="<?php echo $no_antrian; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col col-md-4">
                    <label for="estimasidilayani">Estimasi Dilayani</label>
                </div>
                <div class="col col-md-4">
                    <input type="date" name="tanggal_estimasidilayani" id="tanggal_estimasidilayani" class="form-control" value="<?php echo $tanggal_kunjungan; ?>">
                </div>
                <div class="col col-md-4">
                    <input type="time" name="jam_estimasidilayani" id="jam_estimasidilayani" class="form-control" value="<?php echo $JamPraktekAwal; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col col-md-4">
                    <label for="keterangan">Keterangan</label>
                </div>
                <div class="col col-md-8">
                    <input type="text" name="keterangan" id="keterangan" class="form-control" value="<?php echo $keluhan; ?>">
                </div>
            </div>
<?php }} ?>