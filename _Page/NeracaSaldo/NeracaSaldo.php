<?php
    if(empty($_GET['tahun'])){
        $tahun = "2023";
    }else{
        $tahun = $_GET['tahun'];
    }

    $select_1 = "btn-secondary";
    $select_2 = "btn-secondary";
    $select_3 = "btn-secondary";
    if($tahun=="2023"){
        $select_1 = "btn-primary";
        $select_2 = "btn-secondary";
        $select_3 = "btn-secondary";
    }
    if($tahun=="2024"){
        $select_1 = "btn-secondary";
        $select_2 = "btn-primary";
        $select_3 = "btn-secondary";
    }
     if($tahun=="2025"){
        $select_1 = "btn-secondary";
        $select_2 = "btn-secondary";
        $select_3 = "btn-primary";
    }
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-list"></i> Neraca Saldo</a>
                    </h5>
                    <p class="m-b-0">Kelola referensi fitur, entitas akses, akses user dan pengajuan akses</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-9">
                                        <dt>Neraca Saldo</dt>
                                    </div>
                                    <div class="col-1 text-end">
                                        <a href="index.php?Page=NeracaSaldo&tahun=2023" class="btn btn-sm <?php echo $select_1; ?> btn-block">
                                            2023
                                        </a>
                                    </div>
                                    <div class="col-1 text-end">
                                        <a href="index.php?Page=NeracaSaldo&tahun=2024" class="btn btn-sm <?php echo $select_2; ?> btn-block">
                                            2024
                                        </a>
                                    </div>
                                    <div class="col-1 text-end">
                                        <a href="index.php?Page=NeracaSaldo&tahun=2025" class="btn btn-sm <?php echo $select_3; ?> btn-block">
                                            2025
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <td class="text-center" colspan="2"><dt>No</dt></td>
                                                <td class="text-center" colspan="2"><dt>Nama Akun</dt></td>
                                                <td class="text-center"><dt>Saldo</dt></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $saldo = 0;
                                                $result_count = mysqli_query($Conn, "SELECT * FROM neraca_saldo");
                                                $jml_data = ($result_count) ? mysqli_num_rows($result_count) : 0;
                                                if(empty($jml_data)){
                                                    echo '
                                                        <tr>
                                                            <td class="text-center" colspan="5">Tidak Ada Data yang Ditampilkan</td>
                                                        </tr>
                                                    ';
                                                }else{
                                                    $no_x = 1;

                                                    $query_x = mysqli_query($Conn, "SELECT DISTINCT kategori FROM neraca_saldo ORDER BY kode ASC");
                                                     while ($query_x && $data_x = mysqli_fetch_array($query_x)) {
                                                        $kategori= $data_x['kategori'];
                                                        echo '
                                                            <tr>
                                                                <td class="text-center"><dt>'.$no_x.'</dt></td>
                                                                <td class="text-left" colspan="4"><dt>'.$kategori.'</dt></td>
                                                            </tr>
                                                        ';

                                                        $no= 1;
                                                        $query = mysqli_query($Conn, "SELECT DISTINCT akun_1 FROM neraca_saldo WHERE level='1' AND kategori='$kategori'");
                                                        if(!$query){
                                                            echo '
                                                                <tr>
                                                                    <td class="text-center" colspan="5">Gagal memuat data neraca saldo</td>
                                                                </tr>
                                                            ';
                                                        }
                                                        while ($query && $data = mysqli_fetch_array($query)) {
                                                            $akun_1= $data['akun_1'];
                                                            echo '
                                                                <tr>
                                                                    <td class="text-center"></td>
                                                                    <td class="text-center"><dt>'.$no_x.'. '.$no.'</dt></td>
                                                                    <td class="text-left" colspan="4"><dt>'.$akun_1.'</dt></td>
                                                                </tr>
                                                            ';
                                                            $no2= 1;
                                                            $jumlah_per_unit = 0;
                                                            $query2 = mysqli_query($Conn, "SELECT * FROM neraca_saldo WHERE level='2' AND akun_1='$akun_1' AND kategori='$kategori'");
                                                            while ($data2 = mysqli_fetch_array($query2)) {
                                                                $akun_2= $data2['akun_2'];
                                                                $saldo_raw = "0";
                                                                if($tahun=="2023"){
                                                                    $saldo_raw = $data2['tahun_2023'];
                                                                }
                                                                if($tahun=="2024"){
                                                                    $saldo_raw = $data2['tahun_2024'];
                                                                }
                                                                if($tahun=="2025"){
                                                                    $saldo_raw = $data2['tahun_2025'];
                                                                }
                                                                // Kolom saldo bertipe varchar, jadi bersihkan dulu agar aman dihitung.
                                                                $saldo = preg_replace('/[^0-9\\-]/', '', (string)$saldo_raw);
                                                                if($saldo==='' || $saldo==='-'){
                                                                    $saldo = 0;
                                                                }else{
                                                                    $saldo = (int)$saldo;
                                                                }
                                                                $jumlah_per_unit = $jumlah_per_unit + $saldo;

                                                                echo '
                                                                    <tr>
                                                                        <td class="text-center"></td>
                                                                        <td class="text-center"></td>
                                                                        <td class="text-center">'.$no_x.'.'.$no.'.'.$no2.'</td>
                                                                        <td class="text-left">'.$akun_2.'</td>
                                                                        <td class="text-right">Rp '.number_format($saldo, 0, ',', '.').'</td>
                                                                    </tr>
                                                                ';
                                                                $no2++;
                                                            }
                                                            echo '
                                                                <tr>
                                                                    <td class="text-center"><dt></dt></td>
                                                                    <td class="text-right" colspan="3"><dt>JUMLAH</dt></td>
                                                                    <td class="text-right"><dt>Rp '.number_format($jumlah_per_unit, 0, ',', '.').'</dt></td>
                                                                </tr>
                                                            ';
                                                            $no++;
                                                        }
                                                        $no_x++;
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
