<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/Setting.php";
    include "../../_Config/SettingFaskes.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_operasi
    if(!empty($_GET['id_antrian'])){
        $id_antrian=$_GET['id_antrian'];
        $id_kunjungan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'id_kunjungan');
        $no_antrian=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'no_antrian');
        $kodebooking=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kodebooking');
        $id_pasien=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'id_pasien');
        $nama_pasien=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nama_pasien');
        $nomorkartu=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nomorkartu');
        $nik=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nik');
        $notelp=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'notelp');
        $nomorreferensi=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nomorreferensi');
        $jenisreferensi=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'jenisreferensi');
        $jenisrequest=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'jenisrequest');
        $polieksekutif=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'polieksekutif');
        $tanggal_daftar=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'tanggal_daftar');
        $tanggal_kunjungan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'tanggal_kunjungan');
        $jam_kunjungan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'jam_kunjungan');
        $jam_checkin=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'jam_checkin');
        $kode_dokter=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kode_dokter');
        $nama_dokter=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'nama_dokter');
        $kodepoli=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kodepoli');
        $namapoli=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'namapoli');
        $kelas=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'kelas');
        $keluhan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'keluhan');
        $pembayaran=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'pembayaran');
        $no_rujukan=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'no_rujukan');
        $status=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'status');
        $sumber_antrian=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'sumber_antrian');
        $ws_bpjs=getDataDetail($Conn,'antrian','id_antrian',$id_antrian,'ws_bpjs');
    }else{
        $id_antrian="";
        $id_kunjungan="";
        $no_antrian="";
        $kodebooking="";
        $id_pasien="";
        $nama_pasien="";
        $nomorkartu="";
        $nik="";
        $notelp="";
        $nomorreferensi="";
        $jenisreferensi="";
        $jenisrequest="";
        $polieksekutif="";
        $tanggal_daftar="";
        $tanggal_kunjungan="";
        $jam_kunjungan="";
        $jam_checkin="";
        $kode_dokter="";
        $nama_dokter="";
        $kodepoli="";
        $namapoli="";
        $kelas="";
        $keluhan="";
        $pembayaran="";
        $no_rujukan="";
        $status="";
        $sumber_antrian="";
        $ws_bpjs="";
    }
?>
<html>
    <Header>
        <title>Cetak Antrian</title>
        <style type="text/css">
            body{
                font-family: <?php echo $jenis_font;?>;
                color: <?php echo $warna_font;?>;
                font-size: <?php echo $ukuran_font;?>px;
                /* border: 1px solid #999; */
                width: <?php echo $panjang_x;?>mm;
                height: <?php echo $lebar_y;?>mm;
                padding: 5px;
            }
            table.polos{
                font-size: <?php echo $ukuran_font;?>px;
            }
            table.garis{
                font-size: <?php echo $ukuran_font;?>px;
                border: 1px solid #999;
            }
        </style>
    </Header>
    <body>
        <table class="polos" width="100%">
            <tr>
                <td colspan="3" align="center">
                    <h1><b><?php echo "A-$no_antrian";?></b></h1>
                </td>
            </tr>
            <tr>
                <td><dt>Kode Booking</dt></td>
                <td><dt>:</dt></td>
                <td><?php echo "$kodebooking";?></td>
            </tr>
            <tr>
                <td><dt>No.RM</dt></td>
                <td><dt>:</dt></td>
                <td><?php echo "$id_pasien";?></td>
            </tr>
            <tr>
                <td><dt>Nama Pasien</dt></td>
                <td><dt>:</dt></td>
                <td><?php echo "$nama_pasien";?></td>
            </tr>
            <tr>
                <td><dt>Dokter</dt></td>
                <td><dt>:</dt></td>
                <td><?php echo "$kode_dokter-$nama_dokter";?></td>
            </tr>
            <tr>
                <td><dt>Poliklinik</dt></td>
                <td><dt>:</dt></td>
                <td><?php echo "$kodepoli-$namapoli";?></td>
            </tr>
            <tr>
                <td><dt>Tgl/Jam Kunjungan</dt></td>
                <td><dt>:</dt></td>
                <td><?php echo "$tanggal_kunjungan-$jam_kunjungan";?></td>
            </tr>
        </table>
        <table class="garis" width="100%">
            <tr>
                <td colspan="3" align="center">
                    <b><?php echo $NamaFaskes;?></b><br>
                    <?php echo $AlamatFaskes;?><br><br>
                    <i>Silahkan tunjukan tiket antrian ini kepada petugas pada saat melakukan Checkin</i>
                </td>
            </tr>
        </table>
    </body>
</html>