<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/SimrsFunction.php";
        if(empty($_POST['format_data'])){
            echo "Format Data Tidak Boleh Kosong!";
        }else{
            if(empty($_POST['id_akses'])){
                echo "ID Akses Tidak Boleh Kosong!";
            }else{
                if(empty($_POST['periode_awal'])){
                    echo "Periode Awal Tidak Boleh Kosong!";
                }else{
                    if(empty($_POST['periode_akhir'])){
                        echo "Periode Akhir Tidak Boleh Kosong!";
                    }else{
                        $format=$_POST['format_data'];
                        $id_akses=$_POST['id_akses'];
                        $periode_awal=$_POST['periode_awal'];
                        $periode_akhir=$_POST['periode_akhir'];
                        if(empty($_POST['tampilkan_kop_faskes'])){
                            $TampilkanKop="No";
                        }else{
                            $TampilkanKop=$_POST['tampilkan_kop_faskes'];
                        }
                        if($format=="PDF"){
                            //koneksi dan error
                            $FileName= "DataLogAkses";
                            //Config Plugin MPDF
                            require_once '../../vendor/autoload.php';
                            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'A4']);
                            $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
                            ob_start(); 
                        }else{
                            if($format=="Excel"){
                                header("Content-type: application/vnd-ms-excel");
                                header("Content-Disposition: attachment; filename=DataLogAkses.xls");
                            }
                        }
                        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM log WHERE id_akses='$id_akses' AND waktu>='$periode_awal' AND waktu<='$periode_akhir'"));
?>
    <html>
        <head>
            <title>Data Log Akses</title>
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
            <?php if($TampilkanKop=="Ya"){ ?>
                <table class="Kop" width="100%">
                    <tr>
                        <td align="center" colspan="5">
                            <h3><b><?php echo "$NamaFaskes";?></b></h3>
                            <dt>Log Aktivitas Akses</dt>
                            <?php echo "$AlamatFaskes";?><br>
                            <?php echo "No.Kontak : $KontakFaskes";?><br>
                            <?php echo "Email : $EmailFaskes";?>
                        </td>
                    </tr>
                </table>
                <br>
            <?php } ?>
            <table class="data" width="100%" celspacing="0">
                <tr>
                    <td align="center"><b>NO</b></td>
                    <td align="center"><b>TANGGAL</b></td>
                    <td align="center"><b>NAMA</b></td>
                    <td align="center"><b>KATEGORI</b></td>
                    <td align="center"><b>KETERANGAN</b></td>
                </tr>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="5" class="text-center">';
                        echo '      Belum Ada Data Log Akses';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no=1;
                        //Tampilkan Data
                        $Qry = mysqli_query($Conn, "SELECT * FROM log WHERE id_akses='$id_akses' AND waktu>='$periode_awal' AND waktu<='$periode_akhir'");
                        while ($data = mysqli_fetch_array($Qry)) {
                            $waktu= $data['waktu'];
                            $nama= $data['nama'];
                            $nama_log= $data['nama_log'];
                            $kategori= $data['kategori'];
                            echo '  <tr>';
                            echo '      <td align="center">'.$no.'</td>';
                            echo '      <td>'.$waktu.'</td>';
                            echo '      <td>'.$nama.'</td>';
                            echo '      <td>'.$kategori.'</td>';
                            echo '      <td>'.$nama_log.'</td>';
                            echo '  </tr>';
                            $no++;
                        }
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
    }
?>