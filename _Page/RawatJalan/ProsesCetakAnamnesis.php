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
                $id_anamnesis=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'id_anamnesis');
                if(empty($_GET['TampilkanHeader'])){
                    echo 'ID Yang Anda Gunakan Tidak Valid/Tidak Ditemukan Pada Database!';
                }else{
                    $id_pasien=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'id_pasien');
                    $id_akses=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'id_akses');
                    $tanggal=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'tanggal');
                    $nama_pasien=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'nama_pasien');
                    $nama_petugas=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'nama_petugas');
                    $keluhan_utama=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'keluhan_utama');
                    $riwayat_penyakit=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_penyakit');
                    $riwayat_alergi=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_alergi');
                    $riwayat_pengobatan=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_pengobatan');
                    $habitus_kebiasaan=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'habitus_kebiasaan');
                    //Decode JSON
                    $JsonNamaPetugas =json_decode($nama_petugas, true);
                    $JsonKeluhanUtama =json_decode($keluhan_utama, true);
                    $JsonRiwayatPenyakit =json_decode($riwayat_penyakit, true);
                    $JsonRiwayatAlergi =json_decode($riwayat_alergi, true);
                    $JsonRiwayatPengobatan =json_decode($riwayat_pengobatan, true);
                    $JsonHabitusKebiasaan=json_decode($habitus_kebiasaan, true);
                    //Format Tanggal
                    $strtotime=strtotime($tanggal);
                    $FormatTanggal=date('d/m/Y H:i', $strtotime);
                    //Buka Petugas Entry
                    if(!empty($JsonNamaPetugas['petugas_entry']['nama'])){
                        $PetugasEntry=$JsonNamaPetugas['petugas_entry']['nama'];
                        if(!empty($JsonNamaPetugas['petugas_entry']['tanda_tangan'])){
                            $TtdPetugasEntry=$JsonNamaPetugas['petugas_entry']['tanda_tangan'];
                            $TtdPetugasEntry='<img src="data:image/gif;base64,'. $TtdPetugasEntry .'" width="100%"><br>';
                        }else{
                            $TtdPetugasEntry='<a href="javascript:void(0);" class="text-primary" id="SignPetugasEntry"><small>Tanda Tangan</small></a>';
                        }
                    }else{
                        $PetugasEntry="Tidak Ada";
                        $TtdPetugasEntry='<i>Tidak ADa</i>';
                    }
                    //Buka Dokter
                    if(!empty($JsonNamaPetugas['dokter']['nama'])){
                        $dokter=$JsonNamaPetugas['dokter']['nama'];
                        if(!empty($JsonNamaPetugas['dokter']['tanda_tangan'])){
                            $TtdDokter=$JsonNamaPetugas['dokter']['tanda_tangan'];
                            $TtdDokter='<img src="data:image/gif;base64,'. $TtdDokter .'" width="100%"><br>';
                        }else{
                            $TtdDokter='<a href="javascript:void(0);" class="text-primary" id="SignDokter"><small>Tanda Tangan</small></a>';
                        }
                    }else{
                        $dokter="Tidak Ada";
                        $TtdDokter='<i>Tidak ADa</i>';
                    }
                    //Buka Perawat
                    if(!empty($JsonNamaPetugas['perawat']['nama'])){
                        $perawat=$JsonNamaPetugas['perawat']['nama'];
                        if(!empty($JsonNamaPetugas['perawat']['tanda_tangan'])){
                            $TtdPerawat=$JsonNamaPetugas['perawat']['tanda_tangan'];
                            $TtdPerawat='<img src="data:image/gif;base64,'. $TtdPerawat .'" width="100%"><br>';
                        }else{
                            $TtdPerawat='<a href="javascript:void(0);" class="text-primary" id="SignPerawat"><small>Tanda Tangan</small></a>';
                        }
                    }else{
                        $perawat="Tidak Ada";
                        $TtdPerawat='<i>Tidak ADa</i>';
                    }
                    //Riwayat Penyakit
                    $RiwayatPenyakitSekarang=$JsonRiwayatPenyakit['sekarang'];
                    $RiwayatPenyakitDahulu=$JsonRiwayatPenyakit['dahulu'];
?>
    <html>
        <Header>
            <title>Anamnesis</title>
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
                <b class="f16">ANAMNESIS</b>
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
                        <td>ID Anamnesis</td>
                        <td>:</td>
                        <td><?php echo "$id_anamnesis"; ?></td>
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
                        <td>Tanggal & Jam</td>
                        <td>:</td>
                        <td><?php echo "$FormatTanggal"; ?></td>
                    </tr>
                </table>
            </div>
        </body>
    </html>
<?php }}}} ?>