<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //Jumlah Kategori
    $JumlahKategori = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_kategori_harga"));
    if(empty($JumlahKategori)){
        echo '<li class="list-group-item d-flex justify-content-between align-items-start">';
        echo '  <div class="ms-2 me-auto text-danger">';
        echo '      Belum Ada Data Kategori Harga';
        echo '  </div>';
        echo '</li>';
    }else{
        $no=1;
        $query = mysqli_query($Conn, "SELECT*FROM obat_kategori_harga ORDER BY kategori_harga ASC");
        while ($data = mysqli_fetch_array($query)) {
            $id_kategori_harga= $data['id_kategori_harga'];
            $kategori_harga= $data['kategori_harga'];
            $keterangan= $data['keterangan'];
            //Jumlah Item Obat yang Memiliki Kategori Harga Ini
            $JumlahItemKategori = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_harga WHERE id_kategori_harga='$id_kategori_harga'"));
            $JumlahItemKategori = "" . number_format($JumlahItemKategori, 0, ',', '.');
            echo '<li class="list-group-item d-flex justify-content-between align-items-start">';
            echo '  <div class="ms-2 me-auto">';
            echo '      <div class="fw-bold">';
            echo '          <span class="text-dark">'.$no.'. '.$kategori_harga.'</span>';
            echo '          <span class="badge badge-inverse-primary rounded-pill">'.$JumlahItemKategori.'</span>';
            echo '      </div>';
            echo '      <small>'.$keterangan.'</small><br>';
            echo '      <a href="javascript:void(0);" class="label bg-success" data-toggle="modal" data-target="#ModalEditKategoriHarga" data-id="'.$id_kategori_harga.'">';
            echo '          <i class="ti ti-pencil"></i> Edit';
            echo '      </a>';
            echo '      <a href="javascript:void(0);" class="label bg-danger" data-toggle="modal" data-target="#ModalHapusKategoriHarga" data-id="'.$id_kategori_harga.'">';
            echo '          <i class="ti ti-close"></i> Hapus';
            echo '      </a>';
            echo '  </div>';
            echo '</li>';
            $no++;
        }
    }
?>