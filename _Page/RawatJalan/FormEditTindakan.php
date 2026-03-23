<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_tindakan'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Tindakan Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_tindakan=$_POST['id_tindakan'];
        //Buka Detail Tindakan
        $id_pasien=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'id_pasien');
        $id_kunjungan=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'id_kunjungan');
        $id_akses=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'id_akses');
        $nama_pasien=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'nama_pasien');
        $nama_petugas=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'nama_petugas');
        $tanggal_entry=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'tanggal_entry');
        $tanggal_pelaksanaan=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'tanggal_pelaksanaan');
        $waktu_mulai=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'waktu_mulai');
        $waktu_selesai=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'waktu_selesai');
        $kode_tindakan=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'kode_tindakan');
        $nama_tindakan=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'nama_tindakan');
        $alat_medis=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'alat_medis');
        $bmhp=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'bmhp');
        $nakes=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'nakes');
        //Json Decode
        $JsonAlatMedis=json_decode($alat_medis, true);
        $JsonBmhp =json_decode($bmhp, true);
        $JsonNakes=json_decode($nakes, true);
        //Format Tanggal
        $strtotime1=strtotime($tanggal_entry);
        $strtotime2=strtotime($tanggal_pelaksanaan);
        $FormatTanggalEntry=date('Y-m-d',$strtotime1);
        $FormatJamEntry=date('H:i',$strtotime1);
        $FormatTanggalPelaksanaan=date('Y-m-d',$strtotime2);
