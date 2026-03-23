<?php
    if(empty($_GET['id'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12">';
        echo '      <div class="card table-card">';
        echo '          <div class="card-body text-danger">';
        echo '              ID Entitas Tidak Boleh Kosong!';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_akses_pengajuan=$_GET['id'];
        $tanggal=getDataDetail($Conn,'akses_pengajuan','id_akses_pengajuan',$id_akses_pengajuan,'tanggal');
        $nik=getDataDetail($Conn,'akses_pengajuan','id_akses_pengajuan',$id_akses_pengajuan,'nik');
        $nama=getDataDetail($Conn,'akses_pengajuan','id_akses_pengajuan',$id_akses_pengajuan,'nama');
        $kontak=getDataDetail($Conn,'akses_pengajuan','id_akses_pengajuan',$id_akses_pengajuan,'kontak');
        $email=getDataDetail($Conn,'akses_pengajuan','id_akses_pengajuan',$id_akses_pengajuan,'email');
        $alamat=getDataDetail($Conn,'akses_pengajuan','id_akses_pengajuan',$id_akses_pengajuan,'alamat');
        $deskripsi=getDataDetail($Conn,'akses_pengajuan','id_akses_pengajuan',$id_akses_pengajuan,'deskripsi');
        $foto=getDataDetail($Conn,'akses_pengajuan','id_akses_pengajuan',$id_akses_pengajuan,'foto');
        $status=getDataDetail($Conn,'akses_pengajuan','id_akses_pengajuan',$id_akses_pengajuan,'status');
        $keterangan=getDataDetail($Conn,'akses_pengajuan','id_akses_pengajuan',$id_akses_pengajuan,'keterangan');
        if($status=="Pending"){
            $LabelStatus='<span class="badge badge-danger"><i class="ti ti-time"></i> Pending</span>';
        }else{
            if($status=="Ditolak"){
                $LabelStatus='<span class="badge badge-inverse"><i class="ti ti-close"></i> Ditolak</span>';
            }else{
                if($status=="Diterima"){
                    $LabelStatus='<span class="badge badge-success"><i class="ti ti-check"></i> Diterima</span>';
                }else{
                    $LabelStatus='<span class="badge badge-secondary"><i class="ti ti-close"></i> None</span>';
                }
            }
        }
        //Cek kepemilikan data akses
        $id_akses=getDataDetail($Conn,'akses','email',$email,'id_akses');
        $TanggalAkses=getDataDetail($Conn,'akses','email',$email,'tanggal');
        $EmailAkses=getDataDetail($Conn,'akses','email',$email,'email');
        $NamaAkses=getDataDetail($Conn,'akses','email',$email,'nama');
        $KontakAkses=getDataDetail($Conn,'akses','email',$email,'kontak');
        $PasswordAkses=getDataDetail($Conn,'akses','email',$email,'password');
        $LevelAkses=getDataDetail($Conn,'akses','email',$email,'akses');
        $FotoProfile=getDataDetail($Conn,'akses','email',$email,'gambar');
        $UpdatetimeAkses=getDataDetail($Conn,'akses','email',$email,'updatetime');
?>
    <div class="row">
        <div class="col-xl-6 col-md-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <h4># Detail Pengajuan Akses</h4>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="index.php?Page=Akses&Sub=PengajuanAkses" class="btn btn-sm btn-block btn-secondary">
                                <i class="ti ti-angle-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <dt>Tanggal</dt>
                            <small class="text-muted"><?php echo "$tanggal"; ?></small>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <dt>NIK</dt>
                            <small class="text-muted"><?php echo "$nik"; ?></small>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <dt>Nama</dt>
                            <small class="text-muted"><?php echo "$nama"; ?></small>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <dt>Kontak</dt>
                            <small class="text-muted"><?php echo "$kontak"; ?></small>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <dt>Email</dt>
                            <small class="text-muted"><?php echo "$email"; ?></small>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <dt>Alamat</dt>
                            <small class="text-muted"><?php echo "$alamat"; ?></small>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <dt>Deskripsi Pengajuan</dt>
                            <small class="text-muted"><?php echo "$deskripsi"; ?></small>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <dt>Foto <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalTampilkanFotoPengajuan" data-id="<?php echo "$foto"; ?>">(Tampilkan)</a></dt>
                            <small class="text-muted"><?php echo "$foto"; ?></small><br>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <dt>Status</dt>
                            <?php echo "$LabelStatus"; ?><br>
                            <small class="text-muted"><?php echo "$keterangan"; ?></small>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h4># Detail Akses</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                        if(empty($id_akses)){
                            if($status=="Pending"){
                                echo '<div class="row">';
                                echo '  <div class="col-md-12 text-center text-danger">';
                                echo '      Pengajuan masih pending, silahkan verifikasi pengajuan ini terlebih dulu!';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                if($status=="Diterima"){
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-12 text-center text-danger">';
                                    echo '      Pengajuan sudah diterima namun yang bersangkutan belum memperoleh data akses!';
                                    echo '  </div>';
                                    echo '</div>';
                                    
                                }else{
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-12 text-center text-danger">';
                                    echo '      Pengajuan Ditolak! Akses tidak dapat ditambahkan.<br>';
                                    echo '      Selama data pengajuan ini masih ada, pemohon tidak dapat mengajukan permintaan akses.';
                                    echo '  </div>';
                                    echo '</div>';
                                }
                            }
                        }else{
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 mb-3">';
                            echo '      <dt>ID Akses</dt>';
                            echo '      <small class="text-muted">'.$id_akses.'</small>';
                            echo '  </div>';
                            echo '</div>';
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 mb-3">';
                            echo '      <dt>Tanggal Dibuat</dt>';
                            echo '      <small class="text-muted">'.$TanggalAkses.'</small>';
                            echo '  </div>';
                            echo '</div>';
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 mb-3">';
                            echo '      <dt>Nama</dt>';
                            echo '      <small class="text-muted">'.$NamaAkses.'</small>';
                            echo '  </div>';
                            echo '</div>';
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 mb-3">';
                            echo '      <dt>Kontak</dt>';
                            echo '      <small class="text-muted">'.$KontakAkses.'</small>';
                            echo '  </div>';
                            echo '</div>';
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 mb-3">';
                            echo '      <dt>Email Akses</dt>';
                            echo '      <small class="text-muted">'.$EmailAkses.'</small>';
                            echo '  </div>';
                            echo '</div>';
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 mb-3">';
                            echo '      <dt>Password</dt>';
                            echo '      <small class="text-muted">'.$PasswordAkses.'</small>';
                            echo '  </div>';
                            echo '</div>';
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 mb-3">';
                            echo '      <dt>Entitas Akses</dt>';
                            echo '      <small class="text-muted">'.$LevelAkses.'</small>';
                            echo '  </div>';
                            echo '</div>';
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 mb-3">';
                            echo '      <dt>Foto Profil <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalTampilkanFotoUser" data-id="'.$FotoProfile.'">(Tampilkan)</a></dt>';
                            echo '      <small class="text-muted">'.$FotoProfile.'</small>';
                            echo '  </div>';
                            echo '</div>';
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 mb-3">';
                            echo '      <dt>Updatetime</dt>';
                            echo '      <small class="text-muted">'.$UpdatetimeAkses.'</small>';
                            echo '  </div>';
                            echo '</div>';
                        }
                    ?>
                </div>
                <div class="card-footer">
                    <?php
                        if(empty($id_akses)){
                            if($status=="Pending"){
                                echo '<div class="row">';
                                echo '  <div class="col-md-6 mb-3">';
                                echo '      <button type="button" class="btn btn-md btn-block btn-primary" data-toggle="modal" data-target="#ModalTerimaPengajuan" data-id="'.$id_akses_pengajuan.'">';
                                echo '          <i class="ti ti-check-box"></i> Terima Pengajuan';
                                echo '      </button>';
                                echo '  </div>';
                                echo '  <div class="col-md-6">';
                                echo '      <button type="button" class="btn btn-md btn-block btn-danger" data-toggle="modal" data-target="#ModalTolakPengajuan" data-id="'.$id_akses_pengajuan.'">';
                                echo '          <i class="ti ti-close"></i> Tolak Pengajuan';
                                echo '      </button>';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                if($status=="Ditolak"){
                                    echo '  <div class="col-md-12">';
                                    echo '      <button type="button" class="btn btn-md btn-block btn-danger" data-toggle="modal" data-target="#ModalHapusPengajuanAkses2" data-id="'.$id_akses_pengajuan.'">';
                                    echo '          <i class="ti ti-trash"></i> Hapus Pengajuan';
                                    echo '      </button>';
                                    echo '  </div>';
                                }else{
                                    echo '<div class="row">';
                                    echo '  <div class="col-md-6 mb-3">';
                                    echo '      <button type="button" class="btn btn-md btn-block btn-success">';
                                    echo '          <i class="ti ti-pencil"></i> Ubah Status';
                                    echo '      </button>';
                                    echo '  </div>';
                                    echo '  <div class="col-md-6 mb-3">';
                                    echo '      <button type="button" class="btn btn-md btn-block btn-primary">';
                                    echo '          <i class="ti ti-plus"></i> Tambah Akses';
                                    echo '      </button>';
                                    echo '  </div>';
                                    echo '</div>';
                                }
                            }
                        }else{
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 mb-3">';
                            echo '      <div class="btn-group btn-block">';
                            echo '          <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalUbahPassword" data-id="'.$id_akses.'" title="Atur Ulang Password">';
                            echo '              <i class="ti ti-key"></i> Password';
                            echo '          </button>';
                            echo '          <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapusAkses" data-id="'.$id_akses.'">';
                            echo '              <i class="ti ti-close"></i> Hapus';
                            echo '          </button>';
                            echo '      </div>';
                            echo '  </div>';
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>