<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'yAFYY0uO14');
    if($StatusAkses=="Yes"){
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="icofont-capsule"></i> Medication</a>
                    </h5>
                    <p class="m-b-0">
                        Halaman ini digunakan untuk mengelola data medication obat yang terhubung dengan platform satu sehat.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <?php
                    if(empty($_GET['Sub'])){
                        include "_Page/Medication/MedicationHome.php";
                    }else{
                        $Sub=$_GET['Sub'];
                        if($Sub=="DetailMedication"){
                            include "_Page/Medication/DetailMedication.php";
                        }else{
                            if($Sub=="TambahMedication"){
                                include "_Page/Medication/TambahMedication.php";
                            }else{
                                if($Sub=="EditMedication"){
                                    include "_Page/Medication/EditMedication.php";
                                }else{
                                    include "_Page/Medication/MedicationHome.php";
                                }
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
    }else{
        include "_Page/UnPage/ErrorPage.php";
    }
?>