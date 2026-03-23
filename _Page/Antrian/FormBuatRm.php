<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_antrian
    if(empty($_POST['id_antrian'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          ID Antrian Tidak Boleh Kosong';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_antrian=$_POST['id_antrian'];
        // Mempersiapkan statement SQL
        $QryParam = $Conn->prepare("SELECT * FROM antrian WHERE id_antrian = ?");
        // Mengikat parameter ke statement
        $QryParam->bind_param("s", $id_antrian);
        // Menjalankan query
        $QryParam->execute();
        // Mendapatkan hasil query
        $result = $QryParam->get_result();
        // Memeriksa apakah data ditemukan
        if ($DataParam = $result->fetch_assoc()) {
            $no_antrian = isset($DataParam['no_antrian']) ? $DataParam['no_antrian'] : null;
            $kodebooking = isset($DataParam['kodebooking']) ? $DataParam['kodebooking'] : null;
            $id_pasien = isset($DataParam['id_pasien']) ? $DataParam['id_pasien'] : null;
            $nama_pasien = isset($DataParam['nama_pasien']) ? $DataParam['nama_pasien'] : null;
            $nomorkartu = isset($DataParam['nomorkartu']) ? $DataParam['nomorkartu'] : null;
            $nik = isset($DataParam['nik']) ? $DataParam['nik'] : null;
            $notelp = isset($DataParam['notelp']) ? $DataParam['notelp'] : null;
            $tanggal_daftar = isset($DataParam['tanggal_daftar']) ? $DataParam['tanggal_daftar'] : null;
            $tanggal_kunjungan = isset($DataParam['tanggal_kunjungan']) ? $DataParam['tanggal_kunjungan'] : null;
            $jam_kunjungan = isset($DataParam['jam_kunjungan']) ? $DataParam['jam_kunjungan'] : null;
            $jam_checkin = isset($DataParam['jam_checkin']) ? $DataParam['jam_checkin'] : null;
            $kode_dokter = isset($DataParam['kode_dokter']) ? $DataParam['kode_dokter'] : null;
            //Format Tanggal Daftar
            if(!empty($tanggal_daftar)){
                $strtotime=strtotime($tanggal_daftar);
                $TanggalDaftar=date('Y-m-d',$strtotime);
                $JamDaftar=date('H:i:s',$strtotime);
            }else{
                $TanggalDaftar=date('Y-m-d');
                $JamDaftar=date('H:i:s');
            }
?>
        <input type="hidden" name="id_antrian" value="<?php echo $id_antrian; ?>">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_pasien">1. Nomor RM</label>
            </div>
            <div class="col-md-8">
                <div class="input-group">
                    <input type="text" class="form-control" name="id_pasien" id="GetIdpasien">
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="ReloadIdPasien">
                        <i class="ti ti-reload"></i> Generate
                    </button>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_pasien">2. Nomor KTP (NIK)</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" name="nik" id="nik" value="<?php echo $nik; ?>">
                <?php
                    //Apabila NIK ada maka sistem melakukan pengecekan ke data pasien
                    if(!empty($nik)){
                        $id_pasien_validasi=getDataDetail_v2($Conn,'pasien','nik',$nik,'id_pasien');
                        if(!empty($id_pasien_validasi)){
                            echo '<small class="text-danger">NIK tersebut sudah terdaftar pada SIMRS dengan ID '.$id_pasien_validasi.'</small>';
                        }
                    }
                ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="no_bpjs">3. Nomor Kartu BPJS</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" name="no_bpjs" id="no_bpjs" value="<?php echo $nomorkartu; ?>">
                <?php
                    //Apabila Nomor Kartu BPJS ada maka sistem melakukan pengecekan ke data pasien
                    if(!empty($nomorkartu)){
                        $id_pasien_validasi2=getDataDetail_v2($Conn,'pasien','no_bpjs',$nomorkartu,'id_pasien');
                        if(!empty($id_pasien_validasi2)){
                            echo '<small class="text-danger">Nomor Kartu BPJS tersebut sudah terdaftar pada SIMRS dengan ID '.$id_pasien_validasi2.'</small>';
                        }
                    }
                ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_pasien">4. Nomor IHS</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" name="id_ihs" id="id_ihs">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="tanggal_daftar">5. Tanggal Daftar</label>
            </div>
            <div class="col-md-8">
                <input type="date" name="tanggal_daftar" id="tanggal_daftar" class="form-control" value="<?php echo $TanggalDaftar; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="tanggal_daftar">6. Jam Daftar</label>
            </div>
            <div class="col-md-8">
                <input type="time" name="jam_daftar" id="jam_daftar" value="<?php echo date ('H:i'); ?>" class="form-control" value="<?php echo $JamDaftar; ?>">
            </div>
        </div>
        <h4 class="sub-title"><dt>Data Diri Pasien</dt></h4>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="nama">1. Nama Pasien (Sesuai Identitas)</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $nama_pasien; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="gender">2. Gender</label>
            </div>
            <div class="col-md-8">
                <select id="gender" name="gender" class="form-control" >
                    <option value="">Pilih</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="tempat_lahir">3. Tempat Lahir</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="tempat_lahir">4. Tanggal Lahir</label>
            </div>
            <div class="col-md-8">
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="golongan_darah">5. Golongan Darah</label>
            </div>
            <div class="col-md-8">
                <select id="golongan_darah" name="golongan_darah" class="form-control">
                    <option value="">Pilih</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="perkawinan">6. Status Pernikahan</label>
            </div>
            <div class="col-md-8">
                <select id="perkawinan" name="perkawinan" class="form-control">
                    <option value="">Pilih</option>
                    <option value="Lajang">Lajang</option>
                    <option value="Menikah">Menikah</option>
                    <option value="Janda">Janda</option>
                    <option value="Duda">Duda</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="pekerjaan">7. Pekerjaan</label>
            </div>
            <div class="col-md-8">
                <select id="pekerjaan" name="pekerjaan" class="form-control">
                    <option value="">Pilih</option>
                    <option value="Tidak Bekerja">Tidak Bekerja</option>
                    <option value="Karyawan Swasta">Karyawan Swasta</option>
                    <option value="PNS">PNS/TNI/Polri</option>
                    <option value="Wirausaha">Wirausaha</option>
                </select>
            </div>
        </div>
        <h4 class="sub-title"><dt>Alamat & Kontak</dt></h4>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="propinsi">1. Provinsi</label>
            </div>
            <div class="col-md-8">
                <select id="propinsi" name="propinsi" class="form-control">
                    <option value="">Pilih</option>
                    <?php
                        //Arraykan propinsi
                        $QryPropinsi = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Propinsi' ORDER BY propinsi ASC");
                        while ($DataPropinsi = mysqli_fetch_array($QryPropinsi)) {
                            $propinsi= $DataPropinsi['propinsi'];
                            echo '<option value="'.$propinsi.'">'.$propinsi.'</option>';
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="propinsi">2. Kabupaten/Kota</label>
            </div>
            <div class="col-md-8">
                <select id="kabupaten" name="kabupaten" class="form-control">
                    <option value="">Pilih</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="kecamatan">3. Kecamatan</label>
            </div>
            <div class="col-md-8">
                <select id="kecamatan" name="kecamatan" class="form-control">
                    <option value="">Pilih</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="desa">4. Desa/Kelurahan</label>
            </div>
            <div class="col-md-8">
                <select id="desa" name="desa" class="form-control">
                    <option value="">Pilih</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="alamat">5. RT/RW Jalan</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="alamat" id="alamat" class="form-control" >
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="kontak">6. Kontak Pasien</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="kontak" id="kontak" class="form-control" placeholder="+62" value="<?php echo $notelp; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="kontak_darurat">7. Kontak Darurat</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="kontak_darurat" id="kontak_darurat" class="form-control" placeholder="+62">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="alamat">8. Penanggung Jawab</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="penanggungjawab" id="penanggungjawab" class="form-control">
                <small>Saran: Nama pemilik nomor darurat</small>
            </div>
        </div>
<?php 
        }else{
            echo '  <div class="row">';
            echo '      <div class="col-md-6 mb-3">';
            echo '          ID Antrian Tidak Valid Atau Tidak Ditemukan Pada Database!';
            echo '      </div>';
            echo '  </div>';
        }
        // Menutup statement
        $QryParam->close();
    } 
?>
<script>
    //Reload ID Pasien
    $('#ReloadIdPasien').click(function(){
        $('#NotifikasiIdPasien').html("Loading..");
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/Pasien/ReloadIdPasien.php',
            success : function(data){
                $('#GetIdpasien').val(data.replace(/\s/g, ''));
                $('#NotifikasiIdPasien').html("<i class='text-info'>Reload Selesai</i>");
            }
        });
    });
    //propinsi
    $('#propinsi').change(function(){
        $('#desa').html("<option>Pilih</option>");
        $('#kecamatan').html("<option>Pilih</option>");
        $('#kabupaten').html("<option>Loading..</option>");
        var propinsi = $('#propinsi').val();
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/Pasien/PilihKabupaten.php',
            data 	:  'propinsi='+ propinsi,
            success : function(data){
                $('#kabupaten').html(data);
            }
        });
    });
    //Kabupaten
    $('#kabupaten').change(function(){
        $('#desa').html("<option>Pilih</option>");
        $('#kecamatan').html("<option>Loading..</option>");
        var kabupaten = $('#kabupaten').val();
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/Pasien/PilihKecamatan.php',
            data 	:  'kabupaten='+ kabupaten,
            success : function(data){
                $('#kecamatan').html(data);
            }
        });
    });
    //Kecamatan
    $('#kecamatan').change(function(){
        $('#desa').html("<option>Loading..</option>");
        var kecamatan = $('#kecamatan').val();
        $.ajax({
            type 	: 'POST',
            url 	: '_Page/Pasien/PilihDesa.php',
            data 	:  'kecamatan='+ kecamatan,
            success : function(data){
                $('#desa').html(data);
            }
        });
    });
</script>