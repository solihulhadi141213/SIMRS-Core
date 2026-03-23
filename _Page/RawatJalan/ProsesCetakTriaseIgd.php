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
                $id_triase_igd=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'id_triase_igd');
                if(empty($_GET['TampilkanHeader'])){
                    echo 'ID Yang Anda Gunakan Tidak Valid/Tidak Ditemukan Pada Database!';
                }else{
                     //Membuka Detail Triase Dan IGD
                    $id_pasien=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'id_pasien');
                    $id_akses=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'id_akses');
                    $tanggal=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'tanggal');
                    $nama_pasien=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'nama_pasien');
                    $nama_petugas=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'nama_petugas');
                    $tanggal_jam_masuk=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'tanggal_jam_masuk');
                    $triase_igd=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'triase_igd');
                    //Decode JSON
                    $JsonTriaseIgd =json_decode($triase_igd, true);
                    //Format Tanggal
                    $strtotime=strtotime($tanggal);
                    $FormatTanggal=date('d/m/Y H:i', $strtotime);
                    //Format Tanggal Masuk
                    $strtotime2=strtotime($tanggal_jam_masuk);
                    $FormatTanggalMasuk=date('d/m/Y H:i:s T', $strtotime2);
                    $kajian_resiko_jatuh=$JsonTriaseIgd['kajian_resiko_jatuh'];
                    //Pengantar Pasien
                    if(!empty($JsonTriaseIgd['pengantar_pasien'])){
                        $pengantar_pasien=$JsonTriaseIgd['pengantar_pasien'];
                        $nama_pengantar_pasien=$JsonTriaseIgd['pengantar_pasien']['nama_pengantar_pasien'];
                        $kontak_pengantar_pasien=$JsonTriaseIgd['pengantar_pasien']['kontak_pengantar_pasien'];
                    }else{
                        $pengantar_pasien="";
                        $nama_pengantar_pasien="None";
                        $kontak_pengantar_pasien="None";
                    }
                    //Sarana Transportasi
                    if(!empty($JsonTriaseIgd['sarana_transportasi'])){
                        $sarana_transportasi=$JsonTriaseIgd['sarana_transportasi'];
                        $kategori_sarana_transportasi=$JsonTriaseIgd['sarana_transportasi']['kategori'];
                        $keterangan_sarana_transportasi=$JsonTriaseIgd['sarana_transportasi']['keterangan'];
                    }else{
                        $sarana_transportasi="";
                        $kategori_sarana_transportasi="None";
                        $keterangan_sarana_transportasi="None";
                    }
                    //Kondisi Pasien Tiba
                    if(!empty($JsonTriaseIgd['kondisi_pasien_tiba'])){
                        $kondisi_pasien_tiba=$JsonTriaseIgd['kondisi_pasien_tiba'];
                        $kategori_kondisi_pasien=$JsonTriaseIgd['kondisi_pasien_tiba']['kategori_kondisi_pasien'];
                        $penjelasan_kondisi_pasien=$JsonTriaseIgd['kondisi_pasien_tiba']['penjelasan_kondisi_pasien'];
                    }else{
                        $kondisi_pasien_tiba="";
                        $kategori_kondisi_pasien="None";
                        $penjelasan_kondisi_pasien="None";
                    }
                    //Kesadaran Pasien
                    if(!empty($JsonTriaseIgd['kesadaran_pasien'])){
                        $kesadaran_pasien=$JsonTriaseIgd['kesadaran_pasien'];
                    }else{
                        $kesadaran_pasien='None';
                    }
                    //Surat Pengantar Rujukan
                    if(!empty($JsonTriaseIgd['surat_pengantar_rujukan'])){
                        $surat_pengantar_rujukan=$JsonTriaseIgd['surat_pengantar_rujukan'];
                        $surat_rujukan=$JsonTriaseIgd['surat_pengantar_rujukan']['surat_rujukan'];
                        $no_surat_rujukan=$JsonTriaseIgd['surat_pengantar_rujukan']['no_surat_rujukan'];
                        $asal_rujukan=$JsonTriaseIgd['surat_pengantar_rujukan']['asal_rujukan'];
                    }else{
                        $surat_pengantar_rujukan="";
                        $surat_rujukan="None";
                        $no_surat_rujukan="None";
                        $asal_rujukan="None";
                    }
                    //Assesmen Nyeri
                    if(!empty($JsonTriaseIgd['asesmen_nyeri'])){
                        $asesmen_nyeri=$JsonTriaseIgd['asesmen_nyeri'];
                        $AdaTidakNyeri=$JsonTriaseIgd['asesmen_nyeri']['asesmen_nyeri'];
                        $lokasi_nyeri=$JsonTriaseIgd['asesmen_nyeri']['lokasi_nyeri'];
                        $penyebab_nyeri=$JsonTriaseIgd['asesmen_nyeri']['penyebab_nyeri'];
                        $durasi_nyeri=$JsonTriaseIgd['asesmen_nyeri']['durasi_nyeri'];
                        $frekuensi_nyeri=$JsonTriaseIgd['asesmen_nyeri']['frekuensi_nyeri'];
                        $skor_skala_vas=$JsonTriaseIgd['asesmen_nyeri']['skala_vas']['skor'];
                        $kategori_skala_vas=$JsonTriaseIgd['asesmen_nyeri']['skala_vas']['kategori'];
                        $skor_skala_nrs=$JsonTriaseIgd['asesmen_nyeri']['skala_nrs']['skor'];
                        $kategori_skala_nrs=$JsonTriaseIgd['asesmen_nyeri']['skala_nrs']['kategori'];
                        $skor_skala_vrs=$JsonTriaseIgd['asesmen_nyeri']['skala_vrs']['skor'];
                        $kategori_skala_vrs=$JsonTriaseIgd['asesmen_nyeri']['skala_vrs']['kategori'];
                        if(!empty($asesmen_nyeri)){
                            if($asesmen_nyeri['skala_nips']['skala_nips1']==1){
                                $LabelNips1="Grimace";
                            }else{
                                if($asesmen_nyeri['skala_nips']['skala_nips1']==0){
                                    $LabelNips1="Relaxed";
                                }else{
                                    $LabelNips1="None";
                                }
                            }
                            if($asesmen_nyeri['skala_nips']['skala_nips2']==0){
                                $LabelNips2="No Cry";
                            }else{
                                if($asesmen_nyeri['skala_nips']['skala_nips2']==1){
                                    $LabelNips2="Whimper";
                                }else{
                                    $LabelNips2="Vigorous crying or silent cry";
                                }
                            }
                            if($asesmen_nyeri['skala_nips']['skala_nips3']==0){
                                $LabelNips3="Relaxed";
                            }else{
                                if($asesmen_nyeri['skala_nips']['skala_nips3']==1){
                                    $LabelNips3="Change in breathing";
                                }else{
                                    $LabelNips3="None";
                                }
                            }
                            if($asesmen_nyeri['skala_nips']['skala_nips4']==0){
                                $LabelNips4="Relaxed";
                            }else{
                                if($asesmen_nyeri['skala_nips']['skala_nips4']==1){
                                    $LabelNips4="Flexed/extended";
                                }else{
                                    $LabelNips4="None";
                                }
                            }
                            if($asesmen_nyeri['skala_nips']['skala_nips5']==0){
                                $LabelNips5="Relaxed";
                            }else{
                                if($asesmen_nyeri['skala_nips']['skala_nips5']==1){
                                    $LabelNips5="Flexed/extended";
                                }else{
                                    $LabelNips5="None";
                                }
                            }
                            if($asesmen_nyeri['skala_nips']['skala_nips6']==0){
                                $LabelNips6="quiet, peaceful, settled";
                            }else{
                                if($asesmen_nyeri['skala_nips']['skala_nips6']==1){
                                    $LabelNips6="alert, restless, and thrashing";
                                }else{
                                    $LabelNips6="None";
                                }
                            }
                            if(empty($asesmen_nyeri['skala_nips']['skor'])){
                                $skor_skala_nips="0";
                            }else{
                                $skor_skala_nips=$asesmen_nyeri['skala_nips']['skor'];
                            }
                            if(empty($asesmen_nyeri['skala_nips']['kategori'])){
                                $kategori_skala_nips="0";
                            }else{
                                $kategori_skala_nips=$asesmen_nyeri['skala_nips']['kategori'];
                            }
                        }
                    }else{
                        $asesmen_nyeri="";
                        $AdaTidakNyeri="";
                        $lokasi_nyeri="";
                        $penyebab_nyeri="";
                        $durasi_nyeri="";
                        $frekuensi_nyeri="";
                        $skor_skala_nips="0";
                        $kategori_skala_nips="0";
                    }
                    //Resiko Jatuh
                    if(!empty($kajian_resiko_jatuh)){
                        //pemeriksa
                        if(empty($kajian_resiko_jatuh['pemeriksa'])){
                            $pemeriksa="";
                        }else{
                            $pemeriksa=$kajian_resiko_jatuh['pemeriksa'];
                        }
                        //Label MFS
                        if($kajian_resiko_jatuh['mfs']['mfs1']==0){
                            $LabelMfs1="Tidak";
                        }else{
                            $LabelMfs1="Ya";
                        }
                        if($kajian_resiko_jatuh['mfs']['mfs2']==0){
                            $LabelMfs2="Tidak";
                        }else{
                            $LabelMfs2="Ya";
                        }
                        if($kajian_resiko_jatuh['mfs']['mfs3']==0){
                            $LabelMfs3="Tidak Ada";
                        }else{
                            if($kajian_resiko_jatuh['mfs']['mfs3']==15){
                                $LabelMfs3="Tongkat/Alat Bantu";
                            }else{
                                $LabelMfs3="Furniture";
                            }
                        }
                        if($kajian_resiko_jatuh['mfs']['mfs4']==0){
                            $LabelMfs4="Tidak";
                        }else{
                            $LabelMfs4="Ya";
                        }
                        if($kajian_resiko_jatuh['mfs']['mfs5']==0){
                            $LabelMfs5="Normal";
                        }else{
                            if($kajian_resiko_jatuh['mfs']['mfs5']==10){
                                $LabelMfs5="Lemah";
                            }else{
                                $LabelMfs5="Terganggu";
                            }
                        }
                        if($kajian_resiko_jatuh['mfs']['mfs6']==0){
                            $LabelMfs6="Mengetahui Kemampuan Diri";
                        }else{
                            $LabelMfs6="Lupa Keterbatasan";
                        }
                        if(!empty($kajian_resiko_jatuh['mfs']['skor'])){
                            $SkorMfs=$kajian_resiko_jatuh['mfs']['skor'];
                        }else{
                            $SkorMfs="0";
                        }
                        if(!empty($kajian_resiko_jatuh['mfs']['kategori'])){
                            $KategoriMfs=$kajian_resiko_jatuh['mfs']['kategori'];
                        }else{
                            $KategoriMfs="0";
                        }
                        //HDS
                        if($kajian_resiko_jatuh['hds']['hds1']==4){
                            $LabelHds1="< 3 tahun";
                        }else{
                            if($kajian_resiko_jatuh['hds']['hds1']==3){
                                $LabelHds1="3-7 tahun";
                            }else{
                                if($kajian_resiko_jatuh['hds']['hds1']==2){
                                    $LabelHds1="7-13 tahun";
                                }else{
                                    if($kajian_resiko_jatuh['hds']['hds1']==1){
                                        $LabelHds1="13-18 tahun";
                                    }else{
                                        $LabelHds1="None";
                                    }
                                }
                            }
                        }
                        if($kajian_resiko_jatuh['hds']['hds2']==2){
                            $LabelHds2="Laki-laki";
                        }else{
                            if($kajian_resiko_jatuh['hds']['hds2']==1){
                                $LabelHds2="Perempuan";
                            }else{
                                $LabelHds2="None";
                            }
                        }
                        if($kajian_resiko_jatuh['hds']['hds3']==4){
                            $LabelHds3="Kelainan neurologi";
                        }else{
                            if($kajian_resiko_jatuh['hds']['hds3']==3){
                                $LabelHds3="Gangguan oksigenasi";
                            }else{
                                if($kajian_resiko_jatuh['hds']['hds3']==2){
                                    $LabelHds3="Kelemahan fisik/kelainan psikis";
                                }else{
                                    if($kajian_resiko_jatuh['hds']['hds3']==1){
                                        $LabelHds3="Ada diagnosis tambahan";
                                    }else{
                                        $LabelHds3="None";
                                    }
                                }
                            }
                        }
                        if($kajian_resiko_jatuh['hds']['hds4']==3){
                            $LabelHds4="Tidak memahami keterbatasan";
                        }else{
                            if($kajian_resiko_jatuh['hds']['hds4']==2){
                                $LabelHds4="Lupa keterbatasan";
                            }else{
                                if($kajian_resiko_jatuh['hds']['hds4']==1){
                                    $LabelHds4="Orientasi terhadap kelemahan";
                                }else{
                                    $LabelHds4="None";
                                }
                            }
                        }
                        if($kajian_resiko_jatuh['hds']['hds5']==4){
                            $LabelHds5="Riwayat jatuh dari tempat tidur";
                        }else{
                            if($kajian_resiko_jatuh['hds']['hds5']==3){
                                $LabelHds5="Pasien menggunakan alat bantu";
                            }else{
                                if($kajian_resiko_jatuh['hds']['hds5']==2){
                                    $LabelHds5="Pasien berada di tempat tidur";
                                }else{
                                    if($kajian_resiko_jatuh['hds']['hds5']==1){
                                        $LabelHds5="Pasien berada di luar area ruang perawatan";
                                    }else{
                                        $LabelHds5="None";
                                    }
                                }
                            }
                        }
                        if($kajian_resiko_jatuh['hds']['hds6']==3){
                            $LabelHds6="Kurang dari 24 jam";
                        }else{
                            if($kajian_resiko_jatuh['hds']['hds6']==2){
                                $LabelHds6="Kurang dari 48 jam";
                            }else{
                                if($kajian_resiko_jatuh['hds']['hds6']==1){
                                    $LabelHds6="Lebih dari 48 jam";
                                }else{
                                    $LabelHds6="None";
                                }
                            }
                        }
                        if($kajian_resiko_jatuh['hds']['hds7']==3){
                            $LabelHds7="Penggunaan obat sedative";
                        }else{
                            if($kajian_resiko_jatuh['hds']['hds7']==2){
                                $LabelHds7="Hiponotik, barbitural, fenotazin, antidepresan, laksatif/diuretik, narotik/metadon";
                            }else{
                                if($kajian_resiko_jatuh['hds']['hds7']==1){
                                    $LabelHds7="Pengobatan lain";
                                }else{
                                    $LabelHds7="None";
                                }
                            }
                        }
                        $SkorHds=$kajian_resiko_jatuh['hds']['skor'];
                        $KategoriHds=$kajian_resiko_jatuh['hds']['kategori'];
                        //EPFRA
                        if($kajian_resiko_jatuh['epfra']['epfra1']==8){
                            $LabelEpfra1="< 50 tahun";
                        }else{
                            if($kajian_resiko_jatuh['epfra']['epfra1']==10){
                                $LabelEpfra1="3-7 tahun";
                            }else{
                                if($kajian_resiko_jatuh['epfra']['epfra1']==26){
                                    $LabelEpfra1="7-13 tahun";
                                }else{
                                    $LabelEpfra1="None";
                                }
                            }
                        }
                        if($kajian_resiko_jatuh['epfra']['epfra2']==-4){
                            $LabelEpfra2="Sadar Penuh Dan Orientasi Waktu Baik";
                        }else{
                            if($kajian_resiko_jatuh['epfra']['epfra2']==13){
                                $LabelEpfra2="Agitasi/Cemas";
                            }else{
                                if($kajian_resiko_jatuh['epfra']['epfra2']==12){
                                    $LabelEpfra2="Sering Bingung";
                                }else{
                                    if($kajian_resiko_jatuh['epfra']['epfra2']==14){
                                        $LabelEpfra2="Bingung dan Disorientasi";
                                    }else{
                                        $LabelEpfra2="None";
                                    }
                                }
                            }
                        }
                        if($kajian_resiko_jatuh['epfra']['epfra3']==8){
                            $LabelEpfra3="Mandiri untuk BAB dan BAK";
                        }else{
                            if($kajian_resiko_jatuh['epfra']['epfra3']==12){
                                $LabelEpfra3="Memakai kateter/ostomy, Gangguan Eliminasi, Inkontinesia tetapi bisa ambulasi mandiri";
                            }else{
                                if($kajian_resiko_jatuh['epfra']['epfra3']==10){
                                    $LabelEpfra3="BAB dan BAK dengan Bantuan";
                                }else{
                                    $LabelEpfra3="None";
                                }
                            }
                        }
                        if($kajian_resiko_jatuh['epfra']['epfra4']==10){
                            $LabelEpfra4="Tidak ada pengobatan yang diberikan, Obat-obatan jantung";
                        }else{
                            if($kajian_resiko_jatuh['epfra']['epfra4']==8){
                                $LabelEpfra4="Obat psikiatri";
                            }else{
                                if($kajian_resiko_jatuh['epfra']['epfra4']==12){
                                    $LabelEpfra4="Meningkatnya dosis obat yang dikonsumsi";
                                }else{
                                    $LabelEpfra4="None";
                                }
                            }
                        }
                        if($kajian_resiko_jatuh['epfra']['epfra5']==8){
                            $LabelEpfra5="Penyalah gunaan zat terlarang dan alkohol";
                        }else{
                            if($kajian_resiko_jatuh['epfra']['epfra5']==10){
                                $LabelEpfra5="Bipolar / Gangguan Scizo Affective, Gangguan depresi mayor";
                            }else{
                                if($kajian_resiko_jatuh['epfra']['epfra5']==12){
                                    $LabelEpfra5="Dimensia/Delirium";
                                }else{
                                    $LabelEpfra5="None";
                                }
                            }
                        }
                        if($kajian_resiko_jatuh['epfra']['epfra6']==7){
                            $LabelEpfra6="Ambulasi Mandiri";
                        }else{
                            if($kajian_resiko_jatuh['epfra']['epfra6']==8){
                                $LabelEpfra6="Penggunaan Alat Bantu";
                            }else{
                                if($kajian_resiko_jatuh['epfra']['epfra6']==10){
                                    $LabelEpfra6="Vertigo";
                                }else{
                                    if($kajian_resiko_jatuh['epfra']['epfra6']==15){
                                        $LabelEpfra6="Tidak Menyadari Kemampuan";
                                    }else{
                                        $LabelEpfra6="None";
                                    }
                                }
                            }
                        }
                        if($kajian_resiko_jatuh['epfra']['epfra7']==0){
                            $LabelEpfra7="Nafsu Makan Baik";
                        }else{
                            if($kajian_resiko_jatuh['epfra']['epfra7']==12){
                                $LabelEpfra7="Sedikit mendapatkan asupan makanan/minum";
                            }else{
                                $LabelEpfra7="None";
                            }
                        }
                        if($kajian_resiko_jatuh['epfra']['epfra8']==8){
                            $LabelEpfra8="Tidak Ada Gangguan Tidur";
                        }else{
                            if($kajian_resiko_jatuh['epfra']['epfra8']==12){
                                $LabelEpfra8="Ada Gangguan Tidur";
                            }else{
                                $LabelEpfra8="None";
                            }
                        }
                        if($kajian_resiko_jatuh['epfra']['epfra9']==8){
                            $LabelEpfra9="Tidak Ada Riwayat Jatuh";
                        }else{
                            if($kajian_resiko_jatuh['epfra']['epfra9']==14){
                                $LabelEpfra9="Ada Riwayat Jatuh Dalam 3 Bulan";
                            }else{
                                $LabelEpfra9="None";
                            }
                        }
                        $SkorEpfra=$kajian_resiko_jatuh['epfra']['skor'];
                        $KategoriEpfra=$kajian_resiko_jatuh['epfra']['kategori'];
                    }else{
                        $pemeriksa="";
                    }
