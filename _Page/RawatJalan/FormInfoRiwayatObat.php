<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_riwayat_penggunaan_obat'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Riwayat Penggunaan Obat Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_riwayat_penggunaan_obat=$_POST['id_riwayat_penggunaan_obat'];
        $id_pasien=getDataDetail($Conn,"riwayat_penggunaan_obat",'id_riwayat_penggunaan_obat',$id_riwayat_penggunaan_obat,'id_pasien');
        $id_kunjungan=getDataDetail($Conn,"riwayat_penggunaan_obat",'id_riwayat_penggunaan_obat',$id_riwayat_penggunaan_obat,'id_kunjungan');
        $id_akses=getDataDetail($Conn,"riwayat_penggunaan_obat",'id_riwayat_penggunaan_obat',$id_riwayat_penggunaan_obat,'id_akses');
        $tanggal_entry=getDataDetail($Conn,"riwayat_penggunaan_obat",'id_riwayat_penggunaan_obat',$id_riwayat_penggunaan_obat,'tanggal_entry');
        $id_obat=getDataDetail($Conn,"riwayat_penggunaan_obat",'id_riwayat_penggunaan_obat',$id_riwayat_penggunaan_obat,'id_obat');
        $nama_obat=getDataDetail($Conn,"riwayat_penggunaan_obat",'id_riwayat_penggunaan_obat',$id_riwayat_penggunaan_obat,'nama_obat');
        $waktu_penggunaan=getDataDetail($Conn,"riwayat_penggunaan_obat",'id_riwayat_penggunaan_obat',$id_riwayat_penggunaan_obat,'waktu_penggunaan');
        //Json Decode
        $JsonObat=json_decode($nama_obat, true);
        //Format Tanggal
        $strtotime1=strtotime($tanggal_entry);
        $strtotime2=strtotime($waktu_penggunaan);
        $FormatTanggalEntry=date('d/m/Y H:i T',$strtotime1);
        $FormatTanggalPenggunaan=date('d/m/Y H:i T',$strtotime2);
        //Buka Obat
        $NamaObat=$JsonObat['nama_obat'];
        $Sediaan=$JsonObat['sediaan'];
        $dosis=$JsonObat['dosis'];
        $aturan_pakai=$JsonObat['aturan_pakai'];
        $WaktuPenggunaan=$JsonObat['waktu_penggunaan'];
?>
    <div class="row mb-2">
        <div class="col col-md-12">
            <ol>
                <li class="mb-2">ID.Riwayat: <code class="text-secondary"><?php echo "$id_riwayat_penggunaan_obat"; ?></code></li>
                <li class="mb-2">ID.Kunjungan: <code class="text-secondary"><?php echo "$id_kunjungan"; ?></code></li>
                <li class="mb-2">ID.Pasien: <code class="text-secondary"><?php echo "$id_pasien"; ?></code></li>
                <li class="mb-2">ID.Akses: <code class="text-secondary"><?php echo "$id_akses"; ?></code></li>
                <li class="mb-2">Tgl/Jam Entry: <code class="text-secondary"><?php echo "$FormatTanggalEntry"; ?></code></li>
                <li class="mb-2">Tgl/Jam Penggunaan: <code class="text-secondary"><?php echo "$FormatTanggalPenggunaan"; ?></code></li>
                <li class="mb-2">
                    Uraian Penggunaan Obat
                    <ol>
                        <li>ID.Obat: <code class="text-secondary"><?php echo "$id_obat"; ?></code></li>
                        <li>Nama Obat: <code class="text-secondary"><?php echo "$NamaObat"; ?></code></li>
                        <li>Sediaan: <code class="text-secondary"><?php echo "$Sediaan"; ?></code></li>
                        <li>Dosis: <code class="text-secondary"><?php echo "$dosis"; ?></code></li>
                        <li>Aturan Pakai: <code class="text-secondary"><?php echo "$aturan_pakai"; ?></code></li>
                        <li>Waktu Penggunaan: <code class="text-secondary"><?php echo "$WaktuPenggunaan"; ?></code></li>
                    </ol>
                </li>
            </ol>
        </div>
    </div>
<?php } ?>