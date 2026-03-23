<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $UrlHapus=urlService('Hapus Semua Ruang Rawat');
    $UrlSetRuang=urlService('Set Ruang Kelas');
    //Menghapus Semua Data Di Web
    $HapusDataRuanganWeb=HapusSemuaRuang($api_key,$UrlHapus);
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
                    if($HapusDataRuanganWeb=="200"){
                        echo '<tr>';
                        echo '  <td colspan="8" class="text-center text-success">';
                        echo '      Clear Data Ruang Kelas Di Web Berhasil';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        echo '<tr>';
                        echo '  <td colspan="8" class="text-center text-danger">';
                        echo '      Clear Data Ruang Kelas Di Web Gagal!';
                        echo '  </td>';
                        echo '</tr>';
                    }
                    $no=1;
                    $ListRuangan = array();
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
                        $push3['ruang_rawat'] = $ruangan;
                        $push3['kelas'] = $kelas;
                        $push3['kode'] = $kodekelas;
                        $push3['kapasitas'] = $JumlahBed;
                        $push3['pasien_rawat'] = $JumlahPasien;
                        $push3['tersedia'] = $Sisa;
                        $push3['status'] = $status;
                        array_push($ListRuangan, $push3);
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
                    $KirimData = array(
                        'api_key' => $api_key,
                        'ruang_rawat' => $ListRuangan
                    );
                    $json = json_encode($KirimData);
                    //Mulai CURL
                    $ch = curl_init();
                    curl_setopt($ch,CURLOPT_URL, "$UrlSetRuang");
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch,CURLOPT_HEADER, 0);
                    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $content = curl_exec($ch);
                    $err = curl_error($ch);
                    curl_close($ch);
                    if(!empty($err)){
                        echo '<tr>';
                        echo '  <td colspan="8" class="text-center text-danger">';
                        echo '      '.$err.'';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $JsonData =json_decode($content, true);
                        if(!empty($JsonData['metadata']['massage'])){
                            $massage=$JsonData['metadata']['massage'];
                        }else{
                            $massage="";
                        }
                        if(!empty($JsonData['metadata']['code'])){
                            $code=$JsonData['metadata']['code'];
                        }else{
                            $code="";
                        }
                        if($code==200){
                            echo '<tr>';
                            echo '  <td colspan="8" class="text-center text-success">';
                            echo '      Sinkronisasi Berhasil';
                            echo '  </td>';
                            echo '</tr>';
                        }else{
                            echo '<tr>';
                            echo '  <td colspan="8" class="text-center text-danger">';
                            echo '      '.$massage.'';
                            echo '  </td>';
                            echo '</tr>';
                        }
                    }
                }
            ?>
        </tbody>
    </table>
</div>