<?php
    if(empty($_GET['id_pasien'])){
        echo "Error: ID Pasien tidak ditemukan";
    }else{
        //Koneksi
        date_default_timezone_set('Asia/Jakarta');
        include "../../_Config/Connection.php";
        include "../../_Config/Session.php";
        include "../../_Config/Setting.php";
        include "../../_Config/SettingFaskes.php";
        include "../../_Config/SettingCetakKartuPasien.php";
        $id_pasien= $_GET['id_pasien'];
        //Buka data Pasien
        $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$id_pasien'")or die(mysqli_error($Conn));
        $DataPasien = mysqli_fetch_array($QryPasien);
        if(empty($DataPasien['id_pasien'])){
            echo "Error: Data Pasien tidak ditemukan";
        }else{
            $noRm=sprintf("%07d", $id_pasien);
            $tanggal_daftar= $DataPasien['tanggal_daftar'];
            $nik= $DataPasien['nik'];
            $no_bpjs= $DataPasien['no_bpjs'];
            $nama= $DataPasien['nama'];
            $gender= $DataPasien['gender'];
            $tempat_lahir= $DataPasien['tempat_lahir'];
            $tanggal_lahir= $DataPasien['tanggal_lahir'];
            $propinsi= $DataPasien['propinsi'];
            $kabupaten= $DataPasien['kabupaten'];
            $kecamatan= $DataPasien['kecamatan'];
            $desa= $DataPasien['desa'];
            $alamat= $DataPasien['alamat'];
            $kontak= $DataPasien['kontak'];
            $kontak_darurat= $DataPasien['kontak_darurat'];
            $penanggungjawab= $DataPasien['penanggungjawab'];
            $golongan_darah= $DataPasien['golongan_darah'];
            $perkawinan= $DataPasien['perkawinan'];
            $pekerjaan= $DataPasien['pekerjaan'];
            $status= $DataPasien['status'];
            $gambar= $DataPasien['gambar'];
            $updatetime= $DataPasien['updatetime'];
            //koneksi dan error
            $FileName= "Kartu-Pasien-$noRm";
            //Config Plugin MPDF
            define('_MPDF_PATH','../../assets/mpdf60/');
            include(_MPDF_PATH . "mpdf.php");
            $mpdf=new mPDF('utf-8', array($PanjangSettingKartuPasien,$LebarSettingKartuPasien)); 
            $html='<style>@page *{margin-top: '.$MarginAtasSettingKartuPasien.';margin-bottom: '.$MarginBawahKartuPasien.';margin-left: '.$MarginKiriKartuPasien.';margin-right: '.$MarginKananKartuPasien.';}</style>'; 
            //Beginning Buffer to save PHP variables and HTML tags
            ob_start(); 
?>
    <html>
        <Header>
            <title>Cetak Kartu</title>
            <style type="text/css">
                @page {
                    margin-top: <?php echo "$MarginAtasSettingKartuPasien"; ?>;
                    margin-bottom: <?php echo "$MarginBawahKartuPasien"; ?>;
                    margin-left: <?php echo "$MarginKiriKartuPasien"; ?>;
                    margin-right: <?php echo "$MarginKananKartuPasien"; ?>;
                }
                body{
                    font-family: <?php echo $NamaFornSettingKartuPasien;?>;
                    color: <?php echo "$WarnaFornSettingKartuPasien";?>;
                    font-size: <?php echo "$UkuranFornSettingKartuPasien";?>;
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
                        echo '      <img src="../../assets/Barcode/Barcode.php?size='.$UkuranBarcodeKartuPasien.'&text='.$id_pasien.'"/>';
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
                <td><?php echo "$id_pasien";?></td>
            </tr>
            <tr>
                <td><b>Nik</b></td>
                <td><b>:</b></td>
                <td><?php echo "$nik";?></td>
            </tr>
            <tr>
                <td><b>Nama</dt></td>
                <td><b>:</dt></td>
                <td><?php echo "$nama";?></td>
            </tr>
            <tr>
                <td valign="top"><b>Alamat</dt></td>
                <td valign="top"><b>:</dt></td>
                <td valign="top"><?php echo "$alamat";?></td>
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