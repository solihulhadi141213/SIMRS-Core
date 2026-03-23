<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'3cesc0LfAU');
    if($StatusAkses=="Yes"){
        include "_Page/TopDiagnosa/TopDiagnosaHome.php";
    }else{
        include "_Page/UnPage/ErrorPage.php";
    }
?>