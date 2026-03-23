<!--- Modal Setting Profile Faskes---->
<div class="modal fade" id="ModalSettingProfileFaskes" tabindex="-1" role="dialog" aria-labelledby="ModalSettingProfileFaskes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti ti-more"></i> Profile Setting Faskes</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th align="center"><dt>NO</dt></th>
                                    <th align="center"><dt>Profile Faskes</dt></th>
                                    <th align="center"><dt>Status</dt></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    //Jumlah Pengaturan
                                    $JumlahPengaturan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_profile"));
                                    if(empty($JumlahPengaturan)){
                                        echo '<tr>';
                                        echo '  <td class="center" colspan="3">Belum Ada Pengaturan Yang Tersimpan</td>';
                                        echo '</tr>';
                                    }else{
                                        $no=1;
                                        $QrySettingProfileFaskes = mysqli_query($Conn, "SELECT*FROM setting_profile ORDER BY id_profile DESC");
                                        while ($DataSettingProfileFaskes = mysqli_fetch_array($QrySettingProfileFaskes)) {
                                            $id_profile = $DataSettingProfileFaskes['id_profile'];
                                            $kode_faskes = $DataSettingProfileFaskes['kode_faskes'];
                                            $nama_faskes = $DataSettingProfileFaskes['nama_faskes'];
                                            $status = $DataSettingProfileFaskes['status'];
                                ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td>
                                            <a href="index.php?Page=Setting&Sub=SettingProfile&id=<?php echo $id_profile; ?>" class="text-success">
                                                <?php echo "$nama_faskes";?>
                                            </a>
                                            <?php echo "<br><small>$kode_faskes</small>";?>
                                        </td>
                                        <td align="center"><?php echo $status;?></td>
                                    </tr>
                                <?php $no++;}} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-primary">
                <a href="index.php?Page=Setting&Sub=SettingProfile&id=Add" class="btn btn-sm btn btn-info">
                    <i class="ti ti-plus"></i> Buat Pengaturan Baru
                </a>
                <button type="button" class="btn btn-sm btn btn-inverse" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Hapus Setting Profile Faskes---->
<div class="modal fade" id="ModalHapusSettingProfileFaskes" tabindex="-1" role="dialog" aria-labelledby="ModalHapusSettingProfileFaskes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light"><i class="ti ti-trash"></i> Hapus Setting Faskes</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusSettingProfileFaskes">
                <!---- Konfirmasi Hapus Setting Profile Faskes----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Setting Bridging---->
<div class="modal fade" id="ModalSettingBridging" tabindex="-1" role="dialog" aria-labelledby="ModalSettingBridging" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti ti-more"></i> Profile Setting Bridging</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th align="center"><dt>NO</dt></th>
                                    <th align="center"><dt>Profile Bridging</dt></th>
                                    <th align="center"><dt>Status</dt></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    //Jumlah Pengaturan
                                    $JumlahPengaturan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM bridging"));
                                    if(empty($JumlahPengaturan)){
                                        echo '<tr>';
                                        echo '  <td class="center" colspan="3">Belum Ada Pengaturan Yang Tersimpan</td>';
                                        echo '</tr>';
                                    }else{
                                        $no=1;
                                        $QrySettingBridging = mysqli_query($Conn, "SELECT*FROM bridging ORDER BY id_bridging DESC");
                                        while ($DataSettingBridging = mysqli_fetch_array($QrySettingBridging)) {
                                            $id_bridging = $DataSettingBridging['id_bridging'];
                                            $nama_bridging = $DataSettingBridging['nama_bridging'];
                                            $kode_ppk = $DataSettingBridging['kode_ppk'];
                                            $status = $DataSettingBridging['status'];
                                ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td>
                                            <a href="index.php?Page=Setting&Sub=SettingBridging&id=<?php echo $id_bridging; ?>" class="text-success">
                                                <?php echo "$nama_bridging";?>
                                            </a>
                                            <?php echo "<br><small>$kode_ppk</small>";?>
                                        </td>
                                        <td align="center"><?php echo $status;?></td>
                                    </tr>
                                <?php $no++;}} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-primary">
                <a href="index.php?Page=Setting&Sub=SettingBridging&id=Add" class="btn btn-sm btn btn-info">
                    <i class="ti ti-plus"></i> Buat Pengaturan Baru
                </a>
                <button type="button" class="btn btn-sm btn btn-inverse" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Test Koneksi Bridging---->
