<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'Sh43jR5XM9');
    if($StatusAkses=="Yes"){
        include "_Config/SimrsFunction.php";
        //Buka Pengaturan SIRS Online
        $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
        $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
        $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
        //Panggil Fungsi
        include "_Config/FungsiSirsOnline.php";
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
                                        <i class="icofont-search-document"></i> Referensi Jenis Ruangan Menurut SIRS Online
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="table table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <td align="center"><dt>No</dt></td>
                                                    <td align="center"><dt>Kode</dt></td>
                                                    <td align="center"><dt>Nama Tempat Tidur</dt></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $response_referensi=ReferensiTtSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'GET');
                                                    $php_array = json_decode($response_referensi, true);
                                                    $ReferensiTt=$php_array['tempat_tidur'];
                                                    $JumlahData=count($ReferensiTt);
                                                    if(empty($JumlahData)){
                                                        echo '<tr>';
                                                        echo '  <td align="center" colspan="3">Tidak ada data yang ditampilkan. <br>Keterangan: '.$php_array.'</td>';
                                                        echo '</tr>';
                                                    }else{
                                                        $no=1;
                                                        foreach ($ReferensiTt as $item) {
                                                            // Tambahkan setiap elemen ke dalam array PHP
                                                            $kode_tt= $item['kode_tt'];
                                                            $nama_tt= $item['nama_tt'];
                                                            echo '<tr>';
                                                            echo '  <td align="center">'.$no.'</td>';
                                                            echo '  <td align="center">'.$kode_tt.'</td>';
                                                            echo '  <td>'.$nama_tt.'</td>';
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