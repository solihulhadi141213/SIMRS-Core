<?php
    //Menangkap KategoriPencarian
    if(empty($_POST['kategoriPencarian'])){
        echo "Kategori Tidak Boleh Kosong!!";
    }else{
        $kategoriPencarian=$_POST['kategoriPencarian'];
        if($kategoriPencarian=="Procedure"){
            $Proses="ProsesPencarianProcedur";
        }else{
            $Proses="ProsesPencarianDiagnosa";
        }
?>
    <form action="javascript:void(0);" id="<?php echo "$Proses";?>">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Cari..">
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-sm btn-outline-primary">
                        Cari
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12" id="HasilPencarianDiagnosaProcedur">
                <!-- Hasil Pencarian -->
            </div>
        </div>
    </div>
<?php } ?>
<div class="modal-footer bg-primary">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
                <i class="ti ti-close"></i> Tutup
            </button>
        </div>
    </div>
</div>
