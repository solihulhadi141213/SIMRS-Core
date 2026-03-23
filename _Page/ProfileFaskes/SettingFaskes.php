<?php
    date_default_timezone_set('Asia/Jakarta');
    //memangil setting akses
    include "_Config/SettingAkses.php";
    //Desiossion Akses
    if($SettingProfile=="Ya"){
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10"><a href="index.php?Page=SettingProfile" class="h5">Setting Profile Faskes</a></h5>
                        <p class="m-b-0">Kelola informasi mengenai profile Faskes</p>
                    </div>
                </div>
                <div class="col-md-4 text-right">
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
                                    <form action="javascript:void(0);" id="SettingProfileFaskes">
                                        <h4 class="sub-title"><dt>Informasi Dasar Faskes</dt></h4>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Nama Faskes</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="nama_faskes" value="<?php echo $NamaFaskes;?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Kode Faskes</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="kode" value="<?php echo $KodeFaskes;?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Alamat</label>
                                            <div class="col-sm-10">
                                                <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control"><?php echo $AlamatFaskes;?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">No.Kontak</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="kontak" value="<?php echo $KontakFaskes;?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">E-mail</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" name="email" value="<?php echo $EmailFaskes;?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Link Website</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="link_website" value="<?php echo $LinkWebsiteFaskes;?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Base URL</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="base_url" value="<?php echo $BaseUrl;?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Tahun Berdiri</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="tahun_berdiri" value="<?php echo $TahunBerdiriFaskes;?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Direktur Faskes</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="direktur" value="<?php echo $DirekturFaskes;?>" required>
                                            </div>
                                        </div>
                                        <h4 class="sub-title"><b>Visi & Misi</b></h4>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Visi</label>
                                            <div class="col-sm-10">
                                                <textarea name="visi" id="visi" cols="30" rows="5" class="form-control"><?php echo $VisiFaskes;?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label text-dark">Misi</label>
                                            <div class="col-sm-10">
                                                <textarea name="misi" id="misi" cols="30" rows="5" class="form-control"><?php echo $MisiFaskes;?></textarea>
                                            </div>
                                        </div>
                                        <div class="row text-center">
                                            <div class="col col-md-12 text-center mt-4">
                                                <button type="submit" class="btn btn-md btn-info mr-3" id="ClickSimpanSettingProfile">
                                                    <i class="ti-save"></i> Simpan
                                                </button>
                                                <button type="reset" class="btn btn-md btn-danger">
                                                    <i class="ti-reload"></i> Reset
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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