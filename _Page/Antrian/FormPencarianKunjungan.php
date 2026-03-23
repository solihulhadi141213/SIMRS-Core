<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_pasien'])){
        echo '<tr>';
        echo '  <td colspan="3" align="center" class="text-center text-danger">ID Pasien Tidak Boleh Kosong!</td>';
        echo '</tr>';
    }else{
        $id_pasien=$_POST['id_pasien'];
        $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE id_pasien='$id_pasien'"));
        if(empty($JumlahData)){
            echo '<tr>';
            echo '  <td colspan="3" align="center" class="text-center text-danger">Kunjungan Tidak Ditemukan!</td>';
            echo '</tr>';
        }else{
            $no=1;
            $query = mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE id_pasien='$id_pasien' ORDER BY id_kunjungan DESC");
            while ($data = mysqli_fetch_array($query)) {
                $id_kunjungan= $data['id_kunjungan'];
                if(!empty($data['tujuan'])){
                    $tujuan=$data['tujuan'];
                }else{
                    $tujuan="";
                }
                if(!empty($data['tanggal'])){
                    $tanggal=$data['tanggal'];
                    $strtotime=strtotime($tanggal);
                    $TanggalFormat=date('d/m/Y H:i',$strtotime);
                }else{
                    $TanggalFormat='<span class="text-danger">Tidak Ada</span>';
                }
                if(!empty($data['nama'])){
                    $nama=$data['nama'];
                }else{
                    $nama='<span class="text-danger">Tidak Ada</span>';
                }
                if(!empty($data['sep'])){
                    $sep=$data['sep'];
                }else{
                    $sep='<span class="text-danger">Tidak Ada</span>';
                }
                if(!empty($data['dokter'])){
                    $dokter=$data['dokter'];
                }else{
                    $dokter='<span class="text-danger">Tidak Ada</span>';
                }
                if(!empty($data['poliklinik'])){
                    $poliklinik=$data['poliklinik'];
                }else{
                    $poliklinik='<span class="text-danger">Tidak Ada</span>';
                }
                if(!empty($data['pembayaran'])){
                    $pembayaran=$data['pembayaran'];
                }else{
                    $pembayaran='<span class="text-danger">Tidak Ada</span>';
                }
                if(!empty($data['status'])){
                    $status=$data['status'];
                }else{
                    $status='<span class="text-danger">Tidak Ada</span>';
                }
                echo '<tr>';
                echo '  <td class="text-center">'.$no.'</td>';
                echo '  <td>';
                echo '      <input type="radio" name="GetIdKunjungan" id="GetIdKunjungan'.$no.'" value="'.$id_kunjungan.'"> <label for="GetIdKunjungan'.$no.'"><dt>'.$id_kunjungan.'</dt></label><br>';
                echo '      <small>'.$TanggalFormat.'</small>';
                echo '  </td>';
                echo '  <td>';
                echo '      <dt>'.$tujuan.'</dt>';
                echo '      <small>'.$poliklinik.'</small>';
                echo '  </td>';
                echo '</tr>';
                $no++;
            }
        }
    }
?>