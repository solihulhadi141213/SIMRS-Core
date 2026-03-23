<?php
    //Setting Time Data
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='kelas' ORDER BY kelas ASC");
    while ($data = mysqli_fetch_array($query)) {
        $id_ruang_rawat = $data['id_ruang_rawat'];
        $kelas = $data['kelas'];
        $kodekelas = $data['kodekelas'];
        $updatetime = $data['updatetime'];
        //menghitung jumlah ruangan
        $JumlahRuangan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='ruangan' AND kelas='$kelas'"));
        $JumlahBed = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='bed' AND kelas='$kelas'"));
        $JumlahPasien = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE kelas='$kelas' AND status='Terdaftar'"));
        $Tersedia=$JumlahBed-$JumlahPasien;
?>
<div class="col-3">
    <div class="card">
        <div class="card-block text-center">
            <div class="row align-items-center">
                <div class="col-12">
                    <h5><dt><?php echo "$kelas"; ?></dt></h5>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-12 mt-2">
                    <h5><?php echo "$Tersedia Bed"; ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>