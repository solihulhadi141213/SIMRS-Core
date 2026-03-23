<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10"><a href="" class="h5"><i class="ti ti-settings"></i> Setting</a></h5>
                    <p class="m-b-0">Pengaturan Aplikasi, Identitas Faskes, Tampilan dan Parameter Integrasi.</p>
                </div>
            </div>
            <div class="col-md-4 text-right">
            </div>
        </div>
    </div>
</div>
<?php
    if(empty($_GET['Sub'])){
        include "_Page/Setting/SettingProfile.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="Email"){
            include "_Page/Setting/SettingEmail.php";
        }else{
            if($Sub=="SatuSehat"){
                include "_Page/Setting/SatuSehat.php";
            }else{
                if($Sub=="SettingProfile"){
                    include "_Page/Setting/SettingProfile.php";
                }else{
                    if($Sub=="SettingBridging"){
                        include "_Page/Setting/SettingBridging.php";
                    }else{
                        if($Sub=="SirsOnline"){
                            include "_Page/Setting/SettingSirsOnline.php";
                        }else{
                            if($Sub=="Sisrute"){
                                include "_Page/Setting/Sisrute.php";
                            }
                        }
                    }
                }
            }
        }
    }
?>