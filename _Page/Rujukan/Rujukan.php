<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'05oTlNw4Y7');
    if($StatusAkses=="Yes"){
        if(!empty($_GET['Sub'])){
            $SubPage=$_GET['Sub'];
            if($SubPage=="RujukanInternal"){
                include "_Page/Rujukan/RujukanInternal.php";
            }else{
                if($SubPage=="BuatRujukan"){
                    include "_Page/Rujukan/FormTambahRujukan.php";
                }else{
                    if($SubPage=="RujukanBpjs"){
                        include "_Page/Rujukan/RujukanBpjs.php";
                    }else{
                        if($SubPage=="EditRukan"){
                            include "_Page/Rujukan/EditRukan.php";
                        }else{
                            if($SubPage=="RujukanKhusus"){
                                include "_Page/Rujukan/RujukanKhusus.php";
                            }else{
                                if($SubPage=="BuatRujukanKhusus"){
                                    include "_Page/Rujukan/BuatRujukanKhusus.php";
                                }else{
                                    include "_Page/Rujukan/RujukanHome.php";
                                }
                            }
                        }
                    }
                }
            }
        }else{
            include "_Page/Rujukan/RujukanHome.php";
        }
    }else{
        include "_Page/UnPage/ErrorPage.php";
    }
?>