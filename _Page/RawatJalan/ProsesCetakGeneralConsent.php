<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_GET['id_kunjungan'])){
        echo 'ID Kunjungan Tidak Boleh Kosong!';
    }else{
        if(empty($_GET['FormatCetak'])){
            echo 'Format Cetak Tidak Boleh Kosong!';
        }else{
            if(empty($_GET['TampilkanHeader'])){
                echo 'Header Cetak Tidak Boleh Kosong!';
            }else{
                if(empty($_GET['TampilkanTandaTangan'])){
                    echo 'Tanda Tangan Tidak Boleh Kosong!';
                }else{
                    $id_kunjungan=$_GET['id_kunjungan'];
                    $FormatCetak=$_GET['FormatCetak'];
                    $TampilkanHeader=$_GET['TampilkanHeader'];
                    $TampilkanTandaTangan=$_GET['TampilkanTandaTangan'];
                    //Membuka Detail General Consent
                    $id_pasien=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'id_pasien');
                    $id_akses=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'id_akses');
                    $id_general_consent=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'id_general_consent');
                    $tanggal=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'tanggal');
                    $nama_pasien=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'nama_pasien');
                    $nama_petugas=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'nama_petugas');
                    $penanggung_jawab=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'penanggung_jawab');
                    $general_consent=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'general_consent');
                    if(empty($id_general_consent)){
                        echo 'ID Kunjungan Tidak Valid!';
                    }else{
                        //Decode JSON
                        $JsonPetugas =json_decode($nama_petugas, true);
                        $JsonPenanggungJawab =json_decode($penanggung_jawab, true);
                        $JsonGeneralConsent =json_decode($general_consent, true);
                        //Format Tanggal
                        $strtotime=strtotime($tanggal);
                        $FormatTanggal=date('d/m/Y H:i', $strtotime);
                        //Buka Petugas
                        $NamaPetugas=$JsonPetugas['nama'];
                        $NikPetugas=$JsonPetugas['nik'];
                        $KontakPetugas=$JsonPetugas['kontak'];
                        $AlamatPetugas=$JsonPetugas['alamat'];
                        //Buka Penanggung Jawab
                        $NamaPenanggungJawab=$JsonPenanggungJawab['nama'];
                        $NikPenanggungJawab=$JsonPenanggungJawab['nik'];
                        $KontakPenanggungJawab=$JsonPenanggungJawab['kontak'];
                        $AlamatPenanggungJawab=$JsonPenanggungJawab['alamat'];
                        if(empty($JsonPenanggungJawab['ttd'])){
                            $TtdPenanggungJawab='<i class="text-danger">Belum Ada</i>';
                        }else{
                            $TtdPenanggungJawab='<i class="text-success">Tervalidasi</i>';
                        }
                        //Buka General Consent
                        $pernyataan_1=$JsonGeneralConsent['pernyataan_1'];
                        $pernyataan_2=$JsonGeneralConsent['pernyataan_2'];
                        $pernyataan_3=$JsonGeneralConsent['pernyataan_3'];
                        $pernyataan_4=$JsonGeneralConsent['pernyataan_4'];
                        $pernyataan_5=$JsonGeneralConsent['pernyataan_5'];
                        $pernyataan_6=$JsonGeneralConsent['pernyataan_6'];
                        $pernyataan_7=$JsonGeneralConsent['pernyataan_7'];
                        $pernyataan_8=$JsonGeneralConsent['pernyataan_8'];
                        $pernyataan_9=$JsonGeneralConsent['pernyataan_9'];
                        $pernyataan_10=$JsonGeneralConsent['pernyataan_10'];
?>
    <html>
        <Header>
            <title>General Consent</title>
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
                    padding: 1px;
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
                <b class="f16">PERSETUJUAN UMUM <i>(GENERAL CONSENT)</i></b>
            </div>
            <div class="kop">
                <table class="data" cellspacing="0px">
                    <tr>
                        <td><strong>ID General Consent</strong></td>
                        <td><strong>:</strong></td>
                        <td><?php echo "$id_general_consent"; ?></td>
                    </tr>
                    <tr>
                        <td><strong>ID Kunjungan</strong></td>
                        <td><strong>:</strong></td>
                        <td><?php echo "$id_kunjungan"; ?></td>
                    </tr>
                    <tr>
                        <td><strong>No.RM</strong></td>
                        <td><strong>:</strong></td>
                        <td><?php echo "$id_pasien"; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nama pasien</strong></td>
                        <td><strong>:</strong></td>
                        <td><?php echo "$nama_pasien"; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal, Jam</strong></td>
                        <td><strong>:</strong></td>
                        <td><?php echo "$FormatTanggal"; ?></td>
                    </tr>
                </table>
            </div>
            <div class="kop">
                <p>
                Yang bertandatangan di bawah ini:
                    <table class="data" cellspacing="0px">
                        <tr>
                            <td>Nama</td>
                            <td><strong>:</strong></td>
                            <td><?php echo "$NamaPenanggungJawab"; ?></td>
                        </tr>
                        <tr>
                            <td>NIK</td>
                            <td><strong>:</strong></td>
                            <td><?php echo "$NikPenanggungJawab"; ?></td>
                        </tr>
                        <tr>
                            <td>Kontak</td>
                            <td><strong>:</strong></td>
                            <td><?php echo "$KontakPenanggungJawab"; ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td><strong>:</strong></td>
                            <td><?php echo "$AlamatPenanggungJawab"; ?></td>
                        </tr>
                    </table>
                    Selaku penanggung jawab dengan ini menyatakan persetujuan :
                    <?php
                        echo '              <ul>';
                        echo '                  <li>Pernyataan pasien yang menyatakan persetujuan atau tidak atas pelayanan RS ('.$pernyataan_1.')</li>';
                        echo '                  <li>Penjelasan dari petugas RS mengenai ketentuan pembayaran pelayanan RS. ('.$pernyataan_2.')</li>';
                        echo '                  <li>Penjelasan dari petugas RS mengenai hak dan kewajiban pasien ('.$pernyataan_3.')</li>';
                        echo '                  <li>Penjelasan dari petugas RS mengenai tata tertib RS ('.$pernyataan_4.')</li>';
                        echo '                  <li>Penjelasan dari petugas RS mengenai kebutuhan akan penterjemah bahasa ('.$pernyataan_5.')</li>';
                        echo '                  <li>Penjelasan dari petugas RS mengenai kebutuhan akan rohaniawan ('.$pernyataan_6.')</li>';
                        echo '                  <li>Penjelasan dari petugas RS mengenai konsekuensi pelepasan informasi terkait data-data pasien ('.$pernyataan_7.')</li>';
                        echo '                  <li>Hasil pembacaan dari hasil pemeriksaan penunjang yang diberikan kepada pihak penjamin ('.$pernyataan_8.')</li>';
                        echo '                  <li>Hasil pemeriksaan penunjang yang dapat diinformasikan/diakses kepada peserta didik ('.$pernyataan_9.')</li>';
                        echo '                  <li>Persetujuan terkait dengan informasi pasien yang diberikan kepada fasyankes yang akan dituju ('.$pernyataan_10.')</li>';
                        echo '              </ul>';
                    ?>
                </p>
            </div>
            <?php if($TampilkanTandaTangan=="Ya"){ ?>
                <div class="kop3">
                    <table class="kop_surat3" width="100%">
                        <tr>
                            <td width="50%" valign="top" align="center">
                                <b>Petugas/Saksi RS</b><br>
                                <?php
                                    if(!empty($JsonPetugas['ttd'])){
                                        $TtdPetugas=$JsonPetugas['ttd'];
                                        $DecodeTtdPetugas=base64_decode($TtdPetugas);
                                        echo '<img src="data:image/gif;base64,'. $TtdPetugas .'" width="200px"><br>';
                                        echo "($NamaPetugas)<br><br>";
                                    }
                                ?>
                            </td>
                            <td width="50%" valign="top" align="center">
                                <b>Penanggung Jawab Pasien</b><br>
                                <?php
                                    if(!empty($JsonPenanggungJawab['ttd'])){
                                        $TtdPenanggungJawab=$JsonPenanggungJawab['ttd'];
                                        $DecodeTtdPenanggungJawab=base64_decode($TtdPenanggungJawab);
                                        echo '<img src="data:image/gif;base64,'. $TtdPenanggungJawab .'" width="200px"><br>';
                                        echo "($NamaPenanggungJawab)<br><br>";
                                    }
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
        </body>
    </html>
<?php }}}}} ?>