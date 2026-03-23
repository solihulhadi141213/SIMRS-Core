<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="card">';
        echo '  <div class="card-body text-center text-danger">';
        echo '      ID Kunjungan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        $JumlahPemeriksaanDasar=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM pemeriksaan_fisik WHERE id_kunjungan='$id_kunjungan'"));
        if(empty($JumlahPemeriksaanDasar)){
            echo '<div class="card">';
            echo '  <div class="card-body text-center text-danger">';
            echo '      Belum Ada Pemeriksaan Dasar Untuk Kunjungan Ini. Silahkan buat sesi pemeriksaan dasar terlebih dulu.';
            echo '  </div>';
            echo '</div>';
            echo '<button type="button" class="btn btn-sm btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalTambahPemeriksaanDasar" data-id="'.$id_kunjungan.'">';
            echo '  <i class="ti ti-plus"></i> Tambah Sesi Pemeriksaan Fisik';
            echo '</button>';
        }else{
            $no=1;
            $query = mysqli_query($Conn, "SELECT*FROM pemeriksaan_fisik WHERE id_kunjungan='$id_kunjungan' ORDER BY id_pemeriksaan_fisik ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_pemeriksaan_fisik= $data['id_pemeriksaan_fisik'];
                $id_akses= $data['id_akses'];
                $id_kunjungan= $data['id_kunjungan'];
                $id_pasien= $data['id_pasien'];
                $nama_pasien= $data['nama_pasien'];
                $nama_petugas= $data['nama_petugas'];
                $tanggal_entry= $data['tanggal_entry'];
                $tanggal_pemeriksaan= $data['tanggal_pemeriksaan'];
                $gambar_anatomi= $data['gambar_anatomi'];
                $pemeriksaan_fisik= $data['pemeriksaan_fisik'];
                $tanda_vital= $data['tanda_vital'];
                //Format Tanggal
                $strtotime1=strtotime($tanggal_entry);
                $FormatTanggalEntry=date('d/m/Y H:i T', $strtotime1);
                $strtotime2=strtotime($tanggal_pemeriksaan);
                $FormatTanggalPemeriksaan=date('d/m/Y H:i T', $strtotime2);
                //Json
                $JsonNamaPetugas =json_decode($nama_petugas, true);
                $JsonGambarAnatomi =json_decode($gambar_anatomi, true);
                $JsonPemeriksaanFisik =json_decode($pemeriksaan_fisik, true);
                $JsonTandaVital =json_decode($tanda_vital, true);
                //Buka Petugas Entry
                if(!empty($JsonNamaPetugas['petugas_entry']['nama'])){
                    $PetugasEntry=$JsonNamaPetugas['petugas_entry']['nama'];
                    if(!empty($JsonNamaPetugas['petugas_entry']['tanda_tangan'])){
                        $TtdPetugasEntry=$JsonNamaPetugas['petugas_entry']['tanda_tangan'];
                        $TtdPetugasEntry='<img src="data:image/gif;base64,'. $TtdPetugasEntry .'" width="100%"><br>';
                    }else{
                        $TtdPetugasEntry='<a href="javascript:void(0);" class="text-primary" id="SignPetugasEntryPemeriksaanDasar"><small>Tanda Tangan</small></a>';
                    }
                }else{
                    $PetugasEntry="Tidak Ada";
                    $TtdPetugasEntry='<i>Tidak ADa</i>';
                }
                //Buka Dokter
                if(!empty($JsonNamaPetugas['dokter']['nama'])){
                    $dokter=$JsonNamaPetugas['dokter']['nama'];
                    if(!empty($JsonNamaPetugas['dokter']['tanda_tangan'])){
                        $TtdDokter=$JsonNamaPetugas['dokter']['tanda_tangan'];
                        $TtdDokter='<img src="data:image/gif;base64,'. $TtdDokter .'" width="100%"><br>';
                    }else{
                        $TtdDokter='<a href="javascript:void(0);" class="text-primary" id="SignDokterPemeriksaanDasar"><small>Tanda Tangan</small></a>';
                    }
                }else{
                    $dokter="Tidak Ada";
                    $TtdDokter='<i>Tidak ADa</i>';
                }
                //Buka Perawat
                if(!empty($JsonNamaPetugas['perawat']['nama'])){
                    $perawat=$JsonNamaPetugas['perawat']['nama'];
                    if(!empty($JsonNamaPetugas['perawat']['tanda_tangan'])){
                        $TtdPerawat=$JsonNamaPetugas['perawat']['tanda_tangan'];
                        $TtdPerawat='<img src="data:image/gif;base64,'. $TtdPerawat .'" width="100%"><br>';
                    }else{
                        $TtdPerawat='<a href="javascript:void(0);" class="text-primary" id="SignPerawatPemeriksaanDasar"><small>Tanda Tangan</small></a>';
                    }
                }else{
                    $perawat="Tidak Ada";
                    $TtdPerawat='<i>Tidak ADa</i>';
                }
                echo '<div class="card mb-2">';
                echo '  <div class="card-header">';
                echo '      <div class="btn-group">';
                echo '          <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalEditPemeriksaanDasar" data-id="'.$id_kunjungan.'">';
                echo '              <i class="ti ti-pencil-alt"></i>';
                echo '          </button>';
                echo '          <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapusPemeriksaanDasar" data-id="'.$id_kunjungan.'">';
                echo '              <i class="ti ti-trash"></i>';
                echo '          </button>';
                echo '          <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalCetakPemeriksaanDasar" data-id="'.$id_kunjungan.'">';
                echo '              <i class="ti ti-printer"></i>';
                echo '          </button>';
                echo '      </div>';
                echo '  </div>';
                echo '  <div class="card-body">';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-6">a. ID Pemeriksaan</div>';
                echo '          <div class="col col-md-6">'.$id_pemeriksaan_fisik.'</div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-6">b. ID Kunjungan</div>';
                echo '          <div class="col col-md-6">'.$id_kunjungan.'</div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-6">c. No.RM</div>';
                echo '          <div class="col col-md-6">'.$id_pasien.'</div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-6">d. Nama Pasien</div>';
                echo '          <div class="col col-md-6">'.$nama_pasien.'</div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-6">e. Tanggal Entry</div>';
                echo '          <div class="col col-md-6">'.$FormatTanggalEntry.'</div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-6">f. Tanggal Pemeriksaan</div>';
                echo '          <div class="col col-md-6">'.$FormatTanggalPemeriksaan.'</div>';
                echo '      </div>';
                echo '      <div class="row mb-2">';
                echo '          <div class="col col-md-12">g. Petugas/Nakes</div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col-md-12">';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col-md-1"></div>';
                echo '                  <div class="col-md-5 text-muted">g.1 Petugas Entry</div>';
                echo '                  <div class="col-md-6 text-muted">'.$PetugasEntry.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col-md-1"></div>';
                echo '                  <div class="col-md-5 text-muted">g.2 Perawat</div>';
                echo '                  <div class="col-md-6 text-muted">'.$perawat.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col-md-1"></div>';
                echo '                  <div class="col-md-5 text-muted">g.3 Dokter</div>';
                echo '                  <div class="col-md-6 text-muted">'.$dokter.'</div>';
                echo '              </div>';
                echo '          </div>';
                echo '      </div>';
                echo '      <div class="row mb-2">';
                echo '          <div class="col-md-12">';
                echo '              h. Gambar Anatomi';
                echo '              <a href="javascript:void(0);" class="badge badge-primary" id="ShowAnatomiForm">';
                echo '                  <small><i class="ti ti-plus"></i> Tambah</small>';
                echo '              </a>';
                echo '          </div>';
                echo '      </div>';
                echo '      <div class="row mb-2">';
                echo '          <div class="col-md-12" id="FormTambahAnatomi">';
                echo '              ';
                echo '          </div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                if(!empty($JsonGambarAnatomi)){
                    if(!empty(count($JsonGambarAnatomi))){
                        $JumlahDataLama=count($JsonGambarAnatomi);
                        for($i=0; $i<$JumlahDataLama; $i++){
                            $KodeAnatomi=$JsonGambarAnatomi[$i]["KodeAnatomi"];
                            $ImageAnatomi=$JsonGambarAnatomi[$i]["ImageAnatomi"];
                            if(!empty($JsonGambarAnatomi[$i]["PenejelasanAnatomi"])){
                                $PenejlasanAnatomi=$JsonGambarAnatomi[$i]["PenejelasanAnatomi"];
                            }else{
                                $PenejlasanAnatomi="";
                            }
                            echo '  <div class="col-md-6">';
                            echo '      <div class="card">';
                            echo '          <div class="card-body">';
                            echo '              <div class="row mb-2">';
                            echo '                  <div class="col-md-12"">';
                            echo '                      <img src="assets/images/Anatomi/Hasil/'.$ImageAnatomi.'" width="100%">';
                            echo '                  </div>';
                            echo '              </div>';
                            echo '              <div class="row">';
                            echo '                  <div class="col-md-12 text-muted" tab-index="0" style="overflow-y: auto;  max-height: 50px; height: 50px;">';
                            echo '                      <small>'.$PenejlasanAnatomi.' </small>';
                            echo '                  </div>';
                            echo '              </div>';
                            echo '          </div>';
                            echo '          <div class="card-footer text-center">';
                            echo '              <div class="btn-group">';
                            echo '                  <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalEditAnatomi"  data-id="'.$id_kunjungan.','.$KodeAnatomi.'">';
                            echo '                      <i class="ti ti-pencil"></i> Edit';
                            echo '                  </button>';
                            echo '                  <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapusAnatomi"  data-id="'.$id_kunjungan.','.$KodeAnatomi.'">';
                            echo '                      <i class="ti ti-trash"></i> Hapus';
                            echo '                  </button>';
                            echo '              </div>';
                            echo '          </div>';
                            echo '      </div>';
                            echo '  </div>';
                        }
                    }
                }
                echo '      </div>';
                echo '      <div class="row mb-2">';
                echo '          <div class="col-md-12">';
                echo '              i. Pemeriksaan Fisik';
                echo '          </div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col-md-12">';
                echo '              <ol>';
                echo '                  <li class="mb-3">';
                echo '                      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditPemeriksaanFisikUmum"  data-id="'.$id_kunjungan.',Kepala">';
                echo '                          Kepala <i class="ti ti-pencil"></i>';
                echo '                      </a>';
                                            if(!empty($JsonPemeriksaanFisik)){
                                                if(!empty($JsonPemeriksaanFisik['Kepala'])){
                                                    echo '<span class="text-muted">'.$JsonPemeriksaanFisik['Kepala'].'</span>';
                                                }
                                            }
                echo '                  </li>';
                echo '                  <li class="mb-3">';
                echo '                      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditPemeriksaanFisikUmum"  data-id="'.$id_kunjungan.',Leher">';
                echo '                          Leher <i class="ti ti-pencil"></i>';
                echo '                      </a>';
                                            if(!empty($JsonPemeriksaanFisik)){
                                                if(!empty($JsonPemeriksaanFisik['Leher'])){
                                                    echo '<span class="text-muted">'.$JsonPemeriksaanFisik['Leher'].'</span>';
                                                }
                                            }
                echo '                  </li>';
                echo '                  <li class="mb-3">';
                echo '                      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditPemeriksaanFisikUmum"  data-id="'.$id_kunjungan.',Thorax">';
                echo '                          Thorax <i class="ti ti-pencil"></i>';
                echo '                      </a>';
                                            if(!empty($JsonPemeriksaanFisik)){
                                                if(!empty($JsonPemeriksaanFisik['Thorax'])){
                                                    echo '<span class="text-muted">'.$JsonPemeriksaanFisik['Thorax'].'</span>';
                                                }
                                            }
                echo '                  </li>';
                echo '                  <li class="mb-3">';
                echo '                      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditPemeriksaanFisikUmum"  data-id="'.$id_kunjungan.',Abdomen">';
                echo '                          Abdomen <i class="ti ti-pencil"></i>';
                echo '                      </a>';
                                            if(!empty($JsonPemeriksaanFisik)){
                                                if(!empty($JsonPemeriksaanFisik['Abdomen'])){
                                                    echo '<span class="text-muted">'.$JsonPemeriksaanFisik['Abdomen'].'</span>';
                                                }
                                            }
                echo '                  </li>';
                echo '                  <li class="mb-3">';
                echo '                      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditPemeriksaanFisikUmum"  data-id="'.$id_kunjungan.',Extremitas">';
                echo '                          Extremitas <i class="ti ti-pencil"></i>';
                echo '                      </a>';
                                            if(!empty($JsonPemeriksaanFisik)){
                                                if(!empty($JsonPemeriksaanFisik['Extremitas'])){
                                                    echo '<span class="text-muted">'.$JsonPemeriksaanFisik['Extremitas'].'</span>';
                                                }
                                            }
                echo '                  </li>';
                echo '                  <li class="mb-3">';
                echo '                      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditPemeriksaanFisikUmum"  data-id="'.$id_kunjungan.',Genitourinaria">';
                echo '                          Genitourinaria <i class="ti ti-pencil"></i>';
                echo '                      </a>';
                                            if(!empty($JsonPemeriksaanFisik)){
                                                if(!empty($JsonPemeriksaanFisik['Genitourinaria'])){
                                                    echo '<span class="text-muted">'.$JsonPemeriksaanFisik['Genitourinaria'].'</span>';
                                                }
                                            }
                echo '                  </li>';
                echo '              </ol>';
                echo '          </div>';
                echo '      </div>';
                echo '      <div class="row mb-2">';
                echo '          <div class="col-md-12">';
                echo '              j. Tanda Fital';
                echo '              <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalEditTandaVitalPemeriksaanDasar" data-id="'.$id_kunjungan.'">';
                echo '                  <small>Edit <i class="ti ti-pencil"></i></small>';
                echo '              </a>';
                echo '          </div>';
                echo '      </div>';
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
                
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-12">';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1"></div>';
                echo '                  <div class="col col-md-5 text-muted">j.1. Denyut Jantung</div>';
                echo '                  <div class="col col-md-6 text-muted"><span class="text-dark">'.$denyut_jantung.'</span> X/Menit</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1"></div>';
                echo '                  <div class="col col-md-5 text-muted">j.2. Pernapasan</div>';
                echo '                  <div class="col col-md-6 text-muted"><span class="text-dark">'.$pernapasan.'</span> X/Menit</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1"></div>';
                echo '                  <div class="col col-md-5 text-muted">j.3. Sistole</div>';
                echo '                  <div class="col col-md-6 text-muted"><span class="text-dark">'.$sistole.'</span> /mmHg</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1"></div>';
                echo '                  <div class="col col-md-5 text-muted">j.4. Diastole</div>';
                echo '                  <div class="col col-md-6 text-muted"><span class="text-dark">'.$diastole.'</span> /mmHg</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1"></div>';
                echo '                  <div class="col col-md-5 text-muted">j.5. Suhu</div>';
                echo '                  <div class="col col-md-6 text-muted"><span class="text-dark">'.$suhu.'</span> &#176;C</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1"></div>';
                echo '                  <div class="col col-md-5 text-muted">j.6. SpO2</div>';
                echo '                  <div class="col col-md-6 text-muted"><span class="text-dark">'.$SpO2.'</span> %</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1"></div>';
                echo '                  <div class="col col-md-5 text-muted">j.7. Tinggi Badan</div>';
                echo '                  <div class="col col-md-6 text-muted"><span class="text-dark">'.$tinggi_badan.'</span> Cm</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1"></div>';
                echo '                  <div class="col col-md-5 text-muted">j.8. Berat Badan</div>';
                echo '                  <div class="col col-md-6 text-muted"><span class="text-dark">'.$berat_badan.'</span> Kg</div>';
                echo '              </div>';
                echo '          </div>';
                echo '      </div>';
                echo '      <div class="row mb-2">';
                echo '          <div class="col-md-12">';
                echo '              k. Validasi';
                echo '          </div>';
                echo '      </div>';
                echo '      <div class="row mb-2">';
                echo '          <div class="col-md-4 mb-3 text-center">';
                echo '              <small>Petugas Entry</small><br>';
                echo '              <small>'.$TtdPetugasEntry.'</small><br>';
                echo '              <small>('.$PetugasEntry.')</small>';
                echo '          </div>';
                echo '          <div class="col-md-4 mb-3 text-center">';
                echo '              <small>Dokter</small><br>';
                echo '              <small>'.$TtdDokter.'</small><br>';
                echo '              <small>('.$dokter.')</small>';
                echo '          </div>';
                echo '          <div class="col-md-4 mb-3 text-center">';
                echo '              <small>Perawat</small><br>';
                echo '              <small>'.$TtdPerawat.'</small><br>';
                echo '              <small>('.$perawat.')</small>';
                echo '          </div>';
                echo '      </div>';
                echo '      <div class="row mb-2">';
                echo '          <div class="col-md-12 mb-3" id="FormTandaTanganPemeriksaanDasar"></div>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
                $no++;
            }
        }
    }
