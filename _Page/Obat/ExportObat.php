<?php
    //Connection
    include "../../_Config/Connection.php";
    if(empty($_POST['kategori'])){
        $kategori="";
    }else{
        $kategori=$_POST['kategori'];
    }
    if(empty($_POST['satuan'])){
        $satuan="";
    }else{
        $satuan=$_POST['satuan'];
    }
    if(empty($_POST['keyword_by'])){
        $keyword_by="";
    }else{
        $keyword_by=$_POST['keyword_by'];
    }
    if(empty($_POST['OrderBy'])){
        $OrderBy="id_obat";
    }else{
        $OrderBy=$_POST['OrderBy'];
    }
    if(empty($_POST['ShortBy'])){
        $ShortBy="ASC";
    }else{
        $ShortBy=$_POST['ShortBy'];
    }
    if(empty($_POST['format'])){
        $format="HTML";
    }else{
        $format=$_POST['format'];
    }
    if(empty($_POST['keyword'])){
        $keyword="";
    }else{
        $keyword=$_POST['keyword'];
    }
    if(empty($keyword_by)){
        if(empty($keyword)){
            if(empty($kategori)){
                if(empty($satuan)){
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE satuan='$satuan'"));
                }
            }else{
                if(empty($satuan)){
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE kategori='$kategori'"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE kategori='$kategori' AND satuan='$satuan'"));
                }
            }
        }else{
            if(empty($kategori)){
                if(empty($satuan)){
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE kode like '%$keyword%' OR nama_obat like '%$keyword%' OR kategori like '%$keyword%' OR satuan like '%$keyword%'"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE (satuan='$satuan') AND (kode like '%$keyword%' OR nama_obat like '%$keyword%' OR kategori like '%$keyword%' OR satuan like '%$keyword%')"));
                }
            }else{
                if(empty($satuan)){
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE (kategori='$kategori') AND (kode like '%$keyword%' OR nama_obat like '%$keyword%' OR kategori like '%$keyword%' OR satuan like '%$keyword%')"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE (kategori='$kategori' AND satuan='$satuan') AND (kode like '%$keyword%' OR nama_obat like '%$keyword%' OR kategori like '%$keyword%' OR satuan like '%$keyword%')"));
                }
            }
        }
    }else{
        if(empty($keyword)){
            if(empty($kategori)){
                if(empty($satuan)){
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE satuan='$satuan'"));
                }
            }else{
                if(empty($satuan)){
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE kategori='$kategori'"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE kategori='$kategori' AND satuan='$satuan'"));
                }
            }
        }else{
            if(empty($kategori)){
                if(empty($satuan)){
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE $keyword_by like '%$keyword%'"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE (satuan='$satuan') AND ($keyword_by like '%$keyword%')"));
                }
            }else{
                if(empty($satuan)){
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE (kategori='$kategori') AND ($keyword_by like '%$keyword%')"));
                }else{
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE (kategori='$kategori' AND satuan='$satuan') AND ($keyword_by like '%$keyword%')"));
                }
            }
        }
    }
    if($format=="Excel"){
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=DataObat.xls");
    }else{
        if($format=="PDF"){
            //koneksi dan error
            $FileName= "DataObat";
            //Config Plugin MPDF
            require_once '../../vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf();
            ob_start(); 
        }
    }
