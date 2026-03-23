<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['tanggal'])){
        echo 'Tanggal Stok Opename Tidak Boleh Kosong!';
    }else{
        if(empty($_POST['format'])){
            echo 'Format Export Tidak Boleh Kosong!';
        }else{
            if(empty($_POST['id_obat_storage'])){
                $id_obat_storage="0";
            }else{
                $id_obat_storage=$_POST['id_obat_storage'];
            }
            $tanggal=$_POST['tanggal'];
            $format=$_POST['format'];
            $strtotime=strtotime($tanggal);
            $Tanggal=date('d/m/Y H:i:s T',$strtotime);
            //Buka Nama Penyimpanan
            if(empty($_POST['id_obat_storage'])){
                $nama_penyimpanan="Penyimpanan Utama";
            }else{
                $id_obat_storage=$_POST['id_obat_storage'];
                $QryStorage = mysqli_query($Conn,"SELECT * FROM obat_storage WHERE id_obat_storage='$id_obat_storage'")or die(mysqli_error($Conn));
                $DataStorage = mysqli_fetch_array($QryStorage);
                if(empty($DataStorage['nama_penyimpanan'])){
                    $nama_penyimpanan="None";
                }else{
                    $nama_penyimpanan= $DataStorage['nama_penyimpanan'];
                }
            }
            if($format=="PDF"){
                //koneksi dan error
                $FileName= "Stok-Opename-$tanggal";
                //Config Plugin MPDF
                require_once '../../vendor/autoload.php';
                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'A4']);
                $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
                //Beginning Buffer to save PHP variables and HTML tags
                ob_start(); 
            }
            if($format=="Excel"){
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=Stok-Opename-$tanggal.xls");
            }
?>
    <html>
        <head>
            <title>Data Stok Opename</title>
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
                    </td>
                </tr>
            </table>
            <br>
            <table class="Kop" width="100%">
                <tr>
                    <td align="left" colspan="11">
                        <?php echo "DATA STOK OPENAME :  $Tanggal ";?><br>
                        <?php echo "PENGIMPANAN :  $nama_penyimpanan ";?>
                    </td>
                </tr>
            </table>
            <br>
            <table class="data" width="100%" celspacing="0">
                <tr>
                    <td align="center"><b>No</b></td>
                    <td align="center"><b>Kode</b></td>
                    <td align="center"><b>Nama</b></td>
                    <td align="center"><b>Satuan</b></td>
                    <td align="center"><b>Harga</b></td>
                    <td align="center"><b>Stok Awal</b></td>
                    <td align="center"><b>Stok Akhir</b></td>
                    <td align="center"><b>Selisih</b></td>
                    <td align="center"><b>Keterangan</b></td>
                    <td align="center"><b>Updatetime</b></td>
                </tr>
                <?php
                    $no=1;
                    //Routing berdasarkan 
                    $query = mysqli_query($Conn, "SELECT*FROM obat_so WHERE tanggal='$tanggal' AND id_obat_storage='$id_obat_storage' ORDER BY nama ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $nama_penyimpanan= $data['nama_penyimpanan'];
                        $kode= $data['kode'];
                        $nama= $data['nama'];
                        $satuan= $data['satuan'];
                        $harga= $data['harga'];
                        $stok_awal= $data['stok_awal'];
                        $stok_akhir= $data['stok_akhir'];
                        $stok_selisih= $data['stok_selisih'];
                        $keterangan= $data['keterangan'];
                        $updatetime= $data['updatetime'];
                        //Format Tanggal
                        $strtotime=strtotime($updatetime);
                        $updatetime=date('d/m/Y H:i T');
                        echo '  <tr>';
                        echo '      <td>'.$no.'</td>';
                        echo '      <td>'.$kode.'</td>';
                        echo '      <td>'.$nama.'</td>';
                        echo '      <td>'.$satuan.'</td>';
                        echo '      <td>'.$harga.'</td>';
                        echo '      <td>'.$stok_awal.'</td>';
                        echo '      <td>'.$stok_akhir.'</td>';
                        echo '      <td>'.$stok_selisih.'</td>';
                        echo '      <td>'.$keterangan.'</td>';
                        echo '      <td>'.$updatetime.'</td>';
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
?>