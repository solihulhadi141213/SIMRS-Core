<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/SettingCetakLabel.php";
    if(empty($_POST['id_obat'])){
        echo "Tidak Ada Data Obat Yang Dipilih";
    }else{
        if(empty($_POST['format_barcode'])){
            echo "Tidak Ada Format Yang Dipilih";
        }else{
            if(empty($_POST['tampilkan_harga'])){
                echo "Tidak ada informasi konfirmasi cetak harga";
            }else{
                $id_obat=$_POST['id_obat'];
                $format_barcode=$_POST['format_barcode'];
                $tampilkan_harga=$_POST['tampilkan_harga'];
                if($format_barcode=="PDF"){
                    $FileName= "LabelParsial";
                    //Config Plugin MPDF
                    $FileName= "Label";
                    //Config Plugin MPDF
                    require_once '../../vendor/autoload.php';
                    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [58, 24]]);
                    // $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
                    //Beginning Buffer to save PHP variables and HTML tags
                    ob_start(); 
                }
?>
<html>
    <Header>
        <title>Cetak Barcode</title>
        <style type="text/css">
            @page {
                margin-top: <?php echo "$MarginAtasSettingLabel"; ?>;
                margin-bottom: <?php echo "$MarginBawahLabel"; ?>;
                margin-left: <?php echo "$MarginKiriLabel"; ?>;
                margin-right: <?php echo "$MarginKananLabel"; ?>;
            }
            body{
                font-family: <?php echo $NamaFontSettingLabel;?>;
                color: <?php echo "$WarnaFontSettingLabel";?>;
                font-size: <?php echo "$UkuranFontSettingLabel";?>;
            }
            table.Data tr td{
                border: 1px solid #999;
            }
            table tr td.borderbottom{
                border-bottom: 1px solid #999;
            }
        </style>
    </Header>
    <body>
        
                <?php
                    $JumlahIdObat=count($id_obat);
                    $no=1;
                    for($x=0; $x<$JumlahIdObat; $x++){
                        $IdObat=$id_obat[$x];
                        $QryObat = mysqli_query($Conn,"SELECT * FROM obat WHERE id_obat='$IdObat'")or die(mysqli_error($Conn));
                        $DataObat = mysqli_fetch_array($QryObat);
                        $KodeObat=$DataObat['kode'];
                        $NamaObat=$DataObat['nama'];
                        $kategori_list=$DataObat['kategori'];
                        $satuan_list=$DataObat['satuan'];
                        $stok_min=$DataObat['stok_min'];
                        $harga_2=$DataObat['harga'];
                        echo '<table width="100%">';
                        echo '  <tr>';
                        echo '      <td align="center">';
                        echo '          <img src="../../assets/Barcode/Barcode.php?size='.$UkuranBarcodeLabel.'&text='.$KodeObat.'"/><br>';
                        if($KodeObatLabel=="Ya"){
                            echo ''.$KodeObat.'<br>';
                        }
                        if($NamaObatLabel=="Ya"){
                            echo ''.$NamaObat.'<br>';
                        }
                        if($tampilkan_harga=="Ya"){
                            echo 'Rp '.$harga_2.'<br>';
                        }
                        echo '      </td>';
                        echo '  </tr>';
                        echo '</table>';
                    }
                ?>
    </body>
</html>
<?php 
            if($format_barcode=="PDF"){
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