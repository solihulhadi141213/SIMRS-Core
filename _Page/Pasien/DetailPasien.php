<?php
    if(empty($_GET['id'])){
        echo '<div class="pcoded-inner-content">';
        echo '  <div class="main-body">';
        echo '      <div class="page-wrapper">';
        echo '          <div class="page-body">';
        echo '              <div class="row">';
        echo '                   <div class="col-md-12">';
        echo '                      <div class="card mb-2">';
        echo '                          <div class="card-body">';
        echo '                              ID Pasien Tidak Boleh Kosong!';
        echo '                          </div>';
        echo '                      </div>';
        echo '                  </div>';
        echo '              </div>';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        //Hapus Session URL Back
        $_SESSION['UrlBackKunjungan']='';
        $id_pasien=$_GET['id'];
        //Buka data Pasien
        $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$id_pasien'")or die(mysqli_error($Conn));
        $DataPasien = mysqli_fetch_array($QryPasien);
        $id_pasien= $DataPasien['id_pasien'];
        $noRm=sprintf("%07d", $id_pasien);
        $tanggal_daftar= $DataPasien['tanggal_daftar'];
        if(!empty($DataPasien['id_ihs'])){
            $id_ihs= $DataPasien['id_ihs'];
            $id_ihs='<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailIhs" data-id="'.$id_ihs.'"><small>'.$id_ihs.'  <i class="ti ti-new-window"></i></small></a>';
        }else{
            $id_ihs='<span class="text-danger">Tidak Ada</span>';
        }
        if(!empty($DataPasien['nik'])){
            $nik= $DataPasien['nik'];
            $nik='<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailNik" data-id="'.$nik.'"><small>'.$nik.' <i class="ti ti-new-window"></i></small></a>';
        }else{
            $nik='<span class="text-danger">Tidak Ada</span>';
        }
        if(!empty($DataPasien['no_bpjs'])){
            $no_bpjs= $DataPasien['no_bpjs'];
            $no_bpjs='<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailBpjs" data-id="'.$no_bpjs.'"><small>'.$no_bpjs.' <i class="ti ti-new-window"></i></small></a>';
        }else{
            $no_bpjs='<span class="text-danger">Tidak Ada</span>';
        }
        $nama= $DataPasien['nama'];
        if(!empty($DataPasien['gender'])){
            $gender= $DataPasien['gender'];
            //Inisiasi gender 
            if($gender=="Laki-laki"){
                $labelGender='<label class="label label-info">Male</label>';
            }else{
                if($gender=="Perempuan"){
                    $labelGender='<label class="label label-primary">Female</label>';
                }else{
                    $labelGender='<label class="label label-danger">None</label>';
                }
            }
        }else{
            $gender="";
            $labelGender='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['tempat_lahir'])){
            $tempat_lahir= $DataPasien['tempat_lahir'];
        }else{
            $tempat_lahir='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['tanggal_lahir'])){
            $tanggal_lahir= $DataPasien['tanggal_lahir'];
            $strtotime= strtotime($tanggal_lahir);
            $tanggal_lahir=date('d/m/Y', $strtotime);
        }else{
            $tanggal_lahir='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['propinsi'])){
            $propinsi= $DataPasien['propinsi'];
        }else{
            $propinsi='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['kabupaten'])){
            $kabupaten= $DataPasien['kabupaten'];
        }else{
            $kabupaten='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['kecamatan'])){
            $kecamatan= $DataPasien['kecamatan'];
        }else{
            $kecamatan='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['desa'])){
            $desa= $DataPasien['desa'];
        }else{
            $desa='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['alamat'])){
            $alamat= $DataPasien['alamat'];
        }else{
            $alamat='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['kontak'])){
            $kontak= $DataPasien['kontak'];
        }else{
            $kontak='<span class="text-danger">Tidak Ada</span>';
        }
        if(!empty($DataPasien['kontak_darurat'])){
            $kontak_darurat= $DataPasien['kontak_darurat'];
        }else{
            $kontak_darurat='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['penanggungjawab'])){
            $penanggungjawab= $DataPasien['penanggungjawab'];
        }else{
            $penanggungjawab='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['golongan_darah'])){
            $golongan_darah= $DataPasien['golongan_darah'];
        }else{
            $golongan_darah='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['perkawinan'])){
            $perkawinan= $DataPasien['perkawinan'];
        }else{
            $perkawinan='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['pekerjaan'])){
            $pekerjaan= $DataPasien['pekerjaan'];
        }else{
            $pekerjaan='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['gambar'])){
            $gambar= $DataPasien['gambar'];
            $LinkGambar='assets/images/pasien/'.$gambar.'';
        }else{
            $gambar="";
            $LinkGambar='assets/images/No-Image.png';
        }
        if(!empty($DataPasien['updatetime'])){
            $updatetime= $DataPasien['updatetime'];
            $strtotime=strtotime($updatetime);
            $updatetime=date('d/m/Y H:i',$strtotime);
        }else{
            $updatetime='<span class="text-danger">Tidak Diketahui</span>';
        }
        if(!empty($DataPasien['status'])){
            $status= $DataPasien['status'];
            if($status=="Aktiv"){
                $LabelData='<label class="label label-success"><i class="ti ti-check-box"></i> Aktiv</label>';
            }else{
                if($status=="Meninggal"){
                    $LabelData='<label class="label label-danger"><i class="icofont-close-squared"></i> Meninggal</label>';
                }else{
                    $LabelData='<label class="label label-info">'.$status.'</label>';
                }
            }
        }else{
            $status='Tidak Diketahui';
            $LabelData='<label class="label label-danger">'.$status.'</label>';
        }
        //Format Tanggal Daftar
        $strtotime=strtotime($tanggal_daftar);
        $TanggalDaftarFormat=date('d/m/Y H:i',$strtotime);
        if(!empty($DataPasien['nama_petugas'])){
            $nama_petugas= $DataPasien['nama_petugas'];
        }else{
            $nama_petugas='<span class="text-danger">Tidak Diketahui</span>';
        }
?>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="row">
                                <div class="col-md-9 mb-2">
                                    <a href="index.php?Page=Pasien" class="btn btn-sm btn-secondary btn-block">
                                        <i class="ti ti-angle-left"></i> Kembali
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <button type="button" class="btn btn-sm btn-block btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                                        Option
                                    </button>
                                    <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalKonfirmasiEditPasien" data-id="<?php echo $id_pasien; ?>">
                                            <i class="ti-pencil"></i> Edit
                                        </a>
                                        <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusPasien" data-id="<?php echo $id_pasien; ?>">
                                            <i class="ti-trash"></i> Hapus
                                        </a>
                                        <a class="dropdown-item waves-effect waves-light" href="_Page/Pasien/CetakKartuPdf.php?id_pasien=<?php echo "$id_pasien"; ?>" target="_blank">
                                            <i class="fa fa-file-pdf-o"></i> Cetak Kartu (PDF)
                                        </a>
                                        <a class="dropdown-item waves-effect waves-light" href="_Page/Pasien/CetakKartuHtml.php?id_pasien=<?php echo "$id_pasien";?>" target="_blank">
                                            <i class="fa fa-html5"></i> Cetak Kartu (HTML)
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <h4><i class="ti ti-info-alt"></i> Detail Pasien</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body table table-responsive">
                                            <table class="table table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td><dt>NO.RM</dt></td>
                                                        <td><small id="GetIdPasien"><?php echo $id_pasien; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>NAMA</dt></td>
                                                        <td><small><?php echo $nama; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>IHS</dt></td>
                                                        <td>
                                                            <small>
                                                                <?php 
                                                                    echo "$id_ihs<br>"; 
                                                                    if(empty($DataPasien['id_ihs'])){
                                                                        echo '<a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalCreatIhs" data-id="'.$id_pasien.'">';
                                                                        echo '  <small><i class="ti ti-plus"></i> Buat IHS Pasien</small>';
                                                                        echo '</a>';
                                                                    }
                                                                ?>
                                                            </small>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>Tanggal Daftar</dt></td>
                                                        <td><small><?php echo $TanggalDaftarFormat; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>NIK</dt></td>
                                                        <td><small><?php echo $nik; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>NO.BPJS</dt></td>
                                                        <td><small><?php echo $no_bpjs; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>GENDER</dt></td>
                                                        <td><small><?php echo $labelGender; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>TEMPAT LAHIR</dt></td>
                                                        <td><small><?php echo $tempat_lahir; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>TANGGAL LAHIR</dt></td>
                                                        <td><small><?php echo $tanggal_lahir; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>ALAMAT</dt></td>
                                                        <td><small><?php echo $alamat; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>PROVINSI</dt></td>
                                                        <td><small><?php echo $propinsi; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>KABUPATEN</dt></td>
                                                        <td><small><?php echo $kabupaten; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>KECAMATAN</dt></td>
                                                        <td><small><?php echo $kecamatan; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>DESA</dt></td>
                                                        <td><small><?php echo $desa; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>KONTAK</dt></td>
                                                        <td><small><?php echo $kontak; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>KONTAK DARURAT</dt></td>
                                                        <td><small><?php echo $kontak_darurat; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>PENANGGUNG JAWAB</dt></td>
                                                        <td><small><?php echo $penanggungjawab; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>GOLONGAN DARAH</dt></td>
                                                        <td><small><?php echo $golongan_darah; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>PERNIKAHAN</dt></td>
                                                        <td><small><?php echo $perkawinan; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>PEKERJAAN</dt></td>
                                                        <td><small><?php echo $pekerjaan; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>PEKERJAAN</dt></td>
                                                        <td><small><?php echo $pekerjaan; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>UPDATETIME</dt></td>
                                                        <td><small><?php echo $updatetime; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>PETUGAS</dt></td>
                                                        <td><small><?php echo $nama_petugas; ?></small></td>
                                                    </tr>
                                                    <tr>
                                                        <td><dt>STATUS</dt></td>
                                                        <td><small><?php echo $LabelData; ?></small></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card mb-2">
                                <form action="javascript:void(0);" id="ProsesUploadFotoPasien">
                                    <input type="hidden" id="UploadIdPasien" name="UploadIdPasien" value="<?php echo $id_pasien; ?>">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4><i class="icofont-image"></i> Foto Pasien</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <img src="<?php echo $LinkGambar;?>" alt="" class="" width="150px" height="150px">
                                            </div>
                                            <div class="col-md-8 mb-3">
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <input type="file" class="form-control" name="Fotopasien" name="FotoPasien">
                                                        <small id="NotifikasiUploadFotoPasien">Foto Tidak Boleh Lebih Dari 1 Mb (PNG, JPG, JPEG, GIF)</small>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <button type="submit" class="btn btn-sm btn-primary btn-block">
                                                            <i class="ti ti-upload"></i> Upload Foto
                                                        </button>
                                                    </div>
                                                    <?php
                                                        if(!empty($DataPasien['gambar'])){
                                                            echo '<div class="col-md-6 mb-3">';
                                                            echo '  <button type="button" class="btn btn-sm btn-outline-danger btn-block" data-toggle="modal" data-target="#ModalHapusFoto" data-id="'.$id_pasien.'">';
                                                            echo '      <i class="ti ti-trash"></i> Hapus Foto';
                                                            echo '  </button>';
                                                            echo '</div>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h4><i class="icofont-patient-file"></i> Riwayat Kunjungan</h4>
                                </div>
                                <div class="card-body bg-light">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <button type="button" class="btn btn-sm btn-primary btn-block" data-toggle="modal" data-target="#ModalKonfirmasiBuatKunjungan" data-id="<?php echo "$id_pasien"; ?>">
                                                <i class="ti ti-plus"></i> Buat Kunjungan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="MenampilkanTabelRiwayatKunjungan">
                                    <!--  Menampilkan data Riwayat Kunjungan Pasien disini -->
                                </div>
                            </div> 
                            <?php
                                if(!empty($DataPasien['no_bpjs'])){ 
                                    $today = date('Y-m-d');
                                    $year = date('Y');
                                    $month = date('m');
                                    $firstDayOfMonth = date('Y-m-d', strtotime("$year-$month-01"));
                            ?>
                                <div class="card">
                                    <div class="card-header">
                                        <h4><i class="icofont-patient-file"></i> History Pelayanan Peserta (BPJS)</h4>
                                    </div>
                                    <div class="card-body bg-light">
                                        <form action="javascript:void(0);" id="ProsesTampilkanHistorySep">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <input type="text" readonly class="form-control" name="GetNoKartuPeserta" id="GetNoKartuPeserta" value="<?php echo $DataPasien['no_bpjs']; ?>">
                                                    <label for="GetNoKartuPeserta">Nomor Kartu</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <input type="date" class="form-control" name="PeriodeAwal" id="PeriodeAwal" value="<?php echo $firstDayOfMonth;?>">
                                                    <label for="PeriodeAwal">Periode Awal</label>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <input type="date" class="form-control" name="PeriodeAkhir" id="PeriodeAkhir" value="<?php echo date('Y-m-d'); ?>">
                                                    <label for="PeriodeAkhir">Periode Akhir</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary btn-block">
                                                        <i class="ti ti-angle-double-down"></i> Tampilkan
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="row">
                                            <div class="col-md-12 mb-3" id="ListRiwayatSep">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            <?php } ?>
                            <div class="card">
                                <div class="card-header">
                                    <h4><i class="icofont-prescription"></i> Consent</h4>
                                </div>
                                <div class="card-body bg-light">
                                    <div class="row">
                                        <div class="col-md-12 mb-3 text-center">
                                            Fitur Consent berungsi untuk menginformasikan atau meminta persetujuan/izin dari pemilik 
                                            data yang bersangkutan (pasien) agar diperbolehkan untuk diakses oleh pihak lain (organisasi) 
                                            yang juga terdaftar secara sah dan memiliki akses pada ekosistem SATUSEHAT.
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <?php
                                                if(empty($DataPasien['id_ihs'])){
                                                    echo '<span class="text-danger">Pasien bersangkutan belum memiliki ID IHS Satu Sehat. Lengkapi data terlebih dulu.</span>';
                                                }else{
                                                    //Cek Consent
                                                    $id_patient=$DataPasien['id_ihs'];
                                                    echo '<input type="hidden" id="id_patient" value="'.$id_patient.'">';
                                                    echo '<div class="row mb-3">';
                                                    echo '  <div class="col-md-6">';
                                                    echo '      <button type="button" class="btn btn-sm btn-secondary btn-block" id="ReloadConsent">';
                                                    echo '          <i class="ti ti-reload"></i> Reload';
                                                    echo '      </button>';
                                                    echo '  </div>';
                                                    echo '  <div class="col-md-6">';
                                                    echo '      <button type="button" class="btn btn-sm btn-info btn-block" data-toggle="modal" data-target="#ModalUpdateConsent" data-id="'.$id_patient.'">';
                                                    echo '          <i class="ti ti-pencil"></i> Update';
                                                    echo '      </button>';
                                                    echo '  </div>';
                                                    echo '</div>';
                                                    echo '<div class="row mb-3">';
                                                    echo '  <div class="col-md-12" id="MenampilkanStatusConsent">';
                                                    echo '';
                                                    echo '  </div>';
                                                    echo '</div>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>