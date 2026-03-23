<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Menangkap variabel
    if(empty($_POST['id_ruang_rawat'])){
        echo "<span class='text-danger'>Maaf ID Ruangan Tidak Bisa Ditangkap!!</span>";
    }else{
        $id_ruang_rawat=$_POST['id_ruang_rawat'];
        //Membuka detail database
        $Qry = mysqli_query($Conn,"SELECT * FROM ruang_rawat WHERE id_ruang_rawat='$id_ruang_rawat'")or die(mysqli_error($Conn));
        $Data = mysqli_fetch_array($Qry);
        $kodekelas = $Data['kodekelas'];
        $kelas = $Data['kelas'];
        $ruangan = $Data['ruangan'];
        $bed = $Data['bed'];
        $pria = $Data['pria'];
        $wanita = $Data['wanita'];
        $bebas = $Data['bebas'];
        $status = $Data['status'];
?>
<form action="javascript:void(0);" method="POST" id="ProsesEditBed" autocomplete="off">
    <input type="hidden" name="id_ruang_rawat" id="id_ruang_rawat" value="<?php echo "$id_ruang_rawat"; ?>">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="kategori"><dt>Kategori</dt></label>
                <input type="text" readonly name="kategori" id="kategori" class="form-control" value="ruangan">
            </div>
            <div class="col-md-6 mb-3">
                <label for="kode"><dt>Kode Kelas</dt></label>
                <input type="text" readonly name="kodekelas" id="kodekelas" class="form-control" value="<?php echo "$kodekelas"; ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="kelas"><dt>Nama Kelas</dt></label>
                <input type="text" readonly name="kelas" id="kelas" class="form-control" value="<?php echo "$kelas"; ?>" required>
            </div>
        </div>
        <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="ruangan"><dt>Nama Ruangan</dt></label>
                    <input type="text" readonly name="ruangan" id="ruangan" class="form-control" value="<?php echo "$ruangan"; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="ruangan"><dt>Kode Bed</dt></label>
                    <input type="text" name="bed" id="bed" class="form-control" value="<?php echo "$bed"; ?>"  required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tipe"><dt>Tipe</dt></label>
                    <select name="tipe" id="tipe" class="form-control">
                        <option <?php if($bebas=="1"){echo "selected";} ?> value="bebas">Bebas</option>
                        <option <?php if($pria=="1"){echo "selected";} ?> value="pria">Kusus Pria</option>
                        <option <?php if($wanita=="1"){echo "selected";} ?> value="wanita">Kusus Wanita</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status"><dt>Status</dt></label>
                    <select name="status" id="status" class="form-control">
                        <option <?php if($status=="Aktif"){echo "selected";} ?> value="Aktif">Aktif</option>
                        <option <?php if($status=="Renovasi"){echo "selected";} ?> value="Renovasi">Renovasi</option>
                        <option <?php if($status=="Tutup"){echo "selected";} ?> value="Tutup">Tutup</option>
                    </select>
                </div>
            </div>
        <div class="row">
            <div class="col-md-12 mb-3" id="NotifikasiEditBed">
                <p class="text-primary">Pastikan data yang akan anda update sudah benar</p>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <button type="submit" class="btn btn-md btn-inverse mr-2 mt-2"> <i class="ti-save"></i> Simpan</button>
        <button type="button" class="btn btn-md btn-light mr-2 mt-2" data-dismiss="modal"> <i class="ti-close"></i> Tutup</button>
    </div>
</form>
<?php } ?>