?>
    <input type="hidden" name="id_tindakan" id="id_tindakan" value="<?php echo "$id_tindakan"; ?>">
    <div class="modal-body">
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>A. Informasi Pasien & Kunjungan</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">A.1 ID.Kunjungan</div>
                    <div class="col col-md-8 mb-2">
                        <input type="text" readonly name="id_kunjungan" id="id_kunjungan" class="form-control" value="<?php echo "$id_kunjungan"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">A.2 No.RM</div>
                    <div class="col col-md-8 mb-2">
                        <input type="text" readonly name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$id_pasien"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">A.3 Nama Pasien</div>
                    <div class="col col-md-8 mb-2">
                        <input type="text" readonly name="nama_pasien" id="nama_pasien" class="form-control" value="<?php echo "$nama_pasien"; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>B. Pencatatan Tindakan</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">B.1 Tanggal</div>
                    <div class="col col-md-8 mb-2">
                        <input type="date" readonly name="tanggal_entry" id="tanggal_entry" class="form-control" value="<?php echo $FormatTanggalEntry; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">B.2 Jam</div>
                    <div class="col col-md-8 mb-2">
                        <input type="time" readonly name="jam_entry" id="jam_entry" class="form-control" value="<?php echo $FormatJamEntry; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">B.3 Petugas Entry</div>
                    <div class="col col-md-8 mb-2">
                        <input type="text" name="petugas_entry" id="petugas_entry" class="form-control" value="<?php echo "$nama_petugas"; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>C. Tanggal & Waktu Pelaksanaan</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">C.1 Tanggal Pelaksanaan</div>
                    <div class="col col-md-8 mb-2">
                        <input type="date" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" class="form-control" value="<?php echo $FormatTanggalPelaksanaan; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">C.2 Jam Mulai</div>
                    <div class="col col-md-8 mb-2">
                        <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="<?php echo $waktu_mulai; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">C.3 Jam Selesai</div>
                    <div class="col col-md-8 mb-2">
                        <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="<?php echo $waktu_selesai; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col col-md-4 mb-2">
                <dt>F. Tindakan Medis</dt>
                
            </div>
            <div class="col col-md-8 mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <small>Format pengisian tindakan (kode|Nama Tindakan)</small>
                        <input type="text" class="form-control" id="KeywordProcedur" name="KeywordProcedur" list="ListReferensiTindakan" placeholder="Kode|Tindakan" value="<?php echo "$kode_tindakan|$nama_tindakan"; ?>">
                        <small>
                            Referensi Tindakan :
                            <input checked type="radio" name="ReferensiTindakan" id="ReferensiTindakan1" value="SIMRS">
                            <label for="ReferensiTindakan1"><small>SIMRS</small></label>
                            <input type="radio" name="ReferensiTindakan" id="ReferensiTindakan2" value="BPJS">
                            <label for="ReferensiTindakan2"><small>BPJS</small></label>
                        </small>
                    </div>
                </div>
                <datalist id="ListReferensiTindakan"></datalist>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col col-md-4 mb-2">
                <dt>G. Alat Medis</dt>
            </div>
            <div class="col col-md-8 mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <small>Alat medis yang digunakan ketika dilakukan tindakan</small>
                        <div class="input-group">
                            <input type="text" class="form-control" id="alat_medis" name="alat_medis" placeholder="Nama alat medis">
                            <button type="button" class="btn btn-sm btn-outline-dark" id="TambahAlatMedis">
                                <i class="ti ti-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="MultiFormAlatMedis">
                    <?php
                        $JumlahAlkes=count($JsonAlatMedis);
                        for($i=0; $i<$JumlahAlkes; $i++){
                            echo '<div class="row mb-3" id="BarisAlatMedis'.$i.'"><div class="col-md-12 mb-2 input-group"><input type="text" readonly class="form-control" id="isi_alat_medis[]" name="isi_alat_medis[]" value="'.$JsonAlatMedis[$i]['alkes'].'"><button type="button" class="btn btn-sm btn-outline-danger HapusFormAlatMedis" id="'.$i.'"><i class="ti ti-close"></i></button></div></div>';
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col col-md-4 mb-2">
                <dt>H. BMHP</dt>
            </div>
            <div class="col col-md-8 mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <small>Bahan Medis Habis Pakai yang digunakan untuk tindakan</small>
                        <div class="input-group">
                            <input type="text" class="form-control" id="BMHP" name="BMHP" list="ListReferensiBMHP" placeholder="Nama BMHP">
                            <button type="button" class="btn btn-sm btn-outline-dark" id="TambahBMHP">
                                <i class="ti ti-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="MultiFormBMHP">
                    <?php
                        $JumlahBmhp=count($JsonBmhp);
                        for($i=0; $i<$JumlahBmhp; $i++){
                            echo '<div class="row mb-3" id="BarisBMHP'.$i.'"><div class="col-md-12 mb-2 input-group"><input type="text" readonly class="form-control" id="isi_BMHP[]" name="isi_BMHP[]" value="'.$JsonBmhp[$i]['bmhp'].'"><button type="button" class="btn btn-sm btn-outline-danger HapusFormBMHP" id="'.$i.'"><i class="ti ti-close"></i></button></div></div>';
                        }
                    ?>
                </div>
                <datalist id="ListReferensiBMHP"></datalist>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col col-md-4 mb-2">
                <dt>I. Nakes</dt>
            </div>
            <div class="col col-md-8 mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <small>Tenaga kesehatan yang terlibat dalam tindakan</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input type="text" class="form-control" id="KategoriNakes" name="KategoriNakes" placeholder="Kategori Nakes" list="ListKategoriNakes">
                            <datalist id="ListKategoriNakes">
                                <option value="Dokter">
                                <option value="Perawat">
                                <option value="Bidan">
                                <option value="Lainnya">
                            </datalist>
                            <input type="text" class="form-control" id="NamaNakes" name="NamaNakes" placeholder="Nama Nakes" list="ListReferensiDokter">
                            <button type="button" class="btn btn-sm btn-outline-dark" id="TambahNakes">
                                <i class="ti ti-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="MultiFormNakes">
                    <?php
                        $JumlahNakes=count($JsonNakes);
                        for($i=0; $i<$JumlahNakes; $i++){
                            echo '<div class="row mb-3" id="BarisNakes'.$i.'"><div class="col-md-12 mb-2 input-group"><input type="text" readonly class="form-control" id="isi_kategori_nakes[]" name="isi_kategori_nakes[]" value="'.$JsonNakes[$i]['kategori'].'"><input type="text" readonly class="form-control" id="isi_nama_nakes[]" name="isi_nama_nakes[]" value="'.$JsonNakes[$i]['nama'].'"><button type="button" class="btn btn-sm btn-outline-danger HapusFormNakes" id="'.$i.'"><i class="ti ti-close"></i></button></div></div>';
                        }
                    ?>
                </div>
                <datalist id="ListReferensiDokter"></datalist>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiEditTindakan">
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
        //Multi Form Alat Medis
        $('#TambahAlatMedis').click(function(){
            var alat_medis=$('#alat_medis').val(); 
            if(alat_medis!==""){
                no++;
                $('#MultiFormAlatMedis').append('<div class="row mb-3" id="BarisAlatMedis'+no+'"><div class="col-md-12 mb-2 input-group"><input type="text" readonly class="form-control" id="isi_alat_medis[]" name="isi_alat_medis[]" value="'+alat_medis+'"><button type="button" class="btn btn-sm btn-outline-danger HapusFormAlatMedis" id="'+no+'"><i class="ti ti-close"></i></button></div></div>');
                $('#alat_medis').val(''); 
            }
        });
        $(document).on('click', '.HapusFormAlatMedis', function(){
            var button_id = $(this).attr("id"); 
            $('#BarisAlatMedis'+button_id+'').remove();
        });

        //Multi Form BMHP
        $('#TambahBMHP').click(function(){
            var BMHP=$('#BMHP').val(); 
            if(BMHP!==""){
                no++;
                $('#MultiFormBMHP').append('<div class="row mb-3" id="BarisBMHP'+no+'"><div class="col-md-12 mb-2 input-group"><input type="text" readonly class="form-control" id="isi_BMHP[]" name="isi_BMHP[]" value="'+BMHP+'"><button type="button" class="btn btn-sm btn-outline-danger HapusFormBMHP" id="'+no+'"><i class="ti ti-close"></i></button></div></div>');
                $('#BMHP').val(''); 
            }
        });
        $(document).on('click', '.HapusFormBMHP', function(){
            var button_id = $(this).attr("id"); 
            $('#BarisBMHP'+button_id+'').remove();
        });

        //Multi Form Nakes
        $('#TambahNakes').click(function(){
            var KategoriNakes=$('#KategoriNakes').val(); 
            var NamaNakes=$('#NamaNakes').val(); 
            if(NamaNakes!==""){
                no++;
                $('#MultiFormNakes').append('<div class="row mb-3" id="BarisNakes'+no+'"><div class="col-md-12 mb-2 input-group"><input type="text" readonly class="form-control" id="isi_kategori_nakes[]" name="isi_kategori_nakes[]" value="'+KategoriNakes+'"><input type="text" readonly class="form-control" id="isi_nama_nakes[]" name="isi_nama_nakes[]" value="'+NamaNakes+'"><button type="button" class="btn btn-sm btn-outline-danger HapusFormNakes" id="'+no+'"><i class="ti ti-close"></i></button></div></div>');
                $('#KategoriNakes').val(''); 
                $('#NamaNakes').val(''); 
            }
        });
        $(document).on('click', '.HapusFormNakes', function(){
            var button_id = $(this).attr("id"); 
            $('#BarisNakes'+button_id+'').remove();
        });

        $('#KeywordProcedur').keyup(function(){
            var diagnosa = $('#KeywordProcedur').val();
            var referensi="SIMRS";
            var panjang = diagnosa.length;
            if(panjang>3){
                $('#ListReferensiTindakan').html('<option value="Loading..">');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/CariProcedurList.php',
                    data        :   {code_procedure: diagnosa, ReferensiProcedur: referensi},
                    success     : function(data){
                        $('#ListReferensiTindakan').html(data);
                    }
                });
            }
        });
        $('#BMHP').keyup(function(){
            var BMHP = $('#BMHP').val();
            var panjangBMHP = BMHP.length;
            if(panjangBMHP>3){
                $('#ListReferensiBMHP').html('<option value="Loading..">');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ListReferensiBMHP.php',
                    data        :   {keyword: BMHP},
                    success     : function(data){
                        $('#ListReferensiBMHP').html(data);
                    }
                });
            }
        });
        $('#BMHP').keyup(function(){
            var BMHP = $('#BMHP').val();
            var panjangBMHP = BMHP.length;
            if(panjangBMHP>3){
                $('#ListReferensiBMHP').html('<option value="Loading..">');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/RawatJalan/ListReferensiBMHP.php',
                    data        :   {keyword: BMHP},
                    success     : function(data){
                        $('#ListReferensiBMHP').html(data);
                    }
                });
            }
        });
        $('#NamaNakes').keyup(function(){
            var NamaNakes = $('#NamaNakes').val();
            var KategoriNakes = $('#KategoriNakes').val();
            $('#ListReferensiDokter').html('<option value="Loading..">');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/RawatJalan/ListReferensiDokter.php',
                data        :   {keyword: NamaNakes},
                success     : function(data){
                    $('#ListReferensiDokter').html(data);
                }
            });
        });
    });
</script>