<div class="modal fade" id="ModalTestKoneksiBridging" tabindex="-1" role="dialog" aria-labelledby="ModalTestKoneksiBridging" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTestKoneksiBriddging">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti-control-play"></i> Test Koneksi Bridging</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="tipe Koneksi">Tipe Koneksi</label>
                            <select name="tipe_koneksi" id="tipe_koneksi" class="form-control">
                                <option value="">Pilih Proses</option>
                                <option value="Aplicare (Ketersediaan Kamar)">Aplicare (Ketersediaan Kamar)</option>
                                <option value="Vclaim (Referensi Provinsi)">Vclaim (Referensi Provinsi)</option>
                                <option value="PCare (Referensi Dokter)">PCare (Referensi Dokter)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3" id="NotifikasiTestKoneksiBridging">
                            <span class="text-primary">Pastikan anda mengirim pesan ke email yang valid.</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Test I-Care---->
<div class="modal fade" id="ModalTestIcare" tabindex="-1" role="dialog" aria-labelledby="ModalTestIcare" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTestIcare">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti-control-play"></i> Test Koneksi I-care</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormTestIcare">
                    
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-md btn-success">
                        <i class="ti ti-arrow-circle-right"></i> Next
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Setting Bridging---->
<div class="modal fade" id="ModalHapusSettingBridging" tabindex="-1" role="dialog" aria-labelledby="ModalHapusSettingBridging" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light"><i class="ti ti-trash"></i> Hapus Setting Bridging</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusSettingBridging">
                <!---- Konfirmasi Hapus Setting Bridging----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Setting Email Gateway---->
<div class="modal fade" id="ModalSettingEmailgateway" tabindex="-1" role="dialog" aria-labelledby="ModalSettingEmailgateway" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti ti-more"></i> Profile Setting Email Gateway</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th align="center"><dt>NO</dt></th>
                                    <th align="center"><dt>Email Gateway</dt></th>
                                    <th align="center"><dt>Status</dt></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    //Jumlah Pengaturan
                                    $JumlahPengaturan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_email_gateway"));
                                    if(empty($JumlahPengaturan)){
                                        echo '<tr>';
                                        echo '  <td class="center" colspan="3">Belum Ada Pengaturan Yang Tersimpan</td>';
                                        echo '</tr>';
                                    }else{
                                        $no=1;
                                        $QryEmailGateway = mysqli_query($Conn, "SELECT*FROM setting_email_gateway ORDER BY id_setting_email_gateway DESC");
                                        while ($DataEmailGateway = mysqli_fetch_array($QryEmailGateway)) {
                                            $id_setting_email_gateway = $DataEmailGateway['id_setting_email_gateway'];
                                            $email_gateway = $DataEmailGateway['email_gateway'];
                                            $url_service = $DataEmailGateway['url_service'];
                                            $status = $DataEmailGateway['status'];
                                ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td>
                                            <a href="index.php?Page=Setting&Sub=Email&id=<?php echo $id_setting_email_gateway; ?>" class="text-success">
                                                <?php echo "$email_gateway";?>
                                            </a>
                                            <?php echo "<br><small>$url_service</small>";?>
                                        </td>
                                        <td align="center"><?php echo $status;?></td>
                                    </tr>
                                <?php $no++;}} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-primary">
                <a href="index.php?Page=Setting&Sub=Email&id=Add" class="btn btn-sm btn btn-info">
                    <i class="ti ti-plus"></i> Buat Pengaturan Baru
                </a>
                <button type="button" class="btn btn-sm btn btn-inverse" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Kirim Email---->
