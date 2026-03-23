<?php
    //Desiossion
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'3jt6XIicT7');
    if($StatusAkses=="Yes"){
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="" class="h5"><i class="icofont-patient-file"></i> Approval</a>
                        </h5>
                        <p class="m-b-0">Pengajuan approval backdate SEP dan Fingerprint.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
        if(empty($_GET['Sub'])){
            include "_Page/Approval/ApprovalHome.php";
        }else{
            $Sub=$_GET['Sub'];
            if($Sub=="TambahApproval"){
                include "_Page/Approval/TambahApproval.php";
            }else{
                if($Sub=="DetailApproval"){
                    include "_Page/Approval/DetailApproval.php";
                }else{
                    include "_Page/Approval/ApprovalHome.php";
                }
            }
        }
    }else{
        include "_Page/UnPage/ErrorPage.php";
    }
?>