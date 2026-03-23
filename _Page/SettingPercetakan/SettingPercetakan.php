<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'C77xoLcmaq');
    if($StatusAkses=="Yes"){
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-header-title">
                    <h5 class="m-b-10"><a href="" class="h5">Setting Percetakan</a></h5>
                    <p class="m-b-0">Atur Ukuran, Font dan Warna Setiap Percetakan Dokumen Yang Anda Buat</p>
                </div>
            </div>
            <?php
                if(!empty($_GET['Subpage'])){   
                    echo '<div class="col-md-6 text-right">';
                    echo '  <a href="index.php?Page=SettingPercetakan" class="btn btn-md btn-inverse mr-2 mt-2">';
                    echo '      <i class="ti ti-angle-left text-white"></i> Kembali';
                    echo '  </a>';
                    echo '  <button class="btn btn-md btn-primary mr-2 mt-2" data-toggle="modal" data-target="#ModalTambahBridging">';
                    echo '      <i class="ti-plus text-white"></i> Duplikat Setting';
                    echo '  </button>';
                    echo '</div>';
                }         
            ?>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <?php
                        //Get Subpage
                        if(empty($_GET['Subpage'])){
                            include "_Page/SettingPercetakan/SettingPercetakanHome.php";
                        }else{
                            $Subpage=$_GET['Subpage'];
                            if($Subpage=="KartuPasien"){
                                include "_Config/SettingCetakKartuPasien.php";
                                include "_Page/SettingPercetakan/SettingKartuPasien.php";
                            }else{
                                if($Subpage=="LabelObat"){
                                    include "_Config/SettingCetakLabel.php";
                                    include "_Page/SettingPercetakan/SettingLabelObat.php";
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    }else{
        include "_Page/UnPage/ErrorPage.php";
    }
?>