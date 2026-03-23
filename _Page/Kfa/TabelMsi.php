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
            //jenis_sarana
            if(!empty($_POST['jenis_sarana'])){
                $jenis_sarana=$_POST['jenis_sarana'];
            }else{
                $jenis_sarana="104";
            }
            //limit
            if(!empty($_POST['limit'])){
                $limit=$_POST['limit'];
            }else{
                $limit="10";
            }
            //page
            if(!empty($_POST['page'])){
                $page=$_POST['page'];
            }else{
                $page="1";
            }
            //kode_provinsi
            if(!empty($_POST['kode_provinsi'])){
                $kode_provinsi=$_POST['kode_provinsi'];
            }else{
                $kode_provinsi="";
            }
            //kode_kabkota
            if(!empty($_POST['kode_kabkota'])){
                $kode_kabkota=$_POST['kode_kabkota'];
            }else{
                $kode_kabkota="";
            }
            //kode_kecamatan
            if(!empty($_POST['kode_kecamatan'])){
                $kode_kecamatan=$_POST['kode_kecamatan'];
            }else{
                $kode_kecamatan="";
            }
?>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        $GetAllMsi=GetAllMsi($masterdata_url,$Token,$page,$limit,$jenis_sarana,$kode_provinsi,$kode_kabkota,$kode_kecamatan);
                        if(empty($GetAllMsi)){
                            echo '  <div class="row">';
                            echo '      <div class="col-md-12 text-center text-danger">';
                            echo '          Tidak ada response dari satu sehat';
                            echo '      </div>';
                            echo '  </div>';
                        }else{
                            $data = json_decode($GetAllMsi, true);
                            $status_code=$data['status_code'];
                            if(empty($status_code)){
                                echo '  <div class="row">';
                                echo '      <div class="col-md-12 text-center text-danger">';
                                echo '          Terjadi kesalahan namun kode kesalahan tidak diketahui';
                                echo '      </div>';
                                echo '  </div>';
                            }else{
                                if($status_code!==200){
                                    $message=$data['message'];
                                    echo '  <div class="row">';
                                    echo '      <div class="col-md-12 text-center text-danger">';
                                    echo '          Terjadi kesalahan koneksi dengan satu sehat';
                                    echo '      </div>';
                                    echo '  </div>';
                                    echo '  <div class="row">';
                                    echo '      <div class="col-md-12 text-center text-danger">';
                                    echo '          <dt>Keterangan :</dt> '.$message.'';
                                    echo '      </div>';
                                    echo '  </div>';
                                }else{
                                    $total_page=$data['total_page'];
                                    if(empty($total_page)){
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
                                        var limit="<?php echo "$limit"; ?>";
                                        var jenis_sarana="<?php echo "$jenis_sarana"; ?>";
                                        var kode_provinsi="<?php echo "$kode_provinsi"; ?>";
                                        var kode_kabkota="<?php echo "$kode_kabkota"; ?>";
                                        var kode_kecamatan="<?php echo "$kode_kecamatan"; ?>";
                                        $('#TabelMsi').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
                                        $.ajax({
                                            url     : "_Page/Kfa/TabelMsi.php",
                                            method  : "POST",
                                            data 	:  { page: valueNext, limit: limit, jenis_sarana: jenis_sarana, kode_provinsi: kode_provinsi, kode_kabkota: kode_kabkota, kode_kecamatan: kode_kecamatan },
                                            success: function (data) {
                                                $('#TabelMsi').html(data);
                                            }
                                        })
                                    });
                                    //Ketika klik Previous
                                    $('#PrevPage').click(function() {
                                        var ValuePrev = $('#PrevPage').val();
                                        var limit="<?php echo "$limit"; ?>";
                                        var jenis_sarana="<?php echo "$jenis_sarana"; ?>";
                                        var kode_provinsi="<?php echo "$kode_provinsi"; ?>";
                                        var kode_kabkota="<?php echo "$kode_kabkota"; ?>";
                                        var kode_kecamatan="<?php echo "$kode_kecamatan"; ?>";
                                        $('#TabelMsi').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
                                        $.ajax({
                                            url     : "_Page/Kfa/TabelMsi.php",
                                            method  : "POST",
                                            data 	:  { page: ValuePrev, limit: limit, jenis_sarana: jenis_sarana, kode_provinsi: kode_provinsi, kode_kabkota: kode_kabkota, kode_kecamatan: kode_kecamatan },
                                            success : function (data) {
                                                $('#TabelMsi').html(data);
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
                                            var limit="<?php echo "$limit"; ?>";
                                            var jenis_sarana="<?php echo "$jenis_sarana"; ?>";
                                            var kode_provinsi="<?php echo "$kode_provinsi"; ?>";
                                            var kode_kabkota="<?php echo "$kode_kabkota"; ?>";
                                            var kode_kecamatan="<?php echo "$kode_kecamatan"; ?>";
                                            $('#TabelMsi').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
                                            $.ajax({
                                                url     : "_Page/Kfa/TabelMsi.php",
                                                method  : "POST",
                                                data 	:  { page: PageNumber, limit: limit, jenis_sarana: jenis_sarana, kode_provinsi: kode_provinsi, kode_kabkota: kode_kabkota, kode_kecamatan: kode_kecamatan },
                                                success: function (data) {
                                                    $('#TabelMsi').html(data);
                                                }
                                            })
                                        });
                                    <?php } ?>
                                </script>
                    <?php
                                $no=1;
                                $list=$data['data'];
                                foreach($list as $list_msi){
                                    $kode_satusehat=$list_msi['kode_satusehat'];
                                    $kode_sarana=$list_msi['kode_sarana'];
                                    $nama=$list_msi['nama'];
                                    $telp=$list_msi['telp'];
                                    echo '  <div class="row mb-3 sub-title">';
                                    echo '      <div class="col-md-12">';
                                    echo '          <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalDetailMsi" data-id="'.$kode_sarana.'">';
                                    echo '              <dt class="text-primary">'.$no.'. '.$nama.'</dt>';
                                    echo '          </a>';
                                    echo '      </div>';
                                    echo '      <div class="col-md-3">';
                                    echo '          <ul class="ml-3">';
                                    echo '              <li>Kode Satu Sehat: <code class="text-secondary">'.$kode_satusehat.'</code></li>';
                                    echo '              <li>Kode Sarana: <code class="text-secondary">'.$kode_sarana.'</code></li>';
                                    echo '          </ul>';
                                    echo '      </div>';
                                    echo '  </div>';
                                    $no++;
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php
            //Mengatur Halaman
            $JmlHalaman =$total_page; 
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
        }
    }
?>
