<?php 
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //menangkap id wilayah
    if(empty($_POST['id_wilayah_mendagri'])){
        echo '<span>Tidak ada ID Wilayah Yang Ditangkap</span>';
    }else{
        $id_wilayah_mendagri=$_POST['id_wilayah_mendagri'];
        //Buka data wilayah
        $QryWilayah = mysqli_query($Conn,"SELECT * FROM wilayah_mendagri WHERE id_wilayah_mendagri='$id_wilayah_mendagri'")or die(mysqli_error($Conn));
        $DataWilayah = mysqli_fetch_array($QryWilayah);
        $id_wilayah_mendagri= $DataWilayah['id_wilayah_mendagri'];
        $kategori= $DataWilayah['kategori'];
        $kode= $DataWilayah['kode'];
        $nama= $DataWilayah['nama'];
?>
    <div class="modal-body">
        <div class="row mt-3">
            <div class="col-md-6"><dt>Kode</dt></div>
            <div class="col-md-6" id="GetKodeWilayahMendagri"><?php echo "$kode"; ?></div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6"><dt>Kategori</dt></div>
            <div class="col-md-6"><?php echo "$kategori"; ?></div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6"><dt>Nama Wilayah</dt></div>
            <div class="col-md-6"><?php echo "$nama"; ?></div>
        </div>
    </div>
    <div class="modal-footer bg-info">
        <div class="row">
            <div class="col-md-12">
                <?php
                    if($kategori=="Provinsi"){
                        echo '<a class="btn btn-sm btn-success mr-2" href="javascript:void(0);" id="TampilkanKabupaten">';
                        echo '  <i class="ti ti-align-left"></i> Tampilkan Kabupaten';
                        echo '</a>';
                    }
                    if($kategori=="Kota Kabupaten"){
                        echo '<a class="btn btn-sm btn-success mr-2" href="javascript:void(0);" id="TampilkanKecamatan">';
                        echo '  <i class="ti ti-align-left"></i> Tampilkan Kecamatan';
                        echo '</a>';
                    }
                    if($kategori=="Kecamatan"){
                        echo '<a class="btn btn-sm btn-success mr-2" href="javascript:void(0);" id="TampilkanDesa">';
                        echo '  <i class="ti ti-align-left"></i> Tampilkan Desa';
                        echo '</a>';
                    }
                ?>
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php } ?>