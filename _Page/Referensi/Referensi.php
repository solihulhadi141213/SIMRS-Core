<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10"><a href="" class="h5"><i class="icofont-ui-social-link"></i> Referensi</a></h5>
                    <p class="m-b-0">Kelola Data Referensi Dan Kelengkapan Rumah Sakit</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include "_Config/SimrsFunction.php";
    if(empty($_GET['Sub'])){
        include "_Page/Referensi/Organization.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="Organization"){
            include "_Page/Referensi/Organization.php";
        }else{
            if($Sub=="DetailOrganizationSimrs"){
                include "_Page/Referensi/DetailOrganizationSimrs.php";
            }else{
                if($Sub=="DetailOrganizationSatuSehat"){
                    include "_Page/Referensi/DetailOrganizationSatuSehat.php";
                }else{
                    if($Sub=="Location"){
                        include "_Page/Referensi/Location.php";
                    }else{
                        if($Sub=="Practitioner"){
                            include "_Page/Referensi/Practitioner.php";
                        }else{
                            if($Sub=="Loinc"){
                                include "_Page/Referensi/Loinc.php";
                            }else{
                                if($Sub=="Snomed"){
                                    include "_Page/Referensi/Snomed.php";
                                }else{
                                    include "_Page/Referensi/Organization.php";
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>