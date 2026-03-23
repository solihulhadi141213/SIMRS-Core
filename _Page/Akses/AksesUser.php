<div class="row">
    <div class="col-xl-12 col-md-12">
        <h4># Akses User</h4>
        <div class="card table-card">
            <div class="card-header">
                <form action="javascript:void(0);" id="BatasPencarian">
                    <div class="row">
                        <div class="col-md-1">
                            <select name="batas" id="batas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <small>Batas</small>
                        </div>
                        <div class="col-md-2 mb-3">
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    //Menampilkan list keyword_by
                                    $NamaTabel="akses";
                                    $ListKolom=getColomList($Conn,$NamaTabel);
                                    foreach ($ListKolom as $value){
                                        $nama_kolom=$value['nama_kolom'];
                                        if($nama_kolom=="akses"){
                                            echo '<option value="'.$nama_kolom.'">Akses</option>';
                                        }else{
                                            if($nama_kolom=="tanggal"){
                                                echo '<option value="'.$nama_kolom.'">Tanggal</option>';
                                            }else{
                                                if($nama_kolom=="nama"){
                                                    echo '<option value="'.$nama_kolom.'">Nama</option>';
                                                }else{
                                                    if($nama_kolom=="email"){
                                                        echo '<option value="'.$nama_kolom.'">Email</option>';
                                                    }else{
                                                        if($nama_kolom=="kontak"){
                                                            echo '<option value="'.$nama_kolom.'">Kontak</option>';
                                                        }else{
                                                            if($nama_kolom=="akses"){
                                                                echo '<option value="'.$nama_kolom.'">Akses</option>';
                                                            }else{
                                                                if($nama_kolom=="updatetime"){
                                                                    echo '<option value="'.$nama_kolom.'">Updatetime</option>';
                                                                }else{
                                                                    // echo '<option value="'.$nama_kolom.'">'.$nama_kolom.'</option>';
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                ?>
                            </select>
                            <small>Keyword By</small>
                        </div>
                        <div class="col-md-3" id="FormPencarianAkses">
                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                            <small>Pencarian</small>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-sm btn-block btn-secondary"><i class="ti-search"></i> Cari</button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-sm btn-block btn-inverse" data-toggle="modal" data-target="#ModalExportAkses" ><i class="ti-download"></i> Eksport</button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-sm btn-block btn-primary" data-toggle="modal" data-target="#ModalPengajuanAkses" ><i class="ti-plus"></i> Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="MenampilkanTabelAkses">
                <!--  menampilkan data akses disini -->
            </div>
        </div>
    </div>
</div>