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
                $id_kunjungan=$_GET['id_kunjungan'];
                $FormatCetak=$_GET['FormatCetak'];
                $TampilkanHeader=$_GET['TampilkanHeader'];
                //Validasi Keberadaan Data
                $id_resume=getDataDetail($Conn,"resume",'id_kunjungan',$id_kunjungan,'id_resume');
                if(empty($id_resume)){
                    echo 'ID Yang Anda Gunakan Tidak Valid/Tidak Ditemukan Pada Database!';
                }else{
                    //Membuka Data Resume
                    $id_pasien=getDataDetail($Conn,"resume",'id_resume',$id_resume,'id_pasien');
                    $tanggal_entry=getDataDetail($Conn,"resume",'id_resume',$id_resume,'tanggal_entry');
                    $tanggal_pulang=getDataDetail($Conn,"resume",'id_resume',$id_resume,'tanggal_pulang');
                    $petugas=getDataDetail($Conn,"resume",'id_resume',$id_resume,'petugas');
                    $dokter=getDataDetail($Conn,"resume",'id_resume',$id_resume,'dokter');
                    $resume=getDataDetail($Conn,"resume",'id_resume',$id_resume,'resume');
                    $pasca_pulang=getDataDetail($Conn,"resume",'id_resume',$id_resume,'pasca_pulang');
                    $nasehat=getDataDetail($Conn,"resume",'id_resume',$id_resume,'nasehat');
                    $evaluasi=getDataDetail($Conn,"resume",'id_resume',$id_resume,'evaluasi');
                    $kondisi_keluar=getDataDetail($Conn,"resume",'id_resume',$id_resume,'kondisi_keluar');
                    $cara_keluar=getDataDetail($Conn,"resume",'id_resume',$id_resume,'cara_keluar');
                    $terapi_pulang=getDataDetail($Conn,"resume",'id_resume',$id_resume,'terapi_pulang');
                    $rencana_kontrol=getDataDetail($Conn,"resume",'id_resume',$id_resume,'rencana_kontrol');
                    $meninggal=getDataDetail($Conn,"resume",'id_resume',$id_resume,'meninggal');
                    $pengaturan_lampiran=getDataDetail($Conn,"resume",'id_resume',$id_resume,'pengaturan_lampiran');
                    //Buka Pasien
                    $nama_pasien=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'nama');
                    //Buka Petugas
                    if(!empty($petugas)){
                        $JsonPetugas=json_decode($petugas, true);
                        $NamaPetugas=$JsonPetugas['nama'];
                        $KategoriPetugas=$JsonPetugas['kategori'];
                        $KontakPetugas=$JsonPetugas['kontak'];
                        $KategoriIdentitasPetugas=$JsonPetugas['kategori_identitas'];
                        $NomorIdentitasPetugas=$JsonPetugas['no_identitas'];
                        $TtdPetugas=$JsonPetugas['ttd'];
                    }else{
                        $NamaPetugas="";
                        $KategoriPetugas="";
                        $KontakPetugas="";
                        $KategoriIdentitasPetugas="";
                        $NomorIdentitasPetugas="";
                        $TtdPetugas="";
                    }
                    if(empty($TtdPetugas)){
                        $LabelTtdPetugas='<a href="javascript:void(0);" id="AddTtdPetugasResume" class="AddTtdPetugasResume" value="'.$id_resume.'">Belum Ada <i class="ti ti-pencil"></i></a>';
                    }else{
                        $LabelTtdPetugas='<br><img src="data:image/gif;base64,'. $TtdPetugas .'" width="150px">';
                    }
                    //Buka Dokter
                    if(!empty($petugas)){
                        $JsonDokter =json_decode($dokter, true);
                        $NamaDokter=$JsonDokter['nama'];
                        $SipDokter=$JsonDokter['SIP'];
                        $KontakDokter=$JsonDokter['kontak'];
                        $KategoriIdentitasDokter=$JsonDokter['kategori_identitas'];
                        $NomorIdentitasDokter=$JsonDokter['no_identitas'];
                        $TtdDokter=$JsonDokter['ttd'];
                    }else{
                        $NamaDokter="";
                        $SipDokter="";
                        $KontakDokter="";
                        $KategoriIdentitasDokter="";
                        $NomorIdentitasDokter="";
                        $TtdDokter="";
                    }
                    if(empty($TtdDokter)){
                        $LabelTtdDokter='<a href="javascript:void(0);" id="AddTtdPetugasResume" class="AddTtdPetugasResume" value="'.$id_resume.'">Belum Ada <i class="ti ti-pencil"></i></a>';
                    }else{
                        $LabelTtdDokter='<br><img src="data:image/gif;base64,'. $TtdDokter .'" width="150px">';
                    }
                    //Rencana Kontrol
                    if(!empty($rencana_kontrol)){
                        $JsonRencanaKontrol =json_decode($rencana_kontrol, true);
                        $NomorSuratRencanaKontrol=$JsonRencanaKontrol['no_surat'];
                        $TanggalRencanaKontrol=$JsonRencanaKontrol['tanggal'];
                        $NamaPoliRencanaKontrol=$JsonRencanaKontrol['nama_poli'];
                        $NamaDokterRencanaKontrol=$JsonRencanaKontrol['nama_dokter'];
                        //Format Tanggal
                        $strtotimeKontrol=strtotime($TanggalRencanaKontrol);
                        $TanggalRencanaKontrol=date('d/m/Y', $strtotimeKontrol);
                    }else{
                        $NomorSuratRencanaKontrol="";
                        $TanggalRencanaKontrol="";
                        $NamaPoliRencanaKontrol="";
                        $NamaDokterRencanaKontrol="";
                    }
                    //Meninggal
                    if(!empty($meninggal)){
                        $JsonMeninggal =json_decode($meninggal, true);
                        $no_surat_meninggal=$JsonMeninggal['no_surat_meninggal'];
                        $tanggal_meninggal=$JsonMeninggal['tanggal_meninggal'];
                        $strtotime3=strtotime($tanggal_meninggal);
                        $TanggalMeninggal=date('Y-m-d',$strtotime3);
                        $JamMeninggal=date('H:i',$strtotime3);
                        //Format Tanggal
                        $TanggalJamMeninggal="$TanggalMeninggal $JamMeninggal";
                        $strtotimeMeninggal=strtotime($TanggalJamMeninggal);
                        $TanggalJamMeninggal=date('d/m/Y H:i T', $strtotimeMeninggal);
                    }else{
                        $no_surat_meninggal="";
                        $tanggal_meninggal="";
                        $TanggalMeninggal="";
                        $JamMeninggal="";
                        $TanggalJamMeninggal="";
                    }
                    //Lampiran
                    if(!empty($pengaturan_lampiran)){
                        $JsonLampiran =json_decode($pengaturan_lampiran, true);
                    }else{
                        $JsonLampiran="";
                    }
                    //Format Tanggal
                    $strtotime1=strtotime($tanggal_entry);
                    $strtotime2=strtotime($tanggal_pulang);
                    $TanggalEntry=date('d/m/Y H:i T',$strtotime1);
                    $TanggalPulang=date('d/m/Y H:i T',$strtotime2);
?>
    <html>
        <Header>
            <title>Resume</title>
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
                <b class="f16">RESUME</b>
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
                        <td>ID Resume</td>
                        <td>:</td>
                        <td><?php echo "$id_resume"; ?></td>
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
                        <td><?php echo "$nama_pasien"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.5</td>
                        <td>Tanggal & Jam Entry</td>
                        <td>:</td>
                        <td><?php echo "$TanggalEntry"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.5</td>
                        <td>Tanggal & Jam Pulang</td>
                        <td>:</td>
                        <td><?php echo "$TanggalPulang"; ?></td>
                    </tr>
                </table>
            </div>
        </body>
    </html>
<?php }}}} ?>