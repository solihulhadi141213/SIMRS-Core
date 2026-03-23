<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Tangkap id_operasi
    if(empty($_GET['id_bantuan'])){
        $id_bantuan="";
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Id Bantuan Tidak ada, Silahkan refresh halaman ini.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_bantuan=$_GET['id_bantuan'];
        //Buka data Antrian
        $Qry = mysqli_query($Conn,"SELECT * FROM bantuan WHERE id_bantuan='$id_bantuan'")or die(mysqli_error($Conn));
        $Data = mysqli_fetch_array($Qry);
        $id_bantuan= $Data['id_bantuan'];
        $tanggal= $Data['tanggal'];
        $judul= $Data['judul'];
        $kategori= $Data['kategori'];
        $isi= $Data['isi'];
        if(empty($id_bantuan)){
            echo '<div class="card-body border-0 pb-0">';
            echo '  <div class="row">';
            echo '      <div class="col-md-6 mb-3">';
            echo '          <span class="text-info">Data tidak ditemukan, Silahkan refresh halaman ini.</span>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
?>
<div class="card">
    <div class="card-body">
        <div class="row mt-2">
            <div class="col-md-12 text-left">
                <h4><?php echo "$judul"; ?></h4>
                <i clas="text-muted"><?php echo "Kategori: $kategori"; ?></i><br>
                <i clas="text-muted"><?php echo "Tanggal Posting: $tanggal"; ?></i><br>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12 text-left">
                <span clas="text-muted"><?php echo "$isi"; ?></span>
            </div>
        </div>
    </div>
</div>
<?php
    }}

?>