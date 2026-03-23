<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/SettingCetakLabel.php";
?>
    <html>
        <Header>
            <title>Cetak Label</title>
            <style type="text/css">
                body{
                    font-family: <?php echo $NamaFontSettingLabel;?>;
                    color: <?php echo "$WarnaFontSettingLabel";?>;
                    font-size: <?php echo "$UkuranFontSettingLabel";?>;
                }
                div.card{
                    border: 1px solid #999;
                    width: <?php echo "$PanjangSettingLabel$SatuanSettingLabel";?>;
                    height: <?php echo "$LebarSettingLabel$SatuanSettingLabel";?>;
                }
                table.inside{
                    margin-top: <?php echo "$MarginAtasSettingLabel$SatuanSettingLabel";?>;
                    margin-bottom: <?php echo "$MarginBawahLabel$SatuanSettingLabel";?>;
                    margin-left: <?php echo "$MarginKiriLabel$SatuanSettingLabel";?>;
                    margin-right: <?php echo "$MarginKananLabel$SatuanSettingLabel";?>;
                    font-size: <?php echo "$UkuranFontSettingLabel";?>;
                }
                table tr td{
                    font-size: <?php echo "$UkuranFontSettingLabel";?>;
                }
            </style>
        </Header>
        <body>
            <div class="card">
                <table width="100%" class="inside">
                    <?php
                        echo '<tr>';
                        echo '  <td align="center">';
                        echo '      <img src="../../assets/Barcode/Barcode.php?size='.$UkuranBarcodeLabel.'&text=123000120101"/>';
                        echo ' </td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '  <td align="center">';
                        if($KodeObatLabel=="Ya"){
                            echo '123000120101<br>';
                        }
                        if($NamaObatLabel=="Ya"){
                            echo 'Asamafenamat<br>';
                        }
                        if($HargaObatLabel=="Ya"){
                            echo 'Rp 12.500';
                        }
                        echo ' </td>';
                        echo '</tr>';
                    ?>
                </table>
            </div>
        </body>
    </html>
