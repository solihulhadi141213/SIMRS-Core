<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_pasien'])){
        echo '<di class="modal-body">';
        echo '  <di class="row">';
        echo '      <di class="col-md-12 text-center text-danger">';
        echo '          Isi Terlebih Dulu Nomor RM Pasien';
        echo '      </di>';
        echo '  </di>';
        echo '</di>';
        echo '<di class="modal-footer bg-inverse">';
        echo '  <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </button>';
        echo '</di>';
    }else{
        $id_pasien=$_POST['id_pasien'];
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE id_pasien like '%$id_pasien%'"));
        if(empty($jml_data)){
            echo '<di class="modal-body">';
            echo '  <di class="row">';
            echo '      <di class="col-md-12 text-center text-danger">';
            echo '          Data Antrian Tidak Ditemukan!';
            echo '      </di>';
            echo '  </di>';
            echo '</di>';
            echo '<di class="modal-footer bg-inverse">';
            echo '  <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">';
            echo '      <i class="ti ti-close"></i> Tutup';
            echo '  </button>';
            echo '</di>';
        }else{
            echo '<div class="modal-body">';
            echo '  <div class="row mb-3">';
            echo '      <div class="col-md-12 pre-scrollable">';
            echo '          <ul  class="list-group">';
            $no=1;
            $query = mysqli_query($Conn, "SELECT*FROM antrian WHERE id_pasien like '%$id_pasien%'");
            while ($data = mysqli_fetch_array($query)) {
                $id_antrian= $data['id_antrian'];
                $no_antrian= $data['no_antrian'];
                $kodebooking= $data['kodebooking'];
                if(empty($data['id_kunjungan'])){
                    $LabelIdKunjungan='<span class="text-success">Belum Terhubung</span>';
                }else{
                    $id_kunjungan=$data['id_kunjungan'];
                    $LabelIdKunjungan='<span class="text-danger">Sudah Terhubung Ke ID '.$id_kunjungan.'</span>';
                }
                echo '          <li class="list-group-item">';
                echo '              <dt><input type="radio" name="GetIdAntrianPilih" id="GetIdAntrianPilih'.$no.'" value="'.$id_antrian.'"> <label for="GetIdAntrianPilih'.$no.'">'.$kodebooking.'</label></dt>';
                echo '              <span>No Antrian '.$no_antrian.'</span><br>';
                echo '              <small>Kunjungan '.$LabelIdKunjungan.'</small>';
                echo '          </li>';
                echo '';
                $no++;
            }
            echo '          </ul>';
            echo '      </div>';
            echo '  </div>';
            echo '  <di class="row">';
            echo '      <di class="col-md-12" id="NotifikasiPilihIdAntrian">';
            echo '         Silahkan pilih data antrian yang akan dihubungkan dengan kunjungan.';
            echo '      </di>';
            echo '  </di>';
            echo '</div>';
            echo '<di class="modal-footer bg-inverse">';
            echo '  <button type="submit" class="btn btn-sm btn-success">';
            echo '      <i class="ti ti-check-box"></i> Tambahkan Ke Form';
            echo '  </button>';
            echo '  <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">';
            echo '      <i class="ti ti-close"></i> Tutup';
            echo '  </button>';
            echo '</di>';
        }
    }
?>