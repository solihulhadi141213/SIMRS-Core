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
                if(empty($_GET['TampilkanPengkajian'])){
                    echo 'Informasi Cetak Pengkajian Tidak Boleh Kosong!';
                }else{
                    $id_resep=$_GET['id_resep'];
                    $FormatCetak=$_GET['FormatCetak'];
                    $TampilkanHeader=$_GET['TampilkanHeader'];
                    $TampilkanPengkajian=$_GET['TampilkanPengkajian'];
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
                        //Pengkajian
                        $pengkajian=getDataDetail($Conn,'resep','id_resep',$id_resep,'pengkajian');
                        //Routing Pengkajian
                        if(empty($pengkajian)){
                            $LabelPengkajian='<span class="text-danger">Belum Ada</strong>';
                            $JsonPengkajian="";
                            $Pengkajian1="";
                            $Pengkajian2="";
                            $Pengkajian3="";
                            $Pengkajian4="";
                            $Pengkajian5="";
                            $Pengkajian6="";
                            $Pengkajian7="";
                            $Pengkajian8="";
                            $Pengkajian9="";
                            $Pengkajian10="";
                            $Pengkajian11="";
                            $Pengkajian12="";
                            $Pengkajian13="";
                            $KeteranganPengkajian1="";
                            $KeteranganPengkajian2="";
                            $KeteranganPengkajian3="";
                            $KeteranganPengkajian4="";
                            $KeteranganPengkajian5="";
                            $KeteranganPengkajian6="";
                            $KeteranganPengkajian7="";
                            $KeteranganPengkajian8="";
                            $KeteranganPengkajian9="";
                            $KeteranganPengkajian10="";
                            $KeteranganPengkajian11="";
                            $KeteranganPengkajian12="";
                            $KeteranganPengkajian13="";
                            $petugas_pengkajian="";
                            $ttd_pengkaji="";
                            $LabelTandaTanganPengkaji='';
                        }else{
                            $LabelPengkajian='<span class="text-success">Sudah Ada</strong>';
                            $JsonPengkajian=json_decode($pengkajian, true);
                            //Buka data pengkajian
                            $Pengkajian1=$JsonPengkajian['pengkajian1']['value'];
                            $Pengkajian2=$JsonPengkajian['pengkajian2']['value'];
                            $Pengkajian3=$JsonPengkajian['pengkajian3']['value'];
                            $Pengkajian4=$JsonPengkajian['pengkajian4']['value'];
                            $Pengkajian5=$JsonPengkajian['pengkajian5']['value'];
                            $Pengkajian6=$JsonPengkajian['pengkajian6']['value'];
                            $Pengkajian7=$JsonPengkajian['pengkajian7']['value'];
                            $Pengkajian8=$JsonPengkajian['pengkajian8']['value'];
                            $Pengkajian9=$JsonPengkajian['pengkajian9']['value'];
                            $Pengkajian10=$JsonPengkajian['pengkajian10']['value'];
                            $Pengkajian11=$JsonPengkajian['pengkajian11']['value'];
                            $Pengkajian12=$JsonPengkajian['pengkajian12']['value'];
                            $Pengkajian13=$JsonPengkajian['pengkajian13']['value'];
                            $KeteranganPengkajian1=$JsonPengkajian['pengkajian1']['keterangan'];
                            $KeteranganPengkajian2=$JsonPengkajian['pengkajian2']['keterangan'];
                            $KeteranganPengkajian3=$JsonPengkajian['pengkajian3']['keterangan'];
                            $KeteranganPengkajian4=$JsonPengkajian['pengkajian4']['keterangan'];
                            $KeteranganPengkajian5=$JsonPengkajian['pengkajian5']['keterangan'];
                            $KeteranganPengkajian6=$JsonPengkajian['pengkajian6']['keterangan'];
                            $KeteranganPengkajian7=$JsonPengkajian['pengkajian7']['keterangan'];
                            $KeteranganPengkajian8=$JsonPengkajian['pengkajian8']['keterangan'];
                            $KeteranganPengkajian9=$JsonPengkajian['pengkajian9']['keterangan'];
                            $KeteranganPengkajian10=$JsonPengkajian['pengkajian10']['keterangan'];
                            $KeteranganPengkajian11=$JsonPengkajian['pengkajian11']['keterangan'];
                            $KeteranganPengkajian12=$JsonPengkajian['pengkajian12']['keterangan'];
                            $KeteranganPengkajian13=$JsonPengkajian['pengkajian13']['keterangan'];
                            $petugas_pengkajian=$JsonPengkajian['petugas_pengkajian'];
                            if(!empty($JsonPengkajian['ttd_pengkaji'])){
                                $ttd_pengkaji=$JsonPengkajian['ttd_pengkaji'];
                                $LabelTandaTanganPengkaji='<br><img src="data:image/gif;base64,'. $ttd_pengkaji .'" width="150px">';
                            }else{
                                $ttd_pengkaji="";
                                $LabelTandaTanganPengkaji='';
                            }
                        }
                        if($FormatCetak=="PDF"){
                            //koneksi dan error
                            $FileName= "Resep-$id_resep";
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
            <title>Resep Obat</title>
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
                <b class="f16">RESEP OBAT</b>
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
                        <td>ID Resep/Reg</td>
                        <td>:</td>
                        <td><?php echo "$id_resep/$id_kunjungan"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.2</td>
                        <td>No.RM</td>
                        <td>:</td>
                        <td><?php echo "$id_pasien"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.3</td>
                        <td>Nama Pasien</td>
                        <td>:</td>
                        <td><?php echo "$NamaPasien"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.4</td>
                        <td>Tanggal Lahir</td>
                        <td>:</td>
                        <td><?php echo "$TanggalLahir"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.5</td>
                        <td>Tinggi/Berat Badan</td>
                        <td>:</td>
                        <td><?php echo "$TinggiBadan m/ $BeratBadan Kg"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>A.6</td>
                        <td>Luas Tubuh</td>
                        <td>:</td>
                        <td><?php echo "$LuasTubuh m2"; ?></td>
                    </tr>
                    <tr>
                        <td><strong>B.</strong></td>
                        <td colspan="4"><strong>Informasi Data</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>B.1</td>
                        <td>Tgl & Jam Entry</td>
                        <td>:</td>
                        <td><?php echo "$TanggalEntry"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>B.2</td>
                        <td>Tgl & Jam Resep</td>
                        <td>:</td>
                        <td><?php echo "$TanggalResep"; ?></td>
                    </tr>
                    <tr>
                        <td><strong>C.</strong></td>
                        <td colspan="4"><strong>Informasi Dokter</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>C.1</td>
                        <td>Nama Dokter</td>
                        <td>:</td>
                        <td><?php echo "$nama_dokter"; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>C.2</td>
                        <td>Kontak Dokter</td>
                        <td>:</td>
                        <td>
                            <?php 
                            if(!empty($kontak_dokter)){
                                if(!empty(count($JsonKontakDokter))){
                                    foreach($JsonKontakDokter as $ListKontakDokter){
                                        echo '- '.$ListKontakDokter['nomor_kontak'].' ('.$ListKontakDokter['kategori_kontak'].')<br>';
                                    }
                                }
                            }
                                
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>D.</strong></td>
                        <td colspan="4"><strong>Uraian Resep</strong></td>
                    </tr>
                    <?php
                        if(!empty($obat)){
                            if(!empty(count($JsonObat))){
                                $no=1;
                                foreach($JsonObat as $ListObat){
                                    echo '<tr>';
                                    echo '  <td></td>';
                                    echo '  <td>'.$no.'</td>';
                                    echo '  <td colspan="3">'.$ListObat['nama_obat'].'</td>';
                                    echo '</tr>';
                                    echo '<tr>';
                                    echo '  <td></td>';
                                    echo '  <td></td>';
                                    echo '  <td>Jumlah</td>';
                                    echo '  <td colspan="2">'.$ListObat['jumlah_obat'].' '.$ListObat['bentuk_sediaan'].'</td>';
                                    echo '</tr>';
                                    echo '<tr>';
                                    echo '  <td></td>';
                                    echo '  <td></td>';
                                    echo '  <td>Metode</td>';
                                    echo '  <td colspan="2">'.$ListObat['metode'].'</td>';
                                    echo '</tr>';
                                    echo '<tr>';
                                    echo '  <td></td>';
                                    echo '  <td></td>';
                                    echo '  <td>Dosis</td>';
                                    echo '  <td colspan="2">'.$ListObat['dosis'].' '.$ListObat['unit'].'</td>';
                                    echo '</tr>';
                                    echo '<tr>';
                                    echo '  <td></td>';
                                    echo '  <td></td>';
                                    echo '  <td>Frekuensi</td>';
                                    echo '  <td colspan="2">'.$ListObat['frekuensi'].'</td>';
                                    echo '</tr>';
                                    echo '<tr>';
                                    echo '  <td></td>';
                                    echo '  <td></td>';
                                    echo '  <td>Aturan Tambahan</td>';
                                    echo '  <td colspan="2">'.$ListObat['aturan_tambahan'].'</td>';
                                    echo '</tr>';
                                    $no++;
                                }
                            }
                        }
                    ?>
                    <tr>
                        <td><strong>E.</strong></td>
                        <td colspan="4"><strong>Catatan Dokter</strong></td>
                    </tr>
                    <tr>
                        <td><strong></strong></td>
                        <td colspan="4"><?php echo "$catatan"; ?></td>
                    </tr>
                    <tr>
                        <td><strong>F.</strong></td>
                        <td colspan="4"><strong>Status Resep</strong></td>
                    </tr>
                    <tr>
                        <td><strong></strong></td>
                        <td colspan="4"><?php echo "$status"; ?></td>
                    </tr>
                    <?php
                        if($TampilkanPengkajian=="Ya"){
                            if(!empty($pengkajian)){
                                echo '<tr>';
                                echo '  <td colspan="5">';
                                echo '      <strong>Pengkajian Resep</strong>';
                                echo '  </td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '  <td colspan="5">';
                                echo '      <p>Persyaratan Administrasi</p>';
                                echo '<ol>';
                                echo '  <li>';
                                echo '      Nama, umur, jenis kelamin, berat badan dan tinggi badan Pasien : <strong>'.$Pengkajian1.'</strong><br>';
                                    if(!empty($KeteranganPengkajian1)){
                                        echo '(<strong>'.$KeteranganPengkajian1.'</strong>)';
                                    }
                                echo '  </li>';
                                echo '  <li>';
                                echo '      Nama, nomor ijin, alamat dan paraf dokter : <strong>'.$Pengkajian2.'</strong><br>';
                                    if(!empty($KeteranganPengkajian2)){
                                        echo '(<strong>'.$KeteranganPengkajian2.'</strong>)';
                                    }
                                echo '  </li>';
                                echo '  <li>';
                                echo '      Tanggal resep : <strong>'.$Pengkajian3.'</strong><br>';
                                    if(!empty($KeteranganPengkajian3)){
                                        echo '(<strong>'.$KeteranganPengkajian3.'</strong>)';
                                    }
                                echo '  </li>';
                                echo '  <li>';
                                echo '      Ruangan/unit asal resep : <strong>'.$Pengkajian4.'</strong><br>';
                                    if(!empty($KeteranganPengkajian4)){
                                        echo '(<strong>'.$KeteranganPengkajian4.'</strong>)';
                                    }
                                echo '  </li>';
                                echo '</ol>';
                                echo '      <p>Persyaratan Farmasetik</p>';
                                echo '<ol>';
                                echo '  <li>';
                                echo '      Nama obat, bentuk dan kekuatan sediaan : <strong>'.$Pengkajian5.'</strong><br>';
                                    if(!empty($KeteranganPengkajian5)){
                                        echo '(<strong>'.$KeteranganPengkajian5.'</strong>)';
                                    }
                                echo '  </li>';
                                echo '  <li>';
                                echo '      Dosis dan jumlah obat : <strong>'.$Pengkajian6.'</strong><br>';
                                    if(!empty($KeteranganPengkajian6)){
                                        echo '(<strong>'.$KeteranganPengkajian6.'</strong>)';
                                    }
                                echo '  </li>';
                                echo '  <li>';
                                echo '      Stabilitas : <strong>'.$Pengkajian7.'</strong><br>';
                                    if(!empty($KeteranganPengkajian7)){
                                        echo '(<strong>'.$KeteranganPengkajian7.'</strong>)';
                                    }
                                echo '  </li>';
                                echo '  <li>';
                                echo '      Aturan dan cara penggunaan <strong>'.$Pengkajian8.'</strong><br>';
                                    if(!empty($KeteranganPengkajian8)){
                                        echo '(<strong>'.$KeteranganPengkajian8.'</strong>)';
                                    }
                                echo '  </li>';
                                echo '</ol>';
                                echo '      <p>Persyaratan Klinis</p>';
                                echo '<ol>';
                                echo '  <li>';
                                echo '      Ketepatan indikasi, dosis, dan waktu penggunaan obat  <strong>'.$Pengkajian9.'</strong><br>';
                                    if(!empty($KeteranganPengkajian9)){
                                        echo '(<strong>'.$KeteranganPengkajian9.'</strong>)';
                                    }
                                echo '  </li>';
                                echo '  <li>';
                                echo '      Duplikasi pengobatan  <strong>'.$Pengkajian10.'</strong><br>';
                                    if(!empty($KeteranganPengkajian10)){
                                        echo '(<strong>'.$KeteranganPengkajian10.'</strong>)';
                                    }
                                echo '  </li>';
                                echo '  <li>';
                                echo '      Alergi dan Reaksi Obat yang Tidak Dikehendaki (ROTD)  <strong>'.$Pengkajian11.'</strong><br>';
                                    if(!empty($KeteranganPengkajian11)){
                                        echo '(<strong>'.$KeteranganPengkajian11.'</strong>)';
                                    }
                                echo '  </li>';
                                echo '  <li>';
                                echo '      Kontraindikasi  <strong>'.$Pengkajian12.'</strong><br>';
                                    if(!empty($KeteranganPengkajian12)){
                                        echo '(<strong>'.$KeteranganPengkajian12.'</strong>)';
                                    }
                                echo '  </li>';
                                echo '  <li>';
                                echo '      Interaksi obat   <strong>'.$Pengkajian13.'</strong><br>';
                                    if(!empty($KeteranganPengkajian13)){
                                        echo '(<strong>'.$KeteranganPengkajian13.'</strong>)';
                                    }
                                echo '  </li>';
                                echo '</ol>';
                                echo '  </td>';
                                echo '</tr>';
                            }
                        }
                    ?>
                </table>
            </div>
            <div class="kop">
                <table class="data" cellspacing="0px" width="100%">
                    <tr>
                        <td align="center"> Tanda Tangan Dokter</td>
                        <td align="center">Tanda Tangan Pengkaji</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <?php
                                echo '<img src="data:image/gif;base64,'. $ttd_dokter .'" width="100px"><br>';
                            ?>
                        </td>
                        <td align="center">
                            <?php
                                echo '<img src="data:image/gif;base64,'. $ttd_pengkaji .'" width="100px"><br>';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <?php echo '('.$nama_dokter.')'; ?>
                        </td>
                        <td align="center">
                            <?php echo '('.$petugas_pengkajian.')'; ?>
                        </td>
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
<?php }}}}} ?>