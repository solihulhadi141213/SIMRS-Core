<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SettingFaskes.php";
    if(empty($_POST['PeriodeDataExport'])){
        echo 'Periode Data Tidak Boleh Kosong!';
    }else{
        if(empty($_POST['FormatData'])){
            echo 'Format Data Tidak Boleh Kosong!';
        }else{
            $PeriodeDataExport=$_POST['PeriodeDataExport'];
            $FormatData=$_POST['FormatData'];
            if($PeriodeDataExport=="Tahunan"){
                if(empty($_POST['TahunData'])){
                    $ValidasiWaktuData="Tahun Data Tidak Boleh Kosong";
                    $TahunData="";
                }else{
                    $ValidasiWaktuData="Valid";
                    $TahunData=$_POST['TahunData'];
                    $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi WHERE waktu like '%$TahunData%'"));
                }
            }else{
                if($PeriodeDataExport=="Bulanan"){
                    if(empty($_POST['BulanData'])){
                        $ValidasiWaktuData="Bulan Data Tidak Boleh Kosong";
                        $BulanData="";
                        $TahunData="";
                    }else{
                        if(empty($_POST['TahunData'])){
                            $ValidasiWaktuData="Tahun Data Tidak Boleh Kosong";
                            $BulanData="";
                            $TahunData="";
                        }else{
                            $ValidasiWaktuData="Valid";
                            $TahunData=$_POST['TahunData'];
                            $BulanData=$_POST['BulanData'];
                            $BulanTahunData="$TahunData-$BulanData";
                            $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi WHERE waktu like '%$BulanTahunData%'"));
                        }
                    }
                }else{
                    if($PeriodeDataExport=="Harian"){
                        if(empty($_POST['KeywordWaktu'])){
                            $ValidasiWaktuData="Keterangan Waktu Data Tidak Boleh Kosong";
                            $KeywordWaktu="";
                        }else{
                            $ValidasiWaktuData="Valid";
                            $KeywordWaktu=$_POST['KeywordWaktu'];
                            $strtotime=strtotime($KeywordWaktu);
                            $TanggalFormat=date('d/m/Y',$strtotime);
                            $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM radiologi WHERE waktu like '%$KeywordWaktu%'"));
                        }
                    }
                }
            }
            if($ValidasiWaktuData!=="Valid"){
                echo $ValidasiWaktuData;
            }else{
                if($FormatData=="EXCEL"){
                    header("Content-type: application/vnd-ms-excel");
                    header("Content-Disposition: attachment; filename=Radiologi.xls");
                }
?>
    <html>
        <head>
            <title>Export Data Radiologi</title>
            <link rel="icon" href="../../assets/images/<?php echo "$favicon"; ?>" type="image/x-icon">
            <style type="text/css">
                body{
                    font-family: Arial, Helvetica, sans-serif;
                    color: black;
                }
                .kopsurat{
                    width: 100%;
                    text-align: left;
                }
                .logo{
                    width: 100px;
                }
                .title_halaman{
                    font-size: 18px;
                }
                .bold{
                    font-weight: bolder;
                }
                .italic{
                    font-style: italic;
                }
                .data{
                    font-family: Arial, Helvetica, sans-serif;
                    color: black;
                }
                table.hasil{
                    border-collapse: collapse;
                }
                table.hasil tr td{
                    border: 1px solid #999;
                    padding: 8px 20px;
                    
                }
            </style>
        </head>
        <body>
            <?php if($FormatData!=="EXCEL"){ ?>
                <div class="kopsurat">
                    <table>
                        <tr>
                            <td>
                                <img src="../../assets/images/<?php echo "$logo"; ?>" class="logo">
                            </td>
                            <td>
                                <div class="title_halaman bold"><?php echo "$NamaFaskes";?></div>
                                <div class="title_halaman italic"><?php echo $AlamatFaskes;?></div>
                                <div class="title_halaman bold">DATA PELAYANAN PEMERIKSAAN RADIOLOGI</div>
                                <?php
                                    if($PeriodeDataExport=="Tahunan"){
                                        echo "PERIODE TAHUN $TahunData";
                                    }else{
                                        if($PeriodeDataExport=="Bulanan"){
                                            echo "PERIODE BULAN $BulanData $TahunData";
                                        }else{
                                            echo "PERIODE WAKTU $TanggalFormat";
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
            <div class="data">
                <table class="hasil" cellspacing="0px">
                    <tr>
                        <tr class="title">
                            <td align="center"><strong>No</strong></td>
                            <td align="center"><strong>No.RM</strong></td>
                            <td align="center"><strong>No.REG</strong></td>
                            <td align="center"><strong>NAMA PASIEN</strong></td>
                            <td align="center"><strong>TGL.DAFTAR</strong></td>
                            <td align="center"><strong>ASAL KIRIMAN</strong></td>
                            <td align="center"><strong>PEMERIKSAAN</strong></td>
                            <td align="center"><strong>ALAT</strong></td>
                            <td align="center"><strong>PEMBAYARAN</strong></td>
                            <td align="center"><strong>STATUS</strong></td>
                            <td align="center"><strong>DOKTER</strong></td>
                            <td align="center"><strong>RADIOGRAFER</strong></td>
                            <td align="center"><strong>KESAN</strong></td>
                            <td align="center"><strong>KLINIS</strong></td>
                            <td align="center"><strong>SELESAI</strong></td>
                            <td align="center"><strong>KV/MA/SEC</strong></td>
                        </tr>
                    </tr>
                    <?php
                        if(empty($JumlahData)){
                            echo '<tr>';
                            echo '  <td colspan="16" align="center">';
                            echo '      TIDAK ADA DATA YANG DITAMPILKAN';
                            echo '  </td>';
                            echo '</tr>';
                        }else{
                            $no = 1;
                            //KONDISI PENGATURAN MASING FILTER
                            if($PeriodeDataExport=="Tahunan"){
                                $query = mysqli_query($Conn, "SELECT*FROM radiologi WHERE waktu like '%$TahunData%'");
                            }else{
                                if($PeriodeDataExport=="Bulanan"){
                                    $query = mysqli_query($Conn, "SELECT*FROM radiologi WHERE waktu like '%$BulanTahunData%'");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM radiologi WHERE waktu like '%$KeywordWaktu%'");
                                }
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $id_rad= $data['id_rad'];
                                $id_pasien= $data['id_pasien'];
                                $nama= $data['nama'];
                                $radiografer= $data['radiografer'];
                                $kesan= $data['kesan'];
                                $klinis= $data['klinis'];
                                $selesai= $data['selesai'];
                                //Buka Data Alamat pasien
                                $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$id_pasien'")or die(mysqli_error($Conn));
                                $DataPasien = mysqli_fetch_array($QryPasien);
                                if(empty($DataPasien['propinsi'])){
                                    $propinsi="";
                                }else{
                                    $propinsi=$DataPasien['propinsi'];
                                }
                                if(empty($DataPasien['kabupaten'])){
                                    $kabupaten="";
                                }else{
                                    $kabupaten=$DataPasien['kabupaten'];
                                }
                                if(empty($DataPasien['kecamatan'])){
                                    $kecamatan="";
                                }else{
                                    $kecamatan=$DataPasien['kecamatan'];
                                }
                                if(empty($DataPasien['desa'])){
                                    $desa="";
                                }else{
                                    $desa=$DataPasien['desa'];
                                }
                                if(empty($DataPasien['alamat'])){
                                    $alamat="";
                                }else{
                                    $alamat=$DataPasien['alamat'];
                                }
                                if(empty($desa)){
                                    $Alamatpasien='<span class="text-danger">Alamat Tidak Diketahui</span>';
                                }else{
                                    $Alamatpasien="$desa-$kecamatan";
                                }
                                if(empty($DataPasien['kontak'])){
                                    $kontak="";
                                }else{
                                    $kontak=$DataPasien['kontak'];
                                }
                                //apabila selesai kosong
                                if(empty($data['selesai'])){
                                    $selesai='<span class="text-danger">None</span>';
                                }else{
                                    $selesai=$data['selesai'];
                                    $strtotime_selesai=strtotime($selesai);
                                    $selesai=date('d/m/Y H:i',$strtotime_selesai);
                                }
                                //apabila radiografer kosong
                                if(empty($data['radiografer'])){
                                    $radiografer='<span class="text-danger">None</span>';
                                }else{
                                    $radiografer=$data['radiografer'];
                                }
                                //apabila alat kosong
                                if(empty($data['alat_pemeriksa'])){
                                    $alat_pemeriksa='<span class="text-danger">Alat Tidak Diketahui</span>';
                                }else{
                                    $alat_pemeriksa=$data['alat_pemeriksa'];
                                }
                                //apabila asal_kiriman kosong
                                if(empty($data['asal_kiriman'])){
                                    $asal_kiriman='<span class="text-danger">Asal Kiriman Tidak Ada</span>';
                                }else{
                                    $asal_kiriman=$data['asal_kiriman'];
                                }
                                //apabila permintaan id Kunjungan
                                if(empty($data['id_kunjungan'])){
                                    $id_kunjungan='<span class="text-danger">None</span>';
                                }else{
                                    $id_kunjungan=$data['id_kunjungan'];
                                }
                                //Format waktu pelayanan
                                if(empty($data['waktu'])){
                                    $FormatWaktu='<span class="text-danger">Waktu Tidak Ada</span>';
                                }else{
                                    $waktu=$data['waktu'];
                                    $strtotime_waktu=strtotime($waktu);
                                    $FormatWaktu=date('d/m/Y H:i',$strtotime_waktu);
                                }
                                //apabila permintaan pemeriksaan kosong
                                if(empty($data['permintaan_pemeriksaan'])){
                                    $permintaan_pemeriksaan='<span class="text-danger">Permintaan Pemeriksaan Tidak Ada</span>';
                                }else{
                                    $permintaan_pemeriksaan=$data['permintaan_pemeriksaan'];
                                }
                                //Dokter Penerima
                                if(empty($data['permintaan_pemeriksaan'])){
                                    $dokter_penerima='<small class="text-danger">Dokter Penerima Tidak Diketahui</small>';
                                }else{
                                    $dokter_penerima=$data['dokter_penerima'];
                                }
                                //Dokter Pengirim
                                if(empty($data['dokter_pengirim'])){
                                    $dokter_pengirim='<small class="text-danger">Dokter Pengirim Tidak Diketahui</small>';
                                }else{
                                    $dokter_pengirim=$data['dokter_pengirim'];
                                }
                                //Pembayaran
                                if(empty($data['jenis_pembayaran'])){
                                    $jenis_pembayaran='<small class="text-danger">Pembayaran Tidak Diketahui</small>';
                                }else{
                                    $jenis_pembayaran=$data['jenis_pembayaran'];
                                }
                                //Status
                                if(empty($data['status_pemeriksaan'])){
                                    $status_pemeriksaan='<small class="text-danger">Status Tidak Diketahui</small>';
                                }else{
                                    $status_pemeriksaan=$data['status_pemeriksaan'];
                                    if($status_pemeriksaan=="Selesai"){
                                        $status_pemeriksaan='<small class="text-success">Selesai</small>';
                                    }else{
                                        $status_pemeriksaan='<small class="text-danger">'.$status_pemeriksaan.'</small>';
                                    }
                                }
                                //kv
                                if(empty($data['kv'])){
                                    $kv='<small class="text-danger">None</small>';
                                }else{
                                    $kv=$data['kv'];
                                }
                                //ma
                                if(empty($data['ma'])){
                                    $ma='<small class="text-danger">None</small>';
                                }else{
                                    $ma=$data['ma'];
                                }
                                //sec
                                if(empty($data['sec'])){
                                    $sec='<small class="text-danger">None</small>';
                                }else{
                                    $sec=$data['sec'];
                                }
                    ?>
                        <tr class="isi">
                            <td align="center"><?php echo $no;?></td>
                            <td align="left"><?php echo $id_pasien;?></td>
                            <td align="left"><?php echo $id_kunjungan;?></td>
                            <td align="left"><?php echo $nama;?></td>
                            <td align="left"><?php echo $waktu;?></td>
                            <td align="left"><?php echo $asal_kiriman;?></td>
                            <td align="left"><?php echo $permintaan_pemeriksaan;?></td>
                            <td align="left"><?php echo $alat_pemeriksa;?></td>
                            <td align="left"><?php echo $jenis_pembayaran;?></td>
                            <td align="left"><?php echo $status_pemeriksaan;?></td>
                            <td align="left"><?php echo $dokter_penerima;?></td>
                            <td align="left"><?php echo $radiografer;?></td>
                            <td align="left"><?php echo $kesan;?></td>
                            <td align="left"><?php echo $klinis;?></td>
                            <td align="left"><?php echo $selesai;?></td>
                            <td align="left"><?php echo "$kv/$ma/$sec";?></td>
                        </tr>
                    <?php $no++;}}?>
                </table>
            </div>
        </body>
    </html>
<?php } } } ?>