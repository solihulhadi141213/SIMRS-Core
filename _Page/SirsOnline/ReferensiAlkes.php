<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'BbugxfZCXj');
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
                                        <i class="icofont-search-document"></i> Referensi Alkes Menurut SIRS Online
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="table table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <td align="center"><dt>No</dt></td>
                                                    <td align="center"><dt>ID</dt></td>
                                                    <td align="center"><dt>Nama Kebutuhan</dt></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $response_referensi=ReferensiAlkesSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'GET');
                                                    $php_array = json_decode($response_referensi, true);
                                                    $ReferensiAlkesSirsOnline=$php_array['kebutuhan_apd'];
                                                    $JumlahData=count($ReferensiAlkesSirsOnline);
                                                    if(empty($JumlahData)){
                                                        echo '<tr>';
                                                        echo '  <td align="center" colspan="3">Tidak ada data yang ditampilkan. <br>Keterangan: '.$php_array.'</td>';
                                                        echo '</tr>';
                                                    }else{
                                                        $no=1;
                                                        foreach ($ReferensiAlkesSirsOnline as $item) {
                                                            // Tambahkan setiap elemen ke dalam array PHP
                                                            $id_kebutuhan= $item['id_kebutuhan'];
                                                            $kebutuhan= $item['kebutuhan'];
                                                            echo '<tr>';
                                                            echo '  <td align="center">'.$no.'</td>';
                                                            echo '  <td align="center">'.$id_kebutuhan.'</td>';
                                                            echo '  <td align="left">'.$kebutuhan.'</td>';
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