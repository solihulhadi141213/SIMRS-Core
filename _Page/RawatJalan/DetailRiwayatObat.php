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
        $IdRiwayat=getDataDetail($Conn,"riwayat_penggunaan_obat",'id_kunjungan',$id_kunjungan,'id_riwayat_penggunaan_obat');
        echo '<div class="row">';
        echo '  <div class="col col-md-6">';
        echo '      <button type="button" class="btn btn-sm btn-primary btn-block mb-2" data-toggle="modal" data-target="#ModalTambahRiwayatObat" data-id="'.$id_kunjungan.'">';
        echo '          <i class="ti ti-plus"></i> Tambah Riwayat';
        echo '      </button>';
        echo '  </div>';
        echo '  <div class="col col-md-6">';
        echo '      <button type="button" class="btn btn-sm btn-secondary btn-block mb-2" data-toggle="modal" data-target="#ModalCetakRiwayatObat" data-id="'.$id_kunjungan.'">';
        echo '          <i class="ti ti-printer"></i> Cetak';
        echo '      </button>';
        echo '  </div>';
        echo '</div>';
        if(empty($IdRiwayat)){
            echo '<div class="card">';
            echo '  <div class="card-body text-center text-danger">';
            echo '      Belum ada informasi riwayat penggunaan obat untuk kunjungan ini.';
            echo '  </div>';
            echo '</div>';
        }else{
            $no = 1;
            $query = mysqli_query($Conn, "SELECT * FROM riwayat_penggunaan_obat WHERE id_kunjungan='$id_kunjungan' ORDER BY id_riwayat_penggunaan_obat ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_riwayat_penggunaan_obat= $data['id_riwayat_penggunaan_obat'];
                $id_pasien= $data['id_pasien'];
                $id_kunjungan= $data['id_kunjungan'];
                $id_akses= $data['id_akses'];
                $tanggal_entry= $data['tanggal_entry'];
                $id_obat= $data['id_obat'];
                $nama_obat= $data['nama_obat'];
                $waktu_penggunaan= $data['waktu_penggunaan'];
                //Json Decode
                $JsonObat=json_decode($nama_obat, true);
                //Buka Obat
                $NamaObat=$JsonObat['nama_obat'];
                $Sediaan=$JsonObat['sediaan'];
                $dosis=$JsonObat['dosis'];
                $aturan_pakai=$JsonObat['aturan_pakai'];
                $WaktuPenggunaan=$JsonObat['waktu_penggunaan'];
                //Format Tanggal
                $strtotime1=strtotime($tanggal_entry);
                $strtotime2=strtotime($waktu_penggunaan);
                $FormatTanggalEntry=date('d/m/Y H:i T',$strtotime1);
                $FormatTanggalPenggunaan=date('d/m/Y H:i T',$strtotime2);
                echo '<div class="card mb-2">';
                echo '  <div class="card-header">';
                echo '      <div class="row">';
                echo '          <div class="col-md-12">';
                echo '              <dt>'.$no.'. '.$NamaObat.'</dt>';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '  <div class="card-body">';
                echo '      <div class="row">';
                echo '          <div class="col col-md-12">';
                echo '              <ol>';
                echo '                  <li>Sediaan : <code class="text-secondary">'.$Sediaan.'</code></li>';
                echo '                  <li>Dosis : <code class="text-secondary">'.$dosis.'</code></li>';
                echo '                  <li>Aturan Pakai : <code class="text-secondary">'.$aturan_pakai.'</code></li>';
                echo '                  <li>Waktu Penggunaan : <code class="text-secondary">'.$WaktuPenggunaan.'</code></li>';
                echo '                  <li>Tgl/Jam Penggunaan : <code class="text-secondary">'.$FormatTanggalPenggunaan.'</code></li>';
                echo '                  <li>Tgl/Jam Entry : <code class="text-secondary">'.$FormatTanggalEntry.'</code></li>';
                echo '              </ol>';
                echo '          </div>';
                echo '      </div>';
                echo '      <div class="row">';
                echo '          <div class="col col-md-12">';
                echo '              <div class="icon-btn">';
                echo '                  <a href="javascript:void(0);" class="btn btn-icon btn-secondary btn-outline-secondary" data-toggle="modal" data-target="#ModalInfoRiwayatObat" data-id="'.$id_riwayat_penggunaan_obat.'">';
                echo '                      <i class="icofont-info"></i>';
                echo '                  </a>';
                echo '                  <a href="javascript:void(0);" class="btn btn-icon btn-secondary btn-outline-secondary" data-toggle="modal" data-target="#ModalEditRiwayatObat" data-id="'.$id_riwayat_penggunaan_obat.'">';
                echo '                      <i class="icofont-edit"></i>';
                echo '                  </a>';
                echo '                  <a href="javascript:void(0);" class="btn btn-icon btn-secondary btn-outline-secondary" data-toggle="modal" data-target="#ModalHapusRiwayatObat" data-id="'.$id_riwayat_penggunaan_obat.'">';
                echo '                      <i class="icofont-trash"></i>';
                echo '                  </a>';
                echo '              </div>';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
                $no++;
            }
        }
    }
?>

