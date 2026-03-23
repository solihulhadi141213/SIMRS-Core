<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $url=urlService('Add Poliklinik');
    //Validasi id_poliklinik tidak boleh kosong
    if(empty($_POST['id_poliklinik'])){
        echo '<span class="text-danger">ID Poli Tidak Boleh Kosong</span>';
    }else{
        $id_poliklinik=$_POST['id_poliklinik'];
        //Buka data poli
        //Membuka detail halaman poliklinik
        $QryPoliklinik = mysqli_query($Conn,"SELECT * FROM poliklinik WHERE id_poliklinik='$id_poliklinik'")or die(mysqli_error($Conn));
        $DataPoliklinik = mysqli_fetch_array($QryPoliklinik);
        $nama = $DataPoliklinik['nama'];
        $koordinator= $DataPoliklinik['koordinator'];
        $deskripsi= $DataPoliklinik['deskripsi'];
        $kode= $DataPoliklinik['kode'];
        $status= $DataPoliklinik['status'];
        //Proses Kirim Data
        $KirimData = array(
            'api_key' => $api_key,
            'nama' => $nama,
            'deskripsi' => $deskripsi,
            'kode' => $kode,
            'status' => $status,
        );
        $json = json_encode($KirimData);
        //Mulai CURL
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if(!empty($err)){
            echo '<span class="text-danger">'.$err.'</span>';
        }else{
            $JsonData =json_decode($content, true);
            if(!empty($JsonData['metadata']['massage'])){
                $massage=$JsonData['metadata']['massage'];
            }else{
                $massage="";
            }
            if(!empty($JsonData['metadata']['code'])){
                $code=$JsonData['metadata']['code'];
            }else{
                $code="";
            }
            if($code!==200){
                echo '<span class="text-danger">Gagal!! <br> Pesan: '.$massage.'</span>';
            }else{
                $_SESSION['NotifikasiSwal']="Tambah Poliklinik Berhasil";
                echo '<span class="text-success" id="NotifikasiTambahPoliklinikDariSimrsBerhasil">Success</span>';
            }
        }
    }
?>