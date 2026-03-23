<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Validasi Form Data Yang Wajib Diisi
    if(empty($_POST['id_bridging'])){
        echo '<span class="text-danger">ID Bridging Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['nama_bridging'])){
            echo '<span class="text-danger">Nama Profile Setting Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['status'])){
                echo '<span class="text-danger">Status Setting Tidak Boleh Kosong</span>';
            }else{
                $id_bridging=$_POST['id_bridging'];
                $nama_bridging=$_POST['nama_bridging'];
                $status=$_POST['status'];
                //Buat variabel dari data lain yang tidak wajib
                //consid
                if(!empty($_POST['consid'])){
                    $consid=$_POST['consid'];
                }else{
                    $consid="";
                }
                if(!empty($_POST['cons_id_antrol'])){
                    $cons_id_antrol=$_POST['cons_id_antrol'];
                }else{
                    $cons_id_antrol="";
                }
                //user_key
                if(!empty($_POST['user_key'])){
                    $user_key=$_POST['user_key'];
                }else{
                    $user_key="";
                }
                if(!empty($_POST['user_key_antrol'])){
                    $user_key_antrol=$_POST['user_key_antrol'];
                }else{
                    $user_key_antrol="";
                }
                //secret_key
                if(!empty($_POST['secret_key'])){
                    $secret_key=$_POST['secret_key'];
                }else{
                    $secret_key="";
                }
                if(!empty($_POST['secret_key_antrol'])){
                    $secret_key_antrol=$_POST['secret_key_antrol'];
                }else{
                    $secret_key_antrol="";
                }
                //kode_ppk
                if(!empty($_POST['kode_ppk'])){
                    $kode_ppk=$_POST['kode_ppk'];
                }else{
                    $kode_ppk="";
                }
                //url_vclaim
                if(!empty($_POST['url_vclaim'])){
                    $url_vclaim=$_POST['url_vclaim'];
                }else{
                    $url_vclaim="";
                }
                //url_aplicare
                if(!empty($_POST['url_aplicare'])){
                    $url_aplicare=$_POST['url_aplicare'];
                }else{
                    $url_aplicare="";
                }
                //url_faskes
                if(!empty($_POST['url_faskes'])){
                    $url_faskes=$_POST['url_faskes'];
                }else{
                    $url_faskes="";
                }
                 //url_antrol
                if(!empty($_POST['url_antrol'])){
                    $url_antrol=$_POST['url_antrol'];
                }else{
                    $url_antrol="";
                }
                if(!empty($_POST['kategori_ppk'])){
                    $kategori_ppk=$_POST['kategori_ppk'];
                }else{
                    $kategori_ppk="";
                }
                //Karena hanya boleh 1 yang aktiv maka apabila yang ini aktiv, non aktivkan data yang lain
                if($status=="Aktiv"){
                    $UpdateBridging= mysqli_query($Conn,"UPDATE bridging SET 
                        status='Non-Aktiv'
                    WHERE status='Aktiv'") or die(mysqli_error($Conn));
                    if($UpdateBridging){
                        $UpdateBridgingLanjut= mysqli_query($Conn,"UPDATE bridging SET 
                            nama_bridging='$nama_bridging',
                            consid='$consid',
                            cons_id_antrol='$cons_id_antrol',
                            user_key='$user_key',
                            user_key_antrol='$user_key_antrol',
                            secret_key='$secret_key',
                            secret_key_antrol='$secret_key_antrol',
                            kode_ppk='$kode_ppk',
                            url_vclaim='$url_vclaim',
                            url_aplicare='$url_aplicare',
                            url_antrol='$url_antrol',
                            url_faskes='$url_faskes',
                            kategori_ppk='$kategori_ppk',
                            status='$status'
                        WHERE id_bridging='$id_bridging'") or die(mysqli_error($Conn));
                        if($UpdateBridgingLanjut){
                            echo '<span class="text-primary" id="NotifikasiEdit">Berhasil</span>';
                        }else{
                            echo '<span class="text-danger">Update Profile Setting Bridging Gagal!!</span>';
                        }
                    }else{
                        echo '<span class="text-danger">Update Status Non Aktiv Untuk Data Lain Gagal!!</span>';
                    }
                }else{
                    //Apabila tidak aktiv langsung simpan saja
                    $UpdateBridgingLanjut= mysqli_query($Conn,"UPDATE bridging SET 
                        nama_bridging='$nama_bridging',
                        consid='$consid',
                        cons_id_antrol='$cons_id_antrol',
                        user_key='$user_key',
                        user_key_antrol='$user_key_antrol',
                        secret_key='$secret_key',
                        secret_key_antrol='$secret_key_antrol',
                        kode_ppk='$kode_ppk',
                        url_vclaim='$url_vclaim',
                        url_aplicare='$url_aplicare',
                        url_antrol='$url_antrol',
                        url_faskes='$url_faskes',
                        kategori_ppk='$kategori_ppk',
                        status='$status'
                    WHERE id_bridging='$id_bridging'") or die(mysqli_error($Conn));
                    if($UpdateBridgingLanjut){
                        echo '<span class="text-primary" id="NotifikasiEdit">Berhasil</span>';
                    }else{
                        echo '<span class="text-danger">Update Profile Setting Bridging Gagal!!</span>';
                    }
                }
            }
        }
    }
?>