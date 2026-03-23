<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap kode
    if(empty($_POST['kode'])){
        $SubtotalSemua=0;
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center text-danger">';
        echo '      Kode Transaksi Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $kode=$_POST['kode'];
        $DataRincianTransaksi=getDataDetail($Conn,'transaksi_rincian','kode',$kode,'kode');
        if(empty($DataRincianTransaksi)){
            $SubtotalSemua=0;
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center text-danger">';
            echo '      Belum Ada Data Rincian Transaksi';
            echo '  </div>';
            echo '</div>';
        }else{

?>
            <div class="row sub-title mb-4">
                <div class="col-md-12 bg-light">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-dark">
                                <tr>
                                    <th><dt class="text-light">No</dt></th>
                                    <th><dt class="text-light">Uraian</dt></th>
                                    <th><dt class="text-light">Harga/QTY</dt></th>
                                    <th><dt class="text-light">PPN/DISC</dt></th>
                                    <th><dt class="text-light">Jumlah</dt></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $JumlahObat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE kode='$kode' AND kategori='Obat'"));
                                    $JumlahTindakan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE kode='$kode' AND kategori='Tindakan'"));
                                    $JumlahLainnya = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE kode='$kode' AND kategori='Lainnya'"));
                                    if(!empty($JumlahObat)){
                                        //LIST OBAT
                                        echo '<tr class="bg-secondary">';
                                        echo '  <td colspan="5"><dt class="text-light">A. RINCIAN OBAT</dt></td>';
                                        echo '</tr>';
                                        $no = 1;
                                        $SubtotalObat=0;
                                        $query = mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE kode='$kode' AND kategori='Obat'");
                                        while ($data = mysqli_fetch_array($query)) {
                                            $id_rincian= $data['id_rincian'];
                                            $nama= $data['nama'];
                                            $qty= $data['qty'];
                                            $satuan= $data['satuan'];
                                            $harga= $data['harga'];
                                            $ppn= $data['ppn'];
                                            $diskon= $data['diskon'];
                                            $jumlah= $data['jumlah'];
                                            $klaim= $data['klaim'];
                                            $SubtotalObat=$SubtotalObat+$jumlah;
                                            //Routing Klaim
                                            if($klaim=="UMUM"){
                                                $LabelKlaim='<small class="text-secondary">'.$klaim.'</small>';
                                            }else{
                                                $LabelKlaim='<small class="text-info">'.$klaim.'</small>';
                                            }
                                            //Format Rupiah
                                            $FormatHarga = "" . number_format($harga, 0, ',', '.');
                                            $FormatPpn = "" . number_format($ppn, 0, ',', '.');
                                            $FormatDiskon = "" . number_format($diskon, 0, ',', '.');
                                            $FormatJumlah = "" . number_format($jumlah, 0, ',', '.');
                                            //List Tabel
                                            echo '<tr>';
                                            echo '  <td class="text-center">'.$no.'</td>';
                                            echo '  <td>';
                                            echo '      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditRincian" data-id="'.$id_rincian.'">';
                                            echo '          '.$nama.' <i class="ti ti-pencil"></i>';
                                            echo '      </a><br>';
                                            echo '      Kalim : '.$LabelKlaim.'';
                                            echo '  </td>';
                                            echo '  <td>';
                                            echo '      Harga : '.$FormatHarga.'<br>';
                                            echo '      <small class="text-secondary">QTY: '.$qty.' '.$satuan.'</small>';
                                            echo '  </td>';
                                            echo '  <td>';
                                            echo '      <span class="text-secondary">PPN : '.$FormatPpn.'</span><br>';
                                            echo '      <span class="text-secondary">Diskon : '.$FormatDiskon.'</span>';
                                            echo '  </td>';
                                            echo '  <td align="right">';
                                            echo '      <span class="text-dark">'.$FormatJumlah.'</span><br>';
                                            echo '      <a href="javascript:void(0);" class="text-danger" data-toggle="modal" data-target="#ModalHapusRincian" data-id="'.$id_rincian.'">';
                                            echo '          <small><i class="ti ti-close"></i> Hapus</small>';
                                            echo '      </a>';
                                            echo '  </td>';
                                            echo '</tr>';
                                            $no++;
                                        }
                                        $FormatSubtotalObat= "" . number_format($SubtotalObat, 0, ',', '.');
                                        echo '<tr>';
                                        echo '  <td colspan="4" align="right"><dt>SUBTOTAL TINDAKAN</dt></td>';
                                        echo '  <td align="right"><dt>'.$FormatSubtotalObat.'</dt></td>';
                                        echo '</tr>';
                                    }else{
                                        $SubtotalObat=0;
                                    }
                                    if(!empty($JumlahTindakan)){
                                        echo '<tr class="bg-secondary">';
                                        echo '  <td colspan="5"><dt class="text-light">B. RINCIAN TINDAKAN</dt></td>';
                                        echo '</tr>';
                                        //LIST TINDAKAN
                                        $no = 1;
                                        $SubtotalTindakan=0;
                                        $query = mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE kode='$kode' AND kategori='Tindakan'");
                                        while ($data = mysqli_fetch_array($query)) {
                                            $id_rincian= $data['id_rincian'];
                                            $nama= $data['nama'];
                                            $qty= $data['qty'];
                                            $satuan= $data['satuan'];
                                            $harga= $data['harga'];
                                            $ppn= $data['ppn'];
                                            $diskon= $data['diskon'];
                                            $jumlah= $data['jumlah'];
                                            $klaim= $data['klaim'];
                                            $SubtotalTindakan=$SubtotalTindakan+$jumlah;
                                            //Routing Klaim
                                            if($klaim=="UMUM"){
                                                $LabelKlaim='<small class="text-secondary">'.$klaim.'</small>';
                                            }else{
                                                $LabelKlaim='<small class="text-info">'.$klaim.'</small>';
                                            }
                                            //Format Rupiah
                                            $FormatHarga = "" . number_format($harga, 0, ',', '.');
                                            $FormatPpn = "" . number_format($ppn, 0, ',', '.');
                                            $FormatDiskon = "" . number_format($diskon, 0, ',', '.');
                                            $FormatJumlah = "" . number_format($jumlah, 0, ',', '.');
                                            //List Tabel
                                            echo '<tr>';
                                            echo '  <td class="text-center">'.$no.'</td>';
                                            echo '  <td>';
                                            echo '      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditRincian" data-id="'.$id_rincian.'">';
                                            echo '          '.$nama.' <i class="ti ti-pencil"></i>';
                                            echo '      </a><br>';
                                            echo '      Kalim : '.$LabelKlaim.'';
                                            echo '  </td>';
                                            echo '  <td>';
                                            echo '      Harga : '.$FormatHarga.'<br>';
                                            echo '      <small class="text-secondary">QTY: '.$qty.' '.$satuan.'</small>';
                                            echo '  </td>';
                                            echo '  <td>';
                                            echo '      <span class="text-secondary">PPN : '.$FormatPpn.'</span><br>';
                                            echo '      <span class="text-secondary">Diskon : '.$FormatDiskon.'</span>';
                                            echo '  </td>';
                                            echo '  <td align="right">';
                                            echo '      <span class="text-dark">'.$FormatJumlah.'</span><br>';
                                            echo '      <a href="javascript:void(0);" class="text-danger" data-toggle="modal" data-target="#ModalHapusRincian" data-id="'.$id_rincian.'">';
                                            echo '          <small><i class="ti ti-close"></i> Hapus</small>';
                                            echo '      </a>';
                                            echo '  </td>';
                                            echo '</tr>';
                                            $no++;
                                        }
                                        $FormatSubtotalTindakan= "" . number_format($SubtotalTindakan, 0, ',', '.');
                                        echo '<tr>';
                                        echo '  <td colspan="4" align="right"><dt>SUBTOTAL OBAT</dt></td>';
                                        echo '  <td align="right"><dt>'.$FormatSubtotalTindakan.'</dt></td>';
                                        echo '</tr>';
                                    }else{
                                        $SubtotalTindakan=0;
                                    }
                                    if(!empty($JumlahLainnya)){
                                        //LIST LAINNYA
                                        echo '<tr class="bg-secondary">';
                                        echo '  <td colspan="5"><dt class="text-light">C. RINCIAN LAINNYA</dt></td>';
                                        echo '</tr>';
                                        $no = 1;
                                        $SubtotalLainnya=0;
                                        $query = mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE kode='$kode' AND kategori='Lainnya'");
                                        while ($data = mysqli_fetch_array($query)) {
                                            $id_rincian= $data['id_rincian'];
                                            $nama= $data['nama'];
                                            $qty= $data['qty'];
                                            $satuan= $data['satuan'];
                                            $harga= $data['harga'];
                                            $ppn= $data['ppn'];
                                            $diskon= $data['diskon'];
                                            $jumlah= $data['jumlah'];
                                            $klaim= $data['klaim'];
                                            $SubtotalLainnya=$SubtotalLainnya+$jumlah;
                                            //Routing Klaim
                                            if($klaim=="UMUM"){
                                                $LabelKlaim='<small class="text-secondary">'.$klaim.'</small>';
                                            }else{
                                                $LabelKlaim='<small class="text-info">'.$klaim.'</small>';
                                            }
                                            //Format Rupiah
                                            $FormatHarga = "" . number_format($harga, 0, ',', '.');
                                            $FormatPpn = "" . number_format($ppn, 0, ',', '.');
                                            $FormatDiskon = "" . number_format($diskon, 0, ',', '.');
                                            $FormatJumlah = "" . number_format($jumlah, 0, ',', '.');
                                            //List Tabel
                                            echo '<tr>';
                                            echo '  <td class="text-center">'.$no.'</td>';
                                            echo '  <td>';
                                            echo '      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalEditRincian" data-id="'.$id_rincian.'">';
                                            echo '          '.$nama.' <i class="ti ti-pencil"></i>';
                                            echo '      </a><br>';
                                            echo '      Kalim : '.$LabelKlaim.'';
                                            echo '  </td>';
                                            echo '  <td>';
                                            echo '      Harga : '.$FormatHarga.'<br>';
                                            echo '      <small class="text-secondary">QTY: '.$qty.' '.$satuan.'</small>';
                                            echo '  </td>';
                                            echo '  <td>';
                                            echo '      <span class="text-secondary">PPN : '.$FormatPpn.'</span><br>';
                                            echo '      <span class="text-secondary">Diskon : '.$FormatDiskon.'</span>';
                                            echo '  </td>';
                                            echo '  <td align="right">';
                                            echo '      <span class="text-dark">'.$FormatJumlah.'</span><br>';
                                            echo '      <a href="javascript:void(0);" class="text-danger" data-toggle="modal" data-target="#ModalHapusRincian" data-id="'.$id_rincian.'">';
                                            echo '          <small><i class="ti ti-close"></i> Hapus</small>';
                                            echo '      </a>';
                                            echo '  </td>';
                                            echo '</tr>';
                                            $no++;
                                        }
                                        $FormatSubtotalLainnya= "" . number_format($SubtotalLainnya, 0, ',', '.');
                                        echo '<tr>';
                                        echo '  <td colspan="4" align="right"><dt>SUBTOTAL LAINNYA</dt></td>';
                                        echo '  <td align="right"><dt>'.$FormatSubtotalLainnya.'</dt></td>';
                                        echo '</tr>';
                                    }else{
                                        $SubtotalLainnya=0;
                                    }
                                    $SubtotalSemua=$SubtotalObat+$SubtotalTindakan+$SubtotalLainnya;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
<?php
        }
    }
