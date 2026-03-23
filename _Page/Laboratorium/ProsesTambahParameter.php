<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['parameter'])){
        echo '<span class="text-danger">Parameter Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['kategori_parameter'])){
            echo '<span class="text-danger">Kategori Parameter Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['tipe_data'])){
                echo '<span class="text-danger">Tipe Data Tidak Boleh Kosong</span>';
            }else{
                $parameter=$_POST['parameter'];
                $kategori_parameter=$_POST['kategori_parameter'];
                $tipe_data=$_POST['tipe_data'];
                if(empty($_POST['nilai_kritis'])){
                    $nilai_kritis="";
                }else{
                    $nilai_kritis=$_POST['nilai_kritis'];
                }
                if(empty($_POST['nilai_rujukan'])){
                    $nilai_rujukan="";
                }else{
                    $nilai_rujukan=$_POST['nilai_rujukan'];
                }
                if(empty($_POST['satuan'])){
                    $satuan="";
                }else{
                    $satuan=$_POST['satuan'];
                }
                if(empty($_POST['keterangan'])){
                    $keterangan="";
                }else{
                    $keterangan=$_POST['keterangan'];
                }
                if(empty($_POST['alternatif'])){
                    $alternatif="";
                }else{
                    $alternatif=$_POST['alternatif'];
                    $JumlahAlternatif=count($alternatif);
                    $list = array();
                    for($x=0;$x<$JumlahAlternatif;$x++){
                        $h['alternatif']=$alternatif[$x];
                        array_push($list, $h);
                    }
                    $alternatif=json_encode($list);
                }
                //simpan  data
                $ValidasiDuplikatData=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_parameter WHERE parameter='$parameter' AND kategori_parameter='$kategori_parameter'"));
                if(!empty($ValidasiDuplikatData)){
                    echo '<span class="text-danger">Data Tersebut Sudah Ada</span>';
                }else{
                    //Menyimpan Data Radiologi
                    $entry="INSERT INTO laboratorium_parameter (
                        parameter,
                        kategori_parameter,
                        tipe_data,
                        alternatif,
                        nilai_rujukan,
                        nilai_kritis,
                        satuan,
                        keterangan
                    )VALUES (
                        '$parameter',
                        '$kategori_parameter',
                        '$tipe_data',
                        '$alternatif',
                        '$nilai_rujukan',
                        '$nilai_kritis',
                        '$satuan',
                        '$keterangan'
                    )";
                    $hasil=mysqli_query($Conn, $entry);
                    if($hasil){
                        //menyimpan Log
                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Parameter","Laboratorium",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            $_SESSION['NotifikasiSwal']="Tambah Parameter Berhasil";
                            echo '<span class="text-success" id="NotifikasiTambahParameterBerhasil">Success</span>';
                        }else{
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                        }
                    }else{
                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Data!</span>';
                    }
                }
            }
        }
    }
?>