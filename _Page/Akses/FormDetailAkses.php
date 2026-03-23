<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_akses
    if(empty($_POST['id_akses'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger mb-3">';
        echo '          ID Akses Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-info">';
        echo '  <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">';
        echo '      <i class="ti-close"></i> Tutup';
        echo '  </button>';
        echo '</div>';
    }else{
        $id_akses=$_POST['id_akses'];
        $nama=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
        $tanggal=getDataDetail($Conn,'akses','id_akses',$id_akses,'tanggal');
        $email=getDataDetail($Conn,'akses','id_akses',$id_akses,'email');
        $kontak=getDataDetail($Conn,'akses','id_akses',$id_akses,'kontak');
        $akses=getDataDetail($Conn,'akses','id_akses',$id_akses,'akses');
        $updatetime=getDataDetail($Conn,'akses','id_akses',$id_akses,'updatetime');
        $gambar=getDataDetail($Conn,'akses','id_akses',$id_akses,'gambar');
?>
    <div class="modal-body">
        <div class="row"> 
            <div class="col-md-12 table table-responsive">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td><dt>Nama</dt></td>
                            <td align="right"><?php echo "$nama"; ?></td>
                        </tr>
                        <tr>
                            <td><dt>Tanggal</dt></td>
                            <td align="right"><?php echo "$tanggal"; ?></td>
                        </tr>
                        <tr>
                            <td><dt>Email</dt></td>
                            <td align="right">
                                <small class=""text-muted><?php echo "$email"; ?></small>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>Kontak</dt></td>
                            <td align="right"><?php echo "$kontak"; ?></td>
                        </tr>
                        <tr>
                            <td><dt>Akses</dt></td>
                            <td align="right"><?php echo "$akses"; ?></td>
                        </tr>
                        <tr>
                            <td><dt>Foto</dt></td>
                            <td align="right">
                                <small class=""text-muted><?php echo "$gambar"; ?></small>
                            </td>
                        </tr>
                        <tr>
                            <td><dt>Updatetime</dt></td>
                            <td align="right"><?php echo "$updatetime"; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-info">
        <a href="index.php?Page=Akses&Sub=DetailAkses&id=<?php echo "$id_akses"; ?>" class="btn btn-sm btn-success">
            <i class="ti-more"></i> Selengkapnya
        </a>
        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
            <i class="ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>