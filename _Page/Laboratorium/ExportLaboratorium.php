<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/SimrsFunction.php";
    
    if(empty($_POST['periode'])){
        echo "Periode Waktu Tidak Boleh Kosong!";
    }else{
        if(empty($_POST['format'])){
            echo "Format Data Tidak Boleh Kosong!";
        }else{
            $periode=$_POST['periode'];
            $format=$_POST['format'];
            //Validasi Kelengkapan Data
            if($periode=="Tahunan"){
                if(empty($_POST['tahun'])){
                    $ValidasiKelengkapan="Informasi Tahun Tidak Boleh Kosong!";
                }else{
                    $Tahun=$_POST['tahun'];
                    $ValidasiKelengkapan="Valid";
                    $LabelPeriode="PERIODE TAHUN $Tahun";
                }
            }else{
                if($periode=="Bulanan"){
                    if(empty($_POST['tahun'])){
                        $ValidasiKelengkapan="Informasi Tahun Tidak Boleh Kosong!";
                    }else{
                        if(empty($_POST['bulan'])){
                            $ValidasiKelengkapan="Informasi Bulan Tidak Boleh Kosong!";
                        }else{
                            $Tahun=$_POST['tahun'];
                            $Bulan=$_POST['bulan'];
                            $TahunBulan="$Tahun-$Bulan";
                            $ValidasiKelengkapan="Valid";
                            $NamaBulan=getNamaBulan($Tahun, $Bulan);
                            $LabelPeriode="PERIODE $NamaBulan $Tahun ";
                        }
                    }
                }else{
                    if($periode=="Harian"){
                        if(empty($_POST['tanggal'])){
                            $ValidasiKelengkapan="Tanggal Tidak Boleh Kosong!";
                        }else{
                            $Tanggal=$_POST['tanggal'];
                            $ValidasiKelengkapan="Valid";
                        }
                    }else{
                        if($periode=="Periode"){
                            if(empty($_POST['periode_awal'])){
                                $ValidasiKelengkapan="Periode Awal Tidak Boleh Kosong!";
                            }else{
                                if(empty($_POST['periode_akhir'])){
                                    $ValidasiKelengkapan="Periode Akhir Tidak Boleh Kosong!";
                                }else{
                                    $periode_awal=$_POST['periode_awal'];
                                    $periode_akhir=$_POST['periode_akhir'];
                                    $ValidasiKelengkapan="Valid";
                                }
                            }
                        }else{
                            $ValidasiKelengkapan="Valid";
                        }
                    }
                }
            }
            if($ValidasiKelengkapan!=="Valid"){
                echo "$ValidasiKelengkapan";
            }else{
                if($format=="PDF"){
                    //koneksi dan error
                    $FileName= "DataLaboratorium";
                    //Config Plugin MPDF
                    require_once '../../vendor/autoload.php';
                    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'A4']);
                    $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
                    ob_start(); 
                }else{
                    if($format=="Excel"){
                        header("Content-type: application/vnd-ms-excel");
                        header("Content-Disposition: attachment; filename=DataLaboratorium.xls");
                    }
                }
?>
    <html>
        <head>
            <title>Data Laboratorium</title>
            <style type="text/css">
                @page {
                    margin-top: 1cm;
                    margin-bottom: 1cm;
                    margin-left: 1cm;
                    margin-right: 1cm;
                }
                body {
                    background-color: #FFF;
                    font-family: arial;
                }
                table{
                    border-collapse: collapse;
                    margin-top:10px;
                }
                table.data tr td {
                    border: 0.5px solid #666;
                    color:#333;
                    border-spacing: 0px;
                    padding: 10px;
                    border-collapse: collapse;
                }
            </style>
        </head>
        <body>
            <table class="Kop" width="100%">
                <tr>
                    <td align="center" colspan="11">
                        <h3><b><?php echo "$NamaFaskes";?></b></h3>
                        <?php echo "$AlamatFaskes";?><br>
                        <?php echo "No.Kontak : $KontakFaskes";?><br>
                        <?php echo "Email : $EmailFaskes";?><br>
                        <b><?php echo "DATA LABORATORIUM $LabelPeriode ";?></b>
                    </td>
                </tr>
            </table>
            <br>
            <table class="data" width="100%" celspacing="0">
                <tr>
                    <td align="center"><b>No</b></td>
                    <td align="center"><b>No.RM</b></td>
                    <td align="center"><b>Nama</b></td>
                    <td align="center"><b>Tanggal</b></td>
                    <td align="center"><b>Tujuan</b></td>
                    <td align="center"><b>Dokter</b></td>
                    <td align="center"><b>Faskes</b></td>
                    <td align="center"><b>Unit</b></td>
                    <td align="center"><b>Priotitas</b></td>
                    <td align="center"><b>Diagnosis</b></td>
                    <td align="center"><b>Status</b></td>
                </tr>
                <?php
                    $no=1;
                    //Routing berdasarkan 
                    if($periode=="Tahunan"){
                        $query = mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE tanggal like '%$Tahun%'  ORDER BY id_permintaan ASC");
                    }else{
                        if($periode=="Bulanan"){
                            $query = mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE tanggal like '%$TahunBulan%'  ORDER BY id_permintaan ASC");
                        }else{
                            if($periode=="Harian"){
                                $query = mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE tanggal like '%$Tanggal%'  ORDER BY id_permintaan ASC");
                            }else{
                                if($periode=="Periode"){
                                    $query = mysqli_query($Conn, "SELECT*FROM laboratorium_permintaan WHERE tanggal>=$periode_awal AND tanggal<=$periode_akhir  ORDER BY id_permintaan ASC");
                                }else{
                                }
                            }
                        }
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_permintaan= $data['id_permintaan'];
                        $id_pasien= $data['id_pasien'];
                        $id_kunjungan= $data['id_kunjungan'];
                        $id_dokter= $data['id_dokter'];
                        $tujuan= $data['tujuan'];
                        $nama_pasien= $data['nama_pasien'];
                        $nama_dokter= $data['nama_dokter'];
                        $tanggal= $data['tanggal'];
                        $faskes= $data['faskes'];
                        $unit= $data['unit'];
                        $prioritas= $data['prioritas'];
                        $diagnosis= $data['diagnosis'];
                        $keterangan_permintaan= $data['keterangan_permintaan'];
                        $nama_signature= $data['nama_signature'];
                        $signature= $data['signature'];
                        $status= $data['status'];
                        $keterangan_status= $data['keterangan_status'];
                        //Format Tanggal
                        $strtotime=strtotime($tanggal);
                        $FormatTanggal=date('d/m/Y');
                        echo '  <tr>';
                        echo '      <td>'.$no.'</td>';
                        echo '      <td>'.$id_pasien.'</td>';
                        echo '      <td>'.$nama_pasien.'</td>';
                        echo '      <td>'.$FormatTanggal.'</td>';
                        echo '      <td>'.$tujuan.'</td>';
                        echo '      <td>'.$nama_dokter.'</td>';
                        echo '      <td>'.$faskes.'</td>';
                        echo '      <td>'.$unit.'</td>';
                        echo '      <td>'.$prioritas.'</td>';
                        echo '      <td>'.$diagnosis.'</td>';
                        echo '      <td>'.$status.'</td>';
                        echo '  </tr>';
                        $no++;
                    }
                ?>
            </table>
        </body>
    </html>
<?php
                if($format=="PDF"){
                    $html = ob_get_contents();
                    ob_end_clean();
                    $mpdf->WriteHTML(utf8_encode($html));
                    $mpdf->Output($FileName.".pdf" ,'I');
                    exit; 
                }
            }
        }
    }
?>