<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="card">';
        echo '  <div class="card-body text-center text-danger">';
        echo '      ID Kunjungan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        $id_diagnosis_pasien=getDataDetail($Conn,"diagnosis_pasien",'id_kunjungan',$id_kunjungan,'id_diagnosis_pasien');
        if(empty($id_diagnosis_pasien)){
            echo '<div class="card">';
            echo '  <div class="card-header">';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalTambahDiagnosa" data-id="'.$id_kunjungan.'">';
            echo '          <i class="ti ti-plus"></i> Tambah Diagnosa';
            echo '      </button>';
            echo '  </div>';
            echo '  <div class="card-body text-center text-danger">';
            echo '      Belum ada informasi Diagnosa untuk kunjungan ini.';
            echo '  </div>';
            echo '</div>';
        }else{
            echo '<div class="card">';
            echo '  <div class="card-header">';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalTambahDiagnosa" data-id="'.$id_kunjungan.'">';
            echo '          <i class="ti ti-plus"></i> Tambah Diagnosa';
            echo '      </button>';
            echo '  </div>';
            echo '  <div class="card-body">';
            $no = 1;
            $query = mysqli_query($Conn, "SELECT DISTINCT kategori FROM diagnosis_pasien WHERE id_kunjungan='$id_kunjungan' ORDER BY kategori ASC");
            while ($data = mysqli_fetch_array($query)) {
                $kategori= $data['kategori'];
                echo '<div class="row mb-2">';
                echo '  <div class="col-md-12">';
                echo '      <dt>'.$kategori.'</dt>';
                echo '      <ol>';
                $no2 = 1;
                $query2 = mysqli_query($Conn, "SELECT * FROM diagnosis_pasien WHERE id_kunjungan='$id_kunjungan' AND kategori='$kategori'");
                while ($data2 = mysqli_fetch_array($query2)) {
                    $id_diagnosis_pasien= $data2['id_diagnosis_pasien'];
                    $kode= $data2['kode'];
                    $diagnosis= $data2['diagnosis'];
                    echo '      <li class="text-muted">';
                    echo '          <span class="text-muted">';
                    echo '              '.$kode.'-'.$diagnosis.'';
                    echo '          </span>';
                    echo '          <a href="javascript:void(0);" class="text-primary"  data-toggle="modal" data-target="#ModalInfoDiagnosa" data-id="'.$id_kunjungan.','.$id_diagnosis_pasien.'">';
                    echo '              <small><i class="ti ti-info-alt"></i></small>';
                    echo '          </a>';
                    echo '          <a href="javascript:void(0);" class="text-primary"  data-toggle="modal" data-target="#ModalEditDiagnosa" data-id="'.$id_kunjungan.','.$id_diagnosis_pasien.'">';
                    echo '              <small><i class="ti ti-pencil-alt"></i></small>';
                    echo '          </a>';
                    echo '          <a href="javascript:void(0);" class="text-primary"  data-toggle="modal" data-target="#ModalHapusDiagnosa" data-id="'.$id_kunjungan.','.$id_diagnosis_pasien.'">';
                    echo '              <small><i class="ti ti-trash"></i></small>';
                    echo '          </a>';
                    echo '      </li>';
                    $no2++;
                }
                echo '      </ol>';
                echo '  </div>';
                echo '</div>';
                $no++;
            }
            echo '  </div>';
            echo '</div>';
        }
    }
?>