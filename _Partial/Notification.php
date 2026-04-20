<?php
    $JumlahPengajuanAksesbaru = mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses_pengajuan FROM akses_pengajuan WHERE status='Pending'"));
    $JumlahLaporanKesalahan   = mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses_laporan FROM akses_laporan WHERE status='Terkirim'"));
      //Kalkulasi Jumlah Notifikasi
    $JumlahNotifikasi = $JumlahPengajuanAksesbaru + $JumlahLaporanKesalahan;
?>
<li class="header-notification">
    <a href="javascript:void(0);" class="waves-effect waves-light">
        <i class="ti-bell"></i>
        <?php
            if(!empty($JumlahNotifikasi)){
                echo '<span class="badge bg-c-red"></span>';
            }
        ?>
    </a>
    <ul class="show-notification">
        <li>
            <h6 class="text-dark">
                <dt><?php echo "$JumlahNotifikasi";?> Pemberitahuan</dt>
            </h6>
            <?php
                if(!empty($JumlahNotifikasi)){
                    //Apabila ada pemberitahuan
                    echo '<label class="label label-danger">Baru</label>';
                }else{
                    //Apabila ada pemberitahuan
                    echo '<label class="label label-dark">No</label>';
                }
            ?>
        </li>
        <?php
            if(!empty($JumlahNotifikasi)){
                if(!empty($JumlahPengajuanAksesbaru)){
                    //Notifikasi Jumlah Pengajuan Akses (Pending)newmessege.jpg
                    echo '<a href="index.php?Page=AksesPengajuan">';
                    echo '  <li class="waves-effect waves-light">';
                    echo '      <div class="media">';
                    echo '          <div class="media-body">';
                    echo '              <h5 class="notification-user text-dark"><dt>Pengajuan Akses</dt></h5>';
                    echo '              <small class="text-dark">Ada '.$JumlahPengajuanAksesbaru.' Pengajuan Akses</small>';
                    echo '          </div>';
                    echo '      </div>';
                    echo '  </li>';
                    echo '</a>';
                }
                if(!empty($JumlahLaporanKesalahan)){
                    echo '
                        <a href="index.php?Page=LaporanKesalahan">
                            <li class="waves-effect waves-light">
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="notification-user text-dark"><dt>Laporan Kesalahan</dt></h5>
                                        <small class="text-dark">Ada '.$JumlahLaporanKesalahan.' Laporan Kesalahan Dari user</small>
                                    </div>
                                </div>
                            </li>
                        </a>
                    ';
                }
            }else{
                echo '
                    <li class="waves-effect waves-light">
                        <div class="media">
                            <div class="media-body">
                                <h5 class="notification-user text-dark"><dt>Tidak Ada Pemberitahuan</dt></h5>
                                <small class="text-dark">Sepertinya sudah tidak ada yang harus dikerjakan</small>
                            </div>
                        </div>
                    </li>
                ';
            }
            //Apabila ada pemberitahuan yang belum di tampilkan
            echo '<li class="text-center">';
            // echo '  <a href="index.php?Page=Notifikasi">Lihat Semua</a>';
            echo '</li>';
            echo "";
        ?>
    </ul>
</li>