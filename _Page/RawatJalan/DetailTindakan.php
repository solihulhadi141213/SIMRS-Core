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
        $id_tindakan=getDataDetail($Conn,"tindakan",'id_kunjungan',$id_kunjungan,'id_tindakan');
        echo '<button type="button" class="btn btn-sm btn-outline-dark btn-block mb-2" data-toggle="modal" data-target="#ModalTambahTindakan" data-id="'.$id_kunjungan.'">';
        echo '  <i class="ti ti-plus"></i> Tambah Tindakan';
        echo '</button>';
        if(empty($id_tindakan)){
            echo '<div class="card">';
            echo '  <div class="card-body text-center text-danger">';
            echo '      Belum ada informasi tindakan untuk kunjungan ini.';
            echo '  </div>';
            echo '</div>';
        }else{
            $no = 1;
            $query = mysqli_query($Conn, "SELECT * FROM tindakan WHERE id_kunjungan='$id_kunjungan' ORDER BY id_tindakan ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_tindakan= $data['id_tindakan'];
                $id_pasien= $data['id_pasien'];
                $id_kunjungan= $data['id_kunjungan'];
                $id_akses= $data['id_akses'];
                $nama_pasien= $data['nama_pasien'];
                $nama_petugas= $data['nama_petugas'];
                $tanggal_entry= $data['tanggal_entry'];
                $tanggal_pelaksanaan= $data['tanggal_pelaksanaan'];
                $waktu_mulai= $data['waktu_mulai'];
                $waktu_selesai= $data['waktu_selesai'];
                $kode_tindakan= $data['kode_tindakan'];
                $nama_tindakan= $data['nama_tindakan'];
                $alat_medis= $data['alat_medis'];
                $bmhp= $data['bmhp'];
                $nakes= $data['nakes'];
                //Json Decode
                $JsonAlatMedis=json_decode($alat_medis, true);
                $JsonBmhp =json_decode($bmhp, true);
                $JsonNakes=json_decode($nakes, true);
                //Format Tanggal
                $strtotime1=strtotime($tanggal_entry);
                $strtotime2=strtotime($tanggal_pelaksanaan);
                $FormatTanggalEntry=date('d/m/Y H:i T',$strtotime1);
                $FormatTanggalPelaksanaan=date('d/m/Y',$strtotime2);
                echo '<div class="card mb-2">';
                echo '  <div class="card-header">';
                echo '      <div class="row">';
                echo '          <div class="col-md-12 mb-2 text-center">';
                echo '              <dt>Tindakan No.'.$id_tindakan.'/'.$id_pasien.'/'.$id_kunjungan.'</dt>';
                echo '          </div>';
                echo '          <div class="col-md-12 mb-2 text-center">';
                echo '              <div class="btn-group">';
                echo '                  <a href="javascript:void(0);" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalInfoTindakan" data-id="'.$id_tindakan.'">';
                echo '                      <i class="ti ti-info-alt"></i>';
                echo '                  </a>';
                echo '                  <a href="javascript:void(0);" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalEditTindakan" data-id="'.$id_tindakan.'">';
                echo '                      <i class="ti ti-pencil-alt"></i>';
                echo '                  </a>';
                echo '                  <a href="javascript:void(0);" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapusTindakan" data-id="'.$id_tindakan.'">';
                echo '                      <i class="ti ti-trash"></i>';
                echo '                  </a>';
                echo '                  <a href="javascript:void(0);" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalCetakTindakan" data-id="'.$id_tindakan.'">';
                echo '                      <i class="ti ti-printer"></i>';
                echo '                  </a>';
                echo '              </div>';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '  <div class="card-body">';
                echo '      <div class="row mb-3">';
                echo '          <div class="col col-md-6">a. ID Tindakan</div>';
                echo '          <div class="col col-md-6">'.$id_tindakan.'</div>';
                echo '      </div>';
                echo '      <div class="row mb-3">';
                echo '          <div class="col col-md-6">b. Tanggal Entry</div>';
                echo '          <div class="col col-md-6">'.$FormatTanggalEntry.'</div>';
                echo '      </div>';
                echo '      <div class="row mb-3">';
                echo '          <div class="col col-md-6">c. Tanggal Pelaksanaan</div>';
                echo '          <div class="col col-md-6">'.$FormatTanggalPelaksanaan.'</div>';
                echo '      </div>';
                echo '      <div class="row mb-3">';
                echo '          <div class="col col-md-6 mb-2">d. Tindakan/Procedur</div>';
                echo '          <div class="col col-md-6">'.$kode_tindakan.'-'.$nama_tindakan.'</div>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
                $no++;
            }
        }
    }
?>

