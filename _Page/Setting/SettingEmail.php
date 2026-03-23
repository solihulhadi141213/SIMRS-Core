<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'kDZ0amyC6b');
    if($StatusAkses=="Yes"){
        date_default_timezone_set('Asia/Jakarta');
        include "_Config/SimrsFunction.php";
        if(empty($_GET['id'])){
            //Apabila ID Kosong Maka Menampilkan Data Setting yang Aktif
            $id_setting_email_gateway=getEmailSetting($Conn,'id_setting_email_gateway');
            $EmailGateway=getEmailSetting($Conn,'email_gateway');
            $PasswordGateway=getEmailSetting($Conn,'password_gateway');
            $UrlProvider=getEmailSetting($Conn,'url_provider');
            $PortGateway=getEmailSetting($Conn,'port_gateway');
            $NamaPengirim=getEmailSetting($Conn,'nama_pengirim');
            $UrlService=getEmailSetting($Conn,'url_service');
            $status=getEmailSetting($Conn,'status');
        }else{
            $id=$_GET['id'];
            if($id=="Add"){
                //Apabila Perintah Tambah Profile
                $id_setting_email_gateway="";
                $EmailGateway="";
                $PasswordGateway="";
                $UrlProvider="";
                $PortGateway="";
                $NamaPengirim="";
                $UrlService="";
                $status="";
            }else{
                //Apabila ID merupakan id Setting
                $id_setting_email_gateway=getDataDetail($Conn,'setting_email_gateway','id_setting_email_gateway',$id,'id_setting_email_gateway');
                $EmailGateway=getDataDetail($Conn,'setting_email_gateway','id_setting_email_gateway',$id,'email_gateway');
                $PasswordGateway=getDataDetail($Conn,'setting_email_gateway','id_setting_email_gateway',$id,'password_gateway');
                $UrlProvider=getDataDetail($Conn,'setting_email_gateway','id_setting_email_gateway',$id,'url_provider');
                $PortGateway=getDataDetail($Conn,'setting_email_gateway','id_setting_email_gateway',$id,'port_gateway');
                $NamaPengirim=getDataDetail($Conn,'setting_email_gateway','id_setting_email_gateway',$id,'nama_pengirim');
                $UrlService=getDataDetail($Conn,'setting_email_gateway','id_setting_email_gateway',$id,'url_service');
                $status=getDataDetail($Conn,'setting_email_gateway','id_setting_email_gateway',$id,'status');
            }
        }
?>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <form action="javascript:void(0);" method="POST" id="ProsesSettingEmail">
                            <input type="hidden" name="id_setting_email_gateway" id="id_setting_email_gateway" value="<?php echo "$id_setting_email_gateway"; ?>" >
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <h4><i class="ti ti-email"></i> Email Gateway</h4>
                                            Kelola pengaturan email aplikasi untuk terhubung dengan user untuk berbagai keperluan.
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-sm btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalSettingEmailgateway">
                                                <i class="ti ti-more"></i> Profile Pengaturan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <label class="col-sm-2 col-form-label text-dark">Email Gateway</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="EmailGateway" id="EmailGateway" value="<?php echo "$EmailGateway";?>" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-sm-2 col-form-label text-dark">Password Gateway</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="PasswordGateway" id="PasswordGateway" value="<?php echo "$PasswordGateway";?>" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-sm-2 col-form-label text-dark">URL Provider</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="UrlProvider" id="UrlProvider" value="<?php echo "$UrlProvider";?>" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-sm-2 col-form-label text-dark">PORT Gateway</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="PortGateway" id="PortGateway" value="<?php echo "$PortGateway";?>" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-sm-2 col-form-label text-dark">Nama Pengirim</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="NamaPengirim" id="NamaPengirim" value="<?php echo "$NamaPengirim";?>" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-sm-2 col-form-label text-dark">URL Service</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="UrlService" id="UrlService" value="<?php echo "$UrlService";?>" required>
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
                                        <label class="col-sm-2 col-form-label text-dark"></label>
                                        <div class="col col-md-10" id="NotifikasiSimpanSettingEmail">
                                            Pastikan informasi pengaturan email sudah benar.
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
                                                <button type="button" class="btn btn-sm btn-inverse btn-block" data-toggle="modal" data-target="#ModalKirimEmail">
                                                    <i class="ti-control-play"></i> Test Kirim Email
                                                </button>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <button type="button" class="btn btn-sm btn-danger btn-block" data-toggle="modal" data-target="#ModalHapusSettingEmailGateway" data-id="<?php echo $id_setting_email_gateway; ?>">
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
                                                <button type="button" class="btn btn-sm btn-inverse btn-block" data-toggle="modal" data-target="#ModalKirimEmail">
                                                    <i class="ti-control-play"></i> Test Kirim Email
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