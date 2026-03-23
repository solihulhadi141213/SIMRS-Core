<?php
    include "../../_Config/Connection.php";
    //Menangkap id apabila ada
    if(!empty($_POST['id_dokter'])){
        $id_dokter=$_POST['id_dokter'];
        //Buka data dokter dari simrs
        //Buka data Pasien
        $QryPasien = mysqli_query($Conn,"SELECT * FROM dokter WHERE id_dokter='$id_dokter'")or die(mysqli_error($Conn));
        $DataDokter = mysqli_fetch_array($QryPasien);
        if(!empty($DataDokter['id_dokter'])){
            $kode= $DataDokter['kode'];
            $nama= $DataDokter['nama'];
            $spesialis= $DataDokter['kategori'];
            $alamat= $DataDokter['alamat'];
            $kontak= $DataDokter['kontak'];
            $email= $DataDokter['email'];
            $status= $DataDokter['status'];
        }else{
            $kode="";
            $nama="";
            $spesialis="";
            $alamat="";
            $kontak="";
            $email="";
            $status="";
        }
    }else{
        $id_dokter="";
        $kode="";
        $nama="";
        $spesialis="";
        $alamat="";
        $kontak="";
        $email="";
        $status="";
    }
?>
<div class="row">
    <div class="col-md-12 mb-3">
        <label for="kode">Kode Dokter</label>
        <input type="text" name="kode" id="kode" class="form-control" value="<?php echo $kode;?>">
    </div>
    <div class="col-md-12 mb-3">
        <label for="spesialis">Spesialis</label>
        <input type="text" name="spesialis" id="spesialis" class="form-control" value="<?php echo $spesialis;?>">
    </div>
    <div class="col-md-12 mb-3">
        <label for="nama">Nama Dokter</label>
        <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $nama;?>">
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3">
        <label for="kontak">Kontak</label>
        <input type="text" name="kontak" id="kontak" class="form-control" value="<?php echo $kontak;?>">
    </div>
    <div class="col-md-12 mb-3">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="<?php echo $email;?>">
    </div>
    <div class="col-md-12 mb-3">
        <label for="alamat">Alamat</label>
        <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo $alamat;?>">
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-control">
            <option value="Aktif">Aktif</option>
            <option value="Cuti">Cuti</option>
        </select>
    </div>
    <div class="col-md-12 mb-3">
        <label for="foto">Foto</label>
        <input type="file" name="foto" id="foto" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col col-md-12 mb-3" id="NotifikasiTambahDokterDeh">
        <span class="text-primary">Pastikan semua data dokter sudah terisi dengan benar</span>
    </div>
</div>