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
                if(empty($_POST['id_laboratorium_parameter'])){
                    echo '<span class="text-danger">ID Parameter Tidak Boleh Kosong</span>';
                }else{
                    $id_laboratorium_parameter=$_POST['id_laboratorium_parameter'];
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
                    $UpdateParameter= mysqli_query($Conn,"UPDATE laboratorium_parameter SET 
                        parameter='$parameter',
                        kategori_parameter='$kategori_parameter',
                        tipe_data='$tipe_data',
                        alternatif='$alternatif',
                        nilai_rujukan='$nilai_rujukan',
                        nilai_kritis='$nilai_kritis',
                        satuan='$satuan',
                        keterangan='$keterangan'
                    WHERE id_laboratorium_parameter='$id_laboratorium_parameter'") or die(mysqli_error($Conn));
                    if($UpdateParameter){
                        //menyimpan Log
                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Parameter","Laboratorium",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            echo '<span class="text-success" id="NotifikasiEditParameterLaboratoriumBerhasil">Success</span>';
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