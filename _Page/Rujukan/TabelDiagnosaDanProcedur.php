<?php
include "../../_Config/Connection.php";
include "../../_Config/Session.php";
    if(empty($_POST['NoRujukanKhusus'])){
        echo '<tr>';
        echo '  <td class="text-center text-danger" colspan="3">';
        echo '      <dt>Keterangan</dt>';
        echo '      Nomor Rujukan Tidak Boleh Kosong!';
        echo '  </td>';
        echo '</tr>';
    }else{
        $NoRujukan=$_POST['NoRujukanKhusus'];
        $no=1;
        $query = mysqli_query($Conn, "SELECT*FROM diagnosarujukankhusus WHERE rujukan='$NoRujukan' ORDER BY id_diagnosa DESC");
        while ($data = mysqli_fetch_array($query)) {
            $id_diagnosa  = $data['id_diagnosa'];
            $rujukan= $data['rujukan'];
            $kode= $data['kode'];
            $kategori= $data['kategori'];
            echo '<tr>';
            echo '  <td class="text-center">'.$no.'</td>';
            echo '  <td class="text-left">'.$kategori.'</td>';
            echo '  <td class="text-left">'.$kode.'</td>';
            echo '</tr>';
        $no++;}
    }

?>