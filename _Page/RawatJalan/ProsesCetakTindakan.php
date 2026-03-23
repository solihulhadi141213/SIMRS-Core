<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    
    if(empty($_GET['id_tindakan'])){
        echo 'ID Persetujuan Tindakan Tidak Boleh Kosong!';
    }else{
        if(empty($_GET['FormatCetak'])){
            echo 'Format Cetak Tidak Boleh Kosong!';
        }else{
            if(empty($_GET['TampilkanHeader'])){
                echo 'Header Cetak Tidak Boleh Kosong!';
            }else{
                $id_tindakan=$_GET['id_tindakan'];
                $FormatCetak=$_GET['FormatCetak'];
                $TampilkanHeader=$_GET['TampilkanHeader'];
                //Validasi Keberadaan Data
                $id_tindakan=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'id_tindakan');
                if(empty($id_tindakan)){
                    echo 'ID Yang Anda Gunakan Tidak Valid/Tidak Ditemukan Pada Database!';
                }else{
                    //Membuka Detail
                    $id_pasien=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'id_pasien');
                    $id_kunjungan=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'id_kunjungan');
                    $id_akses=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'id_akses');
                    $nama_pasien=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'nama_pasien');
                    $nama_petugas=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'nama_petugas');
                    $tanggal_entry=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'tanggal_entry');
                    $tanggal_pelaksanaan=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'tanggal_pelaksanaan');
                    $waktu_mulai=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'waktu_mulai');
                    $waktu_selesai=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'waktu_selesai');
                    $kode_tindakan=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'kode_tindakan');
                    $nama_tindakan=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'nama_tindakan');
                    $alat_medis=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'alat_medis');
                    $bmhp=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'bmhp');
                    $nakes=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'nakes');
                    //Json Decode
                    $JsonAlatMedis=json_decode($alat_medis, true);
                    $JsonBmhp =json_decode($bmhp, true);
                    $JsonNakes=json_decode($nakes, true);
                    //Format Tanggal
                    $strtotime1=strtotime($tanggal_entry);
                    $strtotime2=strtotime($tanggal_pelaksanaan);
                    $FormatTanggalEntry=date('d/m/Y H:i T',$strtotime1);
                    $FormatTanggalPelaksanaan=date('d/m/Y',$strtotime2);

                    //Buka Kunjungan
                    $dokter=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'dokter');
                    $poliklinik=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'poliklinik');
                    $dokter=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'dokter');
                    $tanggal=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'tanggal');
                    $DiagAwal=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'DiagAwal');
                    $nik=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'nik');
                    $id_encounter=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_encounter');

                    //Buka Pasien
                    $id_ihs=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'id_ihs');
?>
    <html>
        <Header>
            <title>Lembar Tindakan</title>
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
                    position: relative;
                }

                body::before {
                    content: "RAHASIA";
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    font-size: 100px;
                    color: rgba(200, 0, 0, 0.1); /* Merah samar */
                    transform: translate(-50%, -50%) rotate(-45deg);
                    z-index: 0;
                    white-space: nowrap;
                    pointer-events: none;
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
                <b class="f16">LEMBAR TINDAKAN</b>
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
                        <td>ID REG/RM</td>
                        <td>:</td>
                        <td><?php echo "$id_kunjungan/$id_pasien"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.2</td>
                        <td>NIK/KTP</td>
                        <td>:</td>
                        <td><?php echo "$nik"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.3</td>
                        <td>ID.Encounter</td>
                        <td>:</td>
                        <td><?php echo "$id_encounter"; ?></td>
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
                        <td>Poliklinik</td>
                        <td>:</td>
                        <td><?php echo "$poliklinik"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.6</td>
                        <td>Dokter DPJP</td>
                        <td>:</td>
                        <td><?php echo "$dokter"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.7</td>
                        <td>Tanggal Kunjungan</td>
                        <td>:</td>
                        <td><?php echo date('d/m/Y', strtotime($tanggal)); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.8</td>
                        <td>Diagnosa Awal</td>
                        <td>:</td>
                        <td><?php echo "$DiagAwal"; ?></td>
                    </tr>
                    <tr>
                        <td colspan="5"><br></td>
                    </tr>
                    <tr>
                        <td><strong>B.</strong></td>
                        <td colspan="4"><strong>Informasi Tindakan</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>B.1</td>
                        <td>Kode Tindakan</td>
                        <td>:</td>
                        <td><?php echo "$kode_tindakan"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>B.2</td>
                        <td>Nama Tindakan</td>
                        <td>:</td>
                        <td><?php echo "$nama_tindakan"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>B.3</td>
                        <td>Tanggal Pelaksanaan</td>
                        <td>:</td>
                        <td><?php echo "$tanggal"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>B.4</td>
                        <td>Waktu Pelaksanaan</td>
                        <td>:</td>
                        <td><?php echo "$waktu_mulai - $waktu_selesai"; ?></td>
                    </tr>
                    <tr>
                        <td colspan="5"><br></td>
                    </tr>
                    <tr>
                        <td><strong>C.</strong></td>
                        <td colspan="4"><strong>Instrumen Tindakan</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td valign="top">C.1</td>
                        <td valign="top">Tenaga Kesehatan</td>
                        <td valign="top">:</td>
                        <td valign="top">
                            <?php 
                                foreach($JsonNakes as $nakes_list){
                                    $kategori=$nakes_list['kategori'];
                                    $nakes_list=$nakes_list['nama'];
                                    echo "- $nakes_list ($kategori)<br>";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td valign="top">C.2</td>
                        <td valign="top">Alat Medis</td>
                        <td valign="top">:</td>
                        <td valign="top">
                            <?php 
                                foreach($JsonAlatMedis as $alat_medis_list){
                                    $alkes=$alat_medis_list['alkes'];
                                    echo "- $alkes<br>";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td valign="top">C.3</td>
                        <td valign="top">Bahan Medis (MBHP)</td>
                        <td valign="top">:</td>
                        <td valign="top">
                            <?php 
                                foreach($JsonBmhp as $bmhp_list){
                                    $bmhp=$bmhp_list['bmhp'];
                                    echo "- $bmhp<br>";
                                }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
            <table class="data" cellspacing="0px">
                <tr>
                    <td align="center">
                        
                        <img src="../../view_qr.php?data=<?php echo $id_encounter ?>" width="100px" />
                    </td>
                    <td>
                        <i>
                            Informasi tindakan medis ini sudah terkirim ke platform Satu Sehat dengan uraian berikut, <br>
                            ID Encounter : <?php echo "$id_encounter"; ?><br>
                            ID IHS : <?php echo "$id_ihs"; ?><br>
                        </i>
                    </td>
                </tr>
            </table>
        </body>
    </html>
<?php }}}} ?>