?>
<div class="row mt-4 sub-title">
    <div class="col-md-12 mb-3">
        <dt>
            <i class="icofont-mathematical-alt-1"></i> Akumulasi
        </dt>
    </div>
</div>
<div class="row">
    <div class="col-md-4 mb-3">SUBTOTAL</div>
    <div class="col-md-8 mb-3">
        <input type="text" name="subtotal" id="SubtotalAkumulasi" class="form-control" value="<?php echo "$SubtotalSemua"; ?>">
    </div>
</div>
<div class="row">
    <div class="col-md-4 mb-3">PPN</div>
    <div class="col-md-8 mb-3">
        <input type="text" name="ppn" id="PpnAkumulasi" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-4 mb-3">DISKON</div>
    <div class="col-md-8 mb-3">
        <input type="text" name="diskon" id="DiskonAkumulasi" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-4 mb-3">TOTAL</div>
    <div class="col-md-8 mb-3">
        <input type="text" name="total" id="TotalAkumulasi" class="form-control" value="<?php echo "$SubtotalSemua"; ?>">
    </div>
</div>
<script>
    //Ketika Mengetik Subtotal
    $( '#SubtotalAkumulasi' ).mask('000.000.000.000.000', {reverse: true});
    $( '#PpnAkumulasi' ).mask('000.000.000.000.000', {reverse: true});
    $( '#DiskonAkumulasi' ).mask('000.000.000.000.000', {reverse: true});
    $( '#TotalAkumulasi' ).mask('000.000.000.000.000', {reverse: true});

    //Ketika DiskonRincian Persen Diubah
    $('#SubtotalAkumulasi').keyup(function(){
        //Tangkap Harga Dan QTY
        var SubtotalAkumulasi =$('#SubtotalAkumulasi').val();
        var PpnAkumulasi =$('#PpnAkumulasi').val();
        var DiskonAkumulasi =$('#DiskonAkumulasi').val();
        //Menampilkan rupiah Diskon
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Transaksi/HitungTotalAkumulasi.php',
            data 	    :  {subtotal: SubtotalAkumulasi, ppn: PpnAkumulasi, diskon: DiskonAkumulasi},
            success     : function(data){
                $('#TotalAkumulasi').val(data);
            }
        });
    });
    //Ketika PpnAkumulasi Diubah
    $('#PpnAkumulasi').keyup(function(){
        //Tangkap Harga Dan QTY
        var SubtotalAkumulasi =$('#SubtotalAkumulasi').val();
        var PpnAkumulasi =$('#PpnAkumulasi').val();
        var DiskonAkumulasi =$('#DiskonAkumulasi').val();
        //Menampilkan rupiah Diskon
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Transaksi/HitungTotalAkumulasi.php',
            data 	    :  {subtotal: SubtotalAkumulasi, ppn: PpnAkumulasi, diskon: DiskonAkumulasi},
            success     : function(data){
                $('#TotalAkumulasi').val(data);
            }
        });
    });
    //Ketika DiskonAkumulasi Diubah
    $('#DiskonAkumulasi').keyup(function(){
        //Tangkap Harga Dan QTY
        var SubtotalAkumulasi =$('#SubtotalAkumulasi').val();
        var PpnAkumulasi =$('#PpnAkumulasi').val();
        var DiskonAkumulasi =$('#DiskonAkumulasi').val();
        //Menampilkan rupiah Diskon
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Transaksi/HitungTotalAkumulasi.php',
            data 	    :  {subtotal: SubtotalAkumulasi, ppn: PpnAkumulasi, diskon: DiskonAkumulasi},
            success     : function(data){
                $('#TotalAkumulasi').val(data);
            }
        });
    });
</script>