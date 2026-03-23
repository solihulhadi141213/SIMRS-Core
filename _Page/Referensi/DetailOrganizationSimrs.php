<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <?php
                    if(empty($_GET['id'])){
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-12">';
                        echo '      <div class="card">';
                        echo '          <div class="card-body text-danger">';
                        echo '              ID Organisasi Tidak Boleh Kosong!';
                        echo '          </div>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        //Buka Detail Organisasi
                        $id_referensi_organisasi=$_GET['id'];
                        //Buka Detail Data
                        $nama=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'nama');
                        $identifier=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'identifier');
                        $tipe=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'tipe');
                        $email=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'email');
                        $kontak=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'kontak');
                        $part_of_ID=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'part_of_ID');
                        $ID_Org=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'ID_Org');
                        if(empty($part_of_ID)){
                            $part_of_ID="Utama";
                        }else{
                            $part_of_ID=getDataDetail($Conn,'referensi_organisasi','id_referensi_organisasi',$id_referensi_organisasi,'part_of_ID');
                        }
                        if(empty($ID_Org)){
                            $ID_OrgLabel='<small class="text-danger">Tidak Ada ID-ORG</small>';
                        }else{
                            $ID_OrgLabel='<a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailOrgId" data-id="'.$ID_Org.'" title="Lihat Data ID Di Satu Sehat"><small>'.$ID_Org.' <i class="ti-layers"></i></small></a>';
                        }
                ?>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <h4><i class="ti ti-info-alt"></i> Detail Organisasi SIMRS</h4>
                                            Berikut ini adalah informasi detail organisasi yang diambil dari database SIMRS
                                        </div>
                                        <div class="col-md-12">
                                            <a href="index.php?Page=Referensi&Sub=Organization" class="btn btn-sm btn-secondary btn-block">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body bg-light">
                                    <div class="row mb-3">
                                        <div class="col-md-6"><dt>Nama</dt></div>
                                        <div class="col-md-6"><small><?php echo "$nama"; ?></small></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6"><dt>Identifier</dt></div>
                                        <div class="col-md-6"><small><?php echo "$identifier"; ?></small></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6"><dt>Tipe</dt></div>
                                        <div class="col-md-6"><small><?php echo "$tipe"; ?></small></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6"><dt>Email</dt></div>
                                        <div class="col-md-6"><small><?php echo "$email"; ?></small></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6"><dt>Kontak</dt></div>
                                        <div class="col-md-6"><small><?php echo "$kontak"; ?></small></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6"><dt>ID ORG</dt></div>
                                        <div class="col-md-6"><small><?php echo "$ID_OrgLabel"; ?></small></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6"><dt>Part Of</dt></div>
                                        <div class="col-md-6"><small><?php echo "$part_of_ID"; ?></small></div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalEditOrganisasi" data-id="<?php echo $id_referensi_organisasi;?>" title="Edit Organisasi">
                                        <i class="ti ti-pencil-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapusOrganisasi" data-id="<?php echo $id_referensi_organisasi;?>" title="Hapus Organisasi">
                                        <i class="ti ti-close"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <h4><i class="ti ti-align-left"></i> Data Sub Organisasi</h4>
                                            Data Sub Organisasi yang berkaitan dengan organisasi ini akan muncul pada tab berikut
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-sm btn-primary btn-block" <?php if(empty($ID_Org)){echo "disabled";} ?> data-toggle="modal" data-target="#ModalTambahOrganisasi" data-id="<?php echo $ID_Org;?>" title="Tambah Sub Organisasi">
                                                <i class="ti ti-plus"></i> Sub Organisasi
                                            </button>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="card-body bg-light">
                                    <?php
                                        //Juml;ah Sub Organisasi
                                        $JumlahSubOrganisasi=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM referensi_organisasi WHERE part_of_ID='$ID_Org'"));
                                        if(empty($JumlahSubOrganisasi)){
                                            echo '<div class="row">';
                                            echo '  <div class="col-md-12 text-center text-danger">';
                                            echo '      Tidak Ada Data Sub Organisasi';
                                            echo '  </div>';
                                            echo '</div>';
                                        }else{
                                            //menampilkan Sub Organisasi
                                            //Menampilkan Data Organisasi
                                            $no = 1;
                                            //KONDISI PENGATURAN MASING FILTER
                                            $QryOrganisasi = mysqli_query($Conn, "SELECT*FROM referensi_organisasi WHERE part_of_ID='$ID_Org' ORDER BY id_referensi_organisasi DESC");
                                            while ($DataOrganisasi = mysqli_fetch_array($QryOrganisasi)) {
                                                $id_referensi_organisasi= $DataOrganisasi['id_referensi_organisasi'];
                                                $NamaOrganisasi= $DataOrganisasi['nama'];
                                                $IdentifierOrganisasi= $DataOrganisasi['identifier'];
                                                $TipeOrganisasi= $DataOrganisasi['tipe'];
                                                $EmailOrganisasi= $DataOrganisasi['email'];
                                                $KontakOrganisasi= $DataOrganisasi['kontak'];
                                                $LabelNamaOrganisasi='<a href="javascript:void(0);" class="text-success" class="text-info" data-toggle="modal" data-target="#ModalDetailOrganisasiSimrs" data-id="'.$id_referensi_organisasi.'">'.$NamaOrganisasi.' <i class="ti-new-window"></i></a>';
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
                                                    $ID_Org='<a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailOrgId" data-id="'.$ID_OrgVal.'" title="Lihat Data ID Di Satu Sehat"><small>'.$ID_OrgVal.' <i class="ti-layers"></i></small></a>';
                                                }
                                                //Menghitung Jumlah Sub
                                                $JumlahSubOrganisasi=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM referensi_organisasi WHERE part_of_ID='$ID_OrgVal'"));
                                                if(!empty($JumlahSubOrganisasi)){
                                                    $LabelJumlahSub='<span class="text-success">'.$JumlahSubOrganisasi.' Organisasi</span>';
                                                }else{
                                                    $LabelJumlahSub='<span class="text-dark">0 Organisasi</span>';
                                                }
                                                if(!empty($DataOrganisasi['part_of_ID'])){
                                                    echo '<div class="row">';
                                                    echo '  <div class="col-md-12">';
                                                    echo '      <div class="card">';
                                                    echo '          <div class="card-header">';
                                                    echo '              <dt>'.$LabelNamaOrganisasi.'</dt>';
                                                    echo '              <small>'.$ID_Org.'</small>';
                                                    echo '          </div>';
                                                    echo '          <div class="card-body">';
                                                    echo '              <div class="row">';
                                                    echo '                  <div class="col-md-4"><dt><small>Identifier</small></dt></div>';
                                                    echo '                  <div class="col-md-8"><small>'.$IdentifierOrganisasi.'</small></div>';
                                                    echo '              </div>';
                                                    echo '              <div class="row">';
                                                    echo '                  <div class="col-md-4"><dt><small>Tipe</small></dt></div>';
                                                    echo '                  <div class="col-md-8"><small>'.$TipeOrganisasi.'</small></div>';
                                                    echo '              </div>';
                                                    echo '              <div class="row">';
                                                    echo '                  <div class="col-md-4"><dt><small>Email</small></dt></div>';
                                                    echo '                  <div class="col-md-8"><small>'.$EmailOrganisasi.'</small></div>';
                                                    echo '              </div>';
                                                    echo '              <div class="row">';
                                                    echo '                  <div class="col-md-4"><dt><small>Kontak</small></dt></div>';
                                                    echo '                  <div class="col-md-8"><small>'.$KontakOrganisasi.'</small></div>';
                                                    echo '              </div>';
                                                    echo '              <div class="row">';
                                                    echo '                  <div class="col-md-4"><dt><small>Part Of</small></dt></div>';
                                                    echo '                  <div class="col-md-8"><small>'.$part_of_ID.'</small></div>';
                                                    echo '              </div>';
                                                    echo '          </div>';
                                                    echo '      </div>';
                                                    echo '  </div>';
                                                    echo '</div>';
                                                }
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>