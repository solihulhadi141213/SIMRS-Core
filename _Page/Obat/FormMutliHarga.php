<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Jumlah Kategori
    $JumlahKategori = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_kategori_harga"));
    if(empty($JumlahKategori)){
        echo '  <small class="ms-2 me-auto text-danger">';
        echo '      Belum Ada Data Kategori Harga';
        echo '  </small>';
    }else{
        $query = mysqli_query($Conn, "SELECT*FROM obat_kategori_harga ORDER BY kategori_harga ASC");
        while ($data = mysqli_fetch_array($query)) {
            $id_kategori_harga= $data['id_kategori_harga'];
            $kategori_harga= $data['kategori_harga'];
            $keterangan= $data['keterangan'];
            echo '<div class="row mb-2">';
            echo '  <div class="col-md-12">';
            echo '      <input type="number" id="MultiHarga'.$id_kategori_harga.'" name="MultiHarga'.$id_kategori_harga.'" class="form-control" value="">';
            echo '      <label for="MultiHarga'.$kategori_harga.'"><small>'.$kategori_harga.' <br>('.$keterangan.')</small></label>';
            echo '  </div>';
            echo '</div>';
        }
    }
?>