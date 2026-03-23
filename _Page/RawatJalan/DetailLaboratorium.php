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
        $id_permintaan=getDataDetail($Conn,"laboratorium_permintaan",'id_kunjungan',$id_kunjungan,'id_permintaan');
        echo '<div class="row">';
        echo '  <div class="col col-md-12">';
        echo '      <button type="button" class="btn btn-block btn-sm btn-round btn-outline-primary mb-2" title="Kelola Laboratorium" data-toggle="modal" data-target="#ModalKelolaLaboratorium" data-id="'.$id_kunjungan.'">';
        echo '          <i class="ti ti-plus"></i> Pemeriksaan Laboratorium';
        echo '      </button>';
        echo '  </div>';
        echo '</div>';
        if(empty($id_permintaan)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Belum Ada Data Permintaan Pemeriksaan Laboratorium Untuk Kunjungan Ini';
            echo '  </div>';
            echo '</div>';
        }else{
            $no = 1;
            $query = mysqli_query($Conn, "SELECT * FROM laboratorium_permintaan WHERE id_kunjungan='$id_kunjungan' ORDER BY id_permintaan ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_permintaan=$data['id_permintaan'];
                $id_pasien=$data['id_pasien'];
                $id_kunjungan=$data['id_kunjungan'];
                $id_dokter=$data['id_dokter'];
                $tujuan=$data['tujuan'];
                $nama_dokter=$data['nama_dokter'];
                $tanggal=$data['tanggal'];
                $faskes=$data['faskes'];
                $unit=$data['unit'];
                $prioritas=$data['prioritas'];
                $diagnosis=$data['diagnosis'];
                $keterangan_permintaan=$data['keterangan_permintaan'];
                $nama_signature=$data['nama_signature'];
                $status=$data['status'];
                $keterangan_status=$data['keterangan_status'];
                //Buka Informasi Pemeriksaan
                $id_lab=getDataDetail($Conn,"laboratorium_pemeriksaan",'id_permintaan',$id_permintaan,'id_lab');
                if(!empty($id_lab)){
                    $LabelPemeriksaan='<span class="text-success"><i class="ti ti-check"></i> Tersedia</span>';
                }else{
                    $LabelPemeriksaan='<span class="text-danger"><i class="ti ti-close"></i> Belum Ada</span>';
                }
                //Uraian Pemeriksaan
                $id_rincian_lab=getDataDetail($Conn,"laboratorium_rincian",'id_permintaan',$id_permintaan,'id_rincian_lab');
                if(!empty($id_rincian_lab)){
                    $LabelRincian='<span class="text-success"><i class="ti ti-check"></i> Tersedia</span>';
                }else{
                    $LabelRincian='<span class="text-danger"><i class="ti ti-close"></i> Belum Ada</span>';
                }
                //Format Tanggal
                $strtotime1=strtotime($tanggal);
                $TanggalPermintaan=date('d/m/Y H:i T',$strtotime1);
                echo '<div class="row mt-2 mb-2">';
                echo '  <div class="col-md-12 sub-title">';
                echo '      ID Permintaan Lab : <code class="text-secondary">'.$id_permintaan.'</code>';
                echo '          <a href="javascript:void(0);" class="badge badge-primary" title="Informasi Lengkap Pemeriksaan Lab" data-toggle="modal" data-target="#ModalDetailPemeriksaanLab" data-id="'.$id_permintaan.'">';
                echo '              <i class="ti ti-search"></i> Selengkapnya';
                echo '          </a>';
                echo '      <ol>';
                echo '          <li class="mb-2">Tgl/Jam Permintaan : <code class="text-secondary">'.$TanggalPermintaan.'</code></li>';
                echo '          <li class="mb-2">Faskes : <code class="text-secondary">'.$faskes.'</code></li>';
                echo '          <li class="mb-2">Unit : <code class="text-secondary">'.$unit.'</code></li>';
                echo '          <li class="mb-2">Dokter : <code class="text-secondary">'.$nama_dokter.'</code></li>';
                echo '          <li class="mb-2">Tujuan : <code class="text-secondary">'.$tujuan.'</code></li>';
                echo '          <li class="mb-2">Prioritas : <code class="text-secondary">'.$prioritas.'</code></li>';
                echo '          <li class="mb-2">Diagnosis : <code class="text-secondary">'.$diagnosis.'</code></li>';
                echo '          <li class="mb-2">Keterangan Permintaan : <code class="text-secondary">'.$keterangan_permintaan.'</code></li>';
                echo '          <li class="mb-2">Status : <code class="text-secondary">('.$status.') '.$keterangan_status.'</code></li>';
                echo '          <li class="mb-2">Informasi Pemeriksaan : <code class="text-secondary">'.$LabelPemeriksaan.'</code></li>';
                echo '          <li class="mb-2">Rincian Pemeriksaan : <code class="text-secondary">'.$LabelRincian.'</code></li>';
                echo '      </ol>';
                echo '  </div>';
                echo '</div>';
                $no++;
            }
        }
    }
?>

