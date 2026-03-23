<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    //keyword_by
    if(!empty($_POST['keyword_by'])){
        $keyword_by=$_POST['keyword_by'];
    }else{
        $keyword_by="";
    }
    //batas
    if(!empty($_POST['batas'])){
        $batas=$_POST['batas'];
    }else{
        $batas="10";
    }
    //ShortBy
    if(!empty($_POST['ShortBy'])){
        $ShortBy=$_POST['ShortBy'];
        if($ShortBy=="ASC"){
            $NextShort="DESC";
        }else{
            $NextShort="ASC";
        }
    }else{
        $ShortBy="DESC";
        $NextShort="DESC";
    }
    //OrderBy
    if(!empty($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="id_obat";
    }
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    if(empty($keyword_by)){
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE kode like '%$keyword%' OR nama like '%$keyword%' OR kategori like '%$keyword%' OR satuan like '%$keyword%' OR kelompok like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE $keyword_by like '%$keyword%'"));
        }
    }
?>
<script>
    $('#CheckAllObat').click(function() { 
        $('.IdObatCheck').prop('checked', this.checked);
    });
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        $.ajax({
            url     : "_Page/Obat/TabelObat.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword },
            success: function (data) {
                $('#MenampilkanTabelObat').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        $.ajax({
            url     : "_Page/Obat/TabelObat.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword },
            success : function (data) {
                $('#MenampilkanTabelObat').html(data);
            }
        })
    });
    <?php 
        $JmlHalaman=ceil($jml_data/$batas); 
        $a=1;
        $b=$JmlHalaman;
        for ( $i =$a; $i<=$b; $i++ ){
    ?>
        //ketika klik page number
        $('#PageNumber<?php echo $i;?>').click(function() {
            var PageNumber = $('#PageNumber<?php echo $i;?>').val();
            var batas=$('#batas').val();
            var keyword=$('#keyword').val();
            $.ajax({
                url     : "_Page/Obat/TabelObat.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword },
                success: function (data) {
                    $('#MenampilkanTabelObat').html(data);
                }
            })
        });
    <?php } ?>
</script>
<form action="javascript:void(0);" id="ProsesGetTabelObat">
    <div class="card-body">
        <?php
            if(empty($jml_data)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center text-danger">';
                echo '      Tidak ada data obat yang ditampilkan.';
                echo '  </div>';
                echo '</div>';
            }else{
                $no = 1+$posisi;
                //KONDISI PENGATURAN MASING FILTER
                if(empty($keyword_by)){
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM obat ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM obat WHERE kode like '%$keyword%' OR nama like '%$keyword%' OR kategori like '%$keyword%' OR satuan like '%$keyword%' OR kelompok like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }else{
                    if(empty($keyword)){
                        $query = mysqli_query($Conn, "SELECT*FROM obat ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }else{
                        $query = mysqli_query($Conn, "SELECT*FROM obat WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                    }
                }
                while ($data = mysqli_fetch_array($query)) {
                    $id_obat= $data['id_obat'];
                    if(empty($data['id_medication'])){
                        $id_medication="";
                        $LabelMedication='<a href="javascript:void(0);" class="text-danger" data-toggle="modal" data-target="#ModalPilihRacikan" data-id="'.$id_obat.'"><i class="ti ti-plus"></i>Add Medication</a>';
                    }else{
                        $id_medication= $data['id_medication'];
                        $LabelMedication='<a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalDetailMedication" data-id="'.$id_obat.'">'.$id_medication.'</a>';
                    }
                    $kode= $data['kode'];
                    $nama_obat= $data['nama'];
                    if(empty($data['kelompok'])){
                        $kelompok='<span class="text-danger">Tidak Diketahui</span>';
                    }else{
                        $kelompok= $data['kelompok'];
                    }
                    
                    $kategori= $data['kategori'];
                    $satuan= $data['satuan'];
                    $stok= $data['stok'];
                    $isi= $data['isi'];
                    $harga= $data['harga'];
                    $stok_min= $data['stok_min'];
                    $tanggal= $data['tanggal'];
                    $updatetime= $data['updatetime'];
                    //Update timestamp
                    $strtotime1=strtotime($tanggal);
                    $strtotime2=strtotime($updatetime);
                    $TanggalInput=date('d/m/Y H:i',$strtotime1);
                    $UpdateTime=date('d/m/Y H:i',$strtotime2);
                    //Format Harga
                    $HargaBeli = "Rp " . number_format($harga, 0, ',', '.');
        ?>
            <div class="row mb-3 sub-title">
                <div class="col-md-4">
                    <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailObat" data-id="<?php echo "$id_obat";?>">
                        <?php echo "$no. $nama_obat"; ?>
                    </a>
                    <ul class="ml-3">
                        <li>
                            Kode : <code class='text-secondary'><?php echo "$kode"; ?></code>
                        </li>
                        <li>
                            Medication : <code class='text-secondary'><?php echo "$LabelMedication"; ?></code>
                        </li>
                        <li>
                            Date : <code class='text-secondary'><?php echo "$TanggalInput"; ?></code>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <ul class="ml-3">
                        <li>
                            Kelompok : <code class='text-secondary'><?php echo "$kelompok"; ?></code>
                        </li>
                        <li>
                            Kategori : <code class='text-secondary'><?php echo "$kategori"; ?></code>
                        </li>
                        <li>
                            Satuan : <code class='text-secondary'><?php echo "$satuan"; ?></code>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <ul class="ml-3">
                        <li>
                            Stok Min : <code class='text-secondary'><?php echo "$stok_min $satuan"; ?></code>
                        </li>
                        <li>
                            Stok Akt : <code class='text-secondary'><?php echo "$stok $satuan"; ?></code>
                        </li>
                        <li>
                            Harga : <code class='text-secondary'><?php echo "$HargaBeli"; ?></code>
                        </li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <ul class="ml-3">
                        <li>
                            <input type="checkbox" class="IdObatCheck" name="id_obat[]" id="GetIdObatCheck<?php echo $id_obat;?>" value="<?php echo $id_obat;?>"> 
                            <label for="GetIdObatCheck<?php echo $id_obat;?>">Pilih Item</label>
                        </li>
                    </ul>
                </div>
            </div>
        <?php $no++; } ?>
        <div class="row">
            <div class="col-md-12 text-center">
                <input type="checkbox" class="CheckAllObat" name="CheckAllObat" id="CheckAllObat" value="Ya"> 
                <label for="CheckAllObat" class="text-dark">Pilih Semua</label>
            </div>
        </div>
    <?php } ?>
<?php
    // echo "<small>";
    // echo "<dt>Keterangan:</dt>";
    // echo "  <b>Batas :</b> <i id='GetBatas'>$batas</i>, ";
    // echo "  <b>Order By :</b> <i id='GetOrderBy'>$OrderBy</i>, ";
    // echo "  <b>Keyword :</b> <i id='GetKeyword'>$keyword</i>, ";
    // echo "  <b>Keyword By :</b> <i id='GetKeywordBy'>$keyword_by</i>, ";
    // echo "  <b>Short By :</b> <i id='GetShortBy'>$ShortBy</i>, ";
    // echo "  <b>Halaman :</b> <i id='GetPage'>$page</i>, ";
    // echo "  <b>Posisi :</b> <i id='GetPosisi'>$posisi</i>, ";
    // echo "</small>";
?>     
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="javascript:void(0);" class="badge badge-inverse-primary" data-toggle="modal" data-target="#ModalUpdateObatParsial">
                    <i class="ti ti-pencil-alt text-success"></i> Update Data
                </a>
                <a href="javascript:void(0);" class="badge badge-inverse-primary" data-toggle="modal" data-target="#ModalHapusObatParsial">
                    <i class="ti ti-trash text-danger"></i> Hapus Data
                </a>
                <a href="javascript:void(0);"  class="badge badge-inverse-primary" data-toggle="modal" data-target="#ModalCetakParsial">
                    <i class="icofont-bar-code text-primary"></i> Cetak Bar Code
                </a>
            </div>
        </div>
    </div>
    <?php
        //Mengatur Halaman
        $JmlHalaman = ceil($jml_data/$batas); 
        $JmlHalaman_real = ceil($jml_data/$batas); 
        $prev=$page-1;
        $next=$page+1;
        if($next>$JmlHalaman){
            $next=$page;
        }else{
            $next=$page+1;
        }
        if($prev<"1"){
            $prev="1";
        }else{
            $prev=$page-1;
        }
    ?>
    <div class="card-footer text-center">
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PrevPage" value="<?php echo $prev;?>">
                <i class="ti-angle-left"></i>
            </button>
            <?php 
                //Navigasi nomor
                if($JmlHalaman>5){
                    if($page>=5){
                        $a=$page-2;
                        $b=$page+2;
                        if($JmlHalaman<=$b){
                            $a=$page-2;
                            $b=$JmlHalaman;
                        }
                    }else{
                        $a=1;
                        $b=5;
                        if($JmlHalaman<=$b){
                            $a=1;
                            $b=$JmlHalaman;
                        }
                    }
                }else{
                    $a=1;
                    $b=$JmlHalaman;
                }
                for ( $i =$a; $i<=$b; $i++ ){
                    if($page=="$i"){
                        echo '<button type="button" class="btn btn-sm btn-info btn-round" id="PageNumber'.$i.'" value="'.$i.'">';
                    }else{
                        echo '<button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PageNumber'.$i.'" value="'.$i.'">';
                    }
                    echo ''.$i.'';
                    echo '</button>';
                }
            ?>
            <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="NextPage" value="<?php echo $next;?>">
                <i class="ti-angle-right"></i>
            </button>
        </div>
    </div>
</form>