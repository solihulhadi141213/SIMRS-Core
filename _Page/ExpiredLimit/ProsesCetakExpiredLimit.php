<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $sekarang=date('Y-m-d');
    if(empty($_POST['FormatCetak'])){
        echo 'Format Cetak Tidak Boleh Kosong!';
    }else{
        if(empty($_POST['TampilkanHeader'])){
            echo 'Informasi Tampilkan Header Tidak Boleh Kosong!';
        }else{
            if(empty($_POST['KategoriData'])){
                echo 'Kategori Data Tidak Boleh Kosong!';
            }else{
                $TampilkanHeader=$_POST['TampilkanHeader'];
                $FormatCetak=$_POST['FormatCetak'];
                $KategoriData=$_POST['KategoriData'];
                //Routing Nama File
                if($KategoriData=="ExpiredItem"){
                    $NamaFile="Expired-Item-$sekarang";
                }else{
                    $NamaFile="Limit-Item-$sekarang";
                }
                if($FormatCetak=="PDF"){
                    //koneksi dan error
                    $FileName= "$NamaFile";
                    //Config Plugin MPDF
                    require_once '../../vendor/autoload.php';
                    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'A4']);
                    $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
                    //Beginning Buffer to save PHP variables and HTML tags
                    ob_start(); 
                }
                if($FormatCetak=="Excel"){
                    header("Content-type: application/vnd-ms-excel");
                    header("Content-Disposition: attachment; filename=$NamaFile.xls");
                }
?>
    <html>
        <Header>
            <title>Expired Item</title>
            <link rel="icon" href="../../assets/images/<?php echo "$favicon"; ?>" type="image/x-icon">
            <style type="text/css">
                @page {
                    margin-top: 1cm;
                    margin-bottom: 1cm;
                    margin-left: 1cm;
                    margin-right: 1cm;
                }
                body {
                    background-color: #FFF;
                    font-family: Arial;
                }
                table.data tr td {
                    border: none;
                    color: #000;
                    border-spacing: 0px;
                    padding: 2px;
                    border-spacing: 0px;
                }
                table.kop_surat tr td {
                    border: none;
                    color: #000;
                }
                table.kop_surat3 tr td {
                    border: none;
                    color: #000;
                }
                table.border {
                    border-spacing: 0px;
                }
                table.border tr td {
                    border: 1px solid #000;
                    color: #000;
                    border-spacing: 0px;
                    padding: 2px;
                }
                .logo {
                    width: 50px;
                    height: 50px;
                    
                }
                div.kop{
                    border-bottom: 2px groove #000;
                    color: #000;
                }
                div.kop2{
                    border-bottom: 2px groove #000;
                    color: #000;
                }
                div.kop3{
                    border-bottom: 2px groove #000;
                    color: #000;
                }
                .f8{
                    font-size: 8px;
                }
                .f9{
                    font-size: 9px;
                }
                .f10{
                    font-size: 10px;
                }
                .f11{
                    font-size: 11px;
                }
                .f12{
                    font-size: 12px;
                }
                .f13{
                    font-size: 13px;
                }
                .f14{
                    font-size: 14px;
                }
                .f15{
                    font-size: 15px;
                }
                .f16{
                    font-size: 16px;
                }
            </style>
        </Header>
        <body>
            <?php if($TampilkanHeader=="Ya"){ ?>
                <div class="kop3">
                    <table class="kop_surat3" width="100%">
                        <tr>
                            <td valign="top">
                                <?php 
                                    echo '<b>'.$NamaFaskes.'</b><br>'; 
                                    echo ''.$AlamatFaskes.'<br>'; 
                                    echo 'Kontak : '.$KontakFaskes.'<br>'; 
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
            <div class="kop">
                <table class="data" cellspacing="0px" width="100%">
                    <tr>
                        <?php
                            //Routing Header Table
                            if($KategoriData=="ExpiredItem"){
                                echo '<td align="center"><b>No</b></td>';
                                echo '<td align="center"><b>Kode Batch</b></td>';
                                echo '<td align="center"><b>Kode Item</b></td>';
                                echo '<td align="center"><b>Nama/Merek</b></td>';
                                echo '<td align="center"><b>Kategori</b></td>';
                                echo '<td align="center"><b>QTY</b></td>';
                                echo '<td align="center"><b>Satuan</b></td>';
                                echo '<td align="center"><b>Expired Date</b></td>';
                                echo '<td align="center"><b>Notifikasi</b></td>';
                                echo '<td align="center"><b>Status  Item</b></td>';
                                echo '<td align="center"><b>Status  Expired</b></td>';
                            }else{
                                echo '<td align="center"><b>No</b></td>';
                                echo '<td align="center"><b>Kode</b></td>';
                                echo '<td align="center"><b>Nama/Merek</b></td>';
                                echo '<td align="center"><b>Kelompok</b></td>';
                                echo '<td align="center"><b>Kategori</b></td>';
                                echo '<td align="center"><b>Satuan</b></td>';
                                echo '<td align="center"><b>Stok</b></td>';
                                echo '<td align="center"><b>Harga</b></td>';
                                echo '<td align="center"><b>Minimum</b></td>';
                                echo '<td align="center"><b>Keterangan</b></td>';
                                echo '<td align="center"><b>Tanggal</b></td>';
                                echo '<td align="center"><b>Updatetime</b></td>';
                            }
                        ?>
                    </tr>
                    <?php
                        $no=1;
                        //Routing Data
                        if($KategoriData=="ExpiredItem"){
                            $query = mysqli_query($Conn, "SELECT*FROM obat_expired ORDER BY id_obat_expired DESC");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_obat_expired= $data['id_obat_expired'];
                                $id_obat= $data['id_obat'];
                                $batch= $data['batch'];
                                $qty= $data['qty'];
                                $satuan= $data['satuan'];
                                $expired= $data['expired'];
                                $ingatkan= $data['ingatkan'];
                                $status= $data['status'];
                                $TanggalSekarang=date('Y-m-d');
                                if($TanggalSekarang>$expired){
                                    $StatusExp='Expired';
                                }else{
                                    if($ingatkan<$TanggalSekarang){
                                        $StatusExp='Almost';
                                    }else{
                                        $StatusExp='Safe';
                                    }
                                }
                                //Format Tanggal Expired
                                $ExpiredFormat=DateFormatDinamis($expired,'d/m/Y');
                                $IngatkanFormat=DateFormatDinamis($ingatkan,'d/m/Y');
                                //Buka Data Obat
                                $NamaObat=getDataDetail($Conn,'obat','id_obat',$id_obat,'nama');
                                $KodeObat=getDataDetail($Conn,'obat','id_obat',$id_obat,'kode');
                                $KategoriObat=getDataDetail($Conn,'obat','id_obat',$id_obat,'kategori');
                                //Tampilkan Data
                                echo '<tr>';
                                echo '  <td align="center">'.$no.'</td>';
                                echo '  <td align="left">'.$batch.'</td>';
                                echo '  <td align="left">'.$KodeObat.'</td>';
                                echo '  <td align="left">'.$NamaObat.'</td>';
                                echo '  <td align="left">'.$KategoriObat.'</td>';
                                echo '  <td align="left">'.$qty.'</td>';
                                echo '  <td align="left">'.$satuan.'</td>';
                                echo '  <td align="left">'.$ExpiredFormat.'</td>';
                                echo '  <td align="left">'.$IngatkanFormat.'</td>';
                                echo '  <td align="left">'.$status.'</td>';
                                echo '  <td align="left">'.$StatusExp.'</td>';
                                echo '</tr>';
                                $no++;
                            }
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM obat WHERE stok<stok_min ORDER BY id_obat DESC");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_obat= $data['id_obat'];
                                $kode= $data['kode'];
                                $nama_obat= $data['nama'];
                                $kelompok= $data['kelompok'];
                                $kategori= $data['kategori'];
                                $satuan= $data['satuan'];
                                $stok= $data['stok'];
                                $isi= $data['isi'];
                                $harga= $data['harga'];
                                $stok_min= $data['stok_min'];
                                $tanggal= $data['tanggal'];
                                $keterangan= $data['keterangan'];
                                $updatetime= $data['updatetime'];
                                //Update timestamp
                                $strtotime1=strtotime($tanggal);
                                $strtotime2=strtotime($updatetime);
                                $TanggalInput=date('d/m/Y H:i',$strtotime1);
                                $UpdateTime=date('d/m/Y H:i',$strtotime2);
                                //Format Harga
                                $HargaBeli = "Rp " . number_format($harga, 0, ',', '.');
                                //Tampilkan Data
                                echo '<tr>';
                                echo '  <td align="center">'.$no.'</td>';
                                echo '  <td align="left">'.$kode.'</td>';
                                echo '  <td align="left">'.$nama_obat.'</td>';
                                echo '  <td align="left">'.$kelompok.'</td>';
                                echo '  <td align="left">'.$kategori.'</td>';
                                echo '  <td align="left">'.$satuan.'</td>';
                                echo '  <td align="left">'.$stok.'</td>';
                                echo '  <td align="left">'.$HargaBeli.'</td>';
                                echo '  <td align="left">'.$stok_min.'</td>';
                                echo '  <td align="left">'.$keterangan.'</td>';
                                echo '  <td align="left">'.$TanggalInput.'</td>';
                                echo '  <td align="left">'.$UpdateTime.'</td>';
                                echo '</tr>';
                                $no++;
                            }
                        }
                    ?>
                </table>
            </div>
        </body>
    </html>
<?php
    if($FormatCetak=="PDF"){
        $html = ob_get_contents();
        ob_end_clean();
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output($FileName.".pdf" ,'I');
        exit;
    }
?>
<?php }}} ?>