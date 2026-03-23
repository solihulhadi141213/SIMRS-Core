<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['tanggal'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <div class="alert alert-danger" role="alert">';
        echo '          Tanggal Tidak Boleh Kosong';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_poliklinik'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center">';
            echo '      <div class="alert alert-danger" role="alert">';
            echo '          Poliklinik Tidak Boleh Kosong';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            if(empty($_POST['id_dokter'])){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center">';
                echo '      <div class="alert alert-danger" role="alert">';
                echo '          Dokter Tidak Boleh Kosong';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                if(empty($_POST['status'])){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center">';
                    echo '      <div class="alert alert-danger" role="alert">';
                    echo '          Status Tidak Boleh Kosong';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $tanggal=$_POST['tanggal'];
                    $id_poliklinik=$_POST['id_poliklinik'];
                    $id_dokter=$_POST['id_dokter'];
                    $status=$_POST['status'];
                    //Buka Nama Hari
                    $nama_hari = NamaHariJadwal($tanggal);
                    //Buka Kode Dokter dan kode poli
                    $kode_dokter =getDataDetail_v2($Conn,"dokter",'id_dokter',$id_dokter,'kode');
                    $kodepoli =getDataDetail_v2($Conn,"poliklinik",'id_poliklinik',$id_poliklinik,'kode');
                    
                    $stmt = $Conn->prepare("SELECT * FROM antrian WHERE tanggal_kunjungan = ? AND kode_dokter = ? AND kodepoli = ? AND status = ? ORDER BY no_antrian ASC");
                    $stmt->bind_param("ssss", $tanggal, $kode_dokter, $kodepoli, $status);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $jumlah_data = $result->num_rows;
                    if(empty($jumlah_data)){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center">';
                        echo '      <div class="alert alert-danger" role="alert">';
                        echo '          Antrian Tidak Ditemukan';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
?>
                        <div class="row mb-3 border-1 border-bottom border-bottom-inverse">
                            <div class="col-md-12">
                                <div class="table table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-center"><dt>No</dt></td>
                                                <td class="text-center"><dt>Kode</dt></td>
                                                <td class="text-center"><dt>Pasien</dt></td>
                                                <td class="text-center"><dt>RM</dt></td>
                                                <td class="text-center"><dt>NIK</dt></td>
                                                <td class="text-center"><dt>No.BPJS</dt></td>
                                                <td class="text-center"><dt>Sumber</dt></td>
                                                <td class="text-center"><dt>Kategori</dt></td>
                                                <td class="text-center"><dt>Opsi</dt></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                while ($row_antrian = $result->fetch_assoc()) {
                                                    $id_antrian = $row_antrian['id_antrian'];
                                                    $no_antrian = $row_antrian['no_antrian'];
                                                    $kodebooking = $row_antrian['kodebooking'];
                                                    $id_pasien = $row_antrian['id_pasien'];
                                                    $nama_pasien = $row_antrian['nama_pasien'];
                                                    $tanggal_kunjungan = $row_antrian['tanggal_kunjungan'];
                                                    $nomorkartu = $row_antrian['nomorkartu'];
                                                    $nik = $row_antrian['nik'];
                                                    $status = $row_antrian['status'];
                                                    $sumber_antrian = $row_antrian['sumber_antrian'];
                                                    $pembayaran = $row_antrian['pembayaran'];
                                                    //Routing Berdasarkan kondisi
                                                    if(empty($id_pasien)){
                                                        $LabelIdPasien='<span class="text-danger">None</span>';
                                                    }else{
                                                        $LabelIdPasien='<span class="text-dark">'.$id_pasien.'</span>';
                                                    }
                                                    if(empty($nik)){
                                                        $LabelNik='<span class="text-danger">None</span>';
                                                    }else{
                                                        $LabelNik='<span class="text-dark">'.$nik.'</span>';
                                                    }
                                                    if(empty($nomorkartu)){
                                                        $LabelBpjs='<span class="text-danger">None</span>';
                                                    }else{
                                                        $LabelBpjs='<span class="text-dark">'.$nomorkartu.'</span>';
                                                    }
                                                    if($pembayaran=="UMUM"){
                                                        $LabelKategori='<badge class="badge bg-primary">UMUM</badge>';
                                                    }else{
                                                        $LabelKategori='<badge class="badge bg-success">BPJS/JKN</badge>';
                                                    }
                                                    echo '<tr>';
                                                    echo '  <td class="text-center">'.$no_antrian.'</td>';
                                                    echo '  <td class="text-left">'.$kodebooking.'</td>';
                                                    echo '  <td class="text-left">'.$nama_pasien.'</td>';
                                                    echo '  <td class="text-left">'.$LabelIdPasien.'</td>';
                                                    echo '  <td class="text-left">'.$LabelNik.'</td>';
                                                    echo '  <td class="text-left">'.$LabelBpjs.'</td>';
                                                    echo '  <td class="text-left">'.$sumber_antrian.'</td>';
                                                    echo '  <td class="text-center">'.$LabelKategori.'</td>';
                                                    echo '  <td class="text-center">';
                                                    echo '      <a href="javascript:void(0);" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#ModalDetailAntrian" data-id="'.$id_antrian.'">';
                                                    echo '          <i class="icofont icofont-mega-phone"></i> Panggil';
                                                    echo '      </a>';
                                                    echo '  </td>';
                                                    echo '</tr>';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
<?php
                    }
                }
            }
        }
    }
    
?>