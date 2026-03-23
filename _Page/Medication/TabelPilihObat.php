<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //keyword
    if(!empty($_POST['keyword_obat'])){
        $keyword=$_POST['keyword_obat'];
    }else{
        $keyword="";
    }
    //batas
    $batas="10";
    //ShortBy
    $ShortBy="DESC";
    //OrderBy
    $OrderBy="id_obat";
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat WHERE kode like '%$keyword%' OR nama like '%$keyword%' OR kategori like '%$keyword%' OR satuan like '%$keyword%' OR kelompok like '%$keyword%'"));
    }
    if(empty($jml_data)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Tidak ada data obat yang ditampilkan.';
        echo '  </div>';
        echo '</div>';
    }else{
?>
        <script>
            //ketika klik next
            $('#NextPageObat').click(function() {
                var valueNext=$('#NextPageObat').val();
                var batas="<?php echo "$batas"; ?>";
                var keyword="<?php echo "$keyword"; ?>";
                $('#TabelPilihObat').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
                $.ajax({
                    url     : "_Page/Medication/TabelPilihObat.php",
                    method  : "POST",
                    data 	:  { page: valueNext, batas: batas, keyword_obat: keyword },
                    success: function (data) {
                        $('#TabelPilihObat').html(data);
                    }
                })
            });
            //Ketika klik Previous
            $('#PrevPageObat').click(function() {
                var ValuePrev = $('#PrevPageObat').val();
                var batas="<?php echo "$batas"; ?>";
                var keyword="<?php echo "$keyword"; ?>";
                $('#TabelPilihObat').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
                $.ajax({
                    url     : "_Page/Medication/TabelPilihObat.php",
                    method  : "POST",
                    data 	:  { page: ValuePrev, batas: batas, keyword_obat: keyword },
                    success : function (data) {
                        $('#TabelPilihObat').html(data);
                    }
                })
            });
            <?php 
                $JmlHalaman =ceil($jml_data/$batas); 
                $a=1;
                $b=$JmlHalaman;
                for ( $i =$a; $i<=$b; $i++ ){
            ?>
                //ketika klik page number
                $('#PageNumberObat<?php echo $i;?>').click(function() {
                    var PageNumber = $('#PageNumberObat<?php echo $i;?>').val();
                    var batas="<?php echo "$batas"; ?>";
                    var keyword="<?php echo "$keyword"; ?>";
                    $('#TabelPilihObat').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
                    $.ajax({
                        url     : "_Page/Medication/TabelPilihObat.php",
                        method  : "POST",
                        data 	:  { page: PageNumber, batas: batas, keyword_obat: keyword },
                        success: function (data) {
                            $('#TabelPilihObat').html(data);
                        }
                    })
                });
            <?php } ?>
        </script>
        <?php
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword)){
                $query = mysqli_query($Conn, "SELECT*FROM obat ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
            }else{
                $query = mysqli_query($Conn, "SELECT*FROM obat WHERE kode like '%$keyword%' OR nama like '%$keyword%' OR kategori like '%$keyword%' OR satuan like '%$keyword%' OR kelompok like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_obat= $data['id_obat'];
                if(empty($data['id_medication'])){
                    $id_medication="";
                    $LabelMedication='<span class="text-danger">None</span>';
                }else{
                    $id_medication= $data['id_medication'];
                    $LabelMedication='<span class="text-success">'.$id_medication.'</span>';
                }
                $kode= $data['kode'];
                $nama_obat= $data['nama'];
                if(empty($data['kelompok'])){
                    $kelompok='<span class="text-danger">None</span>';
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
                echo '<div class="row mb-3 sub-title">';
                echo '  <div class="col-md-12">';
                if(empty($data['id_medication'])){
                echo '      <a href="index.php?Page=Medication&Sub=TambahMedication&id='.$id_obat.'" class="text-primary">';
                echo '          '.$no.'.'.$nama_obat.'';
                echo '      </a>';
                }else{
                    echo '      <a href="javascript:void(0);" class="text-secondary" title="Sudah Punya ID Medication">';
                    echo '          '.$no.'.'.$nama_obat.'';
                    echo '      </a>';
                }
                echo '  </div>';
                echo '  <div class="col-md-4">';
                echo '      <ul class="ml-3">';
                echo '          <li>Kode : <code class="text-secondary">'.$kode.'</code></li>';
                echo '          <li>ID Medication : <code class="text-secondary">'.$LabelMedication.'</code></li>';
                echo '          <li>Kategori : <code class="text-secondary">'.$kategori.'</code></li>';
                echo '      </ul>';
                echo '  </div>';
                echo '  <div class="col-md-4">';
                echo '      <ul class="ml-3">';
                echo '          <li>Kelompok : <code class="text-secondary">'.$kelompok.'</code></li>';
                echo '          <li>Kategori : <code class="text-secondary">'.$kategori.'</code></li>';
                echo '          <li>Satuan : <code class="text-secondary">'.$satuan.'</code></li>';
                echo '      </ul>';
                echo '  </div>';
                echo '  <div class="col-md-4">';
                echo '      <ul class="ml-3">';
                echo '          <li>Stok : <code class="text-secondary">'.$stok.' '.$satuan.'</code></li>';
                echo '          <li>Harga : <code class="text-secondary">'.$HargaBeli.'</code></li>';
                echo '          <li>Update : <code class="text-secondary">'.$UpdateTime.'</code></li>';
                echo '      </ul>';
                echo '  </div>';
                echo '</div>';
                $no++;
            }
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
        <div class="row mb-3 mt-3">
            <div class="col-md-12 text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PrevPageObat" value="<?php echo $prev;?>">
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
                                echo '<button type="button" class="btn btn-sm btn-secondary btn-round" id="PageNumberObat'.$i.'" value="'.$i.'">';
                            }else{
                                echo '<button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="PageNumberObat'.$i.'" value="'.$i.'">';
                            }
                            echo ''.$i.'';
                            echo '</button>';
                        }
                    ?>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-round" id="NextPageObat" value="<?php echo $next;?>">
                        <i class="ti-angle-right"></i>
                    </button>
                </div>
            </div>
        </div>
<?php } ?>