?>
    <html>
        <Header>
            <title>Triase IGD</title>
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
                <b class="f16">TRIASE DAN GAWAT DARURAT</b>
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
                        <td>ID Triase IGD</td>
                        <td>:</td>
                        <td><?php echo "$id_triase_igd"; ?></td>
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
                        <td>Tanggal & Jam Pencatatan</td>
                        <td>:</td>
                        <td><?php echo "$FormatTanggal"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.6</td>
                        <td>Tanggal & Jam Pasien Masuk</td>
                        <td>:</td>
                        <td><?php echo "$FormatTanggalMasuk"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.7</td>
                        <td>Petugas Entry</td>
                        <td>:</td>
                        <td><?php echo "$nama_petugas"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.8</td>
                        <td>Pengantar Pasien</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>A.8.1 Nama</td>
                        <td>:</td>
                        <td><?php echo "$nama_pengantar_pasien"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>A.8.2 Kontak</td>
                        <td>:</td>
                        <td><?php echo "$kontak_pengantar_pasien"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.9</td>
                        <td>Sarana Transportasi</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>A.9.1 Kategori</td>
                        <td>:</td>
                        <td><?php echo "$kategori_sarana_transportasi"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>A.9.2 Keterangan</td>
                        <td>:</td>
                        <td><?php echo "$keterangan_sarana_transportasi"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.10</td>
                        <td>Surat Pengantar Rujukan</td>
                        <td>:</td>
                        <td><?php echo "$surat_rujukan"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>A.10.1 Nomor Rujukan</td>
                        <td>:</td>
                        <td><?php echo "$no_surat_rujukan"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>A.10.2 Asal Rujukan</td>
                        <td>:</td>
                        <td><?php echo "$asal_rujukan"; ?></td>
                    </tr>
                    <tr>
                        <td colspan="5"><br></td>
                    </tr>
                    <tr>
                        <td><strong>B.</strong></td>
                        <td colspan="4"><strong>Kondisi Pasien Masuk</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>B.1</td>
                        <td>Kondisi Pasien Tiba</td>
                        <td>:</td>
                        <td><?php echo "$kategori_kondisi_pasien"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>B.1.1 Kategori</td>
                        <td>:</td>
                        <td><?php echo "$kategori_kondisi_pasien"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>B.1.2 Keterangan/Penjelasan</td>
                        <td>:</td>
                        <td><?php echo "$kategori_kondisi_pasien"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>B.2</td>
                        <td>Kesadaran Pasien</td>
                        <td>:</td>
                        <td><?php echo "$kesadaran_pasien"; ?></td>
                    </tr>
                    <tr>
                        <td colspan="5"><br></td>
                    </tr>
                    <tr>
                        <td><strong>C.</strong></td>
                        <td colspan="4"><strong>Asesmen Nyeri</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>C.1</td>
                        <td>Apakah Terdapat Keluhan Nyeri</td>
                        <td>:</td>
                        <td><?php echo "$AdaTidakNyeri"; ?></td>
                    </tr>
                    <?php if($AdaTidakNyeri=="Ada"){ ?>
                        <tr>
                            <td></td>
                            <td>C.2</td>
                            <td>Lokasi Nyeri</td>
                            <td>:</td>
                            <td><?php echo "$lokasi_nyeri"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>C.3</td>
                            <td>Penyebab Nyeri</td>
                            <td>:</td>
                            <td><?php echo "$penyebab_nyeri"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>C.4</td>
                            <td>Gurasi Nyeri</td>
                            <td>:</td>
                            <td><?php echo "$durasi_nyeri"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>C.5</td>
                            <td>Frekuenasi Nyeri</td>
                            <td>:</td>
                            <td><?php echo "$frekuensi_nyeri"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>C.6</td>
                            <td>Skala Nyeri</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>C.6.1 Skala VAS</td>
                            <td>:</td>
                            <td><?php echo "$skor_skala_vas ($kategori_skala_vas)"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>C.6.2 Skala NRS</td>
                            <td>:</td>
                            <td><?php echo "$skor_skala_nrs ($kategori_skala_nrs)"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>C.6.3 Skala VRS</td>
                            <td>:</td>
                            <td><?php echo "$skor_skala_vrs ($kategori_skala_vrs)"; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>C.6.4 Skala NIPS</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td colspan="3">
                                <table class="border" width="100%">
                                    <tr>
                                        <td align="center"><b>No</b></td>
                                        <td align="center"><b>Kriteria</b></td>
                                        <td align="center"><b>Skor</b></td>
                                        <td align="center"><b>Keterangan</b></td>
                                    </tr>
                                    <tr>
                                        <td align="center">1</td>
                                        <td>Facial Expression</td>
                                        <td align="center"><?php echo $asesmen_nyeri['skala_nips']['skala_nips1']; ?></td>
                                        <td><?php echo $LabelNips1; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="center">2</td>
                                        <td>Cry</td>
                                        <td align="center"><?php echo $asesmen_nyeri['skala_nips']['skala_nips1']; ?></td>
                                        <td><?php echo $LabelNips2; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="center">3</td>
                                        <td>Breathing Pattern</td>
                                        <td align="center"><?php echo $asesmen_nyeri['skala_nips']['skala_nips2']; ?></td>
                                        <td><?php echo $LabelNips3; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="center">4</td>
                                        <td>Arms</td>
                                        <td align="center"><?php echo $asesmen_nyeri['skala_nips']['skala_nips3']; ?></td>
                                        <td><?php echo $LabelNips4; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="center">5</td>
                                        <td>Legs</td>
                                        <td align="center"><?php echo $asesmen_nyeri['skala_nips']['skala_nips4']; ?></td>
                                        <td><?php echo $LabelNips5; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="center">6</td>
                                        <td>State Of Arousal</td>
                                        <td align="center"><?php echo $asesmen_nyeri['skala_nips']['skala_nips5']; ?></td>
                                        <td><?php echo $LabelNips6; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Jumlah</td>
                                        <td align="center"><?php echo $skor_skala_nips; ?></td>
                                        <td><?php echo $kategori_skala_nips; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="5"><br></td>
                    </tr>
                    <tr>
                        <td><strong>D.</strong></td>
                        <td colspan="4"><strong>Kajian Resiko Jatuh</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>C.1</td>
                        <td>Nakes Pemeriksa</td>
                        <td>:</td>
                        <td><?php echo "$pemeriksa"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>C.2</td>
                        <td colspan="3">MFS <i>(Morse Fall Scale)</i></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="3">
                            <table class="border" width="100%">
                                <tr>
                                    <td align="center"><b>No</b></td>
                                    <td align="center"><b>Kriteria</b></td>
                                    <td align="center"><b>Skor</b></td>
                                    <td align="center"><b>Keterangan</b></td>
                                </tr>
                                <tr>
                                    <td align="center">1</td>
                                    <td>Riwayat jatuh</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['mfs']['mfs1']; ?></td>
                                    <td><?php echo $LabelMfs1; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">2</td>
                                    <td>Diagnosis Lain</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['mfs']['mfs1']; ?></td>
                                    <td><?php echo $LabelMfs1; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">3</td>
                                    <td>Bantuan Berjalan</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['mfs']['mfs1']; ?></td>
                                    <td><?php echo $LabelMfs1; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">4</td>
                                    <td>Heparin Lock</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['mfs']['mfs1']; ?></td>
                                    <td><?php echo $LabelMfs1; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">5</td>
                                    <td>Cara Berjalan/Berpindah</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['mfs']['mfs1']; ?></td>
                                    <td><?php echo $LabelMfs1; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">6</td>
                                    <td>Status Mental</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['mfs']['mfs1']; ?></td>
                                    <td><?php echo $LabelMfs1; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Jumlah</td>
                                    <td align="center"><?php echo $SkorMfs; ?></td>
                                    <td><?php echo $KategoriMfs; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>C.3</td>
                        <td colspan="3">HDS <i>(Humpty Dumpty Scale)</i></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="3">
                            <table class="border" width="100%">
                                <tr>
                                    <td align="center"><b>No</b></td>
                                    <td align="center"><b>Kriteria</b></td>
                                    <td align="center"><b>Skor</b></td>
                                    <td align="center"><b>Keterangan</b></td>
                                </tr>
                                <tr>
                                    <td align="center">1</td>
                                    <td>Umur</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['hds']['hds1']; ?></td>
                                    <td><?php echo $LabelHds1; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">2</td>
                                    <td>Jenis Kelamin</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['hds']['hds2']; ?></td>
                                    <td><?php echo $LabelHds2; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">3</td>
                                    <td>Diagnosis</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['hds']['hds3']; ?></td>
                                    <td><?php echo $LabelHds3; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">4</td>
                                    <td>Gangguan kognitif</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['hds']['hds4']; ?></td>
                                    <td><?php echo $LabelHds4; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">5</td>
                                    <td>Faktor lingkungan</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['hds']['hds5']; ?></td>
                                    <td><?php echo $LabelHds5; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">6</td>
                                    <td>Respon terhadap obat</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['hds']['hds6']; ?></td>
                                    <td><?php echo $LabelHds6; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">6</td>
                                    <td>Penggunaan obat</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['hds']['hds7']; ?></td>
                                    <td><?php echo $LabelHds7; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Jumlah</td>
                                    <td align="center"><?php echo $SkorHds; ?></td>
                                    <td><?php echo $KategoriHds; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>C.4</td>
                        <td colspan="3"> EPFRA  <i>(Edmonson Psychiatric Fall Risk Assessment)</i></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="3">
                            <table class="border" width="100%">
                                <tr>
                                    <td align="center"><b>No</b></td>
                                    <td align="center"><b>Kriteria</b></td>
                                    <td align="center"><b>Skor</b></td>
                                    <td align="center"><b>Keterangan</b></td>
                                </tr>
                                <tr>
                                    <td align="center">1</td>
                                    <td>Umur</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['epfra']['epfra1']; ?></td>
                                    <td><?php echo $LabelEpfra1; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">2</td>
                                    <td>Status Mental</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['epfra']['epfra2']; ?></td>
                                    <td><?php echo $LabelEpfra2; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">3</td>
                                    <td>Eliminasi</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['epfra']['epfra3']; ?></td>
                                    <td><?php echo $LabelEpfra3; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">4</td>
                                    <td>Medikasi</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['epfra']['epfra4']; ?></td>
                                    <td><?php echo $LabelEpfra4; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">5</td>
                                    <td>Diagnosis</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['epfra']['epfra5']; ?></td>
                                    <td><?php echo $LabelEpfra5; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">6</td>
                                    <td>Ambulasi/Keseimbangan</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['epfra']['epfra6']; ?></td>
                                    <td><?php echo $LabelEpfra6; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">7</td>
                                    <td>Nutrisi</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['epfra']['epfra7']; ?></td>
                                    <td><?php echo $LabelEpfra7; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">8</td>
                                    <td>Gangguan Tidur</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['epfra']['epfra8']; ?></td>
                                    <td><?php echo $LabelEpfra8; ?></td>
                                </tr>
                                <tr>
                                    <td align="center">9</td>
                                    <td>Riwayat Jatuh</td>
                                    <td align="center"><?php echo $kajian_resiko_jatuh['epfra']['epfra9']; ?></td>
                                    <td><?php echo $LabelEpfra9; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Jumlah</td>
                                    <td align="center"><?php echo $SkorEpfra; ?></td>
                                    <td><?php echo $KategoriEpfra; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </body>
    </html>
<?php }}}} ?>