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
        $IdKonsultasi=getDataDetail($Conn,"konsultasi",'id_kunjungan',$id_kunjungan,'id_konsultasi');
        echo '<div class="row mb-2">';
        echo '  <div class="col col-md-12 icon-btn">';
        echo '      <button type="button" class="btn btn-sm btn-round btn-outline-primary btn-block" title="Tambah Konsultasi" data-toggle="modal" data-target="#ModalTambahKonsuiltasi" data-id="'.$id_kunjungan.'">';
        echo '          <i class="ti ti-plus"></i> Tambah Konsultasi';
        echo '      </button>';
        echo '  </div>';
        echo '</div>';
        if(empty($IdKonsultasi)){
            echo '<div class="card">';
            echo '  <div class="card-body text-center text-danger">';
            echo '      Belum ada informasi konsultasi untuk kunjungan ini.';
            echo '  </div>';
            echo '</div>';
        }else{
            $no = 1;
            $query = mysqli_query($Conn, "SELECT * FROM konsultasi WHERE id_kunjungan='$id_kunjungan' ORDER BY id_konsultasi ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_konsultasi= $data['id_konsultasi'];
                $petugas_entry= $data['petugas_entry'];
                $tanggal_entry= $data['tanggal_entry'];
                $tanggal_permintaan= $data['tanggal_permintaan'];
                $tanggal_jawaban= $data['tanggal_jawaban'];
                $dokter_asal= $data['dokter_asal'];
                $dokter_tujuan= $data['dokter_tujuan'];
                $status_konsultasi= $data['status_konsultasi'];
                //Json Decode
                $JsonDokterAsal=json_decode($dokter_asal, true);
                $JsonDokterTujuan=json_decode($dokter_tujuan, true);
                //Buka Dokter Asal
                $IdUnitAsal=$JsonDokterAsal['unit']['id_unit'];
                $NamaUnitAsal=$JsonDokterAsal['unit']['nama'];
                $IdDokterAsal=$JsonDokterAsal['id_dokter'];
                $NamaDokterAsal=$JsonDokterAsal['nama'];
                $TtdDokterAsal=$JsonDokterAsal['ttd'];
                if(empty($TtdDokterAsal)){
                    $LabelTtdAsal='<a href="javascript:void(0);" id="FormTtdAsalKonsultasi['.$id_konsultasi.']" class="FormTtdAsalKonsultasi" value="'.$id_konsultasi.'">Belum Ada <i class="ti ti-pencil"></i></a>';
                }else{
                    $LabelTtdAsal='<br><img src="data:image/gif;base64,'. $TtdDokterAsal .'" width="150px">';
                }
                //Buka Dokter Tujuan
                $IdUnitTujuan=$JsonDokterTujuan['unit']['id_unit'];
                $NamaUnitTujuan=$JsonDokterTujuan['unit']['nama'];
                $IdDokterTujuan=$JsonDokterTujuan['id_dokter'];
                $NamaDokterTujuan=$JsonDokterTujuan['nama'];
                $TtdDokterTujuan=$JsonDokterTujuan['ttd'];
                if(empty($TtdDokterTujuan)){
                    $LabelTtdTujuan='<a href="javascript:void(0);" id="FormTtdTujuanKonsultasi['.$id_konsultasi.']" class="FormTtdTujuanKonsultasi" value="'.$id_konsultasi.'">Belum Ada <i class="ti ti-pencil"></i></a>';
                }else{
                    $LabelTtdTujuan='<br><img src="data:image/gif;base64,'. $TtdDokterTujuan .'" width="150px">';
                }
                //Format Tanggal
                $strtotime1=strtotime($tanggal_entry);
                $strtotime2=strtotime($tanggal_permintaan);
                $strtotime3=strtotime($tanggal_jawaban);
                $FormatTanggalEntry=date('d/m/Y H:i T',$strtotime1);
                $FormatTanggalPermintaan=date('d/m/Y H:i T',$strtotime2);
                $FormatTanggalJawaban=date('d/m/Y H:i T',$strtotime3);
                //Buka Permintaan Konsultasi
                if(!empty($data['permintaan_konsultasi'])){
                    $permintaan_konsultasi=$data['permintaan_konsultasi'];
                    $JsonPermintaanKonsultasi=json_decode($permintaan_konsultasi, true);
                    $diagnosa_kerja=$JsonPermintaanKonsultasi['diagnosa_kerja'];
                    $ikhtisar_klinis=$JsonPermintaanKonsultasi['ikhtisar_klinis'];
                    $konsul_diminta=$JsonPermintaanKonsultasi['konsul_diminta'];
                }else{
                    $permintaan_konsultasi="";
                    $diagnosa_kerja="";
                    $ikhtisar_klinis="";
                    $konsul_diminta="";
                }
                //Buka Jawaban Konsultasi
                if(!empty($data['jawaban_konsultasi'])){
                    $jawaban_konsultasi= $data['jawaban_konsultasi'];
                    $JsonJawabanKonsultasi=json_decode($jawaban_konsultasi, true);
                    $penemuan=$JsonJawabanKonsultasi['penemuan'];
                    $diagnosa=$JsonJawabanKonsultasi['diagnosa'];
                    $saran=$JsonJawabanKonsultasi['saran'];
                }else{
                    $penemuan="";
                    $diagnosa="";
                    $saran="";
                }
                echo '<div class="card mb-2">';
                echo '  <div class="card-header">';
                echo '      <div class="row">';
                echo '          <div class="col-md-12">';
                echo '              <dt>'.$no.'. Kepada Yth. '.$NamaDokterTujuan.'</dt>';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '  <div class="card-body">';
                echo '      <div class="row">';
                echo '          <div class="col col-md-12">';
                echo '              <ol>';
                echo '                  <li class="mb-2">ID.Konsultasi : <code class="text-secondary">'.$id_konsultasi.'</code></li>';
                echo '                  <li class="mb-2">Tgl/Jam Entry : <code class="text-secondary">'.$FormatTanggalEntry.'</code></li>';
                echo '                  <li class="mb-2">Petugas Entry : <code class="text-secondary">'.$petugas_entry.'</code></li>';
                echo '                  <li class="mb-2">';
                echo '                      Asal Permintaan';
                echo '                      <ul>';
                echo '                          <li>Tgl/Jam : <code class="text-secondary">'.$FormatTanggalPermintaan.'</code></li>';
                echo '                          <li>Unit : <code class="text-secondary">('.$IdUnitAsal.') '.$NamaUnitAsal.'</code></li>';
                echo '                          <li>Dokter : <code class="text-secondary">('.$IdDokterAsal.') '.$NamaDokterAsal.'</code></li>';
                echo '                          <li>Ttd Dokter : <code class="text-secondary">'.$LabelTtdAsal.'</code><div id="FormTtdAsal'.$id_konsultasi.'"></div></li>';
                echo '                      </ul>';
                echo '                  </li>';
                echo '                  <li class="mb-2">';
                echo '                      Permintaan Konsultasi ';
                echo '                      <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalPermintaanKonsultasi" data-id="'.$id_konsultasi.'">';
                echo '                          <i class="ti ti-pencil"></i> Edit';
                echo '                      </a>';
                echo '                      <ul>';
                echo '                          <li>Diagnosa Kerja : <code class="text-secondary">'.$diagnosa_kerja.'</code></li>';
                echo '                          <li>Ikhtisar Klinis : <code class="text-secondary">'.$ikhtisar_klinis.'</code></li>';
                echo '                          <li>Konsul Yang Diminta : <code class="text-secondary">'.$konsul_diminta.'</code></li>';
                echo '                      </ul>';
                echo '                  </li>';
                echo '                  <li class="mb-2">';
                echo '                      Ditujukan Kepada';
                echo '                      <ul>';
                echo '                          <li>Unit : <code class="text-secondary">('.$IdUnitTujuan.') '.$NamaUnitTujuan.'</code></li>';
                echo '                          <li>Dokter : <code class="text-secondary">('.$IdDokterTujuan.') '.$NamaDokterTujuan.'</code></li>';
                echo '                          <li>Ttd Dokter : <code class="text-secondary">'.$LabelTtdTujuan.'</code><div id="FormTtdTujuan'.$id_konsultasi.'"></div></li>';
                echo '                      </ul>';
                echo '                  </li>';
                echo '                  <li class="mb-2">';
                echo '                      Jawaban';
                echo '                      <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalJawabanKonsultasi" data-id="'.$id_konsultasi.'">';
                echo '                          <i class="ti ti-pencil"></i> Edit';
                echo '                      </a>';
                echo '                      <ul>';
                echo '                          <li>Tgl/Jam : <code class="text-secondary">'.$FormatTanggalJawaban.'</code></li>';
                echo '                          <li>Penemuan : <code class="text-secondary">'.$penemuan.'</code></li>';
                echo '                          <li>Diagnosa : <code class="text-secondary">'.$diagnosa.'</code></li>';
                echo '                          <li>Saran : <code class="text-secondary">'.$saran.'</code></li>';
                echo '                      </ul>';
                echo '                  </li>';
                echo '                  <li>Status Konsultasi : <code class="text-secondary">'.$status_konsultasi.'</code></li>';
                echo '              </ol>';
                echo '          </div>';
                echo '      </div>';
                echo '      <div class="row">';
                echo '          <div class="col col-md-12">';
                echo '              <div class="icon-btn">';
                echo '                  <a href="javascript:void(0);" class="btn btn-icon btn-secondary btn-outline-secondary" data-toggle="modal" data-target="#ModalEditKonsultasi" data-id="'.$id_konsultasi.'">';
                echo '                      <i class="icofont-edit"></i>';
                echo '                  </a>';
                echo '                  <a href="javascript:void(0);" class="btn btn-icon btn-secondary btn-outline-secondary" data-toggle="modal" data-target="#ModalHapusKonsultasi" data-id="'.$id_konsultasi.'">';
                echo '                      <i class="icofont-trash"></i>';
                echo '                  </a>';
                echo '                  <a href="javascript:void(0);" class="btn btn-icon btn-secondary btn-outline-secondary" data-toggle="modal" data-target="#ModalCetakKonsultasi" data-id="'.$id_konsultasi.'">';
                echo '                      <i class="ti ti-printer"></i>';
                echo '                  </a>';
                echo '              </div>';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
                $no++;
            }
        }
    }
