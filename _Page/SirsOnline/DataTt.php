<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'PAp18idUFM');
    if($StatusAkses=="Yes"){
        include "_Config/SimrsFunction.php";
        include "_Config/FungsiSirsOnline.php";
        //Buka Pengaturan SIRS Online
        $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
        $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
        $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
?>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <div class="card mb-2">
                                <div class="card-header">
                                    <h4>
                                        <i class="icofont-search-document"></i> Data Tempat Tidur Pada Fasyankes Menurut SIRS Online
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="table table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <td align="center"><dt>No</dt></td>
                                                    <td align="center"><dt>TT</dt></td>
                                                    <td align="center"><dt>Ruang</dt></td>
                                                    <td align="center"><dt>Uraian</dt></td>
                                                    <td align="center"><dt>Antrian</dt></td>
                                                    <td align="center"><dt>Covid</dt></td>
                                                    <td align="center"><dt>Update</dt></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $response_referensi=DataTtSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'GET');
                                                    $php_array = json_decode($response_referensi, true);
                                                    $ReferensiTt=$php_array['fasyankes'];
                                                    $JumlahData=count($ReferensiTt);
                                                    if(empty($JumlahData)){
                                                        echo '<tr>';
                                                        echo '  <td align="center" colspan="3">Tidak ada data yang ditampilkan. <br>Keterangan: '.$php_array.'</td>';
                                                        echo '</tr>';
                                                    }else{
                                                        $no=1;
                                                        foreach ($ReferensiTt as $item) {
                                                            // Tambahkan setiap elemen ke dalam array PHP
                                                            $id_tt= $item['id_tt'];
                                                            $tt= $item['tt'];
                                                            $ruang= $item['ruang'];
                                                            $kode_siranap= $item['kode_siranap'];
                                                            $jumlah_ruang= $item['jumlah_ruang'];
                                                            $jumlah= $item['jumlah'];
                                                            $terpakai= $item['terpakai'];
                                                            $terpakai_suspek= $item['terpakai_suspek'];
                                                            $terpakai_konfirmasi= $item['terpakai_konfirmasi'];
                                                            $antrian= $item['antrian'];
                                                            $prepare= $item['prepare'];
                                                            $prepare_plan= $item['prepare_plan'];
                                                            $kosong= $item['kosong'];
                                                            $covid= $item['covid'];
                                                            $id_t_tt= $item['id_t_tt'];
                                                            $tglupdate= $item['tglupdate'];
                                                            if(!empty($ruang)){
                                                                $DataRuang = explode("," , $ruang);
                                                                $JumlahRuang=count($DataRuang);
                                                            }else{
                                                                $DataRuang ="";
                                                                $JumlahRuang=0;
                                                            }
                                                            if(!empty($tglupdate)){
                                                                $strtotime=strtotime($tglupdate);
                                                                $tglupdate=date('d/m/Y H:i:s',$strtotime);
                                                            }else{
                                                                $strtotime="";
                                                                $tglupdate="None";
                                                            }
                                                            
                                                            echo '<tr>';
                                                            echo '  <td align="center">'.$id_tt.'</td>';
                                                            echo '  <td>';
                                                            echo '      '.$tt.'<br>';
                                                            echo '      <small>Jmlh Ruangan : '.$jumlah_ruang.'</small><br>';
                                                            echo '      <small>Kode Siranap : '.$kode_siranap.'</small><br>';
                                                            echo '      <small>ID : '.$id_t_tt.'</small><br>';
                                                            echo '  </td>';
                                                            echo '  <td>';
                                                            if(empty($JumlahRuang)){
                                                                echo '<small>None</small>';
                                                            }else{
                                                                echo "List Ruangan:<br>";
                                                                for ($i=0; $i< $JumlahRuang; $i++) {
                                                                    $NamaRuangan=$DataRuang[$i];
                                                                    echo '<small>- '.$NamaRuangan.'</small><br>';
                                                                }
                                                            }
                                                            echo '  </td>';
                                                            echo '  <td>';
                                                            echo '      <small>Jmlh : '.$jumlah.'</small><br>';
                                                            echo '      <small>Terpakai : '.$terpakai.'</small><br>';
                                                            echo '      <small title="Terpakai Suspek">Sus : '.$terpakai_suspek.'</small><br>';
                                                            echo '      <small title="Terpakai Konfirmasi">Knf : '.$terpakai_konfirmasi.'</small><br>';
                                                            echo '  </td>';
                                                            echo '  <td>';
                                                            echo '      <small>Antrian : '.$antrian.'</small><br>';
                                                            echo '      <small>Periapan : '.$prepare.'</small><br>';
                                                            echo '      <small>Rencana : '.$prepare_plan.'</small><br>';
                                                            echo '      <small>Kosong : '.$kosong.'</small><br>';
                                                            echo '  </td>';
                                                            echo '  <td>'.$covid.'</td>';
                                                            echo '  <td><small>'.$tglupdate.'</small></td>';
                                                            echo '</tr>';
                                                            $no++;
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    }else{
        include "_Page/UnPage/ErrorPageSub.php";
    }
?>