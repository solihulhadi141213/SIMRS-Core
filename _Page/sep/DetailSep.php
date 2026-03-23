<?php
    include "_Config/SettingBridging.php";
    include "_Config/SimrsFunction.php"; 
    include "vendor/autoload.php";
    if(empty($_SESSION['UrlBackDetailSep'])){
        $UrlBack='index.php?Page=sep';
    }else{
        $UrlBack=$_SESSION['UrlBackDetailSep'];
    }
    //Tangkap sep
    if(empty($_GET['sep'])){
        echo '<span class="text-danger">Nomor SEP Tidak Boleh Kosong</span>';
    }else{
        $no_sep=$_GET['sep'];
        
?>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <h4>
                                            <i class="ti ti-info-alt"></i> Detail SEP
                                        </h4>
                                    </div>
                                    <div class="col-md-12 mb-2 text-center">
                                        <input type="hidden" id="GetUrlBackDetailSep" value="<?php echo $UrlBack;?>">
                                        <div class="icon-btn">
                                            <a href="<?php echo $UrlBack;?>" class="btn btn-icon btn-outline-secondary" title="Kembali Ke Halaman Sebelumnya">
                                                <i class="icofont-rounded-double-left"></i>
                                            </a>
                                            <a href="" class="btn btn-icon btn-outline-secondary" title="Reload Halaman Kunjungan Ini">
                                                <i class="icofont-refresh"></i>
                                            </a>
                                            <button type="button" class="btn btn-icon btn-outline-secondary" data-toggle="modal" data-target="#ModalEditSep" title="Edit SEP" data-id="<?php echo "$no_sep"; ?>">
                                                <i class="ti-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-icon btn-outline-secondary" data-toggle="modal" data-target="#ModalCetakSep" title="Cetak SEP" data-id="<?php echo "$no_sep"; ?>">
                                                <i class="ti-printer"></i>
                                            </button>
                                            <button type="button" class="btn btn-icon btn-outline-secondary" data-toggle="modal" data-target="#ModalHapusSep" title="Hapus SEP" data-id="<?php echo "$no_sep"; ?>">
                                                <i class="ti-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php
                                            $Response=DetailSep($url_vclaim,$consid,$secret_key,$user_key,$url_vclaim,$no_sep);
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
                                                                $RealTglSep="";
                                                            }else{
                                                                $RealTglSep=$JsonData["tglSep"];
                                                                $tglSep=$JsonData["tglSep"];
                                                                $strtotime=strtotime($tglSep);
                                                                $tglSep=date('d/m/Y',$strtotime);
                                                            }
                                                            if(empty($JsonData["jnsPelayanan"])){
                                                                $jnsPelayanan='<span class="text-danger">Tidak Ada</span>';
                                                                $KodeJenisPelayanan="1";
                                                            }else{
                                                                $jnsPelayanan=$JsonData["jnsPelayanan"];
                                                                if($jnsPelayanan=="Rawat Jalan"){
                                                                    $KodeJenisPelayanan="2";
                                                                }else{
                                                                    $KodeJenisPelayanan="1";
                                                                }
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
                                                                $noKartuPeserta="";
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
                                                                    $noKartuPeserta="";
                                                                }else{
                                                                    $noKartu=$peserta["noKartu"];
                                                                    $noKartuPeserta=$peserta["noKartu"];
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

                                                            //Routing Keterangan Ada Kunjungan
                                                            if(empty($id_kunjungan)){
                                                                $LabelIdKunjungan='<code class="text-danger">SEP Ini Tidak Terhubung Dengan Data Kunjungan!</code>';
                                                            }else{
                                                                $LabelIdKunjungan='<a href="javascript:void(0);" data-toggle="modal" data-target="#ModalDetailKunjungan" data-id="'.$id_kunjungan.'" title="Detail Kunjungan"><code class="text-success">'.$id_kunjungan.' <i class="ti ti-new-window"></i></code></a>';
                                                            }
                                                            echo '<div class="row mb-4">';
                                                            echo '  <div class="col-md-12 sub-title">';
                                                            echo '      <dt>A. Koneksi Kunjungan</dt>';
                                                            echo '      <ol>';
                                                            echo '          <li class="mb-2">No.SEP : <code class="text-secondary" id="GetValueSep">'.$noSep.'</code></li>';
                                                            echo '          <li class="mb-2">ID.Kunjungan : '.$LabelIdKunjungan.'</li>';
                                                                            if(!empty($id_kunjungan)){
                                                                                $IdPasienSep=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'id_pasien');
                                                                                $LabelIdPasien='<a href="javascript:void(0);" data-toggle="modal" data-target="#ModalDetailPasien" data-id="'.$IdPasienSep.'" title="Detail Pasien"><code class="text-success">'.$IdPasienSep.' <i class="ti ti-new-window"></i></code></a>';
                                                                                $NamaPasienSep=getDataDetail($Conn,'kunjungan_utama','id_kunjungan',$id_kunjungan,'nama');
                                                                                echo '<li class="mb-2">ID.Pasien/No.RM : '.$LabelIdPasien.'</li>';
                                                                                echo '<li class="mb-2">Nama Pasien : '.$NamaPasienSep.'</li>';
                                                                            }
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
                                                        }
                                                    }
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h4><i class="icofont-patient-file"></i> Informasi Lainnya</h4>
                                    </div>
                                    <div class="card-body accordion-block">
                                        <div id="accordion" role="tablist" aria-multiselectable="true">
                                            <div class="accordion-panel">
                                                <div class="accordion-heading" role="tab" id="heading1">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#MenuLembarPengajuanKlaim" aria-expanded="true" aria-controls="MenuLembarPengajuanKlaim" id="MenampilkanLembarPengajuanKlaim">
                                                            <dt>1. Lembar Pengajuan Klaim (LPK)</dt>
                                                            <input type="hidden" id="InputLembarPengajuanKlaim" value="<?php echo "$KodeJenisPelayanan,$RealTglSep,$no_sep"; ?>">
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="MenuLembarPengajuanKlaim" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
                                                <div class="accordion-content accordion-desc bg-light" id="SubPageLembarPengajuanKlaim">

                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class="accordion-heading" role="tab" id="heading1">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#MenuPotensiRujukBalik" aria-expanded="true" aria-controls="MenuPotensiRujukBalik">
                                                            <dt>2. Potensi Rujuk Balik (PRB)</dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="MenuPotensiRujukBalik" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
                                                <div class="accordion-content accordion-desc bg-light">
                                                    <p>Potensi Rujuk Balik Disini</p>
                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class="accordion-heading" role="tab" id="heading1">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#MenuRencanaKontrol" aria-expanded="true" aria-controls="MenuRencanaKontrol">
                                                            <dt>3. Rencana Kontrol</dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="MenuRencanaKontrol" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
                                                <div class="accordion-content accordion-desc bg-light">
                                                    <p>Rencana Kontrol Disini</p>
                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class="accordion-heading" role="tab" id="heading1">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#MenuRujukanKeluar" aria-expanded="true" aria-controls="MenuRujukanKeluar">
                                                            <dt>4. Rujukan Keluar</dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="MenuRujukanKeluar" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
                                                <div class="accordion-content accordion-desc bg-light">
                                                    <p>Rujukan Keluar</p>
                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class="accordion-heading" role="tab" id="heading1">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#MenuSepInternal" aria-expanded="true" aria-controls="MenuSepInternal" id="MenampilkanSepInternal">
                                                            <dt>5. SEP Internal</dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="MenuSepInternal" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
                                                <div class="accordion-content accordion-desc bg-light" id="SubPageSepInternal">
                                                    <p>Menampilkan Data SEP Internal</p>
                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class="accordion-heading" role="tab" id="heading1">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#MenuUpdateTanggalPulang" aria-expanded="true" aria-controls="MenuUpdateTanggalPulang">
                                                            <dt>6. Update Tanggal Pulang (SEP)</dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="MenuUpdateTanggalPulang" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
                                                <div class="accordion-content accordion-desc bg-light">
                                                    <p>Menampilkan Tanggal Pulang SEP</p>
                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class="accordion-heading" role="tab" id="heading1">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#MenuInacbg" aria-expanded="true" aria-controls="MenuInacbg">
                                                            <dt>7. Integrasi SEP dan Inacbg</dt>
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="MenuInacbg" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
                                                <div class="accordion-content accordion-desc bg-light">
                                                    <p>Menampilkan Integrasi SEP dan Inacbg</p>
                                                </div>
                                            </div>
                                            <div class="accordion-panel">
                                                <div class="accordion-heading" role="tab" id="heading1">
                                                    <h3 class="card-title accordion-title">
                                                        <a class="accordion-msg waves-effect waves-dark scale_active" data-toggle="collapse" data-parent="#accordion" href="#MenuFingerPrint" aria-expanded="true" aria-controls="MenuFingerPrint" id="MenampilkanFingerprint">
                                                            <dt>8. Finger Print</dt>
                                                            <input type="hidden" id="GetDataFingerprint" value="<?php echo "$RealTglSep,$noKartuPeserta"; ?>">
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div id="MenuFingerPrint" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
                                                <div class="accordion-content accordion-desc bg-light" id="SubPageFingerprint">
                                                    <p>Menampilkan Finger Print</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
        $_SESSION['UrlBackDetailSep']="";
    } 
?>