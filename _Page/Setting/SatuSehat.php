<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'FBI4OxEl5b');
    if($StatusAkses=="Yes"){
        date_default_timezone_set('Asia/Jakarta');
        include "_Config/SimrsFunction.php";
        if(empty($_GET['id'])){
            //Apabila ID Kosong Maka Menampilkan Data Setting yang Aktif
            $id_setting_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','id_setting_satusehat');
            $nama_setting=getDataDetail($Conn,'setting_satusehat','status','Active','nama_setting');
            $oauth_baseurl=getDataDetail($Conn,'setting_satusehat','status','Active','oauth_baseurl');
            $baseurl=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
            $consent_url=getDataDetail($Conn,'setting_satusehat','status','Active','consent_url');
            $kfa_url=getDataDetail($Conn,'setting_satusehat','status','Active','kfa_url');
            $masterdata_url=getDataDetail($Conn,'setting_satusehat','status','Active','masterdata_url');
            $organization_id=getDataDetail($Conn,'setting_satusehat','status','Active','organization_id');
            $client_key=getDataDetail($Conn,'setting_satusehat','status','Active','client_key');
            $secret_key=getDataDetail($Conn,'setting_satusehat','status','Active','secret_key');
            $status=getDataDetail($Conn,'setting_satusehat','status','Active','status');
            $updatetime=getDataDetail($Conn,'setting_satusehat','status','Active','updatetime');
        }else{
            $id=$_GET['id'];
            if($id=="Add"){
                //Apabila Perintah Tambah Profile
                $id_setting_satusehat="";
                $nama_setting="";
                $oauth_baseurl="";
                $baseurl="";
                $consent_url="";
                $kfa_url="";
                $masterdata_url="";
                $organization_id="";
                $client_key="";
                $secret_key="";
                $status="";
                $updatetime="";
            }else{
                //Apabila ID merupakan id Setting
                $id_setting_satusehat=getDataDetail($Conn,'setting_satusehat','id_setting_satusehat',$id,'id_setting_satusehat');
                $nama_setting=getDataDetail($Conn,'setting_satusehat','id_setting_satusehat',$id,'nama_setting');
                $oauth_baseurl=getDataDetail($Conn,'setting_satusehat','id_setting_satusehat',$id,'oauth_baseurl');
                $baseurl=getDataDetail($Conn,'setting_satusehat','id_setting_satusehat',$id,'baseurl');
                $consent_url=getDataDetail($Conn,'setting_satusehat','id_setting_satusehat',$id,'consent_url');
                $kfa_url=getDataDetail($Conn,'setting_satusehat','id_setting_satusehat',$id,'kfa_url');
                $masterdata_url=getDataDetail($Conn,'setting_satusehat','id_setting_satusehat',$id,'masterdata_url');
                $organization_id=getDataDetail($Conn,'setting_satusehat','id_setting_satusehat',$id,'organization_id');
                $client_key=getDataDetail($Conn,'setting_satusehat','id_setting_satusehat',$id,'client_key');
                $secret_key=getDataDetail($Conn,'setting_satusehat','id_setting_satusehat',$id,'secret_key');
                $status=getDataDetail($Conn,'setting_satusehat','id_setting_satusehat',$id,'status');
                $updatetime=getDataDetail($Conn,'setting_satusehat','id_setting_satusehat',$id,'updatetime');
            }
        }
?>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <form action="javascript:void(0);" method="POST" id="ProsesSettingSatuSehat">
                                <input type="hidden" id="id_setting_satusehat" name="id_setting_satusehat" value="<?php echo $id_setting_satusehat;?>">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <h4><i class="icofont-heart-beat"></i> Satu Sehat</h4>
                                                Pengaturan autentifikasi dan baseurl platform satu sehat kemenkes.
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-sm btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalSettingSatuSehat">
                                                    <i class="ti ti-more"></i> Profile Pengaturan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <label for="nama_setting" class="col-sm-2 col-form-label text-dark">Nama/Label Setting</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="nama_setting" id="nama_setting" value="<?php echo "$nama_setting";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="oauth_baseurl" class="col-sm-2 col-form-label text-dark">OAuth Base URL</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="oauth_baseurl" id="oauth_baseurl" value="<?php echo "$oauth_baseurl";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="baseurl" class="col-sm-2 col-form-label text-dark">Base URL</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="baseurl" id="baseurl" value="<?php echo "$baseurl";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="consent_url" class="col-sm-2 col-form-label text-dark">Consent URL</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="consent_url" id="consent_url" value="<?php echo "$consent_url";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="kfa_url" class="col-sm-2 col-form-label text-dark">KFA URL</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="kfa_url" id="kfa_url" value="<?php echo "$kfa_url";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="masterdata_url" class="col-sm-2 col-form-label text-dark">Master Data URL</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="masterdata_url" id="masterdata_url" value="<?php echo "$masterdata_url";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="organization_id" class="col-sm-2 col-form-label text-dark">Organization ID</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="organization_id" id="organization_id" value="<?php echo "$organization_id";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="client_key" class="col-sm-2 col-form-label text-dark">Client Key</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="client_key" id="client_key" value="<?php echo "$client_key";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="secret_key" class="col-sm-2 col-form-label text-dark">Secret Key</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="secret_key" id="secret_key" value="<?php echo "$secret_key";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-sm-2 col-form-label text-dark">Status Pengaturan</div>
                                            <div class="col-sm-10">
                                                <input type="checkbox" name="status" id="status" value="Active" <?php if($status=="Active"){echo "checked";} ?>>
                                                <label for="status">Active</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2 col-form-label text-dark"></div>
                                            <div class="col col-md-10" id="NotifikasiSimpanSettingSatuSehat">
                                                Pastikan informasi pengaturan satu sehat sudah benar.
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
                                                    <button type="button" class="btn btn-sm btn-inverse btn-block" data-toggle="modal" data-target="#ModalUjiCobaSettingSatuSehat">
                                                        <i class="ti-control-play"></i> Uji Coba
                                                    </button>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <button type="button" class="btn btn-sm btn-danger btn-block" data-toggle="modal" data-target="#ModalHapusSettingSatuSehat" data-id="<?php echo $id_setting_satusehat; ?>">
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
                                                    <button type="button" class="btn btn-sm btn-inverse btn-block" data-toggle="modal" data-target="#ModalUjiCobaSettingSatuSehat">
                                                        <i class="ti-control-play"></i> Uji Coba
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