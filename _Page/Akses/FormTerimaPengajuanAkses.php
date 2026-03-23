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
    <form action="javascript:void(0);" id="ProsesTerimaPengajuan" autocomplete="off">
        <div class="modal-body border-0 pb-0">
            <input type="hidden" name="id_akses_pengajuan" value="<?php echo "$id_akses_pengajuan"; ?>">
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <div>
                        <label for="nama">Nama</label>
                        <input type="text" readonly class="form-control" id="nama" name="nama" value="<?php echo "$nama"; ?>">
                    </div>
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <div>
                        <label for="kontak">Kontak</label>
                        <input type="text" readonly class="form-control" id="kontak" name="kontak" value="<?php echo "$kontak"; ?>">
                    </div>
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <div>
                        <label for="foto">Foto</label>
                        <input type="text" readonly class="form-control" id="foto" name="foto" value="<?php echo "$foto"; ?>">
                    </div>
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <div>
                        <label for="email">Email</label>
                        <input type="email" readonly class="form-control" id="email" name="email" value="<?php echo "$email"; ?>">
                        <small>
                            <input type="checkbox" checked name="KirimEmailPemberitahuan" id="KirimEmailPemberitahuan" value="Ya">
                            <label for="KirimEmailPemberitahuan">Kirim Email Pemberitahuan</label>
                        </small>
                    </div>
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="password" name="password" value="">
                        <button type="button" class="btn btn-sm btn-secondary" id="GeneratePassword" title="Generate Password">
                            <i class="ti-reload"></i>
                        </button>
                    </div>
                    <small class="text-muted">
                        Password menggunakan 5-20 karakter huruf atau angka!
                    </small>
                </div>
            </div>
            <div class="row"> 
                <div class="col-md-12 mb-3">
                    <div>
                        <label for="akses">Entitas Akses</label>
                        <select name="akses" id="akses" class="form-control">
                            <option value="">Pilih</option>
                            <?php
                                $QryAkses = mysqli_query($Conn, "SELECT*FROM akses_entitas ORDER BY akses ASC");
                                while ($DataAkses = mysqli_fetch_array($QryAkses)) {
                                    $AksesList= $DataAkses['akses'];
                                    echo '<option value="'.$AksesList.'">'.$AksesList.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div id="NotifikasiTerimaPengajuan">
                        <span class="text-primary">Pastikan informasi akses sudah sesuai.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-primary">
            <button type="submit" class="btn btn-md btn-success mt-2 ml-2">
                <i class="ti-save"></i> Simpan
            </button>
            <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">
                <i class="ti-close"></i> Tutup
            </button>
        </div>
    </form>
<?php } ?>