<div class="table table-responsive">
    <table class="table table-hover table-bordered">
        <thead class="bg-dark text-light">
            <tr>
                <th class="text-center"><dt>No</dt></th>
                <th class="text-center"><dt>Kode<br>Ruangan</dt></th>
                <th class="text-center"><dt>Q</dt></th>
                <th class="text-center"><dt>L</dt></th>
                <th class="text-center"><dt>P</dt></th>
                <th class="text-center"><dt>L/P</dt></th>
                <th class="text-center"><dt>Ket</dt></th>
            </tr>
        </thead>
        <tbody>
            <?php
                //koneksi dan session
                date_default_timezone_set('Asia/Jakarta');
                include "../../_Config/Connection.php";
                include "../../_Config/Session.php";
                include "../../_Config/SettingBridging.php";
                $no=1;
                $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE (kategori='ruangan') ORDER BY kelas ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_ruang_rawat = $data['id_ruang_rawat'];
                    $kelas = $data['kelas'];
                    $kodekelas = $data['kodekelas'];
                    $ruangan = $data['ruangan'];
                    $status = $data['status'];
                    $updatetime = $data['updatetime'];
                    //menghitung jumlah bed
                    $JumlahBedPria = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='bed' AND pria='1' AND kodekelas='$kodekelas'"));
                    $JumlahBedWanita =mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='bed' AND wanita='1' AND kodekelas='$kodekelas'"));
                    $JumlahBedBebas =mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='bed' AND bebas='1' AND kodekelas='$kodekelas'"));
                    $JumlahTotal=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='bed' AND ruangan='$ruangan'"));
                    $JumlahPasien = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE kelas='$kelas' AND status='Terdaftar'"));
                    //Menghitung Jumlah Pasien Pria
                    $TersediaBedPria=0;
                    $QryRoom1 = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='bed' AND pria='1' AND ruangan='$ruangan'  ORDER BY kelas ASC");
                    while ($DataRoom1 = mysqli_fetch_array($QryRoom1)) {
                        $IdRoomPria = $DataRoom1['id_ruang_rawat'];
                        //apakah ruangan tersebut ada yang isi?
                        $ApakahDiisi1 = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE id_kasur='$IdRoomPria' AND status='Terdaftar'"));
                        if(empty($ApakahDiisi1)){
                            $JumlahPasienPriatersedia=1;
                        }else{
                            $JumlahPasienPriatersedia=0;
                        }
                        $TersediaBedPria=$TersediaBedPria+$JumlahPasienPriatersedia;
                    }
                    //Menghitung Jumlah Pasien Wanita
                    $TersediaBedWanita=0;
                    $QryRoom2= mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='bed' AND wanita='1' AND ruangan='$ruangan'  ORDER BY kelas ASC");
                    while ($DataRoom2 = mysqli_fetch_array($QryRoom2)) {
                        $IdRoomWanita = $DataRoom2['id_ruang_rawat'];
                        //apakah ruangan tersebut ada yang isi?
                        $ApakahDiisi2 = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE id_kasur='$IdRoomWanita' AND status='Terdaftar'"));
                        if(empty($ApakahDiisi2)){
                            $JumlahPasienWanitatersedia=1;
                        }else{
                            $JumlahPasienWanitatersedia=0;
                        }
                        $TersediaBedWanita=$TersediaBedWanita+$JumlahPasienWanitatersedia;
                    }
                    //Menghitung Jumlah Pasien Bebas
                    $TersediaBedBebas=0;
                    $QryRoom3= mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='bed' AND bebas='1' AND ruangan='$ruangan' ORDER BY kelas ASC");
                    while ($DataRoom3 = mysqli_fetch_array($QryRoom3)) {
                        $IdRoomBebas= $DataRoom3['id_ruang_rawat'];
                        //apakah ruangan tersebut ada yang isi?
                        $ApakahDiisi3 = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE id_kasur='$IdRoomBebas' AND status='Terdaftar'"));
                        if(empty($ApakahDiisi3)){
                            $JumlahPasienBebasTersedia=1;
                        }else{
                            $JumlahPasienBebasTersedia=0;
                        }
                        $TersediaBedBebas=$TersediaBedBebas+$JumlahPasienBebasTersedia;
                    }
                    $TersediaSemua=$JumlahTotal-$JumlahPasien;
                    //Melakukan Update berdasarkan kode ruangan masing-masing
                    //konfigurasi
                    date_default_timezone_set('UTC');
                    $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                    $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
                    // base64 encode…
                    $encodedSignature = base64_encode($signature);
                    $ch = curl_init();
                    $headers = array(
                        'X-signature: '.$encodedSignature.'',
                        'X-timestamp: '.$timestamp.'' ,
                        'X-cons-id: '.$consid .'',
                        'user_key: '.$user_key.'',
                        'Content-Type: Application/JSON',          
                        'Accept: Application/JSON'     
                    );
                    $arr = array(
                        "kodekelas" => "$kodekelas",
                        "koderuang" => "$ruangan",
                        "namaruang" => "$ruangan",
                        "kapasitas" => "$JumlahTotal",
                        "tersedia" => "$TersediaSemua",
                        "tersediapria" => "$TersediaBedPria",
                        "tersediawanita" => "$TersediaBedWanita",
                        "tersediapriawanita" => "$TersediaBedBebas"
                    );
                    $json = json_encode($arr);
                    curl_setopt($ch, CURLOPT_URL, "$url_aplicare/rest/bed/update/$kode_ppk");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 3); 
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $content = curl_exec($ch);
                    $err = curl_error($ch);
                    curl_close($ch);
                    if($content==false){
                        $pesan="<i class='danger'>Koneksi Gagal-Update Data</i>";
                    }else{
                        $get =json_decode($content, true);
                        $pesan=$get["metadata"]["message"];
                        $code=$get["metadata"]["code"];
                    }
                    echo '<tr>';
                    echo '  <td class="text-center">'.$no.'</td>';
                    echo '  <td class="text-left">'.$kodekelas.'<br><small>'.$ruangan.'</small></td>';
                    echo '  <td class="text-left">'.$JumlahTotal.'</td>';
                    echo '  <td class="text-left">'.$TersediaBedPria.'</td>';
                    echo '  <td class="text-left">'.$TersediaBedWanita.'</td>';
                    echo '  <td class="text-left">'.$TersediaBedBebas.'</td>';
                    if($pesan=="Data berhasil diupdate."){
                        echo '  <td class="text-left"><i class="text-success">'.$pesan.'</i></td>';
                    }else{
                        echo '  <td class="text-left"><i class="text-danger">'.$pesan.'</i></td>';
                    }
                    
                    echo '</tr>';
                $no++;}
            ?>
        </tbody>
    </table>
</div>
