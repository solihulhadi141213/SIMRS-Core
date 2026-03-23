<?php
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    //Menangkap sep
    if(empty($_POST['sep'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <span class="text-danger">Nomor SEP Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $sep=$_POST['sep'];
        $Response=DetailSep($url_vclaim,$consid,$secret_key,$user_key,$url_vclaim,$sep);
        if(empty($Response)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center">';
            echo '      <span class="text-danger">Tidak Ada Response Dari Service Function SIMRS!</span>';
            echo '  </div>';
            echo '</div>';
        }else{
            $ResponseData =json_decode($Response, true);
            if(empty($ResponseData['metaData']['code'])){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center">';
                echo '      <span class="text-danger">Tidak Ada Response Dari Service BPJS!</span>';
                echo '  </div>';
                echo '</div>';
            }else{
                $ResponseCode=$ResponseData['metaData']['code'];
                if($ResponseCode!=="200"){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center">';
                    echo '      <span class="text-danger">Pesan: '.$ResponseData['metaData']['message'].'</span>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    if(empty($ResponseData['response'])){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center">';
                        echo '      <dt class="text-danger">Terjadi Kesalahan Pada Response</dt>';
                        echo '      <span class="text-danger">Pesan: '.$ResponseData['metaData']['message'].'</span>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        $string=$ResponseData['response'];
                        $stringData =json_decode($string, true);
                        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                        $key="$consid$secret_key$timestamp";
                        //--masukan ke fungsi
                        $FileDeskripsi=stringDecrypt("$key", "$string");
                        $FileDekompresi=decompress("$FileDeskripsi");
                        //--konveris json to raw
                        $JsonData =json_decode($FileDekompresi, true);
                        if(empty($JsonData["noSep"])){
                            $noSep='<span class="text-danger">Tidak Ada</span>';
                            $id_kunjungan="";
                        }else{
                            $noSep=$JsonData["noSep"];
                            $id_kunjungan=getDataDetail($Conn,"kunjungan_utama",'sep',$noSep,'id_kunjungan');
                        }
                        if(empty($JsonData["tglSep"])){
                            $tglSep='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $tglSep=$JsonData["tglSep"];
                            $strtotime=strtotime($tglSep);
                            $tglSep=date('d/m/Y',$strtotime);
                        }
                        if(empty($JsonData["jnsPelayanan"])){
                            $jnsPelayanan='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $jnsPelayanan=$JsonData["jnsPelayanan"];
                        }
                        if(empty($JsonData["kelasRawat"])){
                            $kelasRawat='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $kelasRawat=$JsonData["kelasRawat"];
                        }
                        if(empty($JsonData["diagnosa"])){
                            $diagnosa='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $diagnosa=$JsonData["diagnosa"];
                        }
                        if(empty($JsonData["noRujukan"])){
                            $noRujukan='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $noRujukan=$JsonData["noRujukan"];
                        }
                        if(empty($JsonData["poli"])){
                            $poli='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $poli=$JsonData["poli"];
                        }
                        if(empty($JsonData["poliEksekutif"])){
                            $poliEksekutif='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $poliEksekutif=$JsonData["poliEksekutif"];
                        }
                        if(empty($JsonData["catatan"])){
                            $catatan='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $catatan=$JsonData["catatan"];
                        }
                        if(empty($JsonData["penjamin"])){
                            $penjamin='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $penjamin=$JsonData["penjamin"];
                        }
                        if(empty($JsonData["kdStatusKecelakaan"])){
                            $kdStatusKecelakaan='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $kdStatusKecelakaan=$JsonData["kdStatusKecelakaan"];
                        }
                        if(empty($JsonData["nmstatusKecelakaan"])){
                            $nmstatusKecelakaan='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $nmstatusKecelakaan=$JsonData["nmstatusKecelakaan"];
                        }
                        if(empty($JsonData["lokasiKejadian"])){
                            $lokasiKejadian='<span class="text-danger">Tidak Ada</span>';
                            $kdKab='<span class="text-danger">Tidak Ada</span>';
                            $kdKec='<span class="text-danger">Tidak Ada</span>';
                            $kdProp='<span class="text-danger">Tidak Ada</span>';
                            $ketKejadian='<span class="text-danger">Tidak Ada</span>';
                            $lokasi='<span class="text-danger">Tidak Ada</span>';
                            $tglKejadian='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $lokasiKejadian=$JsonData["lokasiKejadian"];
                            if(empty($lokasiKejadian["kdKab"])){
                                $kdKab='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $kdKab=$lokasiKejadian["kdKab"];
                            }
                            if(empty($lokasiKejadian["kdKec"])){
                                $kdKec='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $kdKec=$lokasiKejadian["kdKec"];
                            }
                            if(empty($lokasiKejadian["kdProp"])){
                                $kdProp='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $kdProp=$lokasiKejadian["kdProp"];
                            }
                            if(empty($lokasiKejadian["ketKejadian"])){
                                $ketKejadian='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $ketKejadian=$lokasiKejadian["ketKejadian"];
                            }
                            if(empty($lokasiKejadian["lokasi"])){
                                $lokasi='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $lokasi=$lokasiKejadian["lokasi"];
                            }
                            if(empty($lokasiKejadian["tglKejadian"])){
                                $tglKejadian='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $tglKejadian=$lokasiKejadian["tglKejadian"];
                            }
                        }
                        if(empty($JsonData["dpjp"])){
                            $kdDPJP='<span class="text-danger">Tidak Ada</span>';
                            $nmDPJP='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            if(empty($JsonData["dpjp"]["kdDPJP"])){
                                $kdDPJP='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $kdDPJP=$JsonData["dpjp"]["kdDPJP"];
                            }
                            if(empty($JsonData["dpjp"]["nmDPJP"])){
                                $nmDPJP='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $nmDPJP=$JsonData["dpjp"]["nmDPJP"];
                            }
                        }
                        if(empty($JsonData["peserta"])){
                            $peserta='<span class="text-danger">Tidak Ada</span>';
                            $asuransi='<span class="text-danger">Tidak Ada</span>';
                            $hakKelas='<span class="text-danger">Tidak Ada</span>';
                            $jnsPeserta='<span class="text-danger">Tidak Ada</span>';
                            $kelamin='<span class="text-danger">Tidak Ada</span>';
                            $nama='<span class="text-danger">Tidak Ada</span>';
                            $noKartu='<span class="text-danger">Tidak Ada</span>';
                            $noMr='<span class="text-danger">Tidak Ada</span>';
                            $tglLahir='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $peserta=$JsonData["peserta"];
                            if(empty($peserta["asuransi"])){
                                $asuransi='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $asuransi=$peserta["asuransi"];
                            }
                            if(empty($peserta["hakKelas"])){
                                $hakKelas='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $hakKelas=$peserta["hakKelas"];
                            }
                            if(empty($peserta["jnsPeserta"])){
                                $jnsPeserta='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $jnsPeserta=$peserta["jnsPeserta"];
                            }
                            if(empty($peserta["kelamin"])){
                                $kelamin='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $kelamin=$peserta["kelamin"];
                            }
                            if(empty($peserta["nama"])){
                                $nama='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $nama=$peserta["nama"];
                            }
                            if(empty($peserta["noKartu"])){
                                $noKartu='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $noKartu=$peserta["noKartu"];
                            }
                            if(empty($peserta["noMr"])){
                                $noMr='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $noMr=$peserta["noMr"];
                            }
                            if(empty($peserta["tglLahir"])){
                                $tglLahir='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $tglLahir=$peserta["tglLahir"];
                                $strtotime=strtotime($tglLahir);
                                $tglLahir=date('d/m/Y',$strtotime);
                            }
                        }
                        if(empty($JsonData["klsRawat"])){
                            $klsRawat='<span class="text-danger">Tidak Ada</span>';
                            $klsRawatHak='<span class="text-danger">Tidak Ada</span>';
                            $klsRawatNaik='<span class="text-danger">Tidak Ada</span>';
                            $pembiayaan='<span class="text-danger">Tidak Ada</span>';
                            $penanggungJawab='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $klsRawat=$JsonData["klsRawat"];
                            if(empty($klsRawat["klsRawatHak"])){
                                $klsRawatHak='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $klsRawatHak=$klsRawat["klsRawatHak"];
                            }
                            if(empty($klsRawat["klsRawatNaik"])){
                                $klsRawatNaik='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $klsRawatNaik=$klsRawat["klsRawatNaik"];
                            }
                            if(empty($klsRawat["pembiayaan"])){
                                $pembiayaan='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $pembiayaan=$klsRawat["pembiayaan"];
                            }
                            if(empty($klsRawat["penanggungJawab"])){
                                $penanggungJawab='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $penanggungJawab=$klsRawat["penanggungJawab"];
                            }
                        }
                        if(empty($JsonData["kontrol"])){
                            $kontrol='<span class="text-danger">Tidak Ada</span>';
                            $kdDokter='<span class="text-danger">Tidak Ada</span>';
                            $nmDokter='<span class="text-danger">Tidak Ada</span>';
                            $noSurat='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $kontrol=$JsonData["kontrol"];
                            if(empty($kontrol["kdDokter"])){
                                $kdDokter='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $kdDokter=$kontrol["kdDokter"];
                            }
                            if(empty($kontrol["nmDokter"])){
                                $nmDokter='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $nmDokter=$kontrol["nmDokter"];
                            }
                            if(empty($kontrol["noSurat"])){
                                $noSurat='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $noSurat=$kontrol["noSurat"];
                            }
                        }
                        if(empty($JsonData["cob"])){
                            $cob='<span class="text-danger">Tidak</span>';
                        }else{
                            $cob=$JsonData["cob"];
                        }
                        if(empty($JsonData["katarak"])){
                            $katarak='<span class="text-danger">Tidak</span>';
                        }else{
                            $katarak=$JsonData["katarak"];
                        }
                        if(empty($JsonData["tujuanKunj"])){
                            $tujuanKunj='<span class="text-danger">Tidak Ada</span>';
                            $kodetujuanKunj='<span class="text-danger">0</span>';
                            $namatujuanKunj='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $tujuanKunj=$JsonData["tujuanKunj"];
                            if(empty($tujuanKunj["tujuanKunj"])){
                                $kodetujuanKunj='<span class="text-danger">0</span>';
                            }else{
                                $kodetujuanKunj=$tujuanKunj["kode"];
                            }
                            if(empty($tujuanKunj["nama"])){
                                $namatujuanKunj='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $namatujuanKunj=$tujuanKunj["nama"];
                            }
                        }
                        if(empty($JsonData["flagProcedure"])){
                            $flagProcedure='<span class="text-danger">Tidak Ada</span>';
                            $KodeflagProcedure='<span class="text-danger">Prosedur tidak berkelanjutan</span>';
                            $NamaflagProcedure='<span class="text-danger">Prosedur tidak berkelanjutan</span>';
                        }else{
                            if(empty($JsonData["flagProcedure"]["kode"])){
                                $KodeflagProcedure='<span class="text-danger">Prosedur tidak berkelanjutan</span>';
                            }else{
                                $KodeflagProcedure=$JsonData["flagProcedure"]["kode"];
                            }
                            if(empty($JsonData["flagProcedure"]["nama"])){
                                $NamaflagProcedure='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $NamaflagProcedure=$JsonData["flagProcedure"]["nama"];
                            }
                        }
                        if(empty($JsonData["kdPenunjang"])){
                            $kdPenunjang='<span class="text-danger">Tidak Ada</span>';
                            $namakdPenunjang='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            if(empty($JsonData["kdPenunjang"]["kode"])){
                                $kdPenunjang='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $kdPenunjang=$JsonData["kdPenunjang"]["kode"];
                            }
                            if(empty($JsonData["kdPenunjang"]["nama"])){
                                $namakdPenunjang='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $namakdPenunjang=$JsonData["kdPenunjang"]["nama"];
                            }
                        }
                        if(empty($JsonData["assestmenPel"])){
                            $assestmenPel='<span class="text-danger">Tidak Ada</span>';
                            $kodeassestmenPel='<span class="text-danger">Tidak Ada</span>';
                            $namaassestmenPel='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            if(empty($JsonData["assestmenPel"]["kode"])){
                                $kodeassestmenPel='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $kodeassestmenPel=$JsonData["assestmenPel"]["kode"];
                            }
                            if(empty($JsonData["assestmenPel"]["nama"])){
                                $namaassestmenPel='<span class="text-danger">Tidak Ada</span>';
                            }else{
                                $namaassestmenPel=$JsonData["assestmenPel"]["nama"];
                            }
                        }
                        if(empty($JsonData["eSEP"])){
                            $eSEP='<span class="text-danger">Tidak Ada</span>';
                        }else{
                            $eSEP=$JsonData["eSEP"];
                        }
                        echo '<div class="row mb-4">';
                        echo '  <div class="col-md-12 sub-title">';
                        echo '      <dt>A. Koneksi Kunjungan</dt>';
                        echo '      <ol>';
                        echo '          <li class="mb-2">No.SEP : <code class="text-secondary">'.$noSep.'</code></li>';
                        echo '          <li class="mb-2">ID.Kunjungan : <code class="text-secondary">'.$id_kunjungan.'</code></li>';
                        echo '      </ol>';
                        echo '  </div>';
                        echo '</div>';
                        echo '<div class="row mb-4">';
                        echo '  <div class="col-md-12 sub-title">';
                        echo '      <dt>B. Detail SEP</dt>';
                        echo '      <ol>';
                        echo '          <li class="mb-2">No.SEP : <code class="text-secondary">'.$noSep.'</code></li>';
                        echo '          <li class="mb-2">Tgl.SEP : <code class="text-secondary">'.$tglSep.'</code></li>';
                        echo '          <li class="mb-2">Jenis Pelayanan : <code class="text-secondary">'.$jnsPelayanan.'</code></li>';
                        echo '          <li class="mb-2">Diagnosa : <code class="text-secondary">'.$diagnosa.'</code></li>';
                        echo '          <li class="mb-2">No.Rujukan : <code class="text-secondary">'.$noRujukan.'</code></li>';
                        echo '          <li class="mb-2">Poliklinik : <code class="text-secondary">'.$poli.'</code></li>';
                        echo '          <li class="mb-2">Poli Eksekutif : <code class="text-secondary">'.$poliEksekutif.'</code></li>';
                        echo '          <li class="mb-2">Catatan : <code class="text-secondary">'.$catatan.'</code></li>';
                        echo '          <li class="mb-2">Penjamin : <code class="text-secondary">'.$penjamin.'</code></li>';
                        echo '          <li class="mb-2">Kode Status Kecelakaan : <code class="text-secondary">'.$kdStatusKecelakaan.'</code></li>';
                        echo '          <li class="mb-2">Nama Status Kecelakaan : <code class="text-secondary">'.$nmstatusKecelakaan.'</code></li>';
                                        if(!empty($JsonData["lokasiKejadian"])){
                                            echo '<li class="mb-2">';
                                            echo '  Lokasi Kejadian';
                                            echo '  <ul>';
                                            echo '      <li>- Kabupaten/Kota : <code class="text-secondary">'.$kdKab.'</code></li>';
                                            echo '      <li>- Kecamatan : <code class="text-secondary">'.$kdKec.'</code></li>';
                                            echo '      <li>- Provinsi : <code class="text-secondary">'.$kdProp.'</code></li>';
                                            echo '      <li>- Keterangan Kejadian : <code class="text-secondary">'.$ketKejadian.'</code></li>';
                                            echo '      <li>- Lokasi : <code class="text-secondary">'.$lokasi.'</code></li>';
                                            echo '      <li>- Tanggal Kejadian : <code class="text-secondary">'.$tglKejadian.'</code></li>';
                                            echo '  </ul>';
                                            echo '</li>';
                                        }
                                        if(!empty($JsonData["dpjp"])){
                                            echo '<li class="mb-2">';
                                            echo '  Dokter DPJP';
                                            echo '  <ul>';
                                            echo '      <li>- Kode DPJP : <code class="text-secondary">'.$kdDPJP.'</code></li>';
                                            echo '      <li>- Nama DPJP : <code class="text-secondary">'.$nmDPJP.'</code></li>';
                                            echo '  </ul>';
                                            echo '</li>';
                                        }
                                        if(!empty($JsonData["klsRawat"])){
                                            echo '<li class="mb-2">';
                                            echo '  Kelas Rawat';
                                            echo '  <ul>';
                                            echo '      <li>- Kelas Rawat : <code class="text-secondary">'.$kelasRawat.'</code></li>';
                                            echo '      <li>- Hak Kelas : <code class="text-secondary">'.$klsRawatHak.'</code></li>';
                                            echo '      <li>- Kelas Naik : <code class="text-secondary">'.$klsRawatNaik.'</code></li>';
                                            echo '      <li>- Pembiaya : <code class="text-secondary">'.$pembiayaan.'</code></li>';
                                            echo '      <li>- Penanggung Jawab : <code class="text-secondary">'.$penanggungJawab.'</code></li>';
                                            echo '  </ul>';
                                            echo '</li>';
                                        }
                                        if(!empty($JsonData["peserta"])){
                                            echo '<li class="mb-2">';
                                            echo '  Identitas Peserta';
                                            echo '  <ul>';
                                            echo '      <li>- Nama : <code class="text-secondary">'.$nama.'</code></li>';
                                            echo '      <li>- No.Kartu : <code class="text-secondary">'.$noKartu.'</code></li>';
                                            echo '      <li>- No.RM : <code class="text-secondary">'.$noMr.'</code></li>';
                                            echo '      <li>- Tgl.Lahir : <code class="text-secondary">'.$tglLahir.'</code></li>';
                                            echo '      <li>- Gender : <code class="text-secondary">'.$kelamin.'</code></li>';
                                            echo '      <li>- Jenis Peserta : <code class="text-secondary">'.$jnsPeserta.'</code></li>';
                                            echo '      <li>- Hak Kelas : <code class="text-secondary">'.$hakKelas.'</code></li>';
                                            echo '      <li>- Asuransi : <code class="text-secondary">'.$asuransi.'</code></li>';
                                            echo '  </ul>';
                                            echo '</li>';
                                        }
                                        if(!empty($JsonData["kontrol"])){
                                            echo '<li class="mb-2">';
                                            echo '  Kontrol';
                                            echo '  <ul>';
                                            echo '      <li>- Kode Dokter : <code class="text-secondary">'.$kdDokter.'</code></li>';
                                            echo '      <li>- Nama Dokter : <code class="text-secondary">'.$nmDokter.'</code></li>';
                                            echo '      <li>- Nomor Surat : <code class="text-secondary">'.$noSurat.'</code></li>';
                                            echo '  </ul>';
                                            echo '</li>';
                                        }
                        echo '          <li class="mb-2">COB : <code class="text-secondary">'.$cob.'</code></li>';
                        echo '          <li class="mb-2">Katarak : <code class="text-secondary">'.$katarak.'</code></li>';
                                        if(!empty($JsonData["tujuanKunj"])){
                                            echo '<li class="mb-2">';
                                            echo '  Tujuan Kunjungan';
                                            echo '  <ul>';
                                            echo '      <li>- Kode : <code class="text-secondary">'.$kodetujuanKunj.'</code></li>';
                                            echo '      <li>- Nama : <code class="text-secondary">'.$namatujuanKunj.'</code></li>';
                                            echo '  </ul>';
                                            echo '</li>';
                                        }
                                        if(!empty($JsonData["flagProcedure"])){
                                            echo '<li class="mb-2">';
                                            echo '  Flag Procedure';
                                            echo '  <ul>';
                                            echo '      <li>- Kode : <code class="text-secondary">'.$KodeflagProcedure.'</code></li>';
                                            echo '      <li>- Nama : <code class="text-secondary">'.$NamaflagProcedure.'</code></li>';
                                            echo '  </ul>';
                                            echo '</li>';
                                        }
                                        if(!empty($JsonData["kdPenunjang"])){
                                            echo '<li class="mb-2">';
                                            echo '  Penunjang';
                                            echo '  <ul>';
                                            echo '      <li>- Kode : <code class="text-secondary">'.$kdPenunjang.'</code></li>';
                                            echo '      <li>- Nama : <code class="text-secondary">'.$namakdPenunjang.'</code></li>';
                                            echo '  </ul>';
                                            echo '</li>';
                                        }
                                        if(!empty($JsonData["assestmenPel"])){
                                            echo '<li class="mb-2">';
                                            echo '  Assesment';
                                            echo '  <ul>';
                                            echo '      <li>- Kode : <code class="text-secondary">'.$kodeassestmenPel.'</code></li>';
                                            echo '      <li>- Nama : <code class="text-secondary">'.$namaassestmenPel.'</code></li>';
                                            echo '  </ul>';
                                            echo '</li>';
                                        }
                        echo '          <li class="mb-2">eSEP : <code class="text-secondary">'.$eSEP.'</code></li>';
                        echo '      </ol>';
                        echo '  </div>';
                        echo '</div>';
                        echo '<div class="row mb-3">';
                        echo '  <div class="col-md-12">';
                        echo '      <a href="index.php?Page=sep&Sub=DetailSep&sep='.$sep.'" class="btn btn-sm btn-block btn-outline-dark btn-round">';
                        echo '          Detail SEP <i class="ti ti-layers-alt"></i>';
                        echo '      </a>';
                        echo '  </div>';
                        echo '</div>';
                    }
                }
            }
        }
    }
?>