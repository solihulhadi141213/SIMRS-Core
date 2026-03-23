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
        $id_anamnesis=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'id_anamnesis');
        if(empty($id_anamnesis)){
            echo '<div class="card">';
            echo '  <div class="card-header">';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalTambahAnamnesis" data-id="'.$id_kunjungan.'">';
            echo '          <i class="ti ti-plus"></i> Tambah Anamnesis';
            echo '      </button>';
            echo '  </div>';
            echo '  <div class="card-body text-center text-danger">';
            echo '      Belum ada informasi anamnesis untuk kunjungan ini.';
            echo '  </div>';
            echo '</div>';
        }else{
            //Membuka Detail Triase Dan IGD
            $id_pasien=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'id_pasien');
            $id_akses=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'id_akses');
            $tanggal=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'tanggal');
            $nama_pasien=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'nama_pasien');
            $nama_petugas=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'nama_petugas');
            $keluhan_utama=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'keluhan_utama');
            $riwayat_penyakit=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_penyakit');
            $riwayat_alergi=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_alergi');
            $riwayat_pengobatan=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_pengobatan');
            $habitus_kebiasaan=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'habitus_kebiasaan');
            //Decode JSON
            $JsonNamaPetugas =json_decode($nama_petugas, true);
            $JsonKeluhanUtama =json_decode($keluhan_utama, true);
            $JsonRiwayatPenyakit =json_decode($riwayat_penyakit, true);
            $JsonRiwayatAlergi =json_decode($riwayat_alergi, true);
            $JsonRiwayatPengobatan =json_decode($riwayat_pengobatan, true);
            $JsonHabitusKebiasaan=json_decode($habitus_kebiasaan, true);
            //Format Tanggal
            $strtotime=strtotime($tanggal);
            $FormatTanggal=date('d/m/Y H:i', $strtotime);
            //Buka Petugas Entry
            if(!empty($JsonNamaPetugas['petugas_entry']['nama'])){
                $PetugasEntry=$JsonNamaPetugas['petugas_entry']['nama'];
                if(!empty($JsonNamaPetugas['petugas_entry']['tanda_tangan'])){
                    $TtdPetugasEntry=$JsonNamaPetugas['petugas_entry']['tanda_tangan'];
                    $TtdPetugasEntry='<img src="data:image/gif;base64,'. $TtdPetugasEntry .'" width="100%"><br>';
                }else{
                    $TtdPetugasEntry='<a href="javascript:void(0);" class="text-primary" id="SignPetugasEntry"><small>Tanda Tangan</small></a>';
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
                    $TtdDokter='<a href="javascript:void(0);" class="text-primary" id="SignDokter"><small>Tanda Tangan</small></a>';
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
                    $TtdPerawat='<a href="javascript:void(0);" class="text-primary" id="SignPerawat"><small>Tanda Tangan</small></a>';
                }
            }else{
                $perawat="Tidak Ada";
                $TtdPerawat='<i>Tidak ADa</i>';
            }
            //Riwayat Penyakit
            $RiwayatPenyakitSekarang=$JsonRiwayatPenyakit['sekarang'];
            $RiwayatPenyakitDahulu=$JsonRiwayatPenyakit['dahulu'];
            echo '<div class="card">';
            echo '  <div class="card-header">';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalEditAnamnesis" data-id="'.$id_kunjungan.'" title="Ubah Anamnesis">';
            echo '          <i class="ti ti-pencil-alt"></i>';
            echo '      </button>';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapusAnamnesis" data-id="'.$id_kunjungan.'" title="Hapus Anamnesis">';
            echo '          <i class="ti ti-trash"></i>';
            echo '      </button>';
            echo '      <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalCetakAnamnesis" data-id="'.$id_kunjungan.'" title="Cetak Lembar Anamnesis">';
            echo '          <i class="ti ti-printer"></i>';
            echo '      </button>';
            echo '  </div>';
            echo '  <div class="card-body">';
            echo '      <div class="row mb-4">';
            echo '          <div class="col col-md-6">a. ID.Anamnesis</div>';
            echo '          <div class="col col-md-6">'.$id_anamnesis.'</div>';
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
            echo '          <div class="col col-md-6">e. Tanggal/Waktu</div>';
            echo '          <div class="col col-md-6">'.$FormatTanggal.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col-md-12 mb-2">g. Petugas</div>';
            echo '          <div class="col-md-12 mb-2">';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">g.1. Petugas Entry</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$PetugasEntry.'</div>';
            echo '              </div>';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">g.2. Dokter</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$dokter.'</div>';
            echo '              </div>';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">g.3. Perawat</div>';
            echo '                  <div class="col col-md-6 text-muted">'.$perawat.'</div>';
            echo '              </div>';
            echo '          </div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col-md-6">';
            echo '              h. Keluhan Utama';
            echo '              <span id="TombolKeluhanUtama">';
            echo '                  <a href="javascript:void(0);" class="text-primary" class="text-primary" data-toggle="modal" data-target="#ModalEditRichText" data-id="keluhan_utama,'.$id_kunjungan.'">';
            echo '                      <i class="ti ti-pencil-alt"></i> Edit';
            echo '                  </a>';
            echo '              </span>';
            echo '          </div>';
            echo '          <div class="col-md-6 text-muted">'.$keluhan_utama.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col-md-12 mb-2">';
            echo '              i. Riwayat Penyakit';
            echo '          </div>';
            echo '          <div class="col-md-12 mb-2">';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">';
            echo '                      i.1. Sekarang';
            echo '                      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditRichText" data-id="riwayat_penyakit_sekarang,'.$id_kunjungan.'"><small><i class="ti ti-pencil-alt"></i> Edit</small></a>';
            echo '                  </div>';
            echo '                  <div class="col col-md-6 text-muted">'.$RiwayatPenyakitSekarang.'</div>';
            echo '              </div>';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">';
            echo '                      i.2. Dahulu';
            echo '                      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditRichText" data-id="riwayat_penyakit_dahulu,'.$id_kunjungan.'"><small><i class="ti ti-pencil-alt"></i> Edit</small></a>';
            echo '                  </div>';
            echo '                  <div class="col col-md-6 text-muted">'.$RiwayatPenyakitDahulu.'</div>';
            echo '              </div>';
            echo '          </div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col-md-12 mb-2">j. Riwayat Alergi</div>';
            echo '          <div class="col-md-12 mb-2">';
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-11 text-muted">';
            echo '                      j.1. Makanan ';
            echo '                      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditRiwayaAlergi" data-id="'.$id_kunjungan.',Makanan"><small><i class="ti ti-pencil-alt"></i> Edit</small></a>';
            echo '                  </div>';
            echo '              </div>';
                                if(!empty($JsonRiwayatAlergi['makanan'])){
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col col-md-1"></div>';
                                    echo '  <div class="col col-md-11 text-muted">';
                                    echo '      <small>';
                                    echo '          <ol>';
                                        $JumlahData=count($JsonRiwayatAlergi['makanan']);
                                        for($i=0; $i<$JumlahData; $i++){
                                            echo '<li class="mb-2">';
                                            echo '  '.$JsonRiwayatAlergi['makanan'][$i]["JenisZat"].' ('.$JsonRiwayatAlergi['makanan'][$i]["Reaksi"].')';
                                            echo '</li>';
                                        }
                                    echo '          </ol>';
                                    echo '      </small>';
                                    echo '  </div>';
                                    echo '</div>';
                                }
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">';
            echo '                      j.2. Minuman ';
            echo '                      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditRiwayaAlergi" data-id="'.$id_kunjungan.',Minuman"><small><i class="ti ti-pencil-alt"></i> Edit</small></a>';
            echo '                  </div>';
            echo '              </div>';
                                if(!empty($JsonRiwayatAlergi['minuman'])){
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col col-md-1"></div>';
                                    echo '  <div class="col col-md-11 text-muted">';
                                    echo '      <small>';
                                    echo '          <ol>';
                                        $JumlahData=count($JsonRiwayatAlergi['minuman']);
                                        for($i=0; $i<$JumlahData; $i++){
                                            echo '<li class="mb-2">';
                                            echo '  '.$JsonRiwayatAlergi['minuman'][$i]["JenisZat"].' ('.$JsonRiwayatAlergi['minuman'][$i]["Reaksi"].')';
                                            echo '</li>';
                                        }
                                    echo '          </ol>';
                                    echo '      </small>';
                                    echo '  </div>';
                                    echo '</div>';
                                }
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">';
            echo '                      j.3. Obat ';
            echo '                      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditRiwayaAlergi" data-id="'.$id_kunjungan.',Obat"><small><i class="ti ti-pencil-alt"></i> Edit</small></a>';
            echo '                  </div>';
            echo '              </div>';
                                if(!empty($JsonRiwayatAlergi['obat'])){
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col col-md-1"></div>';
                                    echo '  <div class="col col-md-11 text-muted">';
                                    echo '      <small>';
                                    echo '          <ol>';
                                        $JumlahData=count($JsonRiwayatAlergi['obat']);
                                        for($i=0; $i<$JumlahData; $i++){
                                            echo '<li class="mb-2">';
                                            echo '  '.$JsonRiwayatAlergi['obat'][$i]["JenisZat"].' ('.$JsonRiwayatAlergi['obat'][$i]["Reaksi"].')';
                                            echo '</li>';
                                        }
                                    echo '          </ol>';
                                    echo '      </small>';
                                    echo '  </div>';
                                    echo '</div>';
                                }
            echo '              <div class="row mb-2">';
            echo '                  <div class="col col-md-1"></div>';
            echo '                  <div class="col col-md-5 text-muted">';
            echo '                      j.4. Lainnya ';
            echo '                      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditRiwayaAlergi" data-id="'.$id_kunjungan.',Lainnya"><small><i class="ti ti-pencil-alt"></i> Edit</small></a>';
            echo '                  </div>';
            echo '              </div>';
                            if(!empty($JsonRiwayatAlergi['lainnya'])){
                                echo '<div class="row mb-2">';
                                echo '  <div class="col col-md-1"></div>';
                                echo '  <div class="col col-md-11 text-muted">';
                                echo '      <small>';
                                echo '          <ol>';
                                    $JumlahData=count($JsonRiwayatAlergi['lainnya']);
                                    for($i=0; $i<$JumlahData; $i++){
                                        echo '<li class="mb-2">';
                                        echo '  '.$JsonRiwayatAlergi['lainnya'][$i]["JenisZat"].' ('.$JsonRiwayatAlergi['lainnya'][$i]["Reaksi"].')';
                                        echo '</li>';
                                    }
                                echo '          </ol>';
                                echo '      </small>';
                                echo '  </div>';
                                echo '</div>';
                            }
            echo '          </div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col col-md-6">';
            echo '              k. Riwayat Pengobatan';
            echo '              <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditRichText" data-id="riwayat_pengobatan,'.$id_kunjungan.'"><small><i class="ti ti-pencil-alt"></i> Edit</small></a>';
            echo '          </div>';
            echo '          <div class="col-md-6 text-muted">'.$riwayat_pengobatan.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col col-md-6">';
            echo '              l. Habitus Kebiasaan';
            echo '              <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditRichText" data-id="habitus_kebiasaan,'.$id_kunjungan.'"><small><i class="ti ti-pencil-alt"></i> Edit</small></a>';
            echo '          </div>';
            echo '          <div class="col-md-6 text-muted">'.$habitus_kebiasaan.'</div>';
            echo '      </div>';
            echo '      <div class="row mb-4">';
            echo '          <div class="col-md-12 mb-2">';
            echo '              m. Tanda Tangan';
            echo '          </div>';
            echo '          <div class="col-md-4 text-center">';
            echo '              <small>Petugas Entry</small><br>';
            echo '              <small>'.$TtdPetugasEntry.'</small><br>';
            echo '              <small>('.$PetugasEntry.')</small>';
            echo '          </div>';
            echo '          <div class="col-md-4 text-center">';
            echo '              <small>Dokter</small><br>';
            echo '              <small>'.$TtdDokter.'</small><br>';
            echo '              <small>('.$dokter.')</small>';
            echo '          </div>';
            echo '          <div class="col-md-4 text-center">';
            echo '              <small>Perawat</small><br>';
            echo '              <small>'.$TtdPerawat.'</small><br>';
            echo '              <small>('.$perawat.')</small>';
            echo '          </div>';
            echo '      </div>';
            echo '      <div class="row">';
            echo '          <div class="col-md-12" id="FormTandaTanganAnamnesa">';
            echo '              ';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }
    }
