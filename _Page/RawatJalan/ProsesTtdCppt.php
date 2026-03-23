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
    //Validasi id_cppt tidak boleh kosong
    if(empty($_POST['id_cppt'])){
        echo '<small class="text-danger">ID CPPT Tindakan tidak boleh kosong</small>';
    }else{
        if(empty($_POST['kategori'])){
            echo '<small class="text-danger">Kategori CPPT Tindakan tidak boleh kosong</small>';
        }else{
            if(empty($_POST['signature'])){
                echo '<small class="text-danger">Tanda tangan tidak boleh kosong</small>';
            }else{
                //Variabel Lainnya
                $id_cppt=$_POST['id_cppt'];
                $kategori=$_POST['kategori'];
                $data_uri=$_POST['signature'];
                $encoded_image = explode(",", $data_uri)[1];
                //Buka Data Lama
                if($kategori=="Nakes"){
                    $kolom="nakes";
                    $NakesDokter=getDataDetail($Conn,"cppt",'id_cppt',$id_cppt,'nakes');
                    $JsonNakesDokter=json_decode($NakesDokter, true);
                    $kategori_nakes=$JsonNakesDokter['kategori'];
                    $nama=$JsonNakesDokter['nama'];
                    $kontak=$JsonNakesDokter['kontak'];
                    $kategori_identitas=$JsonNakesDokter['kategori_identitas'];
                    $no_identitas=$JsonNakesDokter['no_identitas'];
                    $ttd=$encoded_image;
                    $DataArray = array(
                        "kategori"=>"$kategori_nakes",
                        "nama"=>"$nama",
                        "kontak"=>"$kontak",
                        "kategori_identitas"=>"$kategori_identitas",
                        "no_identitas"=>"$no_identitas",
                        "ttd"=>"$ttd"
                    );
                    $DataUpdate= json_encode($DataArray);
                    $Update= mysqli_query($Conn,"UPDATE cppt SET 
                        $kolom='$DataUpdate'
                    WHERE id_cppt='$id_cppt'") or die(mysqli_error($Conn));
                    if($Update){
                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update TTD CPPT","Kunjungan",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            echo '<span class="text-success" id="NotifikasiTtdCpptBerhasil'.$kategori.''.$id_cppt.'">Success</span>';
                        }else{
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                        }
                    }else{
                        echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update!</span><br>';
                    }
                }else{
                    $kolom="dokter";
                    $NakesDokter=getDataDetail($Conn,"cppt",'id_cppt',$id_cppt,'dokter');
                    $JsonNakesDokter=json_decode($NakesDokter, true);
                    $SIP=$JsonNakesDokter['SIP'];
                    $nama=$JsonNakesDokter['nama'];
                    $kontak=$JsonNakesDokter['kontak'];
                    $kategori_identitas=$JsonNakesDokter['kategori_identitas'];
                    $no_identitas=$JsonNakesDokter['no_identitas'];
                    $ttd=$encoded_image;
                    $DataArray = array(
                        "nama"=>"$nama",
                        "SIP"=>"$SIP",
                        "kontak"=>"$kontak",
                        "kategori_identitas"=>"$kategori_identitas",
                        "no_identitas"=>"$no_identitas",
                        "ttd"=>"$ttd"
                    );
                    $DataUpdate= json_encode($DataArray);
                    $Update= mysqli_query($Conn,"UPDATE cppt SET 
                        $kolom='$DataUpdate',
                        status='Valid'
                    WHERE id_cppt='$id_cppt'") or die(mysqli_error($Conn));
                    if($Update){
                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update TTD CPPT","Kunjungan",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            echo '<span class="text-success" id="NotifikasiTtdCpptBerhasil'.$kategori.''.$id_cppt.'">Success</span>';
                        }else{
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                        }
                    }else{
                        echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update!</span><br>';
                    }
                }
            }
        }
    }
?>
