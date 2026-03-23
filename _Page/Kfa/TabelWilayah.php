<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Setting
    $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
    $masterdata_url=getDataDetail($Conn,'setting_satusehat','status','Active','masterdata_url');
    $Token=GenerateTokenSatuSehat($Conn);
    if(empty($SettingSatuSehat)){
        echo '<div class="card-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          Tidak ada setting satu sehat yang aktiv';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($Token)){
            echo '<div class="card-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          Generate Token Gagal';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            //current_page
            if(!empty($_POST['current_page'])){
                $current_page=$_POST['current_page'];
            }else{
                $current_page="1";
            }
            //next
            if(!empty($_POST['next'])){
                $next=$_POST['next'];
            }else{
                $next="";
            }
            //prev
            if(!empty($_POST['prev'])){
                $prev=$_POST['prev'];
            }else{
                $prev="";
            }
            //codes
            if(!empty($_POST['codes'])){
                $codes=$_POST['codes'];
            }else{
                $codes="";
            }
            $GetMasterWilayahProvinsi=GetMasterWilayahProvinsi($masterdata_url,$Token,$current_page,$next,$prev,$codes);
            if(empty($GetMasterWilayahProvinsi)){
                echo '  <div class="row">';
                echo '      <div class="col-md-12 text-center text-danger">';
                echo '          Tidak ada response dari satu sehat';
                echo '      </div>';
                echo '  </div>';
            }else{
                $data = json_decode($GetMasterWilayahProvinsi, true);
                $status=$data['status'];
                if($status!==200){
                    $message=$data['message'];
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12 text-center text-danger">';
                    echo '          Tidak ada data yang ditemukan';
                    echo '      </div>';
                    echo '  </div>';
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12 text-center text-danger">';
                    echo '          Keterangan: '.$message.'';
                    echo '      </div>';
                    echo '  </div>';
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12 text-center text-danger">';
                    echo '          <textarea class="form-control">'.$GetMasterWilayahProvinsi.'</textarea>';
                    echo '      </div>';
                    echo '  </div>';
                }else{
                    $total=$data['meta']['page']['total'];
                    if(empty($total)){
                        echo '  <div class="row">';
                        echo '      <div class="col-md-12 text-center text-danger">';
                        echo '          Tidak ada data yang ditemukan';
                        echo '      </div>';
                        echo '  </div>';
                    }else{
                        $total_page=$data['meta']['page']['total_page'];
                        $limit=$data['meta']['page']['limit'];
                        $current=$data['meta']['page']['current'];
                        $posisi = ( $current - 1 ) * $limit;
?>
                        <script>
                            //ketika klik next
                            $('#NextPage').click(function() {
                                var valueNext=$('#NextPage').val();
                                $('#TabelWilayah').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
                                $.ajax({
                                    url     : "_Page/Kfa/TabelWilayah.php",
                                    method  : "POST",
                                    data 	:  { current_page: valueNext },
                                    success: function (data) {
                                        $('#TabelWilayah').html(data);
                                    }
                                })
                            });
                            //Ketika klik Previous
                            $('#PrevPage').click(function() {
                                var ValuePrev = $('#PrevPage').val();
                                $('#TabelWilayah').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
                                $.ajax({
                                    url     : "_Page/Kfa/TabelWilayah.php",
                                    method  : "POST",
                                    data 	:  { current_page: ValuePrev },
                                    success : function (data) {
                                        $('#TabelWilayah').html(data);
                                    }
                                })
                            });
                            <?php 
                                $a=1;
                                $b=$total_page;
                                for ( $i =$a; $i<=$b; $i++ ){
                            ?>
                                //ketika klik page number
                                $('#PageNumber<?php echo $i;?>').click(function() {
                                    var PageNumber = $('#PageNumber<?php echo $i;?>').val();
                                    $('#TabelWilayah').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
                                    $.ajax({
                                        url     : "_Page/Kfa/TabelWilayah.php",
                                        method  : "POST",
                                        data 	:  { current_page: PageNumber },
                                        success: function (data) {
                                            $('#TabelWilayah').html(data);
                                        }
                                    })
                                });
                            <?php } ?>
                            $('.TampilkanKabupatenKota').click(function() {
                                var code_provinsi = $(this).attr('value');
                                $('#TabelWilayahKabupaten'+code_provinsi+'').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
                                $.ajax({
                                        url     : "_Page/Kfa/TampilkanKabupatenKota.php",
                                        method  : "POST",
                                        data 	:  { code: code_provinsi },
                                        success: function (data) {
                                            $('#TabelWilayahKabupaten'+code_provinsi+'').html(data);
                                        }
                                    })
                            });
                        </script>
<?php
                        $no=1+$posisi;
                        $list=$data['data'];
                        foreach($list as $list_provinsi){
                            $name=$list_provinsi['name'];
                            $parent_code=$list_provinsi['parent_code'];
                            $bps_code=$list_provinsi['bps_code'];
                            $code=$list_provinsi['code'];
?>
                            <div id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="accordion-panel">
                                    <div class="accordion-heading" role="tab" id="heading<?php echo "$code"; ?>">
                                        <h3 class="card-title accordion-title">
                                            <a class="accordion-msg waves-effect waves-dark scale_active TampilkanKabupatenKota" data-toggle="collapse" data-parent="#accordion" href="#collaps<?php echo "$code"; ?>" aria-expanded="true" aria-controls="collaps<?php echo "$code"; ?>" value="<?php echo "$code"; ?>">
                                                <dt><?php echo "$no. $name ($code)"; ?></dt>
                                            </a>
                                        </h3>
                                    </div>
                                    <div id="collaps<?php echo "$code"; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?php echo "$code"; ?>">
                                        <div class="accordion-content accordion-desc">
                                            <div class="row">
                                                <div class="col-md-12" id="TabelWilayahKabupaten<?php echo "$code"; ?>"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
<?php
                        $no++;
                    }
                    //Mengatur Halaman
                    $JmlHalaman =$data['meta']['page']['total_page']; 
                    $prev=$current-1;
                    $next=$current+1;
                    if($next>$JmlHalaman){
                        $next=$current;
                    }else{
                        $next=$current+1;
                    }
                    if($prev<"1"){
                        $prev="1";
                    }else{
                        $prev=$current-1;
                    }
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="PrevPage" value="<?php echo $prev;?>">
                                            <i class="ti-angle-left"></i>
                                        </button>
                                        <?php 
                                            //Navigasi nomor
                                            if($JmlHalaman>5){
                                                if($current>=3){
                                                    $a=$current-2;
                                                    $b=$current+2;
                                                    if($JmlHalaman<=$b){
                                                        $a=$current-2;
                                                        $b=$JmlHalaman;
                                                    }
                                                }else{
                                                    $a=1;
                                                    $b=$current+2;
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
                                                if($current=="$i"){
                                                    echo '<button type="button" class="btn btn-sm btn-secondary" id="PageNumber'.$i.'" value="'.$i.'">';
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
                                    </div>
                                </div>
                            </div>
<?php
                }
            }
        }
    }
}
?>