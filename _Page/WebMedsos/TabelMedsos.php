<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $url=urlService('List Medsos');
?>
<div class="card-block">
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center">
                        <dt>No</dt>
                    </th>
                    <th class="text-center">
                        <dt>Image/Icon</dt>
                    </th>
                    <th class="text-center">
                        <dt>Nama Medsos</dt>
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
                    //Akses Data Dari Server Website
                    $KirimData = array(
                        'api_key' => $api_key
                    );
                    $json = json_encode($KirimData);
                    //Mulai CURL
                    $ch = curl_init();
                    curl_setopt($ch,CURLOPT_URL, "$url");
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
                        echo '  <td colspan="5" class="text-center">';
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
                            echo '  <td colspan="5" class="text-center">';
                            echo '      '.$massage.'';
                            echo '  </td>';
                            echo '</tr>';
                        }else{
                            $JumlahBaris=count($JsonData['response']['list']);
                            if(empty($JumlahBaris)){
                                echo '<tr>';
                                echo '  <td colspan="5" class="text-center">';
                                echo '      Tidak Ada Data Yang Ditampilkan';
                                echo '  </td>';
                                echo '</tr>';
                            }else{
                                $list_data=$JsonData['response']['list'];
                                $no=1;
                                foreach($list_data as $value){
                                    $id_web_medsos=$value['id_web_medsos'];
                                    $nama_medsos=$value['nama_medsos'];
                                    $url_medsos=$value['url_medsos'];
                                    $img_medsos=$value['img_medsos'];
                                    $icon_medsos=$value['icon_medsos'];
                                    $last_update=$value['last_update'];
                                    $strtotime=strtotime($last_update);
                                    $last_update=date('d/m/Y H:i',$strtotime);
                ?>
                    <tr>
                        <td class="text-center"><?php echo "$no"; ?></td>
                        <td class="text-center">
                            <?php 
                                echo '<ul>';
                                echo '  <li>';
                                echo '  <img src="'.$img_medsos.'" width="50px">';
                                echo '      <ul>';
                                echo '          <li>';
                                echo '              <i>'.$icon_medsos.'</i>';
                                echo '          </li>';
                                echo '</ul>';
                                echo '  </li>';
                                echo '</ul>';
                            ?>
                        </td>
                        <td class="text-left">
                            <?php 
                                echo '<ul>';
                                echo '  <li>';
                                echo '  <dt>'.$nama_medsos.'</dt>';
                                echo '      <ul>';
                                echo '          <li>';
                                echo '  <i>'.$url_medsos.'</i>';
                                echo '          </li>';
                                echo '</ul>';
                                echo '  </li>';
                                echo '</ul>';
                            ?>
                        </td>
                        
                        <td class="text-left"><?php echo "$last_update"; ?></td>
                        <td class="text-center">
                            <div class="btn-group dropdown-split-inverse">
                                <button type="button" class="btn btn-sm btn-inverse dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                                    <i class="ti ti-settings"></i>
                                </button>
                                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalEditMedsos" data-id="<?php echo "$id_web_medsos"; ?>">
                                        <i class="ti-pencil"></i> Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapustMedsos" data-id="<?php echo "$id_web_medsos"; ?>">
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
                ?>
            </tbody>
        </table>
        
    </div>
</div>
