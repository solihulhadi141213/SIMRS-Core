<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/SimrsFunction.php";
        if(empty($_POST['format_eksport_referensi'])){
            echo "Format Data Tidak Boleh Kosong!";
        }else{
            $format=$_POST['format_eksport_referensi'];
            if(empty($_POST['TampilkanKop'])){
                $TampilkanKop="No";
            }else{
                $TampilkanKop=$_POST['TampilkanKop'];
            }
            if($format=="PDF"){
                //koneksi dan error
                $FileName= "Referensi_Fitur_Akses";
                //Config Plugin MPDF
                require_once '../../vendor/autoload.php';
                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'A4']);
                $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
                ob_start(); 
            }else{
                if($format=="Excel"){
                    header("Content-type: application/vnd-ms-excel");
                    header("Content-Disposition: attachment; filename=Referensi_Fitur_Akses.xls");
                }
            }
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses_ref"));
?>
    <html>
        <head>
            <title>Referensi Fitur Akses</title>
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
                        <td align="center" colspan="4">
                            <h3><b><?php echo "$NamaFaskes";?></b></h3>
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
                    <td align="center"><b>FITUR</b></td>
                    <td align="center"><b>KETERANGAN</b></td>
                    <td align="center"><b>KODE</b></td>
                </tr>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="5" class="text-center">';
                        echo '      Belum Ada Data Referensi Fitur Akses';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no=1;
                        //Tampilkan Data
                        $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM akses_ref ORDER BY kategori ASC");
                        while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                            $kategori= $DataKategori['kategori'];
                            echo '  <tr>';
                            echo '      <td align="center"><b>'.$no.'</b></td>';
                            echo '      <td colspan="3"><b>'.$kategori.'</b></td>';
                            echo '  </tr>';
                            //Buka Data Referensi
                            $no2=1;
                            $QryFitur = mysqli_query($Conn, "SELECT * FROM akses_ref WHERE kategori='$kategori' ORDER BY kategori ASC");
                            while ($DataFitur = mysqli_fetch_array($QryFitur)) {
                                $nama_fitur= $DataFitur['nama_fitur'];
                                $kode= $DataFitur['kode'];
                                $keterangan= $DataFitur['keterangan'];
                                echo '  <tr>';
                                echo '      <td align="right"></td>';
                                echo '      <td>'.$no.'.'.$no2.' '.$nama_fitur.'</td>';
                                echo '      <td>'.$keterangan.'</td>';
                                echo '      <td>'.$kode.'</td>';
                                echo '  </tr>';
                                $no2++;
                            }
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
?>