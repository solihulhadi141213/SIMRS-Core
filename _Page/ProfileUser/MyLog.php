<?php
    if(empty($_POST['kategori_log'])){
        $kategori_log="";
    }else{
        $kategori_log=$_POST['kategori_log'];
    }
    if(empty($_POST['periode_grafik'])){
        $periode_grafik="Tahunan";
    }else{
        $periode_grafik=$_POST['periode_grafik'];
    }
    if(empty($_POST['tahun_grafik'])){
        $tahun_grafik=date('Y');
    }else{
        $tahun_grafik=$_POST['tahun_grafik'];
    }
    if(empty($_POST['bulan_grafik'])){
        $bulan_grafik=date('m');
    }else{
        $bulan_grafik=$_POST['bulan_grafik'];
    }
?>

<div class="row">
    <div class="col-md-8 mb-3">
        <div class="card">
            <div class="card-header">
                <form action="index.php?Page=ProfileUser&Sub=MyLog" method="POST">
                    <div class="row mb-3">
                        <div class="col col-md-12">
                            <h4><i class="ti ti-bar-chart"></i> Grafik Aktivitas</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <select name="kategori_log" id="kategori_log" class="form-control">
                                <?php
                                    if(empty($kategori_log)){
                                        echo '<option selected value="">Semua</option>';
                                    }else{
                                        echo '<option value="">Semua</option>';
                                    }
                                    $QryKategoriList = mysqli_query($Conn, "SELECT DISTINCT kategori FROM log WHERE id_akses='$SessionIdAkses' ORDER BY kategori ASC");
                                    while ($DatakategoriList = mysqli_fetch_array($QryKategoriList)) {
                                        $KategoriList= $DatakategoriList['kategori'];
                                        if($KategoriList==$kategori_log){
                                            echo '<option selected value="'.$kategori_log.'">'.$kategori_log.'</option>';
                                        }else{
                                            echo '<option value="'.$KategoriList.'">'.$KategoriList.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <select name="periode_grafik" id="periode_grafik" class="form-control">
                                <option <?php if($periode_grafik=="Tahunan"){echo "selected";} ?> value="Tahunan">Tahunan</option>
                                <option <?php if($periode_grafik=="Bulanan"){echo "selected";} ?> value="Bulanan">Bulanan</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <select name="tahun_grafik" id="tahun_grafik" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    $a=2010;
                                    $b=date('Y');
                                    for ( $i =$a; $i<=$b; $i++ ){
                                        if($i==$tahun_grafik){
                                            echo '<option selected value="'.$i.'">'.$i.'</option>';
                                        }else{
                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <select name="bulan_grafik" id="bulan_grafik" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    $a=1;
                                    $b=12;
                                    for ( $i =$a; $i<=$b; $i++ ){
                                        //Zero pading
                                        $BulanNomor = sprintf("%02d", $i);
                                        $BulanList = array(
                                            '01' => 'Januari',
                                            '02' => 'Februari',
                                            '03' => 'Maret',
                                            '04' => 'April',
                                            '05' => 'Mei',
                                            '06' => 'Juni',
                                            '07' => 'Juli',
                                            '08' => 'Agustus',
                                            '09' => 'September',
                                            '10' => 'Oktober',
                                            '11' => 'November',
                                            '12' => 'Desember',
                                        );
                                        $NamaBulan=$BulanList[$BulanNomor];
                                        if($BulanNomor==$bulan_grafik){
                                            echo '<option selected value="'.$BulanNomor.'">'. $NamaBulan.'</option>';
                                        }else{
                                            echo '<option value="'.$BulanNomor.'">'. $NamaBulan.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col col-md-3 mb-3">
                            <button type="submit" class="btn btn-sm btn-block btn-outline-secondary"> <i class="ti-search"></i> Go</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12"  id="TampilkanGrafik">

                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 table table-responsive"  id="TampilkanRekapLog">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header">
                <form action="javascript:void(0);" id="BatasPencarian">
                    <div class="row mb-3">
                        <div class="col col-md-12">
                            <h4><i class="ti-time"></i> Log Aktivitas</h4>
                        </div>
                    </div>
                    <div class="row">
                        <!-- <div class="col-md-3 mb-3">
                            <select name="batas" id="batas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <small>Batas</small>
                        </div> -->
                        <div class="col col-md-12">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                                <button type="submit" class="btn btn-sm btn-outline-secondary"> <i class="ti-search"></i> Go</button>
                            </div>
                            
                        </div>
                    </div>
                </form>
            </div>
            <div id="MenampilkanTabelLog">
                <!----  Menampilkan Tabel Log---->
            </div>
        </div>
    </div>
</div>