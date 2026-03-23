<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    $tgllapor=date('Y-m-d H:i:s');
    if(empty($_POST['tanggal'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
        echo '      Tanggal Laporan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $tanggal=$_POST['tanggal'];
        //Buka Pengaturan SIRS Online
        $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
        $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
        $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
        //Request Data
        $response=DataPcrNakes($x_id_rs,$password_sirs_online,$url_sirs_online,'GET',$tanggal);
        $php_array = json_decode($response, true);
        if(!empty($php_array['PCRNakes'])){
            $DataPcrNakes=$php_array['PCRNakes'];
            $JumlahData=count($DataPcrNakes);
        }else{
            $DataPcrNakes="";
            $JumlahData=0;
        }
        foreach ($DataPcrNakes as $array_data) {
            //Buka data json
            $tanggal = $array_data['tanggal'];
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
            $tgllapor = $array_data['tgllapor'];
?>
    <div class="row mb-3">
        <div class="col-md-12">
            <table>
                <tr>
                    <td><dt>Tanggal Data</dt></td>
                    <td width="2%" class="text-center">:</td>
                    <td><?php echo "$tanggal"; ?></td>
                </tr>
                <tr>
                    <td><dt>Tanggal Laporan</dt></td>
                    <td width="2%" class="text-center">:</td>
                    <td><?php echo "$tgllapor"; ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center"><dt>No</dt></th>
                            <th class="text-center"><dt>Kategori Nakes</dt></th>
                            <th class="text-center"><dt>Jumlah</dt></th>
                            <th class="text-center"><dt>Diperiksa</dt></th>
                            <th class="text-center"><dt>Hasil</dt></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td class="text-left">Dokter Umum</td>
                            <td class="text-center"><?php echo "$jumlah_tenaga_dokter_umum"; ?></td>
                            <td class="text-center"><?php echo "$sudah_periksa_dokter_umum"; ?></td>
                            <td class="text-center"><?php echo "$hasil_pcr_dokter_umum"; ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td class="text-left">Dokter Spesialis</td>
                            <td class="text-center"><?php echo "$jumlah_tenaga_dokter_spesialis"; ?></td>
                            <td class="text-center"><?php echo "$sudah_periksa_dokter_spesialis"; ?></td>
                            <td class="text-center"><?php echo "$hasil_pcr_dokter_spesialis"; ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td class="text-left">Dokter Gigi</td>
                            <td class="text-center"><?php echo "$jumlah_tenaga_dokter_gigi"; ?></td>
                            <td class="text-center"><?php echo "$sudah_periksa_dokter_gigi"; ?></td>
                            <td class="text-center"><?php echo "$hasil_pcr_dokter_gigi"; ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">4</td>
                            <td class="text-left">Dokter Residen</td>
                            <td class="text-center"><?php echo "$jumlah_tenaga_residen"; ?></td>
                            <td class="text-center"><?php echo "$sudah_periksa_residen"; ?></td>
                            <td class="text-center"><?php echo "$hasil_pcr_residen"; ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">5</td>
                            <td class="text-left">Perawat</td>
                            <td class="text-center"><?php echo "$jumlah_tenaga_perawat"; ?></td>
                            <td class="text-center"><?php echo "$sudah_periksa_perawat"; ?></td>
                            <td class="text-center"><?php echo "$hasil_pcr_perawat"; ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">6</td>
                            <td class="text-left">Bidan</td>
                            <td class="text-center"><?php echo "$jumlah_tenaga_bidan"; ?></td>
                            <td class="text-center"><?php echo "$sudah_periksa_bidan"; ?></td>
                            <td class="text-center"><?php echo "$hasil_pcr_bidan"; ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">7</td>
                            <td class="text-left">Apoteker</td>
                            <td class="text-center"><?php echo "$jumlah_tenaga_apoteker"; ?></td>
                            <td class="text-center"><?php echo "$sudah_periksa_apoteker"; ?></td>
                            <td class="text-center"><?php echo "$hasil_pcr_apoteker"; ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">8</td>
                            <td class="text-left">Radiografer</td>
                            <td class="text-center"><?php echo "$jumlah_tenaga_radiografer"; ?></td>
                            <td class="text-center"><?php echo "$sudah_periksa_radiografer"; ?></td>
                            <td class="text-center"><?php echo "$hasil_pcr_radiografer"; ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">9</td>
                            <td class="text-left">Analis Lab</td>
                            <td class="text-center"><?php echo "$jumlah_tenaga_analis_lab"; ?></td>
                            <td class="text-center"><?php echo "$sudah_periksa_analis_lab"; ?></td>
                            <td class="text-center"><?php echo "$hasil_pcr_analis_lab"; ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">10</td>
                            <td class="text-left">Co Ass</td>
                            <td class="text-center"><?php echo "$jumlah_tenaga_co_ass"; ?></td>
                            <td class="text-center"><?php echo "$sudah_periksa_co_ass"; ?></td>
                            <td class="text-center"><?php echo "$hasil_pcr_co_ass"; ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">11</td>
                            <td class="text-left">Interenship</td>
                            <td class="text-center"><?php echo "$jumlah_tenaga_internship"; ?></td>
                            <td class="text-center"><?php echo "$sudah_periksa_internship"; ?></td>
                            <td class="text-center"><?php echo "$hasil_pcr_internship"; ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">12</td>
                            <td class="text-left">Interenship</td>
                            <td class="text-center"><?php echo "$jumlah_tenaga_internship"; ?></td>
                            <td class="text-center"><?php echo "$sudah_periksa_internship"; ?></td>
                            <td class="text-center"><?php echo "$hasil_pcr_internship"; ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">13</td>
                            <td class="text-left">Tenaga Lainnya</td>
                            <td class="text-center"><?php echo "$jumlah_tenaga_nakes_lainnya"; ?></td>
                            <td class="text-center"><?php echo "$sudah_periksa_nakes_lainnya"; ?></td>
                            <td class="text-center"><?php echo "$hasil_pcr_nakes_lainnya"; ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">14</td>
                            <td class="text-left">Rekapitulasi</td>
                            <td class="text-center"><?php echo "$rekap_jumlah_tenaga"; ?></td>
                            <td class="text-center"><?php echo "$rekap_jumlah_sudah_diperiksa"; ?></td>
                            <td class="text-center"><?php echo "$rekap_jumlah_hasil_pcr"; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php }} ?>