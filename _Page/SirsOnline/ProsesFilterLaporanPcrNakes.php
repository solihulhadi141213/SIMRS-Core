<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['TanggalLaporanPcrNakes'])){
        echo '<span class="text-danger">Tanggal Laporan Tidak Boleh Kosong!</span>';
    }else{
        $tanggal=$_POST['TanggalLaporanPcrNakes'];
        //Dokter Umum
        $sudah_periksa_dokter_umum=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Dokter Umum'"));
        $hasil_pcr_dokter_umum=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Dokter Umum' AND hasil_pcr!='Menunggu'"));
        $jumlah_tenaga_dokter_umum=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Dokter Umum'"));
        //Dokter Spesialis
        $sudah_periksa_dokter_spesialis=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Dokter Spesialis'"));
        $hasil_pcr_dokter_spesialis=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Dokter Spesialis' AND hasil_pcr!='Menunggu'"));
        $jumlah_tenaga_dokter_spesialis=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Dokter Spesialis'"));
        //Dokter Gigi
        $sudah_periksa_dokter_gigi=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Dokter Gigi'"));
        $hasil_pcr_dokter_gigi=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Dokter Gigi' AND hasil_pcr!='Menunggu'"));
        $jumlah_tenaga_dokter_gigi=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Dokter Gigi'"));
        //Residen
        $sudah_periksa_residen=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Residen'"));
        $hasil_pcr_residen=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Residen' AND hasil_pcr!='Menunggu'"));
        $jumlah_tenaga_residen=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Residen'"));
        //Perawat
        $sudah_periksa_perawat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Perawat'"));
        $hasil_pcr_perawat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Perawat' AND hasil_pcr!='Menunggu'"));
        $jumlah_tenaga_perawat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Perawat'"));
        //Bidan
        $sudah_periksa_bidan=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Bidan'"));
        $hasil_pcr_bidan=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Bidan' AND hasil_pcr!='Menunggu'"));
        $jumlah_tenaga_bidan=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Bidan'"));
        //Apoteker
        $sudah_periksa_apoteker=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Apoteker'"));
        $hasil_pcr_apoteker=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Apoteker' AND hasil_pcr!='Menunggu'"));
        $jumlah_tenaga_apoteker=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Apoteker'"));
        //Radiografer
        $sudah_periksa_radiografer=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Radiografer'"));
        $hasil_pcr_radiografer=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Radiografer' AND hasil_pcr!='Menunggu'"));
        $jumlah_tenaga_radiografer=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Radiografer'"));
        //Analis Lab
        $sudah_periksa_analis_lab=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Analis Lab'"));
        $hasil_pcr_analis_lab=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Analis Lab' AND hasil_pcr!='Menunggu'"));
        $jumlah_tenaga_analis_lab=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Analis Lab'"));
        //Co Ass
        $sudah_periksa_co_ass=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Co Ass'"));
        $hasil_pcr_co_ass=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Co Ass' AND hasil_pcr!='Menunggu'"));
        $jumlah_tenaga_co_ass=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Co Ass'"));
        //Residen
        $sudah_periksa_residen=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Residen'"));
        $hasil_pcr_residen=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Residen' AND hasil_pcr!='Menunggu'"));
        $jumlah_tenaga_residen=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Residen'"));
        //Interenship
        $sudah_periksa_internship=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Intership'"));
        $hasil_pcr_internship=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Intership' AND hasil_pcr!='Menunggu'"));
        $jumlah_tenaga_internship=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Intership'"));
        //Nakes Lainnya
        $sudah_periksa_nakes_lainnya=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Nakes Lainnya'"));
        $hasil_pcr_nakes_lainnya=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Nakes Lainnya' AND hasil_pcr!='Menunggu'"));
        $jumlah_tenaga_nakes_lainnya=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND kategori_nakes='Nakes Lainnya'"));
        //Rekapitulasi
        $rekap_jumlah_tenaga=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal'"));
        $rekap_jumlah_sudah_diperiksa=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal'"));
        $rekap_jumlah_hasil_pcr=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes_pcr WHERE tanggal='$tanggal' AND hasil_pcr!='Menunggu'"));
?>
    <div class="row">
        <div class="col-md-12">
            <div class="table table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center"><dt>No</dt></th>
                            <th class="text-center"><dt>Kategori Data</dt></th>
                            <th class="text-center"><dt>Diperiksa</dt></th>
                            <th class="text-center"><dt>Hasil</dt></th>
                            <th class="text-center"><dt>Jumlah</dt></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td>Dokter Umum</td>
                            <td>
                                <input type="text" name="sudah_periksa_dokter_umum" class="form-control form-control-sm" value="<?php echo "$sudah_periksa_dokter_umum"; ?>">
                            </td>
                            <td>
                                <input type="text" name="hasil_pcr_dokter_umum" class="form-control form-control-sm" value="<?php echo "$hasil_pcr_dokter_umum"; ?>">
                            </td>
                            <td>
                                <input type="text" name="jumlah_tenaga_dokter_umum" class="form-control form-control-sm" value="<?php echo "$jumlah_tenaga_dokter_umum"; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td>Dokter Spesialis</td>
                            <td>
                                <input type="text" name="sudah_periksa_dokter_spesialis" class="form-control form-control-sm" value="<?php echo "$sudah_periksa_dokter_spesialis"; ?>">
                            </td>
                            <td>
                                <input type="text" name="hasil_pcr_dokter_spesialis" class="form-control form-control-sm" value="<?php echo "$hasil_pcr_dokter_spesialis"; ?>">
                            </td>
                            <td>
                                <input type="text" name="jumlah_tenaga_dokter_spesialis" class="form-control form-control-sm" value="<?php echo "$jumlah_tenaga_dokter_spesialis"; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td>Dokter Gigi</td>
                            <td>
                                <input type="text" name="sudah_periksa_dokter_gigi" class="form-control form-control-sm" value="<?php echo "$sudah_periksa_dokter_gigi"; ?>">
                            </td>
                            <td>
                                <input type="text" name="hasil_pcr_dokter_gigi" class="form-control form-control-sm" value="<?php echo "$hasil_pcr_dokter_gigi"; ?>">
                            </td>
                            <td>
                                <input type="text" name="jumlah_tenaga_dokter_gigi" class="form-control form-control-sm" value="<?php echo "$jumlah_tenaga_dokter_gigi"; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">4</td>
                            <td>Residen</td>
                            <td>
                                <input type="text" name="sudah_periksa_residen" class="form-control form-control-sm" value="<?php echo "$sudah_periksa_residen"; ?>">
                            </td>
                            <td>
                                <input type="text" name="hasil_pcr_residen" class="form-control form-control-sm" value="<?php echo "$hasil_pcr_residen"; ?>">
                            </td>
                            <td>
                                <input type="text" name="jumlah_tenaga_residen" class="form-control form-control-sm" value="<?php echo "$jumlah_tenaga_residen"; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">5</td>
                            <td>Perawat</td>
                            <td>
                                <input type="text" name="sudah_periksa_perawat" class="form-control form-control-sm" value="<?php echo "$sudah_periksa_perawat"; ?>">
                            </td>
                            <td>
                                <input type="text" name="hasil_pcr_perawat" class="form-control form-control-sm" value="<?php echo "$hasil_pcr_perawat"; ?>">
                            </td>
                            <td>
                                <input type="text" name="jumlah_tenaga_perawat" class="form-control form-control-sm" value="<?php echo "$jumlah_tenaga_perawat"; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">6</td>
                            <td>Bidan</td>
                            <td>
                                <input type="text" name="sudah_periksa_bidan" class="form-control form-control-sm" value="<?php echo "$sudah_periksa_bidan"; ?>">
                            </td>
                            <td>
                                <input type="text" name="hasil_pcr_bidan" class="form-control form-control-sm" value="<?php echo "$hasil_pcr_bidan"; ?>">
                            </td>
                            <td>
                                <input type="text" name="jumlah_tenaga_bidan" class="form-control form-control-sm" value="<?php echo "$jumlah_tenaga_bidan"; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">7</td>
                            <td>Apoteker</td>
                            <td>
                                <input type="text" name="sudah_periksa_apoteker" class="form-control form-control-sm" value="<?php echo "$sudah_periksa_apoteker"; ?>">
                            </td>
                            <td>
                                <input type="text" name="hasil_pcr_apoteker" class="form-control form-control-sm" value="<?php echo "$hasil_pcr_apoteker"; ?>">
                            </td>
                            <td>
                                <input type="text" name="jumlah_tenaga_apoteker" class="form-control form-control-sm" value="<?php echo "$jumlah_tenaga_apoteker"; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">8</td>
                            <td>Radiografer</td>
                            <td>
                                <input type="text" name="sudah_periksa_radiografer" class="form-control form-control-sm" value="<?php echo "$sudah_periksa_radiografer"; ?>">
                            </td>
                            <td>
                                <input type="text" name="hasil_pcr_radiografer" class="form-control form-control-sm" value="<?php echo "$hasil_pcr_radiografer"; ?>">
                            </td>
                            <td>
                                <input type="text" name="jumlah_tenaga_radiografer" class="form-control form-control-sm" value="<?php echo "$jumlah_tenaga_radiografer"; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">9</td>
                            <td>Analis Lab</td>
                            <td>
                                <input type="text" name="sudah_periksa_analis_lab" class="form-control form-control-sm" value="<?php echo "$sudah_periksa_analis_lab"; ?>">
                            </td>
                            <td>
                                <input type="text" name="hasil_pcr_analis_lab" class="form-control form-control-sm" value="<?php echo "$hasil_pcr_analis_lab"; ?>">
                            </td>
                            <td>
                                <input type="text" name="jumlah_tenaga_analis_lab" class="form-control form-control-sm" value="<?php echo "$jumlah_tenaga_analis_lab"; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">10</td>
                            <td>Co Ass</td>
                            <td>
                                <input type="text" name="sudah_periksa_co_ass" class="form-control form-control-sm" value="<?php echo "$sudah_periksa_co_ass"; ?>">
                            </td>
                            <td>
                                <input type="text" name="hasil_pcr_co_ass" class="form-control form-control-sm" value="<?php echo "$hasil_pcr_co_ass"; ?>">
                            </td>
                            <td>
                                <input type="text" name="jumlah_tenaga_co_ass" class="form-control form-control-sm" value="<?php echo "$jumlah_tenaga_co_ass"; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">11</td>
                            <td>Residen</td>
                            <td>
                                <input type="text" name="sudah_periksa_residen" class="form-control form-control-sm" value="<?php echo "$sudah_periksa_residen"; ?>">
                            </td>
                            <td>
                                <input type="text" name="hasil_pcr_residen" class="form-control form-control-sm" value="<?php echo "$hasil_pcr_residen"; ?>">
                            </td>
                            <td>
                                <input type="text" name="jumlah_tenaga_residen" class="form-control form-control-sm" value="<?php echo "$jumlah_tenaga_residen"; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">12</td>
                            <td>Internship</td>
                            <td>
                                <input type="text" name="sudah_periksa_interenship" class="form-control form-control-sm" value="<?php echo "$sudah_periksa_internship"; ?>">
                            </td>
                            <td>
                                <input type="text" name="hasil_pcr_internship" class="form-control form-control-sm" value="<?php echo "$hasil_pcr_internship"; ?>">
                            </td>
                            <td>
                                <input type="text" name="jumlah_tenaga_internship" class="form-control form-control-sm" value="<?php echo "$jumlah_tenaga_internship"; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">13</td>
                            <td>Nakes Lainnya</td>
                            <td>
                                <input type="text" name="sudah_periksa_nakes_lainnya" class="form-control form-control-sm" value="<?php echo "$sudah_periksa_nakes_lainnya"; ?>">
                            </td>
                            <td>
                                <input type="text" name="hasil_pcr_nakes_lainnya" class="form-control form-control-sm" value="<?php echo "$hasil_pcr_nakes_lainnya"; ?>">
                            </td>
                            <td>
                                <input type="text" name="jumlah_tenaga_nakes_lainnya" class="form-control form-control-sm" value="<?php echo "$jumlah_tenaga_nakes_lainnya"; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">14</td>
                            <td>Rekapitulasi</td>
                            <td>
                                <input type="text" name="rekap_jumlah_sudah_diperiksa" class="form-control form-control-sm" value="<?php echo "$rekap_jumlah_sudah_diperiksa"; ?>">
                            </td>
                            <td>
                                <input type="text" name="rekap_jumlah_hasil_pcr" class="form-control form-control-sm" value="<?php echo "$rekap_jumlah_hasil_pcr"; ?>">
                            </td>
                            <td>
                                <input type="text" name="rekap_jumlah_tenaga" class="form-control form-control-sm" value="<?php echo "$rekap_jumlah_tenaga"; ?>">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="NotifikasiKirimLaporanPcrNakes">
            Pastikan Data Laporan Hasil PCR Nakes Yang Anda Kirim Sudah Benar
        </div>
    </div>
<?php } ?>