<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //Validasi Data tidak boleh Kosong
    if(empty($_POST['id_tt'])){
        echo '<span class="text-danger">ID TT Tidak Boleh Kosong</span>';
    }else{
        $id_tt=$_POST['id_tt'];
        if(empty($_POST['jumlah'])){
            $jumlah="0";
        }else{
            $jumlah=$_POST['jumlah'];
        }
        if(empty($_POST['terpakai'])){
            $terpakai="0";
        }else{
            $terpakai=$_POST['terpakai'];
        }  
        if(empty($_POST['terpakai_suspek'])){
            $terpakai_suspek="0";
        }else{
            $terpakai_suspek=$_POST['terpakai_suspek'];
        }
        if(empty($_POST['terpakai_konfirmasi'])){
            $terpakai_konfirmasi="0";
        }else{
            $terpakai_konfirmasi=$_POST['terpakai_konfirmasi'];
        }  
        if(empty($_POST['antrian'])){
            $antrian="0";
        }else{
            $antrian=$_POST['antrian'];
        }
        if(empty($_POST['prepare'])){
            $prepare="0";
        }else{
            $prepare=$_POST['prepare'];
        }
        if(empty($_POST['prepare_plan'])){
            $prepare_plan="0";
        }else{
            $prepare_plan=$_POST['prepare_plan'];
        }
        if(empty($_POST['covid'])){
            $covid="0";
        }else{
            $covid=$_POST['covid'];
        }
        //Validasi Hanya Boleh Angka
        if(!is_numeric($jumlah)){
            echo '<span class="text-danger">Jumlah TT Hanya Boleh Angka</span>';
        }else{
            if(!is_numeric($terpakai)){
                echo '<span class="text-danger">Jumlah Terpakai Hanya Boleh Angka</span>';
            }else{
                if(!is_numeric($terpakai_suspek)){
                    echo '<span class="text-danger">Jumlah Terpakai Suspek Hanya Boleh Angka</span>';
                }else{
                    if(!is_numeric($terpakai_konfirmasi)){
                        echo '<span class="text-danger">Jumlah Terpakai Konfirmasi Hanya Boleh Angka</span>';
                    }else{
                        if(!is_numeric($antrian)){
                            echo '<span class="text-danger">Jumlah Antrian Hanya Boleh Angka</span>';
                        }else{
                            if(!is_numeric($prepare)){
                                echo '<span class="text-danger">Jumlah prepare Hanya Boleh Angka</span>';
                            }else{
                                if(!is_numeric($prepare_plan)){
                                    echo '<span class="text-danger">Jumlah prepare plan Hanya Boleh Angka</span>';
                                }else{
                                    if(!is_numeric($covid)){
                                        echo '<span class="text-danger">Jumlah covid Hanya Boleh Angka</span>';
                                    }else{
                                        $hasil_implode = "";
                                        $jumlah_ruangan =0;
                                        $jumlah_tt =0;
                                        $query1 = mysqli_query($Conn, "SELECT*FROM ruang_rawat_sirs WHERE id_tt='$id_tt'");
                                        while ($data1 = mysqli_fetch_array($query1)) {
                                            $id_ruang_rawat  = $data1['id_ruang_rawat'];
                                            //Buka Nama Kelas
                                            $kodekelas=getDataDetail($Conn,'ruang_rawat','id_ruang_rawat',$id_ruang_rawat,'kodekelas');
                                            $kelas=getDataDetail($Conn,'ruang_rawat','id_ruang_rawat',$id_ruang_rawat,'kelas');
                                            $JumlahRuangan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kodekelas='$kodekelas' AND kategori='ruangan'"));
                                            if(!empty($JumlahRuangan)){
                                                $jumlah_ruangan =$jumlah_ruangan+1;
                                                $no=1;
                                                $query2 = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='ruangan' AND kelas='$kelas'");
                                                while ($data2 = mysqli_fetch_array($query2)) {
                                                    $ruangan  = $data2['ruangan'];
                                                    $hasil_implode .= $ruangan . ",";
                                                    $jumlah_tt =$jumlah_tt+1;
                                                }
                                            }else{
                                                $jumlah_ruangan =$jumlah_ruangan+0;
                                            }
                                        }
                                        $hasil_implode = rtrim($hasil_implode, ",");
                                        $ruang=$hasil_implode;
                                        //Buat JSON
                                        $data = array(
                                            'id_tt' => $id_tt,
                                            'ruang' => $ruang,
                                            'jumlah_ruang' => $jumlah_ruangan,
                                            'jumlah' => $jumlah_tt,
                                            'terpakai' => $terpakai,
                                            'terpakai_suspek' => $terpakai_suspek,
                                            'terpakai_konfirmasi' => $terpakai_konfirmasi,
                                            'antrian' => $antrian,
                                            'prepare' => $prepare,
                                            'prepare_plan' => $prepare_plan,
                                            'covid' => $covid,
                                        );
                                        $json_data = json_encode($data);
                                        //Kirim Data
                                        $KirimData=TambahTempatTidur($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data);
                                        if(empty($KirimData)){
                                            echo '<span class="text-danger">Tidak ada response dari service SIRS online</span>';
                                        }else{
                                            $php_array = json_decode($KirimData, true);
                                            $status=$php_array['fasyankes']['0']['status'];
                                            $message=$php_array['fasyankes']['0']['message'];
                                            if($status=="200"){
                                                echo '<span class="text-success" id="NotifikasiTambahTempatTidurBerhasil">Success</span>';
                                            }else{
                                                echo '<span class="text-danger">Terjadi kesalahan pada saat mengirim data</span>';
                                                echo '<p class="text-danger">'.$message.'</p>';
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