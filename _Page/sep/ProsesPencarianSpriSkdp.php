<?php
    //Zona Waktu
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    //Menangkap parameter
    if(empty($_POST['ModePencarianSpriSkdp'])){
        echo '<div class="list-group-item list-group-item-action text-danger">Mode Pencarian Tidak Boleh Kosong</div>';
    }else{
        $ModePencarianSpriSkdp=$_POST['ModePencarianSpriSkdp'];
        if($ModePencarianSpriSkdp=="nomor_surat_kontrol"){
            if(empty($_POST['KeywordByNomorSuratKontrol'])){
                $Validasi="Nomor Surat Kontrol Tidak Boleh Kosong";
            }else{
                $Validasi="Valid";
                $KeywordByNomorSuratKontrol=$_POST['KeywordByNomorSuratKontrol'];
            }
        }else{
            if(empty($_POST['KeywordByNomorKartuBpjs'])){
                $Validasi="Nomor Kartu BPJS Tidak Boleh Kosong";
            }else{
                if(empty($_POST['TanggalPencarianSpriSkdp'])){
                    $Validasi="Tanggal Pencarian Tidak Boleh Kosong";
                }else{
                    $Validasi="Valid";
                    $KeywordByNomorKartuBpjs=$_POST['KeywordByNomorKartuBpjs'];
                    $TanggalPencarianSpriSkdp=$_POST['TanggalPencarianSpriSkdp'];
                    $strtotime=strtotime($TanggalPencarianSpriSkdp);
                    $Bulan=date('m',$strtotime);
                    $Tahun=date('Y',$strtotime);
                }
            }
        }
        if($Validasi!=="Valid"){
            echo '<div class="list-group-item list-group-item-action text-danger">'.$Validasi.'</div>';
        }else{
            if($ModePencarianSpriSkdp=="nomor_surat_kontrol"){
                $url="$url_vclaim/RencanaKontrol/noSuratKontrol/$KeywordByNomorSuratKontrol";
            }else{
                $url="$url_vclaim/RencanaKontrol/ListRencanaKontrol/Bulan/$Bulan/Tahun/$Tahun/Nokartu/$KeywordByNomorKartuBpjs/filter/1";
            }
            $Response=BridgingServiceGet($consid,$secret_key,$user_key,$url);
            if(empty($Response)){
                echo '<div class="list-group-item list-group-item-action text-danger">Tidak ada response dari service BPJS</div>';
            }else{
                $ambil_json =json_decode($Response, true);
                if(empty($ambil_json["metaData"]["code"])){
                    echo '<div class="list-group-item list-group-item-action text-danger">Tidak ada kode kesalahan dari service BPJS <br>'.$Response.'</div>';
                }else{
                    if($ambil_json["metaData"]["code"]!=="200"){
                        $PesanKesalahan=$ambil_json["metaData"]["message"];
                        echo '<div class="list-group-item list-group-item-action text-danger">';
                        echo '  <span class="text-danger">';
                        echo '      Terjadi Kesalahan Pada Service BPJS!</dt> Pesan: '.$PesanKesalahan.'';
                        echo '  </span>';
                        echo '</div>';
                    }else{
                        if(empty($ambil_json["response"])){
                            echo '<div class="list-group-item list-group-item-action text-danger">';
                            echo '  <span class="text-danger">';
                            echo '      Terjadi Kesalahan Pada Service BPJS!</dt> '.$PesanKesalahan.'';
                            echo '  </span>';
                            echo '</div>';
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
                                echo '<div class="list-group-item list-group-item-action text-danger">';
                                echo '  <span class="text-danger">';
                                echo '      <dt>Proses Decrypt Gagal!</dt> Terjadi kesalahan pada saat melakukan proses deskripsi';
                                echo '  </span>';
                                echo '</div>';
                            }else{
                                $JsonData =json_decode($FileDekompresi, true);
                                if($ModePencarianSpriSkdp=="nomor_surat_kontrol"){
                                    $noSuratKontrol=$JsonData['noSuratKontrol'];
                                    $tglRencanaKontrol=$JsonData['tglRencanaKontrol'];
                                    $tglTerbit=$JsonData['tglTerbit'];
                                    $jnsKontrol=$JsonData['jnsKontrol'];
                                    $poliTujuan=$JsonData['poliTujuan'];
                                    $namaPoliTujuan=$JsonData['namaPoliTujuan'];
                                    $kodeDokter=$JsonData['kodeDokter'];
                                    $namaDokter=$JsonData['namaDokter'];
                                    $flagKontrol=$JsonData['flagKontrol'];
                                    $kodeDokterPembuat=$JsonData['kodeDokterPembuat'];
                                    $namaDokterPembuat=$JsonData['namaDokterPembuat'];
                                    $namaJnsKontrol=$JsonData['namaJnsKontrol'];
                                    if(empty($JsonData['sep'])){
                                        $sep="";
                                        $noSep="";
                                        $tglSep="";
                                        $jnsPelayanan="";
                                        $poli="";
                                        $diagnosa="";
                                        $peserta="";
                                        $noKartu="";
                                        $nama="";
                                        $tglLahir="";
                                        $kelamin="";
                                        $hakKelas="";
                                    }else{
                                        if($jnsKontrol=="2"){
                                            $sep=$JsonData['sep'];
                                            $noSep=$sep['noSep'];
                                            $tglSep=$sep['tglSep'];
                                            $jnsPelayanan=$sep['jnsPelayanan'];
                                            $poli=$sep['poli'];
                                            $diagnosa=$sep['diagnosa'];
                                            $peserta=$sep['peserta'];
                                            if(!empty($peserta['noKartu'])){
                                                $noKartu=$peserta['noKartu'];
                                            }else{
                                                $noKartu="";
                                            }
                                            if(!empty($peserta['nama'])){
                                                $nama=$peserta['nama'];
                                            }else{
                                                $nama="";
                                            }
                                            if(!empty($peserta['tglLahir'])){
                                                $tglLahir=$peserta['tglLahir'];
                                            }else{
                                                $tglLahir="";
                                            }
                                            if(!empty($peserta['kelamin'])){
                                                $kelamin=$peserta['kelamin'];
                                            }else{
                                                $kelamin="";
                                            }
                                            if(!empty($peserta['hakKelas'])){
                                                $hakKelas=$peserta['hakKelas'];
                                            }else{
                                                $hakKelas="";
                                            }
                                        }else{
                                            $sep="";
                                            $noSep="";
                                            $tglSep="";
                                            $jnsPelayanan="";
                                            $poli="";
                                            $diagnosa="";
                                            $peserta="";
                                            $noKartu="";
                                            $nama="";
                                            $tglLahir="";
                                            $kelamin="";
                                            $hakKelas="";
                                        }
                                    }
                                    if(empty($JsonData['provUmum'])){
                                        $provUmum="";
                                        $kdProvider="";
                                        $nmProvider="";
                                    }else{
                                        $provUmum=$JsonData['provUmum'];
                                        $kdProvider=$provUmum['kdProvider'];
                                        $nmProvider=$provUmum['nmProvider'];
                                    }
                                    if(empty($JsonData['provPerujuk'])){
                                        $provPerujuk="";
                                        $kdProviderPerujuk="";
                                        $nmProviderPerujuk="";
                                        $asalRujukan2="";
                                        $noRujukan2="";
                                        $tglRujukan2="";
                                    }else{
                                        $provPerujuk=$JsonData['provPerujuk'];
                                        $kdProviderPerujuk=$provPerujuk['kdProviderPerujuk'];
                                        $nmProviderPerujuk=$provPerujuk['nmProviderPerujuk'];
                                        $asalRujukan2=$provPerujuk['asalRujukan'];
                                        $noRujukan2=$provPerujuk['noRujukan'];
                                        $tglRujukan2=$provPerujuk['tglRujukan'];
                                    }
                                    echo '<div class="list-group-item list-group-item-action">';
                                    echo '  <a href="javascript:void(0);" class="text-primary"><dt class="SetNomorSuratKontrol">'.$noSuratKontrol.'</dt></a>';
                                    echo '  <ol>';
                                    echo '      <li>Tanggal Rencana Kontrol : <code class="text-secondary">'.$tglRencanaKontrol.'</code></li>';
                                    echo '      <li>Tgl.Terbit : <code class="text-secondary">'.$tglTerbit.'</code></li>';
                                    echo '      <li>Jenis Kontrol : <code class="text-secondary">'.$jnsKontrol.'-'.$namaJnsKontrol.'</code></li>';
                                    echo '      <li>Poliklinik Tujuan : <code class="text-secondary">'.$poliTujuan.'-'.$namaPoliTujuan.'</code></li>';
                                    echo '      <li>Kode Dokter : <code class="text-secondary" id="SetDokterKontrol'.$noSuratKontrol.'">'.$kodeDokter.'</code></li>';
                                    echo '      <li>Nama Dokter : <code class="text-secondary">'.$namaDokter.'</code></li>';
                                    echo '      <li>Flag Kontrol : <code class="text-secondary">'.$flagKontrol.'</code></li>';
                                    echo '      <li>Dokter Pembuat : <code class="text-secondary">'.$kodeDokterPembuat.'-'.$namaDokterPembuat.'</code></li>';
                                    echo '      <li class="mt-2 mb-2">';
                                    echo '          SEP :';
                                    echo '          <ol>';
                                    echo '              <li>Nomor SEP : <code class="text-secondary">'.$noSep.'</code></li>';
                                    echo '              <li>Tanggal SEP : <code class="text-secondary">'.$tglSep.'</code></li>';
                                    echo '              <li>Jenis Pelayanan : <code class="text-secondary">'.$jnsPelayanan.'</code></li>';
                                    echo '              <li>Poli : <code class="text-secondary">'.$poli.'</code></li>';
                                    echo '              <li>Diagnosa : <code class="text-secondary">'.$diagnosa.'</code></li>';
                                    echo '              <li>Nomor Kartu : <code class="text-secondary">'.$noKartu.'</code></li>';
                                    echo '              <li>Nama : <code class="text-secondary">'.$nama.'</code></li>';
                                    echo '              <li>Tanggal Lahir : <code class="text-secondary">'.$tglLahir.'</code></li>';
                                    echo '              <li>Gender : <code class="text-secondary">'.$kelamin.'</code></li>';
                                    echo '              <li>Hak Kelas : <code class="text-secondary">'.$hakKelas.'</code></li>';
                                    echo '          </ol>';
                                    echo '      </li>';
                                    echo '      <li class="mt-2 mb-2">';
                                    echo '          Provider Umum :';
                                    echo '          <ol>';
                                    echo '              <li>Kode Provider : <code class="text-secondary">'.$kdProvider.'</code></li>';
                                    echo '              <li>Nama Provider : <code class="text-secondary">'.$nmProvider.'</code></li>';
                                    echo '          </ol>';
                                    echo '      </li>';
                                    echo '      <li class="mt-2 mb-2">';
                                    echo '          Provider Perujuk :';
                                    echo '          <ol>';
                                    echo '              <li>Kode : <code class="text-secondary">'.$kdProviderPerujuk.'</code></li>';
                                    echo '              <li>Nama : <code class="text-secondary">'.$nmProviderPerujuk.'</code></li>';
                                    echo '              <li>Asal Rujukan : <code class="text-secondary">'.$asalRujukan2.'</code></li>';
                                    echo '              <li>Nomor Rujukan : <code class="text-secondary">'.$noRujukan2.'</code></li>';
                                    echo '              <li>Tanggal Rujukan : <code class="text-secondary">'.$tglRujukan2.'</code></li>';
                                    echo '          </ol>';
                                    echo '      </li>';
                                    echo '  </ol>';
                                    echo '</div>';
                                }else{
                                    $ListSuratKontrol=$JsonData['list'];
                                    foreach($ListSuratKontrol as $list){
                                        $noSuratKontrol=$list['noSuratKontrol'];
                                        $jnsPelayanan=$list['jnsPelayanan'];
                                        $jnsKontrol=$list['jnsKontrol'];
                                        $namaJnsKontrol=$list['namaJnsKontrol'];
                                        $tglRencanaKontrol=$list['tglRencanaKontrol'];
                                        $tglTerbitKontrol=$list['tglTerbitKontrol'];
                                        $noSepAsalKontrol=$list['noSepAsalKontrol'];
                                        $poliAsal=$list['poliAsal'];
                                        $namaPoliAsal=$list['namaPoliAsal'];
                                        $poliTujuan=$list['poliTujuan'];
                                        $namaPoliTujuan=$list['namaPoliTujuan'];
                                        $tglSEP=$list['tglSEP'];
                                        $kodeDokter=$list['kodeDokter'];
                                        $namaDokter=$list['namaDokter'];
                                        $noKartu=$list['noKartu'];
                                        $nama=$list['nama'];
                                        $terbitSEP=$list['terbitSEP'];
                                        echo '<div class="list-group-item list-group-item-action">';
                                        echo '  <a href="javascript:void(0);" class="text-primary"><dt class="SetNomorSuratKontrol">'.$noSuratKontrol.'</dt></a>';
                                        echo '  <ol>';
                                        echo '      <li>Jenis Pelayanan : <code class="text-secondary">'.$jnsPelayanan.'</code></li>';
                                        echo '      <li>Jenis Kontrol : <code class="text-secondary">'.$jnsKontrol.'-'.$namaJnsKontrol.'</code></li>';
                                        echo '      <li>Tgl.Kontrol : <code class="text-secondary">'.$tglRencanaKontrol.'</code></li>';
                                        echo '      <li>Tgl.Terbit : <code class="text-secondary">'.$tglTerbitKontrol.'</code></li>';
                                        echo '      <li>Nomor SEP Asal : <code class="text-secondary">'.$noSepAsalKontrol.'</code></li>';
                                        echo '      <li>Poliklinik Asal : <code class="text-secondary">'.$poliAsal.'-'.$namaPoliAsal.'</code></li>';
                                        echo '      <li>Poliklinik Tujuan : <code class="text-secondary">'.$poliTujuan.'-'.$namaPoliTujuan.'</code></li>';
                                        echo '      <li>Tanggal SEP : <code class="text-secondary">'.$tglSEP.'</code></li>';
                                        echo '      <li>Kode Dokter : <code class="text-secondary" id="SetDokterKontrol'.$noSuratKontrol.'">'.$kodeDokter.'</code></li>';
                                        echo '      <li>Nama Dokter : <code class="text-secondary">'.$namaDokter.'</code></li>';
                                        echo '      <li>Nomor Kartu : <code class="text-secondary">'.$noKartu.'</code></li>';
                                        echo '      <li>Nama Pasien : <code class="text-secondary">'.$nama.'</code></li>';
                                        echo '      <li>Terbit SEP: <code class="text-secondary">'.$terbitSEP.'</code></li>';
                                        echo '  </ol>';
                                        echo '</div>';
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
    $(".SetNomorSuratKontrol").click(function() {
        //Menangkap Data
        var noSuratKontrol = $(this).html();
        var SetDokterKontrol = $('#SetDokterKontrol'+noSuratKontrol+'').html();
        //Masukan ke Form
        $('#noSurat').val(noSuratKontrol);
        $('#kodeDPJP').val(SetDokterKontrol);
        
        //Tutup Modal
        $('#ModalPencarianSpriSkdp').modal('hide');
    });
</script>