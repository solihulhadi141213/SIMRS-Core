<?php
    $QrySettingWeb = mysqli_query($Conn,"SELECT * FROM setting_web")or die(mysqli_error($Conn));
    $DataSettingWeb = mysqli_fetch_array($QrySettingWeb);
    $user_key= $DataSettingWeb['user_key'];
    $access_key= $DataSettingWeb['access_key'];
    $base_url_service= $DataSettingWeb['base_url_service'];
    $updatetime= $DataSettingWeb['last_update'];
    $strtotime= strtotime($updatetime);
    $last_update_setting= date('d/m/Y H:i',$strtotime);
?>