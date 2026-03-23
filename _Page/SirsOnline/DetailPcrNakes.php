<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    $tgllapor=date('Y-m-d H:i:s');
    if(empty($_POST['id_pcr_nakes'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
        echo '      ID Laporan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_pcr_nakes=$_POST['id_pcr_nakes'];
        $tanggal=getDataDetail($Conn,'pcr_nakes','id_pcr_nakes',$id_pcr_nakes,'tanggal');
        $tanggal_laporan=getDataDetail($Conn,'pcr_nakes','id_pcr_nakes',$id_pcr_nakes,'tanggal_laporan');
        $jumlah=getDataDetail($Conn,'pcr_nakes','id_pcr_nakes',$id_pcr_nakes,'jumlah');
        $raw_json=getDataDetail($Conn,'pcr_nakes','id_pcr_nakes',$id_pcr_nakes,'raw_json');
        $status=getDataDetail($Conn,'pcr_nakes','id_pcr_nakes',$id_pcr_nakes,'status');
        $id_akses=getDataDetail($Conn,'pcr_nakes','id_pcr_nakes',$id_pcr_nakes,'id_akses');
        //Detail Petugas
        $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
        //Buka data json
        $array_data = json_decode($raw_json, true);
        $jumlah_tenaga_dokter_umum = $array_data['jumlah_tenaga_dokter_umum'];
        $sudah_periksa_dokter_umum = $array_data['sudah_periksa_dokter_umum'];
        $hasil_pcr_dokter_umum = $array_data['hasil_pcr_dokter_umum'];
        $jumlah_tenaga_dokter_spesialis = $array_data['jumlah_tenaga_dokter_spesialis'];
        $sudah_periksa_dokter_spesialis = $array_data['sudah_periksa_dokter_spesialis'];
        $hasil_pcr_dokter_spesialis = $array_data['hasil_pcr_dokter_spesialis'];
        $jumlah_tenaga_dokter_gigi = $array_data['jumlah_tenaga_dokter_gigi'];
        $sudah_periksa_dokter_gigi = $array_data['sudah_periksa_dokter_gigi'];
        $hasil_pcr_dokter_gigi = $array_data['hasil_pcr_dokter_gigi'];
        $jumlah_tenaga_residen = $array_data['jumlah_tenaga_residen'];
        $sudah_periksa_residen = $array_data['sudah_periksa_residen'];
        $hasil_pcr_residen = $array_data['hasil_pcr_residen'];
        $jumlah_tenaga_perawat = $array_data['jumlah_tenaga_perawat'];
        $sudah_periksa_perawat = $array_data['sudah_periksa_perawat'];
        $hasil_pcr_perawat = $array_data['hasil_pcr_perawat'];
        $jumlah_tenaga_bidan = $array_data['jumlah_tenaga_bidan'];
        $sudah_periksa_bidan = $array_data['sudah_periksa_bidan'];
        $hasil_pcr_bidan = $array_data['hasil_pcr_bidan'];
        $jumlah_tenaga_apoteker = $array_data['jumlah_tenaga_apoteker'];
        $sudah_periksa_apoteker = $array_data['sudah_periksa_apoteker'];
        $hasil_pcr_apoteker = $array_data['hasil_pcr_apoteker'];
        $jumlah_tenaga_radiografer = $array_data['jumlah_tenaga_radiografer'];
        $sudah_periksa_radiografer = $array_data['sudah_periksa_radiografer'];
        $hasil_pcr_radiografer = $array_data['hasil_pcr_radiografer'];
        $jumlah_tenaga_analis_lab = $array_data['jumlah_tenaga_analis_lab'];
        $sudah_periksa_analis_lab = $array_data['sudah_periksa_analis_lab'];
        $hasil_pcr_analis_lab = $array_data['hasil_pcr_analis_lab'];
        $jumlah_tenaga_co_ass = $array_data['jumlah_tenaga_co_ass'];
        $sudah_periksa_co_ass = $array_data['sudah_periksa_co_ass'];
        $hasil_pcr_co_ass = $array_data['hasil_pcr_co_ass'];
        $jumlah_tenaga_internship = $array_data['jumlah_tenaga_internship'];
        $sudah_periksa_internship = $array_data['sudah_periksa_internship'];
        $hasil_pcr_internship = $array_data['hasil_pcr_internship'];
        $jumlah_tenaga_nakes_lainnya = $array_data['jumlah_tenaga_nakes_lainnya'];
        $sudah_periksa_nakes_lainnya = $array_data['sudah_periksa_nakes_lainnya'];
        $hasil_pcr_nakes_lainnya = $array_data['hasil_pcr_nakes_lainnya'];
        $rekap_jumlah_tenaga = $array_data['rekap_jumlah_tenaga'];
        $rekap_jumlah_sudah_diperiksa = $array_data['rekap_jumlah_sudah_diperiksa'];
        $rekap_jumlah_hasil_pcr = $array_data['rekap_jumlah_hasil_pcr'];
?>
    <div class="row mb-3">
        <div class="col-md-6">ID Laporan</div>
        <div class="col-md-6"><?php echo "$id_pcr_nakes"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">Tanggal Data</div>
        <div class="col-md-6"><?php echo "$tanggal"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">Tanggal Laporan</div>
        <div class="col-md-6"><?php echo "$tanggal_laporan"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">1. Dokter Umum</div>
        <div class="col-md-6">
            <ul>
                <li>Jumlah : <?php echo "$jumlah_tenaga_dokter_umum"; ?></li>
                <li>Diperiksa : <?php echo "$sudah_periksa_dokter_umum"; ?></li>
                <li>Hasil : <?php echo "$hasil_pcr_dokter_umum"; ?></li>
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">2. Dokter Spesialis</div>
        <div class="col-md-6">
        <ul>
                <li>Jumlah : <?php echo "$jumlah_tenaga_dokter_spesialis"; ?></li>
                <li>Diperiksa : <?php echo "$sudah_periksa_dokter_spesialis"; ?></li>
                <li>Hasil : <?php echo "$hasil_pcr_dokter_spesialis"; ?></li>
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">3. Dokter Gigi</div>
        <div class="col-md-6">
            <ul>
                <li>Jumlah : <?php echo "$jumlah_tenaga_dokter_gigi"; ?></li>
                <li>Diperiksa : <?php echo "$sudah_periksa_dokter_gigi"; ?></li>
                <li>Hasil : <?php echo "$hasil_pcr_dokter_gigi"; ?></li>
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">4. Tenaga Residen</div>
        <div class="col-md-6">
            <ul>
                <li>Jumlah : <?php echo "$jumlah_tenaga_residen"; ?></li>
                <li>Diperiksa : <?php echo "$sudah_periksa_residen"; ?></li>
                <li>Hasil : <?php echo "$hasil_pcr_residen"; ?></li>
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">5. Perawat</div>
        <div class="col-md-6">
            <ul>
                <li>Jumlah : <?php echo "$jumlah_tenaga_perawat"; ?></li>
                <li>Diperiksa : <?php echo "$sudah_periksa_perawat"; ?></li>
                <li>Hasil : <?php echo "$hasil_pcr_perawat"; ?></li>
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">6. Bidan</div>
        <div class="col-md-6">
            <ul>
                <li>Jumlah : <?php echo "$jumlah_tenaga_bidan"; ?></li>
                <li>Diperiksa : <?php echo "$sudah_periksa_bidan"; ?></li>
                <li>Hasil : <?php echo "$hasil_pcr_bidan"; ?></li>
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">7. Apoteker</div>
        <div class="col-md-6">
            <ul>
                <li>Jumlah : <?php echo "$jumlah_tenaga_apoteker"; ?></li>
                <li>Diperiksa : <?php echo "$sudah_periksa_apoteker"; ?></li>
                <li>Hasil : <?php echo "$hasil_pcr_apoteker"; ?></li>
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">8. Radiografer</div>
        <div class="col-md-6">
            <ul>
                <li>Jumlah : <?php echo "$jumlah_tenaga_radiografer"; ?></li>
                <li>Diperiksa : <?php echo "$sudah_periksa_radiografer"; ?></li>
                <li>Hasil : <?php echo "$hasil_pcr_radiografer"; ?></li>
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">9. Analis Lab</div>
        <div class="col-md-6">
            <ul>
                <li>Jumlah : <?php echo "$jumlah_tenaga_analis_lab"; ?></li>
                <li>Diperiksa : <?php echo "$sudah_periksa_analis_lab"; ?></li>
                <li>Hasil : <?php echo "$hasil_pcr_analis_lab"; ?></li>
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">10. Co Ass</div>
        <div class="col-md-6">
            <ul>
                <li>Jumlah : <?php echo "$jumlah_tenaga_co_ass"; ?></li>
                <li>Diperiksa : <?php echo "$sudah_periksa_co_ass"; ?></li>
                <li>Hasil : <?php echo "$hasil_pcr_co_ass"; ?></li>
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">11. Interenship</div>
        <div class="col-md-6">
            <ul>
                <li>Jumlah : <?php echo "$jumlah_tenaga_internship"; ?></li>
                <li>Diperiksa : <?php echo "$sudah_periksa_internship"; ?></li>
                <li>Hasil : <?php echo "$hasil_pcr_internship"; ?></li>
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">12. Tenaga Lainnya</div>
        <div class="col-md-6">
            <ul>
                <li>Jumlah : <?php echo "$jumlah_tenaga_nakes_lainnya"; ?></li>
                <li>Diperiksa : <?php echo "$sudah_periksa_nakes_lainnya"; ?></li>
                <li>Hasil : <?php echo "$hasil_pcr_nakes_lainnya"; ?></li>
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">13. Rekapitulasi</div>
        <div class="col-md-6">
            <ul>
                <li>Jumlah : <?php echo "$rekap_jumlah_tenaga"; ?></li>
                <li>Diperiksa : <?php echo "$rekap_jumlah_sudah_diperiksa"; ?></li>
                <li>Hasil : <?php echo "$rekap_jumlah_hasil_pcr"; ?></li>
            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">Petugas</div>
        <div class="col-md-6"><?php echo "$NamaPetugas"; ?></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">Status</div>
        <div class="col-md-6"><?php echo "$status"; ?></div>
    </div>
<?php } ?>