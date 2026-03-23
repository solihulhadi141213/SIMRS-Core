<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    $jumlah_total_rp = "0";
    //Batas
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas=100;
    }

    //Tahun
    if(!empty($_POST['tahun'])){
        $tahun=$_POST['tahun'];
    }else{
        $tahun="2023";
    }

    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ($page - 1) * $batas;
    }else{
        $page=1;
        $posisi = 0;
    }

    //Hitung jumlah data
    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT tahun FROM persediaan_tahunan WHERE tahun='$tahun'"));
    
    // Jika Data Tidak Ada
    if(empty($jml_data)){
        echo '
            <tr>
                <td colspan="7" class="text-center">Tidak Ada Data Yang Ditampilkan</td>
            </tr>
        ';
        exit;
    }

    //Mengatur Halaman
    $JmlHalaman = ceil($jml_data/$batas);
    $no = 1 + $posisi;

    // =========================
    // TOTAL SELURUH DATA
    // =========================
    $query_total = mysqli_query($Conn,"
        SELECT SUM(
            (CASE WHEN qty REGEXP '^[0-9]+$' THEN qty ELSE 0 END) *
            (CASE WHEN harga REGEXP '^[0-9]+$' THEN harga ELSE 0 END)
        ) AS total_all
        FROM persediaan_tahunan 
        WHERE tahun='$tahun'
    ");
    $data_total = mysqli_fetch_assoc($query_total);
    $total = $data_total['total_all'];

    // =========================
    // DATA PER HALAMAN
    // =========================
    $query = mysqli_query($Conn, "SELECT * FROM persediaan_tahunan WHERE tahun='$tahun' LIMIT $posisi,$batas");

    while ($data = mysqli_fetch_array($query)) {

        $kategori    = $data['kategori'];
        $nama_barang = $data['nama_barang'];
        $satuan      = $data['satuan'];

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

        echo '
            <tr>
                <td align="center">'.$no.'</td>
                <td align="left">'.$nama_barang.'</td>
                <td align="left">'.$kategori.'</td>
                <td align="right">Rp '.number_format($harga,0,",",".").'</td>
                <td align="center">'.$qty.'</td>
                <td align="center">'.$satuan.'</td>
                <td align="right">Rp '.number_format($jumlah,0,",",".").'</td>
            </tr>
        ';
        $no++;
    }

    echo '
        <tr class="border-top border-1 border-double border-dark">
            <td></td>
            <td colspan="5"><dt>JUMLAH TOTAL SEMUA HALAMAN</dt></td>
            <td align="right"><dt class="text text-underline">Rp '.number_format($total,0,",",".").'</dt></td>
        </tr>
    ';
    $jumlah_total_rp = number_format($total,0,",",".");
?>

<script>
    var jumlah_total="<?php echo $jumlah_total_rp; ?>";
    var periode=<?php echo $tahun; ?>;
    var page_count=<?php echo $JmlHalaman; ?>;
    var curent_page=<?php echo $page; ?>;

    $('#periode_data').html('PEDIODE TAHUN '+periode+'');
    $('#JumlahTotal').html('Rp '+jumlah_total+'');
    
    $('.page_info').html('Page '+curent_page+' / '+page_count+'');

    if(curent_page==1){
        $('.preview_button').prop('disabled', true);
    }else{
        $('.preview_button').prop('disabled', false);
    }

    if(page_count<=curent_page){
        $('.next_button').prop('disabled', true);
    }else{
        $('.next_button').prop('disabled', false);
    }
</script>