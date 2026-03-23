<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(!empty($_POST['id_obat_storage'])){
        $id_obat_storage=$_POST['id_obat_storage'];
    }else{
        $id_obat_storage="0";
    }
    if(empty($_POST['tanggal'])){
        echo '<span class="text-danger">Tanggal Sesi Tidak Boleh Kosong!</span>';
    }else{
        $tanggal=$_POST['tanggal'];
        //Buka Keberadaan Sesi
        $QrySesi = mysqli_query($Conn,"SELECT * FROM obat_so WHERE id_obat_storage='$id_obat_storage' AND tanggal='$tanggal'")or die(mysqli_error($Conn));
        $DataSesi = mysqli_fetch_array($QrySesi);
        if(empty($DataSesi['id_obat_so'])){
            echo '<span class="text-danger">Sesi stok opename tidak ditemukan!</span>';
        }else{
            $strtotime=strtotime($tanggal);
            $Tanggal=date('d/m/Y H:i:s T',$strtotime);
            $JumlahRecordSo = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_so WHERE id_obat_storage='$id_obat_storage' AND tanggal='$tanggal'"));
            echo '<div class="row">';
            echo '  <div class="col-md-12">';
            echo '      <ol>';
            echo '          <li>ID Penyimpanan : <code class="text-secondary">'.$id_obat_storage.'</code></li>';
            echo '          <li>Tanggal : <code class="text-secondary">'.$Tanggal.'</code></li>';
            echo '          <li>Record : <code class="text-secondary">'.$JumlahRecordSo.'</code></li>';
            echo '      </ol>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="row">';
            echo '  <div class="col-md-12">';
            echo '      <a href="index.php?Page=StokOpename&Sub=DetailSesiStokOpename&id='.$id_obat_storage.'&tanggal='.$tanggal.'" class="btn btn-sm btn-block btn-primary btn-round">';
            echo '          Selengkapnya';
            echo '      </a>';
            echo '  </div>';
            echo '</div>';
        }
    }
?>