<div class="modal fade" id="ModalKirimEmail" tabindex="-1" role="dialog" aria-labelledby="ModalKirimEmail" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesKirimEmail">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-email"></i> Coba Kirim Email</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="email_tujuan">Email Tujuan</label>
                            <input type="email" id="email_tujuan" name="email_tujuan" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nama_tujuan">Nama Penerima</label>
                            <input type="text" id="nama_tujuan" name="nama_tujuan" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="subjek">Subjek Pesan</label>
                            <input type="text" id="subjek" name="subjek" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="pesan">Isi Pesan</label>
                            <textarea name="pesan" id="pesan" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3" id="NotifikasiKirimEmail">
                            <span class="text-primary">Pastikan anda mengirim pesan ke email yang valid.</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-md btn btn-success">
                        <i class="ti ti-arrow-circle-up"></i> Kirim
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Setting Email Gateway---->
<div class="modal fade" id="ModalHapusSettingEmailGateway" tabindex="-1" role="dialog" aria-labelledby="ModalHapusSettingEmailGateway" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light"><i class="ti ti-trash"></i> Hapus Setting Email</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusSettingEmailGateway">
                <!---- Konfirmasi Hapus Email Gateway----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Setting Satu Sehat---->
<div class="modal fade" id="ModalSettingSatuSehat" tabindex="-1" role="dialog" aria-labelledby="ModalSettingSatuSehat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti ti-more"></i> Profile Setting Satu Sehat</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th align="center"><dt>NO</dt></th>
                                    <th align="center"><dt>Nama/Profile Pengaturan</dt></th>
                                    <th align="center"><dt>Status</dt></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    //Jumlah Pengaturan
                                    $JumlahPengaturan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_satusehat"));
                                    if(empty($JumlahPengaturan)){
                                        echo '<tr>';
                                        echo '  <td class="center" colspan="3">Belum Ada Pengaturan Yang Tersimpan</td>';
                                        echo '</tr>';
                                    }else{
                                        $no=1;
                                        $QrySatuSehat = mysqli_query($Conn, "SELECT*FROM setting_satusehat ORDER BY id_setting_satusehat DESC");
                                        while ($DataSatuSehat = mysqli_fetch_array($QrySatuSehat)) {
                                            $id_setting_satusehat = $DataSatuSehat['id_setting_satusehat'];
                                            $nama_setting = $DataSatuSehat['nama_setting'];
                                            $status = $DataSatuSehat['status'];
                                            $updatetime = $DataSatuSehat['updatetime'];
                                ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td>
                                            <a href="index.php?Page=Setting&Sub=SatuSehat&id=<?php echo $id_setting_satusehat; ?>" class="text-success">
                                                <?php echo "$nama_setting";?>
                                            </a>
                                            <?php echo "<br><small>$updatetime</small>";?>
                                        </td>
                                        <td align="center"><?php echo $status;?></td>
                                    </tr>
                                <?php $no++;}} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-primary">
                <a href="index.php?Page=Setting&Sub=SatuSehat&&id=Add" class="btn btn-sm btn btn-info">
                    <i class="ti ti-plus"></i> Buat Pengaturan Baru
                </a>
                <button type="button" class="btn btn-sm btn btn-inverse" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Hapus Setting Satu Sehat---->
<div class="modal fade" id="ModalHapusSettingSatuSehat" tabindex="-1" role="dialog" aria-labelledby="ModalHapusSettingSatuSehat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light"><i class="ti ti-trash"></i> Hapus Profile Setting</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusSettingSatuSehat">
                <!---- Konfirmasi Hapus Satu Sehat----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Uji Coba Setting Satu Sehat---->
