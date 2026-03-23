<?php
    if(empty($_GET['bulan'])){
        $bulan = "01";
    }else{
        $bulan = $_GET['bulan'];
    }

    $select_1 = "btn-secondary";
    $select_2 = "btn-secondary";
    if($bulan=="01"){
        $select_1 = "btn-primary";
        $select_2 = "btn-secondary";
    }else{
        $select_1 = "btn-secondary";
        $select_2 = "btn-primary";
    }

    if($bulan=="01"){
        $keyword = "01/01/2026";
    }else{
        $keyword = "01/02/2026";
    }
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-list"></i> ARUS KAS - TAHUN 2026</a>
                    </h5>
                    <p class="m-b-0">Kelola data arus kas</p>
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
                                    <div class="col-10">
                                        <dt>ARUS KAS - TAHUN 2026</dt>
                                    </div>
                                    <div class="col-1 text-end">
                                        <a href="index.php?Page=Kas&bulan=01" class="btn btn-sm <?php echo $select_1; ?> btn-block">
                                            Januari
                                        </a>
                                    </div>
                                    <div class="col-1 text-end">
                                        <a href="index.php?Page=Kas&bulan=02" class="btn btn-sm <?php echo $select_2; ?> btn-block">
                                            Februari
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <td class="text-center"><dt>No</dt></td>
                                                <td class="text-center"><dt>No.Bukti</dt></td>
                                                <td class="text-center"><dt>Uraian</dt></td>
                                                <td class="text-center"><dt>Akun</dt></td>
                                                <td class="text-center"><dt>No.Akun</dt></td>
                                                <td class="text-center"><dt>Debet</dt></td>
                                                <td class="text-center"><dt>Kredit</dt></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $total_debet = 0;
                                                $total_kredit = 0;
                                                $result_count = mysqli_query($Conn, "SELECT * FROM arus_kas WHERE tanggal='$keyword'");
                                                $jml_data = ($result_count) ? mysqli_num_rows($result_count) : 0;
                                                if(empty($jml_data)){
                                                    echo '
                                                        <tr>
                                                            <td class="text-center" colspan="6">Tidak Ada Data yang Ditampilkan</td>
                                                        </tr>
                                                    ';
                                                }else{
                                                    $no = 1;
                                                    $qry = mysqli_query($Conn, "SELECT * FROM arus_kas WHERE tanggal='$keyword'");
                                                    while ($data = mysqli_fetch_array($qry)) {

                                                        $no_bukti  = $data['no_bukti'];
                                                        $uraian     = $data['uraian'];
                                                        $nama_akun = $data['nama_akun'];
                                                        $no_akun       = $data['no_akun'];

                                                        // Validasi debet
                                                        if(is_numeric($data['debet'])){
                                                            $debet = $data['debet'];
                                                        }else{
                                                            $debet = 0;
                                                        }
                                                        if(is_numeric($data['kredit'])){
                                                            $kredit = $data['kredit'];
                                                        }else{
                                                            $kredit = 0;
                                                        }
                                                        $total_debet = $total_debet+$debet;
                                                        $total_kredit = $total_kredit+$debet;
                                                        echo '
                                                            <tr>
                                                                <td align="center">'.$no.'</td>
                                                                <td align="left">'.$no_bukti.'</td>
                                                                <td align="left">'.$uraian.'</td>
                                                                <td align="left">'.$nama_akun.'</td>
                                                                <td align="left">'.$no_akun.'</td>
                                                                <td align="right">Rp '.number_format($debet, 0, ',', '.').'</td>
                                                                <td align="right">Rp '.number_format($kredit, 0, ',', '.').'</td>
                                                            </tr>
                                                        ';
                                                        $no++;
                                                    }
                                                    echo '
                                                        <tr>
                                                            <td align="center"></td>
                                                            <td align="left"><b>JUMLAH TOTAL</b></td>
                                                            <td align="left"></td>
                                                            <td align="right"></td>
                                                            <td align="center"></td>
                                                            <td align="right">Rp '.number_format($total_debet, 0, ',', '.').'</td>
                                                            <td align="right">Rp '.number_format($total_kredit, 0, ',', '.').'</td>
                                                        </tr>
                                                    ';
                                                    $selisih = $total_debet-$total_kredit;
                                                    echo '
                                                        <tr>
                                                            <td align="center"></td>
                                                            <td align="left"><b>SELISIH</b></td>
                                                            <td align="left"></td>
                                                            <td align="right"></td>
                                                            <td align="center"></td>
                                                            <td align="right">Rp '.number_format($selisih, 0, ',', '.').'</td>
                                                            <td align="right"></td>
                                                        </tr>
                                                    ';
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
