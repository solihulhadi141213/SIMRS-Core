<?php
    if(empty($_GET['id_obat'])){
        echo "Error: ID Obat tidak ditemukan";
    }else{
        //Koneksi
        date_default_timezone_set('Asia/Jakarta');
        include "../../_Config/Connection.php";
        include "../../_Config/Session.php";
        include "../../_Config/Setting.php";
        include "../../_Config/SettingFaskes.php";
        include "../../_Config/SettingCetakLabel.php";
        $id_obat= $_GET['id_obat'];
        //Buka data Pasien
        $QryObat = mysqli_query($Conn,"SELECT * FROM obat WHERE id_obat='$id_obat'")or die(mysqli_error($Conn));
        $DataObat = mysqli_fetch_array($QryObat);
        if(empty($DataObat['id_obat'])){
            echo "Error: Data Obbat tidak ditemukan";
        }else{
            $KodeObat= $DataObat['kode'];
            $NamaObat= $DataObat['nama_obat'];
            $harga_2= $DataObat['harga_2'];
            if($SatuanSettingLabel=="mm"){
                $PanjangSettingLabel=$PanjangSettingLabel;
                $LebarSettingLabel=$LebarSettingLabel;
            }else{
                if($SatuanSettingLabel=="cm"){
                    $PanjangSettingLabel=$PanjangSettingLabel*10;
                    $LebarSettingLabel=$LebarSettingLabel*10;
                }else{
                    if($SatuanSettingLabel=="inc"){
                        $PanjangSettingLabel=$PanjangSettingLabel*25.4;
                        $LebarSettingLabel=$LebarSettingLabel*25.4;
                    }else{
                        $PanjangSettingLabel=$PanjangSettingLabel;
                        $LebarSettingLabel=$LebarSettingLabel;
                    }
                }
            }
            //Format RP
            $harga_2=number_format($harga_2,0,',','.');
            //koneksi dan error
            $FileName= "Label-$KodeObat";
            //Config Plugin MPDF
            require_once '../../vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [$PanjangSettingLabel, $LebarSettingLabel]]);
            // $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
            //Beginning Buffer to save PHP variables and HTML tags
            ob_start(); 
            
?>
    <html>
        <Header>
            <title>Cetak Kartu</title>
            <style type="text/css">
                @page {
                    margin-top: <?php echo "$MarginAtasSettingLabel$SatuanSettingLabel"; ?>;
                    margin-bottom: <?php echo "$MarginBawahLabel$SatuanSettingLabel"; ?>;
                    margin-left: <?php echo "$MarginKiriLabel$SatuanSettingLabel"; ?>;
                    margin-right: <?php echo "$MarginKananLabel$SatuanSettingLabel"; ?>;
                }
                body{
                    font-family: <?php echo $NamaFontSettingLabel;?>;
                    color: <?php echo "$WarnaFontSettingLabel";?>;
                    font-size: <?php echo "$UkuranFontSettingLabel";?>;
                }
                table tr td.bordertop{
                    border-top: 1px solid #999;
                }
                table tr td.borderbottom{
                    border-bottom: 1px solid #999;
                }
            </style>
        </Header>
        <body>
            <table width="100%">
                <tr>
                    <?php
                        echo ' <td align="center">';
                        echo '      <img src="../../assets/Barcode/Barcode.php?size='.$UkuranBarcodeLabel.'&text='.$KodeObat.'"/><br>';
                        if($KodeObatLabel=="Ya"){
                            echo ''.$KodeObat.'<br>';
                        }
                        if($NamaObatLabel=="Ya"){
                            echo ''.$NamaObat.'<br>';
                        }
                        if($HargaObatLabel=="Ya"){
                            echo 'Rp '.$harga_2.'<br>';
                        }
                        echo ' </td>';
                    ?>
                </tr>
            </table>
        </body>
    </html>
<?php 
        $html = ob_get_contents();
        ob_end_clean();
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output($FileName.".pdf" ,'I');
        exit;
    }
} 
?>