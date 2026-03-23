<?php
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    $Updatetime=date('Y-m-d H:i');
    //Validasi id_pasien tidak boleh kosong
    if(empty($_POST['ProsesEditCPPT'])){
        echo '<small class="text-danger">Data Form tidak boleh kosong</small>';
    }else{
        if(empty($_POST['subjective'])){
            echo '<small class="text-danger">Subjective tidak boleh kosong</small>';
        }else{
            if(empty($_POST['objective'])){
                echo '<small class="text-danger">Objective tidak boleh kosong</small>';
            }else{
                if(empty($_POST['assessment'])){
                    echo '<small class="text-danger">Assessment tidak boleh kosong</small>';
                }else{
                    if(empty($_POST['plan'])){
                        echo '<small class="text-danger">Plan tidak boleh kosong</small>';
                    }else{
                        //Membuat variabel wajib
                        $ProsesEditCPPT=$_POST['ProsesEditCPPT'];
                        //Parameter
                        parse_str($ProsesEditCPPT, $params);
                        //Validasi Kelengkapan Data
                        if(empty($params['id_cppt'])){
                            echo '<small class="text-danger">ID CPPT tidak boleh kosong</small>';
                        }else{
                            if(empty($params['id_pasien'])){
                                echo '<small class="text-danger">No.RM tidak boleh kosong</small>';
                            }else{
                                if(empty($params['id_kunjungan'])){
                                    echo '<small class="text-danger">ID Kunjungan tidak boleh kosong</small>';
                                }else{
                                    if(empty($params['tanggal_entry'])){
                                        echo '<small class="text-danger">Tanggal Entry tidak boleh kosong</small>';
                                    }else{
                                        if(empty($params['jam_entry'])){
                                            echo '<small class="text-danger">Jam Entry tidak boleh kosong</small>';
                                        }else{
                                            if(empty($params['nama_nakes'])){
                                                echo '<small class="text-danger">Nama nakes tidak boleh kosong</small>';
                                            }else{
                                                if(empty($params['kategori_nakes'])){
                                                    echo '<small class="text-danger">Kategori nakes tidak boleh kosong</small>';
                                                    }else{
                                                    if(empty($params['kontak_nakes'])){
                                                        echo '<small class="text-danger">Kontak nakes tidak boleh kosong</small>';
                                                    }else{
                                                        if(empty($params['identitas_nakes'])){
                                                            echo '<small class="text-danger">Identitas Nakes tidak boleh kosong</small>';
                                                        }else{
                                                            if(empty($params['no_identitas_nakes'])){
                                                                echo '<small class="text-danger">Nomor identitas nakes tidak boleh kosong</small>';
                                                            }else{
                                                                if(empty($params['nama_dokter'])){
                                                                    echo '<small class="text-danger">Nama Dokter tidak boleh kosong</small>';
                                                                }else{
                                                                    if(empty($params['sip_dokter'])){
                                                                        echo '<small class="text-danger">SIP Dokter DPJP tidak boleh kosong</small>';
                                                                    }else{
                                                                        $id_cppt = $params['id_cppt'];
                                                                        //Buka Data Lama
                                                                        $nakes=getDataDetail($Conn,"cppt",'id_cppt',$id_cppt,'nakes');
                                                                        $dokter=getDataDetail($Conn,"cppt",'id_cppt',$id_cppt,'dokter');
                                                                        //Json 
                                                                        $JsonNakes =json_decode($nakes, true);
                                                                        $JsonDokter =json_decode($dokter, true);
                                                                        $TtdNakes=$JsonNakes['ttd'];
                                                                        $TtdDokter=$JsonDokter['ttd'];
                                                                        //Pasien
                                                                        $id_pasien = $params['id_pasien'];
                                                                        $id_kunjungan = $params['id_kunjungan'];
                                                                        $tanggal_entry = $params['tanggal_entry'];
                                                                        $jam_entry = $params['jam_entry'];
                                                                        //Nakes
                                                                        $nama_nakes = $params['nama_nakes'];
                                                                        $kategori_nakes = $params['kategori_nakes'];
                                                                        $kontak_nakes = $params['kontak_nakes'];
                                                                        $identitas_nakes = $params['identitas_nakes'];
                                                                        $no_identitas_nakes = $params['no_identitas_nakes'];
                                                                        //Dokter DPJP
                                                                        $nama_dokter = $params['nama_dokter'];
                                                                        $sip_dokter = $params['sip_dokter'];
                                                                        if(empty($params['kontak_dokter'])){
                                                                            $kontak_dokter="";
                                                                        }else{
                                                                            $kontak_dokter=$params['kontak_dokter'];
                                                                        }
                                                                        if(empty($params['identitas_dokter'])){
                                                                            $identitas_dokter="";
                                                                        }else{
                                                                            $identitas_dokter=$params['identitas_dokter'];
                                                                        }
                                                                        if(empty($params['no_identitas_dokter'])){
                                                                            $no_identitas_dokter="";
                                                                        }else{
                                                                            $no_identitas_dokter=$params['no_identitas_dokter'];
                                                                        }
                                                                        //SOAp
                                                                        $subjective=$_POST['subjective'];
                                                                        $objective=$_POST['objective'];
                                                                        $assessment=$_POST['assessment'];
                                                                        $plan=$_POST['plan'];
                                                                        if(empty($_POST['catatan'])){
                                                                            $catatan="";
                                                                        }else{
                                                                            $catatan=$_POST['catatan'];
                                                                        }
                                                                        //Bersihkan Ilegal String
                                                                        $subjective= addslashes($subjective);
                                                                        $subjective = str_replace(array("\r","\n"),"",$subjective);
                                                                        $objective= addslashes($objective);
                                                                        $objective = str_replace(array("\r","\n"),"",$objective);
                                                                        $assessment= addslashes($assessment);
                                                                        $assessment = str_replace(array("\r","\n"),"",$assessment);
                                                                        $plan= addslashes($plan);
                                                                        $plan = str_replace(array("\r","\n"),"",$plan);
                                                                        $catatan= addslashes($catatan);
                                                                        $catatan = str_replace(array("\r","\n"),"",$catatan);
                                                                        //Membuat JSON Nakes
                                                                        $NakesArray = array(
                                                                            "kategori"=>"$kategori_nakes",
                                                                            "nama"=>"$nama_nakes",
                                                                            "kontak"=>"$kontak_nakes",
                                                                            "kategori_identitas"=>"$identitas_nakes",
                                                                            "no_identitas"=>"$no_identitas_nakes",
                                                                            "ttd"=>"$TtdNakes",
                                                                        );
                                                                        $JsonNakes= json_encode($NakesArray);
                                                                        //Membuat JSON Dokter
                                                                        $DokterArray = array(
                                                                            "nama"=>"$nama_dokter",
                                                                            "SIP"=>"$sip_dokter",
                                                                            "kontak"=>"$kontak_dokter",
                                                                            "kategori_identitas"=>"$identitas_dokter",
                                                                            "no_identitas"=>"$no_identitas_dokter",
                                                                            "ttd"=>"$TtdDokter"
                                                                        );
                                                                        $JsonDokter= json_encode($DokterArray);
                                                                        //Format Tanggal
                                                                        $TanggalEntry="$tanggal_entry $jam_entry";
                                                                        //Simpan Data
                                                                        $Update= mysqli_query($Conn,"UPDATE cppt SET 
                                                                            tanggal_entry='$TanggalEntry',
                                                                            nakes='$JsonNakes',
                                                                            dokter='$JsonDokter',
                                                                            subjective='$subjective',
                                                                            objective='$objective',
                                                                            assessment='$assessment',
                                                                            plan='$plan',
                                                                            catatan='$catatan'
                                                                        WHERE id_cppt='$id_cppt'") or die(mysqli_error($Conn));
                                                                        if($Update){
                                                                            $LogJsonFile="../../_Page/Log/Log.json";
                                                                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit CPPT","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                            if($MenyimpanLog=="Berhasil"){
                                                                                echo '<span class="text-success" id="NotifikasiEditCPPTBerhasil">Success</span>';
                                                                            }else{
                                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                            }
                                                                        }else{
                                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan data</span>';
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
    }
?>
