<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_obat_transfer_alokasi'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Transfer Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_obat_transfer_alokasi=$_POST['id_obat_transfer_alokasi'];
        $id_obat=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'id_obat');
        $kode=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'kode');
        $nama=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'nama');
        $tanggal=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'tanggal');
        $keterangan=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'keterangan');
        $storage_from=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'storage_from');
        $storage_to=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'storage_to');
        $qty=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'qty');
        $nama_petugas=getDataDetail($Conn,'obat_transfer_alokasi','id_obat_transfer_alokasi',$id_obat_transfer_alokasi,'nama_petugas');
        //Update timestamp
        $TanggalTransfer=strtotime($tanggal);
        $TanggalTransfer=date('d/m/Y H:i T',$TanggalTransfer);
        //Penyimpanan
        $AsalPenyimpanan=getDataDetail($Conn,'obat_storage','id_obat_storage',$storage_from,'nama_penyimpanan');
        $TujuanPenyimpanan=getDataDetail($Conn,'obat_storage','id_obat_storage',$storage_to,'nama_penyimpanan');
        if(empty($AsalPenyimpanan)){
            $LabelAsalPenyimpanan='<code class="text-danger">Tidak Ada/Sudah Dihapus</code>';
        }else{
            $LabelAsalPenyimpanan='<code class="text-secondary">'.$AsalPenyimpanan.'</code>';
        }
        if(empty($TujuanPenyimpanan)){
            $LabelTujuanPenyimpanan='<code class="text-danger">Tidak Ada/Sudah Dihapus</code>';
        }else{
            $LabelTujuanPenyimpanan='<code class="text-secondary">'.$TujuanPenyimpanan.'</code>';
        }
        //Satuan
        $Satuan=getDataDetail($Conn,'obat','id_obat',$id_obat,'satuan');
?>
    <div class="row">
        <div class="col-md-12 mb-3">
            <?php
                echo '<ol>';
                echo '      <li class="mb-3">Kode Obat/Alkes : <code class="text-secondary">'.$kode.'</code></li>';
                echo '      <li class="mb-3">Nama Obat/Alkes : <code class="text-secondary">'.$nama.'</code></li>';
                echo '      <li class="mb-3">Tanggal : <code class="text-secondary">'.$TanggalTransfer.'</code></li>';
                echo '      <li class="mb-3">Asal : '.$LabelAsalPenyimpanan.'</li>';
                echo '      <li class="mb-3">Tujuam : '.$LabelTujuanPenyimpanan.'</li>';
                echo '      <li class="mb-3">Qty : <code class="text-secondary">'.$qty.' '.$Satuan.'</code></li>';
                echo '      <li class="mb-3">Petugas : <code class="text-secondary">'.$nama_petugas.'</code></li>';
                echo '      <li class="mb-3">Keterangan : <code class="text-secondary">'.$keterangan.'</code></li>';
                echo '</ol>';
            ?>
        </div>
    </div>
<?php } ?>