<?php 
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
?>
<form action="javascript:void(0);" id="ProsesTambahWilayah" autocomplete="off">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mt-3">
                <label for="propinsi">
                    <dt>Propinsi</dt>
                </label>
                <input type="text" name="propinsi" id="propinsi" list="DataListPropinsi" class="form-control" required>
                <datalist id="DataListPropinsi">
                    <?php
                        //Arraykan propinsi
                        $QryPropinsi = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Propinsi' ORDER BY propinsi ASC");
                        while ($DataPropinsi = mysqli_fetch_array($QryPropinsi)) {
                            $propinsi= $DataPropinsi['propinsi'];
                            echo '<option value="'.$propinsi.'">'.$propinsi.'</option>';
                        }
                    ?>
                </datalist>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3">
                <label for="kabupaten">
                    <dt>Kabupaten/Kota</dt>
                </label>
                <input type="text" name="kabupaten" id="kabupaten" list="DataListKabupaten" class="form-control">
                <datalist id="DataListKabupaten">
                </datalist>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3">
                <label for="nik">
                    <dt>Kecamatan</dt>
                </label>
                <input type="text" name="kecamatan" id="kecamatan" list="DataListKecamatan" class="form-control">
                <datalist id="DataListKecamatan">
                </datalist>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3">
                <label for="nik">
                    <dt>Desa/Kelurahan</dt>
                </label>
                <input type="text" name="desa" id="desa" list="DataListDesa" class="form-control">
                <datalist id="DataListDesa">
                </datalist>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3" id="NotifikasiTambahWilayah">
                <small>
                    <dt>Keterangan :</dt>
                    - Apabila anda mengisi propinsi saja maka akan dianggap sebagai data propinsi<br>
                    - Apabila anda mengisi propinsi dan kabupaten saja maka akan dianggap sebagai data kabupaten<br>
                    - Apabila anda mengisi propinsi, kabupaten dan kecamatan saja maka akan dianggap sebagai data kecamatan<br>
                    - Apabila anda mengisi semua form maka akan dianggap sebagai data desa<br>
                </small>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-sm btn-inverse mt-2 mr-2">
                    <i class="ti ti-save"></i> Simpan
                </button>
                <button type="button" class="btn btn-sm btn-light mt-2 mr-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</form>