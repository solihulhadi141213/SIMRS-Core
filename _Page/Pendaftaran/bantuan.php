<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM bantuan WHERE tipe='For Client'"));
    if(empty($jml_data)){
        echo '<div class="col-lg-6">';
        echo '  <div class="card">';
        echo '      <div class="card-body text-danger">';
        echo '          Belum ada data bantuan yang bisa di tampilkan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        echo '<div class="card">';
        echo '  <div class="card-body">';
        echo '      <div class="row">';
        echo '          <div class="col-12">';
        echo '              <table class="table table-responsive">';
        echo '                  <table class="table table-bordered">';
        echo '                      <thead>';
        echo '                          <tr>';
        echo '                              <th class="text-center"><dt>No</dt></th>';
        echo '                              <th class="text-center"><dt>Judul/Tema Bantuan</dt></th>';
        echo '                          </tr>';
        echo '                      </thead>';
        $no=1;
        $query = mysqli_query($Conn, "SELECT*FROM bantuan WHERE tipe='For Client'");
        while ($Data = mysqli_fetch_array($query)) {
            $id_bantuan= $Data['id_bantuan'];
            $tanggal= $Data['tanggal'];
            $judul= $Data['judul'];
            $kategori= $Data['kategori'];
            echo '                      <tbody>';
            echo '                          <tr>';
            echo '                              <td class="text-center">'.$no.'</td>';
            echo '                              <td class="text-left"><a href="Pendaftaran.php?page=detail_bantuan&id_bantuan='.$id_bantuan.'" class="text-primary">'.$judul.'</a><br><small>Kategori: '.$kategori.'</small></td>';
            echo '                          </tr>';
            echo '                      </tbody>';
            $no++;
        }
        echo '                  </table>';
        echo '              </div>';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }
?>