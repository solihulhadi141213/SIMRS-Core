<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_practitioner'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Practitioner Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-success">';
        echo '  <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </button>';
        echo '</div>';
    }else{
        $id_practitioner=$_POST['id_practitioner'];
        //Buka Detail Data
        $id_ihs_practitioner=getDataDetail($Conn,'referensi_practitioner','id_practitioner',$id_practitioner,'id_ihs_practitioner');
        $kategori=getDataDetail($Conn,'referensi_practitioner','id_practitioner',$id_practitioner,'kategori');
        $nik=getDataDetail($Conn,'referensi_practitioner','id_practitioner',$id_practitioner,'nik');
        $nama=getDataDetail($Conn,'referensi_practitioner','id_practitioner',$id_practitioner,'nama');
        $gender=getDataDetail($Conn,'referensi_practitioner','id_practitioner',$id_practitioner,'gender');
        $tanggal_lahir=getDataDetail($Conn,'referensi_practitioner','id_practitioner',$id_practitioner,'tanggal_lahir');
        $kontak=getDataDetail($Conn,'referensi_practitioner','id_practitioner',$id_practitioner,'kontak');
        $email=getDataDetail($Conn,'referensi_practitioner','id_practitioner',$id_practitioner,'email');
        $status=getDataDetail($Conn,'referensi_practitioner','id_practitioner',$id_practitioner,'status');
        if(empty($status)){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '         ID Practitioner Tidak Valid!';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-footer bg-success">';
            echo '  <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">';
            echo '      <i class="ti ti-close"></i> Tutup';
            echo '  </button>';
            echo '</div>';
        }else{
?>
    <form action="javascript:void(0);" id="ProsesEditPractitioner">
        <input type="hidden" id="id_practitioner" name="id_practitioner" value="<?php echo $id_practitioner;?>">
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col-md-4"><label for="nama">Nama Practitioner</label></div>
                <div class="col-md-8">
                    <input type="text" id="nama" name="nama" class="form-control" value="<?php echo "$nama"; ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><label for="nik">NIK Practitioner</label></div>
                <div class="col-md-8">
                    <label for="nik">NIK Practitioner</label>
                    <input type="text" id="nik" name="nik" class="form-control" value="<?php echo "$nik"; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><label for="kategori">Kategori Practitioner</label></div>
                <div class="col-md-8">
                    <input type="text" id="kategori" name="kategori" class="form-control" datalist="ListPractitioner" value="<?php echo "$kategori"; ?>" required>
                    <datalist id="ListPractitioner">
                        <?php
                            $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM referensi_practitioner ORDER BY kategori ASC");
                            while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                                $KategoriPractitionerList= $DataKategori['kategori'];
                                echo '<option value="'.$KategoriPractitionerList.'">';
                            }
                        ?>
                    </datalist>
                    <small>Dokter, Perawat, Ahli dll.</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><label for="id_ihs_practitioner">ID IHS Practitioner</label></div>
                <div class="col-md-8">
                    <input type="text" id="id_ihs_practitioner" name="id_ihs_practitioner" class="form-control" value="<?php echo "$id_ihs_practitioner"; ?>">
                    <small>Hubungkan dengan ID Practitioner Satu Sehat</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><label for="gender">Gender</label></div>
                <div class="col-md-8">
                    <select name="gender" id="gender" class="form-control">
                        <option <?php if($gender=="male"){echo "selected";} ?> value="male">Male</option>
                        <option <?php if($gender=="female"){echo "selected";} ?> value="female">Female</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><label for="tanggal_lahir">Tanggal Lahir</label></div>
                <div class="col-md-8">
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" value="<?php echo "$tanggal_lahir"; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><label for="kontak">Kontak (HP)</label></div>
                <div class="col-md-8">
                    <input type="text" id="kontak" name="kontak" class="form-control" placeholder="62" value="<?php echo "$kontak"; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><label for="email">Email</label></div>
                <div class="col-md-8">
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo "$email"; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><label for="status">Status</label></div>
                <div class="col-md-8">
                    <select name="status" id="status" class="form-control">
                        <option <?php if($status=="Aktif"){echo "selected";} ?> value="Aktif">Aktif</option>
                        <option <?php if($status=="Tidak Aktif"){echo "selected";} ?> value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 mb-3" id="NotifikasiEditPractitioner">
                    <span class="text-primary">Pastikan Informasi Practitioner Yang Akan Diinput Sudah Sesuai.</span>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-success">
            <button type="submit" class="btn btn-sm btn btn-primary">
                <i class="ti ti-save"></i> Simpan
            </button>
            <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                <i class="ti ti-close"></i> Tutup
            </button>
        </div>
    </form>
<?php
        }
    }
?>