<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/SettingCetakKartuPasien.php";
?>
    <html>
        <Header>
            <title>Cetak Antrian</title>
            <style type="text/css">
                body{
                    font-family: <?php echo $NamaFornSettingKartuPasien;?>;
                    color: <?php echo "$WarnaFornSettingKartuPasien";?>;
                    font-size: <?php echo "$UkuranFornSettingKartuPasien";?>;
                }
                div.card{
                    border: 1px solid #999;
                    width: <?php echo "$PanjangSettingKartuPasien";?>;
                    height: <?php echo "$LebarSettingKartuPasien";?>;
                }
                div.inside{
                    margin-top: <?php echo "$MarginAtasSettingKartuPasien";?>;
                    margin-bottom: <?php echo "$MarginBawahKartuPasien";?>;
                    margin-left: <?php echo "$MarginKiriKartuPasien";?>;
                    margin-right: <?php echo "$MarginKananKartuPasien";?>;
                    font-size: <?php echo "$UkuranFornSettingKartuPasien";?>;
                }
                table tr td{
                    padding: 4px;
                    font-size: <?php echo "$UkuranFornSettingKartuPasien";?>;
                }
                table tr td.bordertop{
                    border-top: 1px solid #999;
                    font-size: <?php echo "$UkuranFornSettingKartuPasien";?>;
                }
                table tr td.borderbottom{
                    border-bottom: 1px solid #999;
                    font-size: <?php echo "$UkuranFornSettingKartuPasien";?>;
                }
            </style>
        </Header>
        <body>
            <div class="card">
                <div class="inside">
                    <table width="100%">
                        <tr>
                            <td align="center" class="borderbottom">
                                <?php
                                    if($LogoKartuPasien=="Ya"){
                                        echo '<img src="../../assets/images/'.$logo.'" width="'.$PanjangLogoKartuPasien.'" heigth="'.$LebarLogoKartuPasien.'"></img><br>';
                                    }
                                ?>
                                <b><?php echo "$NamaFaskes";?></b><br>
                                <i><?php echo "$AlamatFaskes";?></i><br>
                            </td>
                        </tr>
                        <tr>
                            <?php
                                if($BarcodeKartuPasien=="Ya"){
                                    echo ' <td align="center">';
                                    echo '      <img src="../../assets/Barcode/Barcode.php?size='.$UkuranBarcodeKartuPasien.'&text=123000120101"/>';
                                    echo ' </td>';
                                }
                            ?>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <?php
                                if($FotoKartuPasien=="Ya"){
                                    echo ' <td rowspan="4" valign="top">';
                                    echo '      <img src="../../assets/images/avatar-1.jpg" width="'.$PanjangFotoKartuPasien.'" heigth="'.$LebarFotoKartuPasien.'"></img>';
                                    echo ' </td>';
                                }
                            ?>
                            <td><b>No.RM</b></td>
                            <td><b>:</b></td>
                            <td>123000120101</td>
                        </tr>
                        <tr>
                            <td><b>Nik</b></td>
                            <td><b>:</b></td>
                            <td>31211110000001</td>
                        </tr>
                        <tr>
                            <td><b>Nama</dt></td>
                            <td><b>:</dt></td>
                            <td>Anonimous</td>
                        </tr>
                        <tr>
                            <td valign="top"><b>Alamat</dt></td>
                            <td valign="top"><b>:</dt></td>
                            <td valign="top">Jalan Anggrek 4 no 15 perumnas ciporang. Kabupaten Kuningan 45514</td>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <?php
                                if($KutipanBawahKartuPasien=="Ya"){
                                    echo ' <td align="center" class="bordertop">';
                                    echo '      <i>'.$IsiKutipanKartuPasien.'</i>';
                                    echo ' </td>';
                                }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
        </body>
    </html>
