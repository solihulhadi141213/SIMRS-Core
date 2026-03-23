<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="index.php?Page=Diagnosa" class="h5">
                            <i class="fa fa-book"></i> Referensi Diagnosa
                        </a>
                    </h5>
                    <p class="m-b-0">Kelola Data Referensi Diagnosa</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    if(empty($_GET['Sub'])){
        include "_Page/Diagnosa/DiagnosaSimrs.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="DiagnosaBpjs"){
            include "_Page/Diagnosa/DiagnosaBpjs.php";
        }else{
            if($Sub=="DiagnosaSimrs"){
                include "_Page/Diagnosa/DiagnosaSimrs.php";
            }else{
                include "_Page/Diagnosa/DiagnosaBpjs.php";
            }
        }
    }
?>