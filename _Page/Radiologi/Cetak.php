<?php
	include "../../_Config/Connection.php";
	include "../../_Config/Session.php";
	include "../../_Config/Setting.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_GET['id'])){
        echo 'ID Radiologi Tidak Boleh Kosong!';
    }else{
        if(empty($_GET['CetakHeader'])){
            echo 'Keterangan Cetak Header Tidak Boleh Kosong!';
        }else{
            if(empty($_GET['CetakLampiran'])){
                echo 'Keterangan Cetak Lampiran Tidak Boleh Kosong!';
            }else{
                if(empty($SessionIdAkses)){
                    echo 'Anda Tidak Memiliki Hak Untuk Melihat Dokumen Ini!';
                }else{
                    $id_rad=$_GET['id'];
                    $CetakHeader=$_GET['CetakHeader'];
                    $CetakLampiran=$_GET['CetakLampiran'];
                    if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'id_rad'))){
                        echo 'ID Radiologi Tidak Valid Atau Tidak Terdaftar Pada Database!';
                    }else{
?>
    <html>
        <head>
            <title>Pemeriksaan Radiologi</title>
            <link rel="icon" href="../../assets/images/<?php echo "$favicon"; ?>" type="image/x-icon">
            <style type="text/css">
                @page {
                    margin-top: 1cm;
                    margin-bottom: 1cm;
                    margin-left: 1cm;
                    margin-right: 1cm;
                }
                body {
                    background-color: #FFF;
                    font-family: Arial;
                }
                table.data tr td {
                    border: none;
                    color: #000;
                    border-spacing: 0px;
                    padding: 1px;
                    border-spacing: 0px;
                }
                table.kop_surat tr td {
                    border: none;
                    color: #000;
                }
                table.kop_surat3 tr td {
                    border: none;
                    color: #000;
                }
                .logo {
                    width: 50px;
                    height: 50px;
                    
                }
                div.kop{
                    border-bottom: 2px groove #000;
                    color: #000;
                }
                div.kop2{
                    border-bottom: 2px groove #000;
                    color: #000;
                }
                div.kop3{
                    border-bottom: 2px groove #000;
                    color: #000;
                }
                .f8{
                    font-size: 8px;
                }
                .f9{
                    font-size: 9px;
                }
                .f10{
                    font-size: 10px;
                }
                .f11{
                    font-size: 11px;
                }
                .f12{
                    font-size: 12px;
                }
                .f13{
                    font-size: 13px;
                }
                .f14{
                    font-size: 14px;
                }
                .f15{
                    font-size: 15px;
                }
                .f16{
                    font-size: 16px;
                }
            </style>
        </head>
        <body>
            <?php
                //Apakah Data Radiologi Ada?
                $id_pasien=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'id_pasien');
                $id_kunjungan=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'id_kunjungan');
                $NamaPasien=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'nama');
                $WaktuRadiologi=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'waktu');
                if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'asal_kiriman'))){
                    $AsalKiriman='Tidak Diketahui';
                }else{
                    $AsalKiriman=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'asal_kiriman');
                }
                
                $PermintaanPemeriksaan=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'permintaan_pemeriksaan');
                $AlatPemeriksa=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'alat_pemeriksa');
                $StatusPemeriksa=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'status_pemeriksaan');
                $JenisPembayaran=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'jenis_pembayaran');
                if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_pengirim'))){
                    $DokterPengirim='<small class="text-muted">Tidak Ada</small>';
                }else{
                    $DokterPengirim=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_pengirim');
                }
                if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_penerima'))){
                    $DokterPenerima='<small class="text-muted">Tidak Ada</small>';
                }else{
                    $DokterPenerima=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'dokter_penerima');
                }
                if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'radiografer'))){
                    $RadioGrafer='Belum Memperoleh Verifikasi';
                }else{
                    $RadioGrafer=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'radiografer');
                }
                if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kesan'))){
                    $Kesan='<small class="text-muted">Tidak Ada</small>';
                }else{
                    $Kesan=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kesan');
                }
                if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'klinis'))){
                    $KlinisPasien='<small class="text-muted">Tidak Ada</small>';
                }else{
                    $KlinisPasien=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'klinis');
                }
                if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'selesai'))){
                    $WaktuSelesai='<small class="text-muted">Belum Diatur</small>';
                }else{
                    $WaktuSelesai=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'selesai');
                }
                if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kv'))){
                    $kv='None';
                }else{
                    $kv=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'kv');
                }
                if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'ma'))){
                    $ma='None';
                }else{
                    $ma=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'ma');
                }
                if(empty(getDataDetail($Conn,'radiologi','id_rad',$id_rad,'sec'))){
                    $sec='None';
                }else{
                    $sec=getDataDetail($Conn,'radiologi','id_rad',$id_rad,'sec');
                }
                //Data Pasien
                if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'gender'))){
                    $gender='None';
                }else{
                    $gender=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'gender');
                }
                if(empty(getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'tanggal_lahir'))){
                    $tanggal_lahir='None';
                    $umur="None";
                    $sat_waktu="";
                }else{
                    $tanggal_lahir=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'tanggal_lahir');
                    //menghitung usia
                    $delimiter='-';
                    list($tahun,$bulan,$hari) = explode($delimiter, $tanggal_lahir);
                    $selisih_hari = date('d') - $hari;
                    $selisih_bulan = date('m') - $bulan;
                    $selisih_tahun = date('Y') - $tahun;
                    //Apabila Anak Di Bawah 1 Tahun
                    if ($selisih_tahun < 1) {
                    //Apabila Anak Di Bawah 1 Bulan
                        if($selisih_bulan <1){
                            $umur=$selisih_hari; 
                            $sat_waktu="Hr";
                        }else{
                            $umur=$selisih_bulan; 
                            $sat_waktu="Bl";
                        }
                    }else{
                        //Apabila Di atas 1 Tahun
                        $umur=$selisih_tahun; 
                        $sat_waktu="Th";
                    }
                }
                
            ?>  
            <?php if($CetakHeader=="Yes"){ ?>
                <div class="kop3">
                    <table class="kop_surat3" width="100%">
                        <tr>
                            <td width="80px" valign="top" align="center">
                                <img src="../../assets/images/<?php echo "$logo"; ?>" class="logo">
                            </td>
                            <td valign="top">
                                <?php 
                                    echo '<b>'.$NamaFaskes.'</b><br>'; 
                                    echo ''.$KontakFaskes.'<br>'; 
                                    echo '<b>Lembar Rincian Pemeriksaan Radiologi</b><br>'; 
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
            <div class="kop3">
                <table width="100%">
                    <tr>
                        <td align="left">
                            <b>Data Hasil Pemeriksaan <?php echo "$AlatPemeriksa"; ?></b>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="kop">
                <table width="100%" cellspacing="0px">
                    <tr>
                        <td width="50%">
                <!----------------------------------DATA KIRI------------------------------------------------------------------->        
                            <table width="100%" class="data" cellspacing="0px">
                                <tr>
                                    <td><strong>Waktu Masuk</strong></td>
                                    <td><?php echo "$WaktuRadiologi"; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Waktu Selesai</strong></td>
                                    <td><?php echo "$WaktuSelesai"; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>All ID Pasien</strong></td>
                                    <td>
                                        <?php echo "<b>RM :</b>$id_pasien/<b>ID.RAD :</b>$id_rad/" ;  ?>
                                        <b>ID.REG :</b><?php echo "$id_kunjungan"; ?>
                                    </td>
                        
                                </tr>
                                <tr>
                                    <td><strong>Nama/Gender/Usia </strong></td>
                                    <td><?php echo "$NamaPasien ($gender) ($umur $sat_waktu)"; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis Pembayaran</strong></td>
                                    <td><?php echo "$JenisPembayaran"; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Asal Kiriman</strong></td>
                                    <td><?php echo "$AsalKiriman"; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Permintaan Pemeriksaan</strong></td>
                                    <td><?php echo "$PermintaanPemeriksaan"; ?></td>
                                </tr>
                            </table>
                <!----------------------------------DATA KIRI------------------------------------------------------------------->        
                        </td>
                        <td width="50%">
                <!----------------------------------DATA KANAN------------------------------------------------------------------->     
                            <table width="100%" class="data" cellspacing="0px">
                                <tr>
                                    <td><strong>Alat/Pesawat</strong></td>
                                    <td><?php echo "$AlatPemeriksa"; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Klinis Pasien</strong></td>
                                    <td><?php echo "$KlinisPasien"; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Faktor Eksposi</strong></td>
                                    <td><?php echo "KV:$kv MA:$ma Sec:$sec"; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Dokter Pengirim</strong></td>
                                    <td><?php echo "$DokterPengirim"; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Radiolog</strong></td>
                                    <td><?php echo "$DokterPengirim"; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Radiografer</strong></td>
                                    <td><?php echo $RadioGrafer; ?></td>
                                </tr>
                            </table>
                <!----------------------------------DATA KANAN------------------------------------------------------------------->     
                        </td>
                    </tr>
                </table>	
            </div>
            <div class="kop3">
                <table width="100%">
                    <tr>
                        <td align="left">
                            <b>Deskripsi Gambar / Kesimpulan</b>
                        </td>
                    </tr>
                </table>
            </div>
        <div class="kop">
            <!--------------------------Data hasil RAD--------------------------------------------------------------->
            <table width="100%" class="data">
                <?php
                    $no = 1;
                    $QryHasilPemeriksaan = mysqli_query($Conn, "SELECT*FROM radiologi_rincian WHERE kategori='Radiologi' AND id_rad='$id_rad'");
                    while ($DatahasilPemeriksaan = mysqli_fetch_array($QryHasilPemeriksaan)) {
                    if(empty($DatahasilPemeriksaan['pemeriksaan'])){
                        $Pemeriksaan="";
                    }else{
                        $Pemeriksaan =$DatahasilPemeriksaan['pemeriksaan'];
                    }
                    if(empty($DatahasilPemeriksaan['hasil'])){
                        $HasilPemeriksaan="";
                    }else{
                        $HasilPemeriksaan =$DatahasilPemeriksaan['hasil'];
                    }  
                    if(empty($DatahasilPemeriksaan['keterangan'])){
                        $KeteranganPemeriksaan="";
                    }else{
                        $KeteranganPemeriksaan =$DatahasilPemeriksaan['keterangan'];
                    }
                ?>
                    <tr class="isi">
                        <td align="left">
                            <b><?php echo "$Pemeriksaan"; ?></b>
                            <p><?php echo "$HasilPemeriksaan"; ?></p>
                            <p><?php echo "$KeteranganPemeriksaan"; ?></p>
                        </td>
                    </tr>
                <?php $no++;}?>
            </table>
        </div>
        <?php if($CetakLampiran=="Yes"){ ?>
            <div class="kop">
                <h3>Lampiran</h3><br>
                <?php
                    $QryLampiran = mysqli_query($Conn, "SELECT*FROM radiologi_file WHERE id_rad='$id_rad'");
                    while ($DataLampiran = mysqli_fetch_array($QryLampiran)) {
                        if(!empty($DataLampiran['internal_eksternal'])){
                            $internal_eksternal= $DataLampiran['internal_eksternal'];
                            $url_file= $DataLampiran['url_file'];
                            $filename= $DataLampiran['filename'];
                            if($internal_eksternal=="Internal"){
                                $UrlLampiran="../../assets/images/Radiologi/$filename";
                            }else{
                                $UrlLampiran="$url_file";
                            }
                            echo '<img src="'.$UrlLampiran.'" width="200px" height="200px">';
                        }
                    }
                ?>
                <br><br>
            </div>
        <?php } ?>
            <table class="data" width="100%">
                <tr>
                    <td width="60%" align="center"></td>
                    <?php
                        echo '<td width="20%" align="center">';
                        //Membuka Data Verifikasi
                        $QryVerifikasiRadiografer = mysqli_query($Conn,"SELECT * FROM radiologi_sig WHERE id_rad='$id_rad' AND kategori='Radiografer'")or die(mysqli_error($Conn));
                        $DataVerifikasiRadiografer = mysqli_fetch_array($QryVerifikasiRadiografer);
                        if(empty($DataVerifikasiRadiografer['id_radiologi_sig'])){
                            $id_radiologi_sig="";
                            $TanggalVerifikasiRadiografer="";
                            $NamaVerifikatorRadiografer="";
                            $SignaturRadiografer="";
                        }else{
                            $id_radiologi_sig=$DataVerifikasiRadiografer['id_radiologi_sig'];
                            $TanggalVerifikasiRadiografer=$DataVerifikasiRadiografer['tanggal'];
                            $NamaVerifikatorRadiografer=$DataVerifikasiRadiografer['nama'];
                            $SignaturRadiografer=$DataVerifikasiRadiografer['signature'];
                            //Format Tanggal
                            $Strtotime=strtotime($TanggalVerifikasiRadiografer);
                            $FormatTanggal=date('d/m/Y',$Strtotime);
                            echo '  <b>Radiografer</b><br>';
                            echo '  Tgl.'.$FormatTanggal.'<br>';
                            echo '  <img src="data:image/png;base64,' . $SignaturRadiografer . '" width="100%"><br>';
                            echo '  ('.$NamaVerifikatorRadiografer.')';
                        }
                        echo '</td>';
                    ?>
                    <?php
                        echo '<td width="20%" align="center">';
                        //Membuka Data Verifikasi Dokter
                        $QryVerifikasiDokter= mysqli_query($Conn,"SELECT * FROM radiologi_sig WHERE id_rad='$id_rad' AND kategori='Dokter Spesialis'")or die(mysqli_error($Conn));
                        $DataVerifikasiDokter= mysqli_fetch_array($QryVerifikasiDokter);
                        if(empty($DataVerifikasiDokter['id_radiologi_sig'])){
                            $TanggalVerifikasiDokter="";
                            $NamaVerifikatorDokter="";
                            $SignaturDokter="";
                        }else{
                            $TanggalVerifikasiDokter=$DataVerifikasiDokter['tanggal'];
                            $NamaVerifikatorDokter=$DataVerifikasiDokter['nama'];
                            $SignaturDokter=$DataVerifikasiDokter['signature'];
                            //Format Tanggal
                            $Strtotime=strtotime($TanggalVerifikasiDokter);
                            $FormatTanggal=date('d/m/Y',$Strtotime);
                            echo '  <b>Radiolog</b><br>';
                            echo '  Tgl.'.$FormatTanggal.'<br>';
                            echo '  <img src="data:image/png;base64,' . $SignaturDokter . '" width="100%"><br>';
                            echo '  ('.$NamaVerifikatorDokter.')';
                        }
                        echo '</td>';
                    ?>
                </tr>
            </table>
        </body>
    </html>
<?php } } }}} ?>
