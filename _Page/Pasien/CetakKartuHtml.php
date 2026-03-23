<?php
    if(empty($_GET['id_pasien'])){
        echo "Error: ID Pasien tidak ditemukan";
    }else{
        //Koneksi
        date_default_timezone_set('Asia/Jakarta');
        include "../../_Config/Connection.php";
        include "../../_Config/Session.php";
        include "../../_Config/Setting.php";
        include "../../_Config/SettingFaskes.php";
        include "../../_Config/SettingCetakKartuPasien.php";
        $id_pasien= $_GET['id_pasien'];
        //Buka data Pasien
        $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$id_pasien'")or die(mysqli_error($Conn));
        $DataPasien = mysqli_fetch_array($QryPasien);
        if(empty($DataPasien['id_pasien'])){
            echo "Error: Data Pasien tidak ditemukan";
        }else{
            $noRm=sprintf("%07d", $id_pasien);
            $tanggal_daftar= $DataPasien['tanggal_daftar'];
            $nik= $DataPasien['nik'];
            $no_bpjs= $DataPasien['no_bpjs'];
            $nama= $DataPasien['nama'];
            $gender= $DataPasien['gender'];
            $tempat_lahir= $DataPasien['tempat_lahir'];
            $tanggal_lahir= $DataPasien['tanggal_lahir'];
            $propinsi= $DataPasien['propinsi'];
            $kabupaten= $DataPasien['kabupaten'];
            $kecamatan= $DataPasien['kecamatan'];
            $desa= $DataPasien['desa'];
            $alamat= $DataPasien['alamat'];
            $kontak= $DataPasien['kontak'];
            $kontak_darurat= $DataPasien['kontak_darurat'];
            $penanggungjawab= $DataPasien['penanggungjawab'];
            $golongan_darah= $DataPasien['golongan_darah'];
            $perkawinan= $DataPasien['perkawinan'];
            $pekerjaan= $DataPasien['pekerjaan'];
            $status= $DataPasien['status'];
            $gambar= $DataPasien['gambar'];
            $updatetime= $DataPasien['updatetime'];


            // Mengonversi tanggal lahir menjadi objek DateTime
            $tanggal_lahir_obj = new DateTime($tanggal_lahir);

            // Mendapatkan tanggal saat ini
            $tanggal_sekarang = new DateTime();

            // Menghitung selisih antara tanggal lahir dan tanggal sekarang
            $selisih = $tanggal_sekarang->diff($tanggal_lahir_obj);

            // Variabel untuk menyimpan usia
            $usia_tahun = $selisih->y;  // Usia dalam tahun
            $usia_bulan = $selisih->m;  // Usia dalam bulan
            $usia_hari = $selisih->d;   // Usia dalam hari

            // Logika untuk menentukan bentuk usia
            if ($usia_tahun > 0) {
                $usia = $usia_tahun . " Th";
            } elseif ($usia_bulan > 0) {
                $usia = $usia_bulan . " Bln";
            } else {
                $usia = $usia_hari . " Hr";
            }
?>
    <html>
        <Header>
            <title>Cetak Kartu</title>
            <style type="text/css">
                body{
                    font-family: <?php echo $NamaFornSettingKartuPasien;?>;
                    color: <?php echo "$WarnaFornSettingKartuPasien";?>;
                }
                div.card{
                    border: 0px;
                    width: <?php echo "$PanjangSettingKartuPasien";?>;
                    height: <?php echo "$LebarSettingKartuPasien";?>;
                }
                div.inside{
                    margin-top: <?php echo "$MarginAtasSettingKartuPasien";?>;
                    margin-bottom: <?php echo "$MarginBawahKartuPasien";?>;
                    margin-left: <?php echo "$MarginKiriKartuPasien";?>;
                    margin-right: <?php echo "$MarginKananKartuPasien";?>;
                }
                table tr td{
                    font-size: <?php echo "$UkuranFornSettingKartuPasien";?>;
                }
                table tr td.bordertop{
                    border-top: 1px solid #999;
                    font-size: <?php echo "$UkuranFornSettingKartuPasien";?>;
                }
                table tr td.borderbottom{
                    border-bottom: 1px solid #999;
                    font-size: <?php echo "$UkuranFornSettingKartuPasien";?>;
                }
                table tr td.barcode{
                    font-size: 13pt;
                }
            </style>
        </Header>
        <body>
            <div class="card">
                <div class="inside">
                    <table width="100%">
                        
                        <tr>
                            <?php
                                if($BarcodeKartuPasien=="Ya"){
                                    echo ' <td align="left" class="barcode">';
                                    echo '     <b> RM.'.$id_pasien.'</b> <img src="../../assets/Barcode/Barcode.php?size='.$UkuranBarcodeKartuPasien.'&text='.$id_pasien.'"/>';
                                    echo ' </td>';
                                }
                            ?>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <td><b>Nama</dt></td>
                            <td><b>:</dt></td>
                            <td><?php echo "$nama";?></td>
                        </tr>
                        <tr>
                            <td><b>Gender</dt></td>
                            <td><b>:</dt></td>
                            <td><?php echo "$gender";?></td>
                        </tr>
                        <?php 
                            if(!empty($nik)){
                                echo '
                                    <tr>
                                        <td><b>NIK</b></td>
                                        <td><b>:</b></td>
                                        <td>'.$nik.'</td>
                                    </tr>
                                ';
                            }
                            if(!empty($no_bpjs)){
                                echo '
                                    <tr>
                                        <td><b>BPJS</b></td>
                                        <td><b>:</b></td>
                                        <td>'.$no_bpjs.'</td>
                                    </tr>
                                ';
                            }
                            if(!empty($tempat_lahir)&&!empty($tanggal_lahir)){
                                $tanggal = new DateTime($tanggal_lahir);
                                $tanggal_lahir_format = $tanggal->format('d/m/Y');
                                echo '
                                    <tr>
                                        <td><b>TTL</b></td>
                                        <td><b>:</b></td>
                                        <td>'.$tempat_lahir.','.$tanggal_lahir_format.' ('.$usia.')</td>
                                    </tr>
                                ';
                            }
                        ?>
                        
                        <tr>
                            <td valign="top"><b>Alamat 1</dt></td>
                            <td valign="top"><b>:</dt></td>
                            <td valign="top">
                                <?php 
                                    echo "RT/RW $alamat Ds/Kel $desa";
                                ?> 
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><b>Alamat 2</dt></td>
                            <td valign="top"><b>:</dt></td>
                            <td valign="top">
                                <?php 
                                    echo "$kecamatan-$kabupaten";
                                ?> 
                            </td>
                        </tr>
                    </table>
                    
                </div>
            </div>
        </body>
    </html>
<?php }} ?>