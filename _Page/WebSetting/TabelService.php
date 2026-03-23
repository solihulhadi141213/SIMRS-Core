<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    //kategori_service
    if(!empty($_POST['kategori_service'])){
        $kategori_service=$_POST['kategori_service'];
    }else{
        $kategori_service="";
    }
    //BatasData
    if(!empty($_POST['BatasData'])){
        $batas=$_POST['BatasData'];
    }else{
        $batas="10";
    }
    //ShortBy
    if(!empty($_POST['ShortBy'])){
        $ShortBy=$_POST['ShortBy'];
    }else{
        $ShortBy="ASC";
    }
    //OrderBy
    if(!empty($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="id_setting_service";
    }
    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    if(empty($kategori_service)){
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_service"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM setting_service WHERE service_category='$kategori_service'"));
    }
?>
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var BatasData=$('#BatasData').val();
        var kategori_service=$('#kategori_service').val();
        $('#TabelService').html('Loading...');
        $.ajax({
            url     : "_Page/WebSetting/TabelService.php",
            method  : "POST",
            data 	:  { page: valueNext, BatasData: BatasData, kategori_service: kategori_service },
            success: function (data) {
                $('#TabelService').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var BatasData=$('#BatasData').val();
        var keyword=$('#keyword').val();
        $('#TabelService').html('Loading...');
        $.ajax({
            url     : "_Page/WebSetting/TabelService.php",
            method  : "POST",
            data 	:  { page: ValuePrev, BatasData: BatasData, kategori_service: kategori_service },
            success : function (data) {
                $('#TabelService').html(data);
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
            var BatasData=$('#BatasData').val();
            var keyword=$('#keyword').val();
            $('#TabelService').html('Loading...');
            $.ajax({
                url     : "_Page/WebSetting/TabelService.php",
                method  : "POST",
                data 	:  { page: PageNumber, BatasData: BatasData, kategori_service: kategori_service },
                success: function (data) {
                    $('#TabelService').html(data);
                }
            })
        });
    <?php } ?>
</script>
<div class="card-body pre-scrollable">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center">
                        <dt>No</dt>
                    </th>
                    <th class="text-center">
                        <dt>Nama & URL Service</dt>
                    </th>
                    <th class="text-center">
                        <dt>Kategori</dt>
                    </th>
                    <th class="text-center">
                        <dt>Last Update</dt>
                    </th>
                    <th class="text-center">
                        <dt>Option</dt>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($jml_data)){
                        echo '<tr>';
                        echo '  <td colspan="5" class="text-center">';
                        echo '      Belum Ada Data URL Service';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no = 1+$posisi;
                        //KONDISI PENGATURAN MASING FILTER
                        if(empty($kategori_service)){
                            $query = mysqli_query($Conn, "SELECT*FROM setting_service ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }else{
                            $query = mysqli_query($Conn, "SELECT*FROM setting_service WHERE service_category='$kategori_service' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                        }
                        while ($data = mysqli_fetch_array($query)) {
                            $id_setting_service= $data['id_setting_service'];
                            $service_name= $data['service_name'];
                            $service_category= $data['service_category'];
                            $url_service= $data['url_service'];
                            $last_update= $data['last_update'];
                            //Format waktu
                            $strtotime=strtotime($last_update);
                            $LastUpdate=date('d/m/Y H:i');
                ?>
                    <tr>
                        <td class="text-center"><?php echo "$no"; ?></td>
                        <td class="text-left">
                            <?php 
                                echo "<dt>$service_name</dt><br>"; 
                                echo "<small class='text-muted'>URL: $url_service</small><br>"; 
                            ?>
                        </td>
                        <td class="text-left"><?php echo "$service_category"; ?></td>
                        <td class="text-left"><?php echo "$LastUpdate"; ?></td>
                        <td class="text-center">
                            <div class="btn-group dropdown-split-inverse">
                                <button type="button" class="btn btn-sm btn-inverse dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                                    <i class="ti ti-settings"></i>
                                </button>
                                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalEditService" data-id="<?php echo "$id_setting_service"; ?>">
                                        <i class="ti-pencil"></i> Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusService" data-id="<?php echo "$id_setting_service"; ?>">
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
<div class="card-footer">
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