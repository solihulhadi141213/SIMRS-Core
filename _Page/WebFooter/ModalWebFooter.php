<!--- Modal Tambah Arsip ---->
<div class="modal fade" id="ModalTambahFooterMenu" tabindex="-1" role="dialog" aria-labelledby="ModalTambahFooterMenu" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahFooterMenu" autocomplete="off">
                <div class="modal-header bg-primary">
                    <b cass="text-light"><i class="ti ti-plus"></i> Tambah Footer Menu</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="kategori">Kategori</label>
                            <input type="text" name="kategori" id="kategori" list="ListKategori" class="form-control" value="">
                            <datalist id="ListKategori">
                                <?php
                                    $url=urlServiceInline('List Kategori');
                                    $KirimData = array(
                                        'api_key' => $api_key
                                    );
                                    $json = json_encode($KirimData);
                                    //Mulai CURL
                                    $ch = curl_init();
                                    curl_setopt($ch,CURLOPT_URL, "$url");
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                    curl_setopt($ch,CURLOPT_HEADER, 0);
                                    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $content = curl_exec($ch);
                                    $err = curl_error($ch);
                                    curl_close($ch);
                                    if(!empty($err)){
                                        $jumlah_Artikel="0";
                                    }else{
                                        $JsonData =json_decode($content, true);
                                        if(!empty($JsonData['metadata']['massage'])){
                                            $massage=$JsonData['metadata']['massage'];
                                        }else{
                                            $massage="";
                                        }
                                        if(!empty($JsonData['metadata']['code'])){
                                            $code=$JsonData['metadata']['code'];
                                        }else{
                                            $code="";
                                        }
                                        if($code==200){
                                            $List=count($JsonData['response']['list']);
                                            if(!empty($List)){
                                                $GetListKategori=$JsonData['response']['list'];
                                                foreach ($GetListKategori as $value){
                                                    $Kategori=$value['kategori'];
                                                    echo '<option value="'.$Kategori.'">';
                                                }
                                            }
                                        }
                                    }
                                ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="label">Label</label>
                            <input type="text" name="label" id="label" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="url">URL/Link</label>
                            <input type="text" name="url" id="url" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3" id="NotifikasiTambahFooterMenu">
                            <span class="text-primary">
                                Pastikan data Medsos sudah benar.
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <button type="submit" class="btn btn-md btn btn-success">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Edit Footer Menu ---->
<div class="modal fade" id="ModalEditFooterMenu" tabindex="-1" role="dialog" aria-labelledby="ModalEditFooterMenu" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content border-0">
            <form action="javascript:void(0);" id="ProsesEditFooterMenu" autocomplete="off">
                <div class="modal-header bg-success">
                    <b cass="text-light modal-title"><i class="ti ti-pencil"></i> Edit Footer Menu</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="FormEditFooterMenu">
                    
                </div>
                <div class="modal-footer bg-success">
                    <button type="submit" class="btn btn-md btn btn-primary">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
                        <i class="ti ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Footer Menu ---->
<div class="modal fade" id="ModalHapusFooterMenu" tabindex="-1" role="dialog" aria-labelledby="ModalHapusFooterMenu" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <b cass="text-light">Konfirmasi Hapus Footer Menu</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormHapusFooterMenu">
                <!---- Konfirmasi Hapus FooterMenu ----->
            </div>
        </div>
    </div>
</div>