?>
<script>
    //Tanda Tangan Petugas Entry
    $('#SignPetugasEntry').click(function(){
        var kategori_tanda_tangan = "Petugas Entry";
        var GetIdKunjungan="<?php echo $id_kunjungan;?>";
        $('#FormTandaTanganAnamnesa').html("Loading...");
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/FormTandaTanganAnamnesa.php',
            data        : {id_kunjungan: GetIdKunjungan, kategori: kategori_tanda_tangan},
            success     :   function(data){
                $('#FormTandaTanganAnamnesa').html(data);
                //Tutup Tanda Tangan
                $('#TutupTandaTanganAnamnesa').click(function(){
                    $('#FormTandaTanganAnamnesa').html("");
                });
            }
        });
    });
    //Tanda Tangan Dokter
    $('#SignDokter').click(function(){
        var kategori_tanda_tangan = "Dokter";
        var GetIdKunjungan="<?php echo $id_kunjungan;?>";
        $('#FormTandaTanganAnamnesa').html("Loading...");
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/FormTandaTanganAnamnesa.php',
            data        : {id_kunjungan: GetIdKunjungan, kategori: kategori_tanda_tangan},
            success     :   function(data){
                $('#FormTandaTanganAnamnesa').html(data);
                //Tutup Tanda Tangan
                $('#TutupTandaTanganAnamnesa').click(function(){
                    $('#FormTandaTanganAnamnesa').html("");
                });
            }
        });
    });
    //Tanda Tangan Petugas Entry
    $('#SignPerawat').click(function(){
        var kategori_tanda_tangan = "Perawat";
        var GetIdKunjungan="<?php echo $id_kunjungan;?>";
        $('#FormTandaTanganAnamnesa').html("Loading...");
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/FormTandaTanganAnamnesa.php',
            data        : {id_kunjungan: GetIdKunjungan, kategori: kategori_tanda_tangan},
            success     :   function(data){
                $('#FormTandaTanganAnamnesa').html(data);
                //Tutup Tanda Tangan
                $('#TutupTandaTanganAnamnesa').click(function(){
                    $('#FormTandaTanganAnamnesa').html("");
                });
            }
        });
    });
    
</script>