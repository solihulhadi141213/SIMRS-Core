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
        $id_edukasi=getDataDetail($Conn,"edukasi",'id_kunjungan',$id_kunjungan,'id_edukasi');
        echo '<div class="row">';
        echo '  <div class="col col-md-12 icon-btn">';
        echo '      <button type="button" class="btn btn-block btn-sm btn-round btn-outline-primary mb-2" title="Kelola Edukasi" data-toggle="modal" data-target="#ModalKelolaEdukasi" data-id="'.$id_kunjungan.'">';
        echo '          <i class="ti ti-layers"></i> Kelola Edukasi';
        echo '      </button>';
        echo '  </div>';
        echo '</div>';
        if(empty($id_edukasi)){
            echo '<div class="card">';
            echo '  <div class="card-body text-center text-danger">';
            echo '      Belum ada informasi edukasi pasien untuk kunjungan ini.';
            echo '  </div>';
            echo '</div>';
        }else{
            $no = 1;
            $query = mysqli_query($Conn, "SELECT * FROM edukasi WHERE id_kunjungan='$id_kunjungan' ORDER BY id_edukasi ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_edukasi=$data['id_edukasi'];
                $id_pasien=$data['id_pasien'];
                $id_kunjungan=$data['id_kunjungan'];
                $id_akses=$data['id_akses'];
                $petugas_entry=$data['petugas_entry'];
                $tanggal_entry=$data['tanggal_entry'];
                $tanggal_edukasi=$data['tanggal_edukasi'];
                $kategori_edukasi=$data['kategori_edukasi'];
                $materi_edukasi=$data['materi_edukasi'];
                $pemberi_edukasi=$data['pemberi_edukasi'];
                $penerima_edukasi=$data['penerima_edukasi'];
                $keterangan_edukasi=$data['keterangan_edukasi'];
                $status_edukasi=$data['status_edukasi'];
                //Routing Status Edukasi
                if($status_edukasi=="Sudah Mengerti"){
                    $LabelStatus='<span class="text-primary">'.$status_edukasi.'</span>';
                }else{
                    if($status_edukasi=="Re Edukasi"){
                        $LabelStatus='<span class="text-danger">'.$status_edukasi.'</span>';
                    }else{
                        if($status_edukasi=="Re Demonstrasi"){
                            $LabelStatus='<span class="text-warning">'.$status_edukasi.'</span>';
                        }else{
                            $LabelStatus='<span class="text-dark">'.$status_edukasi.'</span>';
                        }
                    }
                }
                //Format Tanggal
                $strtotime1=strtotime($tanggal_entry);
                $strtotime2=strtotime($tanggal_edukasi);
                $TanggalEntry=date('d/m/Y H:i T',$strtotime1);
                $TanggalEdukasi=date('d/m/Y H:i T',$strtotime2);
                //Json 
                $JsonPemberiEdukasi =json_decode($pemberi_edukasi, true);
                $JsonPenerimaEdukasi =json_decode($penerima_edukasi, true);
                $JsonKeteranganEdukasi =json_decode($keterangan_edukasi, true);
                //Pemberi Edukasi
                $NamaPemberiEdukasi=$JsonPemberiEdukasi['nama'];
                $KontakPemberiEdukasi=$JsonPemberiEdukasi['kontak'];
                $IdentitasPemberiEdukasi=$JsonPemberiEdukasi['kategori_identitas'];
                $NomorIdentitasPemberiEdukasi=$JsonPemberiEdukasi['no_identitas'];
                $TtdPemberiEdukasi=$JsonPemberiEdukasi['ttd'];
                if(empty($TtdPemberiEdukasi)){
                    $LabelTtdPemberiEdukasi='';
                }else{
                    $LabelTtdPemberiEdukasi='<br><img src="data:image/gif;base64,'. $TtdPemberiEdukasi .'" width="150px">';
                }
                //Penerima Edukasi
                $NamaPenerimaEdukasi=$JsonPenerimaEdukasi['nama'];
                $KontakPenerimaEdukasi=$JsonPenerimaEdukasi['kontak'];
                $IdentitasPenerimaEdukasi=$JsonPenerimaEdukasi['kategori_identitas'];
                $NomorIdentitasPenerimaEdukasi=$JsonPenerimaEdukasi['no_identitas'];
                $TtdPenerimaEdukasi=$JsonPenerimaEdukasi['ttd'];
                if(empty($TtdPenerimaEdukasi)){
                    $LabelTtdPenerimaEdukasi='';
                }else{
                    $LabelTtdPenerimaEdukasi='<br><img src="data:image/gif;base64,'. $TtdPenerimaEdukasi .'" width="150px">';
                }
                //Keterangan Edukasi
                $Bahasa=$JsonKeteranganEdukasi['bahasa'];
                $Penerjemah=$JsonKeteranganEdukasi['penerjemah'];
                $Hambatan=$JsonKeteranganEdukasi['hambatan'];
                $jenis_hambatan=$JsonKeteranganEdukasi['jenis_hambatan'];
                $durasi=$JsonKeteranganEdukasi['durasi'];
                $kesediaan_edukasi=$JsonKeteranganEdukasi['kesediaan_edukasi'];
                echo '<div class="card mb-2">';
                echo '  <div class="card-header">';
                echo '      <div class="row">';
                echo '          <div class="col-md-12">';
                echo '              <dt>'.$no.'. '.$kategori_edukasi.'</dt>';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '  <div class="card-body">';
                echo '      <div class="row">';
                echo '          <div class="col col-md-12">';
                echo '              <ol>';
                echo '                  <li>ID.Edukasi : <code class="text-secondary">'.$id_edukasi.'</code></li>';
                echo '                  <li>Tgl/Jam Entry : <code class="text-secondary">'.$TanggalEntry.'</code></li>';
                echo '                  <li>Tgl/Jam Edukasi : <code class="text-secondary">'.$TanggalEdukasi.'</code></li>';
                echo '                  <li>Petugas Entry : <code class="text-secondary">'.$petugas_entry.'</code></li>';
                echo '                  <li>Kategori : <code class="text-secondary">'.$kategori_edukasi.'</code></li>';
                echo '                  <li>Status Edukasi : <code class="text-secondary">'.$LabelStatus.'</code></li>';
                echo '              </ol>';
                echo '          </div>';
                echo '      </div>';
                echo '      <div class="row">';
                echo '          <div class="col col-md-6 text-center">';
                echo '              Pemberi Edukasi';
                echo '              '.$LabelTtdPemberiEdukasi.'<br>';
                echo '              ('.$NamaPemberiEdukasi.')';
                echo '          </div>';
                echo '          <div class="col col-md-6 text-center">';
                echo '              Penerima Edukasi';
                echo '              '.$LabelTtdPenerimaEdukasi.'<br>';
                echo '              ('.$NamaPenerimaEdukasi.')';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
                $no++;
            }
        }
    }
?>

