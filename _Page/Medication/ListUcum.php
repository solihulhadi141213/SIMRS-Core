<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Url File referensi medication form
    $file_json="../../assets/referensi_json/ucum_med_ind_strength.json";
    if(!file_exists($file_json)){
        echo '<option value="No File">';
    }else{
        $data = file_get_contents($file_json);
        $raw_data = json_decode($data, true);
        $raw_data = $raw_data['list'];
        $total_items = count($raw_data);
        if(empty($total_items)){
            echo '<option value="No Data">';
        }else{
            foreach($raw_data as $list){
                $code=$list['code'];
                $display=$list['display'];
                $system=$list['system'];
                echo '<option value="'.$code.'">';
            }
        }
    }