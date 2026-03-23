<!--- Modal Tambah Organisasi---->
<div class="modal fade" id="ModalTambahOrganisasi" tabindex="-1" role="dialog" aria-labelledby="ModalTambahOrganisasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahOrganisasi">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="icofont-chart-flow-1"></i> Tambah Organisasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nama">Nama Organisasi</label>
                            <input type="text" id="nama" name="nama" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="identifier">Identifier</label>
                            <select name="identifier" id="identifier" class="form-control">
                                <option value="usual">Usual</option>
                                <option value="official">Official</option>
                                <option value="temp">Temp</option>
                                <option value="secondary">Secondary</option>
                                <option value="old">Old</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="tipe">Tipe</label>
                            <select name="tipe" id="tipe" class="form-control">
                                <option value="prov">Healthcare Provider</option>
                                <option value="dept">Hospital Department</option>
                                <option value="team">Organizational team</option>
                                <option value="govt">Government</option>
                                <option value="ins">Insurance Company</option>
                                <option value="pay">Payer</option>
                                <option value="edu">Educational Institute</option>
                                <option value="reli">Religious Institution</option>
                                <option value="crs">Clinical Research Sponsor</option>
                                <option value="cg">Community Group</option>
                                <option value="bus">Non-Healthcare Business or Corporation</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="email">Alamat Email</label>
                            <input type="email" id="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="kontak">Nomor Kontak</label>
                            <input type="text" id="kontak" name="kontak" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="part_of_ID">Part Of</label>
                            <input type="text" readonly id="part_of_ID" name="part_of_ID" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input type="radio" checked name="ID_Org" id="ID_Org_ya" value="Ya">
                            <label for="ID_Org_ya">Generate ID Organisasi Dari Satu Sehat</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input type="radio" name="ID_Org" id="ID_Org_tidak" value="Tidak">
                            <label for="ID_Org_tidak">Sudah Punya ID Organization</label>
                            <input type="text" readonly name="id_organization" id="id_organization" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3" id="NotifikasiTambahOrganisasi">
                            <span class="text-primary">Pastikan Informasi Organisasi Yang Akan Diinput Sudah Sesuai.</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-sm btn btn-success">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Edit Organisasi---->
<div class="modal fade" id="ModalEditOrganisasi" tabindex="-1" role="dialog" aria-labelledby="ModalEditOrganisasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditOrganisasi">
                <div class="modal-header bg-success">
                    <b cass="text-light"><i class="ti ti-pencil-alt"></i> Edit Organisasi</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditOrganisasi">

                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Organisasi---->
<div class="modal fade" id="ModalHapusOrganisasi" tabindex="-1" role="dialog" aria-labelledby="ModalHapusOrganisasi" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Organisasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormhapusOrganisasi">
                <!---- Konfirmasi Hapus Organisasi ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Pencarian Organisasi---->
<div class="modal fade" id="ModalPencarianOrganisasiSatuSehat" tabindex="-1" role="dialog" aria-labelledby="ModalPencarianOrganisasiSatuSehat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="icofont-chart-flow-1"></i> Detail ID Organisasi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsewsCariOrganisasiSatuSehat">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <select name="SearchBy" id="SearchBy" class="form-control">
                                <option value="name">Nama Organisasi</option>
                                <option value="id">ID Organisasi</option>
                                <option value="partof">Part Of</option>
                            </select>
                        </div>
                        <div class="col-md-9 mb-3">
                            <div class="input-group">
                                <input type="text" name="KywordOrganization" id="KywordOrganization" class="form-control" placeholder="Kata Kunci">
                                <button type="submit" class="btn btn-sm btn-secondary">
                                    <i class="ti ti-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
            <div class="modal-footer bg-inverse">
                <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Organisasi---->
