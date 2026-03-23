<?php
    //memangil setting akses
    include "_Config/SettingAkses.php";
    //Desiossion Akses
    if($aksesibilitas=="Ya"){
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10"><a href="index.php?Page=Aksesibilitas" class="h5">Setting Akses</a></h5>
                    <p class="m-b-0">Kelola aksesibilitas pengguna berdasarkan group akses</p>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <a href="index.php?Page=Akses" class="btn btn-md btn-info">
                    <i class="ti-arrow-circle-left text-white"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="card table-card">
                            <div class="card-header border-info">
                                <form action="javascript:void(0);" id="BatasPencarian">
                                    <div class="row">
                                        <div class="col col-md-6">
                                            <label for="GroupAkses">Group Akses</label>
                                            <select name="GroupAkses" id="SelecAksesGroup" class="form-control">
                                                <?php
                                                    echo '<option value="">Pilih..</option>';
                                                    //Buka data akses group akses
                                                    $query = mysqli_query($Conn, "SELECT DISTINCT akses FROM akses");
                                                    while ($data = mysqli_fetch_array($query)) {
                                                        $NamaAkses= $data['akses'];
                                                        echo '<option value="'.$NamaAkses.'">'.$NamaAkses.'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="MenampilkanTabelAkses">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 text-primary">
                                            Silahkan pilih group akses terlebih dulu untuk menampilkan setting aksesibilitas.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    }
?>