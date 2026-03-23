<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'nl1n7YdCYq');
    if($StatusAkses=="Yes"){
        date_default_timezone_set('Asia/Jakarta');
        include "_Config/SimrsFunction.php";
        if(empty($_GET['id'])){
            //Apabila ID Kosong Maka Menampilkan Data Setting yang Aktif
            $id_bridging=getDataDetail($Conn,'bridging','status','Aktiv','id_bridging');
            $nama_bridging=getDataDetail($Conn,'bridging','status','Aktiv','nama_bridging');
            $consid=getDataDetail($Conn,'bridging','status','Aktiv','consid');
            $cons_id_antrol=getDataDetail($Conn,'bridging','status','Aktiv','cons_id_antrol');
            $user_key=getDataDetail($Conn,'bridging','status','Aktiv','user_key');
            $user_key_antrol=getDataDetail($Conn,'bridging','status','Aktiv','user_key_antrol');
            $secret_key=getDataDetail($Conn,'bridging','status','Aktiv','secret_key');
            $secret_key_antrol=getDataDetail($Conn,'bridging','status','Aktiv','secret_key_antrol');
            $kode_ppk=getDataDetail($Conn,'bridging','status','Aktiv','kode_ppk');
            $url_vclaim=getDataDetail($Conn,'bridging','status','Aktiv','url_vclaim');
            $url_aplicare=getDataDetail($Conn,'bridging','status','Aktiv','url_aplicare');
            $url_antrol=getDataDetail($Conn,'bridging','status','Aktiv','url_antrol');
            $url_faskes=getDataDetail($Conn,'bridging','status','Aktiv','url_faskes');
            $url_icare=getDataDetail($Conn,'bridging','status','Aktiv','url_icare');
            $kategori_ppk=getDataDetail($Conn,'bridging','status','Aktiv','kategori_ppk');
            $status=getDataDetail($Conn,'bridging','status','Aktiv','status');
        }else{
            $id=$_GET['id'];
            if($id=="Add"){
                //Apabila Perintah Tambah Profile
                $id_bridging="";
                $nama_bridging="";
                $consid="";
                $cons_id_antrol="";
                $user_key="";
                $user_key_antrol="";
                $secret_key="";
                $secret_key_antrol="";
                $kode_ppk="";
                $url_vclaim="";
                $url_aplicare="";
                $url_antrol="";
                $url_faskes="";
                $url_icare="";
                $kategori_ppk="";
                $status="";
            }else{
                //Apabila ID merupakan id Setting
                $id_bridging= $id;
                $nama_bridging=getDataDetail($Conn,'bridging','id_bridging',$id_bridging,'nama_bridging');
                $consid=getDataDetail($Conn,'bridging','id_bridging',$id_bridging,'consid');
                $cons_id_antrol=getDataDetail($Conn,'bridging','id_bridging',$id_bridging,'cons_id_antrol');
                $user_key=getDataDetail($Conn,'bridging','id_bridging',$id_bridging,'user_key');
                $user_key_antrol=getDataDetail($Conn,'bridging','id_bridging',$id_bridging,'user_key_antrol');
                $secret_key=getDataDetail($Conn,'bridging','id_bridging',$id_bridging,'secret_key');
                $secret_key_antrol=getDataDetail($Conn,'bridging','id_bridging',$id_bridging,'secret_key_antrol');
                $kode_ppk=getDataDetail($Conn,'bridging','id_bridging',$id_bridging,'kode_ppk');
                $url_vclaim=getDataDetail($Conn,'bridging','id_bridging',$id_bridging,'url_vclaim');
                $url_aplicare=getDataDetail($Conn,'bridging','id_bridging',$id_bridging,'url_aplicare');
                $url_antrol=getDataDetail($Conn,'bridging','id_bridging',$id_bridging,'url_antrol');
                $url_faskes=getDataDetail($Conn,'bridging','id_bridging',$id_bridging,'url_faskes');
                $url_icare=getDataDetail($Conn,'bridging','id_bridging',$id_bridging,'url_icare');
                $kategori_ppk=getDataDetail($Conn,'bridging','id_bridging',$id_bridging,'kategori_ppk');
                $status=getDataDetail($Conn,'bridging','id_bridging',$id_bridging,'status');
            }
        }
?>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <form action="javascript:void(0);" method="POST" id="ProsesSettingBridging">
                                <input type="hidden" name="id_bridging" id="id_bridging" value="<?php echo "$id_bridging"; ?>" >
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <h4><i class="icofont-connection"></i> Bridging BPJS</h4>
                                                Kelola pengaturan koneksi bridging BPJS, Cont ID, URL service, baik untuk rumah sakit atau Pcare.
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-sm btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalSettingBridging">
                                                    <i class="ti ti-more"></i> Profile Pengaturan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <label for="nama_bridging" class="col-sm-2 col-form-label text-dark">Nama Profile</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="nama_bridging" id="nama_bridging" value="<?php echo "$nama_bridging";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="consid" class="col-sm-2 col-form-label text-dark">Cont ID</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="consid" id="consid" value="<?php echo "$consid";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="cons_id_antrol" class="col-sm-2 col-form-label text-dark">Cont ID Antrol</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="cons_id_antrol" id="cons_id_antrol" value="<?php echo "$cons_id_antrol";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="user_key" class="col-sm-2 col-form-label text-dark">User Key</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="user_key" id="user_key" value="<?php echo "$user_key";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="user_key_antrol" class="col-sm-2 col-form-label text-dark">User Key Antrol</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="user_key_antrol" id="user_key_antrol" value="<?php echo "$user_key_antrol";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="secret_key" class="col-sm-2 col-form-label text-dark">Secret Key</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="secret_key" id="secret_key" value="<?php echo "$secret_key";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="secret_key_antrol" class="col-sm-2 col-form-label text-dark">Secret Key Antrol</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="secret_key_antrol" id="secret_key_antrol" value="<?php echo "$secret_key_antrol";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="kode_ppk" class="col-sm-2 col-form-label text-dark">Kode PPK</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="kode_ppk" id="kode_ppk" value="<?php echo "$kode_ppk";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="url_vclaim" class="col-sm-2 col-form-label text-dark">URL Vclaim/Pcare</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="url_vclaim" id="url_vclaim" value="<?php echo "$url_vclaim";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="url_aplicare" class="col-sm-2 col-form-label text-dark">URL Aplicare</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="url_aplicare" id="url_aplicare" value="<?php echo "$url_aplicare";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="url_antrol" class="col-sm-2 col-form-label text-dark">URL Antrol</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="url_antrol" id="url_antrol" value="<?php echo "$url_antrol";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="url_faskes" class="col-sm-2 col-form-label text-dark">URL Faskes</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="url_faskes" id="url_faskes" value="<?php echo "$url_faskes";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="url_icare" class="col-sm-2 col-form-label text-dark">URL i-care</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="url_icare" id="url_icare" value="<?php echo "$url_icare";?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="kategori_ppk" class="col-sm-2 col-form-label text-dark">Kategori PPK</label>
                                            <div class="col-sm-10">
                                                <select name="kategori_ppk" id="kategori_ppk" class="form-control" required>
                                                    <option <?php if($kategori_ppk=="PCare"){echo "selected";} ?> value="PCare">PCare</option>
                                                    <option <?php if($kategori_ppk=="Rumah Sakit"){echo "selected";} ?> value="Rumah Sakit">Rumah Sakit</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label  class="col-sm-2 col-form-label text-dark">Status Profile</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" <?php if($status=="Aktiv"){echo "checked";} ?> id="status" name="status" value="Aktiv"> <label for="status"> Aktivkan Profile Setting</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-md-12" id="NotifikasiSimpanSettingBridging">
                                                Pastikan informasi pengaturan bridging sudah benar.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <?php if(!empty($_GET['id'])){ ?>
                                                <div class="col-md-3 mb-2">
                                                    <button type="submit" class="btn btn-sm btn-primary btn-block">
                                                        <i class="ti-save"></i> Simpan Pengaturan
                                                    </button>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <button type="button" class="btn btn-sm btn-inverse btn-block" data-toggle="modal" data-target="#ModalTestKoneksiBridging">
                                                        <i class="ti-control-play"></i> Test Koneksi
                                                    </button>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <button type="button" class="btn btn-sm btn-seondary btn-block" data-toggle="modal" data-target="#ModalTestIcare">
                                                        <i class="ti-control-play"></i> I-Care Conf
                                                    </button>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <button type="button" class="btn btn-sm btn-danger btn-block" data-toggle="modal" data-target="#ModalHapusSettingBridging" data-id="<?php echo $id_bridging; ?>">
                                                        <i class="ti-trash"></i> Hapus Profile
                                                    </button>
                                                </div>
                                            <?php }else{ ?>
                                                <div class="col-md-4 mb-2">
                                                    <button type="submit" class="btn btn-sm btn-primary btn-block">
                                                        <i class="ti-save"></i> Simpan Pengaturan
                                                    </button>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <button type="button" class="btn btn-sm btn-inverse btn-block" data-toggle="modal" data-target="#ModalTestKoneksiBridging">
                                                        <i class="ti-control-play"></i> Test Koneksi
                                                    </button>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <button type="button" class="btn btn-sm btn-seondary btn-block" data-toggle="modal" data-target="#ModalTestIcare">
                                                        <i class="ti-control-play"></i> I-Care Conf
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