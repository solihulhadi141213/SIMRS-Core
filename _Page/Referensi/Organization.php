<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'iaSALIjrf2');
    if($StatusAkses=="Yes"){
        $JumlahOrganisasi=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM referensi_organisasi WHERE part_of_ID=''"));
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
                                            <h4><i class="icofont-chart-flow-1"></i> Organization</h4>
                                            Kelola Data Unit, Departemen atau divisi yang tersedia di faskes.
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <button type="button" class="btn btn-sm btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalTambahOrganisasi" title="Tambah Organisasi Baru">
                                                <i class="ti ti-plus"></i> Tambah Organisasi
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body bg-light">
                                    <div class="row">
                                        <?php
                                            if(empty($JumlahOrganisasi)){
                                                echo '<div class="row mb-3">';
                                                echo '  <div class="col-md-12 text-center text-danger">';
                                                echo '      Belum Ada Data Organisasi';
                                                echo '  </div>';
                                                echo '</div>';
                                            }else{
                                                //Menampilkan Data Organisasi
                                                $no = 1;
                                                //KONDISI PENGATURAN MASING FILTER
                                                $QryOrganisasi = mysqli_query($Conn, "SELECT*FROM referensi_organisasi ORDER BY id_referensi_organisasi DESC");
                                                while ($DataOrganisasi = mysqli_fetch_array($QryOrganisasi)) {
                                                    $id_referensi_organisasi= $DataOrganisasi['id_referensi_organisasi'];
                                                    $NamaOrganisasi= $DataOrganisasi['nama'];
                                                    $IdentifierOrganisasi= $DataOrganisasi['identifier'];
                                                    $TipeOrganisasi= $DataOrganisasi['tipe'];
                                                    $EmailOrganisasi= $DataOrganisasi['email'];
                                                    $KontakOrganisasi= $DataOrganisasi['kontak'];
                                                    if(empty($DataOrganisasi['part_of_ID'])){
                                                        $part_of_ID="";
                                                    }else{
                                                        $part_of_ID= $DataOrganisasi['part_of_ID'];
                                                    }
                                                    if(empty($DataOrganisasi['ID_Org'])){
                                                        $ID_OrgVal="";
                                                        $ID_Org='<small class="text-danger">Tidak Ada ID-ORG</small>';
                                                    }else{
                                                        $ID_OrgVal=$DataOrganisasi['ID_Org'];
                                                        $ID_Org='<a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailOrgId" data-id="'.$ID_OrgVal.'" title="Lihat Data ID Di Satu Sehat"><small>'.$ID_OrgVal.' <i class="ti-new-window"></i></small></a>';
                                                    }
                                                    //Menghitung Jumlah Sub
                                                    $JumlahSubOrganisasi=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM referensi_organisasi WHERE part_of_ID!='' AND part_of_ID='$ID_OrgVal'"));
                                                    if(!empty($JumlahSubOrganisasi)){
                                                        $LabelJumlahSub='<span class="text-success">'.$JumlahSubOrganisasi.' Organisasi</span>';
                                                    }else{
                                                        $LabelJumlahSub='<span class="text-dark">0 Organisasi</span>';
                                                    }
                                        ?>
                                            
                                                <div class="col-md-6">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <dt><a href="javascript:void(0);"  data-toggle="modal" data-target="#ModalDetailOrganisasiSimrs" data-id="<?php echo $id_referensi_organisasi;?>" class="text-success"><?php echo "$no. $NamaOrganisasi"; ?> <i class="ti-new-window"></i></a></dt>
                                                            <?php echo "$ID_Org"; ?>
                                                        </div>
                                                        <div class="card-body bg-white">
                                                            <small>
                                                                <ul>
                                                                    <li>
                                                                        Identifier : <?php echo "$IdentifierOrganisasi"; ?>
                                                                    </li>
                                                                    <li>
                                                                        Tipe : <?php echo "$TipeOrganisasi"; ?>
                                                                    </li>
                                                                    <li>
                                                                        Email : <?php echo "$EmailOrganisasi"; ?>
                                                                    </li>
                                                                    <li>
                                                                        Kontak : <?php echo "$KontakOrganisasi"; ?>
                                                                    </li>
                                                                    <li>
                                                                        Sub : <?php echo "$LabelJumlahSub"; ?>
                                                                    </li>
                                                                </ul>
                                                            </small>
                                                        </div>
                                                        <div class="card-footer">
                                                            <div class="btn-group">
                                                                <button type="button" <?php if(empty($DataOrganisasi['ID_Org'])){echo "disabled";} ?> class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalTambahOrganisasi" data-id="<?php echo $ID_OrgVal;?>" title="Tambah Sub Organisasi">
                                                                    <i class="ti-plus"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-dark"  data-toggle="modal" data-target="#ModalDetailOrganisasiSimrs" data-id="<?php echo $id_referensi_organisasi;?>" title="Detail Organisasi Dari SIMRS">
                                                                    <i class="ti ti-info-alt"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalEditOrganisasi" data-id="<?php echo $id_referensi_organisasi;?>" title="Edit Organisasi">
                                                                    <i class="ti ti-pencil-alt"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapusOrganisasi" data-id="<?php echo $id_referensi_organisasi;?>" title="Hapus Organisasi">
                                                                    <i class="ti ti-close"></i>
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
                                            <h4><i class="ti ti-search"></i> Pencarian Organization</h4>
                                            Cari Organisasi Dari Referensi Satu Sehat
                                        </div>
                                    </div>
                                    <form action="javascript:void(0);" id="ProsewsCariOrganisasiSatuSehat">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <input type="text" name="KywordOrganization" id="KywordOrganization" class="form-control" placeholder="Nama Organisasi">
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
                                        <div class="col-md-12 mb-3" id="HasilPencarianOrganisasi">
                                            Belum Ada Proses Pencarian
                                            <!-- Hasil Pencarian Organisasi -->
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