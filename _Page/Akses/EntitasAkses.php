<div class="row">
    <div class="col-md-12 mb-3">
        <h5># Entitas Akses</h5>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-md-12">
        <div class="card table-card">
            <div class="card-header">
                <form action="javascript:void(0);" id="BatasPencarianEntitas">
                    <div class="row">
                        <div class="col-md-1 mb-3">
                            <select name="batas_entitas" id="batas_entitas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <small>Batas</small>
                        </div>
                        <div class="col-md-2 mb-3">
                            <select name="keyword_by_entitas" id="keyword_by_entitas" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    //Menampilkan list keyword_by
                                    $NamaTabel="akses_entitas";
                                    $ListKolom=getColomList($Conn,$NamaTabel);
                                    foreach ($ListKolom as $value){
                                        $nama_kolom=$value['nama_kolom'];
                                        if($nama_kolom=="akses"){
                                            echo '<option value="'.$nama_kolom.'">Akses</option>';
                                        }else{
                                            if($nama_kolom=="deskripsi"){
                                                echo '<option value="'.$nama_kolom.'">Deskripsi</option>';
                                            }else{
                                                // echo '<option value="'.$nama_kolom.'">'.$nama_kolom.'</option>';
                                            }
                                        }
                                    }
                                ?>
                            </select>
                            <small>Keyword By</small>
                        </div>
                        <div class="col-md-3 mb-3" id="FormKeywordEntitas">
                            <input type="text" class="form-control" name="keyword_entitas" id="keyword_entitas" placeholder="Kata Kunci">
                            <small>Pencarian</small>
                        </div>
                        <div class="col-md-2 mb-3">
                            <button type="submit" class="btn btn-sm btn-secondary btn-block"><i class="ti-search"></i> Cari</button>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="index.php?Page=Akses&Sub=TambahEntitasAkses" class="btn btn-sm btn-block btn-primary" title="Tambah Entitas Akses">
                                <i class="ti-plus text-white"></i> Tambah
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div id="MenampilkanTabelEntitas">
                <!--  Menampilkan data Entitas akses disini -->
            </div>
        </div>
    </div>
</div>