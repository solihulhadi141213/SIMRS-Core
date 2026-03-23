<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $UrlInfo=urlService('Info Pasien');
    $UrlList=urlService('List Pasien');
    //KeywordPasien
    if(!empty($_POST['KeywordPasien'])){
        $keyword=$_POST['KeywordPasien'];
    }else{
        $keyword="";
    }
    $keyword_by="";
    //batas
    $batas="10";
    //ShortBy
    $ShortBy="DESC";
    //OrderBy
    $OrderBy="nama";
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    $parameter="jumlah";
    $jml_data =jumlahData($api_key,$UrlInfo,$keyword_by,$keyword,$parameter);
?>
<script>
    //ketika klik next
    $('#NextPage2').click(function() {
        var valueNext=$('#NextPage2').val();
        var keyword=$('#KeywordPasien').val();
        $('#ListPasien').html('Loading...');
        $.ajax({
            url     : "_Page/WebKunjungan/ListPasien.php",
            method  : "POST",
            data 	:  { page: valueNext, keyword: keyword },
            success: function (data) {
                $('#ListPasien').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage2').click(function() {
        var ValuePrev = $('#PrevPage2').val();
        var keyword=$('#KeywordPasien').val();
        $('#ListPasien').html('Loading...');
        $.ajax({
            url     : "_Page/WebKunjungan/ListPasien.php",
            method  : "POST",
            data 	:  { page: ValuePrev, keyword: keyword },
            success : function (data) {
                $('#ListPasien').html(data);
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
        $('#PageNumberPasien<?php echo $i;?>').click(function() {
            var PageNumberPasien = $('#PageNumberPasien<?php echo $i;?>').val();
            var keyword=$('#KeywordPasien').val();
            $('#ListPasien').html('Loading...');
            $.ajax({
                url     : "_Page/WebKunjungan/ListPasien.php",
                method  : "POST",
                data 	:  { page: PageNumberPasien, keyword: keyword },
                success: function (data) {
                    $('#ListPasien').html(data);
                }
            })
        });
    <?php } ?>
</script>

<div class="col-md-12 mt-3 pre-scrollable">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center">
                        <dt>No</dt>
                    </th>
                    <th class="text-center">
                        <dt>Pasien</dt>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="2" class="text-center">';
                        echo '      Tidak Ada Data Yang Ditampilkan';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        //Akses Data Dari Server Website
                        $KirimData = array(
                            'api_key' => $api_key,
                            'page' => $page,
                            'limit' => $batas,
                            'short_by' => $ShortBy,
                            'order_by' => $OrderBy,
                            'keyword_by' => $keyword_by,
                            'keyword' => $keyword,
                        );
                        $json = json_encode($KirimData);
                        //Mulai CURL
                        $ch = curl_init();
                        curl_setopt($ch,CURLOPT_URL, "$UrlList");
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch,CURLOPT_HEADER, 0);
                        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $content = curl_exec($ch);
                        $err = curl_error($ch);
                        curl_close($ch);
                        if(!empty($err)){
                            echo '<tr>';
                            echo '  <td colspan="2" class="text-center">';
                            echo '      '.$err.'';
                            echo '  </td>';
                            echo '</tr>';
                        }else{
                            $JsonData =json_decode($content, true);
                            if(!empty($JsonData['metadata']['massage'])){
                                $massage=$JsonData['metadata']['massage'];
                            }else{
                                $massage="Tidak Ada Pesan Response";
                            }
                            if(!empty($JsonData['metadata']['code'])){
                                $code=$JsonData['metadata']['code'];
                            }else{
                                $code="Kode Tidak Diketahui";
                            }
                            if($code!==200){
                                echo '<tr>';
                                echo '  <td colspan="2" class="text-center">';
                                echo '      '.$massage.'';
                                echo '  </td>';
                                echo '</tr>';
                            }else{
                                $JumlahBaris=count($JsonData['response']['list']);
                                if(empty($JumlahBaris)){
                                    echo '<tr>';
                                    echo '  <td colspan="2" class="text-center">';
                                    echo '      Tidak Ada Data Yang Ditampilkan';
                                    echo '  </td>';
                                    echo '</tr>';
                                }else{
                                    $list_data=$JsonData['response']['list'];
                                    $no=1+$posisi;
                                    foreach($list_data as $value){
                                        $id_web_pasien=$value['id_web_pasien'];
                                        $tanggal_daftar=$value['tanggal_daftar'];
                                        if(empty($value['id_pasien'])){
                                            $id_pasien="Belum Ada";
                                        }else{
                                            $id_pasien=$value['id_pasien'];
                                        }
                                        if(empty($value['nik'])){
                                            $nik="None";
                                        }else{
                                            $nik=$value['nik'];
                                        }
                                        if(empty($value['bpjs'])){
                                            $bpjs="None";
                                        }else{
                                            $bpjs=$value['bpjs'];
                                        }
                                        if(empty($value['kontak'])){
                                            $kontak="Tidak Ada";
                                        }else{
                                            $kontak=$value['kontak'];
                                        }
                                        $email=$value['email'];
                                        $nama=$value['nama'];
                                        $status=$value['status'];
                                        $tepat_lahir=$value['tepat_lahir'];
                                        $tanggal_lahir=$value['tanggal_lahir'];
                                        //Format Tanggal
                                        $Strtotime=strtotime($tanggal_daftar);
                                        $TanggalFormat=date('d/m/Y H:i',$Strtotime);
                                        $Jam=date('H:i',$Strtotime);
                                        //Status
                                        if($status=="Active"){
                                            $LabelStatus='<span class="badge badge-success">Active</span>';
                                        }else{
                                            $LabelStatus='<span class="badge badge-dark">'.$status.'</span>';
                                        }
                ?>
                    <tr>
                        <td class="text-center"><?php echo "$no"; ?></td>
                        <td class="text-left">
                            <?php 
                                echo "<dt><a href='index.php?Page=WebKunjungan&Sub=TambahKunjungan&&id=$id_web_pasien' class='text-primary'>$nama</a></dt>"; 
                                echo '<small class="text-muted">No.RM : '.$id_pasien.'</small><br>';
                                echo '<small class="text-muted">NIK : '.$nik.'</small><br>';
                                echo '<small class="text-muted">No.BPJS : '.$bpjs.'<br></small>';
                            ?>
                        </td>
                    </tr>
                <?php
                                        $no++;
                                    }
                                }
                            }
                        }
                    }
                ?>
            </tbody>
        </table>
        
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
<div class="col-md-12 mt-3 mb-3">
    <div class="btn-group">
        <a href="#!" class="b-b-primary text-primary">
            <button type="button" class="btn btn-sm btn-outline-secondary" id="PrevPage2" value="<?php echo $prev;?>">
                <i class="ti-angle-left"></i>
            </button>
            <?php 
                //Navigasi nomor
                if($JmlHalaman>5){
                    if($page>=3){
                        $a=$page-2;
                        $b=$page+2;
                        if($JmlHalaman<=$b){
                            $a=$page-2;
                            $b=$JmlHalaman;
                        }
                    }else{
                        $a=1;
                        $b=$page+2;
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
                        echo '<button type="button" class="btn btn-sm btn-outline-info" id="PageNumberPasien'.$i.'" value="'.$i.'">';
                    }else{
                        echo '<button type="button" class="btn btn-sm btn-outline-secondary" id="PageNumberPasien'.$i.'" value="'.$i.'">';
                    }
                    echo ''.$i.'';
                    echo '</button>';
                }
            ?>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="NextPage2" value="<?php echo $next;?>">
                <i class="ti-angle-right"></i>
            </button>
        </a>
    </div>
</div>
<?php
    //looping
    
?>