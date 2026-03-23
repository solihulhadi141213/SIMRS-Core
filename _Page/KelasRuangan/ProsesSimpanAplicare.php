<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th class="text-center"><dt>No</dt></th>
            <th class="text-center"><dt>Kode</dt></th>
            <th class="text-center"><dt>Kelas/Ruangan</dt></th>
            <th class="text-center"><dt>Quota</dt></th>
            <th class="text-center"><dt>Pria</dt></th>
            <th class="text-center"><dt>Wanita</dt></th>
            <th class="text-center"><dt>Bebas</dt></th>
            <th class="text-center"><dt>Notifikasi</dt></th>
            <th class="text-center"><dt>Opt</dt></th>
        </tr>
    </thead>
    <tbody>
        <?php
            //Koneksi dan session
            date_default_timezone_set('Asia/Jakarta');
            include "../../_Config/Connection.php";
            include "../../_Config/Session.php";
            include "../../_Config/SettingBridging.php";
            //Menangkap nilai yang dikirim oleh form
            if(isset($_POST['id_ruang_rawat'])) {
                $id_ruang_rawat=$_POST['id_ruang_rawat'];
                echo "<br>";
                for ($i=0; $i < count($id_ruang_rawat) ; $i++){
                    $no=$i+1;
                    $IdLokal=$id_ruang_rawat[$i];
                    //Membuka data ruang_rawat
                    $Qry = mysqli_query($Conn,"SELECT * FROM ruang_rawat WHERE id_ruang_rawat='$IdLokal'")or die(mysqli_error($Conn));
                    $Data = mysqli_fetch_array($Qry);
                    $kategori = $Data['kategori'];
                    $kodekelas = $Data['kodekelas'];
                    $kelas = $Data['kelas'];
                    $ruangan = $Data['ruangan'];
                    $bed = $Data['bed'];
                    $pria = $Data['pria'];
                    $wanita = $Data['wanita'];
                    $bebas = $Data['bebas'];
                    $tarif = $Data['tarif'];
                    $status = $Data['status'];
                    $updatetime = $Data['updatetime'];
                    //menghitung jumlah bed
                    $JumlahBedPria = mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND pria='1' AND kodekelas='$kodekelas' AND status='Aktif'"));
                    $JumlahBedWanita =mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND wanita='1' AND kodekelas='$kodekelas' AND status='Aktif'"));
                    $JumlahBedBebas =mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND bebas='1' AND kodekelas='$kodekelas' AND status='Aktif'"));
                    $JumlahTotal=mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND ruangan='$ruangan'"));
                    $JumlahPasien = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE kelas='$kelas' AND ruangan='$ruangan' AND status='Terdaftar'"));
                    $tersedia=$JumlahTotal-$JumlahPasien;
                    //Menghitung Jumlah BED Pasien Pria
                    $TersediaBedPria=0;
                    $QryRoom1 = mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND pria='1' AND ruangan='$ruangan' AND status='Aktif' ORDER BY kelas ASC");
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
                    //Menghitung Jumlah BED Pasien Wanita
                    $TersediaBedWanita=0;
                    $QryRoom2= mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND wanita='1' AND ruangan='$ruangan' AND status='Aktif' ORDER BY kelas ASC");
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
                    //Menghitung Jumlah BED Pasien Bebas
                    $TersediaBedBebas=0;
                    $QryRoom3= mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND bebas='1' AND ruangan='$ruangan' AND status='Aktif' ORDER BY kelas ASC");
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
                    //Melakukan tambah data BPJS
                    $url ="$url_aplicare/rest/bed/create/$kode_ppk";
                    //KONFIGURASI
                    date_default_timezone_set('UTC');
                    $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                    //Creat Signature
                    $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
                    // base64 encode…
                    $encodedSignature = base64_encode($signature);
                    $ch=curl_init();
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
                        "tersedia" => "$tersedia",
                        "tersediapria" => "$TersediaBedPria",
                        "tersediawanita" => "$TersediaBedWanita",
                        "tersediapriawanita" => "$TersediaBedBebas",
                    );
                    $json = json_encode($arr);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "$url");
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
                        $notifikasi="Tidak ada koneksi";
                    }else{
                        $get =json_decode($content, true);
                        $notifikasi=$get["metadata"]["message"];
                    }
                    echo '<tr>';
                    echo '  <td class="text-center">'.$no.'</td>';
                    echo '  <td class="text-left">'.$kodekelas.'</td>';
                    echo '  <td class="text-left">'.$ruangan.'</td>';
                    echo '  <td class="text-left">'.$tersedia.'/'.$JumlahTotal.'</td>';
                    echo '  <td class="text-left">'.$TersediaBedPria.'</td>';
                    echo '  <td class="text-left">'.$TersediaBedWanita.'</td>';
                    echo '  <td class="text-left">'.$TersediaBedBebas.'</td>';
                    echo '  <td class="text-center">'.$notifikasi.'</td>';
                    echo '  <td class="center"><input checked class="form-check-input" type="checkbox" name="id_ruang_rawat[]" value="'.$IdLokal.'" ></td>';
                    echo '</tr>';
                }
            }else{
                echo "Tidak ada data yang ditemukan!";
            }
        ?>
    </tbody>
</table>