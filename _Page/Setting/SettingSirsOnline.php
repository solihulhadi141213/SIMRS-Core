<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'I5FpOiKA1g');
    if($StatusAkses=="Yes"){
        date_default_timezone_set('Asia/Jakarta');
        include "_Config/SimrsFunction.php";
        if(empty($_GET['id'])){
            //Apabila ID Kosong Maka Menampilkan Data Setting yang Aktif
            $id_setting_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_setting_sirs_online');
            $nama_setting=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','nama_setting');
            $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
            $id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
            $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
            $status=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','status');
        }else{
            $id=$_GET['id'];
            if($id=="Add"){
                //Apabila Perintah Tambah Profile
                $id_setting_sirs_online="";
                $nama_setting="";
                $url_sirs_online="";
                $id_rs="";
                $password_sirs_online="";
                $status="";
            }else{
                //Apabila ID merupakan id Setting
                $id_setting_sirs_online=getDataDetail($Conn,'setting_sirs_online','id_setting_sirs_online',''.$id.'','id_setting_sirs_online');
                $nama_setting=getDataDetail($Conn,'setting_sirs_online','id_setting_sirs_online',''.$id.'','nama_setting');
                $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','id_setting_sirs_online',''.$id.'','url_sirs_online');
                $id_rs=getDataDetail($Conn,'setting_sirs_online','id_setting_sirs_online',''.$id.'','id_rs');
                $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','id_setting_sirs_online',''.$id.'','password_sirs_online');
                $status=getDataDetail($Conn,'setting_sirs_online','id_setting_sirs_online',''.$id.'','status');
            }
        }
?>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <form action="javascript:void(0);" method="POST" id="ProsesSettingSirsOnline">
                                <input type="hidden" name="id_setting_sirs_online" id="id_setting_sirs_online" value="<?php echo "$id_setting_sirs_online"; ?>" >
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <h4><i class="icofont-connection"></i> Integrasi SIRS Online</h4>
                                                Kelola pengaturan koneksi dengan SIRS Online Kemenkes.
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-sm btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalSettingSirsOnline">
                                                    <i class="ti ti-more"></i> Profile Pengaturan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <label for="nama_setting" class="col-sm-2 col-form-label text-dark">Nama Profile</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="nama_setting" id="nama_setting" value="<?php echo "$nama_setting";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="url_sirs_online" class="col-sm-2 col-form-label text-dark">URL SIRS Online</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="url_sirs_online" id="url_sirs_online" value="<?php echo "$url_sirs_online";?>" placeholder="https://" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="id_rs" class="col-sm-2 col-form-label text-dark">ID RS</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="id_rs" id="id_rs" value="<?php echo "$id_rs";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="password_sirs_online" class="col-sm-2 col-form-label text-dark">Password</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="password_sirs_online" id="password_sirs_online" value="<?php echo "$password_sirs_online";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label  class="col-sm-2 col-form-label text-dark">Status Profile</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" <?php if($status=="Aktiv"){echo "checked";} ?> id="status" name="status" value="Aktiv"> <label for="status"> Aktivkan Setting SIRS Online</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-md-12" id="NotifikasiSimpanSettingSirsOnline">
                                                Pastikan informasi pengaturan SIRS Online sudah benar.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <?php if(!empty($_GET['id'])){ ?>
                                                <div class="col-md-4 mb-2">
                                                    <button type="submit" class="btn btn-sm btn-primary btn-block">
                                                        <i class="ti-save"></i> Simpan Pengaturan
                                                    </button>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <button type="button" class="btn btn-sm btn-inverse btn-block" data-toggle="modal" data-target="#ModalTestKoneksiSirsOnline">
                                                        <i class="ti-control-play"></i> Test Koneksi
                                                    </button>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <button type="button" class="btn btn-sm btn-danger btn-block" data-toggle="modal" data-target="#ModalHapusSettingSirsOnline" data-id="<?php echo $id_setting_sirs_online; ?>">
                                                        <i class="ti-trash"></i> Hapus Profile
                                                    </button>
                                                </div>
                                            <?php }else{ ?>
                                                <div class="col-md-6 mb-2">
                                                    <button type="submit" class="btn btn-sm btn-primary btn-block">
                                                        <i class="ti-save"></i> Simpan Pengaturan
                                                    </button>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <button type="button" class="btn btn-sm btn-inverse btn-block" data-toggle="modal" data-target="#ModalTestKoneksiSirsOnline">
                                                        <i class="ti-control-play"></i> Test Koneksi
                                                    </button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    }else{
        include "_Page/UnPage/ErrorPageSub.php";
    }
?>