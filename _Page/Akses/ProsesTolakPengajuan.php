<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $JsonUrl="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i:s');
    //Validasi Form Data
    if(empty($_POST['id_akses_pengajuan'])){
        echo '<span class="text-danger">ID Pengajuan Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['email'])){
            echo '<span class="text-danger">Email Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['keterangan_penolakan'])){
                echo '<span class="text-danger">Setidaknya anda harus mengisi alasan penolakan!</span>';
            }else{
                if(empty($_POST['KirimEmailPenolakan'])){
                    $KirimEmailPenolakan="";
                }else{
                    $KirimEmailPenolakan=$_POST['KirimEmailPenolakan'];
                }
                $id_akses_pengajuan=$_POST['id_akses_pengajuan'];
                $email=$_POST['email'];
                $keterangan_penolakan=$_POST['keterangan_penolakan'];
                $JumlahKeterangan = strlen($keterangan_penolakan);
                if($JumlahKeterangan>200){
                    echo '<span class="text-danger">Keterangan Penolakan Maksimal 200 karakter</span>';
                }else{
                    if($JumlahKeterangan<10){
                        echo '<span class="text-danger">Keterangan penolakan terlalu singkat, Jelaskan lebih rinci.</span>';
                    }else{
                        $UpdatePengajuan = mysqli_query($Conn,"UPDATE akses_pengajuan SET 
                            status='Ditolak',
                            keterangan='$keterangan_penolakan'
                        WHERE id_akses_pengajuan='$id_akses_pengajuan'") or die(mysqli_error($Conn)); 
                        if($UpdatePengajuan){
                            if($KirimEmailPenolakan=="Ya"){
                                $NamaPemohon=getDataDetail($Conn,'akses_pengajuan','id_akses_pengajuan',$id_akses_pengajuan,'nama');
                                //Kirim Email
                                $email_tujuan=$email;
                                $nama_tujuan=$NamaPemohon;
                                $pesan='
                                Pengajuan akses anda ditolak dengan alasan:<br> 
                                '.$keterangan_penolakan.'<br>
                                ';
                                $subjek='Pengajuan Akses Ditolak';
                                //Membuka Pengaturan
                                $EmailGateway=getEmailSetting($Conn,'email_gateway');
                                $PasswordGateway=getEmailSetting($Conn,'password_gateway');
                                $UrlProvider=getEmailSetting($Conn,'url_provider');
                                $PortGateway=getEmailSetting($Conn,'port_gateway');
                                $NamaPengirim=getEmailSetting($Conn,'nama_pengirim');
                                $UrlService=getEmailSetting($Conn,'url_service');
                                //Kirim Email
                                $KirimData = array(
                                    'subjek' => $subjek,
                                    'email_asal' => $EmailGateway,
                                    'password_email_asal' => $PasswordGateway,
                                    'url_provider' => $UrlProvider,
                                    'nama_pengirim' => $NamaPengirim,
                                    'email_tujuan' => $email_tujuan,
                                    'nama_tujuan' => $nama_tujuan,
                                    'pesan' => $pesan,
                                    'port' => $PortGateway
                                );
                                $json = json_encode($KirimData);
                                //Mulai CURL
                                $ch = curl_init();
                                curl_setopt($ch,CURLOPT_URL, "$UrlService");
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
                                     //Menyimpan Log
                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Menolak Pengajuan Akses","Akses",$SessionIdAkses,$JsonUrl);
                                    if($MenyimpanLog=="Berhasil"){
                                        $_SESSION['NotifikasiSwal']="Tolak Pengajuan Berhasil";
                                        echo '<span class="text-success" id="NotifikasiTolakPengajuanBerhasil">Success</span>';
                                    }else{
                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                    }
                                }
                            }else{
                                //Menyimpan Log
                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Menolak Pengajuan Akses","Akses",$SessionIdAkses,$JsonUrl);
                                if($MenyimpanLog=="Berhasil"){
                                    $_SESSION['NotifikasiSwal']="Tolak Pengajuan Berhasil";
                                    echo '<span class="text-success" id="NotifikasiTolakPengajuanBerhasil">Success</span>';
                                }else{
                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>