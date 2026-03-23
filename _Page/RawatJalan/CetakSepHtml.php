<html>
    <Header>
        <title><?php echo $noSep;?></title>
        <style type="text/css">
            body{
                font-family: Arial, Helvetica, sans-serif;
                color: black;
                margin-left:1 cm;
                font-size:12px;
            }
            table{
                border-collapse: collapse;
                font-size: 12px;
            }
            table tr td{
                padding: 1px;
                font-size: 12px;
                
            }
            table tr td.ttd{
                border-bottom: 1px solid #000;
            }
		</style>
    </Header>
    <body>
        <table width="100%">
            <tr>
                <td align="center" colspan="7">
                    <img src="<?php echo "../../assets/images/bpjs.png";?>" width="200px"><br>
                    <b>
                        SURAT ELIGIBILITAS PESERTA <?php echo "<br>$Namafaskes <br> $AlamatFaskes"; ?>
                    </b>
                </td>
            </tr>
            <tr>
                <td align="center" colspan="7">
                    <br> <br>
                </td>
            </tr>
            <tr>
                <td align="left">No.SEP</td>
                <td align="center" width="3%">:</td>
                <td align="left">
                    <?php echo "$noSep"; ?>
                    <?php
                        $tanggalsekarang=date('Y-m-d');
                        if($tglSep<$tanggalsekarang){
                            echo "(Backdate)";
                        }
                    ?>
                </td>
                <td width="5%"></td>
                <td align="left">Peserta</td>
                <td align="center" width="3%">:</td>
                <td align="left"><?php echo "$jnsPeserta"; ?></td>
            </tr>
            <tr>
                <td align="left">Tgl.SEP</td>
                <td align="center" width="3%">:</td>
                <td align="left"><?php echo "$tglSep"; ?></td>
                <td width="5%"></td>
                <td align="left">Pelayanan</td>
                <td align="center" width="3%">:</td>
                <td align="left"><?php echo "$jnsPelayanan"; ?></td>
            </tr>
            <tr>
                <td align="left">No.Kartu</td>
                <td align="center" width="3%">:</td>
                <td align="left"><?php echo "$noKartu"; ?></td>
                <td width="5%"></td>
                <td align="left">Diagnosa</td>
                <td align="center" width="3%">:</td>
                <td align="left"><?php echo "$diagnosa"; ?></td>
            </tr>
            <tr>
                <td align="left">Nama Peserta</td>
                <td align="center" width="3%">:</td>
                <td align="left"><?php echo "$nama"; ?></td>
                <td width="5%"></td>
                <td align="left">Poliklinik/Kelas</td>
                <td align="center" width="3%">:</td>
                <td align="left">
                <?php 
                    if($jnsPelayanan=="Rawat Inap"){
                        echo "Kelas $kelasRawat"; 
                    }else{
                        echo "$poli"; 
                    }
                   
                ?>
                </td>
            </tr>
            <tr>
                <td align="left">Tgl.Lahir</td>
                <td align="center" width="3%">:</td>
                <td align="left"><?php echo "$tglLahir"; ?></td>
                <td width="5%"></td>
                <td align="left">Poli.Ekskluif</td>
                <td align="center" width="3%">:</td>
                <td align="left"><?php echo "$poliEksekutif"; ?></td>
            </tr>
            <tr>
                <td align="left">Gender</td>
                <td align="center" width="3%">:</td>
                <td align="left"><?php echo "$gender ($kelamin)"; ?></td>
                <td width="5%"></td>
                <td align="left">Penjamin</td>
                <td align="center" width="3%">:</td>
                <td align="left"><?php echo "$penjamin"; ?></td>
            </tr>
            <tr>
                <td align="left">Rujukan</td>
                <td align="center" width="3%">:</td>
                <td align="left"><?php echo "$noRujukan"; ?></td>
                <td width="5%"></td>
                <td align="left">Asuransi</td>
                <td align="center" width="3%">:</td>
                <td align="left"><?php echo "$asuransi"; ?></td>
            </tr>
            <tr>
                <td align="left">No.MR</td>
                <td align="center" width="3%">:</td>
                <td align="left"><?php echo "$noMr"; ?></td>
                <td width="5%"></td>
                <td align="left">Catatan</td>
                <td align="center" width="3%">:</td>
                <td align="left"><?php echo "$catatan"; ?></td>
            </tr>
            <?php if(!empty($nmstatusKecelakaan)){ ?>
            <tr>
                <td align="left">Nama Status Kecelakaan</td>
                <td align="center" width="3%">:</td>
                <td align="left"><?php echo "$nmstatusKecelakaan"; ?></td>
                <td width="5%"></td>
            </tr>
            <?php } ?>
            <tr>
                <td align="center" colspan="7">
                    <br> <br>
                </td>
            </tr>
            <tr>
                <td align="left" colspan="3">
                    - Saya menyetujui BPJS kesehatan menggunakan informasi medis pasien jika diperlukan.<br>
                    - SEP bukan sebagai bukti penjaminan peserta.<br>
                    - CETAK PADA TANGGAL :<?php echo date('Y-m-d H:i:s');?>
                </td>
                <td width="5%"></td>
                <td align="left" valign="top" class="ttd"><b>Pasien/Keluarga pasien</b><br><br><br> <br></td>
                <td align="center" valign="top"  width="3%"></td>
                
            </tr>
        </table>
    </body>
    <footer>

    </footer>
</html>