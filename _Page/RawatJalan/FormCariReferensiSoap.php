<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Kunjungan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        //Membuka Detail Triase Dan IGD
        $id_pasien=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'id_pasien');
        $id_akses=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'id_akses');
        $tanggal=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'tanggal');
        $nama_pasien=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'nama_pasien');
        $nama_petugas=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'nama_petugas');
        $tanggal_entry=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'tanggal_entry');
        $tanggal_wawancara=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'tanggal_wawancara');
        $psikologi=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'psikologi');
        $sosial=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'sosial');
        $spiritual=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'spiritual');
        //Decode JSON
        $JsonNamaPetugas =json_decode($nama_petugas, true);
        $JsonPsikologi =json_decode($psikologi, true);
        $JsonSosial =json_decode($sosial, true);
        $JsonSpiritual =json_decode($spiritual, true);
        //Format Tanggal
        $strtotime=strtotime($tanggal_entry);
        $FormatTanggal=date('d/m/Y H:i', $strtotime);
        $strtotime2=strtotime($tanggal_wawancara);
        $FormatTanggal_wawancara=date('d/m/Y H:i', $strtotime2);
?>
    <div id="accordion" role="tablist" aria-multiselectable="true">
        <div class="accordion-panel">
            <div class=" accordion-heading" role="tab" id="heading5">
                <h3 class="card-title accordion-title">
                    <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Anamnesis2" aria-expanded="false" aria-controls="Anamnesis2">
                        <dt>Anamnesis</dt>
                    </a>
                </h3>
            </div>
        </div>
        <div id="Anamnesis2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
            <div class="accordion-content accordion-desc">
                <p>
                    <?php
                        $id_anamnesis=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'id_anamnesis');
                        if(empty($id_anamnesis)){
                            echo "Tidak Ada Data Anamnesa";
                        }else{
                            $keluhan_utama=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'keluhan_utama');
                            $riwayat_penyakit=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_penyakit');
                            $riwayat_alergi=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_alergi');
                            $riwayat_pengobatan=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_pengobatan');
                            $habitus_kebiasaan=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'habitus_kebiasaan');
                            //Decode JSON
                            $JsonKeluhanUtama =json_decode($keluhan_utama, true);
                            $JsonRiwayatPenyakit =json_decode($riwayat_penyakit, true);
                            $JsonRiwayatAlergi =json_decode($riwayat_alergi, true);
                            $JsonRiwayatPengobatan =json_decode($riwayat_pengobatan, true);
                            $JsonHabitusKebiasaan=json_decode($habitus_kebiasaan, true);
                            //Riwayat Penyakit
                            $RiwayatPenyakitSekarang=$JsonRiwayatPenyakit['sekarang'];
                            $RiwayatPenyakitDahulu=$JsonRiwayatPenyakit['dahulu'];
                            echo '<ol>';
                            echo '  <li class="mb-2">Riwayat Penyakit Sekarang : <code class="text-secondary">'.$RiwayatPenyakitSekarang.'</code></li>';
                            echo '  <li class="mb-2">Riwayat Penyakit Dahulu : <code class="text-secondary">'.$RiwayatPenyakitDahulu.'</code></li>';
                            echo '  <li class="mb-2">Riwayat Pengobatan : <code class="text-secondary">'.$riwayat_pengobatan.'</code></li>';
                            echo '  <li class="mb-2">Habitus Kebiasaan : <code class="text-secondary">'.$habitus_kebiasaan.'</code></li>';
                            echo '  <li class="mb-2">';
                            if(!empty($JsonRiwayatAlergi['makanan'])){
                                echo 'Alergi Makanan';
                                echo '          <ol>';
                                $JumlahData=count($JsonRiwayatAlergi['makanan']);
                                for($i=0; $i<$JumlahData; $i++){
                                    echo '<li>';
                                    echo '  '.$JsonRiwayatAlergi['makanan'][$i]["JenisZat"].' ('.$JsonRiwayatAlergi['makanan'][$i]["Reaksi"].')';
                                    echo '</li>';
                                }
                                echo '          </ol>';
                            }
                            if(!empty($JsonRiwayatAlergi['minuman'])){
                                echo 'Alergi Minuman';
                                echo '          <ol>';
                                $JumlahData=count($JsonRiwayatAlergi['minuman']);
                                for($i=0; $i<$JumlahData; $i++){
                                    echo '<li class="mb-2">';
                                    echo '  '.$JsonRiwayatAlergi['minuman'][$i]["JenisZat"].' ('.$JsonRiwayatAlergi['minuman'][$i]["Reaksi"].')';
                                    echo '</li>';
                                }
                                echo '          </ol>';
                            }
                            if(!empty($JsonRiwayatAlergi['obat'])){
                                echo 'Alergi Obat';
                                echo '          <ol>';
                                $JumlahData=count($JsonRiwayatAlergi['obat']);
                                for($i=0; $i<$JumlahData; $i++){
                                    echo '<li class="mb-2">';
                                    echo '  '.$JsonRiwayatAlergi['obat'][$i]["JenisZat"].' ('.$JsonRiwayatAlergi['obat'][$i]["Reaksi"].')';
                                    echo '</li>';
                                }
                                echo '          </ol>';
                            }
                            if(!empty($JsonRiwayatAlergi['lainnya'])){
                                echo 'Alergi Lainnya';
                                echo '          <ol>';
                                $JumlahData=count($JsonRiwayatAlergi['lainnya']);
                                for($i=0; $i<$JumlahData; $i++){
                                    echo '<li class="mb-2">';
                                    echo '  '.$JsonRiwayatAlergi['lainnya'][$i]["JenisZat"].' ('.$JsonRiwayatAlergi['lainnya'][$i]["Reaksi"].')';
                                    echo '</li>';
                                }
                                echo '          </ol>';
                            }
                            echo '  </li>';
                            echo '</ol>';
                        }
                    ?>
                </p>
            </div>
        </div>
        <div class="accordion-panel">
            <div class=" accordion-heading" role="tab" id="heading5">
                <h3 class="card-title accordion-title">
                    <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#PemeriksaanFisik2" aria-expanded="false" aria-controls="PemeriksaanFisik2">
                        <dt>Pemeriksaan Fisik</dt>
                    </a>
                </h3>
            </div>
        </div>
        <div id="PemeriksaanFisik2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
            <div class="accordion-content accordion-desc">
                <p>
                    <?php
                        $id_pemeriksaan_fisik=getDataDetail($Conn,"pemeriksaan_fisik",'id_kunjungan',$id_kunjungan,'id_pemeriksaan_fisik');
                        if(empty($id_pemeriksaan_fisik)){
                            echo "Tidak Ada Data Pemeriksaan Fisik";
                        }else{
                            echo '<ol>';
                            $query = mysqli_query($Conn, "SELECT*FROM pemeriksaan_fisik WHERE id_kunjungan='$id_kunjungan' ORDER BY id_pemeriksaan_fisik ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_pemeriksaan_fisik= $data['id_pemeriksaan_fisik'];
                                $pemeriksaan_fisik= $data['pemeriksaan_fisik'];
                                $tanda_vital= $data['tanda_vital'];
                                //Json
                                $JsonPemeriksaanFisik =json_decode($pemeriksaan_fisik, true);
                                $JsonTandaVital =json_decode($tanda_vital, true);
                                echo '  <li class="mb-2">';
                                echo '      <dt>ID Pemeriksaan : <code class="text-secondary">'.$id_pemeriksaan_fisik.'</code></dt>';
                                echo '      <ol>';
                                if(!empty($JsonPemeriksaanFisik['Kepala'])){
                                    echo '<li>Kepala : <code class="text-secondary">'.$JsonPemeriksaanFisik['Kepala'].'</code></li>';
                                }
                                if(!empty($JsonPemeriksaanFisik['Leher'])){
                                    echo '<li>Leher : <code class="text-secondary">'.$JsonPemeriksaanFisik['Leher'].'</code></li>';
                                }
                                if(!empty($JsonPemeriksaanFisik['Thorax'])){
                                    echo '<li>Thorax : <code class="text-secondary">'.$JsonPemeriksaanFisik['Thorax'].'</code></li>';
                                }
                                if(!empty($JsonPemeriksaanFisik['Abdomen'])){
                                    echo '<li>Abdomen : <code class="text-secondary">'.$JsonPemeriksaanFisik['Abdomen'].'</code></li>';
                                }
                                if(!empty($JsonPemeriksaanFisik['Extremitas'])){
                                    echo '<li>Extremitas : <code class="text-secondary">'.$JsonPemeriksaanFisik['Extremitas'].'</code></li>';
                                }
                                if(!empty($JsonPemeriksaanFisik['Genitourinaria'])){
                                    echo '<li>Genitourinaria : <code class="text-secondary">'.$JsonPemeriksaanFisik['Genitourinaria'].'</code></li>';
                                }
                                if(!empty($JsonTandaVital)){
                                    if(!empty($JsonTandaVital['denyut_jantung'])){
                                        $denyut_jantung=$JsonTandaVital['denyut_jantung'];
                                    }else{
                                        $denyut_jantung="";
                                    }
                                    if(!empty($JsonTandaVital['pernapasan'])){
                                        $pernapasan =$JsonTandaVital['pernapasan'];
                                    }else{
                                        $pernapasan ="";
                                    }
                                    if(!empty($JsonTandaVital['sistole'])){
                                        $sistole =$JsonTandaVital['sistole'];
                                    }else{
                                        $sistole ="";
                                    }
                                    if(!empty($JsonTandaVital['diastole'])){
                                        $diastole =$JsonTandaVital['diastole'];
                                    }else{
                                        $diastole ="";
                                    }
                                    if(!empty($JsonTandaVital['suhu'])){
                                        $suhu =$JsonTandaVital['suhu'];
                                    }else{
                                        $suhu ="";
                                    }
                                    if(!empty($JsonTandaVital['SpO2'])){
                                        $SpO2 =$JsonTandaVital['SpO2'];
                                    }else{
                                        $SpO2 ="";
                                    }
                                    if(!empty($JsonTandaVital['tinggi_badan'])){
                                        $tinggi_badan =$JsonTandaVital['tinggi_badan'];
                                    }else{
                                        $tinggi_badan ="";
                                    }
                                    if(!empty($JsonTandaVital['berat_badan'])){
                                        $berat_badan =$JsonTandaVital['berat_badan'];
                                    }else{
                                        $berat_badan ="";
                                    }
                                }else{
                                    $denyut_jantung="";
                                    $pernapasan ="";
                                    $sistole ="";
                                    $diastole ="";
                                    $suhu ="";
                                    $SpO2 ="";
                                    $tinggi_badan ="";
                                    $berat_badan ="";
                                }
                                echo '<li>Denyut Jantung : <code class="text-secondary">'.$denyut_jantung.'</code></li>';
                                echo '<li>Pernapasan : <code class="text-secondary">'.$pernapasan.'</code></li>';
                                echo '<li>Sistole : <code class="text-secondary">'.$sistole.'</code></li>';
                                echo '<li>Diastole : <code class="text-secondary">'.$diastole.'</code></li>';
                                echo '<li>Suhu : <code class="text-secondary">'.$suhu.'</code></li>';
                                echo '<li>SpO2 : <code class="text-secondary">'.$SpO2.'</code></li>';
                                echo '<li>Tinggi Badan : <code class="text-secondary">'.$tinggi_badan.'</code></li>';
                                echo '<li>Berat Badan : <code class="text-secondary">'.$berat_badan.'</code></li>';
                                echo '      </ol>';
                                echo '  </li>';
                            }
                            echo '</ol>';
                        }
                    ?>
                </p>
            </div>
        </div>
        <div class="accordion-panel">
            <div class=" accordion-heading" role="tab" id="heading5">
                <h3 class="card-title accordion-title">
                    <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Diagnosa2" aria-expanded="false" aria-controls="Diagnosa2">
                        <dt>Diagnosa</dt>
                    </a>
                </h3>
            </div>
        </div>
        <div id="Diagnosa2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
            <div class="accordion-content accordion-desc">
                <p>
                    <?php
                        $id_diagnosis_pasien=getDataDetail($Conn,"diagnosis_pasien",'id_kunjungan',$id_kunjungan,'id_diagnosis_pasien');
                        if(empty($id_diagnosis_pasien)){
                            echo 'Belum ada informasi Diagnosa untuk kunjungan ini.';
                        }else{
                            echo '<ol class="row mb-2">';
                            $query = mysqli_query($Conn, "SELECT DISTINCT kategori FROM diagnosis_pasien WHERE id_kunjungan='$id_kunjungan' ORDER BY kategori ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $kategori= $data['kategori'];
                                echo '  <li>';
                                echo '      '.$kategori.'';
                                echo '      <ol>';
                                $query2 = mysqli_query($Conn, "SELECT * FROM diagnosis_pasien WHERE id_kunjungan='$id_kunjungan' AND kategori='$kategori'");
                                while ($data2 = mysqli_fetch_array($query2)) {
                                    $id_diagnosis_pasien= $data2['id_diagnosis_pasien'];
                                    $kode= $data2['kode'];
                                    $diagnosis= $data2['diagnosis'];
                                    echo '      <li class="text-muted">';
                                    echo '          <span class="text-muted">';
                                    echo '              '.$kode.'-'.$diagnosis.'';
                                    echo '          </span>';
                                    echo '      </li>';
                                }
                                echo '      </ol>';
                                echo '  </li>';
                            }
                            echo '</ol>';
                        }
                    ?>
                </p>
            </div>
        </div>
        <div class="accordion-panel">
            <div class=" accordion-heading" role="tab" id="heading5">
                <h3 class="card-title accordion-title">
                    <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#Resep2" aria-expanded="false" aria-controls="Resep2">
                        <dt>Resep</dt>
                    </a>
                </h3>
            </div>
        </div>
        <div id="Resep2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
            <div class="accordion-content accordion-desc">
                <p>
                    <?php
                        $id_resep=getDataDetail($Conn,"resep",'id_kunjungan',$id_kunjungan,'id_resep');
                        if(empty($id_resep)){
                            echo 'Belum ada informasi resep untuk kunjungan ini.';
                        }else{
                            echo '<ol class="mb-3">';
                            $no = 1;
                            $query = mysqli_query($Conn, "SELECT * FROM resep WHERE id_kunjungan='$id_kunjungan' ORDER BY id_resep ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_resep= $data['id_resep'];
                                $id_pasien= $data['id_pasien'];
                                $id_kunjungan= $data['id_kunjungan'];
                                $id_akses= $data['id_akses'];
                                $id_dokter= $data['id_dokter'];
                                $nama_pasien= $data['nama_pasien'];
                                $nama_pasien= $data['nama_pasien'];
                                $nama_pasien= $data['nama_pasien'];
                                $petugas_entry= $data['petugas_entry'];
                                $tanggal_entry= $data['tanggal_entry'];
                                $tanggal_resep= $data['tanggal_resep'];
                                $nama_dokter= $data['nama_dokter'];
                                $kontak_dokter= $data['kontak_dokter'];
                                $obat= $data['obat'];
                                $catatan= $data['catatan'];
                                $status= $data['status'];
                                //Json Decode
                                $JsonNamaPasien=json_decode($nama_pasien, true);
                                $JsonKontakDokter =json_decode($kontak_dokter, true);
                                $JsonObat=json_decode($obat, true);
                                //Buka Pasien
                                $NamaPasien=$JsonNamaPasien['nama_pasien'];
                                $TanggalLahir=$JsonNamaPasien['tanggal_lahir'];
                                $BeratBadan=$JsonNamaPasien['berat_badan'];
                                $TinggiBadan=$JsonNamaPasien['tinggi_badan'];
                                $LuasTubuh=$JsonNamaPasien['luas_tubuh'];
                                //Format Tanggal
                                $strtotime1=strtotime($tanggal_entry);
                                $strtotime2=strtotime($tanggal_resep);
                                $FormatTanggalEntry=date('d/m/Y H:i T',$strtotime1);
                                $FormatTanggalResep=date('d/m/Y H:i T',$strtotime2);
                                echo '<li>';
                                echo '  <dt>Resep No.'.$id_resep.'/'.$id_pasien.'/'.$id_kunjungan.'</dt>';
                                echo '  <ol>';
                                if(!empty($JsonObat)){
                                    $JumlahObat=count($JsonObat);
                                    for($i=0; $i<$JumlahObat; $i++){
                                        $id=$JsonObat[$i]['id'];
                                        $id_obat=$JsonObat[$i]['id_obat'];
                                        $nama_obat=$JsonObat[$i]['nama_obat'];
                                        $bentuk_sediaan=$JsonObat[$i]['bentuk_sediaan'];
                                        $jumlah_obat=$JsonObat[$i]['jumlah_obat'];
                                        $metode=$JsonObat[$i]['metode'];
                                        $dosis=$JsonObat[$i]['dosis'];
                                        $unit=$JsonObat[$i]['unit'];
                                        $frekuensi=$JsonObat[$i]['frekuensi'];
                                        $aturan_tambahan=$JsonObat[$i]['aturan_tambahan'];
                                        echo '<li class="mb-3">';
                                        echo '  '.$nama_obat.' ('.$jumlah_obat.' '.$bentuk_sediaan.')<br>';
                                        echo '  Metode: '.$metode.' ('.$dosis.' '.$unit.' '.$frekuensi.')<br>';
                                        echo '  Aturan: '.$aturan_tambahan.'<br>';
                                        echo '</li>';
                                    }
                                }
                                echo '  </ol>';
                                echo '</li>';
                                $no++;
                            }
                            echo '</ol>';
                        }
                    ?>
                </p>
            </div>
        </div>
    </div>
<?php } ?>