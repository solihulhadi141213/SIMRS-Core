<?php
    //Koneksi
    include "../../_Config/Connection.php";
?>
<div class="row">
    <div class="col-md-12">
        <div class="table table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td align="center"><dt>No</dt></td>
                        <td align="center"><dt>No.RM</dt></td>
                        <td align="center"><dt>Id.Reg</dt></td>
                        <td align="center"><dt>Tgl</dt></td>
                        <td align="center"><dt>Pasien</dt></td>
                        <td align="center"><dt>Opsi</dt></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(empty($_POST['kelas'])){
                            echo '<tr>';
                            echo '  <td align="center" colspan="6">Siahkan Pilih Kelas Terlebih Dulu</td>';
                            echo '</tr>';
                        }else{
                            if(empty($_POST['ruangan'])){
                                echo '<tr>';
                                echo '  <td align="center" colspan="6">Siahkan Pilih Ruangan Terlebih Dulu</td>';
                                echo '</tr>';
                            }else{
                                $ruangan=$_POST['ruangan'];
                                $kelas=$_POST['kelas'];
                                $no=1;
                                $query = mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE kelas='$kelas' AND ruangan='$ruangan' AND status='Terdaftar' ORDER BY id_kunjungan ASC");
                                while ($data = mysqli_fetch_array($query)) {
                                    $id_kunjungan = $data['id_kunjungan'];
                                    $id_kunjungan = $data['id_kunjungan'];
                                    $id_pasien = $data['id_pasien'];
                                    $nama = $data['nama'];
                                    $tanggal = $data['tanggal'];
                                    //Format Tanggal
                                    $strtotime=strtotime($tanggal);
                                    $TanggalKunjunga=date('d/m/Y H:i:s',$strtotime);
                                    echo '<tr>';
                                    echo '  <td align="center"><small>'.$no.'</small></td>';
                                    echo '  <td align="center"><small>'.$id_pasien.'</small></td>';
                                    echo '  <td align="center"><small>'.$id_kunjungan.'</small></td>';
                                    echo '  <td align="center"><small>'.$TanggalKunjunga.'</small></td>';
                                    echo '  <td align="left"><small>'.$nama.'</small></td>';
                                    echo '  <td align="left">';
                                    echo '      <a href="index.php?Page=RawatJalan&Sub=DetailKunjungan&id='.$id_kunjungan.'" class="btn btn-md btn-block btn-outline-primary btn-sm"><small>Lihat</small></a>';
                                    echo '  </td>';
                                    echo '</tr>';
                                    $no++;
                                }
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>