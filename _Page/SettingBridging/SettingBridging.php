<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'nl1n7YdCYq');
    if($StatusAkses=="Yes"){
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10"><a href="index.php?Page=SettingBridging" class="h5">Setting Bridging</a></h5>
                        <p class="m-b-0">Kelola Profile Pengaturan Bridging</p>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <button class="btn btn-md btn-inverse mr-2 mt-2" data-toggle="modal" data-target="#ModalTambahBridging">
                        <i class="ti-plus text-white"></i> Buat Profile
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row" id="TampilkanListProfileSettingBridging">
                        <!-- Menampilkan data list profile Setting Bridging disini -->
                    </div>
                </div>
            </div>
            <div id="styleSelector">

            </div>
        </div>
    </div>
<?php
    }else{
        include "_Page/UnPage/ErrorPage.php";
        echo "$StatusAkses";
    }
?>