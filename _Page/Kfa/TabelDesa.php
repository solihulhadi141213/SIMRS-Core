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
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Tidak ada setting satu sehat yang aktiv';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($Token)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center text-danger">';
            echo '      Generate Token Gagal';
            echo '  </div>';
            echo '</div>';
        }else{
            if(empty($_POST['code'])){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center text-danger">';
                echo '      Kode Tidak Boleh Kosong';
                echo '  </div>';
                echo '</div>';
            }else{
                $code_kecamatan=$_POST['code'];
                //current_page
                if(!empty($_POST['current_page'])){
                    $current_page=$_POST['current_page'];
                }else{
                    $current_page="1";
                }
                $GetMasterWilayahDesa=GetMasterWilayahDesa($masterdata_url,$Token,$current_page,$code_kecamatan);
                if(empty($GetMasterWilayahDesa)){
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12 text-center text-danger">';
                    echo '          Tidak ada response dari satu sehat';
                    echo '      </div>';
                    echo '  </div>';
                }else{
                    $data = json_decode($GetMasterWilayahDesa, true);
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
                        echo '          <textarea class="form-control">'.$GetMasterWilayahDesa.'</textarea>';
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
                            echo '  <div class="row">';
                            echo '      <div class="col-md-12 text-center text-danger">';
                            echo '          Keterangan: '.$message.'';
                            echo '      </div>';
                            echo '  </div>';
                            echo '  <div class="row">';
                            echo '      <div class="col-md-12 text-center text-danger">';
                            echo '          <textarea class="form-control">'.$GetMasterWilayahDesa.'</textarea>';
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
                            $('#NextPage<?php echo $code_kecamatan;?>').click(function() {
                                var valueNext=$('#NextPage<?php echo $code_kecamatan;?>').val();
                                var code="<?php echo $code_kecamatan;?>";
                                $('#TabelDesa<?php echo $code_kecamatan;?>').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
                                $.ajax({
                                    url     : "_Page/Kfa/TabelDesa.php",
                                    method  : "POST",
                                    data 	:  { current_page: valueNext, code: code },
                                    success: function (data) {
                                        $('#TabelDesa<?php echo $code_kecamatan;?>').html(data);
                                    }
                                })
                            });
                            //Ketika klik Previous
                            $('#PrevPage<?php echo $code_kecamatan;?>').click(function() {
                                var ValuePrev = $('#PrevPage<?php echo $code_kecamatan;?>').val();
                                var code="<?php echo $code_kecamatan;?>";
                                $('#TabelDesa<?php echo $code_kecamatan;?>').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
                                $.ajax({
                                    url     : "_Page/Kfa/TabelDesa.php",
                                    method  : "POST",
                                    data 	:  { current_page: ValuePrev, code: code },
                                    success : function (data) {
                                        $('#TabelDesa<?php echo $code_kecamatan;?>').html(data);
                                    }
                                })
                            });
                            <?php 
                                $a=1;
                                $b=$total_page;
                                for ( $i =$a; $i<=$b; $i++ ){
                            ?>
                                //ketika klik page number
                                $('#PageNumber<?php echo "$code_kecamatan-$i";?>').click(function() {
                                    var PageNumber = $('#PageNumber<?php echo "$code_kecamatan-$i";?>').val();
                                    var code="<?php echo $code_kecamatan;?>";
                                    $('#TabelDesa<?php echo $code_kecamatan;?>').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
                                    $.ajax({
                                        url     : "_Page/Kfa/TabelDesa.php",
                                        method  : "POST",
                                        data 	:  { current_page: PageNumber, code: code },
                                        success: function (data) {
                                            $('#TabelDesa<?php echo $code_kecamatan;?>').html(data);
                                        }
                                    })
                                });
                            <?php } ?>
                        </script>
<?php
                        $no=1+$posisi;
                        $list=$data['data'];
                        foreach($list as $list_provinsi){
                            $name=$list_provinsi['name'];
                            $parent_code=$list_provinsi['parent_code'];
                            $bps_code=$list_provinsi['bps_code'];
                            $code=$list_provinsi['code'];
                            echo '<div class="row mb-3">';
                            echo '  <div class="col col-md-12 ml-3">'.$no.'. '.$name.' ('.$code.')</div>';
                            echo '</div>';
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
                                <div class="col-md-12 text-left ml-3">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-info" id="PrevPage<?php echo $code_kecamatan;?>" value="<?php echo $prev;?>">
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
                                                    echo '<button type="button" class="btn btn-sm btn-info" id="PageNumber'.$code_kecamatan.'-'.$i.'" value="'.$i.'">';
                                                }else{
                                                    echo '<button type="button" class="btn btn-sm btn-outline-info" id="PageNumber'.$code_kecamatan.'-'.$i.'" value="'.$i.'">';
                                                }
                                                echo ''.$i.'';
                                                echo '</button>';
                                            }
                                        ?>
                                        <button type="button" class="btn btn-sm btn-outline-info" id="NextPage<?php echo $code_kecamatan;?>" value="<?php echo $next;?>">
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
    }
?>