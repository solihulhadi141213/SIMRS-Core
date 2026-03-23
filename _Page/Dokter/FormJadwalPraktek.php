<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_dokter
    if(empty($_POST['id_dokter'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center text-danger">';
        echo '      ID Dokter Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_dokter=$_POST['id_dokter'];
        $kode=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'kode');
        if(empty($kode)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center text-danger">';
            echo '      ID Dokter Tersebut Tidak Valid Atau Tidak Terdaftar!';
            echo '  </div>';
            echo '</div>';
        }else{
            //Jumlah Jadwal
            $JumlahJadwalDokter = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jadwal_dokter WHERE id_dokter='$id_dokter'"));
            if(empty($JumlahJadwalDokter)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center text-danger">';
                echo '      ID Dokter Tersebut Tidak Tidak Memiliki Jadwal';
                echo '  </div>';
                echo '</div>';
            }else{
?>
    <div class="row mt-2 mb-2"> 
        <div class="col col-md-12">
            <ol>
            <?php
                // Array berisi nama-nama hari dalam Bahasa Indonesia
                $hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
                // Looping melalui nama-nama hari
                foreach ($hari as $index => $namaHari) {
                    $JumlahJadwalDokterByHari = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jadwal_dokter WHERE id_dokter='$id_dokter' AND hari='$namaHari'"));
                    if(!empty($JumlahJadwalDokterByHari)){
                        echo '<li class="mb-3">';
                        echo '  <dt>'.$namaHari.'</dt>';
                        echo '  <ul>';
                        //Menampilkan jadwal
                        $QryJadwal = mysqli_query($Conn, "SELECT*FROM jadwal_dokter WHERE id_dokter='$id_dokter' AND hari='$namaHari' ORDER BY jam ASC");
                        while ($DataJadwal = mysqli_fetch_array($QryJadwal)) {
                            $jam= $DataJadwal['jam'];
                            $poliklinik= $DataJadwal['poliklinik'];
                            echo '<li>- '.$jam.' ('.$poliklinik.')</li>';
                        }
                        echo '  </ul>';
                        echo '</li>';
                    }
                }
                
            ?>
            </ol>
        </div>
    </div>
<?php }}} ?>