<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_GET['id_konsultasi'])){
        echo 'ID Konsultasi Tidak Boleh Kosong!';
    }else{
        if(empty($_GET['FormatCetak'])){
            echo 'Format Cetak Tidak Boleh Kosong!';
        }else{
            if(empty($_GET['TampilkanHeader'])){
                echo 'Header Cetak Tidak Boleh Kosong!';
            }else{
                $id_konsultasi=$_GET['id_konsultasi'];
                $FormatCetak=$_GET['FormatCetak'];
                $TampilkanHeader=$_GET['TampilkanHeader'];
                //Validasi Keberadaan Data
                $id_konsultasi=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'id_konsultasi');
                if(empty($id_konsultasi)){
                    echo 'ID Yang Anda Gunakan Tidak Valid/Tidak Ditemukan Pada Database!';
                }else{
                    //Membuka Detail
                    $id_pasien=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'id_pasien');
                    $id_kunjungan=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'id_kunjungan');
                    $id_akses=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'id_akses');
                    $petugas_entry=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'petugas_entry');
                    $tanggal_entry=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'tanggal_entry');
                    $tanggal_permintaan=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'tanggal_permintaan');
                    $tanggal_jawaban=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'tanggal_jawaban');
                    $dokter_asal=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'dokter_asal');
                    $dokter_tujuan=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'dokter_tujuan');
                    $status_konsultasi=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'status_konsultasi');
                    //Buka Nama Pasien
                    $NamaPasien=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'nama');
                    //Json Decode
                    $JsonDokterAsal=json_decode($dokter_asal, true);
                    $JsonDokterTujuan=json_decode($dokter_tujuan, true);
                    //Buka Dokter Asal
                    $IdUnitAsal=$JsonDokterAsal['unit']['id_unit'];
                    $NamaUnitAsal=$JsonDokterAsal['unit']['nama'];
                    $IdDokterAsal=$JsonDokterAsal['id_dokter'];
                    $NamaDokterAsal=$JsonDokterAsal['nama'];
                    $TtdDokterAsal=$JsonDokterAsal['ttd'];
                    if(empty($TtdDokterAsal)){
                        $LabelTtdAsal="";
                    }else{
                        $LabelTtdAsal='<img src="data:image/gif;base64,'. $TtdDokterAsal .'" width="150px">';
                    }
                    //Buka Dokter Tujuan
                    $IdUnitTujuan=$JsonDokterTujuan['unit']['id_unit'];
                    $NamaUnitTujuan=$JsonDokterTujuan['unit']['nama'];
                    $IdDokterTujuan=$JsonDokterTujuan['id_dokter'];
                    $NamaDokterTujuan=$JsonDokterTujuan['nama'];
                    $TtdDokterTujuan=$JsonDokterTujuan['ttd'];
                    if(empty($TtdDokterTujuan)){
                        $LabelTtdTujuan="";
                    }else{
                        $LabelTtdTujuan='<img src="data:image/gif;base64,'. $TtdDokterTujuan .'" width="150px">';
                    }
                    //Format Tanggal
                    $strtotime1=strtotime($tanggal_entry);
                    $strtotime2=strtotime($tanggal_permintaan);
                    $strtotime3=strtotime($tanggal_jawaban);
                    $FormatTanggalEntry=date('d/m/Y H:i T',$strtotime1);
                    $FormatTanggalPermintaan=date('d/m/Y H:i T',$strtotime2);
                    $FormatTanggalJawaban=date('d/m/Y H:i T',$strtotime3);
                    //Buka Permintaan Konsultasi
                    if(!empty($data['permintaan_konsultasi'])){
                        $permintaan_konsultasi=$data['permintaan_konsultasi'];
                        $JsonPermintaanKonsultasi=json_decode($permintaan_konsultasi, true);
                        $diagnosa_kerja=$JsonPermintaanKonsultasi['diagnosa_kerja'];
                        $ikhtisar_klinis=$JsonPermintaanKonsultasi['ikhtisar_klinis'];
                        $konsul_diminta=$JsonPermintaanKonsultasi['konsul_diminta'];
                    }else{
                        $permintaan_konsultasi="";
                        $diagnosa_kerja="";
                        $ikhtisar_klinis="";
                        $konsul_diminta="";
                    }
                    //Buka Jawaban Konsultasi
                    if(!empty($data['jawaban_konsultasi'])){
                        $jawaban_konsultasi= $data['jawaban_konsultasi'];
                        $JsonJawabanKonsultasi=json_decode($jawaban_konsultasi, true);
                        $penemuan=$JsonJawabanKonsultasi['penemuan'];
                        $diagnosa=$JsonJawabanKonsultasi['diagnosa'];
                        $saran=$JsonJawabanKonsultasi['saran'];
                    }else{
                        $penemuan="";
                        $diagnosa="";
                        $saran="";
                    }
?>
    <html>
        <Header>
            <title>Konsultasi</title>
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
                <b class="f16">LEMBAR KONSULTASI</b>
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
                        <td>ID Konsultasi</td>
                        <td>:</td>
                        <td><?php echo "$id_konsultasi"; ?></td>
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