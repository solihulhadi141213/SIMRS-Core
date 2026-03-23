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
        $id_cppt=getDataDetail($Conn,"cppt",'id_kunjungan',$id_kunjungan,'id_cppt');
        echo '<div class="row">';
        echo '  <div class="col col-md-12 icon-btn">';
        echo '      <button type="button" class="btn btn-block btn-sm btn-round btn-outline-primary mb-2" title="Kelola CPPT" data-toggle="modal" data-target="#ModalKelolaCppt" data-id="'.$id_kunjungan.'">';
        echo '          <i class="ti ti-layers"></i> Kelola CPPT';
        echo '      </button>';
        echo '  </div>';
        echo '</div>';
        if(empty($id_cppt)){
            echo '<div class="card">';
            echo '  <div class="card-body text-center text-danger">';
            echo '      Belum ada CPPT untuk kunjungan ini.';
            echo '  </div>';
            echo '</div>';
        }else{
            $no = 1;
            $query = mysqli_query($Conn, "SELECT * FROM cppt WHERE id_kunjungan='$id_kunjungan' ORDER BY id_cppt ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_cppt=$data['id_cppt'];
                $id_pasien=$data['id_pasien'];
                $id_kunjungan=$data['id_kunjungan'];
                $id_akses=$data['id_akses'];
                $tanggal_entry=$data['tanggal_entry'];
                $nakes=$data['nakes'];
                $dokter=$data['dokter'];
                $subjective=$data['subjective'];
                $objective=$data['objective'];
                $assessment=$data['assessment'];
                $plan=$data['plan'];
                $catatan=$data['catatan'];
                $status=$data['status'];
                //Format Tanggal
                $strtotime1=strtotime($tanggal_entry);
                $TanggalEntry=date('d/m/Y H:i T',$strtotime1);
                //Json 
                $JsonNakes =json_decode($nakes, true);
                $JsonDokter =json_decode($dokter, true);
                //Routing Status
                if($status=="Pending"){
                    $LabelStatus='<span class="text-danger">'.$status.'</span>';
                }else{
                    $LabelStatus='<span class="text-success">'.$status.'</span>';
                }
                echo '<div class="card mb-2">';
                echo '  <div class="card-header">';
                echo '      <div class="row">';
                echo '          <div class="col-md-12">';
                echo '              <dt>'.$no.'. CPPT/'.$id_cppt.'/'.$id_kunjungan.'/'.$id_pasien.'</dt>';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '  <div class="card-body">';
                echo '      <div class="row">';
                echo '          <div class="col col-md-12">';
                echo '              <ol>';
                echo '                  <li>ID.CPPT : <code class="text-secondary">'.$id_cppt.'</code></li>';
                echo '                  <li>No.RM : <code class="text-secondary">'.$id_pasien.'</code></li>';
                echo '                  <li>Tgl/Jam Entry : <code class="text-secondary">'.$TanggalEntry.'</code></li>';
                echo '                  <li>Status CPPT : <code class="text-secondary">'.$LabelStatus.'</code></li>';
                echo '                  <li>Subjective (S) : <code class="text-secondary">'.$subjective.'</code></li>';
                echo '                  <li>Objective (O) : <code class="text-secondary">'.$objective.'</code></li>';
                echo '                  <li>Assessment (A) : <code class="text-secondary">'.$assessment.'</code></li>';
                echo '                  <li>Plan (P) : <code class="text-secondary">'.$plan.'</code></li>';
                echo '              </ol>';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
                $no++;
            }
        }
    }
?>

