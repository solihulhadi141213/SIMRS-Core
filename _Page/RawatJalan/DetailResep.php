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
        $id_resep=getDataDetail($Conn,"resep",'id_kunjungan',$id_kunjungan,'id_resep');
        echo '<button type="button" class="btn btn-sm btn-outline-dark btn-block mb-2" data-toggle="modal" data-target="#ModalTambahResep" data-id="'.$id_kunjungan.'">';
        echo '  <i class="ti ti-plus"></i> Tambah Resep';
        echo '</button>';
        if(empty($id_resep)){
            echo '<div class="card">';
            echo '  <div class="card-body text-center text-danger">';
            echo '      Belum ada informasi resep untuk kunjungan ini.';
            echo '  </div>';
            echo '</div>';
        }else{
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
                //Routing Tanda Tangan Dokter Sudah Ada Atau Tidak
                if(empty($data['ttd_dokter'])){
                    $ttd_dokter="";
                    $LabelTandaTangan='<a href="javascript:void(0);" id="ShowFormTtdDokterResep" class="text-danger">Belum Ada <i class="ti ti-pencil"></i></a>';
                }else{
                    $ttd_dokter= $data['ttd_dokter'];
                    $LabelTandaTangan='<br><img src="data:image/gif;base64,'. $ttd_dokter .'" width="150px">';
                }
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
                //Pengkajian
                if(!empty($data['pengkajian'])){
                    $pengkajian=$data['pengkajian'];
                    $JsonPengkajian=json_decode($pengkajian, true);
                    //Buka data pengkajian
                    $Pengkajian1=$JsonPengkajian['pengkajian1']['value'];
                    $Pengkajian2=$JsonPengkajian['pengkajian2']['value'];
                    $Pengkajian3=$JsonPengkajian['pengkajian3']['value'];
                    $Pengkajian4=$JsonPengkajian['pengkajian4']['value'];
                    $Pengkajian5=$JsonPengkajian['pengkajian5']['value'];
                    $Pengkajian6=$JsonPengkajian['pengkajian6']['value'];
                    $Pengkajian7=$JsonPengkajian['pengkajian7']['value'];
                    $Pengkajian8=$JsonPengkajian['pengkajian8']['value'];
                    $Pengkajian9=$JsonPengkajian['pengkajian9']['value'];
                    $Pengkajian10=$JsonPengkajian['pengkajian10']['value'];
                    $Pengkajian11=$JsonPengkajian['pengkajian11']['value'];
                    $Pengkajian12=$JsonPengkajian['pengkajian12']['value'];
                    $Pengkajian13=$JsonPengkajian['pengkajian13']['value'];
                    $KeteranganPengkajian1=$JsonPengkajian['pengkajian1']['keterangan'];
                    $KeteranganPengkajian2=$JsonPengkajian['pengkajian2']['keterangan'];
                    $KeteranganPengkajian3=$JsonPengkajian['pengkajian3']['keterangan'];
                    $KeteranganPengkajian4=$JsonPengkajian['pengkajian4']['keterangan'];
                    $KeteranganPengkajian5=$JsonPengkajian['pengkajian5']['keterangan'];
                    $KeteranganPengkajian6=$JsonPengkajian['pengkajian6']['keterangan'];
                    $KeteranganPengkajian7=$JsonPengkajian['pengkajian7']['keterangan'];
                    $KeteranganPengkajian8=$JsonPengkajian['pengkajian8']['keterangan'];
                    $KeteranganPengkajian9=$JsonPengkajian['pengkajian9']['keterangan'];
                    $KeteranganPengkajian10=$JsonPengkajian['pengkajian10']['keterangan'];
                    $KeteranganPengkajian11=$JsonPengkajian['pengkajian11']['keterangan'];
                    $KeteranganPengkajian12=$JsonPengkajian['pengkajian12']['keterangan'];
                    $KeteranganPengkajian13=$JsonPengkajian['pengkajian13']['keterangan'];
                    $petugas_pengkajian=$JsonPengkajian['petugas_pengkajian'];
                    if(!empty($JsonPengkajian['ttd_pengkaji'])){
                        $ttd_pengkaji=$JsonPengkajian['ttd_pengkaji'];
                        $LabelTandaTanganPengkaji='<br><img src="data:image/gif;base64,'. $ttd_pengkaji .'" width="150px">';
                    }else{
                        $ttd_pengkaji="";
                        $LabelTandaTanganPengkaji='<a href="javascript:void(0);" id="ShowFormTtdPengkaji" class="text-danger">Belum Ada <i class="ti ti-pencil"></i></a>';
                    }
                    
                }else{
                    $pengkajian="";
                    $JsonPengkajian="";
                    $Pengkajian1="";
                    $Pengkajian2="";
                    $Pengkajian3="";
                    $Pengkajian4="";
                    $Pengkajian5="";
                    $Pengkajian6="";
                    $Pengkajian7="";
                    $Pengkajian8="";
                    $Pengkajian9="";
                    $Pengkajian10="";
                    $Pengkajian11="";
                    $Pengkajian12="";
                    $Pengkajian13="";
                    $KeteranganPengkajian1="";
                    $KeteranganPengkajian2="";
                    $KeteranganPengkajian3="";
                    $KeteranganPengkajian4="";
                    $KeteranganPengkajian5="";
                    $KeteranganPengkajian6="";
                    $KeteranganPengkajian7="";
                    $KeteranganPengkajian8="";
                    $KeteranganPengkajian9="";
                    $KeteranganPengkajian10="";
                    $KeteranganPengkajian11="";
                    $KeteranganPengkajian12="";
                    $KeteranganPengkajian13="";
                    $petugas_pengkajian="";
                    $ttd_pengkaji="";
                    $LabelTandaTanganPengkaji='<a href="javascript:void(0);" id="ShowFormTtdPengkaji" class="text-danger">Belum Ada <i class="ti ti-pencil"></i></a>';
                }
                echo '<div class="card mb-2">';
                echo '  <div class="card-header">';
                echo '      <div class="row">';
                echo '          <div class="col-md-12 mb-2 text-center">';
                echo '              <dt>Resep No.'.$id_resep.'/'.$id_pasien.'/'.$id_kunjungan.'</dt>';
                echo '          </div>';
                echo '          <div class="col-md-12 mb-2 text-center">';
                echo '              <div class="btn-group">';
                echo '                  <a href="javascript:void(0);" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalEditResep" data-id="'.$id_resep.'">';
                echo '                      <i class="ti ti-pencil-alt"></i>';
                echo '                  </a>';
                echo '                  <a href="javascript:void(0);" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapusResep" data-id="'.$id_resep.'">';
                echo '                      <i class="ti ti-trash"></i>';
                echo '                  </a>';
                echo '                  <a href="javascript:void(0);" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalCetakResep" data-id="'.$id_resep.'">';
                echo '                      <i class="ti ti-printer"></i>';
                echo '                  </a>';
                echo '              </div>';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '  <div class="card-body">';
                echo '      <div class="row mb-4">';
                echo '          <div class="col col-md-12">';
                echo '              <ol>';
                //Informasi Dasar
                echo '                  <li class="mb-3">ID Resep : <code class="text-secondary">'.$id_resep.'</code></li>';
                echo '                  <li class="mb-3">Tgl Entry : <code class="text-secondary">'.$FormatTanggalEntry.'</code></li>';
                echo '                  <li class="mb-3">Tgl Resep : <code class="text-secondary">'.$FormatTanggalResep.'</code></li>';
                echo '                  <li class="mb-3">';
                echo '                      Pasien';
                echo '                      <ol>';
                echo '                          <li class="mb-1">Nama Pasien : <code class="text-secondary">'.$NamaPasien.'</code></li>';
                echo '                          <li class="mb-1">Tanggal Lahir : <code class="text-secondary">'.$TanggalLahir.'</code></li>';
                echo '                          <li class="mb-1">Tinggi Badan: <code class="text-secondary">'.$TinggiBadan.' cm</code></li>';
                echo '                          <li class="mb-1">Berat Badan : <code class="text-secondary">'.$BeratBadan.' Kg</code></li>';
                echo '                          <li class="mb-1">Luas Tubuh : <code class="text-secondary">'.$LuasTubuh.' m<sup>2</sup></code></li>';
                echo '                      </ol>';
                echo '                  </li>';
                //Dokter
                echo '                  <li class="mb-3">';
                echo '                      Dokter';
                echo '                      <ol>';
                echo '                          <li class="mb-1">Nama Dokter : <code class="text-secondary">'.$nama_dokter.'</code></li>';
                echo '                          <li class="mb-1">';
                echo '                              Kontak :';
                                                    $JumlahKontak=count($JsonKontakDokter);
                                                    for($i=0; $i<$JumlahKontak; $i++){
                                                        $KategoriKontak=$JsonKontakDokter[$i]['kategori_kontak'];
                                                        $NomorKontak=$JsonKontakDokter[$i]['nomor_kontak'];
                                                        echo '<code class="text-secondary">('.$KategoriKontak.' : '.$NomorKontak.'), </code>';
                                                    }
                echo '                          </li>';
                echo '                          <li class="mb-1">TTD : <code>'.$LabelTandaTangan.'</code><div id="FormTtdDokterResep"></div></li>';
                echo '                      </ol>';
                echo '                  </li>';
                //Uraian Obat
                echo '                  <li class="mb-3">';
                echo '                      Resep';
                echo '                      <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalTambahObatResep" data-id="'.$id_resep.'">';
                echo '                          <i class="ti ti-plus"></i> Tambah Obat';
                echo '                      </a>';
                echo '                      <ol>';
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
                                                        echo '  <code class="text-secondary">'.$nama_obat.' ('.$jumlah_obat.' '.$bentuk_sediaan.') </code>';
                                                        echo '  <a href="javascript:void(0);" class="text-primary mr-1 ml-1" data-toggle="modal" data-target="#ModalInfoObatResep" data-id="'.$id.','.$id_resep.'"><small><i class="ti ti-info-alt"></i></small></a>';
                                                        echo '  <a href="javascript:void(0);" class="text-primary mr-1" data-toggle="modal" data-target="#ModalEditObatResep" data-id="'.$id.','.$id_resep.'"><small><i class="ti ti-pencil"></i></small></a>';
                                                        echo '  <a href="javascript:void(0);" class="text-primary mr-1" data-toggle="modal" data-target="#ModalHapusObatResep" data-id="'.$id.','.$id_resep.'"><small><i class="ti ti-close"></i></small></a><br>';
                                                        echo '  <code class="text-secondary"><small>Metode: '.$metode.' ('.$dosis.' '.$unit.' '.$frekuensi.')</small></code><br>';
                                                        echo '  <code class="text-secondary"><small>Aturan: '.$aturan_tambahan.'</small></code>';
                                                        echo '</li>';
                                                    }
                                                }
                echo '                      </ol>';
                echo '                  </li>';
                //Catatan Resep
                echo '                  <li class="mb-3">';
                echo '                      Catatan';
                echo '                      <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalEditCatatanResep" data-id="'.$id_resep.'">';
                echo '                          <i class="ti ti-pencil"></i> Edit';
                echo '                      </a>';
                echo '                      <code class="text-secondary">'.$catatan.'</code>';
                echo '                  </li>';
                //Pengkajian Resep
                echo '                  <li class="mb-3">';
                echo '                      Pengkajian Resep';
                echo '                      <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalPengkajianResep" data-id="'.$id_resep.'">';
                echo '                          <i class="ti ti-pencil"></i> Edit';
                echo '                      </a>';
                if(!empty($data['pengkajian'])){
                    echo '                      <ul>';
                    echo '                          <li class="mt-2 mb-2">Petugas Pengkajian: <code class="text-secondary">'.$petugas_pengkajian.'</code></li>';
                    echo '                          <li class="mb-2">';
                    echo '                              Persyaratan Administrasi';
                    echo '                              <ol>';
                    echo '                                  <li>';
                    echo '                                      <small>Nama, umur, jenis kelamin, berat badan dan tinggi badan Pasien <code>('.$Pengkajian1.')</code></small><br>';
                    echo '                                      <small>(Keterangan: <code>'.$KeteranganPengkajian1.')</code></small>';
                    echo '                                  </li>';
                    echo '                                  <li>';
                    echo '                                      <small>Nama, nomor ijin, alamat dan paraf dokter  <code>('.$Pengkajian2.')</code></small><br>';
                    echo '                                      <small>(Keterangan: <code>'.$KeteranganPengkajian2.')</code></small>';
                    echo '                                  </li>';
                    echo '                                  <li>';
                    echo '                                      <small>Tanggal resep   <code>('.$Pengkajian3.')</code></small><br>';
                    echo '                                      <small>(Keterangan: <code>'.$KeteranganPengkajian3.')</code></small>';
                    echo '                                  </li>';
                    echo '                                  <li>';
                    echo '                                      <small>Ruangan/unit asal resep <code>('.$Pengkajian4.')</code></small><br>';
                    echo '                                      <small>(Keterangan: <code>'.$KeteranganPengkajian4.')</code></small>';
                    echo '                                  </li>';
                    echo '                              </ol>';
                    echo '                          </li>';
                    echo '                          <li class="mb-2">';
                    echo '                              Persyaratan Farmasetik';
                    echo '                              <ol>';
                    echo '                                  <li>';
                    echo '                                      <small>Nama obat, bentuk dan kekuatan sediaan <code>('.$Pengkajian5.')</code></small><br>';
                    echo '                                      <small>(Keterangan: <code>'.$KeteranganPengkajian5.'</code>)</small>';
                    echo '                                  </li>';
                    echo '                                  <li>';
                    echo '                                      <small>Dosis dan jumlah obat <code>('.$Pengkajian6.')</code></small><br>';
                    echo '                                      <small>(Keterangan: <code>'.$KeteranganPengkajian6.'</code>)</small>';
                    echo '                                  </li>';
                    echo '                                  <li>';
                    echo '                                      <small>Stabilitas <code>('.$Pengkajian7.')</code></small><br>';
                    echo '                                      <small>(Keterangan: <code>'.$KeteranganPengkajian7.'</code>)</small>';
                    echo '                                  </li>';
                    echo '                                  <li>';
                    echo '                                      <small>Aturan dan cara penggunaan <code>('.$Pengkajian8.')</code></small><br>';
                    echo '                                      <small>(Keterangan: <code>'.$KeteranganPengkajian8.'</code>)</small>';
                    echo '                                  </li>';
                    echo '                              </ol>';
                    echo '                          </li>';
                    echo '                          <li class="mb-2">';
                    echo '                              Persyaratan Klinis';
                    echo '                              <ol>';
                    echo '                                  <li>';
                    echo '                                      <small>Ketepatan indikasi, dosis, dan waktu penggunaan obat  <code>('.$Pengkajian9.')</code></small><br>';
                    echo '                                      <small>(Keterangan: <code>'.$KeteranganPengkajian9.'</code>)</small>';
                    echo '                                  </li>';
                    echo '                                  <li>';
                    echo '                                      <small>Duplikasi pengobatan  <code>('.$Pengkajian10.')</code></small><br>';
                    echo '                                      <small>(Keterangan: <code>'.$KeteranganPengkajian10.'</code>)</small>';
                    echo '                                  </li>';
                    echo '                                  <li>';
                    echo '                                      <small>Alergi dan Reaksi Obat yang Tidak Dikehendaki (ROTD)  <code>('.$Pengkajian11.')</code></small><br>';
                    echo '                                      <small>(Keterangan: <code>'.$KeteranganPengkajian11.'</code>)</small>';
                    echo '                                  </li>';
                    echo '                                  <li>';
                    echo '                                      <small>Kontraindikasi  <code>('.$Pengkajian12.')</code></small><br>';
                    echo '                                      <small>(Keterangan: <code>'.$KeteranganPengkajian12.'</code>)</small>';
                    echo '                                  </li>';
                    echo '                                  <li>';
                    echo '                                      <small>Interaksi obat   <code>('.$Pengkajian13.')</code></small><br>';
                    echo '                                      <small>(Keterangan: <code>'.$KeteranganPengkajian13.'</code>)</small>';
                    echo '                                  </li>';
                    echo '                              </ol>';
                    echo '                          </li>';
                    echo '                          <li class="mb-2">TTD Pengkajian: <code class="text-secondary">'.$LabelTandaTanganPengkaji.'</code><div id="FormTtdPengkaji"></div></li>';
                    echo '                      </ul>';
                }
                echo '                  </li>';
                //Status Resep
                echo '                  <li class="mb-3">Status Resep: <code><a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalStatusResep" data-id="'.$id_resep.'">'.$status.'</a> </code></li>';
                echo '              </ol>';
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
    //Menampilkan Form TTD Dokter
    $('#ShowFormTtdDokterResep').click(function(){
        var id_resep ="<?php echo "$id_resep"; ?>";
        $('#FormTtdDokterResep').html('Loading...');
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/FormTtdDokterResep.php',
            data        :   {id_resep: id_resep},
            success     :   function(data){
                $('#FormTtdDokterResep').html(data);
                //Menyembunyikan TTD
                $('#HideFormTtdDokterResep').click(function(){
                    $('#FormTtdDokterResep').html('');
                });
            }
        });
    });
    //Menampilkan Form TTD Pengkaji
    $('#ShowFormTtdPengkaji').click(function(){
        var id_resep ="<?php echo "$id_resep"; ?>";
        $('#FormTtdPengkaji').html('Loading...');
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/FormTtdPengkaji.php',
            data        :   {id_resep: id_resep},
            success     :   function(data){
                $('#FormTtdPengkaji').html(data);
                //Menyembunyikan TTD Pengkaji
                $('#HideFormTtdPengkaji').click(function(){
                    $('#FormTtdPengkaji').html('');
                });
            }
        });
    });
</script>

