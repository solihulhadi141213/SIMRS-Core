<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_lab'])){
        echo "Error: ID Laboratorium tidak boleh kosong";
    }else{
        //Tangkap Setting
        if(empty($_POST['nama_font'])){
            $nama_font="";
        }else{
            $nama_font=$_POST['nama_font'];
        }
        if(empty($_POST['ukuran_font'])){
            $ukuran_font="";
        }else{
            $ukuran_font=$_POST['ukuran_font'];
        }
        if(empty($_POST['warna_font'])){
            $warna_font="";
        }else{
            $warna_font=$_POST['warna_font'];
        }
        if(empty($_POST['satuan'])){
            $satuan="";
        }else{
            $satuan=$_POST['satuan'];
        }
        if(empty($_POST['margin'])){
            $margin="";
        }else{
            $margin=$_POST['margin'];
        }
        if(empty($_POST['padding'])){
            $padding="";
        }else{
            $padding=$_POST['padding'];
        }
        if(empty($_POST['panjang_x'])){
            $panjang_x="";
        }else{
            $panjang_x=$_POST['panjang_x'];
        }
        if(empty($_POST['lebar_y'])){
            $lebar_y="";
        }else{
            $lebar_y=$_POST['lebar_y'];
        }
        if(empty($_POST['signature'])){
            $signature_setting="";
        }else{
            $signature_setting=$_POST['signature'];
        }
        if(empty($_POST['kop'])){
            $kop="";
        }else{
            $kop=$_POST['kop'];
        }
        if(empty($_POST['spesimen'])){
            $cetak_spesimen="";
        }else{
            $cetak_spesimen=$_POST['spesimen'];
        }
        if(empty($_POST['format'])){
            $format_cetak="";
        }else{
            $format_cetak=$_POST['format'];
        }
        if(empty($_POST['SimpanPengaturan'])){
            $SimpanPengaturan="";
        }else{
            $SimpanPengaturan=$_POST['SimpanPengaturan'];
            if($SimpanPengaturan=="Simpan"){
                $nama_font_save=saveSettingDinamis($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','nama_font',$nama_font);
                $ukuran_font_save=saveSettingDinamis($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','ukuran_font',$ukuran_font);
                $warna_font_save=saveSettingDinamis($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','warna_font',$warna_font);
                $satuan_save=saveSettingDinamis($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','satuan',$satuan);
                $panjang_x_save=saveSettingDinamis($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','panjang_x',$panjang_x);
                $lebar_y_save=saveSettingDinamis($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','lebar_y',$lebar_y);
                $margin_save=saveSettingDinamis($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','margin',$margin);
                $padding_save=saveSettingDinamis($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','padding',$padding);
                $signature_save=saveSettingDinamis($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','signature',$signature_setting);
                $kop_save=saveSettingDinamis($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','kop',$kop);
                $spesimen_save=saveSettingDinamis($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','spesimen',$cetak_spesimen);
                $format_save=saveSettingDinamis($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','format',$format_cetak);
                $Panjang="$panjang_x";
                $Lebar="$lebar_y";
            }
        }
        //buka Lab
        $id_lab= $_POST['id_lab'];
        $id_permintaan=getDataDetail($Conn,'laboratorium_pemeriksaan','id_lab',$id_lab,'id_permintaan');
        $id_pasien=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'id_pasien');
        $id_kunjungan=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'id_kunjungan');
        $id_dokter=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'id_dokter');
        $tujuan=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'tujuan');
        $nama_pasien=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'nama_pasien');
        $nama_dokter=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'nama_dokter');
        $tanggal=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'tanggal');
        $faskes=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'faskes');
        $unit=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'unit');
        $prioritas=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'prioritas');
        $diagnosis=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'diagnosis');
        $keterangan_permintaan=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'keterangan_permintaan');
        $nama_signature=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'nama_signature');
        $signature=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'signature');
        $status=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'status');
        $keterangan_status=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'keterangan_status');
        //Buka Kunjungan
        $tanggal_kunjungan=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'tanggal');
        $pembayaran=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'pembayaran');
        //Pemeriksaan
        $waktu_pendaftaran=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'waktu_pendaftaran');
        $pengambilan_sample=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'pengambilan_sample');
        $pemeriksaan_sample=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'pemeriksaan_sample');
        $keluar_hasil=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'keluar_hasil');
        $hasil_diserahkan=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'hasil_diserahkan');
        $metode_penyerahan=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'metode_penyerahan');
        $interpertasi_hasil=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'interpertasi_hasil');
        $dokter_interpertasi=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'dokter_interpertasi');
        $dokter_validator=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'dokter_validator');
        $petugas_analis=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'petugas_analis');
        $sig_dokter_intr=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'sig_dokter_intr');
        $sig_dokter_validator=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'sig_dokter_validator');
        $sig_petugas_analis=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'sig_petugas_analis');
        //Pecahkan tanggal
        $strtotime=strtotime($tanggal);
        $strtotime2=strtotime($tanggal_kunjungan);
        $strtotime3=strtotime($pengambilan_sample);
        $strtotime4=strtotime($pemeriksaan_sample);
        $strtotime5=strtotime($keluar_hasil);
        $Tanggal=date('d/m/Y H:i T',$strtotime);
        $TanggalKunjungan=date('d/m/Y H:i T',$strtotime2);
        $PengambilanSample=date('d/m/Y H:i T',$strtotime3);
        $PemeriksaanSample=date('d/m/Y H:i T',$strtotime4);
        $KeluarHasil=date('d/m/Y H:i T',$strtotime5);
        $WaktuAwal=strtotime("$pengambilan_sample"); 
        $WaktuAkhir=strtotime("$hasil_diserahkan");
        $diff  = $strtotime5 - $strtotime;
        $DurasiPelayananJam   = floor($diff / (60 * 60));
        $DurasiPelayananMenit = $diff - $DurasiPelayananJam * (60 * 60);
        $DurasiPelayananMenit = floor( $DurasiPelayananMenit / 60 );
        //Jumlah Hasil Pemeriksaan
        $JumlahHasilPemeriksaan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_rincian WHERE id_permintaan='$id_permintaan' AND id_lab='$id_lab'"));
        //Format
        if($format_cetak=="PDF"){
            //koneksi dan error
            $FileName= "Hasil-Pemeriksaan-lab-$id_lab";
            //Config Plugin MPDF
            require_once '../../vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [$Panjang, $Lebar]]);
            $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
            //Beginning Buffer to save PHP variables and HTML tags
            ob_start(); 
        }
        if(empty($_POST['status_selesai'])){
            $status_selesai="";
        }else{
            $status_selesai=$_POST['status_selesai'];
            if( $status_selesai=="selesai"){
                $UpdateStatusPermintaan = mysqli_query($Conn,"UPDATE laboratorium_permintaan SET 
                    status='Selesai'
                WHERE id_permintaan='$id_permintaan'") or die(mysqli_error($Conn)); 
                if($UpdateStatusPermintaan){
                }
            }
        }

?>
    <html>
        <Header>
            <title>Hasil Pemeriksaan</title>
            <style type="text/css">
                @page {
                    margin-top: <?php echo "$margin$satuan"; ?>;
                    margin-bottom: <?php echo "$margin$satuan"; ?>;
                    margin-left: <?php echo "$margin$satuan"; ?>;
                    margin-right: <?php echo "$margin$satuan"; ?>;
                }
                body{
                    font-family: <?php echo "$nama_font"; ?>;
                    color: <?php echo "$warna_font"; ?>;
                    padding: <?php echo "$padding$satuan"; ?>;
                } 
                table{
                    font-size: <?php echo "$ukuran_font"; ?>;
                }
                .kopsurat{
                    width: 100%;
                    text-align: center;
                    border-bottom: 1px solid #999;
                }
                .logo{
                    width: 80px;
                    height: 80px;
                }
                .title_halaman{
                    font-size: <?php echo "$ukuran_font"; ?>;
                }
                .bold{
                    font-weight: bolder;
                }
                .italic{
                    font-style: italic;
                }
                .data{
                    font-family: <?php echo "$nama_font"; ?>;
                    color: <?php echo "$warna_font"; ?>;
                    font-size: <?php echo "$ukuran_font"; ?>;
                }
                table.hasil{
                    border-collapse: collapse;
                }
                table.hasil tr td{
                    border: 1px solid #999;
                }
            </style>
        </Header>
        <body>
            <?php if($kop=="Ya"){ ?>
                <div class="kopsurat">
                    <table class="tabel_kop" cellspacing="0px">
                        <tr>
                            <td>
                                <img class="logo" src="../../assets/images/<?php echo "$logo"; ?>" alt="" >
                            </td>
                            <td>
                                HASIL PEMERIKSAAN LABORATORIUM<br>
                                <?php echo "$NamaFaskes"; ?><br>
                                <?php echo "$AlamatFaskes"; ?><br>
                                <?php echo "Tlp.$KontakFaskes, Email.$EmailFaskes"; ?><br>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
            <div class="data">
                <table class="form" width="100%" cellspacing="0px">
                    <tr>
                        <td><b>NO.RM</b></td>
                        <td width="2%">:</td>
                        <td><?php echo $id_pasien; ?></td>
                        <td><b>ID.Permintaan</b></td>
                        <td width="2%">:</td>
                        <td><?php echo $id_permintaan; ?></td>
                        <td><b>Pendaftaran Lab</b></td>
                        <td>:</td>
                        <td><?php echo "$Tanggal"; ?></td>
                    </tr>
                    <tr>
                        <td><b>Nama Pasien</b></td>
                        <td>:</td>
                        <td><?php echo $nama_pasien; ?></td>
                        <td><b>Tanggal Permintaan</b></td>
                        <td>:</td>
                        <td><?php echo $Tanggal; ?></td>
                        <td><b>Pengambilan Sampel</b></td>
                        <td>:</td>
                        <td><?php echo "$PengambilanSample"; ?></td>
                    </tr>
                    <tr>
                        <td><b>Kunjungan</b></td>
                        <td>:</td>
                        <td><?php echo "REG-$id_kunjungan ($tujuan)"; ?></td>
                        <td><b>Permintaan Dokter</b></td>
                        <td>:</td>
                        <td><?php echo $nama_dokter; ?></td>
                        <td><b>Pemeriksaan Sample</b></td>
                        <td>:</td>
                        <td><?php echo "$PemeriksaanSample"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td width="2%">:</td>
                        <td><?php echo "$TanggalKunjungan"; ?></td>
                        <td><b>Faskes</b></td>
                        <td>:</td>
                        <td><?php echo "$faskes"; ?></td>
                        <td><b>Keluar Hasil</b></td>
                        <td>:</td>
                        <td><?php echo "$KeluarHasil"; ?></td>
                    </tr>
                    <tr>
                        <td><b>Kategori Peserta</b></td>
                        <td>:</td>
                        <td><?php echo "$pembayaran"; ?></td>
                        <td><b>Unit</b></td>
                        <td>:</td>
                        <td><?php echo "$unit"; ?></td>
                        <td><b>Durasi Pelayanan</b></td>
                        <td>:</td>
                        <td>
                            <?php 
                                if(empty($KeluarHasil)){
                                    echo "Tidak Bisa Menghitung Durasi Pelayanan"; 
                                }else{
                                    echo "$DurasiPelayananJam Jam $DurasiPelayananMenit Menit"; 
                                }
                                
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Petugas Analis</b></td>
                        <td>:</td>
                        <td><?php echo "$petugas_analis"; ?></td>
                        <td><b>Prioritas</b></td>
                        <td>:</td>
                        <td><?php echo "$prioritas"; ?></td>
                    </tr>
                    <tr>
                        <td><b>Dokter Analis</b></td>
                        <td>:</td>
                        <td><?php echo "$dokter_interpertasi"; ?></td>
                        <td><b>Diagnosis</b></td>
                        <td>:</td>
                        <td><?php echo "$diagnosis"; ?></td>
                    </tr>
                    <tr>
                        <td><b>Dokter Validator</b></td>
                        <td>:</td>
                        <td><?php echo "$dokter_validator"; ?></td>
                        <td><b>Pemohon</b></td>
                        <td>:</td>
                        <td><?php echo "$nama_signature"; ?></td>
                    </tr>
                </table><br>
                HASIL PEMERIKSAAN
                <table width="100%" class="hasil">
                    <tr class="title">
                        <td width="5%" align="center"><strong>No</strong></td>
                        <td align="center"><strong>PARAMETER</strong></td>
                        <td align="center"><strong>SPESIMEN</strong></td>
                        <td align="center"><strong>HASIL</strong></td>
                        <td align="center"><strong>N.RUJUKAN</strong></td>
                        <td align="center"><strong>N.KRITIS</strong></td>
                        <td align="center"><strong>INTERPERTASI</strong></td>
                        <td align="center"><strong>KETERANGAN</strong></td>
                    </tr>
                    <?php
                        if(empty($JumlahHasilPemeriksaan)){
                            echo '<tr>';
                            echo '  <td align="center" colspan="8">Belum Ada Hasil Pemeriksaan</td>';
                            echo '</tr>';
                        }else{
                            $no = 1;
                            //Menampilkan Hasil Pemeriksaan Kategori
                            $query = mysqli_query($Conn, "SELECT DISTINCT kategori_parameter FROM laboratorium_rincian WHERE id_permintaan='$id_permintaan' AND id_lab='$id_lab' ORDER BY kategori_parameter ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $kategori_parameter= $data['kategori_parameter'];
                                echo '<tr>';
                                echo '  <td align="center"><b>'.$no.'</b></td>';
                                echo '  <td align="left" colspan="7"><b>'.$kategori_parameter.'</b></td>';
                                echo '</tr>';
                                //Tampilkan Hasil Pemeriksaan
                                $no2=1;
                                $QryParameter = mysqli_query($Conn, "SELECT * FROM laboratorium_rincian WHERE id_permintaan='$id_permintaan' AND id_lab='$id_lab' AND kategori_parameter='$kategori_parameter' ORDER BY parameter ASC");
                                while ($DataParameter = mysqli_fetch_array($QryParameter)) {
                                    
                                    $parameter= $DataParameter['parameter'];
                                    $hasil= $DataParameter['hasil'];
                                    $interpertasi= $DataParameter['interpertasi'];
                                    $keterangan= $DataParameter['keterangan'];
                                    //Buka data parameter
                                    $QryParameter2 = mysqli_query($Conn,"SELECT * FROM laboratorium_parameter WHERE kategori_parameter='$kategori_parameter' AND parameter='$parameter'")or die(mysqli_error($Conn));
                                    $DataParameter2 = mysqli_fetch_array($QryParameter2);
                                    if(!empty($DataParameter2['id_laboratorium_parameter'])){
                                        $nilai_rujukan = $DataParameter2['nilai_rujukan'];
                                        $nilai_kritis = $DataParameter2['nilai_kritis'];
                                        $satuan = $DataParameter2['satuan'];
                                    }else{
                                        $nilai_rujukan ="";
                                        $nilai_kritis ="";
                                        $satuan ="";
                                    }
                                    //Buka Spesimen
                                    if(!empty($DataParameter['id_laboratorium_sample'])){
                                        $id_laboratorium_sample= $DataParameter['id_laboratorium_sample'];
                                        //Spesimen
                                        $QrySpesimen = mysqli_query($Conn,"SELECT * FROM laboratorium_sample WHERE id_laboratorium_sample='$id_laboratorium_sample'")or die(mysqli_error($Conn));
                                        $DataSpesimen = mysqli_fetch_array($QrySpesimen);
                                        if(!empty($DataSpesimen['id_laboratorium_sample'])){
                                            $sumber = $DataSpesimen['sumber'];
                                        }else{
                                            $sumber ="";
                                        }
                                    }else{
                                        $id_laboratorium_sample="";
                                        $sumber ="";
                                    }
                                    echo '<tr>';
                                    echo '  <td align="right">'.$no.'.'.$no2.'</td>';
                                    echo '  <td align="left">'.$parameter.'</td>';
                                    echo '  <td align="left">'.$id_laboratorium_sample.'-'.$sumber.'</td>';
                                    echo '  <td align="left">'.$hasil.' '.$satuan.'</td>';
                                    echo '  <td align="left">'.$nilai_rujukan.'</td>';
                                    echo '  <td align="left">'.$nilai_kritis.'</td>';
                                    echo '  <td align="left">'.$interpertasi.'</td>';
                                    echo '  <td align="left">'.$keterangan.'</td>';
                                    echo '</tr>';
                                    $no2++;
                                }
                                $no++;
                            }
                        }
                    ?>
                </table><br>
                <?php if($cetak_spesimen=="Ya"){ ?>
                    REFERENSI SPESIMEN
                    <table width="100%" class="hasil">
                        <tr class="title">
                            <td align="center"><strong>ID/Sumber</strong></td>
                            <td align="center"><strong>JUMLAH/Volume</strong></td>
                            <td align="center"><strong>METODE</strong></td>
                            <td align="center"><strong>KONDISI</strong></td>
                            <td align="center"><strong>FIKSASI</strong></td>
                            <td align="center"><strong>PETUGAS-1</strong></td>
                            <td align="center"><strong>PETUGAS-2</strong></td>
                            <td align="center"><strong>PETUGAS-3</strong></td>
                            <td align="center"><strong>STATUS</strong></td>
                        </tr>
                        <?php
                            $JumlahSpesimen=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_sample WHERE id_lab='$id_lab'"));
                            if(empty($JumlahSpesimen)){
                                echo '<tr>';
                                echo '  <td align="center" colspan="14">Belum Ada Data Spesimen Pemeriksaan</td>';
                                echo '</tr>';
                            }else{
                                //Menampilkan Spesimen
                                $QrySpesimen = mysqli_query($Conn, "SELECT * FROM laboratorium_sample WHERE id_lab='$id_lab' ORDER BY id_laboratorium_sample ASC");
                                while ($DataSpesimen = mysqli_fetch_array($QrySpesimen)) {
                                    $id_laboratorium_sample= $DataSpesimen['id_laboratorium_sample'];
                                    if(!empty($DataSpesimen['waktu_pengambilan'])){
                                        $waktu_pengambilan=$DataSpesimen['waktu_pengambilan'];
                                    }else{
                                        $waktu_pengambilan="";
                                    }
                                    if(!empty($DataSpesimen['sumber'])){
                                        $sumber=$DataSpesimen['sumber'];
                                    }else{
                                        $sumber="";
                                    }
                                    if(!empty($DataSpesimen['lokasi_pengambilan'])){
                                        $lokasi_pengambilan=$DataSpesimen['lokasi_pengambilan'];
                                    }else{
                                        $lokasi_pengambilan="";
                                    }
                                    if(!empty($DataSpesimen['jumlah_sample'])){
                                        $jumlah_sample=$DataSpesimen['jumlah_sample'];
                                    }else{
                                        $jumlah_sample="";
                                    }
                                    if(!empty($DataSpesimen['volume_sample'])){
                                        $volume_sample=$DataSpesimen['volume_sample'];
                                    }else{
                                        $volume_sample="";
                                    }
                                    if(!empty($DataSpesimen['metode'])){
                                        $metode=$DataSpesimen['metode'];
                                    }else{
                                        $metode="";
                                    }
                                    if(!empty($DataSpesimen['kondisi'])){
                                        $kondisi=$DataSpesimen['kondisi'];
                                    }else{
                                        $kondisi="";
                                    }
                                    if(!empty($DataSpesimen['waktu_fiksasi'])){
                                        $waktu_fiksasi=$DataSpesimen['waktu_fiksasi'];
                                    }else{
                                        $waktu_fiksasi="";
                                    }
                                    if(!empty($DataSpesimen['cairan_fiksasi'])){
                                        $cairan_fiksasi=$DataSpesimen['cairan_fiksasi'];
                                    }else{
                                        $cairan_fiksasi="";
                                    }
                                    if(!empty($DataSpesimen['volume_fiksasi'])){
                                        $volume_fiksasi=$DataSpesimen['volume_fiksasi'];
                                    }else{
                                        $volume_fiksasi="";
                                    }
                                    if(!empty($DataSpesimen['petugas_sample'])){
                                        $petugas_sample=$DataSpesimen['petugas_sample'];
                                    }else{
                                        $petugas_sample="";
                                    }
                                    if(!empty($DataSpesimen['petugas_pengantar'])){
                                        $petugas_pengantar=$DataSpesimen['petugas_pengantar'];
                                    }else{
                                        $petugas_pengantar="";
                                    }
                                    if(!empty($DataSpesimen['petugas_penerima'])){
                                        $petugas_penerima=$DataSpesimen['petugas_penerima'];
                                    }else{
                                        $petugas_penerima="";
                                    }
                                    if(!empty($DataSpesimen['status'])){
                                        $status=$DataSpesimen['status'];
                                    }else{
                                        $status="";
                                    }
                                    echo '<tr>';
                                    echo '  <td align="left"><b>'.$id_laboratorium_sample.'-'.$sumber.' ('.$lokasi_pengambilan.')</b><br><i>'.$waktu_pengambilan.'</i></td>';
                                    echo '  <td align="left"><b>'.$jumlah_sample.'</b><br><i>'.$volume_sample.'</i></td>';
                                    echo '  <td align="left">'.$metode.'</td>';
                                    echo '  <td align="left">'.$kondisi.'</td>';
                                    echo '  <td align="left"><b>'.$waktu_fiksasi.'</b><br><i>'.$cairan_fiksasi.' ('.$volume_fiksasi.')</i></td>';
                                    echo '  <td align="left">'.$petugas_sample.'</td>';
                                    echo '  <td align="left">'.$petugas_pengantar.'</td>';
                                    echo '  <td align="left">'.$petugas_penerima.'</td>';
                                    echo '  <td align="left">'.$status.'</td>';
                                    echo '</tr>';
                                }
                            }
                        ?>
                    </table>
                    <b>Keterangan : </b>
                    Petugas 1 : Petugas Yang Mengambil Spesimen,
                    Petugas 2 : Petugas Yang Mengantar Spesimen,
                    Petugas 3 : Petugas Yang Menerima Spesimen.
                <?php } ?>
                <?php if($signature_setting=="Ya"){ ?>
                    <table width="100%" class="hasil">
                        <tr class="title">
                            <td align="center"><strong>Dokter Analis</strong></td>
                            <td align="center"><strong>Dokter Validator</strong></td>
                            <td align="center"><strong>Petugas Analis</strong></td>
                        </tr>
                        <tr class="title">
                            <td align="center">
                                <?php
                                    echo '<img src="data:image/png;base64,' . $sig_dokter_intr . '" width="100px"><br>';
                                    echo "($dokter_interpertasi)";
                                ?>
                            </td>
                            <td align="center">
                                <?php
                                    echo '<img src="data:image/png;base64,' . $sig_dokter_validator . '" width="100px%"><br>';
                                    echo "($dokter_validator)";
                                ?>
                            </td>
                            <td align="center">
                                <?php
                                    echo '<img src="data:image/png;base64,' . $sig_petugas_analis . '" width="100px%"><br>';
                                    echo "($petugas_analis)";
                                ?>
                            </td>
                        </tr>
                    </table>
                <?php } ?>
            </div>
        </body>
    </html>
<?php 
        if($format_cetak=="PDF"){
            $html = ob_get_contents();
            ob_end_clean();
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output($FileName.".pdf" ,'I');
            exit; 
        }
    }
