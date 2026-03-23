<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Setting
    $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
    $kfa_url=getDataDetail($Conn,'setting_satusehat','status','Active','kfa_url');
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
            //product_type
            if(!empty($_POST['product_type'])){
                $product_type=$_POST['product_type'];
            }else{
                $product_type="farmasi";
            }
            //keyword
            if(!empty($_POST['keyword'])){
                $keyword=$_POST['keyword'];
            }else{
                $keyword="";
            }
            //size
            if(!empty($_POST['size'])){
                $size=$_POST['size'];
            }else{
                $size="10";
            }
            //page
            if(!empty($_POST['page'])){
                $page=$_POST['page'];
            }else{
                $page="1";
            }
?>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        $GetAllKfa=GetAllKfa($kfa_url,$Token,$page,$size,$product_type,$keyword);
                        if(empty($GetAllKfa)){
                            echo '  <div class="row">';
                            echo '      <div class="col-md-12 text-center text-danger">';
                            echo '          Tidak ada response dari satu sehat';
                            echo '      </div>';
                            echo '  </div>';
                        }else{
                            $data = json_decode($GetAllKfa, true);
                            $total=$data['total'];
                            if(empty($total)){
                                echo '  <div class="row">';
                                echo '      <div class="col-md-12 text-center text-danger">';
                                echo '          Tidak ada data yang ditemukan';
                                echo '      </div>';
                                echo '  </div>';
                            }else{
                    ?>
                    <script>
                        //ketika klik next
                        $('#NextPage').click(function() {
                            var valueNext=$('#NextPage').val();
                            var size="<?php echo "$size"; ?>";
                            var keyword="<?php echo "$keyword"; ?>";
                            var product_type="<?php echo "$product_type"; ?>";
                            $.ajax({
                                url     : "_Page/Kfa/TabelKfa.php",
                                method  : "POST",
                                data 	:  { page: valueNext, size: size, keyword: keyword, product_type: product_type },
                                success: function (data) {
                                    $('#TabelKfa').html(data);
                                }
                            })
                        });
                        //Ketika klik Previous
                        $('#PrevPage').click(function() {
                            var ValuePrev = $('#PrevPage').val();
                            var size="<?php echo "$size"; ?>";
                            var keyword="<?php echo "$keyword"; ?>";
                            var product_type="<?php echo "$product_type"; ?>";
                            $.ajax({
                                url     : "_Page/Kfa/TabelKfa.php",
                                method  : "POST",
                                data 	:  { page: ValuePrev, size: size, keyword: keyword, product_type: product_type },
                                success : function (data) {
                                    $('#TabelKfa').html(data);
                                }
                            })
                        });
                        <?php 
                            $JmlHalaman =ceil($total/$size); 
                            $a=1;
                            $b=$JmlHalaman;
                            for ( $i =$a; $i<=$b; $i++ ){
                        ?>
                            //ketika klik page number
                            $('#PageNumber<?php echo $i;?>').click(function() {
                                var PageNumber = $('#PageNumber<?php echo $i;?>').val();
                                var size="<?php echo "$size"; ?>";
                                var keyword="<?php echo "$keyword"; ?>";
                                var product_type="<?php echo "$product_type"; ?>";
                                $.ajax({
                                    url     : "_Page/Kfa/TabelKfa.php",
                                    method  : "POST",
                                    data 	:  { page: PageNumber, size: size, keyword: keyword, product_type: product_type },
                                    success: function (data) {
                                        $('#TabelKfa').html(data);
                                    }
                                })
                            });
                        <?php } ?>
                    </script>
                    <?php
                                $no=1;
                                $list=$data['items']['data'];
                                foreach($list as $list_kfa){
                                    $name=$list_kfa['name'];
                                    $kfa_code=$list_kfa['kfa_code'];
                                    $active=$list_kfa['active'];
                                    $state=$list_kfa['state'];
                                    $updated_at=$list_kfa['updated_at'];
                                    $produksi_buatan=$list_kfa['produksi_buatan'];
                                    $nie=$list_kfa['nie'];
                                    $nama_dagang=$list_kfa['nama_dagang'];
                                    $manufacturer=$list_kfa['manufacturer'];
                                    $registrar=$list_kfa['registrar'];
                                    $generik=$list_kfa['generik'];
                                    $dosage_form_code=$list_kfa['dosage_form']['code'];
                                    $dosage_form_name=$list_kfa['dosage_form']['name'];
                                    $farmalkes_type_code=$list_kfa['farmalkes_type']['code'];
                                    $farmalkes_type_name=$list_kfa['farmalkes_type']['name'];
                                    $farmalkes_type_group=$list_kfa['farmalkes_type']['group'];
                                    if($active==true){
                                        $LabelActive='<span class="text-success">Yes</span>';
                                    }else{
                                        $LabelActive='<span class="text-danger">None</span>';
                                    }
                                    if($state==true){
                                        $LabelState='<span class="text-success">Yes</span>';
                                    }else{
                                        $LabelState='<span class="text-danger">None</span>';
                                    }
                                    echo '  <div class="row mb-3 sub-title">';
                                    echo '      <div class="col-md-12">';
                                    echo '          <a href="javascript:void(0);"  data-toggle="modal" data-target="#ModalDetailKfa" data-id="'.$kfa_code.'">';
                                    echo '              <dt class="text-primary">'.$no.'. '.$name.'</dt>';
                                    echo '          </a>';
                                    echo '      </div>';
                                    echo '      <div class="col-md-3">';
                                    echo '          <ul class="ml-3">';
                                    echo '              <li>ND: <code class="text-secondary">'.$nama_dagang.'</code></li>';
                                    echo '              <li>Code: <code class="text-secondary">'.$kfa_code.'</code></li>';
                                    echo '              <li>NIE: <code class="text-secondary">'.$nie.'</code></li>';
                                    echo '          </ul>';
                                    echo '      </div>';
                                    echo '      <div class="col-md-3">';
                                    echo '          <ul class="ml-3">';
                                    echo '              <li>Dosage : <code class="text-secondary">'.$dosage_form_name.' ('.$dosage_form_code.')</code></li>';
                                    echo '              <li>Update: <code class="text-secondary">'.$updated_at.'</code></li>';
                                    echo '              <li>Manufaktur: <code class="text-secondary">'.$manufacturer.'</code></li>';
                                    echo '          </ul>';
                                    echo '      </div>';
                                    echo '      <div class="col-md-3">';
                                    echo '          <ul class="ml-3">';
                                    echo '              <li>Generik : <code class="text-secondary">'.$generik.'</code></li>';
                                    echo '              <li>Active : <code class="text-secondary">'.$LabelActive.'</code></li>';
                                    echo '              <li>State: <code class="text-secondary">'.$state.'</code></li>';
                                    echo '          </ul>';
                                    echo '      </div>';
                                    echo '      <div class="col-md-3">';
                                    echo '          <ul class="ml-3">';
                                    echo '              <li>Type : <code class="text-secondary">'.$farmalkes_type_name.'</code></li>';
                                    echo '              <li>Type Code : <code class="text-secondary">'.$farmalkes_type_code.'</code></li>';
                                    echo '              <li>Group: <code class="text-secondary">'.$farmalkes_type_group.'</code></li>';
                                    echo '          </ul>';
                                    echo '      </div>';
                                    echo '      <div class="col-md-12 ml-3">';
                                    echo '          <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalHargaKfa" data-id="'.$kfa_code.'">';
                                    echo '              <small>Lihat Harga BPJS..</small>';
                                    echo '          </a>';
                                    echo '      </div>';
                                    echo '  </div>';
                                    $no++;
                                }
                            }
                            // echo '  <div class="row">';
                            // echo '      <div class="col-md-12 text-center text-danger">';
                            // echo '          '.$total.'';
                            // echo '      </div>';
                            // echo '  </div>';
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php
            //Mengatur Halaman
            $JmlHalaman = ceil($total/$size); 
            $JmlHalaman_real = ceil($total/$size); 
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
<?php
        }
    }
?>
