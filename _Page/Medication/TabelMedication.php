<?php
    //koneksi dan session
    // ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
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
        $OrderBy="id_obat_medication";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_medication"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_medication WHERE id_medication like '%$keyword%' OR nama like '%$keyword%' OR kode like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_medication"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_medication WHERE $keyword_by like '%$keyword%'"));
        }
    }
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        $('#MenampilkanTabelMedication').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
        $.ajax({
            url     : "_Page/Medication/TabelMedication.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success: function (data) {
                $('#MenampilkanTabelMedication').html(data);
            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas="<?php echo "$batas"; ?>";
        var keyword="<?php echo "$keyword"; ?>";
        var keyword_by="<?php echo "$keyword_by"; ?>";
        $('#MenampilkanTabelMedication').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
        $.ajax({
            url     : "_Page/Medication/TabelMedication.php",
            method  : "POST",
            data 	:  { page: ValuePrev, batas: batas, keyword: keyword, keyword_by: keyword_by },
            success : function (data) {
                $('#MenampilkanTabelMedication').html(data);
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
            var batas="<?php echo "$batas"; ?>";
            var keyword="<?php echo "$keyword"; ?>";
            var keyword_by="<?php echo "$keyword_by"; ?>";
            $('#MenampilkanTabelMedication').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
            $.ajax({
                url     : "_Page/Medication/TabelMedication.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword, keyword_by: keyword_by },
                success: function (data) {
                    $('#MenampilkanTabelMedication').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="card-body">
    <?php
        if(empty($jml_data)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Tidak ada data medication yang ditampilkan.';
            echo '  </div>';
            echo '</div>';
        }else{
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
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM obat_medication ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM obat_medication WHERE id_medication like '%$keyword%' OR nama like '%$keyword%' OR kode like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM obat_medication ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM obat_medication WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_obat_medication= $data['id_obat_medication'];
                $id_obat= $data['id_obat'];
                $id_medication= $data['id_medication'];
                $kode= $data['kode'];
                $nama= $data['nama'];
                $raw_medication= $data['raw_medication'];
                $id_akses= $data['id_akses'];
                $updatetime= $data['updatetime'];
                //Update timestamp
                $strtotime=strtotime($updatetime);
                $TanggalInput=date('d/m/Y H:i',$strtotime);
                //Buka Data Obat
                $kelompok=getDataDetail($Conn,'obat','id_obat',$id_obat,'kelompok');
                $kategori=getDataDetail($Conn,'obat','id_obat',$id_obat,'kategori');
                $satuan=getDataDetail($Conn,'obat','id_obat',$id_obat,'satuan');
                $isi=getDataDetail($Conn,'obat','id_obat',$id_obat,'isi');
                $stok=getDataDetail($Conn,'obat','id_obat',$id_obat,'stok');
                $harga=getDataDetail($Conn,'obat','id_obat',$id_obat,'harga');
                $stok_min=getDataDetail($Conn,'obat','id_obat',$id_obat,'stok_min');
                $keterangan=getDataDetail($Conn,'obat','id_obat',$id_obat,'keterangan');
                //Format Harga Beli
                $harga=number_format($harga,0,',','.');
                //Nama Petugas
                $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
    ?>
        <div class="row mb-3 sub-title">
            <div class="col-md-12">
                <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailMedicationLocal" data-id="<?php echo "$id_obat_medication";?>">
                    <?php echo "$no. $nama"; ?>
                </a>
            </div>
            <div class="col-md-6">
                <ul class="ml-3">
                    <li>
                        ID Obat : <code class='text-secondary'><?php echo "$id_obat"; ?></code>
                    </li>
                    <li>
                        Kode Obat : <code class='text-secondary'><?php echo "$kode"; ?></code>
                    </li>
                    <li>
                        Medication : 
                        <code class='text-primary'>
                            <a href="javascript:void(0);" class='text-info' data-toggle="modal" data-target="#ModalDetailMedicationSatuSehat" data-id="<?php echo "$id_medication";?>">
                                <?php echo "$id_medication"; ?>
                            </a>
                        </code>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul class="ml-3">
                    <li>
                        Group : <code class='text-secondary'><?php echo "$kelompok"; ?></code>
                    </li>
                    <li>
                        Kategori : <code class='text-secondary'><?php echo "$kategori"; ?></code>
                    </li>
                    <li>
                        Harga : <code class='text-secondary'><?php echo "$harga"; ?></code>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul class="ml-3">
                    <li>
                        Petugas : <code class='text-secondary'><?php echo "$NamaPetugas"; ?></code>
                    </li>
                    <li>
                        Update Time : <code class='text-secondary'><?php echo "$TanggalInput"; ?></code>
                    </li>
                </ul>
            </div>
        </div>
    <?php $no++; } ?>
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
<?php } ?>