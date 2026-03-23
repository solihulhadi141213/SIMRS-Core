<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_GET['id_perencanaan_pasien'])){
        echo 'ID Perencanaan Pasien Tidak Boleh Kosong!';
    }else{
        if(empty($_GET['FormatCetak'])){
            echo 'Format Cetak Tidak Boleh Kosong!';
        }else{
            if(empty($_GET['TampilkanHeader'])){
                echo 'Header Cetak Tidak Boleh Kosong!';
            }else{
                $id_perencanaan_pasien=$_GET['id_perencanaan_pasien'];
                $FormatCetak=$_GET['FormatCetak'];
                $TampilkanHeader=$_GET['TampilkanHeader'];
                //Validasi Keberadaan Data
                $QryPerencanaanPasien = mysqli_query($Conn,"SELECT * FROM perencanaan_pasien WHERE id_perencanaan_pasien='$id_perencanaan_pasien'")or die(mysqli_error($Conn));
                $DataPerencanaanPasien = mysqli_fetch_array($QryPerencanaanPasien);
                if(empty($DataPerencanaanPasien['id_perencanaan_pasien'])){
                    echo 'ID Yang Anda Gunakan Tidak Valid/Tidak Ditemukan Pada Database!';
                }else{
                    $perencanaan = $DataPerencanaanPasien['perencanaan'];
                    $kategori_perencanaan = $DataPerencanaanPasien['kategori_perencanaan'];
                    $tanggal_entry = $DataPerencanaanPasien['tanggal_entry'];
                    $id_akses = $DataPerencanaanPasien['id_akses'];
                    $id_kunjungan = $DataPerencanaanPasien['id_kunjungan'];
                    $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
                    $id_pasien=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_pasien');
                    $NamaPasien=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'nama');
                    //Format Tanggal
                    $strtotime=strtotime($tanggal_entry);
                    $FormatTanggalEntry=date('d/m/Y H:i T', $strtotime);
                    //Routing Berdasarkan Kategori
                    if($kategori_perencanaan=="pemulangan_pasien"){
                        $LabelKategori="Perencanaan Pemulangan Pasien";
                    }else{
                        if($kategori_perencanaan=="rencana_rawat"){
                            $LabelKategori="Rencana Rawat";
                        }else{
                            if($kategori_perencanaan=="instruksi_medik"){
                                $LabelKategori="Intruksi Medik dan Keperawatan";
                            }else{
                                $LabelKategori="Tidak Diketahui";
                            }
                        }
                    }
?>
    <html>
        <Header>
            <title><?php echo $LabelKategori; ?></title>
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
                            <td width="80px" valign="top" align="center">
                                <img src="../../assets/images/<?php echo "$logo"; ?>" class="logo">
                            </td>
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
                <b class="f16"><?php echo $LabelKategori; ?></b>
            </div>
            <div class="kop">
                <table class="data" cellspacing="0px">
                    <tr>
                        <td><strong>A.</strong></td>
                        <td colspan="4"><strong>Informasi Pasien & Pendaftaran</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.1</td>
                        <td>ID Perencanaan</td>
                        <td>:</td>
                        <td><?php echo "$id_perencanaan_pasien"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.2</td>
                        <td>ID Kunjungan</td>
                        <td>:</td>
                        <td><?php echo "$id_kunjungan"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.3</td>
                        <td>No.RM</td>
                        <td>:</td>
                        <td><?php echo "$id_pasien"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.4</td>
                        <td>Nama Pasien</td>
                        <td>:</td>
                        <td><?php echo "$NamaPasien"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.5</td>
                        <td>Tanggal & Jam Entry</td>
                        <td>:</td>
                        <td><?php echo "$FormatTanggalEntry"; ?></td>
                    </tr>
                </table>
            </div>
        </body>
    </html>
<?php }}}} ?>