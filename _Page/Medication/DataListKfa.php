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
        echo '<option value="Tidak ada setting satu sehat yang aktiv">';
    }else{
        if(empty($Token)){
            echo '<option value="Generate Token Gagal">';
        }else{
            if(empty($_POST['keyword'])){
                echo '<option value="Ketik Kata Kunci KFA Terlebih Dulu">';
            }else{
                $keyword=$_POST['keyword'];
                $product_type="farmasi";
                $size="20";
                $page="1";
                $GetAllKfa=GetAllKfa($kfa_url,$Token,$page,$size,$product_type,$keyword);
                if(empty($GetAllKfa)){
                    echo '<option value="No Response">';
                }else{
                    $data = json_decode($GetAllKfa, true);
                    $total=$data['total'];
                    if(empty($total)){
                        echo '<option value="No Data">';
                    }else{
                        $no=1+$posisi;
                        $list=$data['items']['data'];
                        foreach($list as $list_kfa){
                            $name=$list_kfa['name'];
                            $kfa_code=$list_kfa['kfa_code'];
                            echo '<option value="'.$kfa_code.'|'.$name.'">';
                        }
                    }
                }
            }
        }
    }
?>