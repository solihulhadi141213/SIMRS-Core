<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    if(empty($_POST['id_tt'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
        echo '      ID Tempat Tidur Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_tt=$_POST['id_tt'];
        //Buka detail pengaturan
        $response_referensi=DataTtSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'GET');
        if(empty($response_referensi)){
            echo '<div class="row">';
            echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
            echo '      Tidak ada response dari SIRS Online <br>Keterangan: '.$response_referensi.'';
            echo '  </div>';
            echo '</div>';
        }else{
            $php_array = json_decode($response_referensi, true);
            $ReferensiTt=$php_array['fasyankes'];
            $JumlahData=count($ReferensiTt);
            if(empty($JumlahData)){
                echo '<div class="row">';
                echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
                echo '      Tidak ada yang ditampilkan dari SIRS Online <br>Keterangan: '.$response_referensi.'';
                echo '  </div>';
                echo '</div>';
            }else{
                foreach ($ReferensiTt as $item) {
                    // Tambahkan setiap elemen ke dalam array PHP
                    $IdTtList= $item['id_tt'];
                    if($IdTtList==$id_tt){
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
                            $LabelTglUpdate=date('d/m/Y H:i:s',$strtotime);
                        }else{
                            $strtotime="";
                            $LabelTglUpdate='<span class="text-danger">Tidak Ada</span>';
                        }
                        //Cari Kelas dari SIMRS yang sudah di sinkronisasikan
                        $id_ruang_rawat_sirs=getDataDetail($Conn,'ruang_rawat_sirs','id_tt',$id_tt,'id_ruang_rawat_sirs');
                        $id_ruang_rawat=getDataDetail($Conn,'ruang_rawat_sirs','id_tt',$id_tt,'id_ruang_rawat');
                        
?>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="id_tt">DI TT</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="id_tt" id="id_tt" class="form-control" value="<?php echo $IdTtList; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="id_t_tt">DI Record</label>
        </div>
        <div class="col-md-8">
            <input type="text" readonly name="id_t_tt" id="id_t_tt" class="form-control" value="<?php echo $id_t_tt; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <label for="ruang">Rekapitulasi Tempat Tidur Ruangan</label>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center"><dt>No</dt></th>
                            <th class="text-center"><dt>Ruangan</dt></th>
                            <th class="text-center"><dt>Bed</dt></th>
                            <th class="text-center"><dt>Terisi</dt></th>
                            <th class="text-center"><dt>Kosong</dt></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $TotalBed=0;
                            $TotalPasien=0;
                            $TotalKosong=0;
                            $query1 = mysqli_query($Conn, "SELECT*FROM ruang_rawat_sirs WHERE id_tt='$id_tt'");
                            while ($data1 = mysqli_fetch_array($query1)) {
                                $id_ruang_rawat  = $data1['id_ruang_rawat'];
                                //Buka Nama Kelas
                                $kodekelas=getDataDetail($Conn,'ruang_rawat','id_ruang_rawat',$id_ruang_rawat,'kodekelas');
                                $kelas=getDataDetail($Conn,'ruang_rawat','id_ruang_rawat',$id_ruang_rawat,'kelas');
                                $JumlahRuangan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kodekelas='$kodekelas' AND kategori='ruangan'"));
                                if(empty($JumlahRuangan)){
                                    echo '<tr>';
                                    echo '  <td class="text-center" colspan="5">Tidak ada data ruangan untuk kelas ini</td>';
                                    echo '</tr>';
                                }else{
                                    echo '<tr>';
                                    echo '  <td class="text-center"><dt>'.$kodekelas.'</dt></td>';
                                    echo '  <td class="text-left" colspan="4"><dt>'.$kelas.'</dt></td>';
                                    echo '</tr>';
                                    $no=1;
                                    $query2 = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='ruangan' AND kelas='$kelas'");
                                    while ($data2 = mysqli_fetch_array($query2)) {
                                        $ruangan  = $data2['ruangan'];
                                        $JumlahBed = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE ruangan='$ruangan' AND kategori='bed'"));
                                        $JumlahPasien = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE ruangan='$ruangan' AND status!='Pulang'"));
                                        $JumlahKosong=$JumlahBed-$JumlahPasien;
                                        $TotalBed=$JumlahBed+$TotalBed;
                                        $TotalPasien=$JumlahPasien+$TotalPasien;
                                        $TotalKosong=$JumlahKosong+$TotalKosong;
                                        echo '<tr>';
                                        echo '  <td class="text-center">'.$no.'</td>';
                                        echo '  <td class="text-left">'.$ruangan.'</td>';
                                        echo '  <td class="text-right">'.$JumlahBed.'</td>';
                                        echo '  <td class="text-right">'.$JumlahPasien.'</td>';
                                        echo '  <td class="text-right">'.$JumlahKosong.'</td>';
                                        echo '</tr>';
                                        $no++;
                                    }
                                }
                            }
                            echo '<tr>';
                            echo '  <td class="text-left"></td>';
                            echo '  <td class="text-left"><dt>JUMLAH TOTAL</dt></td>';
                            echo '  <td class="text-right"><dt>'.$TotalBed.'</dt></td>';
                            echo '  <td class="text-right"><dt>'.$TotalPasien.'</dt></td>';
                            echo '  <td class="text-right"><dt>'.$TotalKosong.'</dt></td>';
                            echo '</tr>';
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="jumlah">Jumlah Bed</label>
        </div>
        <div class="col-md-8">
            <input ttype="number" min="0" name="jumlah" id="jumlah" class="form-control" value="<?php echo $TotalBed; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="terpakai">Jumlah Terpakai</label>
        </div>
        <div class="col-md-8">
            <input type="text" min="0" name="terpakai" id="terpakai" class="form-control" value="<?php echo $TotalPasien; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="terpakai_suspek">Terpakai Suspek</label>
        </div>
        <div class="col-md-8">
            <input type="text" min="0" name="terpakai_suspek" id="terpakai_suspek" class="form-control" value="<?php echo $terpakai_suspek; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="terpakai_konfirmasi">Terpakai Konfirmasi</label>
        </div>
        <div class="col-md-8">
            <input type="text" min="0" name="terpakai_konfirmasi" id="terpakai_konfirmasi" class="form-control" value="<?php echo $terpakai_konfirmasi; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="antrian">Antrian</label>
        </div>
        <div class="col-md-8">
            <input type="text" min="0" name="antrian" id="antrian" class="form-control" value="<?php echo $antrian; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="prepare">Prepare</label>
        </div>
        <div class="col-md-8">
            <input type="text" min="0" name="prepare" id="prepare" class="form-control" value="<?php echo $prepare; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="prepare_plan">Prepare Plan</label>
        </div>
        <div class="col-md-8">
            <input type="text" min="0" name="prepare_plan" id="prepare_plan" class="form-control" value="<?php echo $prepare_plan; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="covid">Prepare Plan</label>
        </div>
        <div class="col-md-8">
            <input type="text" min="0" name="covid" id="covid" class="form-control" value="<?php echo $covid; ?>">
        </div>
    </div>
<?php }}}}} ?>