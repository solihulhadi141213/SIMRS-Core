<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_dokter
    if(empty($_POST['id_dokter'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center text-danger">';
        echo '      ID Dokter Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_dokter=$_POST['id_dokter'];
        $kode=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'kode');
        if(empty($kode)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center text-danger">';
            echo '      ID Dokter Tersebut Tidak Valid Atau Tidak Terdaftar!';
            echo '  </div>';
            echo '</div>';
        }else{
            //Buka data Pasien
            $id_ihs_practitioner=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'id_ihs_practitioner');
            $nama=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'nama');
            $kategori=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'kategori');
            $kategori_identitas=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'kategori_identitas');
            $no_identitas=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'no_identitas');
            $alamat=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'alamat');
            $kontak=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'kontak');
            $email=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'email');
            $SIP=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'SIP');
            $status=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'status');
            $foto=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'foto');
?>
    <input type="hidden" name="id_dokter" value="<?php echo "$id_dokter"; ?>">
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="kode"><dt>Kode</dt></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="kode" id="kode" class="form-control" value="<?php echo "$kode"; ?>" required>
            <small>Kode sesuai HAFIS atau bisa sesuai standar faskes</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="id_ihs_practitioner"><dt>ID IHS</dt></label>
        </div>
        <div class="col-md-8">
            <select name="id_ihs_practitioner" id="id_ihs_practitioner" class="form-control">
                <option value="">Pilih</option>
                <?php
                    $query = mysqli_query($Conn, "SELECT*FROM referensi_practitioner ORDER BY nama ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $IdIhsPractitionerList= $data['id_ihs_practitioner'];
                        $ListKategori= $data['kategori'];
                        $NamaPractitioner= $data['nama'];
                        if($id_ihs_practitioner==$IdIhsPractitionerList){
                            echo '<option selected value="'.$IdIhsPractitionerList.'">'.$NamaPractitioner.'</option>';
                        }else{
                            echo '<option value="'.$IdIhsPractitionerList.'">'.$NamaPractitioner.'</option>';
                        }
                    }
                ?>
            </select>
            <small>ID practitioner yang sesuai dengan platform satu sehat atau SISDMK (Apabila Ada)</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="nama"><dt>Nama Lengkap</dt></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="nama" id="nama" class="form-control" value="<?php echo "$nama"; ?>" required>
            <small>Nama lengkap diikuti gelar</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="kategori"><dt>Spesialis/Profesi</dt></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo "$kategori"; ?>" required>
            <small>
                Ex : Spesialis Anak, Spesialis Penyakit Dalam, Radiografer, Analis Laboratorium
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="kategori_identitas"><dt>Kategori Identitas</dt></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="kategori_identitas" id="kategori_identitas" class="form-control" value="<?php echo "$kategori_identitas"; ?>" required>
            <small>Ex: KTP, KK, Passport Dll.</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="no_identitas"><dt>Nomor Identitas</dt></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="no_identitas" id="no_identitas" class="form-control" value="<?php echo "$no_identitas"; ?>" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="alamat"><dt>Alamat</dt></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo "$alamat"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="kontak"><dt>Nomor Kontak (HP)</dt></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="kontak" id="kontak" class="form-control" placeholder="62" value="<?php echo "$kontak"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="email"><dt>Alamat Email</dt></label>
        </div>
        <div class="col-md-8">
            <input type="email" name="email" id="email" class="form-control" placeholder="email@domain.com" value="<?php echo "$email"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="SIP"><dt>SIP/Nomor Registrasi</dt></label>
        </div>
        <div class="col-md-8">
            <input type="text" name="SIP" id="SIP" class="form-control" value="<?php echo "$SIP"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="foto"><dt>Foto</dt></label>
        </div>
        <div class="col-md-8">
            <input type="file" name="foto" id="foto" class="form-control">
            <small>Maksimal file 2 mb (jpg, jpeg, png, gif)</small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="status"><dt>Status</dt></label>
        </div>
        <div class="col-md-8">
            <select id="status" name="status" class="form-control" required>
                <option <?php if($status=="Aktiv"){echo "selected";} ?> value="Aktiv">Aktiv</option>
                <option <?php if($status=="Non-Aktiv"){echo "selected";} ?> value="Non-Aktiv">Non-Aktiv</option>
                <option <?php if($status=="Cuti"){echo "selected";} ?> value="Cuti">Cuti</option>
            </select>
        </div>
    </div>
<?php }} ?>