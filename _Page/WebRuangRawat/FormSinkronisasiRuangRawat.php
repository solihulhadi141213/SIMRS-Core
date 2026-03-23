<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $UrlHapus=urlService('Hapus Semua Ruang Rawat');
    //Menghapus Semua Data Di Web
    $JumlahRuangan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='ruangan'"));
?>
<div class="table table-responsive">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th class="text-center">
                    <dt>No</dt>
                </th>
                <th class="text-center">
                    <dt>Ruangan</dt>
                </th>
                <th class="text-center">
                    <dt>Kelas</dt>
                </th>
                <th class="text-center">
                    <dt>Kode</dt>
                </th>
                <th class="text-center">
                    <dt>Kapasitas</dt>
                </th>
                <th class="text-center">
                    <dt>Pasien</dt>
                </th>
                <th class="text-center">
                    <dt>Sisa</dt>
                </th>
                <th class="text-center">
                    <dt>Status</dt>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                if(empty($JumlahRuangan)){
                    echo '<tr>';
                    echo '  <td colspan="8" class="text-center">';
                    echo '      Tidak Ada Data Yang Ditampilkan';
                    echo '  </td>';
                    echo '</tr>';
                }else{
                    $no=1;
                    $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE (kategori='ruangan') ORDER BY ruangan ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $id_ruang_rawat = $data['id_ruang_rawat'];
                        $kelas = $data['kelas'];
                        $kodekelas = $data['kodekelas'];
                        $ruangan = $data['ruangan'];
                        $status = $data['status'];
                        $updatetime = $data['updatetime'];
                        //menghitung jumlah ruangan
                        $JumlahRuangan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='ruangan' AND kelas='$kelas'"));
                        $JumlahBed = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='bed' AND kelas='$kelas'"));
                        $JumlahPasien = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE kelas='$kelas' AND status='Terdaftar'"));
                        $Sisa=$JumlahBed-$JumlahPasien;
            ?>
                <tr>
                    <td class="text-center"><?php echo "$no"; ?></td>
                    <td class="text-left"><?php echo "$ruangan"; ?></td>
                    <td class="text-left"><?php echo "$kelas"; ?></td>
                    <td class="text-left"><?php echo "$kodekelas"; ?></td>
                    <td class="text-left"><?php echo "$JumlahBed Bed"; ?></td>
                    <td class="text-left"><?php echo "$JumlahPasien Pasien"; ?></td>
                    <td class="text-left"><?php echo "$Sisa Bed"; ?></td>
                    <td class="text-left"><?php echo "$status"; ?></td>
                </tr>
            <?php
                        $no++;
                    }
                }
            ?>
        </tbody>
    </table>
</div>