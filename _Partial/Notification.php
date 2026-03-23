<?php
    // //Koneksi Web Dan Fungsi
    include "_Config/SettingKoneksiWeb.php";
    include "_Config/WebNotificationFunction.php";
    // //Hitung Jumlah masing-masing Notifikasi
    // //--Notifikasi Hubungi Admin Pending
    $JumlahHubungiAdminPending=0;
    
    // //--Notifikasi Pendaftaran Kunjungan pasien web
    $listKunjunganMenunggu="";
    $JumlahKunjunganMenunggu=0;
    // //--Notifikasi Testimoni Pending
    $JumlahTestimoniPending=0;
    
    // //--Notifikasi Pasien Belum RM
    $JumlahPasienBelumRm=0;
    
    // //--Notifikasi Dokter None Di SIMRS
    $JumlahDokterNoneNotifikasi=0;
    
    // //--Notifikasi Sitemap None
    $JumlahSitemapNone=0;
    
    // //--Notifikasi Metatag None
    $JumlahMetaTagNone=0;
    // //--Notifikasi Ruang Rawat Expired
    $JumlahRuangRawatExpired=0;

    // //--Notifikasi Pengajuan Akses Baru
    $JumlahPengajuanAksesbaru = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_pengajuan WHERE status='Pending'"));
    //Kalkulasi Jumlah Notifikasi
    $JumlahNotifikasi=$JumlahPengajuanAksesbaru+$JumlahHubungiAdminPending+$JumlahKunjunganMenunggu+$JumlahTestimoniPending+$JumlahPasienBelumRm+$JumlahDokterNoneNotifikasi+$JumlahSitemapNone+$JumlahMetaTagNone+$JumlahRuangRawatExpired;
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
                    echo '<a href="index.php?Page=Akses&Sub=PengajuanAkses">';
                    echo '  <li class="waves-effect waves-light">';
                    echo '      <div class="media">';
                    echo '          <img class="d-flex align-self-center img-radius" src="assets/images/newmessege.jpg">';
                    echo '          <div class="media-body">';
                    echo '              <h5 class="notification-user text-dark"><dt>Pengajuan Akses</dt></h5>';
                    echo '              <small class="text-dark">Ada '.$JumlahPengajuanAksesbaru.' Pengajuan Akses</small>';
                    echo '          </div>';
                    echo '      </div>';
                    echo '  </li>';
                    echo '</a>';
                }
                if(!empty($JumlahHubungiAdminPending)){
                    //Notifikasi Pesan Hubungi Admin (Pending)newmessege.jpg
                    echo '<a href="index.php?Page=WebHubungiAdmin">';
                    echo '  <li class="waves-effect waves-light">';
                    echo '      <div class="media">';
                    echo '          <img class="d-flex align-self-center img-radius" src="assets/images/newmessege.jpg">';
                    echo '          <div class="media-body">';
                    echo '              <h5 class="notification-user text-dark"><dt>Pesan Masuk Website</dt></h5>';
                    echo '              <small class="text-dark">Ada '.$JumlahHubungiAdminPending.' Pesan Masuk Dari Website</small>';
                    echo '          </div>';
                    echo '      </div>';
                    echo '  </li>';
                    echo '</a>';
                }
                if(!empty($JumlahKunjunganMenunggu)){
                    //Notifikasi Pendaftaran Kunjungan Online Baru
                    echo '<a href="index.php?Page=WebKunjungan">';
                    echo '  <li class="waves-effect waves-light">';
                    echo '      <div class="media">';
                    echo '          <img class="d-flex align-self-center img-radius" src="assets/images/NewRegister.png">';
                    echo '          <div class="media-body">';
                    echo '              <h5 class="notification-user text-dark"><dt>Pendaftaran Kunjungan Online</dt></h5>';
                    echo '              <small class="text-dark">Ada '.$JumlahKunjunganMenunggu.' Pendaftaran Kunjungan Online Baru</small>';
                    echo '          </div>';
                    echo '      </div>';
                    echo '  </li>';
                    echo '</a>';
                }
                if(!empty($JumlahTestimoniPending)){
                    //Notifikasi Testimoni dari pengunjung Masih Pending
                    echo '<a href="index.php?Page=WebTestimoni">';
                    echo '  <li class="waves-effect waves-light">';
                    echo '      <div class="media">';
                    echo '          <img class="d-flex align-self-center img-radius" src="assets/images/newTestimonial.png">';
                    echo '          <div class="media-body">';
                    echo '              <h5 class="notification-user text-dark"><dt>Testimoni Menunggu</dt></h5>';
                    echo '              <small class="text-dark">Ada '.$JumlahTestimoniPending.' Testimoni Menunggu Verifikasi</small>';
                    echo '          </div>';
                    echo '      </div>';
                    echo '  </li>';
                    echo '</a>';
                }
                if(!empty($JumlahPasienBelumRm)){
                    //Notifikasi Pasien Belum Memiliki RM
                    echo '<a href="index.php?Page=WebAksesPasien">';
                    echo '  <li class="waves-effect waves-light">';
                    echo '      <div class="media">';
                    echo '          <img class="d-flex align-self-center img-radius" src="assets/images/faq_man.png">';
                    echo '          <div class="media-body">';
                    echo '              <h5 class="notification-user text-dark"><dt>Pasien Menunggu</dt></h5>';
                    echo '              <small class="text-dark">Ada '.$JumlahPasienBelumRm.' Pasien Menunggu Verifikasi RM</small>';
                    echo '          </div>';
                    echo '      </div>';
                    echo '  </li>';
                    echo '</a>';
                }
                if(!empty($JumlahDokterNoneNotifikasi)){
                    //Notifikasi Jumlah Dokter Dengan Status Tidak Diketahui
                    echo '<a href="index.php?Page=WebDokter">';
                    echo '  <li class="waves-effect waves-light">';
                    echo '      <div class="media">';
                    echo '          <img class="d-flex align-self-center img-radius" src="assets/images/faq_man.png">';
                    echo '          <div class="media-body">';
                    echo '              <h5 class="notification-user text-dark"><dt>Status Dokter</dt></h5>';
                    echo '              <small class="text-dark">Ada '.$JumlahDokterNoneNotifikasi.' Status Dokter Tidak Diketahui</small>';
                    echo '          </div>';
                    echo '      </div>';
                    echo '  </li>';
                    echo '</a>';
                }
                if(!empty($JumlahSitemapNone)){
                    //Notifikasi Jumlah Sitemap Dengan Status Tidak Diketahui
                    echo '<a href="index.php?Page=WebSiteMap">';
                    echo '  <li class="waves-effect waves-light">';
                    echo '      <div class="media">';
                    echo '          <img class="d-flex align-self-center img-radius" src="assets/images/warningicon.png">';
                    echo '          <div class="media-body">';
                    echo '              <h5 class="notification-user text-dark"><dt>Status Sitemap</dt></h5>';
                    echo '              <small class="text-dark">Ada '.$JumlahSitemapNone.' Sitemap Yang Tidak Diketahui</small>';
                    echo '          </div>';
                    echo '      </div>';
                    echo '  </li>';
                    echo '</a>';
                }
                if(!empty($JumlahMetaTagNone)){
                    //Notifikasi Jumlah MetaTag Dengan Status Tidak Diketahui
                    echo '<a href="index.php?Page=WebMetaTag">';
                    echo '  <li class="waves-effect waves-light">';
                    echo '      <div class="media">';
                    echo '          <img class="d-flex align-self-center img-radius" src="assets/images/warningicon.png">';
                    echo '          <div class="media-body">';
                    echo '              <h5 class="notification-user text-dark"><dt>Title Meta Tag</dt></h5>';
                    echo '              <small class="text-dark">Ada '.$JumlahMetaTagNone.' Meta Tag Yang Tidak Terkonfirmasi</small>';
                    echo '          </div>';
                    echo '      </div>';
                    echo '  </li>';
                    echo '</a>';
                }
                if(!empty($JumlahRuangRawatExpired)){
                    //Notifikasi Jumlah MetaTag Dengan Status Tidak Diketahui
                    echo '<a href="index.php?Page=WebRuangRawat">';
                    echo '  <li class="waves-effect waves-light">';
                    echo '      <div class="media">';
                    echo '          <img class="d-flex align-self-center img-radius" src="assets/images/warningicon.png">';
                    echo '          <div class="media-body">';
                    echo '              <h5 class="notification-user text-dark"><dt>Ruang Rawat Expired</dt></h5>';
                    echo '              <small class="text-dark">Ada '.$JumlahRuangRawatExpired.' Data Ruang Rawat Belum Update</small>';
                    echo '          </div>';
                    echo '      </div>';
                    echo '  </li>';
                    echo '</a>';
                }
                    // //Contoh Notifikasi Pesan dari pengunjung
                    // echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#ModalKonfirmasiIjinAksesBerkas" data-id="">';
                    // echo '  <li class="waves-effect waves-light">';
                    // echo '      <div class="media">';
                    // echo '          <img class="d-flex align-self-center img-radius" src="assets/images/newEmail.png">';
                    // echo '          <div class="media-body">';
                    // echo '              <h5 class="notification-user text-dark"><dt>Pesan Pengunjung</dt></h5>';
                    // echo '              <small class="text-dark">Ada 12 Pesan Masuk Dari Pengunjung Web</small>';
                    // echo '              <p class="notification-time text-dark text-left">12/03/2023</p>';
                    // echo '          </div>';
                    // echo '      </div>';
                    // echo '  </li>';
                    // echo '</a>';
                    // //Contoh Notifikasi Testimoni dari pengunjung
                    // echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#ModalKonfirmasiIjinAksesBerkas" data-id="">';
                    // echo '  <li class="waves-effect waves-light">';
                    // echo '      <div class="media">';
                    // echo '          <img class="d-flex align-self-center img-radius" src="assets/images/newTestimonial.png">';
                    // echo '          <div class="media-body">';
                    // echo '              <h5 class="notification-user text-dark"><dt>Testimoni Menunggu</dt></h5>';
                    // echo '              <small class="text-dark">Ada 5 Testimoni Menunggu Publikasi</small>';
                    // echo '              <p class="notification-time text-dark text-left">12/03/2023</p>';
                    // echo '          </div>';
                    // echo '      </div>';
                    // echo '  </li>';
                    // echo '</a>';
                    // //Contoh Notifikasi Lamaran Kerja Baru
                    // echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#ModalKonfirmasiIjinAksesBerkas" data-id="">';
                    // echo '  <li class="waves-effect waves-light">';
                    // echo '      <div class="media">';
                    // echo '          <img class="d-flex align-self-center img-radius" src="assets/images/newJobAplication.png">';
                    // echo '          <div class="media-body">';
                    // echo '              <h5 class="notification-user text-dark"><dt>Pelamar Kerja</dt></h5>';
                    // echo '              <small class="text-dark">Ada 9 Pelamar Kerja</small>';
                    // echo '              <p class="notification-time text-dark text-left">12/03/2023</p>';
                    // echo '          </div>';
                    // echo '      </div>';
                    // echo '  </li>';
                    // echo '</a>';
                    // //Contoh Notifikasi Transaksi Belum Di Jurnal
                    // echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#ModalKonfirmasiIjinAksesBerkas" data-id="">';
                    // echo '  <li class="waves-effect waves-light">';
                    // echo '      <div class="media">';
                    // echo '          <img class="d-flex align-self-center img-radius" src="assets/images/warningicon.png">';
                    // echo '          <div class="media-body">';
                    // echo '              <h5 class="notification-user text-dark"><dt>Jurnal Transaksi</dt></h5>';
                    // echo '              <small class="text-dark">Ada 103 Transaksi Belum Di Jurnal</small>';
                    // echo '              <p class="notification-time text-dark text-left">12/03/2023</p>';
                    // echo '          </div>';
                    // echo '      </div>';
                    // echo '  </li>';
                    // echo '</a>';
            }else{
                echo '  <li class="waves-effect waves-light">';
                echo '      <div class="media">';
                echo '          <img class="d-flex align-self-center img-radius" src="assets/images/CheckNotification.png">';
                echo '          <div class="media-body">';
                echo '              <h5 class="notification-user text-dark"><dt>Tidak Ada Pemberitahuan</dt></h5>';
                echo '              <small class="text-dark">Sepertinya sudah tidak ada yang harus dikerjakan</small>';
                echo '          </div>';
                echo '      </div>';
                echo '  </li>';
            }
            //Apabila ada pemberitahuan yang belum di tampilkan
            echo '<li class="text-center">';
            // echo '  <a href="index.php?Page=Notifikasi">Lihat Semua</a>';
            echo '</li>';
            echo "";
        ?>
    </ul>
</li>