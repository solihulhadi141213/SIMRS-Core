<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_pasien
    if(empty($_POST['id_pasien'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Akses Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_pasien=$_POST['id_pasien'];
        //Buka data Pasien
        $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$id_pasien'")or die(mysqli_error($Conn));
        $DataPasien = mysqli_fetch_array($QryPasien);
        $id_pasien= $DataPasien['id_pasien'];
        $noRm=sprintf("%07d", $id_pasien);
        $tanggal_daftar= $DataPasien['tanggal_daftar'];
        $strtotimedaftar=strtotime($tanggal_daftar);
        $tanggal_daftar=date('d/m/Y H:i:s',$strtotimedaftar);
        if(!empty($DataPasien['id_ihs'])){
            $id_ihs= $DataPasien['id_ihs'];
        }else{
            $id_ihs='<span class="text-danger">Tidak Ada</span>';
        }
        if(!empty($DataPasien['nik'])){
            $nik= $DataPasien['nik'];
        }else{
            $nik='<span class="text-danger">Tidak Ada</span>';
        }
        if(!empty($DataPasien['no_bpjs'])){
            $no_bpjs= $DataPasien['no_bpjs'];
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
            $tanggal_lahir_obj = new DateTime($tanggal_lahir);
            $tanggal_sekarang = new DateTime();
            $selisih_tahun = $tanggal_lahir_obj->diff($tanggal_sekarang)->y;
            if($selisih_tahun<1){
                $usia = $tanggal_lahir_obj->diff($tanggal_sekarang)->m;
                $usia_name ="$usia Bulan";
                if($usia<1){
                    $usia = $tanggal_lahir_obj->diff($tanggal_sekarang)->d;
                    $usia_name ="$usia Hari";
                }
            }else{
                $usia = $tanggal_lahir_obj->diff($tanggal_sekarang)->y;
                $usia_name ="$usia Tahun";
            }
            $strtotime= strtotime($tanggal_lahir);
            $tanggal_lahir=date('d/m/Y', $strtotime);
        }else{
            $tanggal_lahir='<span class="text-danger">Tidak Diketahui</span>';
            $usia_name='<span class="text-danger">Tidak Diketahui</span>';
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
            $LinkGambar='<a href="../../assets/images/pasien/'.$gambar.'" target="_blank">'.$gambar.' <i class="ti ti-new-window"></i></a>';
        }else{
            $gambar="";
            $LinkGambar='<span class="text-danger">Tidak Ada</span>';
        }
        if(!empty($DataPasien['updatetime'])){
            $updatetime= $DataPasien['updatetime'];
            $strtotime=strtotime($updatetime);
            $updatetime=date('d/m/Y H:i:s',$strtotime);
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
        if(!empty($DataPasien['nama_petugas'])){
            $nama_petugas= $DataPasien['nama_petugas'];
        }else{
            $nama_petugas='<span class="text-danger">Tidak Diketahui</span>';
        }
?>
    <div class="modal-body border-0 pb-0 mb-4">
        <div class="row">
            <div class="col-md-12">
                <div id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="accordion-panel">
                        <div class="accordion-heading" role="tab" id="headingOne">
                            <h3 class="card-title accordion-title">
                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <dt>A. Informasi Umum</dt>
                                </a>
                            </h3>
                        </div>
                    </div>
                    <div id="collapseOne" class="panel-collapse in collapse show" role="tabpanel" aria-labelledby="headingOne" style="">
                        <div class="accordion-content accordion-desc">
                            <div class="row mb-3">
                                <div class="col-md-6">1. No.RM</div>
                                <div class="col-md-6 text-right"><?php echo "$id_pasien"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">2. IHS</div>
                                <div class="col-md-6 text-right"><?php echo "$id_ihs"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">3. NIK</div>
                                <div class="col-md-6 text-right"><?php echo "$nik"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">4. BPJS</div>
                                <div class="col-md-6 text-right"><?php echo "$no_bpjs"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">5. Nama</div>
                                <div class="col-md-6 text-right"><?php echo "$nama"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">6. Gender</div>
                                <div class="col-md-6 text-right"><?php echo "$labelGender"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">7. Golongan Darah</div>
                                <div class="col-md-6 text-right"><?php echo "$golongan_darah"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">8. Link Foto</div>
                                <div class="col-md-6 text-right"><?php echo "$LinkGambar"; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="accordion-panel">
                        <div class="accordion-heading" role="tab" id="headingTwo">
                            <h3 class="card-title accordion-title">
                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    <dt>B. Kelahiran</dt>
                                </a>
                            </h3>
                        </div>
                    </div>
                    <div id="collapseTwo" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingTwo" style="">
                        <div class="accordion-content accordion-desc">
                            <div class="row mb-3">
                                <div class="col-md-6">1. Tempat Lahir</div>
                                <div class="col-md-6 text-right"><?php echo "$tempat_lahir"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">2. Tanggal Lahir</div>
                                <div class="col-md-6 text-right"><?php echo "$tanggal_lahir"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">3. Usia Sekarang</div>
                                <div class="col-md-6 text-right"><?php echo "$usia_name"; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="accordion-panel">
                        <div class="accordion-heading" role="tab" id="headingTree">
                            <h3 class="card-title accordion-title">
                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#collapseTree" aria-expanded="true" aria-controls="collapseTree">
                                    <dt>C. Alamat Tinggal</dt>
                                </a>
                            </h3>
                        </div>
                    </div>
                    <div id="collapseTree" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingTree" style="">
                        <div class="accordion-content accordion-desc">
                            <div class="row mb-3">
                                <div class="col-md-6">1. Provinsi</div>
                                <div class="col-md-6 text-right"><?php echo "$propinsi"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">2. Kabupaten</div>
                                <div class="col-md-6 text-right"><?php echo "$kabupaten"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">3. Kecamatan</div>
                                <div class="col-md-6 text-right"><?php echo "$kecamatan"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">4. Desa/Kelurahan</div>
                                <div class="col-md-6 text-right"><?php echo "$desa"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">5. Gang/RT/RW</div>
                                <div class="col-md-6 text-right"><?php echo "$alamat"; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="accordion-panel">
                        <div class="accordion-heading" role="tab" id="headingFour">
                            <h3 class="card-title accordion-title">
                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                    <dt>C. Kontak & Penanggung Jawab</dt>
                                </a>
                            </h3>
                        </div>
                    </div>
                    <div id="collapseFour" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingFour" style="">
                        <div class="accordion-content accordion-desc">
                            <div class="row mb-3">
                                <div class="col-md-6">1. Kontak Pasien</div>
                                <div class="col-md-6 text-right"><?php echo "$kontak"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">2. Kontak Darurat</div>
                                <div class="col-md-6 text-right"><?php echo "$kontak_darurat"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">3. Penanggung Jawab</div>
                                <div class="col-md-6 text-right"><?php echo "$penanggungjawab"; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="accordion-panel">
                        <div class="accordion-heading" role="tab" id="headingFive">
                            <h3 class="card-title accordion-title">
                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                    <dt>D. Sosial Budaya</dt>
                                </a>
                            </h3>
                        </div>
                    </div>
                    <div id="collapseFive" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingFive" style="">
                        <div class="accordion-content accordion-desc">
                            <div class="row mb-3">
                                <div class="col-md-6">1. Status Pernikahan</div>
                                <div class="col-md-6 text-right"><?php echo "$perkawinan"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">2. Pekerjaan</div>
                                <div class="col-md-6 text-right"><?php echo "$pekerjaan"; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="accordion-panel">
                        <div class="accordion-heading" role="tab" id="headingSix">
                            <h3 class="card-title accordion-title">
                                <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                                    <dt>E. Informasi Pendaftaran</dt>
                                </a>
                            </h3>
                        </div>
                    </div>
                    <div id="collapseSix" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingSix" style="">
                        <div class="accordion-content accordion-desc">
                            <div class="row mb-3">
                                <div class="col-md-6">1. Petugas Pendaftaran</div>
                                <div class="col-md-6 text-right"><?php echo "$nama_petugas"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">2. Tanggal Daftar</div>
                                <div class="col-md-6 text-right"><?php echo "$tanggal_daftar"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">3. Update</div>
                                <div class="col-md-6 text-right"><?php echo "$updatetime"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">4. Status</div>
                                <div class="col-md-6 text-right"><?php echo "$LabelData"; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-inverse">
        <div class="row">
            <div class="col-md-12">
                <!-- <div class="btn-group dropdown-split-inverse">
                    <button type="button" class="btn btn-md btn-inverse dropdown-toggle dropdown-toggle-split waves-effect waves-light mb-3 ml-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                        Option
                    </button>
                    <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalEditPasien">
                            <i class="ti-pencil"></i> Edit
                        </a>
                        <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusPasien">
                            <i class="ti-trash"></i> Hapus
                        </a>
                        <a class="dropdown-item waves-effect waves-light" href="_Page/Pasien/CetakKartuPdf.php?id_pasien=<?php echo "$id_pasien"; ?>" target="_blank">
                            <i class="fa fa-file-pdf-o"></i> Cetak Kartu (PDF)
                        </a>
                        <a class="dropdown-item waves-effect waves-light" href="_Page/Pasien/CetakKartuHtml.php?id_pasien=<?php echo "$id_pasien";?>" target="_blank">
                            <i class="fa fa-html5"></i> Cetak Kartu (HTML)
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalKunjunganPasien">
                            <i class="icofont-stethoscope-alt"></i> Kunjungan
                        </a>
                    </div>
                </div> -->
                    <a href="index.php?Page=Pasien&Sub=DetailPasien&id=<?php echo $id_pasien; ?>" class="btn btn-sm btn-primary mr-3">
                        Selengkapnya <i class="ti ti-more-alt"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>