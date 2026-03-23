<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i:s');
    if(empty($_POST['id_referensi_location'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger mb-3">';
        echo '          ID Organisasi Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-info">';
        echo '  <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">';
        echo '      <i class="ti-close"></i> Tutup';
        echo '  </button>';
        echo '</div>';
    }else{
        $id_referensi_location=$_POST['id_referensi_location'];
        //Buka Detail Data
        $id_location=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'id_location');
        $nama=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'nama');
        $kode=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'kode');
        $deskripsi=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'deskripsi');
        $status=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'status');
        $mode=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'mode');
        $kontak=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'kontak');
        $fax=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'fax');
        $email=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'email');
        $url=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'url');
        $address_use=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'address_use');
        $address_line=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'address_line');
        $address_city=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'address_city');
        $address_postalCode=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'address_postalCode');
        $physicalType_code=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'physicalType_code');
        $physicalType_display=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'physicalType_display');
        $longitude=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'longitude');
        $latitude=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'latitude');
        $longitude=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'longitude');
        $altitude=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'altitude');
        $managingOrganization=getDataDetail($Conn,'referensi_location','id_referensi_location',$id_referensi_location,'managingOrganization');
?>
    <input type="hidden" id="id_referensi_location" name="id_referensi_location" class="form-control" value="<?php echo "$id_referensi_location"; ?>" required>
    <div class="modal-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="nama">Nama Location</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="nama" name="nama" class="form-control" value="<?php echo "$nama"; ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="kode">Kode</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="kode" name="kode" class="form-control" value="<?php echo "$kode"; ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="deskripsi">Deskripsi</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="deskripsi" name="deskripsi" class="form-control" value="<?php echo "$deskripsi"; ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="status">Status</label>
            </div>
            <div class="col-md-8">
                <select name="status" id="status" class="form-control">
                    <option <?php if($status=="active"){echo "selected";} ?> value="active">Active</option>
                    <option <?php if($status=="suspended"){echo "selected";} ?> value="suspended">Suspended</option>
                    <option <?php if($status=="inactive"){echo "selected";} ?> value="inactive">Inactive</option>
                </select>
                <small>
                    <a href="http://hl7.org/fhir/R4/codesystem-location-status.html#location-status-active" class="text-info">Lihat Dokumentasi</a>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="mode">Mode</label>
            </div>
            <div class="col-md-8">
                <select name="mode" id="mode" class="form-control">
                    <option <?php if($mode=="instance"){echo "selected";} ?> value="instance">Instance</option>
                    <option <?php if($mode=="official"){echo "selected";} ?> value="official">Official</option>
                    <option <?php if($mode=="kind"){echo "selected";} ?> value="kind">Kind</option>
                </select>
                <small>
                    <a href="http://hl7.org/fhir/R4/codesystem-location-mode.html#location-mode-instance" class="text-info">Lihat Dokumentasi</a>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="email">Email</label>
            </div>
            <div class="col-md-8">
                <input type="email" id="email" name="email" class="form-control" value="<?php echo "$email"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="kontak">Kontak</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="kontak" name="kontak" class="form-control" value="<?php echo "$kontak"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="fax">Fax</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="fax" name="fax" class="form-control" value="<?php echo "$fax"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="url">Web/URL</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="url" name="url" class="form-control" placeholder="https://" value="<?php echo "$url"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="address_use">Address Use</label>
            </div>
            <div class="col-md-8">
                <select name="address_use" id="address_use" class="form-control">
                    <option <?php if($address_use=="home"){echo "selected";} ?> value="home">Home</option>
                    <option <?php if($address_use=="work"){echo "selected";} ?> value="work">Work</option>
                    <option <?php if($address_use=="temp"){echo "selected";} ?> value="temp">Temporary</option>
                    <option <?php if($address_use=="old"){echo "selected";} ?> value="old">Old / Incorrect</option>
                    <option <?php if($address_use=="billing"){echo "selected";} ?> value="billing">Billing</option>
                </select>
                <a href="http://hl7.org/fhir/R4/codesystem-address-use.html#address-use-home" class="text-info">Lihat Dokumentasi</a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="address_line">Jalan/Line</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="address_line" name="address_line" class="form-control" placeholder="Nama Jalan" value="<?php echo "$address_line"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="address_city">Kota/City</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="address_city" name="address_city" class="form-control" value="<?php echo "$address_city"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="address_postalCode">Kode POS</label>
            </div>
            <div class="col-md-8">
                <input type="text" id="address_postalCode" name="address_postalCode" class="form-control" value="<?php echo "$address_postalCode"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="physicalType_code">Tipe</label>
            </div>
            <div class="col-md-8">
                <select name="physicalType_code" id="physicalType_code" class="form-control">
                    <option <?php if($physicalType_code=="si"){echo "selected";} ?> value="si">Site</option>
                    <option <?php if($physicalType_code=="bu"){echo "selected";} ?> value="bu">Building</option>
                    <option <?php if($physicalType_code=="wi"){echo "selected";} ?> value="wi">Wing</option>
                    <option <?php if($physicalType_code=="wa"){echo "selected";} ?> value="wa">Ward</option>
                    <option <?php if($physicalType_code=="lvl"){echo "selected";} ?> value="lvl">Level</option>
                    <option <?php if($physicalType_code=="co"){echo "selected";} ?> value="co">Corridor</option>
                    <option <?php if($physicalType_code=="ro"){echo "selected";} ?> value="ro">Room</option>
                    <option <?php if($physicalType_code=="bd"){echo "selected";} ?> value="bd">Bed</option>
                    <option <?php if($physicalType_code=="ve"){echo "selected";} ?> value="ve">Vehicle</option>
                    <option <?php if($physicalType_code=="ho"){echo "selected";} ?> value="ho">House</option>
                    <option <?php if($physicalType_code=="ca"){echo "selected";} ?> value="ca">Cabinet</option>
                    <option <?php if($physicalType_code=="rd"){echo "selected";} ?> value="rd">Road</option>
                    <option <?php if($physicalType_code=="area"){echo "selected";} ?> value="area">Area</option>
                    <option <?php if($physicalType_code=="jdn"){echo "selected";} ?> value="jdn">Jurisdiction</option>
                    <option <?php if($physicalType_code=="vi"){echo "selected";} ?> value="vi">Virtual</option>
                </select>
                <a href="https://terminology.hl7.org/5.1.0/CodeSystem-location-physical-type.html" class="text-info">Lihat Dokumentasi</a>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="managingOrganization">Organization</label>
            </div>
            <div class="col-md-8">
                <select name="managingOrganization" id="managingOrganization" class="form-control">
                    <option value="">Pilih</option>
                    <?php
                        $QryOrganisasi = mysqli_query($Conn, "SELECT*FROM referensi_organisasi WHERE ID_Org!='' ORDER BY id_referensi_organisasi DESC");
                        while ($DataOrganisasi = mysqli_fetch_array($QryOrganisasi)) {
                            $id_referensi_organisasi= $DataOrganisasi['id_referensi_organisasi'];
                            $NamaOrganisasi= $DataOrganisasi['nama'];
                            $ID_Org= $DataOrganisasi['ID_Org'];
                            if($managingOrganization==$ID_Org){
                                echo '<option selected value="'.$ID_Org.'">'.$NamaOrganisasi.'</option>';
                            }else{
                                echo '<option value="'.$ID_Org.'">'.$NamaOrganisasi.'</option>';
                            }
                        }
                    ?>
                </select>
                <small class="text-mutted">
                    Organisasi Pengelola
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_location">IHS Location</label>
            </div>
            <div class="col-md-8">
                <input type="text" readonly id="id_location" name="id_location" class="form-control" value="<?php echo "$id_location"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"></div>
            <div class="col-md-8">
                <input type="checkbox" <?php if(!empty($id_location)){echo "checked";} ?> name="UpdateLocationToSatuSehat" id="UpdateLocationToSatuSehat" value="Ya">
                <label for="UpdateLocationToSatuSehat">Update Location Satu Sehat</label>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-3" id="NotifikasiEditLocation">
                <span class="text-primary">Pastikan Informasi Location Yang Akan Diinput Sudah Sesuai.</span>
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
<?php } ?>