<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    $tgllapor=date('Y-m-d H:i:s');
    //Validasi Data tidak boleh Kosong
    if(empty($_POST['TanggalLaporanPcrNakes'])){
        echo '<span class="text-danger">Tanggal Tidak Boleh Kosong</span>';
    }else{
        $tanggal=$_POST['TanggalLaporanPcrNakes'];
        //Validasi Duplikat
        if(empty($_POST['jumlah_tenaga_dokter_umum'])){
            $jumlah_tenaga_dokter_umum=0;
        }else{
            $jumlah_tenaga_dokter_umum=$_POST['jumlah_tenaga_dokter_umum'];
        }
        if(empty($_POST['sudah_periksa_dokter_umum'])){
            $sudah_periksa_dokter_umum=0;
        }else{
            $sudah_periksa_dokter_umum=$_POST['sudah_periksa_dokter_umum'];
        }
        if(empty($_POST['hasil_pcr_dokter_umum'])){
            $hasil_pcr_dokter_umum=0;
        }else{
            $hasil_pcr_dokter_umum=$_POST['hasil_pcr_dokter_umum'];
        }
        if(empty($_POST['jumlah_tenaga_dokter_spesialis'])){
            $jumlah_tenaga_dokter_spesialis=0;
        }else{
            $jumlah_tenaga_dokter_spesialis=$_POST['jumlah_tenaga_dokter_spesialis'];
        }
        if(empty($_POST['sudah_periksa_dokter_spesialis'])){
            $sudah_periksa_dokter_spesialis=0;
        }else{
            $sudah_periksa_dokter_spesialis=$_POST['sudah_periksa_dokter_spesialis'];
        }
        if(empty($_POST['hasil_pcr_dokter_spesialis'])){
            $hasil_pcr_dokter_spesialis=0;
        }else{
            $hasil_pcr_dokter_spesialis=$_POST['hasil_pcr_dokter_spesialis'];
        }
        if(empty($_POST['jumlah_tenaga_dokter_gigi'])){
            $jumlah_tenaga_dokter_gigi=0;
        }else{
            $jumlah_tenaga_dokter_gigi=$_POST['jumlah_tenaga_dokter_gigi'];
        }
        if(empty($_POST['sudah_periksa_dokter_gigi'])){
            $sudah_periksa_dokter_gigi=0;
        }else{
            $sudah_periksa_dokter_gigi=$_POST['sudah_periksa_dokter_gigi'];
        }
        if(empty($_POST['hasil_pcr_dokter_gigi'])){
            $hasil_pcr_dokter_gigi=0;
        }else{
            $hasil_pcr_dokter_gigi=$_POST['hasil_pcr_dokter_gigi'];
        }
        if(empty($_POST['jumlah_tenaga_residen'])){
            $jumlah_tenaga_residen=0;
        }else{
            $jumlah_tenaga_residen=$_POST['jumlah_tenaga_residen'];
        }
        if(empty($_POST['sudah_periksa_residen'])){
            $sudah_periksa_residen=0;
        }else{
            $sudah_periksa_residen=$_POST['sudah_periksa_residen'];
        }
        if(empty($_POST['hasil_pcr_residen'])){
            $hasil_pcr_residen=0;
        }else{
            $hasil_pcr_residen=$_POST['hasil_pcr_residen'];
        }
        if(empty($_POST['jumlah_tenaga_perawat'])){
            $jumlah_tenaga_perawat=0;
        }else{
            $jumlah_tenaga_perawat=$_POST['jumlah_tenaga_perawat'];
        }
        if(empty($_POST['sudah_periksa_perawat'])){
            $sudah_periksa_perawat=0;
        }else{
            $sudah_periksa_perawat=$_POST['sudah_periksa_perawat'];
        }
        if(empty($_POST['hasil_pcr_perawat'])){
            $hasil_pcr_perawat=0;
        }else{
            $hasil_pcr_perawat=$_POST['hasil_pcr_perawat'];
        }
        if(empty($_POST['jumlah_tenaga_bidan'])){
            $jumlah_tenaga_bidan=0;
        }else{
            $jumlah_tenaga_bidan=$_POST['jumlah_tenaga_bidan'];
        }
        if(empty($_POST['sudah_periksa_bidan'])){
            $sudah_periksa_bidan=0;
        }else{
            $sudah_periksa_bidan=$_POST['sudah_periksa_bidan'];
        }
        if(empty($_POST['hasil_pcr_bidan'])){
            $hasil_pcr_bidan=0;
        }else{
            $hasil_pcr_bidan=$_POST['hasil_pcr_bidan'];
        }
        if(empty($_POST['jumlah_tenaga_apoteker'])){
            $jumlah_tenaga_apoteker=0;
        }else{
            $jumlah_tenaga_apoteker=$_POST['jumlah_tenaga_apoteker'];
        }
        if(empty($_POST['sudah_periksa_apoteker'])){
            $sudah_periksa_apoteker=0;
        }else{
            $sudah_periksa_apoteker=$_POST['sudah_periksa_apoteker'];
        }
        if(empty($_POST['hasil_pcr_apoteker'])){
            $hasil_pcr_apoteker=0;
        }else{
            $hasil_pcr_apoteker=$_POST['hasil_pcr_apoteker'];
        }
        if(empty($_POST['jumlah_tenaga_radiografer'])){
            $jumlah_tenaga_radiografer=0;
        }else{
            $jumlah_tenaga_radiografer=$_POST['jumlah_tenaga_radiografer'];
        }
        if(empty($_POST['sudah_periksa_radiografer'])){
            $sudah_periksa_radiografer=0;
        }else{
            $sudah_periksa_radiografer=$_POST['sudah_periksa_radiografer'];
        }
        if(empty($_POST['hasil_pcr_radiografer'])){
            $hasil_pcr_radiografer=0;
        }else{
            $hasil_pcr_radiografer=$_POST['hasil_pcr_radiografer'];
        }
        if(empty($_POST['jumlah_tenaga_analis_lab'])){
            $jumlah_tenaga_analis_lab=0;
        }else{
            $jumlah_tenaga_analis_lab=$_POST['jumlah_tenaga_analis_lab'];
        }
        if(empty($_POST['sudah_periksa_analis_lab'])){
            $sudah_periksa_analis_lab=0;
        }else{
            $sudah_periksa_analis_lab=$_POST['sudah_periksa_analis_lab'];
        }
        if(empty($_POST['hasil_pcr_analis_lab'])){
            $hasil_pcr_analis_lab=0;
        }else{
            $hasil_pcr_analis_lab=$_POST['hasil_pcr_analis_lab'];
        }
        if(empty($_POST['jumlah_tenaga_co_ass'])){
            $jumlah_tenaga_co_ass=0;
        }else{
            $jumlah_tenaga_co_ass=$_POST['jumlah_tenaga_co_ass'];
        }
        if(empty($_POST['sudah_periksa_co_ass'])){
            $sudah_periksa_co_ass=0;
        }else{
            $sudah_periksa_co_ass=$_POST['sudah_periksa_co_ass'];
        }
        if(empty($_POST['hasil_pcr_co_ass'])){
            $hasil_pcr_co_ass=0;
        }else{
            $hasil_pcr_co_ass=$_POST['hasil_pcr_co_ass'];
        }
        if(empty($_POST['jumlah_tenaga_internship'])){
            $jumlah_tenaga_internship=0;
        }else{
            $jumlah_tenaga_internship=$_POST['jumlah_tenaga_internship'];
        }
        if(empty($_POST['sudah_periksa_internship'])){
            $sudah_periksa_internship=0;
        }else{
            $sudah_periksa_internship=$_POST['sudah_periksa_internship'];
        }
        if(empty($_POST['hasil_pcr_internship'])){
            $hasil_pcr_internship=0;
        }else{
            $hasil_pcr_internship=$_POST['hasil_pcr_internship'];
        }
        if(empty($_POST['jumlah_tenaga_nakes_lainnya'])){
            $jumlah_tenaga_nakes_lainnya=0;
        }else{
            $jumlah_tenaga_nakes_lainnya=$_POST['jumlah_tenaga_nakes_lainnya'];
        }
        if(empty($_POST['sudah_periksa_nakes_lainnya'])){
            $sudah_periksa_nakes_lainnya=0;
        }else{
            $sudah_periksa_nakes_lainnya=$_POST['sudah_periksa_nakes_lainnya'];
        }
        if(empty($_POST['hasil_pcr_nakes_lainnya'])){
            $hasil_pcr_nakes_lainnya=0;
        }else{
            $hasil_pcr_nakes_lainnya=$_POST['hasil_pcr_nakes_lainnya'];
        }
        if(empty($_POST['rekap_jumlah_tenaga'])){
            $rekap_jumlah_tenaga=0;
        }else{
            $rekap_jumlah_tenaga=$_POST['rekap_jumlah_tenaga'];
        }
        if(empty($_POST['rekap_jumlah_sudah_diperiksa'])){
            $rekap_jumlah_sudah_diperiksa=0;
        }else{
            $rekap_jumlah_sudah_diperiksa=$_POST['rekap_jumlah_sudah_diperiksa'];
        }
        if(empty($_POST['rekap_jumlah_hasil_pcr'])){
            $rekap_jumlah_hasil_pcr=0;
        }else{
            $rekap_jumlah_hasil_pcr=$_POST['rekap_jumlah_hasil_pcr'];
        }
        if(empty($_POST['update_sisrs_online'])){
            $update_sisrs_online="Tidak";
            $status="None";
        }else{
            $update_sisrs_online=$_POST['update_sisrs_online'];
            $status="Syn";
        }
        if (!is_numeric($jumlah_tenaga_dokter_umum)){
            echo "Jumlah Tenga Dokter Umum Hanya Boleh Diisi Angka";
        }else{
            if (!is_numeric($sudah_periksa_dokter_umum)){
                echo "Jumlah Tenga Dokter Umum Hanya Boleh Diisi Angka";
            }else{
                if (!is_numeric($hasil_pcr_dokter_umum)){
                    echo "Jumlah Tenga Dokter Umum Hanya Boleh Diisi Angka";
                }else{
                    if (!is_numeric($jumlah_tenaga_dokter_spesialis)){
                        echo "Jumlah Tenga Dokter Spesialis Hanya Boleh Diisi Angka";
                    }else{
                        if (!is_numeric($sudah_periksa_dokter_spesialis)){
                            echo "Jumlah Tenga Dokter Spesialis Hanya Boleh Diisi Angka";
                        }else{
                            if (!is_numeric($hasil_pcr_dokter_spesialis)){
                                echo "Jumlah Tenga Dokter Spesialis Hanya Boleh Diisi Angka";
                            }else{
                                if (!is_numeric($jumlah_tenaga_dokter_gigi)){
                                    echo "Jumlah Tenga Dokter Gigi Hanya Boleh Diisi Angka";
                                }else{
                                    if (!is_numeric($sudah_periksa_dokter_gigi)){
                                        echo "Jumlah Tenga Dokter Gigi Hanya Boleh Diisi Angka";
                                    }else{
                                        if (!is_numeric($hasil_pcr_dokter_gigi)){
                                            echo "Jumlah Tenga Dokter Gigi Hanya Boleh Diisi Angka";
                                        }else{
                                            if (!is_numeric($jumlah_tenaga_residen)){
                                                echo "Jumlah Tenga Residen Hanya Boleh Diisi Angka";
                                            }else{
                                                if (!is_numeric($sudah_periksa_residen)){
                                                    echo "Jumlah Tenga Residen Hanya Boleh Diisi Angka";
                                                }else{
                                                    if (!is_numeric($hasil_pcr_residen)){
                                                        echo "Jumlah Tenga Residen Hanya Boleh Diisi Angka";
                                                    }else{
                                                        if (!is_numeric($jumlah_tenaga_perawat)){
                                                            echo "Jumlah Tenga Perawat Hanya Boleh Diisi Angka";
                                                        }else{
                                                            if (!is_numeric($sudah_periksa_perawat)){
                                                                echo "Jumlah Tenga Perawat Hanya Boleh Diisi Angka";
                                                            }else{
                                                                if (!is_numeric($hasil_pcr_perawat)){
                                                                    echo "Jumlah Tenga Perawat Hanya Boleh Diisi Angka";
                                                                }else{
                                                                    if (!is_numeric($jumlah_tenaga_bidan)){
                                                                        echo "Jumlah Tenga Bidan Hanya Boleh Diisi Angka";
                                                                    }else{
                                                                        if (!is_numeric($sudah_periksa_bidan)){
                                                                            echo "Jumlah Tenga Bidan Hanya Boleh Diisi Angka";
                                                                        }else{
                                                                            if (!is_numeric($hasil_pcr_bidan)){
                                                                                echo "Jumlah Tenga Bidan Hanya Boleh Diisi Angka";
                                                                            }else{
                                                                                if (!is_numeric($jumlah_tenaga_apoteker)){
                                                                                    echo "Jumlah Tenga Apoteker Hanya Boleh Diisi Angka";
                                                                                }else{
                                                                                    if (!is_numeric($sudah_periksa_apoteker)){
                                                                                        echo "Jumlah Tenga Apoteker Hanya Boleh Diisi Angka";
                                                                                    }else{
                                                                                        if (!is_numeric($hasil_pcr_apoteker)){
                                                                                            echo "Jumlah Tenga Apoteker Hanya Boleh Diisi Angka";
                                                                                        }else{
                                                                                            if (!is_numeric($jumlah_tenaga_radiografer)){
                                                                                                echo "Jumlah Tenga Radiografer Hanya Boleh Diisi Angka";
                                                                                            }else{
                                                                                                if (!is_numeric($sudah_periksa_radiografer)){
                                                                                                    echo "Jumlah Tenga Radiografer Hanya Boleh Diisi Angka";
                                                                                                }else{
                                                                                                    if (!is_numeric($hasil_pcr_radiografer)){
                                                                                                        echo "Jumlah Tenga Radiografer Hanya Boleh Diisi Angka";
                                                                                                    }else{
                                                                                                        if (!is_numeric($jumlah_tenaga_analis_lab)){
                                                                                                            echo "Jumlah Tenga Analis Lab Hanya Boleh Diisi Angka";
                                                                                                        }else{
                                                                                                            if (!is_numeric($sudah_periksa_analis_lab)){
                                                                                                                echo "Jumlah Tenga Analis Lab Hanya Boleh Diisi Angka";
                                                                                                            }else{
                                                                                                                if (!is_numeric($hasil_pcr_analis_lab)){
                                                                                                                    echo "Jumlah Tenga Analis Lab Hanya Boleh Diisi Angka";
                                                                                                                }else{
                                                                                                                    if (!is_numeric($jumlah_tenaga_co_ass)){
                                                                                                                        echo "Jumlah Tenga Co Ass  Hanya Boleh Diisi Angka";
                                                                                                                    }else{
                                                                                                                        if (!is_numeric($sudah_periksa_co_ass)){
                                                                                                                            echo "Jumlah Tenga Co Ass  Hanya Boleh Diisi Angka";
                                                                                                                        }else{
                                                                                                                            if (!is_numeric($hasil_pcr_co_ass)){
                                                                                                                                echo "Jumlah Tenga Co Ass  Hanya Boleh Diisi Angka";
                                                                                                                            }else{
                                                                                                                                if (!is_numeric($jumlah_tenaga_internship)){
                                                                                                                                    echo "Jumlah Tenga Interinship  Hanya Boleh Diisi Angka";
                                                                                                                                }else{
                                                                                                                                    if (!is_numeric($sudah_periksa_internship)){
                                                                                                                                        echo "Jumlah Tenga Interinship  Hanya Boleh Diisi Angka";
                                                                                                                                    }else{
                                                                                                                                        if (!is_numeric($hasil_pcr_internship)){
                                                                                                                                            echo "Jumlah Tenga Interinship  Hanya Boleh Diisi Angka";
                                                                                                                                        }else{
                                                                                                                                            if (!is_numeric($jumlah_tenaga_nakes_lainnya)){
                                                                                                                                                echo "Jumlah Tenga Lainnya  Hanya Boleh Diisi Angka";
                                                                                                                                            }else{
                                                                                                                                                if (!is_numeric($sudah_periksa_nakes_lainnya)){
                                                                                                                                                    echo "Jumlah Tenga Lainnya  Hanya Boleh Diisi Angka";
                                                                                                                                                }else{
                                                                                                                                                    if (!is_numeric($hasil_pcr_nakes_lainnya)){
                                                                                                                                                        echo "Jumlah Tenga Lainnya  Hanya Boleh Diisi Angka";
                                                                                                                                                    }else{
                                                                                                                                                        if (!is_numeric($rekap_jumlah_tenaga)){
                                                                                                                                                            echo "Jumlah Tenga Hanya Boleh Diisi Angka";
                                                                                                                                                        }else{
                                                                                                                                                            if (!is_numeric($rekap_jumlah_sudah_diperiksa)){
                                                                                                                                                                echo "Jumlah Tenga Yang Sudah Diperiksa Hanya Boleh Diisi Angka";
                                                                                                                                                            }else{
                                                                                                                                                                if (!is_numeric($rekap_jumlah_hasil_pcr)){
                                                                                                                                                                    echo "Jumlah Hasil PCR Yang Sudah Diperiksa Hanya Boleh Diisi Angka";
                                                                                                                                                                }else{
                                                                                                                                                                    //Buat Json
                                                                                                                                                                    $data = array(
                                                                                                                                                                        'tanggal' => $tanggal,
                                                                                                                                                                        'jumlah_tenaga_dokter_umum' => $jumlah_tenaga_dokter_umum,
                                                                                                                                                                        'sudah_periksa_dokter_umum' => $sudah_periksa_dokter_umum,
                                                                                                                                                                        'hasil_pcr_dokter_umum' => $hasil_pcr_dokter_umum,
                                                                                                                                                                        'jumlah_tenaga_dokter_spesialis' => $jumlah_tenaga_dokter_spesialis,
                                                                                                                                                                        'sudah_periksa_dokter_spesialis' => $sudah_periksa_dokter_spesialis,
                                                                                                                                                                        'hasil_pcr_dokter_spesialis' => $hasil_pcr_dokter_spesialis,
                                                                                                                                                                        'jumlah_tenaga_dokter_gigi' => $jumlah_tenaga_dokter_gigi,
                                                                                                                                                                        'sudah_periksa_dokter_gigi' => $sudah_periksa_dokter_gigi,
                                                                                                                                                                        'hasil_pcr_dokter_gigi' => $hasil_pcr_dokter_gigi,
                                                                                                                                                                        'jumlah_tenaga_residen' => $jumlah_tenaga_residen,
                                                                                                                                                                        'sudah_periksa_residen' => $sudah_periksa_residen,
                                                                                                                                                                        'hasil_pcr_residen' => $hasil_pcr_residen,
                                                                                                                                                                        'jumlah_tenaga_perawat' => $jumlah_tenaga_perawat,
                                                                                                                                                                        'sudah_periksa_perawat' => $sudah_periksa_perawat,
                                                                                                                                                                        'hasil_pcr_perawat' => $hasil_pcr_perawat,
                                                                                                                                                                        'jumlah_tenaga_bidan' => $jumlah_tenaga_bidan,
                                                                                                                                                                        'sudah_periksa_bidan' => $sudah_periksa_bidan,
                                                                                                                                                                        'hasil_pcr_bidan' => $hasil_pcr_bidan,
                                                                                                                                                                        'jumlah_tenaga_apoteker' => $jumlah_tenaga_apoteker,
                                                                                                                                                                        'sudah_periksa_apoteker' => $sudah_periksa_apoteker,
                                                                                                                                                                        'hasil_pcr_apoteker' => $hasil_pcr_apoteker,
                                                                                                                                                                        'jumlah_tenaga_radiografer' => $jumlah_tenaga_radiografer,
                                                                                                                                                                        'sudah_periksa_radiografer' => $sudah_periksa_radiografer,
                                                                                                                                                                        'hasil_pcr_radiografer' => $hasil_pcr_radiografer,
                                                                                                                                                                        'jumlah_tenaga_analis_lab' => $jumlah_tenaga_analis_lab,
                                                                                                                                                                        'sudah_periksa_analis_lab' => $sudah_periksa_analis_lab,
                                                                                                                                                                        'hasil_pcr_analis_lab' => $hasil_pcr_analis_lab,
                                                                                                                                                                        'jumlah_tenaga_co_ass' => $jumlah_tenaga_co_ass,
                                                                                                                                                                        'sudah_periksa_co_ass' => $sudah_periksa_co_ass,
                                                                                                                                                                        'hasil_pcr_co_ass' => $hasil_pcr_co_ass,
                                                                                                                                                                        'jumlah_tenaga_internship' => $jumlah_tenaga_internship,
                                                                                                                                                                        'sudah_periksa_internship' => $sudah_periksa_internship,
                                                                                                                                                                        'hasil_pcr_internship' => $hasil_pcr_internship,
                                                                                                                                                                        'jumlah_tenaga_nakes_lainnya' => $jumlah_tenaga_nakes_lainnya,
                                                                                                                                                                        'sudah_periksa_nakes_lainnya' => $sudah_periksa_nakes_lainnya,
                                                                                                                                                                        'hasil_pcr_nakes_lainnya' => $hasil_pcr_nakes_lainnya,
                                                                                                                                                                        'rekap_jumlah_tenaga' => $rekap_jumlah_tenaga,
                                                                                                                                                                        'rekap_jumlah_sudah_diperiksa' => $rekap_jumlah_sudah_diperiksa,
                                                                                                                                                                        'rekap_jumlah_hasil_pcr' => $rekap_jumlah_hasil_pcr,
                                                                                                                                                                        'tgllapor' => $tgllapor,
                                                                                                                                                                    );
                                                                                                                                                                    $json_data = json_encode($data);
                                                                                                                                                                    //Buka Pengaturan SIRS Online
                                                                                                                                                                    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
                                                                                                                                                                    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
                                                                                                                                                                    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
                                                                                                                                                                    //Kirim Data
                                                                                                                                                                    $KirimData=PostDataSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'fo/index.php/Pasien/pcr_nakes',$json_data);
                                                                                                                                                                    $response = json_decode($KirimData, true);
                                                                                                                                                                    $status=$response['PCRNakes'][0]['status'];
                                                                                                                                                                    if($status=="200"){
                                                                                                                                                                        $_SESSION['NotifikasiSwal']="Tambah PCR Nakes Berhasil";
                                                                                                                                                                        echo '<span class="text-success" id="NotifikasiTambahPcrNakesBerhasil">Success</span>';
                                                                                                                                                                    }else{
                                                                                                                                                                        echo "$KirimData";
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
                    }
                }
            }
        }
    }

?>