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
        $id_persetujuan_tindakan=getDataDetail($Conn,"persetujuan_tindakan",'id_kunjungan',$id_kunjungan,'id_persetujuan_tindakan');
        echo '<button type="button" class="btn btn-sm btn-outline-dark btn-block mb-2" data-toggle="modal" data-target="#ModalTambahPersetujuanTindakan" data-id="'.$id_kunjungan.'">';
        echo '  <i class="ti ti-plus"></i> Tambah Persetujuan/Penolakan';
        echo '</button>';
        if(empty($id_persetujuan_tindakan)){
            echo '<div class="card">';
            echo '  <div class="card-body text-center text-danger">';
            echo '      Belum ada informasi persetujuan tindakan untuk kunjungan ini.';
            echo '  </div>';
            echo '</div>';
        }else{
            $no = 1;
            $query = mysqli_query($Conn, "SELECT * FROM persetujuan_tindakan WHERE id_kunjungan='$id_kunjungan' ORDER BY id_persetujuan_tindakan ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_persetujuan_tindakan= $data['id_persetujuan_tindakan'];
                $id_pasien= $data['id_pasien'];
                $id_akses= $data['id_akses'];
                $nama_pasien= $data['nama_pasien'];
                $nama_petugas= $data['nama_petugas'];
                $dokter= $data['dokter'];
                $pemberi_pernyataan= $data['pemberi_pernyataan'];
                $tanggal_entry= $data['tanggal_entry'];
                $tanggal_penjelasan= $data['tanggal_penjelasan'];
                $persetujuan= $data['persetujuan'];
                $tindakan= $data['tindakan'];
                $konsekuensi= $data['konsekuensi'];
                $saksi= $data['saksi'];
                //Json Decode
                $JsonDokter=json_decode($dokter, true);
                $JsonPemberiPernyataan =json_decode($pemberi_pernyataan, true);
                $JsonTindakan=json_decode($tindakan, true);
                $JsonSaksi=json_decode($saksi, true);
                //Dokter
                $kategori_identitas_dokter=$JsonDokter['kategori_identitas_dokter'];
                $nomor_identitas_dokter=$JsonDokter['nomor_identitas_dokter'];
                $nama_dokter=$JsonDokter['nama_dokter'];
                $pendaping_dokter=$JsonDokter['pendaping_dokter'];
                if(!empty($JsonDokter['ttd'])){
                    $TtdDokter=$JsonDokter['ttd'];
                    $TtdDokter='<a href="javascript:void(0);" class="text-danger" id="TandaTanganDokter"><img src="data:image/gif;base64,'. $TtdDokter .'" width="100px"></a>';
                }else{
                    $TtdDokter='<a href="javascript:void(0);" class="text-danger" id="TandaTanganDokter"><small><i class="ti ti-pencil"></i> Tanda Tangan Dokter</small></a>';
                }
                //Pemberi Pernyataan
                $pemberi_pernyataan=$JsonPemberiPernyataan['pemberi_pernyataan'];
                $nama_pemberi_pernyataan=$JsonPemberiPernyataan['nama_pemberi_pernyataan'];
                $identitas_pemberi_pernyataan=$JsonPemberiPernyataan['identitas_pemberi_pernyataan'];
                $nomor_identitas_pemberi_pernyataan=$JsonPemberiPernyataan['nomor_identitas_pemberi_pernyataan'];
                $TtdPemberiPernyataan=$JsonPemberiPernyataan['ttd'];
                if(!empty($JsonPemberiPernyataan['ttd'])){
                    $TtdPemberiPernyataan=$JsonPemberiPernyataan['ttd'];
                    $TtdPemberiPernyataan='<a href="javascript:void(0);" class="text-danger" id="TandaTanganPernyataan"><img src="data:image/gif;base64,'. $TtdPemberiPernyataan .'" width="100px"></a>';
                }else{
                    $TtdPemberiPernyataan='<a href="javascript:void(0);" class="text-danger" id="TandaTanganPernyataan"><small><i class="ti ti-pencil"></i> Tanda Tangan</small></a>';
                }
                //Saksi1
                $identitas_saksi1=$JsonSaksi['saksi1']['identitas_saksi1'];
                $nomor_identitas_saksi1=$JsonSaksi['saksi1']['nomor_identitas_saksi1'];
                $nama_saksi1=$JsonSaksi['saksi1']['nama_saksi1'];
                if(!empty($JsonSaksi['saksi1']['ttd'])){
                    $ttd_saksi1=$JsonSaksi['saksi1']['ttd'];
                    $ttd_saksi1='<a href="javascript:void(0);" class="text-danger" id="TandaTanganSaksi1"><img src="data:image/gif;base64,'. $ttd_saksi1 .'" width="100px"></a>';
                }else{
                    $ttd_saksi1='<a href="javascript:void(0);" class="text-danger" id="TandaTanganSaksi1"><small><i class="ti ti-pencil"></i> Tanda Tangan</small></a>';
                }
                //Saksi 2
                $identitas_saksi2=$JsonSaksi['saksi2']['identitas_saksi2'];
                $nomor_identitas_saksi2=$JsonSaksi['saksi2']['nomor_identitas_saksi2'];
                $nama_saksi2=$JsonSaksi['saksi2']['nama_saksi2'];
                if(!empty($JsonSaksi['saksi2']['ttd'])){
                    $ttd_saksi2=$JsonSaksi['saksi2']['ttd'];
                    $ttd_saksi2='<a href="javascript:void(0);" class="text-danger" id="TandaTanganSaksi2"><img src="data:image/gif;base64,'. $ttd_saksi2 .'" width="100px"></a>';
                }else{
                    $ttd_saksi2='<a href="javascript:void(0);" class="text-danger" id="TandaTanganSaksi2"><small><i class="ti ti-pencil"></i> Tanda Tangan</small></a>';
                }
                //Format Tanggal
                $strtotime1=strtotime($tanggal_entry);
                $strtotime2=strtotime($tanggal_penjelasan);
                $FormatTanggalEntry=date('d/m/Y H:i T',$strtotime1);
                $FormatTanggalPenjelasan=date('d/m/Y H:i T',$strtotime2);
                echo '<div class="card mb-2">';
                echo '  <div class="card-header">';
                echo '      <div class="row">';
                echo '          <div class="col-md-12 mb-2 text-center">';
                echo '              <dt>Lembar Persetujuan No.'.$id_persetujuan_tindakan.'/'.$id_pasien.'/'.$id_kunjungan.'</dt>';
                echo '          </div>';
                echo '          <div class="col-md-12 mb-2 text-center">';
                echo '              <div class="btn-group">';
                echo '                  <a href="javascript:void(0);" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalEditPersetujuanTindakan" data-id="'.$id_persetujuan_tindakan.'">';
                echo '                      <i class="ti ti-pencil-alt"></i>';
                echo '                  </a>';
                echo '                  <a href="javascript:void(0);" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapusPersetujuanTindakan" data-id="'.$id_persetujuan_tindakan.'">';
                echo '                      <i class="ti ti-trash"></i>';
                echo '                  </a>';
                echo '                  <a href="javascript:void(0);" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalCetakPersetujuanTindakan" data-id="'.$id_persetujuan_tindakan.'">';
                echo '                      <i class="ti ti-printer"></i>';
                echo '                  </a>';
                echo '              </div>';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '  <div class="card-body">';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-6">a. ID Persetujuan</div>';
                echo '          <div class="col col-md-6">'.$id_persetujuan_tindakan.'</div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-6">b. No.RM</div>';
                echo '          <div class="col col-md-6">'.$id_pasien.'</div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-6">c. Nama Pasien</div>';
                echo '          <div class="col col-md-6">'.$nama_pasien.'</div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-6">d. Tanggal Entry</div>';
                echo '          <div class="col col-md-6">'.$FormatTanggalEntry.'</div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-6">e. Tanggal Penjelasan</div>';
                echo '          <div class="col col-md-6">'.$FormatTanggalPenjelasan.'</div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-12 mb-2">f. Dokter</div>';
                echo '          <div class="col col-md-12">';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">f.1. Nama</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$nama_dokter.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">f.2. Identitas</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$kategori_identitas_dokter.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">f.3. No.Identitas</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$nomor_identitas_dokter.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">f.4. Pendaping</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$pendaping_dokter.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">f.5. TTD Dokter</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$TtdDokter.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-11 text-muted" id="FormTtdDokter"></div>';
                echo '              </div>';
                echo '          </div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-12 mb-2">g. Pemberi Pernyataan</div>';
                echo '          <div class="col col-md-12">';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">g.1. Pemberi Pernyataan</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$pemberi_pernyataan.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">g.2. Nama</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$nama_pemberi_pernyataan.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">g.3. Identitas</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$identitas_pemberi_pernyataan.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">g.4. No.Identitas</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$nomor_identitas_pemberi_pernyataan.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">g.5. Tanda Tangan</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$TtdPemberiPernyataan.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-11 text-muted" id="FormTtdPemberiPernyataan"></div>';
                echo '              </div>';
                echo '          </div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-12">h. Saksi</div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-12 mb-2 text-muted">h.1. Saksi 1</div>';
                echo '          <div class="col col-md-12">';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">h.1.1 Nama</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$nama_saksi1.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">h.1.2. Identitas</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$identitas_saksi1.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">h.1.3. No.Identitas</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$nomor_identitas_saksi1.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">h.1.4. Tanda Tangan</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$ttd_saksi1.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-11 text-muted" id="FormTtdSaksi1"></div>';
                echo '              </div>';
                echo '          </div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-12 mb-2 text-muted">h.2. Saksi 2</div>';
                echo '          <div class="col col-md-12">';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">h.2.1 Nama</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$nama_saksi2.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">h.2.2. Identitas</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$identitas_saksi2.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">h.2.3. No.Identitas</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$nomor_identitas_saksi2.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-5 text-muted">h.2.4. Tanda Tangan</div>';
                echo '                  <div class="col col-md-6 text-muted">'.$ttd_saksi2.'</div>';
                echo '              </div>';
                echo '              <div class="row mb-2">';
                echo '                  <div class="col col-md-1 text-muted"></div>';
                echo '                  <div class="col col-md-11 text-muted" id="FormTtdSaksi2"></div>';
                echo '              </div>';
                echo '          </div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-12 mb-2">i. Tindakan</div>';
                echo '          <div class="col col-md-12">';
                echo '              <ol>';
                                    if(!empty(count($JsonTindakan))){
                                        $JumlahTindakan=count($JsonTindakan);
                                        for($i=0; $i<$JumlahTindakan; $i++){
                                            $tindakan_list=$JsonTindakan[$i]["tindakan"];
                                            echo '<li class="text-muted">'.$tindakan_list.'</li>';
                                        }
                                    }
                echo '              </ol>';
                echo '          </div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-6">j. Konsekuensi</div>';
                echo '          <div class="col col-md-6">'.$konsekuensi.'</div>';
                echo '      </div>';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-6">k. Persetujuan</div>';
                echo '          <div class="col col-md-6">'.$persetujuan.'</div>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
                $no++;
            }
        }
    }