<div class="modal fade" id="ModalUjiCobaSettingSatuSehat" tabindex="-1" role="dialog" aria-labelledby="ModalUjiCobaSettingSatuSehat" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="ti-control-play"></i> Uji Coba Koneksi Satu Sehat</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormUjiCobaKoneksiSatuSehat">
                <!-- Form Uji Coba Koneksi Satu Sehat -->
            </div>
            <div class="modal-footer bg-inverse">
                <button type="button" class="btn btn-sm btn btn-light" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Setting SIRS Online---->
<div class="modal fade" id="ModalSettingSirsOnline" tabindex="-1" role="dialog" aria-labelledby="ModalSettingSirsOnline" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti ti-more"></i> Profile Setting SIRS Online</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th align="center"><dt>NO</dt></th>
                                    <th align="center"><dt>Nama Profile</dt></th>
                                    <th align="center"><dt>Status</dt></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    //Jumlah Pengaturan
                                    $JumlahPengaturan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_sirs_online"));
                                    if(empty($JumlahPengaturan)){
                                        echo '<tr>';
                                        echo '  <td class="center" colspan="3">Belum Ada Pengaturan Yang Tersimpan</td>';
                                        echo '</tr>';
                                    }else{
                                        $no=1;
                                        $QrySettingSirsOnline = mysqli_query($Conn, "SELECT*FROM setting_sirs_online ORDER BY id_setting_sirs_online DESC");
                                        while ($DataSettingSirsOnline = mysqli_fetch_array($QrySettingSirsOnline)) {
                                            $id_setting_sirs_online2 = $DataSettingSirsOnline['id_setting_sirs_online'];
                                            $nama_setting_sirs_online = $DataSettingSirsOnline['nama_setting'];
                                            $id_rs_sirs_online = $DataSettingSirsOnline['id_rs'];
                                            $status_sirs_online = $DataSettingSirsOnline['status'];
                                ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td>
                                            <a href="index.php?Page=Setting&Sub=SirsOnline&id=<?php echo $id_setting_sirs_online2; ?>" class="text-success">
                                                <?php echo "$nama_setting_sirs_online";?>
                                            </a>
                                            <?php echo "<br><small>$id_rs_sirs_online</small>";?>
                                        </td>
                                        <td align="center"><?php echo $status_sirs_online;?></td>
                                    </tr>
                                <?php $no++;}} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-primary">
                <a href="index.php?Page=Setting&Sub=SirsOnline&id=Add" class="btn btn-sm btn btn-info">
                    <i class="ti ti-plus"></i> Buat Pengaturan Baru
                </a>
                <button type="button" class="btn btn-sm btn btn-inverse" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Hapus Setting Sirs Online---->
<div class="modal fade" id="ModalHapusSettingSirsOnline" tabindex="-1" role="dialog" aria-labelledby="ModalHapusSettingSirsOnline" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light"><i class="ti ti-trash"></i> Hapus Profile Setting</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusSettingSSirsOnline">
                <!---- Konfirmasi Hapus Sirs Online----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Uji Coba Setting SIRS Online---->
