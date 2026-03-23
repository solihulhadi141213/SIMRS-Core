<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_obat_storage'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Penyimpanan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_obat_storage=$_POST['id_obat_storage'];
        //Buka data Pengimpanan Obat
        $QryStorage = mysqli_query($Conn,"SELECT * FROM obat_storage WHERE id_obat_storage='$id_obat_storage'")or die(mysqli_error($Conn));
        $DataStorage = mysqli_fetch_array($QryStorage);
        $id_akses= $DataStorage['id_akses'];
        $tanggal= $DataStorage['tanggal'];
        $nama_petugas= $DataStorage['nama_petugas'];
        $nama_penyimpanan= $DataStorage['nama_penyimpanan'];
        $deskripsi_tempat= $DataStorage['deskripsi_tempat'];
        $updatetime= $DataStorage['updatetime'];
        //Format Tanggal
        $strtotime=strtotime($tanggal);
        $strtotime2=strtotime($updatetime);
        $tanggal_creat=date('d/m/Y H:i T',$strtotime);
        $updatetime=date('d/m/Y H:i T',$strtotime2);
        //menghitung Data Item
        $jumlahItem = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_posisi WHERE id_obat_storage='$id_obat_storage'"));
        //menghitung Transfer Masuk
        $JumlahTransferMasuk = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE storage_to='$id_obat_storage'"));
        //menghitung Transfer Keluar
        $JumlahTransferKeluar = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE storage_from='$id_obat_storage'"));
        //menghitung Alokasi Masuk
        $JumlahAlokasiMasuk = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE storage_to='$id_obat_storage'"));
        //menghitung Alokasi Keluar
        $JumlahAlokasiKeluar = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE storage_from='$id_obat_storage'"));
        
?>
    <div class="row">
        <div class="col-md-12 mb-3">
            <?php
                echo '<ul>';
                echo '      <li class="mb-3">Nama Penyimpanan : <code class="text-secondary">'.$nama_penyimpanan.'</code></li>';
                echo '      <li class="mb-3">Deskripsi : <code class="text-secondary">'.$deskripsi_tempat.'</code></li>';
                echo '      <li class="mb-3">Petugas : <code class="text-secondary">'.$nama_petugas.'</code></li>';
                echo '      <li class="mb-3">Jumlah Item : <code class="text-secondary">'.$jumlahItem.'</code></li>';
                echo '      <li class="mb-3">Barang Masuk : <code class="text-secondary">'.$JumlahTransferMasuk.'</code></li>';
                echo '      <li class="mb-3">Barang Keluar : <code class="text-secondary">'.$JumlahTransferKeluar.'</code></li>';
                echo '      <li class="mb-3">Tanggal Input : <code class="text-secondary">'.$tanggal_creat.'</code></li>';
                echo '      <li class="mb-3">Tanggal Update : <code class="text-secondary">'.$updatetime.'</code></li>';
                echo '</ul>';
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="index.php?Page=ObatStorage&Sub=DetailStorage&id=<?php echo $id_obat_storage ?>" class="btn btn-sm btn-outline-dark btn-block btn-round">
                Selengkapnya <i class="ti ti-new-window"></i>
            </a>
        </div>
    </div>
<?php } ?>