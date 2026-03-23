<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'uYR8rqHLXq');
    if($StatusAkses=="Yes"){
        $JumlahLocation=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM referensi_location"));
?>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <h4><i class="icofont-google-map"></i> Location</h4>
                                            Kelola data location termasuk data ruangan, instalasi dan sarana prasarana yang digunakan.
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <button type="button" class="btn btn-sm btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalTambahLocation" title="Tambah Location Baru">
                                                <i class="ti ti-plus"></i> Tambah Location
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body bg-light">
                                    <div class="row">
                                        <?php
                                            if(empty($JumlahLocation)){
                                                echo '  <div class="col-md-12 text-center text-danger">';
                                                echo '      Belum Ada Data Location';
                                                echo '  </div>';
                                            }else{
                                                //Menampilkan Data Location
                                                $no = 1;
                                                $QryLocation = mysqli_query($Conn, "SELECT*FROM referensi_location ORDER BY id_referensi_location DESC");
                                                while ($DataLocation = mysqli_fetch_array($QryLocation)) {
                                                    $id_referensi_location= $DataLocation['id_referensi_location'];
                                                    $nama= $DataLocation['nama'];
                                                    $kode= $DataLocation['kode'];
                                                    $kontak= $DataLocation['kontak'];
                                                    $email= $DataLocation['email'];
                                                    $managingOrganization= $DataLocation['managingOrganization'];
                                                    if(empty($DataLocation['id_location'])){
                                                        $id_location="";
                                                        $LabelIdLocation='<span class="text-dark"><small>ID Location Tidak Ada</small></span>';
                                                    }else{
                                                        $id_location= $DataLocation['id_location'];
                                                        $LabelIdLocation='<a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailLocationSatuSehat" data-id="'.$id_location.'"><small>'.$id_location.' <i class="ti ti-new-window"></i></small></a>';
                                                    }
                                        ?>
                                            
                                                <div class="col-md-6">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <dt><a href="javascript:void(0);"  data-toggle="modal" data-target="#ModalDetailLocationSimrs" data-id="<?php echo $id_referensi_location;?>" class="text-success"><?php echo "$no. $nama"; ?> <i class="ti-new-window"></i></a></dt>
                                                            <?php echo "$LabelIdLocation"; ?>
                                                        </div>
                                                        <div class="card-body bg-white">
                                                            <small>
                                                                <ul>
                                                                    <li>
                                                                        Nama : <?php echo "$nama"; ?>
                                                                    </li>
                                                                    <li>
                                                                        Kode : <?php echo "$kode"; ?>
                                                                    </li>
                                                                    <li>
                                                                        Email : <?php echo "$email"; ?>
                                                                    </li>
                                                                    <li>
                                                                        Kontak : <?php echo "$kontak"; ?>
                                                                    </li>
                                                                    <li>
                                                                        Organization : <?php if(!empty($managingOrganization)){echo '<a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailOrgId" data-id="'.$managingOrganization.'"><small>'.$managingOrganization.'</small></a>';} ?>
                                                                    </li>
                                                                </ul>
                                                            </small>
                                                        </div>
                                                        <div class="card-footer">
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalEditLocation" data-id="<?php echo $id_referensi_location;?>" title="Edit Location">
                                                                    <i class="ti ti-pencil-alt"></i> Edit
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapusLocation" data-id="<?php echo $id_referensi_location;?>" title="Hapus Location">
                                                                    <i class="ti ti-close"></i> Hapus
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php $no++;}} ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <h4><i class="ti ti-search"></i> Pencarian Location</h4>
                                            Cari Location Dari Referensi Satu Sehat
                                        </div>
                                    </div>
                                    <form action="javascript:void(0);" id="ProsesCariLocation">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <input type="text" name="KeywordLocation" id="KeywordLocation" class="form-control" placeholder="Nama Location">
                                                    <button type="submit" class="btn btn-sm btn-secondary">
                                                        <i class="ti ti-search"></i> Cari
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-body bg-light">
                                    <div class="row">
                                        <div class="col-md-12" id="HasilPencarianLocation">
                                            Belum Ada Proses Pencarian
                                            <!-- Hasil Pencarian Location -->
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
<?php 
    }else{
        include "_Page/UnPage/ErrorPageSub.php";
    }
?>