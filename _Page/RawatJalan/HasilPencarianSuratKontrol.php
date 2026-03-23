<?php
    //Koneksi
    date_default_timezone_set('UTC');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    include "../../vendor/autoload.php";
    //Menangkap parameter
    if(empty($_POST['tanggal_kontrol'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Tanggal Kontrol harus Diisi Terlebih Dulu!';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['KeywordNomorKartuCariSuratKontrol'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Nomor Kartu BPJS harus Diisi Terlebih Dulu!';
            echo '  </div>';
            echo '</div>';
        }else{
            $tanggal_kontrol=$_POST['tanggal_kontrol'];
            $NomorKartu=$_POST['KeywordNomorKartuCariSuratKontrol'];
            //Pecah Tanggal
            $strtotime=strtotime($tanggal_kontrol);
            $Bulan=date('m',$strtotime);
            $Tahun=date('Y',$strtotime);
            $Pencarian=SuratKontrolByKartu($url_vclaim,$consid,$secret_key,$user_key,$NomorKartu,$Bulan,$Tahun);
            if(empty($Pencarian)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center text-danger">';
                echo '      Tidak Ada Response Dari Service BPJS, Pastikan Anda Melakukan Pengaturan Bridging BPJS Dengan Benar!';
                echo '  </div>';
                echo '</div>';
            }else{
                $ambil_json =json_decode($Pencarian, true);
                if($ambil_json["metaData"]["code"]!=="200"){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center text-danger">';
                    echo '      '.$ambil_json["metaData"]["message"].'';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $string=$ambil_json["response"];
                    $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                    $key="$consid$secret_key$timestamp";
                    $FileDeskripsi=stringDecrypt("$key", "$string");
                    $FileDekompresi=decompress("$FileDeskripsi");
                    //--konveris json to raw
                    $JsonData =json_decode($FileDekompresi, true);
                    //Tampilkan Data 
                    if(empty($JsonData['list'])){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center text-danger">';
                        echo '      '.$FileDekompresi.'';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        $list=$JsonData['list'];
                        if(empty(count($list))){
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 text-center text-danger">';
                            echo '      List Surat Kontrol Tidak Bisa Ditampilkan';
                            echo '  </div>';
                            echo '</div>';
                        }else{
                            $no=1;
                            $Jumlah=count($JsonData['list']);
                            $list=$JsonData['list'];
                            for($a=0; $a<$Jumlah; $a++){
                                $noSuratKontrol=$list[$a]['noSuratKontrol'];
                                $jnsPelayanan=$list[$a]['jnsPelayanan'];
                                $jnsKontrol=$list[$a]['jnsKontrol'];
                                $namaJnsKontrol=$list[$a]['namaJnsKontrol'];
                                $tglRencanaKontrol=$list[$a]['tglRencanaKontrol'];
                                $tglTerbitKontrol=$list[$a]['tglTerbitKontrol'];
                                $poliTujuan=$list[$a]['poliTujuan'];
                                $namaPoliTujuan=$list[$a]['namaPoliTujuan'];
                                $kodeDokter=$list[$a]['kodeDokter'];
                                $NamaDokter=$list[$a]['namaDokter'];
?>
                                <div class="row sub-title">
                                    <div class="col-md-12">
                                        <dt>
                                            <a href="javascript:void(0);" id="GetNomorSurat<?php echo $noSuratKontrol; ?>" class="CheckSuratKontrol" value="<?php echo $noSuratKontrol; ?>"><?php echo "$noSuratKontrol"; ?></a>
                                        </dt>
                                    </div>
                                    <div class="col-md-6">
                                        <small>
                                            <ol>
                                                <li>
                                                    Jenis Pelayanan : <code><?php echo $jnsPelayanan; ?></code>
                                                </li>
                                                <li>
                                                    Jenis Kontrol : <code><?php echo $namaJnsKontrol; ?></code>
                                                </li>
                                                <li>
                                                    Tgl Rencana : <code id="GetTglRencana<?php echo $noSuratKontrol; ?>"><?php echo $tglRencanaKontrol; ?></code>
                                                </li>
                                                <li>
                                                    Tgl Terbit : <code><?php echo $tglTerbitKontrol; ?></code>
                                                </li>
                                            </ol>
                                        </small>
                                    </div>
                                    <div class="col-md-6">
                                        <small>
                                            <ol>
                                                <li>
                                                    Kode Poli : <code id="GetKodePoli<?php echo $noSuratKontrol; ?>"><?php echo $poliTujuan; ?></code>
                                                </li>
                                                <li>
                                                    Nama Poli : <code id="GetNamaPoli<?php echo $noSuratKontrol; ?>"><?php echo $namaPoliTujuan; ?></code>
                                                </li>
                                                <li>
                                                    Kode Dokter : <code id="GetKodeDokter<?php echo $noSuratKontrol; ?>"><?php echo $kodeDokter; ?></code>
                                                </li>
                                                <li>
                                                    Nama Dokter : <code id="GetNamaDokter<?php echo $noSuratKontrol; ?>"><?php echo $NamaDokter; ?></code>
                                                </li>
                                            </ol>
                                        </small>
                                    </div>
                                </div>
<?php
                                $no++;
                            }
                        }
                    }
                }
            }
        }
    }
?>
<script>
    //Ketika Salah Satu Data Dipilih
    $('.CheckSuratKontrol').click(function(){
        var noSuratKontrol = $(this).attr("value");
        //Menangkap Nilai Pada Baris
        var GetNomorSurat=$('#GetNomorSurat'+noSuratKontrol+'').html();
        var GetTglRencana=$('#GetTglRencana'+noSuratKontrol+'').html();
        var GetNamaPoli=$('#GetNamaPoli'+noSuratKontrol+'').html();
        var GetNamaDokter=$('#GetNamaDokter'+noSuratKontrol+'').html();
        //Menambahkan Ke Form
        $('#no_surat_kontrol').val(GetNomorSurat);
        $('#tanggal_rencana_kontrol').val(GetTglRencana);
        $('#nama_poli_kontrol').val(GetNamaPoli);
        $('#nama_dokter_kontrol').val(GetNamaDokter);
        //Menutup Modal
        $('#ModalCariSuratKontrol').modal('hide');
    });
</script>