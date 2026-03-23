<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_laboratorium_sample'])){
        echo "Error: ID Spesimen tidak ditemukan";
    }else{
        //Tangkap Setting
        if(empty($_POST['nama_font'])){
            $nama_font="";
        }else{
            $nama_font=$_POST['nama_font'];
        }
        if(empty($_POST['ukuran_font'])){
            $ukuran_font="";
        }else{
            $ukuran_font=$_POST['ukuran_font'];
        }
        if(empty($_POST['warna_font'])){
            $warna_font="";
        }else{
            $warna_font=$_POST['warna_font'];
        }
        if(empty($_POST['satuan'])){
            $satuan="";
        }else{
            $satuan=$_POST['satuan'];
        }
        if(empty($_POST['margin'])){
            $margin="";
        }else{
            $margin=$_POST['margin'];
        }
        if(empty($_POST['padding'])){
            $padding="";
        }else{
            $padding=$_POST['padding'];
        }
        if(empty($_POST['panjang_x'])){
            $panjang_x="";
        }else{
            $panjang_x=$_POST['panjang_x'];
        }
        if(empty($_POST['lebar_y'])){
            $lebar_y="";
        }else{
            $lebar_y=$_POST['lebar_y'];
        }
        if(empty($_POST['tampilkan_barcode'])){
            $tampilkan_barcode="";
        }else{
            $tampilkan_barcode=$_POST['tampilkan_barcode'];
        }
        if(empty($_POST['format'])){
            $format_cetak="";
        }else{
            $format_cetak=$_POST['format'];
        }
        if(empty($_POST['SimpanPengaturan'])){
            $SimpanPengaturan="";
        }else{
            $SimpanPengaturan=$_POST['SimpanPengaturan'];
            if($SimpanPengaturan=="Simpan"){
                $nama_font_save=saveSettingDinamis($Conn,$SessionIdAkses,'Laboratorium','nama_font',$nama_font);
                $ukuran_font_save=saveSettingDinamis($Conn,$SessionIdAkses,'Laboratorium','ukuran_font',$ukuran_font);
                $warna_font_save=saveSettingDinamis($Conn,$SessionIdAkses,'Laboratorium','warna_font',$warna_font);
                $satuan_save=saveSettingDinamis($Conn,$SessionIdAkses,'Laboratorium','satuan',$satuan);
                $panjang_x_save=saveSettingDinamis($Conn,$SessionIdAkses,'Laboratorium','panjang_x',$panjang_x);
                $lebar_y_save=saveSettingDinamis($Conn,$SessionIdAkses,'Laboratorium','lebar_y',$lebar_y);
                $margin_save=saveSettingDinamis($Conn,$SessionIdAkses,'Laboratorium','margin',$margin);
                $padding_save=saveSettingDinamis($Conn,$SessionIdAkses,'Laboratorium','padding',$padding);
                $tampilkan_barcode_save=saveSettingDinamis($Conn,$SessionIdAkses,'Laboratorium','tampilkan_barcode',$tampilkan_barcode);
                $format_save=saveSettingDinamis($Conn,$SessionIdAkses,'Laboratorium','format',$format_cetak);
            }
        }
        //buka Lab
        $id_laboratorium_sample= $_POST['id_laboratorium_sample'];
        $id_lab=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'id_lab');
        $id_permintaan=getDataDetail($Conn,'laboratorium_pemeriksaan','id_lab',$id_lab,'id_permintaan');
        $id_pasien=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'id_pasien');
        $nama_pasien=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'nama_pasien');
        $sumber=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'sumber');
        //Format
        if($format_cetak=="PDF"){
            //koneksi dan error
            $FileName= "Label";
            //Config Plugin MPDF
            require_once '../../vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [$panjang_x, $lebar_y]]);
            // $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
            //Beginning Buffer to save PHP variables and HTML tags
            ob_start(); 
        }

?>
    <html>
        <Header>
            <title>Cetak Label</title>
            <style type="text/css">
                @page {
                    margin-top: <?php echo "$margin$satuan"; ?>;
                    margin-bottom: <?php echo "$margin$satuan"; ?>;
                    margin-left: <?php echo "$margin$satuan"; ?>;
                    margin-right: <?php echo "$margin$satuan"; ?>;
                }
                body{
                    font-family: <?php echo "$nama_font"; ?>;
                    color: <?php echo "$warna_font"; ?>;
                    padding: <?php echo "$padding$satuan"; ?>;
                } 
                table{
                    font-size: <?php echo "$ukuran_font"; ?>;
                }
            </style>
        </Header>
        <body>
            <table>
                <tr>
                    <td colspan="3" align="left">
                        <?php
                            if($tampilkan_barcode=="Ya"){
                                echo '<img src="../../assets/Barcode/Barcode.php?size=30&text='.$id_laboratorium_sample.'"/>';
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>ID.Lab</td>
                    <td>:</td>
                    <td><?php echo "$id_lab"; ?></td>
                </tr>
                <tr>
                    <td>ID.Spesimen</td>
                    <td>:</td>
                    <td><?php echo "$id_laboratorium_sample-$sumber"; ?></td>
                </tr>
                <tr>
                    <td>No.RM</td>
                    <td>:</td>
                    <td><?php echo "$id_pasien-$nama_pasien"; ?></td>
                </tr>
            </table>
        </body>
    </html>
<?php 
        if($format_cetak=="PDF"){
            $html = ob_get_contents();
            ob_end_clean();
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output($FileName.".pdf" ,'I');
            exit; 
        }
    }
?>