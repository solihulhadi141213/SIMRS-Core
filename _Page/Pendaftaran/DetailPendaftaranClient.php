<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Tangkap id_operasi
    if(empty($_GET['id_antrian'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          <span class="text-danger">Tidak ada data yang dipilih!.</span>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_antrian=$_GET['id_antrian'];
        //Buka data Antrian
        $Qry = mysqli_query($Conn,"SELECT * FROM antrian WHERE id_antrian='$id_antrian'")or die(mysqli_error($Conn));
        $Data = mysqli_fetch_array($Qry);
        $id_antrian= $Data['id_antrian'];
        $no_antrian= $Data['no_antrian'];
        $id_pasien= $Data['id_pasien'];
        $nama_pasien= $Data['nama_pasien'];
        $kode_dokter= $Data['kode_dokter'];
        $nama_dokter= $Data['nama_dokter'];
        $kodepoli= $Data['kodepoli'];
        $namapoli= $Data['namapoli'];
        $tanggal_kunjungan= $Data['tanggal_kunjungan'];
        $jam_kunjungan= $Data['jam_kunjungan'];
        $kodebooking= $Data['kodebooking'];
        if(empty($id_antrian)){
            echo '<div class="card-body border-0 pb-0">';
            echo '  <div class="row">';
            echo '      <div class="col-md-6 mb-3">';
            echo '          <span class="text-danger">Data tidak ditemukan, Silahkan refresh halaman ini.</span>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
?>
<div class="row">
    <div class="col-md-12 text-center">
        <h4 class="text-success">Rincian Data pendaftaran</h4>
        <dt>Silahkan lakukan konfirmasi kedatangan (<i>Checkin</i>) pada saat kunjungan 15 menit sebelum waktu jadwal di loket pendaftaran</dt>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table table-responsive">
            <table width="100%">
                <tr>
                    <td><dt>Kode Booking</dt></td>
                    <td><dt>:</dt></td>
                    <td><?php echo "$kodebooking";?></td>
                </tr>
                <tr>
                    <td><dt>No.Antrian</dt></td>
                    <td><dt>:</dt></td>
                    <td><?php echo "$no_antrian";?></td>
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
                    <td><?php echo "$tanggal_kunjungan $jam_kunjungan";?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center">
        <a href="_Page/Pendaftaran/CetakTiketAntrian.php?id_antrian=<?php echo $id_antrian;?>" target="_blank" class="btn btn-md btn-block btn-primary">
            <i class="ti ti-printer"></i> Cetak Tiket Antrian
        </a>
        <a href="Pendaftaran.php?page=history" class="btn btn-md btn-block">
            <i class="ti ti-arrow-circle-left"></i> Kembali Ke Pencarian
        </a>
    </div>
</div>
<?php
    }}
?>