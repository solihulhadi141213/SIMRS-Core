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
        echo '<small class="text-danger">ID Kunjungan Tindakan tidak boleh kosong</small>';
    }else{
        if(empty($_POST['signature'])){
            echo '<small class="text-danger">Tanda tangan tidak boleh kosong</small>';
        }else{
            //Variabel Lainnya
            $id_kunjungan=$_POST['id_kunjungan'];
            $data_uri=$_POST['signature'];
            $encoded_image = explode(",", $data_uri)[1];
            $decoded_image = base64_decode($encoded_image);
            //Buka Data Lama
            $Persetujuan=getDataDetail($Conn,"operasi",'id_kunjungan',$id_kunjungan,'persetujuan');
            $JsonPersetujuan=json_decode($Persetujuan, true);
            $hubungan=$JsonPersetujuan['hubungan'];
            $nama=$JsonPersetujuan['nama'];
            $kontak=$JsonPersetujuan['kontak'];
            $kategori_identitas=$JsonPersetujuan['kategori_identitas'];
            $nomor_identitas=$JsonPersetujuan['nomor_identitas'];
            $ttd=$encoded_image;
            $PersetujuanArray = array(
                "hubungan"=>"$hubungan",
                "nama"=>"$nama",
                "kontak"=>"$kontak",
                "kategori_identitas"=>"$kategori_identitas",
                "nomor_identitas"=>"$nomor_identitas",
                "ttd"=>"$ttd"
            );
            $JsonPersetujuanBaru= json_encode($PersetujuanArray);
            $Update= mysqli_query($Conn,"UPDATE operasi SET 
                persetujuan='$JsonPersetujuanBaru'
            WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
            if($Update){
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tanda Tangan Persetujuan Operasi","Kunjungan",$SessionIdAkses,$LogJsonFile);
                if($MenyimpanLog=="Berhasil"){
                    echo '<span class="text-success" id="NotifikasiTtdPenanggungjawabOperasiBerhasil">Success</span>';
                    echo '<span class="text-success" id="UrlBackTtdPenanggungJawabOperasi">index.php?Page=RawatJalan&Sub=Operasi&id='.$id_kunjungan.'</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update!</span><br>';
            }
        }
    }
?>