<div class="modal fade" id="ModalTestKoneksiSirsOnline" tabindex="-1" role="dialog" aria-labelledby="ModalTestKoneksiSirsOnline" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="ti-control-play"></i> Uji Coba Koneksi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:void(0);" id="ProsesKirimTestSirsOnline">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="x_id_rs">X-rs-id</label>
                            <input type="text" id="x_id_rs" name="x_id_rs" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="x_timestamp">X-Timestamp</label>
                            <input type="text" id="x_timestamp" name="x_timestamp" class="form-control">
                            <a href="javascript:void(0);" id="ReloadTimestamp" class="text-primary">
                                <small><i class="ti ti-reload"></i> Reload Timestamp</small>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="x_pass">X-Password</label>
                            <input type="text" id="x_pass" name="x_pass" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="ContentType">Content-Type</label>
                            <input type="text" id="ContentType" name="ContentType" class="form-control" list="ListContentType">
                            <datalist id="ListContentType">
                                <option value="text/plain">
                                <option value="text/html">
                                <option value="application/json">
                                <option value="application/xml">
                                <option value="multipart/form-data">
                                <option value="application/octet-stream">
                                <option value="image/jpeg">
                                <option value="image/png">
                                <option value="image/gif">
                                <option value="audio/mpeg">
                                <option value="audio/wav">
                                <option value="video/mp4">
                                <option value="video/quicktime">
                            </datalist>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="base_url">Base URL</label>
                            <input type="text" id="base_url" name="base_url" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="url_direction">Direction</label>
                            <input type="text" id="url_direction" name="url_direction" class="form-control" list="list_url_satu_sehat">
                            <datalist id="list_url_satu_sehat">
                                <option value="fo/index.php/Referensi/tempat_tidur">
                                <option value="fo/index.php/Fasyankes">
                                <option value="fo/index.php/Referensi/kebutuhan_sdm">
                                <option value="fo/index.php/Referensi/kebutuhan_apd">
                                <option value="fo/index.php/Fasyankes/apd">
                                <option value="fo/index.php/Pasien/pcr_nakes">
                                <option value="fo/index.php/Pasien/harian_nakes_terinfeksi">
                                <option value="fo/index.php/Logistik/oksigen">
                                <option value="fo/index.php/Pasien/shk">
                                <option value="fo/index.php/Pasien/hasilShk">
                                <option value="fo/index.php/index.php/Antrian">
                            </datalist>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="metode">Metode</label>
                            <select name="metode" id="metode" class="form-control">
                                <option value="GET">GET</option>
                                <option value="POST">POST</option>
                                <option value="PUT">PUT</option>
                                <option value="DELETE">DELETE</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="body">Body</label>
                            <textarea name="body" id="body" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="response">Response</label>
                            <textarea readonly name="response" id="response" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3" id="NotifikasiTestKoneksiSirsOnline">
                            <span class="text-primary">Pastikan anda mengirim pesan ke email yang valid.</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-inverse">
                    <button type="submit" class="btn btn-sm btn btn-success">
                        <i class="ti ti-arrow-circle-up"></i> Kirim
                    </button>
                    <button type="button" class="btn btn-sm btn btn-light" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Setting SISRUTE---->
<div class="modal fade" id="ModalSettingSisrute" tabindex="-1" role="dialog" aria-labelledby="ModalSettingSisrute" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti ti-more"></i> Profile Setting SISRUTE</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 table table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th align="center"><dt>NO</dt></th>
                                    <th align="center"><dt>Nama Profile</dt></th>
                                    <th align="center"><dt>Status</dt></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    //Jumlah Pengaturan
                                    $JumlahPengaturan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_sisrute"));
                                    if(empty($JumlahPengaturan)){
                                        echo '<tr>';
                                        echo '  <td class="center" colspan="3">Belum Ada Pengaturan Yang Tersimpan</td>';
                                        echo '</tr>';
                                    }else{
                                        $no=1;
                                        $QrySisrute = mysqli_query($Conn, "SELECT*FROM setting_sisrute ORDER BY id_setting_sisrute DESC");
                                        while ($DataSisrute = mysqli_fetch_array($QrySisrute)) {
                                            $id_setting_sisrute = $DataSisrute['id_setting_sisrute'];
                                            $nama_setting = $DataSisrute['nama_setting'];
                                            $id_rs = $DataSisrute['id_rs'];
                                            $status = $DataSisrute['status'];
                                ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td>
                                            <a href="index.php?Page=Setting&Sub=Sisrute&id=<?php echo $id_setting_sisrute; ?>" class="text-success">
                                                <?php echo "$nama_setting";?>
                                            </a>
                                            <?php echo "<br><small>$id_rs</small>";?>
                                        </td>
                                        <td align="center"><?php echo $status;?></td>
                                    </tr>
                                <?php $no++;}} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-primary">
                <a href="index.php?Page=Setting&Sub=Sisrute&id=Add" class="btn btn-sm btn btn-info">
                    <i class="ti ti-plus"></i> Buat Pengaturan Baru
                </a>
                <button type="button" class="btn btn-sm btn btn-inverse" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Hapus Setting SISRUTE---->
