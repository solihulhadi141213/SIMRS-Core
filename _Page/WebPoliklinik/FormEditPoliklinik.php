<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="index.php?Page=WebPoliklinik" class="h5"><i class="ti ti-view-grid"></i> Poliklinik</a>
                    </h5>
                    <p class="m-b-0">Kelola data Poliklinik halaman website</p>
                </div>
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
                        <?php
                            if(empty($_GET['id'])){
                                echo '<div class="card">';
                                echo '  <div class="card-body">';
                                echo '      ID Artikel Tidak Boleh Kosong!';
                                echo '  </div>';
                                echo '</d>';
                            }else{
                                $id_poliklinik=$_GET['id'];
                                //Menampilkan data
                                include "_Config/SettingKoneksiWeb.php";
                                include "_Config/WebFunction.php";
                                $url=urlService('Detail Poliklinik');
                                $JsonDataDetail=getDetailPoliklinik($api_key,$url,$id_poliklinik);
                                $massage=$JsonDataDetail['metadata']['massage'];
                                if($massage=="Berhasil"){
                                    $kode=$JsonDataDetail['response']['kode'];
                                    $nama=$JsonDataDetail['response']['nama'];
                                    $deskripsi=$JsonDataDetail['response']['deskripsi'];
                                    $status=$JsonDataDetail['response']['status'];
                                    $last_update=$JsonDataDetail['response']['last_update'];
                        ?>
                            <form action="javascript:void(0);" id="ProsesEditArtikel">
                                <input type="hidden" name="id_poliklinik" id="id_poliklinik" class="form-control" value="<?php echo "$id_poliklinik"; ?>">
                                <div class="card table-card">
                                    <div class="card-header border-info">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <dt>Form Edit Poliklinik</dt>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="ijavascript:void(0);" class="btn btn-sm btn-block btn-success" id="MulaiEditArtikel">
                                                    <i class="ti ti-pencil"></i> Mulai Edit
                                                </a>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="index.php?Page=WebPoliklinik" class="btn btn-sm btn-block btn-secondary">
                                                    <i class="ti ti-angle-left"></i> Kembali
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mt-3">
                                                <label for="nama">Nama Poliklinik</label>
                                                <input type="text" name="nama" id="nama" class="form-control" value="<?php echo "$nama"; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mt-3">
                                                <label for="deskripsi">Deskripsi</label>
                                                <textarea name="deskripsi" id="deskripsi" cols="30" rows="10"><?php echo "$deskripsi"; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mt-3">
                                                <label for="kode">Kode Poli</label>
                                                <input type="text" name="kode" id="kode" class="form-control" value="<?php echo "$kode"; ?>">
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="status">Kode Poli</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option <?php if($status=="Aktif"){echo "selected";} ?> value="Aktif">Aktif</option>
                                                    <option <?php if($status=="None"){echo "selected";} ?> value="None">None</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-md-12 mb-3">
                                                <span class="text-primary" id="NotifikasiEditPoliklinik">Pastikan semua data poliklinik sudah terisi dengan benar</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-md btn-primary" id="KlikProsesEditPoliklinik">
                                            <i class="ti ti-save"></i> Simpan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>