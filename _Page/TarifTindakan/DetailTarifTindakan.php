<?php
    include "_Config/SimrsFunction.php";
    if(empty($_GET['id'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <div class="card">';
        echo '          <div class="card-body text-center text-danger">';
        echo '              ID Tarif Tidak Boleh Kosong!';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $GetIdTarif=$_GET['id'];
        //Buka Detail tarif
        $id_tarif=getDataDetail($Conn,'tarif','id_tarif',$GetIdTarif,'id_tarif');
        if(empty($id_tarif)){
            echo '<div class="row">';
            echo '  <div class="col-md-12">';
            echo '      <div class="card">';
            echo '          <div class="card-body text-center text-danger">';
            echo '              ID Tarif Tidak Valid, Atau Tidak Ditemukan Pada Database!';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $nama=getDataDetail($Conn,'tarif','id_tarif',$id_tarif,'nama');
            $kategori=getDataDetail($Conn,'tarif','id_tarif',$id_tarif,'kategori');
            $tarif=getDataDetail($Conn,'tarif','id_tarif',$id_tarif,'tarif');
            //Format Harga Beli
            $tarif=number_format($tarif,0,',','.');
?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-8 mb-2">
                                    <dt><i class="ti ti-info-alt"></i> Detail Tarif & Tindakan</dt>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <a href="index.php?Page=TarifTindakan" class="btn btn-sm btn-block btn-round btn-dark">
                                        <i class="ti ti-angle-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3"><dt>ID Tarif</dt></div>
                                <div class="col-md-9" id="PutIdTarifInDetail"><?php echo "$id_tarif"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3"><dt>Nama Tarif</dt></div>
                                <div class="col-md-9"><?php echo "$nama"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3"><dt>Kategori</dt></div>
                                <div class="col-md-9"><?php echo "$kategori"; ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3"><dt>Tarif</dt></div>
                                <div class="col-md-9"><?php echo "$tarif"; ?></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-sm btn-block btn-outline-dark btn-round mb-3" data-toggle="modal" data-target="#ModalEditTarif2" data-id="<?php echo "$id_tarif";?>">
                                <i class="ti ti-pencil"></i> Edit Tarif
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-8 mb-2">
                                    <dt><i class="ti ti-view-list"></i> Unit Cost</dt>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <button type="button" class="btn btn-sm btn-block btn-primary btn-round" data-toggle="modal" data-target="#ModalTambahUnitCost" title="Tambah Unit Cost">
                                        <i class="ti ti-plus"></i> Unit Cost
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="MenampilkanTabelUnitCost">
                            <div class="row">
                                <div class="col-md-12">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php
        }
    }
?>