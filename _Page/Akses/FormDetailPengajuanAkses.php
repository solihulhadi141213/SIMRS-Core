<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_akses_pengajuan
    if(empty($_POST['id_akses_pengajuan'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center mb-3">';
        echo '         ID Pengajuan Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-info">';
        echo '  <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">';
        echo '      <i class="ti-close"></i> Tutup';
        echo '  </button>';
        echo '</div>';
    }else{
        $id_akses_pengajuan=$_POST['id_akses_pengajuan'];
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
?>
    <div class="modal-body pre-scrollable">
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
                <dt>Foto <a href="javascript:void(0);" id="TampilkanFotoPengajuan" class="text-success">(Tampilkan)</a></dt>
                <small class="text-muted"><?php echo "$foto"; ?></small><br>
                <div id="TempatMenampilkanFoto"></div>
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
    <div class="modal-footer bg-info">
        <div class="btn-group dropdown-split-inverse">
            <button type="button" class="btn btn-md btn-primary dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                <i class="ti ti-settings"></i> Option
            </button>
            <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item waves-effect waves-light" href="index.php?Page=Akses&Sub=DetailPengajuanAkses&id=<?php echo "$id_akses_pengajuan"; ?>">
                    <i class="ti-more"></i> Selengkapnya
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusPengajuanAkses">
                    <i class="ti-trash"></i> Hapus
                </a>
            </div>
        </div>
        <button type="button" class="btn btn-md btn-inverse" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>