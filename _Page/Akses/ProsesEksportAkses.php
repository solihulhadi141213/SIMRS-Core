<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/SimrsFunction.php";
        if(empty($_POST['format_eksport_akses'])){
            echo "Format Data Tidak Boleh Kosong!";
        }else{
            $format=$_POST['format_eksport_akses'];
            if(empty($_POST['TampilkanKop'])){
                $TampilkanKop="No";
            }else{
                $TampilkanKop=$_POST['TampilkanKop'];
            }
            if($format=="PDF"){
                //koneksi dan error
                $FileName= "DataAkses";
                //Config Plugin MPDF
                require_once '../../vendor/autoload.php';
                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'A4']);
                $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
                ob_start(); 
            }else{
                if($format=="Excel"){
                    header("Content-type: application/vnd-ms-excel");
                    header("Content-Disposition: attachment; filename=DataAkses.xls");
                }
            }
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akses"));
?>
    <html>
        <head>
            <title>Data Akses</title>
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
                    <td align="center"><b>ID AKSES</b></td>
                    <td align="center"><b>TANGGAL</b></td>
                    <td align="center"><b>NAMA</b></td>
                    <td align="center"><b>EMAIL</b></td>
                    <td align="center"><b>KONTAK</b></td>
                    <td align="center"><b>PASSWORD</b></td>
                    <td align="center"><b>AKSES</b></td>
                    <td align="center"><b>FOTO</b></td>
                    <td align="center"><b>UPDATETIME</b></td>
                </tr>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="10" class="text-center">';
                        echo '      Belum Ada Data Akses';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no=1;
                        //Tampilkan Data
                        $Qry = mysqli_query($Conn, "SELECT * FROM akses");
                        while ($data = mysqli_fetch_array($Qry)) {
                            $id_akses= $data['id_akses'];
                            $tanggal= $data['tanggal'];
                            $nama= $data['nama'];
                            $email= $data['email'];
                            $kontak= $data['kontak'];
                            $password= $data['password'];
                            $akses= $data['akses'];
                            $gambar= $data['gambar'];
                            $updatetime= $data['updatetime'];
                            echo '  <tr>';
                            echo '      <td align="center">'.$no.'</td>';
                            echo '      <td>'.$id_akses.'</td>';
                            echo '      <td>'.$tanggal.'</td>';
                            echo '      <td>'.$nama.'</td>';
                            echo '      <td>'.$email.'</td>';
                            echo '      <td>'.$kontak.'</td>';
                            echo '      <td>'.$password.'</td>';
                            echo '      <td>'.$akses.'</td>';
                            echo '      <td>'.$gambar.'</td>';
                            echo '      <td>'.$updatetime.'</td>';
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
?>