?>
<script>
    var id_kunjungan="<?php echo $id_kunjungan; ?>";
    $('.FormTtdAsalKonsultasi').click(function(){
        var id_konsultasi = $(this).attr("value");
        $('#FormTtdAsal'+id_konsultasi+'').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormTtdAsal.php',
            data        :   {id_konsultasi: id_konsultasi},
            success     : function(data){
                $('#FormTtdAsal'+id_konsultasi+'').html(data);
                //Simpan TTD
                $('#ProsesTtdAsalKonsultasi'+id_konsultasi+'').submit(function(){
                    var signature = signaturePad.toDataURL();
                    $('#NotifikasiTtdAsalKonsultasi'+id_konsultasi+'').html('Loading...');
                    $.ajax({
                        type 	    :   'POST',
                        url 	    :   '_Page/RawatJalan/ProsesTtdAsalKonsultasi.php',
                        data        :   {id_konsultasi: id_konsultasi, signature: signature},
                        success     :   function(data){
                            $('#NotifikasiTtdAsalKonsultasi'+id_konsultasi+'').html(data);
                            var NotifikasiTtdAsalKonsultasiBerhasil=$('#NotifikasiTtdAsalKonsultasiBerhasil').html();
                            if(NotifikasiTtdAsalKonsultasiBerhasil=="Success"){
                                $('#DetailKonsultasi').html("Loading...");
                                $.ajax({
                                    type 	    : 'POST',
                                    url 	    : '_Page/RawatJalan/DetailKonsultasi.php',
                                    data        : {id_kunjungan: id_kunjungan},
                                    success     : function(data){
                                        $('#DetailKonsultasi').html(data);
                                    }
                                });
                                //Tampilkan Swal
                                Swal.fire({
                                    title: 'Good Job!',
                                    text: 'Tanda Tangan Konsultasi Berhasil',
                                    icon: 'success',
                                    confirmButtonText: 'Tutup'
                                })
                            }
                        }
                    });
                });
            }
        });
    });
    $('.FormTtdTujuanKonsultasi').click(function(){
        var id_konsultasi = $(this).attr("value");
        $('#FormTtdTujuan'+id_konsultasi+'').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormTtdTujuan.php',
            data        :   {id_konsultasi: id_konsultasi},
            success     : function(data){
                $('#FormTtdTujuan'+id_konsultasi+'').html(data);
                //Simpan TTD
                $('#ProsesTtdTujuanKonsultasi'+id_konsultasi+'').submit(function(){
                    var signature = signaturePad.toDataURL();
                    $('#NotifikasiTtdTujuanKonsultasi'+id_konsultasi+'').html('Loading...');
                    $.ajax({
                        type 	    :   'POST',
                        url 	    :   '_Page/RawatJalan/ProsesTtdTujuanKonsultasi.php',
                        data        :   {id_konsultasi: id_konsultasi, signature: signature},
                        success     :   function(data){
                            $('#NotifikasiTtdTujuanKonsultasi'+id_konsultasi+'').html(data);
                            var NotifikasiTtdTujuanKonsultasiBerhasil=$('#NotifikasiTtdTujuanKonsultasiBerhasil').html();
                            if(NotifikasiTtdTujuanKonsultasiBerhasil=="Success"){
                                $('#DetailKonsultasi').html("Loading...");
                                $.ajax({
                                    type 	    : 'POST',
                                    url 	    : '_Page/RawatJalan/DetailKonsultasi.php',
                                    data        : {id_kunjungan: id_kunjungan},
                                    success     : function(data){
                                        $('#DetailKonsultasi').html(data);
                                    }
                                });
                                //Tampilkan Swal
                                Swal.fire({
                                    title: 'Good Job!',
                                    text: 'Tanda Tangan Konsultasi Berhasil',
                                    icon: 'success',
                                    confirmButtonText: 'Tutup'
                                })
                            }
                        }
                    });
                });
            }
        });
    });
</script>

