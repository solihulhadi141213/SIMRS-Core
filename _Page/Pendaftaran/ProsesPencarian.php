<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_operasi
    if(empty($_POST['search_by'])){
        $search_by="";
        echo '<span class="text-danger">Silahkan masukan data anda untuk memulai pencarian data.</span>';
    }else{
        if(empty($_POST['keyword'])){
            $keyword="";
            echo '<span class="text-danger">Silahkan masukan data anda untuk memulai pencarian data.</span>';
        }else{
            $search_by=$_POST['search_by'];
            $keyword=$_POST['keyword'];
            echo '      <div class="table table-responsive">';
            echo '         <table class="table-bordered" width="100%">';
            //Hitung jumlah data antrian
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM antrian WHERE $search_by='$keyword'"));
            if(empty($jml_data)){
                echo '      <tbody>';
                echo '          <tr>';
                echo '              <td class="text-center">';
                echo '                  <span class="text-danger">Data tidak ditemukan.</span>';
                echo '              </td>';
                echo '          </tr>';
                echo '      </tbody>';
            }else{
                echo '      <thead>';
                echo '          <tr>';
                echo '              <th class="text-center"><dt>No</dt></th>';
                echo '              <th class="text-center"><dt>Kode Booking</dt></th>';
                echo '              <th class="text-center"><dt>Nama Pasien</dt></th>';
                echo '              <th class="text-center"><dt>Tanggal Kunjungan</dt></th>';
                echo '              <th class="text-center"><dt>Poliklinik</dt></th>';
                echo '              <th class="text-center"><dt>Dokter</dt></th>';
                echo '          </tr>';
                echo '      </thead>';
                //Buka data Antrian
                $no=1;
                $query = mysqli_query($Conn, "SELECT*FROM antrian WHERE $search_by='$keyword'");
                while ($Data = mysqli_fetch_array($query)) {
                    $id_antrian= $Data['id_antrian'];
                    $no_antrian= $Data['no_antrian'];
                    $id_pasien= $Data['id_pasien'];
                    $nama_pasien= $Data['nama_pasien'];
                    $kode_dokter= $Data['kode_dokter'];
                    $nama_dokter= $Data['nama_dokter'];
                    $kodepoli= $Data['kodepoli'];
                    $namapoli= $Data['namapoli'];
                    $tanggal_kunjungan= $Data['tanggal_kunjungan'];
                    $jam_kunjungan= $Data['jam_kunjungan'];
                    $kodebooking= $Data['kodebooking'];
                    echo '      <tbody>';
                    echo '          <tr>';
                    echo '              <td class="text-center">'.$no.'</td>';
                    echo '              <td class="text-left text-info"><a href="Pendaftaran.php?page=DetailPendaftaranClient&id_antrian='.$id_antrian.'" class="text-info">'.$kodebooking.'</a></td>';
                    echo '              <td class="text-left">'.$nama_pasien.'</td>';
                    echo '              <td class="text-left">'.$tanggal_kunjungan.' '.$jam_kunjungan.'</td>';
                    echo '              <td class="text-left">'.$namapoli.'</td>';
                    echo '              <td class="text-left">'.$nama_dokter.'</td>';
                    echo '          </tr>';
                    echo '      </tbody>';
                    $no++;
                }
            }
            echo '</table>';
        }
    }
?>