?>
<script>
    //Menampilkan form Anatomi
    $('#ShowAnatomiForm').click(function(){
        var GetIdKunjungan="<?php echo $id_kunjungan;?>";
        $('#FormTambahAnatomi').html("Loading...");
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/FormTambahAnatomi.php',
            data        : {id_kunjungan: GetIdKunjungan},
            success     :   function(data){
                $('#FormTambahAnatomi').html(data);
                //Tutup Form Anatomi
                $('#TutupFormAnatomi').click(function(){
                    $('#FormTambahAnatomi').html("");
                });
            }
        });
    });
    //Menampilkan Form Sign Pemeriksaan Dasar
    $('#SignPetugasEntryPemeriksaanDasar').click(function(){
        var GetIdKunjungan="<?php echo $id_kunjungan;?>";
        var kategori="Petugas Entry";
        $('#FormTandaTanganPemeriksaanDasar').html("Loading...");
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/FormTandaTanganPemeriksaanDasar.php',
            data        : {id_kunjungan: GetIdKunjungan, kategori: kategori},
            success     :   function(data){
                $('#FormTandaTanganPemeriksaanDasar').html(data);
            }
        });
    });
    $('#SignDokterPemeriksaanDasar').click(function(){
        var GetIdKunjungan="<?php echo $id_kunjungan;?>";
        var kategori="Dokter";
        $('#FormTandaTanganPemeriksaanDasar').html("Loading...");
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/FormTandaTanganPemeriksaanDasar.php',
            data        : {id_kunjungan: GetIdKunjungan, kategori: kategori},
            success     :   function(data){
                $('#FormTandaTanganPemeriksaanDasar').html(data);
            }
        });
    });
    $('#SignPerawatPemeriksaanDasar').click(function(){
        var GetIdKunjungan="<?php echo $id_kunjungan;?>";
        var kategori="Perawat";
        $('#FormTandaTanganPemeriksaanDasar').html("Loading...");
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/FormTandaTanganPemeriksaanDasar.php',
            data        : {id_kunjungan: GetIdKunjungan, kategori: kategori},
            success     :   function(data){
                $('#FormTandaTanganPemeriksaanDasar').html(data);
            }
        });
    });
</script>