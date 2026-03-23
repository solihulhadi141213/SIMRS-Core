<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_referensi_organisasi'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Organisasi Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-success">';
        echo '  <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </button>';
        echo '</div>';
    }else{
        $id_referensi_organisasi=$_POST['id_referensi_organisasi'];
        //Buka Detail Data
        $nama=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'nama');
        $identifier=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'identifier');
        $tipe=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'tipe');
        $email=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'email');
        $kontak=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'kontak');
        $part_of_ID=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'part_of_ID');
        $ID_Org=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'ID_Org');
        if(empty($nama)){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          Data Organisasi Tidak Ditemukan!';
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
    <input type="hidden" id="id_referensi_organisasi" name="id_referensi_organisasi" value="<?php echo $id_referensi_organisasi;?>">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="nama">Nama Organisasi</label>
                <input type="text" id="nama" name="nama" class="form-control" required value="<?php echo "$nama";?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="identifier">Identifier</label>
                <select name="identifier" id="identifier" class="form-control">
                    <option <?php if($identifier=="usual"){echo "selected";} ?> value="usual">Usual</option>
                    <option <?php if($identifier=="official"){echo "selected";} ?> value="official">Official</option>
                    <option <?php if($identifier=="temp"){echo "selected";} ?> value="temp">Temp</option>
                    <option <?php if($identifier=="secondary"){echo "selected";} ?> value="secondary">Secondary</option>
                    <option <?php if($identifier=="old"){echo "selected";} ?> value="old">Old</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="tipe">Tipe</label>
                <select name="tipe" id="tipe" class="form-control">
                    <option <?php if($tipe=="prov"){echo "selected";} ?> value="prov">Healthcare Provider</option>
                    <option <?php if($tipe=="dept"){echo "selected";} ?> value="dept">Hospital Department</option>
                    <option <?php if($tipe=="team"){echo "selected";} ?> value="team">Organizational team</option>
                    <option <?php if($tipe=="govt"){echo "selected";} ?> value="govt">Government</option>
                    <option <?php if($tipe=="ins"){echo "selected";} ?> value="ins">Insurance Company</option>
                    <option <?php if($tipe=="pay"){echo "selected";} ?> value="pay">Payer</option>
                    <option <?php if($tipe=="edu"){echo "selected";} ?> value="edu">Educational Institute</option>
                    <option <?php if($tipe=="reli"){echo "selected";} ?> value="reli">Religious Institution</option>
                    <option <?php if($tipe=="crs"){echo "selected";} ?> value="crs">Clinical Research Sponsor</option>
                    <option <?php if($tipe=="cg"){echo "selected";} ?> value="cg">Community Group</option>
                    <option <?php if($tipe=="bus"){echo "selected";} ?> value="bus">Non-Healthcare Business or Corporation</option>
                    <option <?php if($tipe=="other"){echo "selected";} ?> value="other">Other</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo "$email";?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="kontak">Nomor Kontak</label>
                <input type="text" id="kontak" name="kontak" class="form-control" value="<?php echo "$kontak";?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="part_of_ID">Part Of</label>
                <select name="part_of_ID" id="part_of_ID" class="form-control">
                    <?php
                        echo '<option value="">Pilih</option>';
                        $QryOrganisasi = mysqli_query($Conn, "SELECT*FROM referensi_organisasi WHERE ID_Org!='$ID_Org' AND ID_Org!='' AND part_of_ID!='$ID_Org' ORDER BY id_referensi_organisasi DESC");
                        while ($DataOrganisasi = mysqli_fetch_array($QryOrganisasi)) {
                            $id_referensi_organisasi= $DataOrganisasi['id_referensi_organisasi'];
                            $NamaOrganisasi= $DataOrganisasi['nama'];
                            if(empty($DataOrganisasi['ID_Org'])){
                                $ID_OrgVal="";
                            }else{
                                $ID_OrgVal=$DataOrganisasi['ID_Org'];
                            }
                            if($ID_OrgVal==$part_of_ID){
                                echo '<option selected value="'.$ID_OrgVal.'">'.$NamaOrganisasi.'</option>';
                            }else{
                                echo '<option value="'.$ID_OrgVal.'">'.$NamaOrganisasi.'</option>';
                            }
                        }
                    ?>
                </select>
                <small>Apabila anda mengisi informasi ini, maka data organisasi tidak akan ditampilkan pada halaman utama</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <input type="radio" <?php if($ID_Org==""){echo "checked";} ?> name="ID_Org2" id="ID_Org2_Ya" value="Ya">
                <label for="ID_Org2_Ya">Generate ID Organisasi Dari Satu Sehat</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <input type="radio" <?php if($ID_Org!==""){echo "checked";} ?> name="ID_Org2" id="ID_Org2_Tidak" value="Tidak">
                <label for="ID_Org2_Tidak">Sudah Ada ID Organization</label>
                <input type="text" <?php if($ID_Org==""){echo "readonly";} ?> name="id_organization" id="id_organization2" class="form-control" value="<?php echo "$ID_Org"; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3" id="NotifikasiEditOrganisasi">
                <span class="text-primary">Pastikan Informasi Organisasi Yang Akan Diinput Sudah Sesuai.</span>
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

<?php
        }
    }
?>