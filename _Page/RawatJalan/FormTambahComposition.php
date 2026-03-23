<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_kunjungan
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-danger text-center">';
        echo '          Data Kunjungan Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-primary">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12">';
        echo '          <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">';
        echo '              <i class="ti-close"></i> Tutup';
        echo '          </button>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
        $id_encounter=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_encounter');
        $TanggalKunjungan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'tanggal');
        $id_ihs=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'id_ihs');
        $nama=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'nama');
?>
    <form action="javascript:void(0);" id="ProsesTambahComposition">
        <input type="hidden" name="GetIdKunjungan" id="GetIdKunjungan" value="<?php echo $id_kunjungan; ?>">
        <div class="modal-body border-0 pb-0 mb-4">
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="id_pasien">No.RM</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="id_pasien" id="id_pasien" value="<?php echo "$id_pasien"; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="id_condition">ID.Composition</label>
                </div>
                <div class="col-md-8">
                    <input type="text" readonly class="form-control" name="id_composition" id="id_composition" value="">
                    <small>
                        <input type="checkbox" checked name="GenerateIdComposition" id="GenerateIdComposition" value="Ya"> 
                        <label for="GenerateIdComposition">Generate ID Condition</label>
                    </small>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="id_ihs">ID IHS</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="id_ihs" id="id_ihs" value="<?php echo "$id_ihs"; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="nama">Patient Name</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="nama" id="nama" value="<?php echo "$nama"; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="id_encounter">ID Encounter</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="id_encounter" id="id_encounter" value="<?php echo "$id_encounter"; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="tanggal_kunjungan">Tanggal Kunjungan</label>
                </div>
                <div class="col-md-8">
                    <input type="date" class="form-control" name="tanggal_kunjungan" id="tanggal_kunjungan" value="<?php echo "$TanggalKunjungan"; ?>">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="typeConposition">
                        Type <br>
                        <a href="https://loinc.org/" class="text-info"><small>https://loinc.org/</small></a>
                    </label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="typeConposition" id="typeConposition" list="typeConpositionList" placeholder="Code|Display">
                    <datalist id="typeConpositionList">
                        <option value="18842-5|Discharge summary">
                    </datalist>
                    <small>
                        Contoh Format: 18842-5|Discharge summary
                    </small>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="titleComposition">Title</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="titleComposition" id="titleComposition" placeholder="Resume Medis Rawat Jalan">
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="categoryConposition">
                        Category<br>
                        <a href="https://loinc.org/" class="text-info"><small>https://loinc.org/</small></a>
                    </label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="categoryConposition" id="categoryConposition" list="categoryConpositionList" placeholder="Code|Display">
                    <datalist id="categoryConpositionList">
                        <option value="LP173421-1|Report">
                    </datalist>
                    <small>
                        Contoh Format: LP173421-1|Report
                    </small>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="IdIhsPractitioner">Practitioner</label>
                </div>
                <div class="col-md-8">
                    <select name="IdIhsPractitioner" id="IdIhsPractitioner" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            //Menampilkan Practitioner
                            $query = mysqli_query($Conn, "SELECT*FROM referensi_practitioner ORDER BY nama ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_ihs_practitioner= $data['id_ihs_practitioner'];
                                $nama= $data['nama'];
                                echo '<option value="'.$id_ihs_practitioner.'">'.$nama.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="IdOrg">Organization</label>
                </div>
                <div class="col-md-8">
                    <select name="IdOrg" id="IdOrg" class="form-control">
                        <option value="">Pilih</option>
                        <?php
                            //Menampilkan Practitioner
                            $query = mysqli_query($Conn, "SELECT*FROM referensi_organisasi ORDER BY nama ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $ID_Org= $data['ID_Org'];
                                $nama= $data['nama'];
                                echo '<option selected value="'.$ID_Org.'">'.$nama.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="sectionConposition">
                        Section<br>
                        <a href="https://loinc.org/" class="text-info"><small>https://loinc.org/</small></a>
                    </label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="sectionConposition" id="sectionConposition" list="sectionConpositionList" placeholder="Code|Display">
                    <datalist id="categoryConpositionList">
                        <option value="42344-2|Discharge diet (narrative)">
                    </datalist>
                    <small>
                        Contoh Format: 42344-2|Discharge diet (narrative)
                    </small>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-4">
                    <label for="sectionTextConposition">
                        Section Text
                    </label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="sectionTextConposition" id="sectionTextConposition" placeholder="Rekomendasi diet rendah lemak">
                    <small>
                        Contoh: Rekomendasi diet rendah lemak, rendah kalori
                    </small>
                </div>
            </div>
            <div class="row mb-3"> 
                <div class="col-md-12" id="NotifikasiTambahComposition">
                    <span class="text-primary">Pastikan Data Composition Sudah Sesuai!</span>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-primary">
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-sm btn-inverse mr-2">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </form>
<?php } ?>