<div class="modal fade" id="ModalDetailOrgId" tabindex="-1" role="dialog" aria-labelledby="ModalDetailOrgId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="icofont-chart-flow-1"></i> Detail Organisasi Satu Sehat</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailOrgId">
                
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Organisasi Simrs---->
<div class="modal fade" id="ModalDetailOrganisasiSimrs" tabindex="-1" role="dialog" aria-labelledby="ModalDetailOrganisasiSimrs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Organisasi SIMRS</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormDetailOrganisasiSimrs">
                
            </div>
        </div>
    </div>
</div>

<!-- Location -->
<!--- Modal Tambah Location---->
<div class="modal fade" id="ModalTambahLocation" tabindex="-1" role="dialog" aria-labelledby="ModalTambahLocation" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahLocation">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="icofont-google-map"></i> Tambah Location</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nama">Nama Location</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="nama" name="nama" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kode">Kode</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="kode" name="kode" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="deskripsi">Deskripsi</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="deskripsi" name="deskripsi" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="status">Status</label>
                        </div>
                        <div class="col-md-8">
                            <select name="status" id="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="suspended">Suspended</option>
                                <option value="inactive">Inactive</option>
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
                                <option value="instance">Instance</option>
                                <option value="official">Official</option>
                                <option value="kind">Kind</option>
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
                            <input type="email" id="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="kontak">Kontak</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="kontak" name="kontak" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="fax">Fax</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="fax" name="fax" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="url">Web/URL</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="url" name="url" class="form-control" placeholder="https://">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="address_use">Address Use</label>
                        </div>
                        <div class="col-md-8">
                            <select name="address_use" id="address_use" class="form-control">
                                <option value="home">Home</option>
                                <option value="work">Work</option>
                                <option value="temp">Temporary</option>
                                <option value="old">Old / Incorrect</option>
                                <option value="billing">Billing</option>
                            </select>
                            <a href="http://hl7.org/fhir/R4/codesystem-address-use.html#address-use-home" class="text-info">Lihat Dokumentasi</a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="address_line">Jalan/Line</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="address_line" name="address_line" class="form-control" placeholder="Nama Jalan">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="address_city">Kota/City</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="address_city" name="address_city" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="address_postalCode">Kode POS</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="address_postalCode" name="address_postalCode" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="physicalType_code">Tipe</label>
                        </div>
                        <div class="col-md-8">
                            <select name="physicalType_code" id="physicalType_code" class="form-control">
                                <option value="si">Site</option>
                                <option value="bu">Building</option>
                                <option value="wi">Wing</option>
                                <option value="wa">Ward</option>
                                <option value="lvl">Level</option>
                                <option value="co">Corridor</option>
                                <option value="ro">Room</option>
                                <option value="bd">Bed</option>
                                <option value="ve">Vehicle</option>
                                <option value="ho">House</option>
                                <option value="ca">Cabinet</option>
                                <option value="rd">Road</option>
                                <option value="area">Area</option>
                                <option value="jdn">Jurisdiction</option>
                                <option value="vi">Virtual</option>
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
                                        echo '<option value="'.$ID_Org.'">'.$NamaOrganisasi.'</option>';
                                    }
                                ?>
                            </select>
                            <small class="text-mutted">
                                Organisasi Pengelola
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <input type="checkbox" checked name="ID_Org" id="ID_Org" value="Ya">
                            <label for="ID_Org">Generate ID Location Dari Satu Sehat</label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3" id="NotifikasiTambahLocation">
                            <span class="text-primary">Pastikan Informasi Location Yang Akan Diinput Sudah Sesuai.</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-sm btn btn-success">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Location Satu Sehat---->
<div class="modal fade" id="ModalDetailLocationSatuSehat" tabindex="-1" role="dialog" aria-labelledby="ModalDetailLocationSatuSehat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Location Satu Sehat</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailLocationSatuSehat">
                
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Location SIMRS---->
<div class="modal fade" id="ModalDetailLocationSimrs" tabindex="-1" role="dialog" aria-labelledby="ModalDetailLocationSimrs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Location SIMRS</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormDetailLocationSimrs">
                
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Location---->
<div class="modal fade" id="ModalEditLocation" tabindex="-1" role="dialog" aria-labelledby="ModalEditLocation" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditLocation">
                <div class="modal-header bg-success">
                    <b cass="text-light"><i class="ti ti-pencil-alt"></i> Edit Location</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="FormEditLocation">

                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Location---->
