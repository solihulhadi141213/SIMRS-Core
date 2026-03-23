<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_perkiraan
    if(empty($_POST['id_perkiraan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Akun Perkiraan Tidak Boleh Kosong.';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_perkiraan=$_POST['id_perkiraan'];
        $id_perkiraan=getDataDetail($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'id_perkiraan');
        //Buka data obat
        if(empty($id_perkiraan)){
            echo '<div class="card-body border-0 pb-0">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          ID Akun Perkiraan Tidak Valid Karena Tidak Ditemukan Pada Database.';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $nama=getDataDetail($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'nama');
            $name=getDataDetail($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'name');
            $kode=getDataDetail($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'kode');
            $level=getDataDetail($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'level');
            $rank=getDataDetail($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'rank');
            $saldo_normal=getDataDetail($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'saldo_normal');
?>
    <div class="row mb-3">
        <div class="col col-md-4">ID Akun Perkiraan</div>
        <div class="col col-md-8">
            <code class="text-secondary">
                <?php echo "$id_perkiraan"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Kode Akun</div>
        <div class="col col-md-8">
            <code class="text-secondary">
                <?php echo "$kode"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Rank</div>
        <div class="col col-md-8">
            <code class="text-secondary">
                <?php echo "$rank"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Nama Akun</div>
        <div class="col col-md-8">
            <code class="text-secondary">
                <?php echo "$nama"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Name Account</div>
        <div class="col col-md-8">
            <code class="text-secondary">
                <?php echo "$name"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Level</div>
        <div class="col col-md-8">
            <code class="text-secondary">
                <?php echo "$level"; ?>
            </code>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-4">Saldo Normal</div>
        <div class="col col-md-8">
            <code class="text-secondary">
                <?php echo "$saldo_normal"; ?>
            </code>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="btn-group dropdown-split-inverse btn-block">
                <button type="button" class="btn btn-sm btn-outline-primary btn-block btn-round dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                    Opsi Lainnya
                </button>
                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalTambahAkunPerkiraan" data-id="<?php echo "$id_perkiraan";?>" title="Tambah Sub Level Akun Perkiraan">
                        <i class="ti-plus"></i> Tambah Sub Akun
                    </a>
                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalEditAkunPerkiraan" data-id="<?php echo "$id_perkiraan";?>" title="Edit Akun Perkiraan">
                        <i class="ti-pencil"></i> Edit Akun
                    </a>
                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusAkunPerkiraan" data-id="<?php echo "$id_perkiraan";?>" title="Hapus Akun Perkiraan">
                        <i class="ti-trash"></i> Hapus Akun
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php }} ?>