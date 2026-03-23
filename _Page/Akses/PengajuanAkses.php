<div class="row">
    <div class="col-md-12 mb-3">
        <h5># Pengajuan Akses</h5>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-md-12">
        <div class="card table-card">
            <div class="card-header">
                <form action="javascript:void(0);" id="BatasPencarianPengajuan">
                    <div class="row">
                        <div class="col-md-1 mb-3">
                            <select name="batas_pengajuan" id="batas_pengajuan" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <small>Batas</small>
                        </div>
                        <div class="col-md-2 mb-3">
                            <select name="keyword_by_pengajuan" id="keyword_by_pengajuan" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    //Menampilkan list keyword_by
                                    $NamaTabel="akses_pengajuan";
                                    $ListKolom=getColomList($Conn,$NamaTabel);
                                    foreach ($ListKolom as $value){
                                        $nama_kolom=$value['nama_kolom'];
                                        if($nama_kolom=="tanggal"){
                                            echo '<option value="'.$nama_kolom.'">Tanggal</option>';
                                        }else{
                                            if($nama_kolom=="nik"){
                                                echo '<option value="'.$nama_kolom.'">NIK</option>';
                                            }else{
                                                if($nama_kolom=="nama"){
                                                    echo '<option value="'.$nama_kolom.'">Nama</option>';
                                                }else{
                                                    if($nama_kolom=="kontak"){
                                                        echo '<option value="'.$nama_kolom.'">Kontak</option>';
                                                    }else{
                                                        if($nama_kolom=="email"){
                                                            echo '<option value="'.$nama_kolom.'">Email</option>';
                                                        }else{
                                                            if($nama_kolom=="status"){
                                                                echo '<option value="'.$nama_kolom.'">Status</option>';
                                                            }else{
                                                                // echo '<option value="'.$nama_kolom.'">'.$nama_kolom.'</option>';
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
                        <div class="col-md-3 mb-3" id="FormKeywordPengajuan">
                            <input type="text" class="form-control" name="keyword_pengajuan" id="keyword_pengajuan" placeholder="Kata Kunci">
                            <small>Pencarian</small>
                        </div>
                        <div class="col-md-2 mb-3">
                            <button type="submit" class="btn btn-sm btn-secondary btn-block"><i class="ti-search"></i> Cari</button>
                        </div>
                        <div class="col-md-4 mb-3">
                            <button type="button" class="btn btn-sm btn-block btn-primary"  data-toggle="modal" data-target="#ModalPengajuanAkses" title="Buat Pengajuan Akses">
                                <i class="ti-plus text-white"></i> Buat Pengajuan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="MenampilkanTabelPengajuan">
                <!--  Menampilkan data pengajuan akses disini -->
            </div>
        </div>
    </div>
</div>