?>
<html>
    <head>
        <style type="text/css">
            @page {
                margin-top: <?php echo "20 mm"; ?>;
                margin-bottom: <?php echo "20 mm"; ?>;
                margin-left: <?php echo "20 mm"; ?>;
                margin-right: <?php echo "20 mm"; ?>;
            }
            body {
                background-color: #FFF;
                font-family: Arial;
            }
            table.data tr td {
                border: 1px solid #666;
                font-size: 12px;
                color:#333;
                border-spacing: 0px;
                padding: 4px;
            }
            table.data{
                border-spacing: 0px;
            }
            table tr td {
                border: 1px solid #666;
                font-size: 12px;
                color: #000;
                border-spacing: 0px;
            }
        </style>
        <title>Cetak Obat</title>
    </head>
    <body>
        <table class="data" width="100%">
            <tr>
                <td align="center"><b>No</b></td>
                <td align="center"><b>Kode</b></td>
                <td align="center"><b>Nama Obat</b></td>
                <td align="center"><b>Kategori</b></td>
                <td align="center"><b>Satuan</b></td>
                <td align="center"><b>Isi</b></td>
                <td align="center"><b>Stok</b></td>
                <td align="center"><b>Harga Beli</b></td>
                <td align="center"><b>Harga Eceran</b></td>
                <td align="center"><b>Harga Grosir</b></td>
                <td align="center"><b>Harga Medis</b></td>
                <td align="center"><b>Stok Minimum</b></td>
                <td align="center"><b>Last Update</b></td>
            </tr>
            <?php
                if(empty($jml_data)){
                    echo '<tr>';
                    echo '  <td align="center" colspan="13"><b>Tidak Ada Data yang Ditampilkan</b></td>';
                    echo '</tr>';
                }else{
                    $no = 1;
                    //KONDISI PENGATURAN MASING FILTER
                    if(empty($keyword_by)){
                        if(empty($keyword)){
                            if(empty($kategori)){
                                if(empty($satuan)){
                                    $query = mysqli_query($Conn, "SELECT*FROM obat ORDER BY $OrderBy $ShortBy");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE satuan='$satuan' ORDER BY $OrderBy $ShortBy");
                                }
                            }else{
                                if(empty($satuan)){
                                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE kategori='$kategori' ORDER BY $OrderBy $ShortBy");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE kategori='$kategori' AND satuan='$satuan' ORDER BY $OrderBy $ShortBy");
                                }
                            }
                        }else{
                            if(empty($kategori)){
                                if(empty($satuan)){
                                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE kode like '%$keyword%' OR nama_obat like '%$keyword%' OR kategori like '%$keyword%' OR satuan like '%$keyword%' ORDER BY $OrderBy $ShortBy");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE satuan='$satuan' AND (kode like '%$keyword%' OR nama_obat like '%$keyword%' OR kategori like '%$keyword%' OR satuan like '%$keyword%') ORDER BY $OrderBy $ShortBy");
                                }
                            }else{
                                if(empty($satuan)){
                                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE kategori='$kategori' AND (kode like '%$keyword%' OR nama_obat like '%$keyword%' OR kategori like '%$keyword%' OR satuan like '%$keyword%') ORDER BY $OrderBy $ShortBy");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE (kategori='$kategori' AND satuan='$satuan') AND (kode like '%$keyword%' OR nama_obat like '%$keyword%' OR kategori like '%$keyword%' OR satuan like '%$keyword%') ORDER BY $OrderBy $ShortBy");
                                }
                            }
                        }
                    }else{
                        if(empty($keyword)){
                            if(empty($kategori)){
                                if(empty($satuan)){
                                    $query = mysqli_query($Conn, "SELECT*FROM obat ORDER BY $OrderBy $ShortBy");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE satuan='$satuan' ORDER BY $OrderBy $ShortBy");
                                }
                            }else{
                                if(empty($satuan)){
                                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE kategori='$kategori' ORDER BY $OrderBy $ShortBy");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE kategori='$kategori' AND satuan='$satuan' ORDER BY $OrderBy $ShortBy");
                                }
                            }
                        }else{
                            if(empty($kategori)){
                                if(empty($satuan)){
                                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE satuan='$satuan' AND ($keyword_by like '%$keyword%') ORDER BY $OrderBy $ShortBy");
                                }
                            }else{
                                if(empty($satuan)){
                                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE kategori='$kategori' AND ($keyword_by like '%$keyword%') ORDER BY $OrderBy $ShortBy");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM obat WHERE (kategori='$kategori' AND satuan='$satuan') AND ($keyword_by like '%$keyword%') ORDER BY $OrderBy $ShortBy");
                                }
                            }
                        }
                    }
                    while ($data = mysqli_fetch_array($query)) {
                        $id_obat= $data['id_obat'];
                        $kode= $data['kode'];
                        $nama_obat= $data['nama_obat'];
                        $kategori= $data['kategori'];
                        $satuan= $data['satuan'];
                        $stok= $data['stok'];
                        $isi= $data['isi'];
                        $harga_1= $data['harga_1'];
                        $harga_2= $data['harga_2'];
                        $harga_3= $data['harga_3'];
                        $harga_4= $data['harga_4'];
                        $stok_min= $data['stok_min'];
                        $updatetime= $data['updatetime'];
                        echo '<tr>';
                        echo '  <td align="center">'.$no.'</td>';
                        echo '  <td align="left">'.$kode.'</td>';
                        echo '  <td align="left">'.$nama_obat.'</td>';
                        echo '  <td align="left">'.$kategori.'</td>';
                        echo '  <td align="left">'.$satuan.'</td>';
                        echo '  <td align="left">'.$isi.'</td>';
                        echo '  <td align="left">'.$stok.'</td>';
                        echo '  <td align="left">'.$harga_1.'</td>';
                        echo '  <td align="left">'.$harga_2.'</td>';
                        echo '  <td align="left">'.$harga_3.'</td>';
                        echo '  <td align="left">'.$harga_4.'</td>';
                        echo '  <td align="left">'.$stok_min.'</td>';
                        echo '  <td align="left">'.$updatetime.'</td>';
                        echo '</tr>';
                        $no++;
                    }
                }
            ?>
        </table>
    </body>
</html>
<?php
 if($format=="PDF"){
    $html = ob_get_contents();
    ob_end_clean();
    $mpdf->WriteHTML(utf8_encode($html));
    $mpdf->Output($FileName.".pdf" ,'I');
    exit;
}
?>