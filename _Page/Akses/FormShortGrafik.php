<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    if(empty($_POST['id_akses'])){
        echo 'ID Akses Tidak Boleh Kosong!';
    }else{
        $id_akses=$_POST['id_akses'];
?>
    <input type="hidden" name="id_akses" id="id_akses" value="<?php echo "$id_akses"; ?>">
    <div class="row">
        <div class="col-md-3 mb-3">
            <select name="kategori_log" id="kategori_log" class="form-control">
                <option value="">Semua</option>
                <?php
                    $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM log ORDER BY kategori ASC");
                    while ($Datakategori = mysqli_fetch_array($QryKategori)) {
                        $KategoriList= $Datakategori['kategori'];
                        echo '<option value="'.$KategoriList.'">'.$KategoriList.'</option>';
                    }
                ?>
            </select>
            <small for="kategori">Kategori Log</small>
        </div>
        <div class="col-md-2 mb-3">
            <select name="periode_grafik" id="periode_grafik" class="form-control">
                <option value="">Pilih</option>
                <option value="Tahunan">Tahunan</option>
                <option value="Bulanan">Bulanan</option>
            </select>
            <small for="periode_grafik">Periode Data</small>
        </div>
        <div class="col-md-2 mb-3">
            <select name="tahun_grafik" id="tahun_grafik" class="form-control">
                <option value="">Pilih</option>
                <?php
                    $a=2010;
                    $b=date('Y');
                    for ( $i =$a; $i<=$b; $i++ ){
                        if($i==date('Y')){
                            echo '<option selected value="'.$i.'">'.$i.'</option>';
                        }else{
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                ?>
            </select>
            <small for="tahun_grafik">Tahun</small>
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
                        if($BulanNomor==date('m')){
                            echo '<option selected value="'.$BulanNomor.'">'. $NamaBulan.'</option>';
                        }else{
                            echo '<option value="'.$BulanNomor.'">'. $NamaBulan.'</option>';
                        }
                    }
                ?>
            </select>
            <small for="bulan_grafik">Bulan</small>
        </div>
        <div class="col-md-3 mb-3">
            <button type="submit" class="btn btn-md btn-block btn-inverse">
                Generate
            </button>
        </div>
    </div>
<?php } ?>