<div class="modal fade" id="ModalHapusSettingSisrute" tabindex="-1" role="dialog" aria-labelledby="ModalHapusSettingSisrute" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light"><i class="ti ti-trash"></i> Hapus Profile Setting</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusSettingSisrute">
                <!---- Konfirmasi Hapus Sisrute----->
            </div>
        </div>
    </div>
</div>
<!--- Modal Uji Coba Setting SISRUTE---->
<div class="modal fade" id="ModalTestKoneksiSisrute" tabindex="-1" role="dialog" aria-labelledby="ModalTestKoneksiSisrute" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-inverse">
                <b cass="text-light"><i class="ti-control-play"></i> Uji Coba Koneksi</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:void(0);" id="ProsesKirimTestSisrute">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="x_id_rs_sisrute">X-rs-id</label>
                            <input type="text" id="x_id_rs_sisrute" name="x_id_rs_sisrute" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="x_timestamp_sisrute">X-Timestamp</label>
                            <input type="text" id="x_timestamp_sisrute" name="x_timestamp_sisrute" class="form-control">
                            <a href="javascript:void(0);" id="ReloadTimestampSisrute" class="text-primary">
                                <small><i class="ti ti-reload"></i> Reload Timestamp</small>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="x_pass_sisrute">X-Password</label>
                            <input type="text" id="x_pass_sisrute" name="x_pass_sisrute" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="ContentTypeSisrute">Content-Type</label>
                            <input type="text" id="ContentTypeSisrute" name="ContentTypeSisrute" class="form-control" list="ListContentTypeSisrute">
                            <datalist id="ListContentTypeSisrute">
                                <option value="text/plain">
                                <option value="text/html">
                                <option value="application/json">
                                <option value="application/xml">
                                <option value="multipart/form-data">
                                <option value="application/octet-stream">
                                <option value="image/jpeg">
                                <option value="image/png">
                                <option value="image/gif">
                                <option value="audio/mpeg">
                                <option value="audio/wav">
                                <option value="video/mp4">
                                <option value="video/quicktime">
                            </datalist>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="base_url_sisrute">Base URL</label>
                            <input type="text" id="base_url_sisrute" name="base_url_sisrute" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="url_direction_sisrute">Direction</label>
                            <input type="text" id="url_direction_sisrute" name="url_direction_sisrute" class="form-control" list="list_url_sisrute">
                            <datalist id="list_url_sisrute">
                                <option value="api/referensi/faskes">
                                <option value="api/referensi/alasanrujukan">
                                <option value="api/referensi/diagnosa">
                            </datalist>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="metode_sisrute">Metode</label>
                            <select name="metode_sisrute" id="metode_sisrute" class="form-control">
                                <option value="GET">GET</option>
                                <option value="POST">POST</option>
                                <option value="PUT">PUT</option>
                                <option value="DELETE">DELETE</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="x_signature">X-Signature</label>
                            <textarea name="x_signature" id="x_signature" cols="30" rows="3" class="form-control"></textarea>
                            <a href="javascript:void(0);" id="GenerateSignatureSisrute" class="text-primary">
                                <small>
                                    <i class="ti ti-reload"></i>
                                    Generate Signature
                                </small>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="body_sisrute">Body</label>
                            <textarea name="body_sisrute" id="body_sisrute" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="response_sisrute">Response</label>
                            <textarea readonly name="response_sisrute" id="response_sisrute" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3" id="NotifikasiTestKoneksiSisrute">
                            <span class="text-primary">Pastikan anda mengirim data yang valid.</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-inverse">
                    <button type="submit" class="btn btn-sm btn btn-success">
                        <i class="ti ti-arrow-circle-up"></i> Kirim
                    </button>
                    <button type="button" class="btn btn-sm btn btn-light" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>