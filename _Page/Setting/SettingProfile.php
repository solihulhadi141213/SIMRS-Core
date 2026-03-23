<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'LX8gL8QXX9');
    if($StatusAkses=="Yes"){
        date_default_timezone_set('Asia/Jakarta');
        include "_Config/SimrsFunction.php";
        if(empty($_GET['id'])){
            //Apabila ID Kosong Maka Menampilkan Data Setting yang Aktif
            $id_profile=getDataDetail($Conn,'setting_profile','status','Active','id_profile');
            $kode_faskes=getDataDetail($Conn,'setting_profile','status','Active','kode_faskes');
            $nama_faskes=getDataDetail($Conn,'setting_profile','status','Active','nama_faskes');
            $alamat_faskes=getDataDetail($Conn,'setting_profile','status','Active','alamat_faskes');
            $kontak_faskes=getDataDetail($Conn,'setting_profile','status','Active','kontak_faskes');
            $email_faskes=getDataDetail($Conn,'setting_profile','status','Active','email_faskes');
            $link_website=getDataDetail($Conn,'setting_profile','status','Active','link_website');
            $base_url=getDataDetail($Conn,'setting_profile','status','Active','base_url');
            $tahun_berdiri=getDataDetail($Conn,'setting_profile','status','Active','tahun_berdiri');
            $direktur_faskes=getDataDetail($Conn,'setting_profile','status','Active','direktur_faskes');
            $visi_faskes=getDataDetail($Conn,'setting_profile','status','Active','visi_faskes');
            $misi_faskes=getDataDetail($Conn,'setting_profile','status','Active','misi_faskes');
            $judul_tab=getDataDetail($Conn,'setting_profile','status','Active','judul_tab');
            $judul_halaman=getDataDetail($Conn,'setting_profile','status','Active','judul_halaman');
            $warna=getDataDetail($Conn,'setting_profile','status','Active','warna');
            $favicon=getDataDetail($Conn,'setting_profile','status','Active','favicon');
            $logo=getDataDetail($Conn,'setting_profile','status','Active','logo');
            $status=getDataDetail($Conn,'setting_profile','status','Active','status');
        }else{
            $id=$_GET['id'];
            if($id=="Add"){
                //Apabila Perintah Tambah Profile
                $id_profile="";
                $kode_faskes="";
                $nama_faskes="";
                $alamat_faskes="";
                $kontak_faskes="";
                $email_faskes="";
                $link_website="";
                $base_url="";
                $tahun_berdiri="";
                $direktur_faskes="";
                $visi_faskes="";
                $misi_faskes="";
                $judul_tab="";
                $judul_halaman="";
                $warna="";
                $favicon="";
                $logo="";
                $status="";
            }else{
                //Apabila ID merupakan id Setting
                $id_profile=getDataDetail($Conn,'setting_profile','id_profile',$id,'id_profile');
                $kode_faskes=getDataDetail($Conn,'setting_profile','id_profile',$id,'kode_faskes');
                $nama_faskes=getDataDetail($Conn,'setting_profile','id_profile',$id,'nama_faskes');
                $alamat_faskes=getDataDetail($Conn,'setting_profile','id_profile',$id,'alamat_faskes');
                $kontak_faskes=getDataDetail($Conn,'setting_profile','id_profile',$id,'kontak_faskes');
                $email_faskes=getDataDetail($Conn,'setting_profile','id_profile',$id,'email_faskes');
                $link_website=getDataDetail($Conn,'setting_profile','id_profile',$id,'link_website');
                $base_url=getDataDetail($Conn,'setting_profile','id_profile',$id,'base_url');
                $tahun_berdiri=getDataDetail($Conn,'setting_profile','id_profile',$id,'tahun_berdiri');
                $direktur_faskes=getDataDetail($Conn,'setting_profile','id_profile',$id,'direktur_faskes');
                $visi_faskes=getDataDetail($Conn,'setting_profile','id_profile',$id,'visi_faskes');
                $misi_faskes=getDataDetail($Conn,'setting_profile','id_profile',$id,'misi_faskes');
                $judul_tab=getDataDetail($Conn,'setting_profile','id_profile',$id,'judul_tab');
                $judul_halaman=getDataDetail($Conn,'setting_profile','id_profile',$id,'judul_halaman');
                $warna=getDataDetail($Conn,'setting_profile','id_profile',$id,'warna');
                $favicon=getDataDetail($Conn,'setting_profile','id_profile',$id,'favicon');
                $logo=getDataDetail($Conn,'setting_profile','id_profile',$id,'logo');
                $status=getDataDetail($Conn,'setting_profile','id_profile',$id,'status');
            }
        }
?>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <form action="javascript:void(0);" method="POST" id="ProsesSettingProfileFaskes">
                                <input type="hidden" name="id_profile" id="id_profile" value="<?php echo "$id_profile"; ?>" >
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <h4><i class="icofont-hospital"></i> Profile Faskes</h4>
                                                Kelola informasi utama/profile faskes.
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-sm btn-outline-dark btn-block" data-toggle="modal" data-target="#ModalSettingProfileFaskes">
                                                    <i class="ti ti-more"></i> Profile Pengaturan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="sub-title"><dt>Informasi Umum</dt></h4>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Nama Faskes</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="nama_faskes" id="nama_faskes" value="<?php echo $nama_faskes;?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Kode Faskes</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="kode_faskes" id="kode_faskes" value="<?php echo $kode_faskes;?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Alamat</label>
                                            <div class="col-sm-10">
                                                <textarea name="alamat_faskes" id="alamat_faskes" cols="30" rows="5" class="form-control"><?php echo $alamat_faskes;?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">No.Kontak</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="kontak_faskes" id="kontak_faskes" value="<?php echo $kontak_faskes;?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">E-mail</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" name="email_faskes" id="email_faskes" value="<?php echo $email_faskes;?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Tahun Berdiri</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="tahun_berdiri" id="tahun_berdiri" value="<?php echo $tahun_berdiri;?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Direktur Faskes</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="direktur_faskes" value="<?php echo $direktur_faskes;?>" required>
                                            </div>
                                        </div>
                                        <h4 class="sub-title"><dt>Visi & Misi</dt></h4>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Visi</label>
                                            <div class="col-sm-10">
                                                <textarea name="visi_faskes" id="visi_faskes" cols="30" rows="5" class="form-control"><?php echo $visi_faskes;?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Misi</label>
                                            <div class="col-sm-10">
                                                <textarea name="misi_faskes" id="misi_faskes" cols="30" rows="5" class="form-control"><?php echo $misi_faskes;?></textarea>
                                            </div>
                                        </div>
                                        <h4 class="sub-title"><dt>Base URL Aplikasi</dt></h4>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Link Website</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="link_website" id="link_website" value="<?php echo $link_website;?>">
                                                <small>Apabila Faskes tidak memiliki website, isi dengan base URL aplikasi.</small>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Base URL</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="base_url" id="base_url" value="<?php echo $base_url;?>">
                                            </div>
                                        </div>
                                        <h4 class="sub-title"><dt>Personalisasi Aplikasi</dt></h4>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Judul Tab Aplikasi</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="judul_tab" value="<?php echo "$judul_tab";?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Nama Aplikasi</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="judul_halaman" value="<?php echo "$judul_halaman";?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Warna Tampilan</label>
                                            <div class="col-sm-10">
                                                <select name="warna"  id="warna" class="form-control">
                                                    <option <?php if($warna=="bg-danger"){echo "selected";} ?> value="bg-danger">bg-danger</option>
                                                    <option <?php if($warna=="bg-info"){echo "selected";} ?> value="bg-info">bg-info</option>
                                                    <option <?php if($warna=="bg-primary"){echo "selected";} ?> value="bg-primary">bg-primary</option>
                                                    <option <?php if($warna=="bg-secondary"){echo "selected";} ?> value="bg-secondary">bg-secondary</option>
                                                    <option <?php if($warna=="bg-warning"){echo "selected";} ?> value="bg-warning">bg-warning</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Image Favicon</label>
                                            <div class="col-md-8">
                                                <input type="file" class="form-control" name="favicon" id="favicon" value="<?php echo "$favicon";?>">
                                                <small>File Gambar Favicon maksimal 1 mb (jpg, jpeg. PNG)</small>
                                            </div>
                                            <div class="col-md-2">
                                                <?php
                                                    if(!empty($favicon)){
                                                        echo '<a href="assets/images/'.$favicon.'" target="_blank" class="btn btn-block btn-sm btn-success">';
                                                        echo '  Tersedia';
                                                        echo '</a>';
                                                    }else{
                                                        echo '<button type="button" disabled class="btn btn-block btn-sm btn-secondary">';
                                                        echo '  No Image';
                                                        echo '</button>';
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Image Logo</label>
                                            <div class="col-sm-8">
                                                <input type="file" class="form-control" name="logo" id="logo" value="<?php echo "$logo";?>">
                                                <small>File Gambar Logo maksimal 1 mb (jpg, jpeg. PNG)</small>
                                            </div>
                                            <div class="col-md-2">
                                                <?php
                                                    if(!empty($logo)){
                                                        echo '<a href="assets/images/'.$logo.'" target="_blank" class="btn btn-block btn-sm btn-success">';
                                                        echo '  Tersedia';
                                                        echo '</a>';
                                                    }else{
                                                        echo '<button type="button" disabled class="btn btn-block btn-sm btn-secondary">';
                                                        echo '  No Image';
                                                        echo '</button>';
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2 col-form-label text-dark">Status Pengaturan</div>
                                            <div class="col-sm-10">
                                                <input type="checkbox" name="status" id="status" value="Active" <?php if($status=="Active"){echo "checked";} ?>>
                                                <label for="status">Active</label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark"></label>
                                            <div class="col col-md-10" id="NotifikasiSimpanSettingProfileFaskes">
                                                Pastikan informasi profile faskes sudah benar.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <?php if(!empty($_GET['id'])){ ?>
                                                <div class="col-md-6 mb-2">
                                                    <button type="submit" class="btn btn-sm btn-primary btn-block">
                                                        <i class="ti-save"></i> Simpan Pengaturan
                                                    </button>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <button type="button" class="btn btn-sm btn-danger btn-block" data-toggle="modal" data-target="#ModalHapusSettingProfileFaskes" data-id="<?php echo "$id"; ?>">
                                                        <i class="ti-trash"></i> Hapus Profile
                                                    </button>
                                                </div>
                                            <?php }else{ ?>
                                                <div class="col-md-12 mb-2">
                                                    <button type="submit" class="btn btn-sm btn-primary btn-block">
                                                        <i class="ti-save"></i> Simpan Pengaturan
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