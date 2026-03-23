<?php
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Buka Setting Satu Sehat
    $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
    $organization_id=getDataDetail($Conn,'setting_satusehat','status','Active','organization_id');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi id_pasien tidak boleh kosong
    if(empty($_POST['id_pasien'])){
        echo '<small class="text-danger">ID Pasien tidak boleh kosong</small>';
    }else{
        //Validasi id_kunjungan tidak boleh kosong
        if(empty($_POST['id_kunjungan'])){
            echo '<small class="text-danger">ID Kunjungan tidak boleh kosong</small>';
        }else{
            //Validasi id_encounter tidak boleh kosong
            if(empty($_POST['id_encounter'])){
                echo '<small class="text-danger">ID Encounter tidak boleh kosong</small>';
            }else{
                //Validasi tanggal tidak boleh kosong
                if(empty($_POST['organization_id'])){
                    echo '<small class="text-danger">ID Organization tidak boleh kosong</small>';
                }else{
                    //Validasi nama tidak boleh kosong
                    if(empty($_POST['nama'])){
                        echo '<small class="text-danger">Nama pasien tidak boleh kosong</small>';
                    }else{
                        //Validasi clinicalStatus tidak boleh kosong
                        if(empty($_POST['clinicalStatus'])){
                            echo '<small class="text-danger">Status Klinis tidak boleh kosong</small>';
                        }else{
                            //Validasi verificationStatus tidak boleh kosong
                            if(empty($_POST['verificationStatus'])){
                                echo '<small class="text-danger">Status Verifikasi tidak boleh kosong</small>';
                            }else{
                                //Validasi category tidak boleh kosong
                                if(empty($_POST['category'])){
                                    echo '<small class="text-danger">Kategori tidak boleh kosong</small>';
                                }else{
                                    //Validasi code_alergi tidak boleh kosong
                                    if(empty($_POST['code_alergi'])){
                                        echo '<small class="text-danger">Kategori tidak boleh kosong</small>';
                                    }else{
                                        //Validasi id_ihs_practitioner tidak boleh kosong
                                        if(empty($_POST['id_ihs_practitioner'])){
                                            echo '<small class="text-danger">Practitioner/Nakes tidak boleh kosong</small>';
                                        }else{
                                            //Validasi Sesi Login
                                            if(empty($SessionIdAkses)){
                                                echo '<small class="text-danger">Sesi Login Sudah Berakhir, Silahkan login ulang terlebih dulu</small>';
                                            }else{
                                                if(empty($_POST['keterangan_alergi'])){
                                                    $keterangan_alergi="";
                                                }else{
                                                    $keterangan_alergi=$_POST['keterangan_alergi'];
                                                }
                                                //Membuat variabel wajib
                                                $id_kunjungan=$_POST['id_kunjungan'];
                                                $id_pasien=$_POST['id_pasien'];
                                                $id_encounter=$_POST['id_encounter'];
                                                $organization_id=$_POST['organization_id'];
                                                $nama=$_POST['nama'];
                                                $clinicalStatus=$_POST['clinicalStatus'];
                                                $verificationStatus=$_POST['verificationStatus'];
                                                $category=$_POST['category'];
                                                $code_alergi=$_POST['code_alergi'];
                                                $id_ihs_practitioner=$_POST['id_ihs_practitioner'];
                                                //Buka Informasi Pendukung
                                                $id_ihs=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'id_ihs');
                                                $tujuan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'tujuan');
                                                $tanggal_kunjungan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'tanggal');
                                                $recordedDate = date('Y-m-d\TH:i:sP');
                                                //Mencari id_kunjungan_alergi
                                                $sql = "SELECT MAX(id_kunjungan_alergi) AS max_value FROM kunjungan_alergi"; 
                                                $result = $Conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    $row = $result->fetch_assoc();
                                                    $max_value = $row["max_value"];
                                                } else {
                                                    $max_value=0;
                                                }
                                                $id_kunjungan_alergi=$max_value+1;
                                                if(empty($id_ihs)){
                                                    echo '<small class="text-danger">Pasien tersebut belum memiliki ID IHS</small>';
                                                }else{
                                                    //Menangkap Multi Data
                                                    $jumlah_dipilih = count($code_alergi);
                                                    $JumlahDipilihValid=0;
                                                    for($x=0;$x<$jumlah_dipilih;$x++){
                                                        $alergi=$code_alergi[$x];
                                                        //Explode
                                                        $explode=explode('-',$alergi);
                                                        $code_alergi=$explode[0];
                                                        $nama_alergi=$explode[1];
                                                        //Buka Sistem
                                                        $QryAlergi = mysqli_query($Conn,"SELECT * FROM referensi_alergi WHERE code='$code_alergi' AND display='$nama_alergi'")or die(mysqli_error($Conn));
                                                        $DataAlergi = mysqli_fetch_array($QryAlergi);
                                                        if(empty($DataAlergi['sumber'])){
                                                            $sumber="";
                                                            $coding = array(
                                                                "system" => $sumber,
                                                                "code" => $code_alergi,
                                                                "display" => $nama_alergi
                                                            );
                                                            $JumlahDipilihValid=$JumlahDipilihValid+0;
                                                        }else{
                                                            $sumber=$DataAlergi['sumber'];
                                                            $coding = array(
                                                                "system" => $sumber,
                                                                "code" => $code_alergi,
                                                                "display" => $nama_alergi
                                                            );
                                                            $JumlahDipilihValid=$JumlahDipilihValid+1;
                                                        }
                                                        $code_coding[] = $coding;
                                                    }
                                                    if($jumlah_dipilih!==$JumlahDipilihValid){
                                                        echo '<small class="text-danger">Format pengisian jenis alergi tidak valid</small>';
                                                    }else{
                                                        //Devinisikan Variabel
                                                        if($clinicalStatus=="active"){
                                                            $clinicalStatus_display="Active";
                                                        }else{
                                                            if($clinicalStatus=="inactive"){
                                                                $clinicalStatus_display="Inactive";
                                                            }else{
                                                                $clinicalStatus_display="Resolved";
                                                            }
                                                        }
                                                        if($verificationStatus=="unconfirmed"){
                                                            $verificationStatus_display="Unconfirmed";
                                                        }else{
                                                            if($verificationStatus=="confirmed"){
                                                                $verificationStatus_display="Confirmed";
                                                            }else{
                                                                if($verificationStatus=="refuted"){
                                                                    $verificationStatus_display="Refuted";
                                                                }else{
                                                                    $verificationStatus_display="Entered in Error";
                                                                }
                                                            }
                                                        }
                                                        //Membuat JSON
                                                        $resourceType="AllergyIntolerance";
                                                        //Array
                                                        $identifier=Array (
                                                            "0" => Array (
                                                                "system" => "http://sys-ids.kemkes.go.id/allergy/$organization_id",
                                                                "use" => "official",
                                                                "value" => "$id_kunjungan_alergi"
                                                            )
                                                        );
                                                        $clinicalStatus_coding=Array (
                                                            "0" => Array (
                                                                "code" => $clinicalStatus,
                                                                "display" => $clinicalStatus_display,
                                                                "system" => "http://terminology.hl7.org/CodeSystem/allergyintolerance-clinical"
                                                            )
                                                        );
                                                        $clinicalStatus=Array (
                                                            "coding" => $clinicalStatus_coding
                                                        );
                                                        $verificationStatus_coding=Array (
                                                            "0" => Array (
                                                                "system" => "http://terminology.hl7.org/CodeSystem/allergyintolerance-verification",
                                                                "code" => $verificationStatus,
                                                                "display" => $verificationStatus_display
                                                            )
                                                        );
                                                        $verificationStatus=Array (
                                                            "coding" => $verificationStatus_coding
                                                        );
                                                        $category = array("$category");
                                                        $code_alergi=Array (
                                                            "coding" => $code_coding,
                                                            "text" => $keterangan_alergi,
                                                        );
                                                        $patient=Array (
                                                            "reference" => "Patient/$id_ihs",
                                                            "display" => $nama,
                                                        );
                                                        $encounter=Array (
                                                            "reference" => "Encounter/$id_encounter",
                                                            "display" => "Kunjungan $tujuan pada tanggal $tanggal_kunjungan",
                                                        );
                                                        $recorder=Array (
                                                            "reference" => "Practitioner/$id_ihs_practitioner"
                                                        );
                                                        $ArrayAlergi=Array (
                                                            "resourceType" => $resourceType,
                                                            "identifier" => $identifier,
                                                            "clinicalStatus" => $clinicalStatus,
                                                            "verificationStatus" => $verificationStatus,
                                                            "category" => $category,
                                                            "code" => $code_alergi,
                                                            "patient" => $patient,
                                                            "encounter" => $encounter,
                                                            "recordedDate" => $recordedDate,
                                                            "recorder" => $recorder
                                                        );
                                                        $Json= json_encode($ArrayAlergi);
                                                        //Buat Token
                                                        $Token=GenerateTokenSatuSehat($Conn);
                                                        if(empty($Token)){
                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Generate Token</span>';
                                                        }else{
                                                            //Simpan Ke Service Satu Sehat
                                                            $response=CreatAllergyIntolerance ($baseurl_satusehat,$Json,$Token);
                                                            if(empty($response)){
                                                                echo '<span class="text-danger">Tidak ada respoonse dari Satu Sehat</span>';
                                                            }else{
                                                                $JsonData =json_decode($response, true);
                                                                if(empty($JsonData['id'])){
                                                                    echo '<span class="text-danger">Proses Kirim Ke Satu Sehat Gagal</span><br>';
                                                                    echo '<textarea class="form-control">'.$response.'</textarea>';
                                                                    echo '<textarea class="form-control">'.$Json.'</textarea>';
                                                                }else{
                                                                    $id_allergy=$JsonData['id'];
                                                                    $updatetime=date('Y-m-d H:i:s');
                                                                    //Menyimpan Kedalam Database
                                                                    $entry="INSERT INTO kunjungan_alergi (
                                                                        id_kunjungan_alergi,
                                                                        id_pasien,
                                                                        id_kunjungan,
                                                                        id_encounter,
                                                                        id_allergy,
                                                                        raw,
                                                                        id_akses,
                                                                        updatetime
                                                                    ) VALUES (
                                                                        '$id_kunjungan_alergi',
                                                                        '$id_pasien',
                                                                        '$id_kunjungan',
                                                                        '$id_encounter',
                                                                        '$id_allergy',
                                                                        '$Json',
                                                                        '$SessionIdAkses',
                                                                        '$updatetime'
                                                                    )";
                                                                    $hasil=mysqli_query($Conn, $entry);
                                                                    if($hasil){
                                                                        $now=date('Y-m-d H:i:s');
                                                                        $LogJsonFile="../../_Page/Log/Log.json";
                                                                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Alergi Kunjungan","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                        if($MenyimpanLog=="Berhasil"){
                                                                            echo '<span class="text-success" id="NotifikasiTambahAllergyIntolerancBerhasil">Success</span>';
                                                                        }else{
                                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                        }
                                                                    }else{
                                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan data Alergy</span>';
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
                }
            }
        }
    }
?>
