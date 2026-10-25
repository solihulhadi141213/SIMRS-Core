<?php
    $JumlahPengajuanAksesbaru = mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses_pengajuan FROM akses_pengajuan WHERE status='Pending'"));
    $JumlahLaporanKesalahan   = mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses_laporan FROM akses_laporan WHERE status='Terkirim'"));
    
    //Kalkulasi Jumlah Notifikasi
    $JumlahNotifikasi = $JumlahPengajuanAksesbaru + $JumlahLaporanKesalahan;
?>
<li class="header-notification">
    <a href="javascript:void(0);" class="waves-effect waves-light" aria-label="Notifikasi">
        <i class="bi bi-bell" aria-hidden="true"></i>
        <?php
            if(!empty($JumlahNotifikasi)){
                echo '<span class="badge bg-danger" aria-hidden="true"></span>';
            }
        ?>
    </a>
    <ul class="show-notification">
        <li>
            <span class="text-dark fw-semibold"><?php echo "$JumlahNotifikasi";?> Pemberitahuan</span>
            <?php
                if(!empty($JumlahNotifikasi)){
                    //Apabila ada pemberitahuan
                    echo '<span class="badge text-bg-danger float-end">Baru</span>';
                }else{
                    //Apabila ada pemberitahuan
                    echo '<span class="badge text-bg-secondary float-end">Tidak ada</span>';
                }
            ?>
        </li>
        <?php
            if(!empty($JumlahNotifikasi)){
                if(!empty($JumlahPengajuanAksesbaru)){
                    //Notifikasi Jumlah Pengajuan Akses (Pending)newmessege.jpg
                    echo '  <li class="waves-effect waves-light">';
                    echo '      <a href="index.php?Page=AksesPengajuan">';
                    echo '      <div class="media">';
                    echo '          <div class="media-body">';
                    echo '              <h5 class="notification-user text-dark">Pengajuan Akses</h5>';
                    echo '              <small class="text-dark">Ada '.$JumlahPengajuanAksesbaru.' Pengajuan Akses</small>';
                    echo '          </div>';
                    echo '      </div>';
                    echo '      </a>';
                    echo '  </li>';
                }
                if(!empty($JumlahLaporanKesalahan)){
                    echo '
                        <li class="waves-effect waves-light">
                            <a href="index.php?Page=LaporanKesalahan">
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="notification-user text-dark">Laporan Kesalahan</h5>
                                        <small class="text-dark">Ada '.$JumlahLaporanKesalahan.' Laporan Kesalahan Dari user</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                    ';
                }
            }else{
                echo '
                    <li class="waves-effect waves-light">
                        <div class="media">
                            <div class="media-body">
                                <h5 class="notification-user text-dark">Tidak Ada Pemberitahuan</h5>
                                <small class="text-dark">Sepertinya sudah tidak ada yang harus dikerjakan</small>
                            </div>
                        </div>
                    </li>
                ';
            }
        ?>
    </ul>
</li>