<div class="modal fade" id="ModalHapusLocation" tabindex="-1" role="dialog" aria-labelledby="ModalHapusLocation" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Location</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusLocation">
                <!---- Konfirmasi Hapus Location ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Tambah Practitioner---->
<div class="modal fade" id="ModalTambahPractitioner" tabindex="-1" role="dialog" aria-labelledby="ModalTambahPractitioner" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahPractitioner">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-plus"></i> Tambah Practitioner</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="nama">Nama Practitioner</label></div>
                        <div class="col-md-8">
                            <input type="text" id="nama" name="nama" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="nik">NIK Practitioner</label></div>
                        <div class="col-md-8">
                            <input type="text" id="nik" name="nik" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="kategori">Kategori Practitioner</label></div>
                        <div class="col-md-8">
                            <input type="text" id="kategori" name="kategori" class="form-control" datalist="ListPractitioner" required>
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
                            <input type="text" id="id_ihs_practitioner" name="id_ihs_practitioner" class="form-control">
                            <small>Hubungkan dengan ID Practitioner Satu Sehat</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="gender">Gender</label></div>
                        <div class="col-md-8">
                            
                            <select name="gender" id="gender" class="form-control">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="tanggal_lahir">Tanggal Lahir</label></div>
                        <div class="col-md-8">
                            
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="kontak">Kontak (HP)</label></div>
                        <div class="col-md-8">
                            
                            <input type="text" id="kontak" name="kontak" class="form-control" placeholder="62">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="email">Email</label></div>
                        <div class="col-md-8">
                            
                            <input type="email" id="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><label for="status">Status</label></div>
                        <div class="col-md-8">
                            
                            <select name="status" id="status" class="form-control">
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiTambahPractitioner">
                            <span class="text-primary">Pastikan Informasi Practitioner Yang Akan Diinput Sudah Sesuai.</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-sm btn btn-success">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Practitioner Satu Sehat---->
<div class="modal fade" id="ModalDetailPractitionerById" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPractitionerById" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Practitioner (Satu Sehat)</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailPractitionerSatuSehat">
                
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Practitioner Satu Sehat---->
<div class="modal fade" id="ModalDetailPractitionerByNik" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPractitionerByNik" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Practitioner (Satu Sehat)</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailPractitionerSatuSehatNik">
                
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Practitioner Satu Sehat---->
<div class="modal fade" id="ModalEditPractitioner" tabindex="-1" role="dialog" aria-labelledby="ModalEditPractitioner" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <b cass="text-light"><i class="ti ti-pencil-alt"></i> Edit Practitioner</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormEditPractitioner">
                
            </div>
        </div>
    </div>
</div>
<!--- Modal Hasil Pencarian ID Practitioner Satu Sehat---->
<div class="modal fade" id="ModalPencarianPractitionerSatuSehat" tabindex="-1" role="dialog" aria-labelledby="ModalPencarianPractitionerSatuSehat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Practitioner (Satu Sehat)</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormHasilPencarianPractitionerSatuSehat">
                
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Hapus Practitioner---->
<div class="modal fade" id="ModalHapusPractitioner" tabindex="-1" role="dialog" aria-labelledby="ModalHapusPractitioner" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Practitioner</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusPractitioner">
                <!---- Konfirmasi Hapus Practitioner ----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail LOINC---->
<div class="modal fade" id="ModalDetailLoinc" tabindex="-1" role="dialog" aria-labelledby="ModalDetailLoinc" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Referensi LOINC</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailLoinc">
                
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Snomed---->
<div class="modal fade" id="ModalDetailSnomed" tabindex="-1" role="dialog" aria-labelledby="ModalDetailSnomed" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <b cass="text-light"><i class="ti ti-info-alt"></i> Detail Referensi Snomed</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailSnomed">
                
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-sm btn btn-secondary" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>