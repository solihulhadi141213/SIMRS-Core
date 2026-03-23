<?php
    //koneksi dan session
    ini_set("display_errors","off");
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
    }else{
        $ShortBy="DESC";
    }
    //OrderBy
    if(!empty($_POST['OrderBy'])){
        $OrderBy=$_POST['OrderBy'];
    }else{
        $OrderBy="id_api_access";
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
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM api_access"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM api_access WHERE api_name like '%$keyword%' OR client_id like '%$keyword%' OR datetime_creat like '%$keyword%' OR datetime_update like '%$keyword%'"));
        }
    }else{
        if(empty($keyword)){
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM api_access"));
        }else{
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM api_access WHERE $keyword_by like '%$keyword%'"));
        }
    }
    $JmlHalaman = ceil($jml_data/$batas); 
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
<script>
    //ketika klik next
    $('#NextPage').click(function() {
        var valueNext=$('#NextPage').val();
        $('#page').val(valueNext);
        ShowTableApiKey();
    });
    //Ketika klik Previous
    $('#PrevPage').click(function() {
        var ValuePrev = $('#PrevPage').val
        $('#page').val(ValuePrev);
        ShowTableApiKey();
    });
</script>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">
                            <dt>No</dt>
                        </th>
                        <th class="text-center">
                            <dt>API Name</dt>
                        </th>
                        <th class="text-center">
                            <dt>Client ID</dt>
                        </th>
                        <th class="text-center">
                            <dt>Datetime Creat</dt>
                        </th>
                        <th class="text-center">
                            <dt>Update</dt>
                        </th>
                        <th class="text-center">
                            <dt>Log</dt>
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
                            echo '  <td class="text-center text-danger" colspan="7" align="center">';
                            echo '      Tidak Ada Data API Key Yang Ditampilkan';
                            echo '  </td>';
                            echo '</tr>';
                        }else{
                            $no = 1+$posisi;
                            //KONDISI PENGATURAN MASING FILTER
                            if(empty($keyword_by)){
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT*FROM api_access ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM api_access WHERE api_name like '%$keyword%' OR client_id like '%$keyword%' OR datetime_creat like '%$keyword%' OR datetime_update like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }else{
                                if(empty($keyword)){
                                    $query = mysqli_query($Conn, "SELECT*FROM api_access ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }else{
                                    $query = mysqli_query($Conn, "SELECT*FROM api_access WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                                }
                            }
                            while ($data = mysqli_fetch_array($query)) {
                                $id_api_access= $data['id_api_access'];
                                $api_name= $data['api_name'];
                                $client_id= $data['client_id'];
                                $datetime_creat= $data['datetime_creat'];
                                $datetime_update= $data['datetime_update'];
                                //Format Tanggal
                                $strtotime1=strtotime($datetime_creat);
                                $strtotime2=strtotime($datetime_update);
                                $datetime_creat=date('d/m/Y H:i',$strtotime1);
                                $datetime_update=date('d/m/Y H:i',$strtotime2);
                                //Menghitung Jumlah Log
                                $JumlahLog = mysqli_num_rows(mysqli_query($Conn, "SELECT id_api_log FROM api_log WHERE id_api_access='$id_api_access'"));
                        ?>
                            <tr>
                                <td align="center">
                                    <small>
                                        <?php echo $no;?>
                                    </small>
                                </td>
                                <td align="left">
                                    <small>
                                        <?php echo $api_name;?>
                                    </small>
                                </td>
                                <td align="left">
                                    <small>
                                        <?php echo $client_id;?>
                                    </small>
                                </td>
                                <td align="left">
                                    <small>
                                        <?php echo $datetime_creat;?>
                                    </small>
                                </td>
                                <td align="left">
                                    <small>
                                        <?php echo $datetime_update;?>
                                    </small>
                                </td>
                                <td align="left">
                                    <small>
                                        <?php echo "$JumlahLog Record";?>
                                    </small>
                                </td>
                                <td align="center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalEditApiKeyService" data-id="<?php echo $id_api_access; ?>">
                                            <i class="ti ti-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapusApiKey" data-id="<?php echo $id_api_access; ?>">
                                            <i class="ti ti-close"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                    <?php
                            $no++; }
                        }
                    ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center">
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-secondary" id="PrevPage" value="<?php echo $prev;?>">
                <i class="ti-angle-left"></i>
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <?php echo "$page/$JmlHalaman"; ?>
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="NextPage" value="<?php echo $next;?>">
                <i class="ti-angle-right"></i>
            </button>
        </div>
    </div>
</div>