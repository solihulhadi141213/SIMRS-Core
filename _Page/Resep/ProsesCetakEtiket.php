<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_GET['id_resep'])){
        echo 'ID Resep Tidak Boleh Kosong!';
    }else{
        if(empty($_GET['FormatCetak'])){
            echo 'Format Cetak Tidak Boleh Kosong!';
        }else{
            if(empty($_GET['TampilkanHeader'])){
                echo 'Header Cetak Tidak Boleh Kosong!';
            }else{
                if(empty($_GET['id'])){
                    echo 'ID Etiket Tidak Boleh Kosong!';
                }else{
                    if(empty($_GET['TampilkanObat'])){
                        echo 'Informasi tampilkan Obat Tidak Boleh Kosong!';
                    }else{
                        $TampilkanObat=$_GET['TampilkanObat'];
                        $id_resep=$_GET['id_resep'];
                        $FormatCetak=$_GET['FormatCetak'];
                        $TampilkanHeader=$_GET['TampilkanHeader'];
                        $id=$_GET['id'];
                        //Validasi Keberadaan Data
                        $id_resep=getDataDetail($Conn,"resep",'id_resep',$id_resep,'id_resep');
                        if(empty($id_resep)){
                            echo 'ID Yang Anda Gunakan Tidak Valid/Tidak Ditemukan Pada Database!';
                        }else{
                            //Membuka Detail
                            $id_kunjungan=getDataDetail($Conn,"resep",'id_resep',$id_resep,'id_kunjungan');
                            $id_pasien=getDataDetail($Conn,"resep",'id_resep',$id_resep,'id_pasien');
                            $nama_pasien=getDataDetail($Conn,"resep",'id_resep',$id_resep,'nama_pasien');
                            $petugas_entry=getDataDetail($Conn,"resep",'id_resep',$id_resep,'petugas_entry');
                            $tanggal_entry=getDataDetail($Conn,"resep",'id_resep',$id_resep,'tanggal_entry');
                            $tanggal_resep=getDataDetail($Conn,"resep",'id_resep',$id_resep,'tanggal_resep');
                            $IdDokter=getDataDetail($Conn,"resep",'id_resep',$id_resep,'id_dokter');
                            $nama_dokter=getDataDetail($Conn,"resep",'id_resep',$id_resep,'nama_dokter');
                            $kontak_dokter=getDataDetail($Conn,"resep",'id_resep',$id_resep,'kontak_dokter');
                            $obat=getDataDetail($Conn,"resep",'id_resep',$id_resep,'obat');
                            $catatan=getDataDetail($Conn,"resep",'id_resep',$id_resep,'catatan');
                            $status=getDataDetail($Conn,"resep",'id_resep',$id_resep,'status');
                            $ttd_dokter=getDataDetail($Conn,"resep",'id_resep',$id_resep,'ttd_dokter');
                            //Json Decode
                            $JsonNamaPasien=json_decode($nama_pasien, true);
                            $JsonKontakDokter =json_decode($kontak_dokter, true);
                            $JsonObat =json_decode($obat, true);
                            foreach($JsonObat as $ListObat){
                                if($ListObat['id']==$id){
                                    $NamaObat=$ListObat['nama_obat'];
                                    $bentuk_sediaan=$ListObat['bentuk_sediaan'];
                                    $jumlah_obat=$ListObat['jumlah_obat'];
                                    $metode=$ListObat['metode'];
                                    $dosis=$ListObat['dosis'];
                                    $unit=$ListObat['unit'];
                                    $frekuensi=$ListObat['frekuensi'];
                                    $aturan_tambahan=$ListObat['aturan_tambahan'];
                                }
                            }
                            //Buka Pasien
                            $NamaPasien=$JsonNamaPasien['nama_pasien'];
                            $TanggalLahir=$JsonNamaPasien['tanggal_lahir'];
                            $BeratBadan=$JsonNamaPasien['berat_badan'];
                            $TinggiBadan=$JsonNamaPasien['tinggi_badan'];
                            $LuasTubuh=$JsonNamaPasien['luas_tubuh'];
                            //Format Tanggal
                            $strtotime1=strtotime($tanggal_entry);
                            $strtotime2=strtotime($tanggal_resep);
                            $TanggalEntry=date('d/m/Y H:i T',$strtotime1);
                            $TanggalResep=date('d/m/Y H:i T',$strtotime2);
                            //Routing Format
                            if($FormatCetak=="PDF"){
                                //koneksi dan error
                                $FileName= "Etiket-$id_resep-$id";
                                //Config Plugin MPDF
                                require_once '../../vendor/autoload.php';
                                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'A4']);
                                $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
                                //Beginning Buffer to save PHP variables and HTML tags
                                ob_start(); 
                            }
?>
    <html>
        <Header>
            <title>Etiket Obat</title>
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
                <table class="data" cellspacing="0px">
                    <tr>
                        <td>Tgl</td>
                        <td>:</td>
                        <td colspan="3"><?php echo "$TanggalResep"; ?></td>
                    </tr>
                    <tr>
                        <td>No.RM</td>
                        <td>:</td>
                        <td colspan="3"><?php echo "$id_pasien"; ?></td>
                    </tr>
                    <tr>
                        <td>Pasien</td>
                        <td>:</td>
                        <td colspan="3"><?php echo "$NamaPasien"; ?></td>
                    </tr>
                </table>
            </div>
            <div class="kop">
                <table class="data" cellspacing="0px">
                    <tr>
                        <td colspan="5">
                            <?php
                                if($TampilkanObat=="Ya"){
                                    echo "<h3>$NamaObat</h3>"; 
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Sediaan</td>
                        <td>:</td>
                        <td colspan="3"><?php echo "$bentuk_sediaan"; ?></td>
                    </tr>
                    <tr>
                        <td>Dosis</td>
                        <td>:</td>
                        <td colspan="3"><?php echo "$dosis $unit"; ?></td>
                    </tr>
                    <tr>
                        <td>Frekuensi</td>
                        <td>:</td>
                        <td colspan="3"><?php echo "$frekuensi"; ?></td>
                    </tr>
                    <tr>
                        <td>Aturan Tambahan</td>
                        <td>:</td>
                        <td colspan="3"><?php echo "$aturan_tambahan"; ?></td>
                    </tr>
                </table>
            </div>
            <div class="kop">
                <table class="data" cellspacing="0px">
                    <tr>
                        <td colspan="5"><i>Semoga Lekas Sembuh</i></td>
                    </tr>
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
<?php }}}}}} ?>