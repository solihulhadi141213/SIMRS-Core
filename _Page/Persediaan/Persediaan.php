<?php
    if(empty($_GET['grup'])){
        $grup = "Alkes";
    }else{
        $grup = $_GET['grup'];
    }

    $select_1 = "btn-secondary";
    $select_2 = "btn-secondary";
    if($grup=="Alkes"){
        $select_1 = "btn-primary";
        $select_2 = "btn-secondary";
    }else{
        $select_1 = "btn-secondary";
        $select_2 = "btn-primary";
    }

    if($grup=="Alkes"){
        $keyword = "Obat dan Alkes";
    }else{
        $keyword = "Logistik";
    }
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-list"></i> Persediaan - Maret 2026</a>
                    </h5>
                    <p class="m-b-0">Kelola data persediaan Obat, Alkes Dan Logistik</p>
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
                                        <dt>PERSEDIAAN</dt>
                                    </div>
                                    <div class="col-1 text-end">
                                        <a href="index.php?Page=Persediaan&grup=Alkes" class="btn btn-sm <?php echo $select_1; ?> btn-block">
                                            Obat Dan Alkes
                                        </a>
                                    </div>
                                    <div class="col-1 text-end">
                                        <a href="index.php?Page=Persediaan&grup=Logistik" class="btn btn-sm <?php echo $select_2; ?> btn-block">
                                            Logistik
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
                                                <td class="text-center"><dt>Nama Barang</dt></td>
                                                <td class="text-center"><dt>Kategori</dt></td>
                                                <td class="text-center"><dt>Harga + PPN</dt></td>
                                                <td class="text-center"><dt>QTY</dt></td>
                                                <td class="text-center"><dt>Satuan</dt></td>
                                                <td class="text-center"><dt>Jumlah</dt></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $total = 0;
                                                $result_count = mysqli_query($Conn, "SELECT * FROM persediaan WHERE group_barang='$keyword'");
                                                $jml_data = ($result_count) ? mysqli_num_rows($result_count) : 0;
                                                if(empty($jml_data)){
                                                    echo '
                                                        <tr>
                                                            <td class="text-center" colspan="6">Tidak Ada Data yang Ditampilkan</td>
                                                        </tr>
                                                    ';
                                                }else{
                                                    $no = 1;
                                                    $qry = mysqli_query($Conn, "SELECT * FROM persediaan WHERE group_barang='$keyword' ORDER BY nama_barang ASC");
                                                    while ($data = mysqli_fetch_array($qry)) {

                                                        $nama_barang  = $data['nama_barang'];
                                                        $kategori     = $data['kategori'];
                                                        $group_barang = $data['group_barang'];
                                                        $satuan       = $data['satuan'];

                                                        // Validasi QTY
                                                        if(is_numeric($data['qty'])){
                                                            $qty = $data['qty'];
                                                        }else{
                                                            $qty = 0;
                                                        }

                                                        // Validasi Harga
                                                        if(is_numeric($data['harga'])){
                                                            $harga = $data['harga'];
                                                        }else{
                                                            $harga = 0;
                                                        }

                                                        $jumlah = $qty * $harga;
                                                        $total = $total + $jumlah;
                                                        echo '
                                                            <tr>
                                                                <td align="center">'.$no.'</td>
                                                                <td align="left">'.$nama_barang.'</td>
                                                                <td align="left">'.$kategori.'</td>
                                                                <td align="right">Rp '.number_format($harga, 0, ',', '.').'</td>
                                                                <td align="center">'.$qty.'</td>
                                                                <td align="center">'.$satuan.'</td>
                                                                <td align="right">Rp '.number_format($jumlah, 0, ',', '.').'</td>
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
                                                            <td align="center"></td>
                                                            <td align="right">Rp '.number_format($total, 0, ',', '.').'</td>
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
