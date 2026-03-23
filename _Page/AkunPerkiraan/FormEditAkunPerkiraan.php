<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_perkiraan
    if(empty($_POST['id_perkiraan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Akun Perkiraan Tidak Boleh Kosong.';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_perkiraan=$_POST['id_perkiraan'];
        $id_perkiraan=getDataDetail($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'id_perkiraan');
        //Buka data obat
        if(empty($id_perkiraan)){
            echo '<div class="card-body border-0 pb-0">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          ID Akun Perkiraan Tidak Valid Karena Tidak Ditemukan Pada Database.';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $nama=getDataDetail($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'nama');
            $name=getDataDetail($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'name');
            $kode=getDataDetail($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'kode');
            $level=getDataDetail($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'level');
            $rank=getDataDetail($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'rank');
            $saldo_normal=getDataDetail($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'saldo_normal');
?>
    <input type="hidden" name="id_perkiraan" value="<?php echo "$id_perkiraan"; ?>">
    <div class="row">
        <div class="col-md-12 mb-3 form-group form-primary">
            <label class="float-label">Kode Akun</label>
            <input type="text" readonly name="kode" id="kode" class="form-control" value="<?php echo "$kode";?>" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3 form-group form-primary">
            <label for="level" class="float-label">Level</label>
            <input type="text" readonly name="level" id="level" class="form-control" value="<?php echo "$level";?>" required>
        </div>
        
    </div>
    <div class="row">
        <div class="col-md-12 mb-3 form-group form-primary">
            <label class="float-label">Nama Akun</label>
            <input type="text" name="nama_perkiraan1" id="nama_perkiraan1" class="form-control" value="<?php echo "$nama";?>" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3 form-group form-primary">
            <label class="float-label">Name</label>
            <input type="text" name="nama_perkiraan2" id="nama_perkiraan2" class="form-control" value="<?php echo "$name";?>" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3 form-group form-primary">
            <label class="float-label">Saldo Normal</label>
            <input type="text" readonly name="saldo_normal" id="saldo_normal" class="form-control" value="<?php echo "$saldo_normal";?>" required>
        </div>
    </div>
<?php }} ?>