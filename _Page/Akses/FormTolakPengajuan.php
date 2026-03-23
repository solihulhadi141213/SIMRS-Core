<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_akses_pengajuan
    if(empty($_POST['id_akses_pengajuan'])){
        echo '<div class="card-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-danger mb-3">';
        echo '          ID Pengajuan Tidak Boleh Kosong.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="card-footer bg-primary">';
        echo '  <button type="button" class="btn btn-md btn-light mt-2 ml-2">';
        echo '      <i class="ti-close"></i> Tutup';
        echo '      </div>';
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
?>
    <form action="javascript:void(0);" id="ProsesTolakPengajuan" autocomplete="off">
        <div class="modal-body border-0 pb-0">
            <input type="hidden" name="id_akses_pengajuan" id="id_akses_pengajuan" value="<?php echo "$id_akses_pengajuan"; ?>">
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <div>
                        <label for="email">Email</label>
                        <input type="email" readonly class="form-control" id="email" name="email" value="<?php echo "$email"; ?>">
                        <small>
                            <input type="checkbox" checked name="KirimEmailPenolakan" id="KirimEmailPenolakan" value="Ya">
                            <label for="KirimEmailPenolakan">Kirim Email Penolakan</label>
                        </small>
                    </div>
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <div>
                        <label for="keterangan_penolakan">Keterangan Penolakan</label>
                        <textarea name="keterangan_penolakan" id="keterangan_penolakan" cols="30" rows="3" class="form-control"></textarea>
                        <small>Maksimal 200 karakter</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div id="NotifikasiTolakPengajuan">
                        <span class="text-primary">Apakah anda yakin akan menolak permintaan akses ini?</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-danger">
            <button type="submit" class="btn btn-md btn-success mt-2 ml-2">
                <i class="ti-save"></i> Simpan
            </button>
            <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">
                <i class="ti-close"></i> Tutup
            </button>
        </div>
    </form>
<?php } ?>