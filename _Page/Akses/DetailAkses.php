<?php
    if(empty($_GET['id'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12">';
        echo '      <div class="card table-card">';
        echo '          <div class="card-body text-danger">';
        echo '              ID Akses Tidak Boleh Kosong!';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_akses=$_GET['id'];
        $nama=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
        $tanggal=getDataDetail($Conn,'akses','id_akses',$id_akses,'tanggal');
        $email=getDataDetail($Conn,'akses','id_akses',$id_akses,'email');
        $kontak=getDataDetail($Conn,'akses','id_akses',$id_akses,'kontak');
        $akses=getDataDetail($Conn,'akses','id_akses',$id_akses,'akses');
        $updatetime=getDataDetail($Conn,'akses','id_akses',$id_akses,'updatetime');
        $gambar=getDataDetail($Conn,'akses','id_akses',$id_akses,'gambar');
        //Detail Pengajuan akses
        $IdPengajuanAkses=getDataDetail($Conn,'akses_pengajuan','email',$email,'id_akses_pengajuan');
        $TanggalPengajuan=getDataDetail($Conn,'akses_pengajuan','email',$email,'tanggal');
        $nik=getDataDetail($Conn,'akses_pengajuan','email',$email,'nik');
        $NamaPemohon=getDataDetail($Conn,'akses_pengajuan','email',$email,'nama');
        $KontakPemohon=getDataDetail($Conn,'akses_pengajuan','email',$email,'kontak');
        $EmailPemohon=getDataDetail($Conn,'akses_pengajuan','email',$email,'email');
        $AlamatPemohon=getDataDetail($Conn,'akses_pengajuan','email',$email,'alamat');
        $DeskripsiPengajuan=getDataDetail($Conn,'akses_pengajuan','email',$email,'deskripsi');
        $FotoPengajuan=getDataDetail($Conn,'akses_pengajuan','email',$email,'foto');
        $StatusPengajuan=getDataDetail($Conn,'akses_pengajuan','email',$email,'status');
        $KeteranganPengajuan=getDataDetail($Conn,'akses_pengajuan','email',$email,'keterangan');
?>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12 mb-2 text-center">
                            <h4><i class="ti ti-info-alt"></i> Detail Akses</h4>
                        </div>
                        <div class="col-md-12">
                            <a href="index.php?Page=Akses&Sub=AksesUser" class="btn btn-sm btn-block btn-secondary">
                                <i class="ti ti-angle-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body table table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>
                                    <dt>Tanggal</dt>
                                    <small class="text-muted"><?php echo "$tanggal"; ?></small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Nama</dt>
                                    <small class="text-muted"><?php echo "$nama"; ?></small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Email</dt>
                                    <small class="text-muted"><?php echo "$email"; ?></small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Kontak</dt>
                                    <small class="text-muted"><?php echo "$kontak"; ?></small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Akses</dt>
                                    <small class="text-muted"><?php echo "$akses"; ?></small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Foto</dt>
                                    <small class="text-muted">
                                        <?php 
                                            if(!empty($gambar)){
                                                echo '<a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalTampilkanFotoUser" data-id="'.$gambar.'">';
                                                echo ''.$gambar.' <i class="ti ti-layers"></i>';
                                                echo '</a>';
                                            }else{
                                                echo "None";
                                            }
                                        ?>
                                    </small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Updatetime</dt>
                                    <small class="text-muted"><?php echo "$updatetime"; ?></small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Pengajuan Akses</dt>
                                    <small>
                                        <?php
                                            if(!empty($TanggalPengajuan)){
                                                echo '<a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalDetailPengajuanAkses2" data-id="'.$IdPengajuanAkses.'">';
                                                echo '  '.$TanggalPengajuan.' <i class="ti ti-layers"></i>';
                                                echo '</a>';
                                            }else{
                                                echo "Tidak Ada";
                                            }
                                        ?>
                                    </small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="btn-group">
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalUbahPassword" data-id="<?php echo "$id_akses"; ?>" title="Ubah Password User Akses">
                                    <i class="ti ti-key"></i> Password
                                </a>
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalEditAkses" data-id="<?php echo "$id_akses"; ?>" title="Ubah Profile User Akses">
                                    <i class="ti ti-pencil"></i> Profile
                                </a>
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapusAkses" data-id="<?php echo "$id_akses"; ?>" title="Hapus User Akses">
                                    <i class="ti ti-trash"></i> Hapus
                                </a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <form action="javascript:void(0);" id="ProsesSimpanIjinAkses">
                    <input type="hidden" name="id_akses" value="<?php echo "$id_akses"; ?>">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <h4><i class="ti ti-check-box"></i> Ijin Akses Fitur</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php
                                //Array Kategori
                                $QryAksesRef = mysqli_query($Conn, "SELECT DISTINCT kategori FROM akses_ref ORDER BY kategori ASC");
                                while ($DataAksesRef = mysqli_fetch_array($QryAksesRef)) {
                                    $KategoriRef= $DataAksesRef['kategori'];
                                    echo '<div class="col-md-4 mb-3">';
                                    echo '  <dt>'.$KategoriRef.'</dt>';
                                    echo '  <ul>';
                                    //Array Fitur
                                    $QryRef = mysqli_query($Conn, "SELECT * FROM akses_ref WHERE kategori='$KategoriRef'");
                                    while ($DataRef = mysqli_fetch_array($QryRef)) {
                                        $id_akses_ref= $DataRef['id_akses_ref'];
                                        $nama_fitur= $DataRef['nama_fitur'];
                                        //Buka Data Acc
                                        $QryAcc = mysqli_query($Conn,"SELECT * FROM akses_acc WHERE id_akses='$id_akses' AND id_akses_ref='$id_akses_ref'")or die(mysqli_error($Conn));
                                        $DataAcc = mysqli_fetch_array($QryAcc);
                                        if(empty($DataAcc['status'])){
                                            $StatusAcc ="No";
                                        }else{
                                            $StatusAcc = $DataAcc['status'];
                                        }
                                        if($StatusAcc=="Yes"){
                                            echo '<li>';
                                            echo '  <input type="checkbox" checked name="IdAksesRef'.$id_akses_ref.'" id="IdAksesRef'.$id_akses_ref.'" value="Yes">';
                                            echo '  <label for="IdAksesRef'.$id_akses_ref.'">'.$nama_fitur.'</label>';
                                            echo '</li>';
                                        }else{
                                            echo '<li>';
                                            echo '  <input type="checkbox" name="IdAksesRef'.$id_akses_ref.'" id="IdAksesRef'.$id_akses_ref.'" value="Yes">';
                                            echo '  <label for="IdAksesRef'.$id_akses_ref.'">'.$nama_fitur.'</label>';
                                            echo '</li>';
                                        }
                                    }
                                    echo '  </ul>';
                                    echo '</div>';
                                }
                            ?>
                        </div>
                        <div class="row">
                            <div class="col-md-12" id="NotifikasiSimpanIjinAkses">
                                <span class="text-primary">
                                    Pastikan Data Ijin Akses Sudah Sesuai!
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="ti ti-save"></i> Simpan Ijin Fitur
                        </button>
                    </div>
                </form>
            </div>
            <div class="card">
                <div class="card-header">
                    <form action="javascript:void(0);" id="ProsesBatasLogAkses">
                        <input type="hidden" id="IdAksesLog" name="IdAksesLog" value="<?php echo "$id_akses"; ?>">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <h4><i class="ti-control-record"></i> Log Aktivitas</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-2">
                                <select name="BatasLog" id="BatasLog" class="form-control">
                                    <option value="5">5</option>
                                    <option selected value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <small>Batas</small>
                            </div>
                            <div class="col-md-2 mb-3">
                                <select name="KeywordByLog" id="KeywordByLog" class="form-control">
                                    <option value="">Pilih</option>
                                    <?php
                                        //Menampilkan list KeywordByLog
                                        $NamaTabel="log";
                                        $ListKolom=getColomList($Conn,$NamaTabel);
                                        foreach ($ListKolom as $value){
                                            $nama_kolom=$value['nama_kolom'];
                                            if($nama_kolom=="waktu"){
                                                echo '<option value="'.$nama_kolom.'">Tanggal</option>';
                                            }else{
                                                if($nama_kolom=="nama_log"){
                                                    echo '<option value="'.$nama_kolom.'">Keterangan</option>';
                                                }else{
                                                    if($nama_kolom=="kategori"){
                                                        echo '<option value="'.$nama_kolom.'">Kategori</option>';
                                                    }else{
                                                        // echo '<option value="'.$nama_kolom.'">'.$nama_kolom.'</option>';
                                                    }
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                                <small>Keyword By</small>
                            </div>
                            <div class="col-md-4 mb-3" id="FormKeywordLog">
                                <input type="text" class="form-control" name="KeywordLog" id="KeywordLog" placeholder="Kata Kunci">
                                <small>Pencarian</small>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="submit" class="btn btn-sm btn-block btn-inverse">
                                    <i class="ti-search"></i> cari
                                </button>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalEksportLogAkses" data-id="<?php echo "$id_akses"; ?>" title="Export Data Log">
                                        <i class="ti-download"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalRekapLogAkses" data-id="<?php echo "$id_akses"; ?>" title="Lihat Rekapitulasi">
                                        <i class="ti ti-bar-chart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="MenampilkanLogAkses">
                    
                </div>
            </div>
        </div>
    </div>
<?php } ?>