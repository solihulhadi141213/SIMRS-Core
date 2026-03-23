<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_GET['id_edukasi'])){
        echo 'ID Kunjungan Tidak Boleh Kosong!';
    }else{
        if(empty($_GET['FormatCetak'])){
            echo 'Format Cetak Tidak Boleh Kosong!';
        }else{
            if(empty($_GET['TampilkanHeader'])){
                echo 'Header Cetak Tidak Boleh Kosong!';
            }else{
                $id_edukasi=$_GET['id_edukasi'];
                $FormatCetak=$_GET['FormatCetak'];
                $TampilkanHeader=$_GET['TampilkanHeader'];
                //Validasi Keberadaan Data
                $id_edukasi=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'id_edukasi');
                if(empty($id_edukasi)){
                    echo 'ID Yang Anda Gunakan Tidak Valid/Tidak Ditemukan Pada Database!';
                }else{
                    //Membuka Detail
                    $id_kunjungan=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'id_kunjungan');
                    $id_pasien=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'id_pasien');
                    $petugas_entry=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'petugas_entry');
                    $tanggal_edukasi=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'tanggal_edukasi');
                    $kategori_edukasi=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'kategori_edukasi');
                    $materi_edukasi=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'materi_edukasi');
                    $pemberi_edukasi=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'pemberi_edukasi');
                    $penerima_edukasi=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'penerima_edukasi');
                    $keterangan_edukasi=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'keterangan_edukasi');
                    $status_edukasi=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'status_edukasi');
                    //Format waktu
                    $strtotime=strtotime($tanggal_edukasi);
                    $tanggal_edukasi=date('d/m/Y H:i T',$strtotime);
                    //Json 
                    $JsonPemberiEdukasi =json_decode($pemberi_edukasi, true);
                    $JsonPenerimaEdukasi =json_decode($penerima_edukasi, true);
                    $JsonKeteranganEdukasi =json_decode($keterangan_edukasi, true);
                    //Pemberi Edukasi
                    $NamaPemberiEdukasi=$JsonPemberiEdukasi['nama'];
                    $KontakPemberiEdukasi=$JsonPemberiEdukasi['kontak'];
                    $IdentitasPemberiEdukasi=$JsonPemberiEdukasi['kategori_identitas'];
                    $NomorIdentitasPemberiEdukasi=$JsonPemberiEdukasi['no_identitas'];
                    $TtdPemberiEdukasi=$JsonPemberiEdukasi['ttd'];
                    if(empty($TtdPemberiEdukasi)){
                        $LabelTtdPemberiEdukasi='<a href="javascript:void(0);" id="AddTtdPemberiEdukasi" class="AddTtdPemberiEdukasi" value="'.$id_edukasi.'">Belum Ada <i class="ti ti-pencil"></i></a>';
                    }else{
                        $LabelTtdPemberiEdukasi='<br><img src="data:image/gif;base64,'. $TtdPemberiEdukasi .'" width="150px">';
                    }
                    //Penerima Edukasi
                    $NamaPenerimaEdukasi=$JsonPenerimaEdukasi['nama'];
                    $KontakPenerimaEdukasi=$JsonPenerimaEdukasi['kontak'];
                    $IdentitasPenerimaEdukasi=$JsonPenerimaEdukasi['kategori_identitas'];
                    $NomorIdentitasPenerimaEdukasi=$JsonPenerimaEdukasi['no_identitas'];
                    $TtdPenerimaEdukasi=$JsonPenerimaEdukasi['ttd'];
                    if(empty($TtdPenerimaEdukasi)){
                        $LabelTtdPenerimaEdukasi='<a href="javascript:void(0);" id="AddTtdPenerimaEdukasi" class="AddTtdPenerimaEdukasi" value="'.$id_edukasi.'">Belum Ada <i class="ti ti-pencil"></i></a>';
                    }else{
                        $LabelTtdPenerimaEdukasi='<br><img src="data:image/gif;base64,'. $TtdPenerimaEdukasi .'" width="150px">';
                    }
                    //Keterangan Edukasi
                    $Bahasa=$JsonKeteranganEdukasi['bahasa'];
                    $Penerjemah=$JsonKeteranganEdukasi['penerjemah'];
                    $Hambatan=$JsonKeteranganEdukasi['hambatan'];
                    $jenis_hambatan=$JsonKeteranganEdukasi['jenis_hambatan'];
                    $durasi=$JsonKeteranganEdukasi['durasi'];
                    $kesediaan_edukasi=$JsonKeteranganEdukasi['kesediaan_edukasi'];
?>
    <html>
        <Header>
            <title>Edukasi</title>
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
                <b class="f16">LEMBAR EDUKASI</b>
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
                        <td>ID Kunjungan</td>
                        <td>:</td>
                        <td><?php echo "$id_kunjungan"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.2</td>
                        <td>No.RM</td>
                        <td>:</td>
                        <td><?php echo "$id_pasien"; ?></td>
                    </tr>
                </table>
            </div>
        </body>
    </html>
<?php }}}} ?>