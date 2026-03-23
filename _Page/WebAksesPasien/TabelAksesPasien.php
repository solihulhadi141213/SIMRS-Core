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
        $NextShort="ASC";
    }
    //OrderBy
    if(!empty($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="id_web_pasien";
    }
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
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        $('#TabelAksesPasien').html('Loading...');
        $.ajax({
            url     : "_Page/WebAksesPasien/TabelAksesPasien.php",
            method  : "POST",
            data 	:  { page: valueNext, batas: batas, keyword: keyword },
            success: function (data) {
                $('#TabelAksesPasien').html(data);

            }
        })
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val();
        var batas=$('#batas').val();
        var keyword=$('#keyword').val();
        $('#TabelAksesPasien').html('Loading...');
        $.ajax({
            url     : "_Page/WebAksesPasien/TabelAksesPasien.php",
            method  : "POST",
            data 	:  { page: ValuePrev,batas: batas, keyword: keyword },
            success : function (data) {
                $('#TabelAksesPasien').html(data);
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
            $('#TabelAksesPasien').html('Loading...');
            $.ajax({
                url     : "_Page/WebAksesPasien/TabelAksesPasien.php",
                method  : "POST",
                data 	:  { page: PageNumber, batas: batas, keyword: keyword },
                success: function (data) {
                    $('#TabelAksesPasien').html(data);
                }
            })
        });
    <?php } ?>
</script>

<div class="card-body">
    <div class="table-responsive mb-4">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center">
                        <dt>No</dt>
                    </th>
                    <th class="text-center">
                        <dt>Pasien</dt>
                    </th>
                    <th class="text-center">
                        <dt>Info Kartu</dt>
                    </th>
                    <th class="text-center">
                        <dt>Akun</dt>
                    </th>
                    <th class="text-center">
                        <dt>Kontak & TTL</dt>
                    </th>
                    <th class="text-center">
                        <dt>Status</dt>
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
                        echo '  <td colspan="6" class="text-center">';
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
                            echo '  <td colspan="6" class="text-center">';
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
                                echo '  <td colspan="6" class="text-center">';
                                echo '      '.$massage.'';
                                echo '  </td>';
                                echo '</tr>';
                            }else{
                                $JumlahBaris=count($JsonData['response']['list']);
                                if(empty($JumlahBaris)){
                                    echo '<tr>';
                                    echo '  <td colspan="6" class="text-center">';
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
                                echo '<a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailPasien" data-id="'.$id_web_pasien.'">';
                                echo "<dt>$nama <i class='ti ti-layers-alt'></i></dt>"; 
                                echo '</a>';
                                if(empty($value['id_pasien'])){
                                    echo '<small class="text-danger">No.RM : '.$id_pasien.'</small>';
                                }else{
                                    echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#ModalDetailRm" data-id="'.$id_pasien.'">';
                                    echo '<small class="text-primary">No.RM : '.$id_pasien.'</small>';
                                    echo '</a>';
                                }
                            ?>
                        </td>
                        <td class="text-left">
                            <?php 
                                if(empty($value['nik'])){
                                    echo '<dt>NIK: '.$nik.'</dt>'; 
                                }else{
                                    echo'<dt>';
                                    echo '  NIK:';
                                    echo '  <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailNik" data-id="'.$nik.'">';
                                    echo '      '.$nik.''; 
                                    echo '  </a>';
                                    echo '</dt>';
                                }
                                if(empty($value['bpjs'])){
                                    echo '<small class="text-muted">BPJS: '.$bpjs.'</small>';
                                }else{
                                    echo'<small>';
                                    echo '  BPJS:';
                                    echo '  <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailBpjs" data-id="'.$bpjs.'">';
                                    echo '      <small>'.$bpjs.'</small>'; 
                                    echo '  </a>';
                                    echo '</small>';
                                }
                            ?>
                        </td>
                        <td class="text-left">
                            <?php 
                                echo "<dt>Daftar. $TanggalFormat</dt>"; 
                                echo '<small class="text-muted">Email : '.$email.'</small>';
                            ?>
                        </td>
                        <td class="text-left">
                            <?php 
                                if(empty($value['kontak'])){
                                    echo '<dt>Kontak: '.$kontak.'</dt>'; 
                                }else{
                                    echo'<dt>';
                                    echo '  Kontak:';
                                    echo '  <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailKontak" data-id="'.$kontak.'">';
                                    echo '      '.$kontak.''; 
                                    echo '  </a>';
                                    echo '</dt>';
                                }
                                echo '<small class="text-muted">TTL: '.$tepat_lahir.', '.$tanggal_lahir.'</small>';
                            ?>
                        </td>
                        <td class="text-center"><?php echo "$LabelStatus"; ?></td>
                        <td class="text-center">
                            <div class="btn-group dropdown-split-inverse">
                                <button type="button" class="btn btn-sm btn-inverse dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                                    <i class="ti ti-settings"></i>
                                </button>
                                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalDetailPasien" data-id="<?php echo "$id_web_pasien"; ?>">
                                        <i class="ti ti-info-alt"></i> Detail
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item waves-effect waves-light" href="index.php?Page=WebAksesPasien&Sub=EditPasien&id=<?php echo "$id_web_pasien"; ?>">
                                        <i class="ti-pencil"></i> Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusPasien" data-id="<?php echo "$id_web_pasien"; ?>">
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
<div class="card-footer text-left">
    <div class="btn-group">
        <a href="javascript:void(0);" class="b-b-primary text-primary">
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
<?php
    //looping
    
?>