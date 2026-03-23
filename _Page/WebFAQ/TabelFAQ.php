<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "FungsiFAQ.php";
    $url=urlService('List FAQ');
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
                        <dt>FAQ</dt>
                    </th>
                    <th class="text-center">
                        <dt>Posisi</dt>
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
                                $no=1;
                                foreach($list_data as $value){
                                    $id_web_faq=$value['id_web_faq'];
                                    $web_pertanyaan=$value['web_pertanyaan'];
                                    $web_jawaban=$value['web_jawaban'];
                                    $web_ururtan=$value['web_ururtan'];
                                    $preview = substr($web_jawaban, 0, 50);
                ?>
                    <tr>
                        <td class="text-center"><?php echo "$no"; ?></td>
                        <td class="text-left" width="40%%">
                            <?php 
                                echo '<ul>';
                                echo '  <li>';
                                echo '  <dt>'.$web_pertanyaan.'</dt>';
                                echo '      <ul>';
                                echo '          <li>';
                                echo '  <i>'.$preview.'...</i>';
                                echo '          </li>';
                                echo '</ul>';
                                echo '  </li>';
                                echo '</ul>';
                            ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalPosisiNaik" data-id="<?php echo "$id_web_faq"; ?>">
                                    <i class="ti ti-angle-up"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#ModalPosisiTurun" data-id="<?php echo "$id_web_faq"; ?>">
                                    <i class="ti ti-angle-down"></i>
                                </button>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-group dropdown-split-inverse">
                                <button type="button" class="btn btn-sm btn-inverse dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                                    <i class="ti ti-settings"></i>
                                </button>
                                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalEditFAQ" data-id="<?php echo "$id_web_faq"; ?>">
                                        <i class="ti-pencil"></i> Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapustFAQ" data-id="<?php echo "$id_web_faq"; ?>">
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
