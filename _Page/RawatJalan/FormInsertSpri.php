<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap no_bpjs
    if(empty($_POST['noKartu'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data No Kartu BPJS Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $noKartu=$_POST['noKartu'];
?>
<form action="javascript:void(0);" id="ProsesInsertSpri">
    <div class="modal-body border-0 pb-0 mb-4">
        <div class="row mt-2 mb-2"> 
            <div class="col-md-6">
                <label for="noKartu"><dt>No.Kartu</dt></label>
                <input type="text" name="noKartu" id="noKartu" class="form-control" value="<?php echo "$noKartu";?>" required>
            </div>
            <div class="col-md-6">
                <label for="kodeDokter"><dt>Kode Dokter</dt></label>
                <select name="kodeDokter" id="kodeDokter" class="form-control">
                    <option value="">Pilih</option>
                    <?php
                        //menamilkan dari database
                        $query = mysqli_query($Conn, "SELECT*FROM dokter");
                        while ($data = mysqli_fetch_array($query)) {
                            $KodeDokter= $data['kode'];
                            $NamaDokter= $data['nama'];
                            echo '<option value="'.$KodeDokter.'">'.$NamaDokter.'</option>';
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-6 mt-3">
                <label for="poliKontrol"><dt>Poliklinik Kontrol</dt></label>
                <select name="poliKontrol" id="poliKontrol" class="form-control">
                    <option value="">Pilih</option>
                    <?php
                        //menamilkan dari database
                        $query = mysqli_query($Conn, "SELECT*FROM poliklinik");
                        while ($data = mysqli_fetch_array($query)) {
                            $id_poliklinik= $data['id_poliklinik'];
                            $nama= $data['nama'];
                            $kode= $data['kode'];
                            echo '<option value="'.$kode.'">'.$nama.'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="tglRencanaKontrol"><dt>Tanggal Kontrol</dt></label>
                <input type="date" name="tglRencanaKontrol" id="tglRencanaKontrol" class="form-control" value="<?php echo date('Y-m-d');?>" required>
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12">
                <label for="user"><dt>Petugas</dt></label>
                <input type="text" name="user" id="user" class="form-control" value="<?php echo "$SessionNama"; ?>" required>
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12" id="NotifikasiInsertSpri">
                <span class="text-info">
                    <dt>Keterangan :</dt>
                    Pastikan data rencana kontrol yang anda isi sudah sesuai.
                </span>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-inverse">
        <div class="row">
            <div class="col-md-12 mb-3">
                <button type="submit" class="btn btn-md btn-primary mt-2 ml-2">
                    <i class="ti-check-box"></i> Simpan
                </button>
                <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</form>
<?php } ?>