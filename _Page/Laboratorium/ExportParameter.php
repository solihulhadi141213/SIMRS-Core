<?php
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingFaskes.php";
    if(empty($_POST['FormatExportParameter'])){
        $FormatExportParameter="";
    }else{
        $FormatExportParameter=$_POST['FormatExportParameter'];
    }
    if(empty($_POST['HeaderKop'])){
        $HeaderKop="";
    }else{
        $HeaderKop=$_POST['HeaderKop'];
    }
    if($FormatExportParameter=="Excel"){
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=parameter_lab.xls");
    }
?>
<html>
    <head>
        <title>Data Parameter Lab</title>
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
        <?php if($HeaderKop=="Tampilkan"){?>
        <table class="Kop" width="100%">
            <tr>
                <td align="center" colspan="11">
                    <h3><b><?php echo "$NamaFaskes";?></b></h3>
                    <?php echo "$AlamatFaskes";?><br>
                    <?php echo "No.Kontak : $KontakFaskes";?><br>
                    <?php echo "Email : $EmailFaskes";?><br>
                    <b><?php echo "DATA PARAMETER PEMERIKSAAN LABORATORIUM";?></b>
                </td>
            </tr>
        </table>
        <br>
        <?php } ?>
        <table class="data" width="100%" celspacing="0">
            <tr>
                <td align="center"><b>No</b></td>
                <td align="center"><b>Kategori</b></td>
                <td align="center"><b>Nama Parameter</b></td>
                <td align="center"><b>Tipe Data</b></td>
                <td align="center"><b>Satuan</b></td>
                <td align="center"><b>Nilai Rujukan</b></td>
                <td align="center"><b>Nilai Kritis</b></td>
                <td align="center"><b>Alternatif</b></td>
            </tr>
            <?php
                $NoKategori=1;
                $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori_parameter FROM laboratorium_parameter ORDER BY kategori_parameter ASC");
                while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                    $kategori_parameter= $DataKategori['kategori_parameter'];
                    echo '  <tr>';
                    echo '      <td><b>'.$NoKategori.'</b></td>';
                    echo '      <td colspan="7"><b>'.$kategori_parameter.'</b></td>';
                    echo '  </tr>';
                    //Buka Parameter
                    $NoParameter=1;
                    $QryParameter = mysqli_query($Conn, "SELECT * FROM laboratorium_parameter WHERE kategori_parameter='$kategori_parameter' ORDER BY parameter ASC");
                    while ($DataParameter = mysqli_fetch_array($QryParameter)) {
                        $parameter= $DataParameter['parameter'];
                        $tipe_data= $DataParameter['tipe_data'];
                        $alternatif= $DataParameter['alternatif'];
                        $nilai_rujukan= $DataParameter['nilai_rujukan'];
                        $nilai_kritis= $DataParameter['nilai_kritis'];
                        $satuan= $DataParameter['satuan'];
                        $keterangan= $DataParameter['keterangan'];
                        echo '  <tr>';
                        echo '      <td></td>';
                        echo '      <td>'.$NoKategori.'.'.$NoParameter.'</td>';
                        echo '      <td>'.$parameter.'</td>';
                        echo '      <td>'.$tipe_data.'</td>';
                        echo '      <td>'.$satuan.'</td>';
                        echo '      <td>'.$nilai_rujukan.'</td>';
                        echo '      <td>'.$nilai_kritis.'</td>';
                        echo '      <td>';
                        if(!empty($alternatif)){
                            $ambil_json =json_decode($alternatif, true);
                            $string=count($ambil_json);
                            for($i=0; $i<$string; $i++){
                                $ListAlternatif=$ambil_json[$i]['alternatif'];
                                echo "$ListAlternatif,";
                            }
                        }
                        echo '      </td>';
                        echo '  </tr>';
                        $NoParameter++;
                    }
                    $NoKategori++;
                }
            ?>
        </table>
    </body>
</html>