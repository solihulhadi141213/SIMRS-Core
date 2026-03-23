<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    $JumlahDataObatStorage = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_storage"));
    if(empty($JumlahDataObatStorage)){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <div class="card">';
        echo '          <div class="card-body text-center text-danger">';
        echo '              Belum Ada Data Storage!';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $no=1;
        $query = mysqli_query($Conn, "SELECT*FROM obat_storage ORDER BY id_obat_storage DESC");
        while ($data = mysqli_fetch_array($query)) {
            $id_obat_storage= $data['id_obat_storage'];
            $id_akses= $data['id_akses'];
            $nama_petugas= $data['nama_petugas'];
            $nama_penyimpanan= $data['nama_penyimpanan'];
            $deskripsi_tempat= $data['deskripsi_tempat'];
            $updatetime= $data['updatetime'];
            //Format Tanggal
            $strtotime=strtotime($updatetime);
            $updatetime=date('d/m/Y H:i T',$strtotime);
            //menghitung Data Item
            $jumlahItem = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_posisi WHERE id_obat_storage='$id_obat_storage'"));
            //menghitung Transfer Masuk
            $JumlahTransferMasuk = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE storage_to='$id_obat_storage'"));
            //menghitung Transfer Keluar
            $JumlahTransferKeluar = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE storage_from='$id_obat_storage'"));
            //menghitung Alokasi Masuk
            $JumlahAlokasiMasuk = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE storage_to='$id_obat_storage' "));
            //menghitung Alokasi Keluar
            $JumlahAlokasiKeluar = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_transfer_alokasi WHERE storage_from='$id_obat_storage'"));
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12 sub-title">';
            echo '      <dt>'.$no.'. '.$nama_penyimpanan.'</dt>';
            echo '      <ul class="mb-3">';
            echo '          <li><i class="ti ti-box"></i> Jumlah Item : <code class="text-secondary">'.$jumlahItem.'</code></li>';
            echo '          <li>Barang Masuk : <code class="text-secondary">'.$JumlahTransferMasuk.'</code></li>';
            echo '          <li>Barang Keluar : <code class="text-secondary">'.$JumlahTransferKeluar.'</code></li>';
            echo '          <li>Updatetime : <code class="text-secondary">'.$updatetime.'</code></li>';
            echo '      </ul>';
            echo '      <div class="icon-btn">';
            echo '          <button type="button" class="btn btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalDetailObatStorage" data-id="'.$id_obat_storage.'" title="Detail Informasi Penyimpanan Obat">';
            echo '              <i class="ti ti-info"></i>';
            echo '          </button>';
            echo '          <button type="button" class="btn btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalEditObatStorage" data-id="'.$id_obat_storage.'" title="Edit Data Penyimpanan Obat">';
            echo '              <i class="ti ti-pencil-alt"></i>';
            echo '          </button>';
            echo '          <button type="button" class="btn btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalHapusObatStorage" data-id="'.$id_obat_storage.'" title="Hapus Data Penyimpanan Obat">';
            echo '              <i class="ti ti-trash"></i>';
            echo '          </button>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            $no++;
        }
    }
?>