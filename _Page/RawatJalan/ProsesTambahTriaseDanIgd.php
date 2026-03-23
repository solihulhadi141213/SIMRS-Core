<?php
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi id_kunjungan tidak boleh kosong
    if(empty($_POST['id_kunjungan'])){
        echo '<small class="text-danger">ID Kunjungan tidak boleh kosong</small>';
    }else{
        //Validasi id_pasien tidak boleh kosong
        if(empty($_POST['id_pasien'])){
            echo '<small class="text-danger">No.RM tidak boleh kosong</small>';
        }else{
            //Validasi nama_pasien tidak boleh kosong
            if(empty($_POST['nama_pasien'])){
                echo '<small class="text-danger">Nama pasien tidak boleh kosong</small>';
            }else{
                //Validasi tanggal_catat tidak boleh kosong
                if(empty($_POST['tanggal_catat'])){
                    echo '<small class="text-danger">Tanggal Pencatatan tidak boleh kosong</small>';
                }else{
                    //Validasi jam_catat tidak boleh kosong
                    if(empty($_POST['jam_catat'])){
                        echo '<small class="text-danger">Jam Pencatatan tidak boleh kosong</small>';
                    }else{
                        //Validasi tanggal_masuk tidak boleh kosong
                        if(empty($_POST['tanggal_masuk'])){
                            echo '<small class="text-danger">Tanggal masuk/kedatangan pasien tidak boleh kosong</small>';
                        }else{
                            //Validasi jam_masuk tidak boleh kosong
                            if(empty($_POST['jam_masuk'])){
                                echo '<small class="text-danger">Jam masuk/kedatangan pasien tidak boleh kosong</small>';
                            }else{
                                //Validasi sarana_transportasi tidak boleh kosong
                                if(empty($_POST['sarana_transportasi'])){
                                    echo '<small class="text-danger">Sarana transportasi tidak boleh kosong</small>';
                                }else{
                                    //Validasi kategori_kondisi_pasien tidak boleh kosong
                                    if(empty($_POST['kategori_kondisi_pasien'])){
                                        echo '<small class="text-danger">Kondisi pasien tiba tidak boleh kosong</small>';
                                    }else{
                                         //Validasi asesmen_nyeri tidak boleh kosong
                                        if(empty($_POST['asesmen_nyeri'])){
                                            echo '<small class="text-danger">Informasi Assesmen Nyeri tidak boleh kosong</small>';
                                        }else{
                                            //Membuat variabel wajib
                                            $id_kunjungan=$_POST['id_kunjungan'];
                                            $id_pasien=$_POST['id_pasien'];
                                            $nama_pasien=$_POST['nama_pasien'];
                                            $tanggal_catat=$_POST['tanggal_catat'];
                                            $jam_catat=$_POST['jam_catat'];
                                            $TanggalJamCatat="$tanggal_catat $jam_catat";
                                            $tanggal_masuk=$_POST['tanggal_masuk'];
                                            $jam_masuk=$_POST['jam_masuk'];
                                            $TanggalJamMasuk="$tanggal_masuk $jam_masuk";
                                            $kategori_kondisi_pasien=$_POST['kategori_kondisi_pasien'];
                                            $asesmen_nyeri=$_POST['asesmen_nyeri'];
                                            //Variabel yang tidak wajib
                                            if(empty($_POST['nama_pengantar_pasien'])){
                                                $nama_pengantar_pasien="";
                                            }else{
                                                $nama_pengantar_pasien=$_POST['nama_pengantar_pasien'];
                                            }
                                            if(empty($_POST['kontak_pengantar_pasien'])){
                                                $kontak_pengantar_pasien="";
                                            }else{
                                                $kontak_pengantar_pasien=$_POST['kontak_pengantar_pasien'];
                                            }
                                            if(empty($_POST['penjelasan_kondisi_pasien'])){
                                                $penjelasan_kondisi_pasien="";
                                            }else{
                                                $penjelasan_kondisi_pasien=$_POST['penjelasan_kondisi_pasien'];
                                            }
                                            //Asesmen Nyeri
                                            if(empty($_POST['lokasi_nyeri'])){
                                                $lokasi_nyeri="";
                                            }else{
                                                $lokasi_nyeri=$_POST['lokasi_nyeri'];
                                            }
                                            if(empty($_POST['penyebab_nyeri'])){
                                                $penyebab_nyeri="";
                                            }else{
                                                $penyebab_nyeri=$_POST['penyebab_nyeri'];
                                            }
                                            if(empty($_POST['durasi_nyeri'])){
                                                $durasi_nyeri="";
                                            }else{
                                                $durasi_nyeri=$_POST['durasi_nyeri'];
                                            }
                                            if(empty($_POST['frekuensi_nyeri'])){
                                                $frekuensi_nyeri="";
                                            }else{
                                                $frekuensi_nyeri=$_POST['frekuensi_nyeri'];
                                            }
                                            if(empty($_POST['skala_vas'])){
                                                $skala_vas="0";
                                            }else{
                                                $skala_vas=$_POST['skala_vas'];
                                            }
                                            if(empty($_POST['skala_nrs'])){
                                                $skala_nrs="0";
                                            }else{
                                                $skala_nrs=$_POST['skala_nrs'];
                                            }
                                            if(empty($_POST['skala_vrs'])){
                                                $skala_vrs="0";
                                            }else{
                                                $skala_vrs=$_POST['skala_vrs'];
                                            }
                                            if(empty($_POST['skala_wbps'])){
                                                $skala_wbps="0";
                                            }else{
                                                $skala_wbps=$_POST['skala_wbps'];
                                            }
                                            if(empty($_POST['skala_nips1'])){
                                                $skala_nips1="0";
                                            }else{
                                                $skala_nips1=$_POST['skala_nips1'];
                                            }
                                            if(empty($_POST['skala_nips2'])){
                                                $skala_nips2="0";
                                            }else{
                                                $skala_nips2=$_POST['skala_nips1'];
                                            }
                                            if(empty($_POST['skala_nips3'])){
                                                $skala_nips3="0";
                                            }else{
                                                $skala_nips3=$_POST['skala_nips3'];
                                            }
                                            if(empty($_POST['skala_nips4'])){
                                                $skala_nips4="0";
                                            }else{
                                                $skala_nips4=$_POST['skala_nips4'];
                                            }
                                            if(empty($_POST['skala_nips5'])){
                                                $skala_nips5="0";
                                            }else{
                                                $skala_nips5=$_POST['skala_nips5'];
                                            }
                                            if(empty($_POST['skala_nips6'])){
                                                $skala_nips6="0";
                                            }else{
                                                $skala_nips6=$_POST['skala_nips6'];
                                            }
                                            if(empty($_POST['nakes_nyeri'])){
                                                $nakes_nyeri="";
                                            }else{
                                                $nakes_nyeri=$_POST['nakes_nyeri'];
                                            }
                                            //Kajian Resiko Jatuh
                                            //mfs
                                            if(empty($_POST['resikoi_jatuh_mfs1'])){
                                                $resikoi_jatuh_mfs1=0;
                                            }else{
                                                $resikoi_jatuh_mfs1=$_POST['resikoi_jatuh_mfs1'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_mfs2'])){
                                                $resikoi_jatuh_mfs2=0;
                                            }else{
                                                $resikoi_jatuh_mfs2=$_POST['resikoi_jatuh_mfs2'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_mfs3'])){
                                                $resikoi_jatuh_mfs3=0;
                                            }else{
                                                $resikoi_jatuh_mfs3=$_POST['resikoi_jatuh_mfs3'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_mfs4'])){
                                                $resikoi_jatuh_mfs4=0;
                                            }else{
                                                $resikoi_jatuh_mfs4=$_POST['resikoi_jatuh_mfs4'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_mfs5'])){
                                                $resikoi_jatuh_mfs5=0;
                                            }else{
                                                $resikoi_jatuh_mfs5=$_POST['resikoi_jatuh_mfs5'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_mfs6'])){
                                                $resikoi_jatuh_mfs6=0;
                                            }else{
                                                $resikoi_jatuh_mfs6=$_POST['resikoi_jatuh_mfs6'];
                                            }
                                            //HDS
                                            if(empty($_POST['resikoi_jatuh_hds1'])){
                                                $resikoi_jatuh_hds1=0;
                                            }else{
                                                $resikoi_jatuh_hds1=$_POST['resikoi_jatuh_hds1'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_hds2'])){
                                                $resikoi_jatuh_hds2=0;
                                            }else{
                                                $resikoi_jatuh_hds2=$_POST['resikoi_jatuh_hds2'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_hds3'])){
                                                $resikoi_jatuh_hds3=0;
                                            }else{
                                                $resikoi_jatuh_hds3=$_POST['resikoi_jatuh_hds3'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_hds4'])){
                                                $resikoi_jatuh_hds4=0;
                                            }else{
                                                $resikoi_jatuh_hds4=$_POST['resikoi_jatuh_hds4'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_hds5'])){
                                                $resikoi_jatuh_hds5=0;
                                            }else{
                                                $resikoi_jatuh_hds5=$_POST['resikoi_jatuh_hds5'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_hds6'])){
                                                $resikoi_jatuh_hds6=0;
                                            }else{
                                                $resikoi_jatuh_hds6=$_POST['resikoi_jatuh_hds6'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_hds7'])){
                                                $resikoi_jatuh_hds7=0;
                                            }else{
                                                $resikoi_jatuh_hds7=$_POST['resikoi_jatuh_hds7'];
                                            }
                                            //EPFRA
                                            if(empty($_POST['resikoi_jatuh_epfra1'])){
                                                $resikoi_jatuh_epfra1=0;
                                            }else{
                                                $resikoi_jatuh_epfra1=$_POST['resikoi_jatuh_epfra1'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_epfra2'])){
                                                $resikoi_jatuh_epfra2=0;
                                            }else{
                                                $resikoi_jatuh_epfra2=$_POST['resikoi_jatuh_epfra2'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_epfra3'])){
                                                $resikoi_jatuh_epfra3=0;
                                            }else{
                                                $resikoi_jatuh_epfra3=$_POST['resikoi_jatuh_epfra3'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_epfra4'])){
                                                $resikoi_jatuh_epfra4=0;
                                            }else{
                                                $resikoi_jatuh_epfra4=$_POST['resikoi_jatuh_epfra4'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_epfra5'])){
                                                $resikoi_jatuh_epfra5=0;
                                            }else{
                                                $resikoi_jatuh_epfra5=$_POST['resikoi_jatuh_epfra5'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_epfra6'])){
                                                $resikoi_jatuh_epfra6=0;
                                            }else{
                                                $resikoi_jatuh_epfra6=$_POST['resikoi_jatuh_epfra6'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_epfra7'])){
                                                $resikoi_jatuh_epfra7=0;
                                            }else{
                                                $resikoi_jatuh_epfra7=$_POST['resikoi_jatuh_epfra7'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_epfra8'])){
                                                $resikoi_jatuh_epfra8=0;
                                            }else{
                                                $resikoi_jatuh_epfra8=$_POST['resikoi_jatuh_epfra8'];
                                            }
                                            if(empty($_POST['resikoi_jatuh_epfra9'])){
                                                $resikoi_jatuh_epfra9=0;
                                            }else{
                                                $resikoi_jatuh_epfra9=$_POST['resikoi_jatuh_epfra9'];
                                            }
                                            //Pemeriksa Jatuh
                                            if(empty($_POST['nakes_resiko_jatuh'])){
                                                $nakes_resiko_jatuh="";
                                            }else{
                                                $nakes_resiko_jatuh=$_POST['nakes_resiko_jatuh'];
                                            }
                                            //Kesadaran
                                            if(empty($_POST['kesadaran_pasien'])){
                                                $kesadaran_pasien="";
                                            }else{
                                                $kesadaran_pasien=$_POST['kesadaran_pasien'];
                                            }
                                            //Validasi sarana_transportasi tidak boleh kosong
                                            if(empty($_POST['sarana_transportasi'])){
                                                $validasisarana_transportasi="Informasi Sarana transportasi tidak boleh kosong!";
                                            }else{
                                                //Validasi sarana_transportasi tidak boleh kosong
                                                if($_POST['sarana_transportasi']=="Lainnya"){
                                                    if(empty($_POST['keterangan_sarana_transportasi'])){
                                                        $validasisarana_transportasi="Keterangan sarana transportasi lainnya tidak boleh kosong!";
                                                    }else{
                                                        $validasisarana_transportasi="Valid";
                                                        $sarana_transportasi=$_POST['sarana_transportasi'];
                                                        $keterangan_sarana_transportasi=$_POST['keterangan_sarana_transportasi'];
                                                    }
                                                }else{
                                                    $validasisarana_transportasi="Valid";
                                                    $sarana_transportasi=$_POST['sarana_transportasi'];
                                                    $keterangan_sarana_transportasi="";
                                                }
                                                if($validasisarana_transportasi!=="Valid"){
                                                    echo '<small class="text-danger">'.$validasisarana_transportasi.'</small>';
                                                }else{
                                                    //Validasi surat_rujukan tidak boleh kosong
                                                    if(empty($_POST['surat_rujukan'])){
                                                        echo '<small class="text-danger">Keterangan Adanya Surat Rujukan Tidak Boleh Kosong!</small>';
                                                    }else{
                                                        if($_POST['surat_rujukan']=="Ada"){
                                                            if(empty($_POST['asal_rujukan'])){
                                                                $ValidasiSuratRujukan="Informasi asal rujukan tidak boleh kosong tidak boleh kosong!";
                                                            }else{
                                                                if(empty($_POST['no_surat_rujukan'])){
                                                                    $ValidasiSuratRujukan="Nomor Surat rujukan tidak boleh kosong tidak boleh kosong!";
                                                                }else{
                                                                    $ValidasiSuratRujukan="Valid";
                                                                    $surat_rujukan=$_POST['surat_rujukan'];
                                                                    $no_surat_rujukan=$_POST['no_surat_rujukan'];
                                                                    $asal_rujukan=$_POST['asal_rujukan'];
                                                                }
                                                            }
                                                        }else{
                                                            $ValidasiSuratRujukan="Valid";
                                                            $surat_rujukan=$_POST['surat_rujukan'];
                                                            $no_surat_rujukan="";
                                                            $asal_rujukan="";
                                                        }
                                                    }
                                                }
                                                if($ValidasiSuratRujukan!=="Valid"){
                                                    echo '<small class="text-danger">'.$ValidasiSuratRujukan.'</small>';
                                                }else{
                                                    //Json Sarana Transportasi
                                                    $sarana_transportasi=Array (
                                                        "kategori" => "$sarana_transportasi",
                                                        "keterangan" => "$keterangan_sarana_transportasi"
                                                    );
                                                    //Json Surat Pengantar Rujukan
                                                    $surat_pengantar_rujukan=Array (
                                                        "surat_rujukan" => "$surat_rujukan",
                                                        "no_surat_rujukan" => "$no_surat_rujukan",
                                                        "asal_rujukan" => "$asal_rujukan"
                                                    );
                                                    //Json Kondisi Pasien Saat Tiba
                                                    $kondisi_pasien_tiba=Array (
                                                        "kategori_kondisi_pasien" => "$kategori_kondisi_pasien",
                                                        "penjelasan_kondisi_pasien" => "$penjelasan_kondisi_pasien"
                                                    );
                                                    //Json Pengantar Pasien
                                                    $pengantar_pasien=Array (
                                                        "nama_pengantar_pasien" => "$nama_pengantar_pasien",
                                                        "kontak_pengantar_pasien" => "$kontak_pengantar_pasien"
                                                    );
                                                    //Json Asesmen Nyeri
                                                    if($skala_vas==0){
                                                        $kategori_vas="No Pain";
                                                    }else{
                                                        if($skala_vas<=5){
                                                            $kategori_vas="Moderate Pain";
                                                        }else{
                                                            $kategori_vas="Worst Possible Pain";
                                                        }
                                                    }
                                                    if($skala_nrs==0){
                                                        $kategori_nrs="No Pain";
                                                    }else{
                                                        if($skala_vas<=3){
                                                            $kategori_nrs="Mild Pain";
                                                        }else{
                                                            if($skala_vas<=6){
                                                                $kategori_nrs="Moderate Pain";
                                                            }else{
                                                                $kategori_nrs="Severe Pain";
                                                            }
                                                        }
                                                    }
                                                    if($skala_vrs==0){
                                                        $kategori_vrs="No Pain";
                                                    }else{
                                                        if($skala_vas<=2){
                                                            $kategori_vrs="Mild Pain";
                                                        }else{
                                                            if($skala_vas<=4){
                                                                $kategori_vrs="Moderate Pain";
                                                            }else{
                                                                if($skala_vas<=6){
                                                                    $kategori_vrs="Severe Pain";
                                                                }else{
                                                                    if($skala_vas<=8){
                                                                        $kategori_vrs="Very Severe Pain";
                                                                    }else{
                                                                        $kategori_vrs="Worst Possible Pain";
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                    if($skala_wbps==0){
                                                        $kategori_wbps="Tidak Sakit";
                                                    }else{
                                                        if($skala_wbps==2){
                                                            $kategori_wbps="Sedikit Sakit";
                                                        }else{
                                                            if($skala_wbps==4){
                                                                $kategori_wbps="Agak Mengganggu";
                                                            }else{
                                                                if($skala_wbps==6){
                                                                    $kategori_wbps="Mengganggu Aktivitas";
                                                                }else{
                                                                    if($skala_wbps==8){
                                                                        $kategori_wbps="Sangat Mengganggu";
                                                                    }else{
                                                                        $kategori_wbps="Tidak Tertahankan";
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                    $JumlahSkalaNips=$skala_nips1+$skala_nips2+$skala_nips3+$skala_nips4+$skala_nips5+$skala_nips6;
                                                    if($JumlahSkalaNips<=2){
                                                        $kategori_nips="mild to no pain";
                                                    }else{
                                                        if($JumlahSkalaNips<=4){
                                                            $kategori_nips="Mild Pain";
                                                        }else{
                                                            if($JumlahSkalaNips<=6){
                                                                $kategori_nips="mild to noderate pain";
                                                            }else{
                                                                $kategori_nips="Severe Pain";
                                                            }
                                                        }
                                                    }
                                                    $JumlahMfs=$resikoi_jatuh_mfs1+$resikoi_jatuh_mfs2+$resikoi_jatuh_mfs3+$resikoi_jatuh_mfs4+$resikoi_jatuh_mfs5+$resikoi_jatuh_mfs6;
                                                    if($JumlahMfs<=24){
                                                        $KategoriMfs="Resiko Rendah";
                                                    }else{
                                                        if($JumlahMfs<=44){
                                                            $KategoriMfs="Resiko Sedang";
                                                        }else{
                                                            if($JumlahMfs>=45){
                                                                $KategoriMfs="Resiko Tinggi";
                                                            }else{
                                                                $KategoriMfs="Tidak Diketahui";
                                                            }
                                                        }
                                                    }
                                                    $JumlahHds=$resikoi_jatuh_hds1+$resikoi_jatuh_hds2+$resikoi_jatuh_hds3+$resikoi_jatuh_hds4+$resikoi_jatuh_hds5+$resikoi_jatuh_hds6+$resikoi_jatuh_hds7;
                                                    if($JumlahHds<=11){
                                                        $KategoriHds="Resiko Rendah";
                                                    }else{
                                                        $KategoriHds="Resiko Tinggi";
                                                    }
                                                    $JumlahEpfra=$resikoi_jatuh_epfra1+$resikoi_jatuh_epfra2+$resikoi_jatuh_epfra3+$resikoi_jatuh_epfra4+$resikoi_jatuh_epfra5+$resikoi_jatuh_epfra6+$resikoi_jatuh_epfra7+$resikoi_jatuh_epfra8+$resikoi_jatuh_epfra9;
                                                    if($JumlahEpfra<=89){
                                                        $KategoriEpfra="Resiko Rendah";
                                                    }else{
                                                        $KategoriEpfra="Resiko Tinggi";
                                                    }
                                                    //Buatkan Array
                                                    $skala_vas=Array (
                                                        "skor" => "$skala_vas",
                                                        "kategori" => "$kategori_vas"
                                                    );
                                                    $skala_nrs=Array (
                                                        "skor" => "$skala_nrs",
                                                        "kategori" => "$kategori_nrs"
                                                    );
                                                    $skala_vrs=Array (
                                                        "skor" => "$skala_vrs",
                                                        "kategori" => "$kategori_vrs"
                                                    );
                                                    $skala_wbps=Array (
                                                        "skor" => "$skala_wbps",
                                                        "kategori" => "$kategori_wbps"
                                                    );
                                                    $skala_nips=Array (
                                                        "skala_nips1" => "$skala_nips1",
                                                        "skala_nips2" => "$skala_nips2",
                                                        "skala_nips3" => "$skala_nips3",
                                                        "skala_nips4" => "$skala_nips4",
                                                        "skala_nips5" => "$skala_nips5",
                                                        "skala_nips6" => "$skala_nips6",
                                                        "skor" => "$JumlahSkalaNips",
                                                        "kategori" => "$kategori_nips"
                                                    );
                                                    $asesmen_nyeri=Array (
                                                        "asesmen_nyeri" => "$asesmen_nyeri",
                                                        "lokasi_nyeri" => "$lokasi_nyeri",
                                                        "penyebab_nyeri" => "$penyebab_nyeri",
                                                        "durasi_nyeri" => "$durasi_nyeri",
                                                        "frekuensi_nyeri" => "$frekuensi_nyeri",
                                                        "skala_vas" => $skala_vas,
                                                        "skala_nrs" => $skala_nrs,
                                                        "skala_vrs" => $skala_vrs,
                                                        "skala_nips" => $skala_nips,
                                                        "skala_wbps" => $skala_wbps,
                                                        "nakes_nyeri" => $nakes_nyeri
                                                    );
                                                    $mfs=Array (
                                                        "mfs1" => "$resikoi_jatuh_mfs1",
                                                        "mfs2" => "$resikoi_jatuh_mfs2",
                                                        "mfs3" => "$resikoi_jatuh_mfs3",
                                                        "mfs4" => "$resikoi_jatuh_mfs4",
                                                        "mfs5" => "$resikoi_jatuh_mfs5",
                                                        "mfs6" => "$resikoi_jatuh_mfs6",
                                                        "skor" => "$JumlahMfs",
                                                        "kategori" => "$KategoriMfs"
                                                    );
                                                    $hds=Array (
                                                        "hds1" => "$resikoi_jatuh_hds1",
                                                        "hds2" => "$resikoi_jatuh_hds2",
                                                        "hds3" => "$resikoi_jatuh_hds3",
                                                        "hds4" => "$resikoi_jatuh_hds4",
                                                        "hds5" => "$resikoi_jatuh_hds5",
                                                        "hds6" => "$resikoi_jatuh_hds6",
                                                        "hds7" => "$resikoi_jatuh_hds7",
                                                        "skor" => "$JumlahHds",
                                                        "kategori" => "$KategoriHds"
                                                    );
                                                    $epfra=Array (
                                                        "epfra1" => "$resikoi_jatuh_epfra1",
                                                        "epfra2" => "$resikoi_jatuh_epfra2",
                                                        "epfra3" => "$resikoi_jatuh_epfra3",
                                                        "epfra4" => "$resikoi_jatuh_epfra4",
                                                        "epfra5" => "$resikoi_jatuh_epfra5",
                                                        "epfra6" => "$resikoi_jatuh_epfra6",
                                                        "epfra7" => "$resikoi_jatuh_epfra7",
                                                        "epfra8" => "$resikoi_jatuh_epfra8",
                                                        "epfra9" => "$resikoi_jatuh_epfra9",
                                                        "skor" => "$JumlahEpfra",
                                                        "kategori" => "$KategoriEpfra"
                                                    );
                                                    $kajian_resiko_jatuh=Array (
                                                        "mfs" => $mfs,
                                                        "hds" => $hds,
                                                        "epfra" => $epfra,
                                                        "pemeriksa" => $nakes_resiko_jatuh
                                                    );
                                                    //JSON Triase IGD
                                                    $triase_igd=Array (
                                                        "sarana_transportasi" => $sarana_transportasi,
                                                        "surat_pengantar_rujukan" => $surat_pengantar_rujukan,
                                                        "kondisi_pasien_tiba" => $kondisi_pasien_tiba,
                                                        "pengantar_pasien" => $pengantar_pasien,
                                                        "asesmen_nyeri" => $asesmen_nyeri,
                                                        "kajian_resiko_jatuh" => $kajian_resiko_jatuh,
                                                        "kesadaran_pasien" => $kesadaran_pasien,
                                                    );
                                                    $JsonTreaseIgd= json_encode($triase_igd);
                                                    //Menyimpan Kedalam Database
                                                    $entry="INSERT INTO triase_igd (
                                                        id_pasien,
                                                        id_kunjungan,
                                                        id_akses,
                                                        tanggal,
                                                        nama_pasien,
                                                        nama_petugas,
                                                        tanggal_jam_masuk,
                                                        triase_igd
                                                    ) VALUES (
                                                        '$id_pasien',
                                                        '$id_kunjungan',
                                                        '$SessionIdAkses',
                                                        '$TanggalJamCatat',
                                                        '$nama_pasien',
                                                        '$SessionNama',
                                                        '$TanggalJamMasuk',
                                                        '$JsonTreaseIgd'
                                                    )";
                                                    $hasil=mysqli_query($Conn, $entry);
                                                    if($hasil){
                                                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Trease Dan Igd","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                        if($MenyimpanLog=="Berhasil"){
                                                            echo '<span class="text-success" id="NotifikasiTambahTriaseDanIgdBerhasil">Success</span>';
                                                        }else{
                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                        }
                                                    }else{
                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Trease Igd</span>';
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
            }
        }
    }
?>
