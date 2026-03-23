<?php
    //Koneksi
    include "../../_Config/Connection.php";
    //id_pasien
    if(empty($_POST['id_pasien'])){
        echo '<span class="text-danger">Tidak Ada ID Pasien Yang Ditangkap!!</span>';
    }else{
        $id_pasien=$_POST['id_pasien'];
        //Membuka data pasien
        $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$id_pasien'")or die(mysqli_error($Conn));
        $DataPasien = mysqli_fetch_array($QryPasien);
        $id_pasien= $DataPasien['id_pasien'];
        $tanggal_daftar= $DataPasien['tanggal_daftar'];
        $nik= $DataPasien['nik'];
        $no_bpjs= $DataPasien['no_bpjs'];
        $nama= $DataPasien['nama'];
        $gender= $DataPasien['gender'];
        $tempat_lahir= $DataPasien['tempat_lahir'];
        $tanggal_lahir= $DataPasien['tanggal_lahir'];
        $propinsi= $DataPasien['propinsi'];
        $kabupaten= $DataPasien['kabupaten'];
        $kecamatan= $DataPasien['kecamatan'];
        $desa= $DataPasien['desa'];
        $alamat= $DataPasien['alamat'];
        $kontak= $DataPasien['kontak'];
        $kontak_darurat= $DataPasien['kontak_darurat'];
        $penanggungjawab= $DataPasien['penanggungjawab'];
        $golongan_darah= $DataPasien['golongan_darah'];
        $perkawinan= $DataPasien['perkawinan'];
        $pekerjaan= $DataPasien['pekerjaan'];
        $status= $DataPasien['status'];
        $gambar= $DataPasien['gambar'];
        $updatetime= $DataPasien['updatetime'];
?>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 pre-scrollable">
                <div class="table table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>
                                    <dt>No.RM</dt>
                                    <?php echo "$id_pasien"; ?>
                                </td>
                                <td>
                                    <dt>Tanggal Daftar</dt>
                                    <?php echo "$tanggal_daftar"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Nama Pasien</dt>
                                    <?php echo "$nama"; ?>
                                </td>
                                <td>
                                    <dt>No.KTP/NIK</dt>
                                    <?php echo "$nik"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Gender</dt>
                                    <?php echo "$gender"; ?>
                                </td>
                                <td>
                                    <dt>No.BJS</dt>
                                    <?php echo "$no_bpjs"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Tempat, Tanggal Lahir</dt>
                                    <?php echo "$tempat_lahir, $tanggal_lahir"; ?>
                                </td>
                                <td>
                                    <dt>Alamat</dt>
                                    <?php echo "$alamat"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Desa</dt>
                                    <?php echo "$desa"; ?>
                                </td>
                                <td>
                                    <dt>Kecamatan</dt>
                                    <?php echo "$kecamatan"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Kabupaten</dt>
                                    <?php echo "$kabupaten"; ?>
                                </td>
                                <td>
                                    <dt>Propinsi</dt>
                                    <?php echo "$propinsi"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Kontak</dt>
                                    <?php echo "$kontak"; ?>
                                </td>
                                <td>
                                    <dt>Kontak Darurat</dt>
                                    <?php echo "$kontak_darurat"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Penanggung Jawab</dt>
                                    <?php echo "$penanggungjawab"; ?>
                                </td>
                                <td>
                                    <dt>Golongan Darah</dt>
                                    <?php echo "$golongan_darah"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Perkawinan</dt>
                                    <?php echo "$perkawinan"; ?>
                                </td>
                                <td>
                                    <dt>Pekerjaan</dt>
                                    <?php echo "$pekerjaan"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Status</dt>
                                    <?php echo "$status"; ?>
                                </td>
                                <td>
                                    <dt>Updatetime</dt>
                                    <?php echo "$updatetime"; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-inverse">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-md btn-light mt-2 mr-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php } ?>