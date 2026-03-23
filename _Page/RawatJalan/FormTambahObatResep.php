<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_resep'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Resep Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_resep=$_POST['id_resep'];
        //Buka Detail Pasien
        $id_pasien=getDataDetail($Conn,"resep",'id_resep',$id_resep,'id_pasien');
?>
    <input type="hidden" name="id_resep" id="id_resep" class="form-control" value="<?php echo "$id_resep"; ?>">
    <div class="modal-body">
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>A. Data Obat Dari SIMRS</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col col-md-12">
                        A.1 Pencarian Data
                        <div class="input-group">
                            <input type="text" name="keyword_obat" id="keyword_obat" class="form-control">
                            <button type="button" class="btn btn-sm btn-default" id="PencarianObat">
                                <i class="ti ti-search"></i> Cari
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-12">
                        A.2 Hasil Pencarian
                        <select class="form-control" name="HasilPencarianObat" id="HasilPencarianObat" multiple aria-label="Multiple select example">
                            <option selected>Pilih</option>
                        </select>
                        <small id="DetailObatSelect"></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>B. Uraian Resep</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col col-md-4">
                        B.1 ID Obat
                    </div>
                    <div class="col col-md-8">
                        <input type="text" name="id_obat" id="id_obat" class="form-control">
                        <small>*Hanya Apabila Item Obat Berasal Dari Database</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        B.2 Nama Obat
                    </div>
                    <div class="col col-md-8">
                        <input type="text" name="nama_obat" id="nama_obat" class="form-control">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        B.3 Bentuk/Sediaan
                    </div>
                    <div class="col col-md-8">
                        <input type="text" name="bentuk_sediaan" id="bentuk_sediaan" class="form-control">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        B.4 Jumlah/Kuantitas
                    </div>
                    <div class="col col-md-8">
                        <input type="text" name="jumlah_obat" id="jumlah_obat" class="form-control">
                        <small>Jumlah total obat yang diberikan</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>C. Aturan Pakai</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col col-md-4">
                        C.1 Metode/Rute
                    </div>
                    <div class="col col-md-8">
                        <input type="text" name="metode" id="metode" class="form-control">
                        <small>Cara obat dimasukkan ke dalam tubuh pasien</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        C.2 Dosis
                    </div>
                    <div class="col col-md-8">
                        <input type="text" name="dosis" id="dosis" class="form-control">
                        <small>Jumlah kuantitas dosis obat yang diresepkan kepada pasien</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        C.3 Unit
                    </div>
                    <div class="col col-md-8">
                        <input type="text" name="unit" id="unit" class="form-control">
                        <small>Satuan dosis obat (mg, unit, ml)</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        C.4 Frekuensi
                    </div>
                    <div class="col col-md-8">
                        <input type="text" name="frekuensi" id="frekuensi" class="form-control">
                        <small>Jumlah total obat yang diberikan</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        C.5 Aturan
                    </div>
                    <div class="col col-md-8">
                        <input type="text" name="aturan_tambahan" id="aturan_tambahan" class="form-control">
                        <small>Jika diperlukan aturan tambahan dari dokter (sebelum makan, sesudahb makan, dll)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiTambahObatResep">
                <span class="text-primary">Pastikan informasi sudah terisi dengan lengkap dan benar.</span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-primary mr-3">
            <i class="ti ti-save"></i> Simpan
        </button>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>
<script>
    $(document).ready(function(){
        var no =1;
        //Multi Form Kontak Dokter
        $('#TambahKontakDokter').click(function(){
            var kategori_kontak=$('#kategori_kontak').val(); 
            var nomor_kontak=$('#nomor_kontak').val(); 
            if(kategori_kontak!==""){
                no++;
                $('#MultiFormKontakDokter').append('<div class="row mb-3" id="BarisKontakDokter'+no+'"><div class="col-md-12 mb-2 input-group"><input type="text" readonly class="form-control" id="isi_kategori[]" name="isi_kategori[]" value="'+kategori_kontak+'"><input type="text" readonly class="form-control" id="isi_nomor_kontak[]" name="isi_nomor_kontak[]" value="'+nomor_kontak+'"><button type="button" class="btn btn-sm btn-outline-danger HapusFormKontakDokter" id="'+no+'"><i class="ti ti-close"></i></button></div></div>');
                $('#kategori_kontak').val(''); 
                $('#nomor_kontak').val(''); 
            }
        });
        $(document).on('click', '.HapusFormKontakDokter', function(){
            var button_id = $(this).attr("id"); 
            $('#BarisKontakDokter'+button_id+'').remove();
        });
    });
    //Kondisi Ketika Dilakukan Pencarian
    $('#PencarianObat').click(function(){
        var keyword_obat=$('#keyword_obat').val(); 
        $('#HasilPencarianObat').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormHasilPencarianObat.php',
            data        :{keyword: keyword_obat},
            success     : function(data){
                $('#HasilPencarianObat').html(data);
            }
        });
    });
    //Kondisi Ketika Salah Satu Opsi Obat Dipilih
    $('#HasilPencarianObat').change(function(){
        var IdObtSelect=$('#HasilPencarianObat').val(); 
        $('#DetailObatSelect').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/DetailObatSelect.php',
            data        :{id_obat: IdObtSelect},
            success     : function(data){
                $('#DetailObatSelect').html(data);
                var GetIdObat=$('#GetIdObat').html();  
                var GetNamaObat=$('#GetNamaObat').html();  
                var GetSatuanObat=$('#GetSatuanObat').html();
                //Pasangkan Ke Form
                $('#id_obat').val(GetIdObat);
                $('#nama_obat').val(GetNamaObat);
                $('#bentuk_sediaan').val(GetSatuanObat);
            }
        });
    });
</script>