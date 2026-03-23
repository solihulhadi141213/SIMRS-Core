<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Kunjungan Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        //Buka Detail Pasien
        $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
?>
    <input type="hidden" name="id_kunjungan" id="id_kunjungan" class="form-control" value="<?php echo "$id_kunjungan"; ?>">
    <input type="hidden" name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$id_pasien"; ?>">
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
                <dt>B. Uraian Penggunaan Obat</dt>
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
                        <small>Tablet, syirup, dll</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        B.4 Dosis
                    </div>
                    <div class="col col-md-8">
                        <input type="text" name="dosis" id="dosis" class="form-control">
                        <small>Jumlah dosis penggunaan per satuan</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        B.5 Aturan Pakai
                    </div>
                    <div class="col col-md-8">
                        <input type="text" name="aturan_pakai" id="aturan_pakai" class="form-control">
                        <small>Keterangan penggunaan obat</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        B.6 Waktu
                    </div>
                    <div class="col col-md-8">
                        <input type="text" name="waktu_penggunaan" id="waktu_penggunaan" class="form-control">
                        <small>Keterangan waktu penggunaan (Pagi, Siang, Malam)</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        B.7 Tanggal
                    </div>
                    <div class="col col-md-8">
                        <input type="date" name="tanggal" id="tanggal" class="form-control">
                        <small>Keterangan tanggal penggunaan obat</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">
                        B.8 Jam
                    </div>
                    <div class="col col-md-8">
                        <input type="time" name="jam" id="jam" class="form-control">
                        <small>Keterangan jam penggunaan obat</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiTambahRiwayatObat">
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