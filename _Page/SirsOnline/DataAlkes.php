<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'APzGdlAT7w');
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
                                        <i class="icofont-search-document"></i> Data Alkes Menurut SIRS Online
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="table table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <td align="center"><dt>ID</dt></td>
                                                    <td align="center"><dt>Kebutuhan</dt></td>
                                                    <td align="center"><dt>Eksisting</dt></td>
                                                    <td align="center"><dt>Jumlah</dt></td>
                                                    <td align="center"><dt>Diterima</dt></td>
                                                    <td align="center"><dt>Update</dt></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $DataAlkes=DataAlkesSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'GET');
                                                    $php_array = json_decode($DataAlkes, true);
                                                    $ListAlkes=$php_array['apd'];
                                                    $JumlahData=count($ListAlkes);
                                                    if(empty($JumlahData)){
                                                        echo '<tr>';
                                                        echo '  <td align="center" colspan="3">Tidak ada data yang ditampilkan. <br>Keterangan: '.$php_array.'</td>';
                                                        echo '</tr>';
                                                    }else{
                                                        $no=1;
                                                        foreach ($ListAlkes as $item) {
                                                            // Tambahkan setiap elemen ke dalam array PHP
                                                            $id_kebutuhan= $item['id_kebutuhan'];
                                                            $kebutuhan= $item['kebutuhan'];
                                                            $jumlah_eksisting= $item['jumlah_eksisting'];
                                                            $jumlah= $item['jumlah'];
                                                            $jumlah_diterima= $item['jumlah_diterima'];
                                                            
                                                            //Format Tanggal
                                                            if(!empty($item['tglupdate'])){
                                                                $tglupdate= $item['tglupdate'];
                                                                $strtotime=strtotime($tglupdate);
                                                                $tglupdate=date('d/m/Y',$strtotime);
                                                            }else{
                                                                $tglupdate="";
                                                            }
                                                            echo '<tr>';
                                                            echo '  <td align="center">'.$id_kebutuhan.'</td>';
                                                            echo '  <td align="left">'.$kebutuhan.'</td>';
                                                            echo '  <td align="center">'.$jumlah_eksisting.'</td>';
                                                            echo '  <td align="center">'.$jumlah.'</td>';
                                                            echo '  <td align="center">'.$jumlah_diterima.'</td>';
                                                            echo '  <td align="left">'.$tglupdate.'</td>';
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