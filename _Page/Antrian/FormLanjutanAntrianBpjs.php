<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    include "../../_Config/SimrsFunction.php";
    if(!empty($_POST['ModePencarianAntrian'])){
        $ModePencarian=$_POST['ModePencarianAntrian'];
        if($ModePencarian=="Antrian Per Tanggal"){
            echo '<div class="col-md-12 mb-3">';
            echo '  <input type="date" class="form-control" id="TanggalAntrianPencarian" name="TanggalAntrianPencarian">';
            echo '  <small>Tanggal Antrian</small>';
            echo '</div>';
        }else{
            if($ModePencarian=="Antrian Per Kode Boking"){
                echo '<div class="col-md-12 mb-3">';
                echo '  <input type="text" class="form-control" id="PencarianKodeBooking" name="PencarianKodeBooking">';
                echo '  <small>Kode Booking</small>';
                echo '</div>';
            }else{
                if($ModePencarian=="Antrian Belum Dilayani Per Poli"){
                    echo '<div class="col-md-12 mb-3">';
                    echo '  <select class="form-control" id="KodePoli" name="KodePoli">';
                    echo '      <option value="">Pilih</option>';
                    $QryPoli = mysqli_query($Conn, "SELECT*FROM poliklinik ORDER BY nama ASC");
                    while ($DataPoli = mysqli_fetch_array($QryPoli)) {
                        $NamaPoli = $DataPoli['nama'];
                        $KodePoli = $DataPoli['kode'];
                        echo '      <option value="'.$KodePoli.'">'.$NamaPoli.'</option>';
                    }
                    echo '  </select>';
                    echo '  <small>Kode Poli</small>';
                    echo '</div>';
                    echo '<div class="col-md-12 mb-3">';
                    echo '  <select class="form-control" id="KodeDokter" name="KodeDokter">';
                    echo '  </select>';
                    echo '  <small>Kode Dokter</small>';
                    echo '</div>';
                    echo '<div class="col-md-12 mb-3">';
                    echo '  <select class="form-control" id="KodeHari" name="KodeHari">';
                    echo '      <option value="">Pilih</option>';
                    echo '      <option value="1">Senin</option>';
                    echo '      <option value="2">Selasa</option>';
                    echo '      <option value="3">Rabu</option>';
                    echo '      <option value="4">Kamis</option>';
                    echo '      <option value="5">Jumat</option>';
                    echo '      <option value="6">Sabtu</option>';
                    echo '      <option value="7">Minggu</option>';
                    echo '  </select>';
                    echo '  <small>Hari</small>';
                    echo '</div>';
                    echo '<div class="col-md-12 mb-3">';
                    echo '  <select class="form-control" id="JamPraktek" name="JamPraktek">';
                    echo '  </select>';
                    echo '  <small>Jam Praktek</small>';
                    echo '</div>';
                }else{
                    
                }
            }
        }
    }
?>