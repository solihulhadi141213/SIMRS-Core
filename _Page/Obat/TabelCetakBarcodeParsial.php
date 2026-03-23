<?php
    include "../../_Config/Connection.php";
    if(empty($_POST['id_obat'])){
        echo '<tr>';
        echo '  <td colspan="6" class="text-center">';
        echo '      <span class="text-danger">Tidak ada data yang dipilih!</span>';
        echo '  </td>';
        echo '</tr>';
    }else{
        $id_obat=$_POST['id_obat'];
        $JumlahIdObat=count($id_obat);
        $no=1;
        for($x=0; $x<$JumlahIdObat; $x++){
            $IdObat=$id_obat[$x];
            $QryObat = mysqli_query($Conn,"SELECT * FROM obat WHERE id_obat='$IdObat'")or die(mysqli_error($Conn));
            $DataObat = mysqli_fetch_array($QryObat);
            $kode=$DataObat['kode'];
            $nama_obat=$DataObat['nama'];
            $kategori=$DataObat['kategori'];
            $satuan=$DataObat['satuan'];
            $stok=$DataObat['stok'];
            echo '<input type="hidden" name="id_obat[]" value="'.$IdObat.'">';
            echo '<tr>';
            echo '  <td class="text-center">'.$no.'</td>';
            echo '  <td class="text-left">'.$kode.'</td>';
            echo '  <td class="text-left">'.$nama_obat.'</td>';
            echo '  <td class="text-left">'.$kategori.'</td>';
            echo '  <td class="text-left">'.$stok.' '.$satuan.'</td>';
            echo '  <td class="text-center"><small class="text-info">Ready</small></td>';
            echo '</tr>';
            $no++;
        }
    }
?>