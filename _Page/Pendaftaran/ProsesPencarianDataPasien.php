<?php
    //menangkap data dari form
    if(empty($_POST['metode_pembayaran'])){
        echo '<i class="text-danger">Metode Pembayaran Tidak Boleh Kosong!</i>';
    }else{
        if(empty($_POST['kategori_pendaftaran'])){
            echo '<i class="text-danger">Kategori Pendaftaran Tidak Boleh Kosong!</i>';
        }else{
            if(empty($_POST['kategori_id'])){
                echo '<i class="text-danger">Kategori Pencarian Data Pasien Tidak Boleh Kosong!</i>';
            }else{
                if(empty($_POST['keyword'])){
                    echo '<i class="text-danger">Nomor Pencarian Data Pasien Tidak Boleh Kosong!</i>';
                }else{
                    $metode_pembayaran=$_POST['metode_pembayaran'];
                    $kategori_pendaftaran=$_POST['kategori_pendaftaran'];
                    $kategori_id=$_POST['kategori_id'];
                    $keyword=$_POST['keyword'];
                    //Koneksi ke database
                    include "../../_Config/Connection.php";
                    //Pencarian data pasien
                    $sql="SELECT * FROM pasien WHERE $kategori_id='$keyword'";
                    $query=mysqli_query($Conn,$sql);
                    $data=mysqli_fetch_assoc($query);
                    //Jika data pasien tidak ditemukan
                    if(mysqli_num_rows($query)==0){
                        echo '<i class="text-danger">Data Pasien Tidak Ditemukan!</i>';
                    }else{
                        //Data pasien
                        $id_pasien=$data['id_pasien'];
                        $tanggal_daftar=$data['tanggal_daftar'];
                        $nik=$data['nik'];
                        $no_bpjs=$data['no_bpjs'];
                        $gender=$data['gender'];
                        $nama=$data['nama'];
                        echo '<div class="table table-responsive">';
                        echo '  <table class="table">';
                        echo '      <tr>';
                        echo '          <td colspan="3" class="text-center">';
                        echo '              <dt class="text-success">Data Pasien Ditemukan</dt>';
                        echo '              <small>Silahkan pilih tombol <i>lanjutkan pendaftaran</i> untuk melanjutkan proses</small>';
                        echo '          </td>';
                        echo '      </tr>';
                        echo '      <tr>';
                        echo '          <td><dt>No.RM</dt></td>';
                        echo '          <td><dt>:</dt></td>';
                        echo '          <td>'.$id_pasien.'</td>';
                        echo '      </tr>';
                        echo '      <tr>';
                        echo '          <td><dt>Nama Pasien</dt></td>';
                        echo '          <td><dt>:</dt></td>';
                        echo '          <td>'.$nama.'</td>';
                        echo '      </tr>';
                        echo '      <tr>';
                        echo '          <td><dt>Tanggal Daftar</dt></td>';
                        echo '          <td><dt>:</dt></td>';
                        echo '          <td>'.$tanggal_daftar.'</td>';
                        echo '      </tr>';
                        echo '      <tr>';
                        echo '          <td><dt>Gender</dt></td>';
                        echo '          <td><dt>:</dt></td>';
                        echo '          <td>'.$gender.'</td>';
                        echo '      </tr>';
                        echo '  </table>';
                        echo '</div>';
                        echo '<a href="Pendaftaran.php?page=FormPendaftaranPasienLama&kategori='.$kategori_pendaftaran.'&metode_pembayaran='.$metode_pembayaran.'&id_pasien='.$id_pasien.'" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">';
                        echo '  <i class="ti ti-arrow-circle-right"></i> Lanjutkan Pendaftaran';
                        echo '</a>';
                    }
                }
            }
        }
    }
?>