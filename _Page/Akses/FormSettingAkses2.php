<?php
    //Zona waktu dan koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Menangkap data gorup akses
    if(empty($_POST['AksesGroup'])){
        $NamaGroupAkses="";
        $JumlahIjin="";
        $IjinAksesibilitas="";
        $IjinProfileSekolah="";
        $IjinPersonalisasi="";
    }else{
        $NamaGroupAkses=$_POST['AksesGroup'];
        $JumlahIjin=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_ijin WHERE akses='$NamaGroupAkses'"));
        //Buka nama akses satu persatu
        $IjinAksesibilitas=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_ijin WHERE akses='$NamaGroupAkses' AND aksesibilitas='Ya'"));
        $IjinProfileSekolah=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_ijin WHERE akses='$NamaGroupAkses' AND ProfileSekolah='Ya'"));
        $IjinPersonalisasi=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_ijin WHERE akses='$NamaGroupAkses' AND Personalisasi='Ya'"));
    }
?>
<div class="row">
    <div class="col col-md-4 mt-3 text-info">
        2. Pengaturan
        <input type="hidden" name="NamaGroupAkses" value="<?php echo "$NamaGroupAkses";?>">
    </div>
</div> 
<div class="row">
    <div class="col col-md-4 mt-3">
        <select class="form-control" name="aksesibilitas" id="aksesibilitas" required>
            <option <?php if(empty($IjinAksesibilitas)){echo "selected";} ?> value="No">Tidak</option>
            <option <?php if(!empty($IjinAksesibilitas)){echo "selected";} ?> value="Ya">Ya</option>
        </select>
        <span>Ijin Halaman Aksesibilitas</span>
    </div>
    <div class="col col-md-4 mt-3">
        <select class="form-control" name="ProfileSekolah" id="ProfileSekolah" required>
            <option <?php if(empty($IjinProfileSekolah)){echo "selected";} ?> value="No">Tidak</option>
            <option <?php if(!empty($IjinProfileSekolah)){echo "selected";} ?> value="Ya">Ya</option>
        </select>
        <span>Ijin Halaman Profile Faskes</span>
    </div>
    <div class="col col-md-4 mt-3">
        <select class="form-control" name="Personalisasi" id="Personalisasi" required>
            <option <?php if(empty($IjinPersonalisasi)){echo "selected";} ?> value="No">Tidak</option>
            <option <?php if(!empty($IjinPersonalisasi)){echo "selected";} ?> value="Ya">Ya</option>
        </select>
        <span>Ijin Halaman Personalisasi</span>
    </div>
</div>    
<div class="row">
    <div class="col col-md-12 mb-3 mt-3 text-info" id="NotifikasiSettingAkses">
        Pastikan pengaturan yang anda pilih sudah sesuai dan pilih tombol simpan.<br>
    </div>
</div>
