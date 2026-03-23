<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap kfa_code
    if(empty($_POST['kfa_code'])){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      Kode KFA Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $kfa_code=$_POST['kfa_code'];
        //Setting
        $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
        $kfa_url=getDataDetail($Conn,'setting_satusehat','status','Active','kfa_url');
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
                echo '      Generate Token Gagal!';
                echo '  </div>';
                echo '</div>';
            }else{
                $GetDetailKfa=GetDetailKfa($kfa_url,$Token,$kfa_code);
                if(empty($GetDetailKfa)){
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12 text-center text-danger">';
                    echo '          Tidak ada response dari satu sehat';
                    echo '      </div>';
                    echo '  </div>';
                }else{
                    $data = json_decode($GetDetailKfa, true);
                    $search_code=$data['search_code'];
                    $search_identifier=$data['search_identifier'];
                    $result=$data['result'];
                    if(empty($result['active_ingredients'])){
                        echo '  <div class="row">';
                        echo '      <div class="col-md-12 text-center text-danger">';
                        echo '          Tidak ada informasi ingridient pada item KFA ini';
                        echo '      </div>';
                        echo '  </div>';
                    }else{
                        $active_ingredients=$result['active_ingredients'];
                        $active_ingredients_count=count($active_ingredients);
                        if(empty($active_ingredients_count)){
                            echo '  <div class="row">';
                            echo '      <div class="col-md-12 text-center text-danger">';
                            echo '          Tidak ada informasi list ingridient pada item KFA ini';
                            echo '      </div>';
                            echo '  </div>';
                        }else{
                            $no=1;
                            foreach($active_ingredients as $active_ingredients_list){
                                $active_ingredients_active=$active_ingredients_list['active'];
                                $active_ingredients_kfa_code=$active_ingredients_list['kfa_code'];
                                $active_ingredients_zat_aktif=$active_ingredients_list['zat_aktif'];
                                $active_ingredients_kekuatan_zat_aktif=$active_ingredients_list['kekuatan_zat_aktif'];
?>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <dt>
                                            <?php echo "$no. $active_ingredients_zat_aktif"; ?>
                                        </dt>
                                        <ul>
                                            <li>Is Active : <code><?php echo $active_ingredients_active;?></code></li>
                                            <li>Kode KFA : <code><?php echo $active_ingredients_kfa_code;?></code></li>
                                            <li>Kekuatan Zat Aktiv : <code><?php echo $active_ingredients_kekuatan_zat_aktif;?></code></li>
                                        </ul>
                                    </div>
                                </div>
<?php 
                                $no++;
                            }
                        }
                    }
                }
            }
        }
    } 
?>