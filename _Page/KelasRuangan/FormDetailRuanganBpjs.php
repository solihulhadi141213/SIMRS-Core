<?php
    if(empty($_POST['namaruang'])){
        $namaruang="";
    }else{
        $namaruang=$_POST['namaruang'];
    }
    if(empty($_POST['namakelas'])){
        $namakelas="";
    }else{
        $namakelas=$_POST['namakelas'];
    }
    if(empty($_POST['kapasitas'])){
        $kapasitas=0;
    }else{
        $kapasitas=$_POST['kapasitas'];
    }
    if(empty($_POST['tersediapria'])){
        $tersediapria=0;
    }else{
        $tersediapria=$_POST['tersediapria'];
    }
    if(empty($_POST['tersediawanita'])){
        $tersediawanita=0;
    }else{
        $tersediawanita=$_POST['tersediawanita'];
    }
    if(empty($_POST['tersediapriawanita'])){
        $tersediapriawanita=0;
    }else{
        $tersediapriawanita=$_POST['tersediapriawanita'];
    }
    if(empty($_POST['lastupdate'])){
        $lastupdate="";
    }else{
        $lastupdate=$_POST['lastupdate'];
    }
    if(empty($_POST['kodekelas'])){
        $kodekelas="";
    }else{
        $kodekelas=$_POST['kodekelas'];
    }
?>
<input type="hidden" name="namaruang" value="<?php echo $namaruang; ?>">
<input type="hidden" name="namakelas" value="<?php echo $namakelas; ?>">
<input type="hidden" name="kodekelas" value="<?php echo $kodekelas; ?>">
<input type="hidden" name="kapasitas" value="<?php echo $kapasitas; ?>">
<input type="hidden" name="tersediapria" value="<?php echo $tersediapria; ?>">
<input type="hidden" name="tersediawanita" value="<?php echo $tersediawanita; ?>">
<input type="hidden" name="tersediapriawanita" value="<?php echo $tersediapriawanita; ?>">
<input type="hidden" name="lastupdate" value="<?php echo $lastupdate; ?>">
<div class="row mb-3">
    <div class="col-md-12">
        <ol>
            <li class="mb-3">
                Nama Ruangan : 
                <code class="text-secondary"><?php echo "$namaruang"; ?></code>
            </li>
            <li class="mb-3">
                Nama Kelas : 
                <code class="text-secondary"><?php echo "$namakelas"; ?></code>
            </li>
            <li class="mb-3">
                Kode Kelas : 
                <code class="text-secondary"><?php echo "$kodekelas"; ?></code>
            </li>
            <li class="mb-3">
                Kapasitas : 
                <code class="text-secondary"><?php echo "$kapasitas"; ?></code>
            </li>
            <li class="mb-3">
                Tersedia Pria : 
                <code class="text-secondary"><?php echo "$tersediapria"; ?></code>
            </li>
            <li class="mb-3">
                Tersedia Wanita : 
                <code class="text-secondary"><?php echo "$tersediawanita"; ?></code>
            </li>
            <li class="mb-3">
                Tersedia Pria & Wanita : 
                <code class="text-secondary"><?php echo "$tersediapriawanita"; ?></code>
            </li>
            <li class="mb-3">
                Update Time : 
                <code class="text-secondary"><?php echo "$lastupdate"; ?></code>
            </li>
        </ol>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12 text-center" id="NotifikasiUpdateRuanganBpjs">
        <span>Silahkan lakukan update ketersediaan pasien.</span>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <button type="submit" class="btn btn-sm btn-info btn-round btn-block">
            Update
        </button>
    </div>
</div>