?>
<script>
    $('#TandaTanganDokter').click(function(){
        var kategori="Dokter";
        var id_persetujuan_tindakan="<?php echo "$id_persetujuan_tindakan"; ?>";
        $('#FormTtdDokter').html("Loading..");
        $('#FormTtdPemberiPernyataan').html("");
        $('#FormTtdSaksi1').html("");
        $('#FormTtdSaksi2').html("");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormTtdPersetujuanTindakan.php',
            data        : {kategori: kategori, id_persetujuan_tindakan: id_persetujuan_tindakan},
            success     : function(data){
                $('#FormTtdDokter').html(data);
                $('#TutupTandaTanganPersetujuanTindakan').click(function(){
                    $('#FormTtdDokter').html("");
                });
            }
        });
    });
    $('#TandaTanganPernyataan').click(function(){
        var kategori="Pernyataan";
        var id_persetujuan_tindakan="<?php echo "$id_persetujuan_tindakan"; ?>";
        $('#FormTtdDokter').html("");
        $('#FormTtdPemberiPernyataan').html("Loading..");
        $('#FormTtdSaksi1').html("");
        $('#FormTtdSaksi2').html("");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormTtdPersetujuanTindakan.php',
            data        : {kategori: kategori, id_persetujuan_tindakan: id_persetujuan_tindakan},
            success     : function(data){
                $('#FormTtdPemberiPernyataan').html(data);
                $('#TutupTandaTanganPersetujuanTindakan').click(function(){
                    $('#FormTtdPemberiPernyataan').html("");
                });
            }
        });
    });
    $('#TandaTanganSaksi1').click(function(){
        var kategori="Saksi1";
        var id_persetujuan_tindakan="<?php echo "$id_persetujuan_tindakan"; ?>";
        $('#FormTtdDokter').html("");
        $('#FormTtdPemberiPernyataan').html("");
        $('#FormTtdSaksi1').html("Loading..");
        $('#FormTtdSaksi2').html("");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormTtdPersetujuanTindakan.php',
            data        : {kategori: kategori, id_persetujuan_tindakan: id_persetujuan_tindakan},
            success     : function(data){
                $('#FormTtdSaksi1').html(data);
                $('#TutupTandaTanganPersetujuanTindakan').click(function(){
                    $('#FormTtdSaksi1').html("");
                });
            }
        });
    });
    $('#TandaTanganSaksi2').click(function(){
        var kategori="Saksi2";
        var id_persetujuan_tindakan="<?php echo "$id_persetujuan_tindakan"; ?>";
        $('#FormTtdDokter').html("");
        $('#FormTtdPemberiPernyataan').html("");
        $('#FormTtdSaksi1').html("");
        $('#FormTtdSaksi2').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormTtdPersetujuanTindakan.php',
            data        : {kategori: kategori, id_persetujuan_tindakan: id_persetujuan_tindakan},
            success     : function(data){
                $('#FormTtdSaksi2').html(data);
                $('#TutupTandaTanganPersetujuanTindakan').click(function(){
                    $('#FormTtdSaksi2').html("");
                });
            }
        });
    });
</script>

