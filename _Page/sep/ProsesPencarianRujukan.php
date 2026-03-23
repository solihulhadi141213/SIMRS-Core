<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    if(empty($_POST['DasarPencarianRujukan'])){
        echo '<a href="javascript:void(0);" class="list-group-item list-group-item-action">';
        echo '  <span class="text-danger">';
        echo '      Dasar Pencarian Tidak Boleh Kosong!';
        echo '  </span>';
        echo '</a>';
    }else{
        $DasarPencarianRujukan=$_POST['DasarPencarianRujukan'];
        if($DasarPencarianRujukan=="no_rujukan"){
            if(empty($_POST['PutNoRujukan'])){
                $ValidasiKelengkapanData="Nomor Rujukan Tidak Boleh Kosong!";
            }else{
                $ValidasiKelengkapanData="Valid";
            }
        }else{
            if(empty($_POST['PutNoKartu'])){
                $ValidasiKelengkapanData="Nomor Kartu Tidak Boleh Kosong!";
            }else{
                $ValidasiKelengkapanData="Valid";
            }
        }
        if($ValidasiKelengkapanData!=="Valid"){
            echo '<a href="javascript:void(0);" class="list-group-item list-group-item-action">';
            echo '  <span class="text-danger">';
            echo '      '.$ValidasiKelengkapanData.'';
            echo '  </span>';
            echo '</a>';
        }else{
            if(empty($_POST['PutNoRujukan'])){
                $PutNoRujukan="";
            }else{
                $PutNoRujukan=$_POST['PutNoRujukan'];
            }
            if(empty($_POST['PutNoKartu'])){
                $PutNoKartu="";
            }else{
                $PutNoKartu=$_POST['PutNoKartu'];
            }
            //Mengambil Response Berdasarkan Tipe Pencarian
            if($DasarPencarianRujukan=="no_rujukan"){
                $TipeRujukan="1";
                $Response=RujukanByNomorRujukan($url_vclaim,$consid,$secret_key,$user_key,$PutNoRujukan);
            }else{
                $TipeRujukan="1";
                $Response=RujukanByKartu($url_vclaim,$consid,$secret_key,$user_key,$PutNoKartu,$TipeRujukan);
            }
            if(empty($Response)){
                echo '<a href="javascript:void(0);" class="list-group-item list-group-item-action">';
                echo '  <span class="text-danger">';
                echo '      Terjadi kesalahan pada service BPJS!';
                echo '  </span>';
                echo '</a>';
            }else{
                $ambil_json =json_decode($Response, true);
                if(empty($ambil_json["metaData"]["code"])){
                    echo '<a href="javascript:void(0);" class="list-group-item list-group-item-action">';
                    echo '  <span class="text-danger">';
                    echo '      Terjadi Kesalahan Pada Service BPJS!</dt> '.$Response.'';
                    echo '  </span>';
                    echo '</a>';
                }else{
                    if($ambil_json["metaData"]["code"]!=="200"){
                        $PesanKesalahan=$ambil_json["metaData"]["message"];
                        echo '<a href="javascript:void(0);" class="list-group-item list-group-item-action">';
                        echo '  <span class="text-danger">';
                        echo '      Terjadi Kesalahan Pada Service BPJS! '.$TipeRujukan.'</dt> Pesan: '.$PesanKesalahan.'';
                        echo '  </span>';
                        echo '</a>';
                    }else{
                        if(empty($ambil_json["response"])){
                            echo '<a href="javascript:void(0);" class="list-group-item list-group-item-action">';
                            echo '  <span class="text-danger">';
                            echo '      Terjadi Kesalahan Pada Service BPJS!</dt> '.$PesanKesalahan.'';
                            echo '  </span>';
                            echo '</a>';
                        }else{
                            $string=$ambil_json["response"];
                            //Proses decode dan dekompresi
                            //--membuat key
                            $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                            $key="$consid$secret_key$timestamp";
                            //--masukan ke fungsi
                            $FileDeskripsi=stringDecrypt("$key", "$string");
                            $FileDekompresi=decompress("$FileDeskripsi");
                            $FileDekompresiJson =json_decode($FileDekompresi, true);
                            //--konveris json to raw
                            if(empty(json_decode($FileDekompresi, true))){
                                echo '<a href="javascript:void(0);" class="list-group-item list-group-item-action">';
                                echo '  <span class="text-danger">';
                                echo '      <dt>Proses Decrypt Gagal!</dt> Terjadi kesalahan pada saat melakukan proses deskripsi';
                                echo '  </span>';
                                echo '</a>';
                            }else{
                                if(empty($FileDekompresiJson['rujukan'])){
                                    echo '<a href="javascript:void(0);" class="list-group-item list-group-item-action">';
                                    echo '  <span class="text-danger">';
                                    echo '      <dt>Tidak ada rujukan yang ditemukan!</dt> '.$string.'';
                                    echo '  </span>';
                                    echo '</a>';
                                }else{
                                    $JsonData =json_decode($FileDekompresi, true);
                                    if($DasarPencarianRujukan=="no_rujukan"){
                                        //Pencarian berdasarkan rujukan
                                        $ViewData=$JsonData['rujukan'];
                                        if(empty($ViewData['diagnosa'])){
                                            $KodeDiagnosa="";
                                            $NamaDiagnosa="";
                                        }else{
                                            $Diagnosa=$ViewData['diagnosa'];
                                            if(empty($Diagnosa['kode'])){
                                                $KodeDiagnosa="";
                                            }else{
                                                $KodeDiagnosa=$Diagnosa['kode'];
                                            }
                                            if(empty($Diagnosa['nama'])){
                                                $NamaDiagnosa="";
                                            }else{
                                                $NamaDiagnosa=$Diagnosa['nama'];
                                            }
                                        }
                                        if(empty($ViewData['keluhan'])){
                                            $keluhan="";
                                        }else{
                                            $keluhan=$ViewData['keluhan'];
                                        }
                                        $noKunjungan=$ViewData['noKunjungan'];
                                        if(empty($ViewData['pelayanan'])){
                                            $Pelayanan="";
                                            $KodePelayanan="";
                                            $NamaPelayanan="";
                                        }else{
                                            $pelayanan=$ViewData['pelayanan'];
                                            if(empty($pelayanan['kode'])){
                                                $KodePelayanan="";
                                            }else{
                                                $KodePelayanan=$pelayanan['kode'];
                                            }
                                            if(empty($pelayanan['nama'])){
                                                $NamaPelayanan="";
                                            }else{
                                                $NamaPelayanan=$pelayanan['nama'];
                                            }
                                        }
                                        if(empty($ViewData['poliRujukan'])){
                                            $poliRujukan="";
                                            $KodePoliPerujuk="";
                                            $NamaPoliPerujuk="";
                                        }else{
                                            $poliRujukan=$ViewData['poliRujukan'];
                                            if(empty($poliRujukan['kode'])){
                                                $KodePoliPerujuk="";
                                            }else{
                                                $KodePoliPerujuk=$poliRujukan['kode'];
                                            }
                                            if(empty($poliRujukan['nama'])){
                                                $NamaPoliPerujuk="";
                                            }else{
                                                $NamaPoliPerujuk=$poliRujukan['nama'];
                                            }
                                        }
                                        if(empty($ViewData['provPerujuk'])){
                                            $provPerujuk="";
                                            $KodeProvPerujuk="";
                                            $NamaProvPerujuk="";
                                        }else{
                                            $provPerujuk=$ViewData['provPerujuk'];
                                            if(empty($provPerujuk['kode'])){
                                                $KodeProvPerujuk="";
                                            }else{
                                                $KodeProvPerujuk=$provPerujuk['kode'];
                                            }
                                            if(empty($provPerujuk['nama'])){
                                                $NamaProvPerujuk="";
                                            }else{
                                                $NamaProvPerujuk=$provPerujuk['nama'];
                                            }
                                        }
                                        if(empty($ViewData['peserta']['hakKelas'])){
                                            $hakKelas="";
                                            $KeteranganHakKelas="";
                                            $KodeHakKelas="";
                                        }else{
                                            $hakKelas=$ViewData['peserta']['hakKelas'];
                                            if(empty($hakKelas['keterangan'])){
                                                $KeteranganHakKelas="";
                                            }else{
                                                $KeteranganHakKelas=$hakKelas['keterangan'];
                                            }
                                            if(empty($hakKelas['kode'])){
                                                $KodeHakKelas="";
                                            }else{
                                                $KodeHakKelas=$hakKelas['kode'];
                                            }
                                        }
                                        if(empty($ViewData['tglKunjungan'])){
                                            $tglKunjungan="";
                                        }else{
                                            $tglKunjungan=$ViewData['tglKunjungan'];
                                        }
                                        echo '<div class="list-group-item list-group-item-action">';
                                        echo '  <dt class="text-primary"><a href="javascript:void(0);" class="SetNoRujukan">'.$noKunjungan.'</a></dt>';
                                        echo '  <ol>';
                                        echo '      <li class="mb-3">';
                                        echo '          Diagnosa';
                                        echo '          <ul>';
                                        echo '              <li>Kode : <code class="text-secondary" id="SetDiagnosaRujukan'.$noKunjungan.'">'.$KodeDiagnosa.'</code></li>';
                                        echo '              <li>Deskripsi : <code class="text-secondary">'.$NamaDiagnosa.'</code></li>';
                                        echo '          </ul>';
                                        echo '      </li>';
                                        echo '      <li class="mb-3">Keluhan : <code class="text-secondary">'.$keluhan.'</code></li>';
                                        echo '      <li class="mb-3">No.Rujukan : <code class="text-secondary">'.$noKunjungan.'</code></li>';
                                        echo '      <li class="mb-3">';
                                        echo '          Pelayanan';
                                        echo '          <ul>';
                                        echo '              <li>Kode : <code class="text-secondary" id="SetKodePelayanan'.$noKunjungan.'">'.$KodePelayanan.'</code></li>';
                                        echo '              <li>Nama : <code class="text-secondary">'.$NamaPelayanan.'</code></li>';
                                        echo '          </ul>';
                                        echo '      </li>';
                                        echo '      <li class="mb-3">';
                                        echo '          Poli Perujuk';
                                        echo '          <ul>';
                                        echo '              <li>Kode : <code class="text-secondary" id="SetKodePoliRujukan'.$noKunjungan.'">'.$KodePoliPerujuk.'</code></li>';
                                        echo '              <li>Nama : <code class="text-secondary">'.$NamaPoliPerujuk.'</code></li>';
                                        echo '          </ul>';
                                        echo '      </li>';
                                        echo '      <li class="mb-3">';
                                        echo '          Provider Perujuk';
                                        echo '          <ul>';
                                        echo '              <li>Kode : <code class="text-secondary" id="SetKodePpk'.$noKunjungan.'">'.$KodeProvPerujuk.'</code></li>';
                                        echo '              <li>Nama : <code class="text-secondary">'.$NamaProvPerujuk.'</code></li>';
                                        echo '          </ul>';
                                        echo '      </li>';
                                        echo '      <li class="mb-3">';
                                        echo '          Hak Kelas';
                                        echo '          <ul>';
                                        echo '              <li>Kode : <code class="text-secondary" id="SetKodeHakKelas'.$noKunjungan.'">'.$KodeHakKelas.'</code></li>';
                                        echo '              <li>Keterangan : <code class="text-secondary">'.$KeteranganHakKelas.'</code></li>';
                                        echo '          </ul>';
                                        echo '      </li>';
                                        echo '      <li class="mb-3">Tgl.Kunjungan : <code class="text-secondary" id="SetTanggalRujukan'.$noKunjungan.'">'.$tglKunjungan.'</code></li>';
                                        echo '  </ol>';
                                        echo '</div>';
                                    }else{
                                        //Pencarian Berdasarkan Kartu
                                        $list=$JsonData['rujukan'];
                                        $Jumlah=count($list);
                                        $no=1;
                                        for($a=0; $a<$Jumlah; $a++){
                                            $noKunjungan=$list[$a]['noKunjungan'];
                                            $kodediagnosa=$list[$a]['diagnosa']['kode'];
                                            $namadiagnosa=$list[$a]['diagnosa']['nama'];
                                            $keluhan=$list[$a]['keluhan'];
                                            $tglKunjungan=$list[$a]['tglKunjungan'];
                                            $provPerujuk=$list[$a]['provPerujuk'];
                                            $KodeProvPerujuk=$list[$a]['provPerujuk']['kode'];
                                            $NamaProvPerujuk=$list[$a]['provPerujuk']['nama'];
                                            $KodepoliRujukan=$list[$a]['poliRujukan']['kode'];
                                            $NamapoliRujukan=$list[$a]['poliRujukan']['nama'];
                                            $KodePelayanan=$list[$a]['pelayanan']['kode'];
                                            $NamaPelayanan=$list[$a]['pelayanan']['nama'];
                                            $tglKunjungan=$list[$a]['tglKunjungan'];
                                            //Hak Kelas
                                            $KeteranganHakKelas=$list[$a]['peserta']['hakKelas']['keterangan'];
                                            $KodeHakKelas=$list[$a]['peserta']['hakKelas']['kode'];
                                            echo '<div class="list-group-item list-group-item-action">';
                                            echo '  <dt class="text-primary"><a href="javascript:void(0);" class="SetNoRujukan">'.$noKunjungan.'</a></dt>';
                                            echo '  <ol>';
                                            echo '      <li class="mb-2">Tanggal : <code class="text-secondary" id="SetTanggalRujukan'.$noKunjungan.'">'.$tglKunjungan.'</code></li>';
                                            echo '      <li class="mb-2">Diagnosa : <code class="text-secondary" id="SetDiagnosaRujukan'.$noKunjungan.'">'.$kodediagnosa.'-'.$namadiagnosa.'</code></li>';
                                            echo '      <li class="mb-2">Pelayanan : <code class="text-secondary" id="SetKodePelayanan'.$noKunjungan.'">'.$KodePelayanan.'</code> <code class="text-secondary">'.$NamaPelayanan.'</code></li> ';
                                            echo '      <li class="mb-2">Poli Rujukan : <code class="text-secondary" id="SetKodePoliRujukan'.$noKunjungan.'">'.$KodepoliRujukan.'</code> <code class="text-secondary">'.$KodepoliRujukan.'</code></li> ';
                                            echo '      <li class="mb-2">';
                                            echo '          Hak Kelas : ';
                                            echo '          <code class="text-secondary" id="SetKodeHakKelas'.$noKunjungan.'">'.$KodeHakKelas.'</code> - <code class="text-secondary">('.$KeteranganHakKelas.')</code>';
                                            echo '      </li>';
                                            echo '      <li class="mb-2">';
                                            echo '          Provider Perujuk : ';
                                            echo '          <code class="text-secondary" id="SetKodePpk'.$noKunjungan.'">'.$KodeProvPerujuk.'</code> - <code class="text-secondary">'.$NamaProvPerujuk.'</code>';
                                            echo '      </li>';
                                            echo '  </ol>';
                                            echo '</div>';
                                            $no++;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
<script>
    //Ketika Dipilih Rujukan
    $(".SetNoRujukan").click(function() {
        //Menangkap Data
        var noRujukan = $(this).html();
        var tglRujukan = $('#SetTanggalRujukan'+noRujukan+'').html();
        var SetKodePpk = $('#SetKodePpk'+noRujukan+'').html();
        var SetDiagnosaRujukan = $('#SetDiagnosaRujukan'+noRujukan+'').html();
        var SetKodePelayanan = $('#SetKodePelayanan'+noRujukan+'').html();
        var SetKodePoliRujukan = $('#SetKodePoliRujukan'+noRujukan+'').html();
        var SetKodeHakKelas = $('#SetKodeHakKelas'+noRujukan+'').html();
        //Masukan ke Form
        $('#noRujukan').val(noRujukan);
        $('#tglRujukan').val(tglRujukan);
        $('#rujukan_dari').val(SetKodePpk);
        $("#jnsPelayanan").val(SetKodePelayanan);
        $('#diagAwal').val(SetDiagnosaRujukan);
        $('#poli_tujuan').val(SetKodePoliRujukan);
        $('#klsRawatHak').val(SetKodeHakKelas);
        
        //Tutup Modal
        $('#ModalCariRujukan').modal('hide');
    });
</script>