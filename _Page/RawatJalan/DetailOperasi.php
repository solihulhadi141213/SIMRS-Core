<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Kunjungan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        $id_operasi=getDataDetail($Conn,"operasi",'id_kunjungan',$id_kunjungan,'id_operasi');
        $id_jadwal_operasi=getDataDetail($Conn,"operasi",'id_kunjungan',$id_kunjungan,'id_jadwal_operasi');
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <button type="button" class="btn btn-sm btn-outline-primary btn-round btn-block" data-toggle="modal" data-target="#ModalKelolaOperasi" data-id="'.$id_kunjungan.'">';
        echo '          <i class="ti ti-layers-alt"></i> Kelola Operasi';
        echo '      </button>';
        echo '  </div>';
        echo '</div>';
        if(empty($id_operasi)){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Belum ada informasi operasi untuk kunjungan ini.';
            echo '  </div>';
            echo '</div>';
        }else{
            //Membuka Data Operasi
            $id_jadwal_operasi=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'id_jadwal_operasi');
            $id_kunjungan=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'id_kunjungan');
            $id_pasien=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'id_pasien');
            $id_akses=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'id_akses');
            $tanggal_entry=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'tanggal_entry');
            $tanggal_mulai=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'tanggal_mulai');
            $tanggal_selesai=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'tanggal_selesai');
            $petugas_entry=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'petugas_entry');
            $pelaksana=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'pelaksana');
            $diagnosa_operasi=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'diagnosa_operasi');
            $body_site=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'body_site');
            $tindakan_operasi=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'tindakan_operasi');
            $instrumen=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'instrumen');
            $keterangan_dokter=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'keterangan_dokter');
            $anastesi=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'anastesi');
            $persetujuan=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'persetujuan');
            //Nama
            $nama_pasien=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'nama');
            //Format Tanggal
            $strtotime1=strtotime($tanggal_entry);
            $strtotime2=strtotime($tanggal_mulai);
            $strtotime3=strtotime($tanggal_selesai);
            $TanggalEntry=date('d/m/Y H:i T',$strtotime1);
            $TanggalMulai=date('d/m/Y H:i T',$strtotime2);
            $TanggalSelesai=date('d/m/Y H:i T',$strtotime3);
            echo '<div class="row">';
            echo '  <div class="col-md-12">';
            echo '      <ol>';
            echo '          <li class="mb-3">';
            echo '              <dt>Informasi Umum</dt>';
            echo '              <ul>';
            echo '                  <li>ID Operasi : <code class="text-secondary">'.$id_operasi.'</code></li>';
            echo '                  <li>ID Jadwal : <code class="text-secondary">'.$id_jadwal_operasi.'</code></li>';
            echo '                  <li>No.RM : <code class="text-secondary">'.$id_pasien.'</code></li>';
            echo '                  <li>ID Kunjungan : <code class="text-secondary">'.$id_kunjungan.'</code></li>';
            echo '                  <li>Tgl/Jam Entry : <code class="text-secondary">'.$TanggalEntry.'</code></li>';
            echo '                  <li>Tgl/Jam Mulai Operasi : <code class="text-secondary">'.$TanggalMulai.'</code></li>';
            echo '                  <li>Tgl/Jam Selesai Operasi : <code class="text-secondary">'.$TanggalSelesai.'</code></li>';
            echo '              </ul>';
            echo '          </li>';
            echo '      </ol>';
            echo '  </div>';
            echo '</div>';
        }
    }
?>