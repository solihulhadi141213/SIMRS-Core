<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_transaksi
    if(empty($_POST['id_transaksi'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center text-danger">';
        echo '      ID Transaksi Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_transaksi=$_POST['id_transaksi'];
        $kode=getDataDetail($Conn,'transaksi','id_transaksi',$id_transaksi,'kode');
        if(empty($kode)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center text-danger">';
            echo '      ID Transaksi Tersebut Tidak Valid Atau Tidak Terdaftar!';
            echo '  </div>';
            echo '</div>';
        }else{
            //Buka data Transaksi
            $transaksi=getDataDetail($Conn,'transaksi','id_transaksi',$id_transaksi,'transaksi');
            $tanggal=getDataDetail($Conn,'transaksi','id_transaksi',$id_transaksi,'tanggal');
            $nama_akses=getDataDetail($Conn,'transaksi','id_transaksi',$id_transaksi,'nama_akses');
            $id_supplier=getDataDetail($Conn,'transaksi','id_transaksi',$id_transaksi,'id_supplier');
            $nama_supplier=getDataDetail($Conn,'transaksi','id_transaksi',$id_transaksi,'nama_supplier');
            $id_pasien=getDataDetail($Conn,'transaksi','id_transaksi',$id_transaksi,'id_pasien');
            $nama_pasien=getDataDetail($Conn,'transaksi','id_transaksi',$id_transaksi,'nama_pasien');
            $id_kunjungan=getDataDetail($Conn,'transaksi','id_transaksi',$id_transaksi,'id_kunjungan');
            $nama_dokter=getDataDetail($Conn,'transaksi','id_transaksi',$id_transaksi,'nama_dokter');
            $subtotal=getDataDetail($Conn,'transaksi','id_transaksi',$id_transaksi,'subtotal');
            $ppn=getDataDetail($Conn,'transaksi','id_transaksi',$id_transaksi,'ppn');
            $diskon=getDataDetail($Conn,'transaksi','id_transaksi',$id_transaksi,'diskon');
            $status=getDataDetail($Conn,'transaksi','id_transaksi',$id_transaksi,'status');
            $kunci=getDataDetail($Conn,'transaksi','id_transaksi',$id_transaksi,'kunci');
            $catatan=getDataDetail($Conn,'transaksi','id_transaksi',$id_transaksi,'catatan');
            $updatetime=getDataDetail($Conn,'transaksi','id_transaksi',$id_transaksi,'updatetime');
            //Format
            if(!empty($diskon)){
                $DiskonFormat = "Rp " . number_format($diskon, 0, ',', '.');
            }else{
                $DiskonFormat ="0";
            }
            if(!empty($ppn)){
                $PpnFormat = "Rp " . number_format($ppn, 0, ',', '.');
            }else{
                $PpnFormat ="0";
            }
            if(!empty($subtotal)){
                $SubtotalFormat = "Rp " . number_format($subtotal, 0, ',', '.');
            }else{
                $SubtotalFormat ="0";
            }
            //Format Tanggal
            $strtotime=strtotime($tanggal);
            $strtotime2=strtotime($updatetime);
            $TanggalFormat=date('d/m/Y H:i:s T',$strtotime);
            $UpdatetimeFormat=date('d/m/Y H:i:s T',$strtotime2);
            //Routing Transaksi
            if($transaksi=="Pemasukan"){
                $LabelTransaksi='<span class="text-success">'.$transaksi.'</span>';
            }else{
                $LabelTransaksi='<span class="text-danger">'.$transaksi.'</span>';
            }
            //Routing Status
            if($status=="Lunas"){
                $LabelStatus='<span class="text-success">'.$status.'</span>';
            }else{
                $LabelStatus='<span class="text-danger">'.$status.'</span>';
            }
            //Hitung Ketersediaan Jurnal
            $JumlahJurnal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jurnal WHERE kode='$kode'"));
?>
    <div class="row sub-title">
        <div class="col col-md-3">Kode Transaksi</div>
        <div class="col col-md-9"><?php echo '<span class="text-secondary">'.$kode.'</span>';?></div>
    </div>
    <div class="row sub-title">
        <div class="col col-md-3">Kategori</div>
        <div class="col col-md-9"><?php echo ''.$LabelTransaksi.'';?></div>
    </div>
    <div class="row sub-title">
        <div class="col col-md-3">Tanggal</div>
        <div class="col col-md-9"><?php echo '<span class="text-secondary">'.$TanggalFormat.'</span>';?></div>
    </div>
    <div class="row sub-title">
        <div class="col col-md-3">Update Terakhir</div>
        <div class="col col-md-9"><?php echo '<span class="text-secondary">'.$UpdatetimeFormat.'</span>';?></div>
    </div>
    <?php
        if(!empty($id_pasien)){
            if(!empty($nama_pasien)){
                echo '<div class="row sub-title">';
                echo '  <div class="col col-md-3">No.RM</div>';
                echo '  <div class="col col-md-9"><span class="text-secondary">'.$id_pasien.'</span></div>';
                echo '</div>';
                if(!empty($id_kunjungan)){
                    echo '<div class="row sub-title">';
                    echo '  <div class="col col-md-3">No.REG</div>';
                    echo '  <div class="col col-md-9"><span class="text-secondary">'.$id_kunjungan.'</span></div>';
                    echo '</div>';
                }
                echo '<div class="row sub-title">';
                echo '  <div class="col col-md-3">Nama Pasien</div>';
                echo '  <div class="col col-md-9"><span class="text-secondary">'.$nama_pasien.'</span></div>';
                echo '</div>';
            }
        }
        if(!empty($nama_dokter)){
            echo '<div class="row sub-title">';
            echo '  <div class="col col-md-3">Dokter BPJP</div>';
            echo '  <div class="col col-md-9"><span class="text-secondary">'.$nama_dokter.'</span></div>';
            echo '</div>';
        }
        if(!empty($id_supplier)){
            if(!empty($nama_supplier)){
                echo '<div class="row sub-title">';
                echo '  <div class="col col-md-3">Supplier</div>';
                echo '  <div class="col col-md-9"><span class="text-secondary">'.$nama_supplier.'</span></div>';
                echo '</div>';
            }
        }
    ?>
    <div class="row sub-title">
        <div class="col col-md-3">Petugas</div>
        <div class="col col-md-9"><?php echo '<span class="text-secondary">'.$nama_akses.'</span>';?></div>
    </div>
    <div class="row sub-title">
        <div class="col col-md-3">Jurnal</div>
        <div class="col col-md-9"><?php echo '<span class="text-secondary">'.$JumlahJurnal.' Record</span>';?></div>
    </div>
    <div class="row sub-title">
        <div class="col col-md-3">Kunci Data</div>
        <div class="col col-md-9"><?php echo '<span class="text-secondary">'.$kunci.'</span>';?></div>
    </div>
    <div class="row sub-title">
        <div class="col col-md-3">Status Transaksi</div>
        <div class="col col-md-9"><?php echo ''.$LabelStatus.'';?></div>
    </div>
    <div class="row sub-title">
        <div class="col col-md-3">Catatan</div>
        <div class="col col-md-9"><?php echo '<span class="text-secondary">'.$catatan.'</span>';?></div>
    </div>
    <div class="row mb-3">
        <div class="col col-md-12">
            <a href="index.php?Page=Transaksi&Sub=DetailTransaksi&id=<?php echo "$id_transaksi"; ?>" class="btn btn-sm btn-block btn-round btn-info">
                <i class="ti ti-new-window"></i> Lihat Selengkapnya
            </a>
        </div>
    </div>
<?php }} ?>