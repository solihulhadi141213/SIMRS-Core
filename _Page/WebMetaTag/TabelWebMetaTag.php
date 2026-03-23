<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "FungsiMetatag.php";
    $url_service=urlService('Info Meta Tag');
    $url_list_meta_tag=urlService('List Meta Tag');
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
        $ShortBy="ASC";
        $NextShort="ASC";
    }
    //OrderBy
    if(!empty($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="";
    }
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    $jml_data =jumlahData($api_key,$url_service,$keyword_by,$keyword);
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        $('#MenampilkanTabelMetaTag').html('Loading...');
        $.ajax({
            url     : "_Page/WebMetaTag/TabelWebMetaTag",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword },
            success: function (data) {
                $('#MenampilkanTabelMetaTag').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        $('#MenampilkanTabelMetaTag').html('Loading...');
        $.ajax({
            url     : "_Page/WebMetaTag/TabelWebMetaTag",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword },
            success : function (data) {
                $('#MenampilkanTabelMetaTag').html(data);
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
        $('#PageNumber<?php echo $i;?>').click(function() {
            var PageNumber = $('#PageNumber<?php echo $i;?>').val();
            var batas=$('#batas').val();
            var keyword=$('#keyword').val();
            $('#MenampilkanTabelMetaTag').html('Loading...');
            $.ajax({
                url     : "_Page/WebMetaTag/TabelWebMetaTag",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword },
                success: function (data) {
                    $('#MenampilkanTabelMetaTag').html(data);
                }
            })
        });
    <?php } ?>
</script>

<div class="card-block">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center" id="TabShortNama">
                        <dt>No</dt>
                    </th>
                    <th class="text-center" id="TabShortNama">
                        <dt>Page & Sub</dt>
                    </th>
                    <th class="text-center" id="TabShortNama">
                        <dt>Judul & Deskripsi</dt>
                    </th>
                    <th class="text-center" id="TabShortNama">
                        <dt>Option</dt>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="4" class="text-center">';
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
                        curl_setopt($ch,CURLOPT_URL, "$url_list_meta_tag");
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
                            echo '  <td colspan="4" class="text-center">';
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
                                echo '  <td colspan="4" class="text-center">';
                                echo '      '.$massage.'';
                                echo '  </td>';
                                echo '</tr>';
                            }else{
                                $JumlahBaris=count($JsonData['response']['list']);
                                if(empty($JumlahBaris)){
                                    echo '<tr>';
                                    echo '  <td colspan="4" class="text-center">';
                                    echo '      Tidak Ada Data Yang Ditampilkan';
                                    echo '  </td>';
                                    echo '</tr>';
                                }else{
                                    $list_data=$JsonData['response']['list'];
                                    $no=1+$posisi;
                                    foreach($list_data as $value){
                                        $id_web_metatag=$value['id_web_metatag'];
                                        $forPage=$value['forPage'];
                                        $forSub=$value['forSub'];
                                        $metatag_title=$value['metatag_title'];
                                        $metatag_description=$value['metatag_description'];
                                        $metatag_keywords=$value['metatag_keywords'];
                                        $metatag_author=$value['metatag_author'];
                ?>
                    <tr>
                        <td class="text-center"><?php echo "$no"; ?></td>
                        <td class="text-left"><?php echo "<dt>$forPage</dt>Sub: $forSub"; ?></td>
                        <td class="text-left">
                            <?php 
                                echo "<dt>$metatag_title</dt>"; 
                                echo "<small>Des: $metatag_description</small><br>"; 
                                echo "<small>Key: $metatag_keywords</small>"; 
                                echo "<small>Aut: $metatag_author</small>"; 
                            ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group dropdown-split-inverse">
                                <button type="button" class="btn btn-sm btn-inverse dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                                    <i class="ti ti-settings"></i>
                                </button>
                                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalEditMetaTag" data-id="<?php echo "$id_web_metatag"; ?>">
                                        <i class="ti-pencil"></i> Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapustMetaTag" data-id="<?php echo "$id_web_metatag"; ?>">
                                        <i class="ti-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
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
<div class="card-footer text-left border-info">
    <div class="btn-group">
        <a href="#!" class="b-b-primary text-primary">
            <button type="button" class="btn btn-sm btn-outline-secondary" id="PrevPage" value="<?php echo $prev;?>">
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
                        echo '<button type="button" class="btn btn-sm btn-outline-info" id="PageNumber'.$i.'" value="'.$i.'">';
                    }else{
                        echo '<button type="button" class="btn btn-sm btn-outline-secondary" id="PageNumber'.$i.'" value="'.$i.'">';
                    }
                    echo ''.$i.'';
                    echo '</button>';
                }
            ?>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="NextPage" value="<?php echo $next;?>">
                <i class="ti-angle-right"></i>
            </button>
        </a>
    </div>
</div>