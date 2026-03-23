<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php"; 
    //Tangkap ID
    if(empty($_POST['id_cppt'])){
        echo '<span class="text-danger">Belum Ada Data Kunjungan Yang Dipilih</span>';
    }else{
        $id_cppt=$_POST['id_cppt'];
        //Buka ID Pasien
        $id_kunjungan=getDataDetail($Conn,"cppt",'id_cppt',$id_cppt,'id_kunjungan');
        $id_pasien=getDataDetail($Conn,"cppt",'id_cppt',$id_cppt,'id_pasien');
        $id_akses=getDataDetail($Conn,"cppt",'id_cppt',$id_cppt,'id_akses');
        $tanggal_entry=getDataDetail($Conn,"cppt",'id_cppt',$id_cppt,'tanggal_entry');
        $nakes=getDataDetail($Conn,"cppt",'id_cppt',$id_cppt,'nakes');
        $dokter=getDataDetail($Conn,"cppt",'id_cppt',$id_cppt,'dokter');
        $subjective=getDataDetail($Conn,"cppt",'id_cppt',$id_cppt,'subjective');
        $objective=getDataDetail($Conn,"cppt",'id_cppt',$id_cppt,'objective');
        $assessment=getDataDetail($Conn,"cppt",'id_cppt',$id_cppt,'assessment');
        $plan=getDataDetail($Conn,"cppt",'id_cppt',$id_cppt,'plan');
        $catatan=getDataDetail($Conn,"cppt",'id_cppt',$id_cppt,'catatan');
        //Format Tangga
        $strtotime=strtotime($tanggal_entry);
        $TanggalEntry=date('Y-m-d',$strtotime);
        $JamEntry=date('H:i',$strtotime);
        //Json 
        $JsonNakes =json_decode($nakes, true);
        $JsonDokter =json_decode($dokter, true);
        //Nakes
        $KategoriNakes=$JsonNakes['kategori'];
        $NamaNakes=$JsonNakes['nama'];
        $KontakNakes=$JsonNakes['kontak'];
        $KategoriIdentitasNakes=$JsonNakes['kategori_identitas'];
        $NomorIdentitasNakes=$JsonNakes['no_identitas'];
        $TtdNakes=$JsonNakes['ttd'];
        //Dokter
        $NamaDokter=$JsonDokter['nama'];
        $SipDokter=$JsonDokter['SIP'];
        $KontakDokter=$JsonDokter['kontak'];
        $KategoriIdentitasDokter=$JsonDokter['kategori_identitas'];
        $NomorIdentitasDokter=$JsonDokter['no_identitas'];
        $TtdDokter=$JsonDokter['ttd'];
?>
    <form action="javascript:void(0);" id="ProsesEditCPPT">
        <input type="hidden" readonly name="id_cppt" id="id_cppt" class="form-control" value="<?php echo "$id_cppt"; ?>">
        <div class="row mb-3">
            <div class="col-md-12 sub-title">
                <dt>Informasi Umum</dt>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="id_pasien">No.RM</label>
            </div>
            <div class="col-md-9">
                <input type="text" readonly name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$id_pasien"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="id_kunjungan">ID Kunjungan</label>
            </div>
            <div class="col-md-9">
                <input type="text" readonly name="id_kunjungan" id="id_kunjungan" class="form-control" value="<?php echo "$id_kunjungan"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="tanggal_entry">Tanggal Entry</label>
            </div>
            <div class="col-md-5">
                <input type="date" name="tanggal_entry" id="tanggal_entry" class="form-control" value="<?php echo $TanggalEntry; ?>">
                <small>Tanggal Entry</small>
            </div>
            <div class="col-md-4">
                <input type="time" name="jam_entry" id="jam_entry" class="form-control" value="<?php echo $JamEntry; ?>">
                <small>Jam Entry</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 sub-title">
                <dt>
                    Tenaga Kesehatan 
                    <a href="javascript:void(0);" class="badge badge-info" data-toggle="modal" data-target="#ModalCariNakesCppt">
                        <i class="ti ti-search"></i> Cari
                    </a>
                </dt>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="kategori_nakes">Kategori Nakes</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="kategori_nakes" id="kategori_nakes" class="form-control" list="KategoriNakes" value="<?php echo $KategoriNakes; ?>">
                <datalist id="KategoriNakes">
                    <option value="Perawat">
                    <option value="Dokter IGD">
                    <option value="Profesi/Ahli">
                    <option value="Lainnya">
                </datalist>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="nama_nakes">Nama Nakes</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="nama_nakes" id="nama_nakes" class="form-control" value="<?php echo $NamaNakes; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="kontak_nakes">Kontak Nakes</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="kontak_nakes" id="kontak_nakes" class="form-control" value="<?php echo $KontakNakes; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="identitas_nakes">Identitas</label>
            </div>
            <div class="col-md-4">
                <input type="text" name="identitas_nakes" id="identitas_nakes" list="KategoriIdentitas" class="form-control" value="<?php echo $KategoriIdentitasNakes; ?>">
                <small>Kategori Identitas</small>
            </div>
            <div class="col-md-5">
                <input type="text" name="no_identitas_nakes" id="no_identitas_nakes" class="form-control" value="<?php echo $NomorIdentitasNakes; ?>">
                <small>Nomor Identitas</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 sub-title">
                <dt>
                    Dokter DPJP
                    <a href="javascript:void(0);" class="badge badge-info" data-toggle="modal" data-target="#ModalCariDokter">
                        <i class="ti ti-search"></i> Cari
                    </a>
                </dt>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="nama_dokter">Nama Dokter</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="nama_dokter" id="nama_dokter" class="form-control" value="<?php echo $NamaDokter; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="sip_dokter">SIP</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="sip_dokter" id="sip_dokter" class="form-control" value="<?php echo $SipDokter; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="kontak_dokter">Kontak Dokter</label>
            </div>
            <div class="col-md-9">
                <input type="text" name="kontak_dokter" id="kontak_dokter" class="form-control" value="<?php echo $KontakDokter; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="identitas_dokter">Identitas</label>
            </div>
            <div class="col-md-4">
                <input type="text" name="identitas_dokter" id="identitas_dokter" list="KategoriIdentitas" class="form-control" value="<?php echo $KategoriIdentitasDokter; ?>">
                <small>Kategori Identitas</small>
            </div>
            <div class="col-md-5">
                <input type="text" name="no_identitas_dokter" id="no_identitas_dokter" class="form-control" value="<?php echo $NomorIdentitasDokter; ?>">
                <small>Nomor Identitas</small>
            </div>
            <datalist id="KategoriIdentitas">
                <option value="KTP">
                <option value="SIM">
                <option value="KK">
                <option value="Passport">
            </datalist>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 sub-title">
                <dt>
                    SOAP
                    <a href="javascript:void(0);" class="badge badge-info" data-toggle="modal" data-target="#ModalCariReferensiSoap" data-id="<?php echo "$id_kunjungan"; ?>">
                        <i class="ti ti-search"></i> Referensi
                    </a>
                </dt>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="subjective">Subjective (S)</label><br>
                <small>Informasi berupa ungkapan yang di terima dari klien setelah diberikan tindakan.</small>
                <div id="subjective"><?php echo "$subjective"; ?></div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="objective">Objective (O)</label><br>
                <small>Informasi hasil pengamatan, penilaian, pengukuran yang diberi oleh perawat setelah tindakan.</small>
                <div id="objective"><?php echo "$objective"; ?></div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="assessment">Assessment (A)</label><br>
                <small>Membandingkan antara informasi subjective dan objective dengan tujuan & kriteria hasil.</small>
                <div id="assessment"><?php echo "$assessment"; ?></div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="plan">Plan (P)</label><br>
                <small>Rencana keperawatan lanjutan yang akan dilakukan berdasarkan hasil analisa</small>
                <div id="plan"><?php echo "$plan"; ?></div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="catatan">Catatan</label><br>
                <small>Catatan Lain Yang Mungkin Ingin Ditambahkan</small>
                <div id="catatan"><?php echo "$catatan"; ?></div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiEditCPPT">
                <span class="text-primary">Pastikan Informasi CPPT Sudah Terisi Dengan Benar Dan Lengkap!</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <button type="submit" class="btn btn-md btn-primary mr-2">
                    <i class="ti ti-save"></i> Simpan
                </button>
                <button type="reset" class="btn btn-md btn-secondary">
                    <i class="ti ti-reload"></i> Reset
                </button>
            </div>
        </div>
    </form>
<?PHP } ?>
<script>
    //Proses Edit CPPT
    var id_kunjungan="<?php echo $id_kunjungan;?>";
    $('#ProsesEditCPPT').submit(function(){
        var ProsesEditCPPT = $('#ProsesEditCPPT').serialize();
        var subjective =  $('#subjective').summernote('code');
        var objective =  $('#objective').summernote('code');
        var assessment =  $('#assessment').summernote('code');
        var plan =  $('#plan').summernote('code');
        var catatan =  $('#catatan').summernote('code');
        $('#NotifikasiEditCPPT').html("Loading...");
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/ProsesEditCPPT.php',
            data        :   
            {
                ProsesEditCPPT, 
                subjective: subjective, 
                objective: objective, 
                assessment: assessment, 
                plan: plan, 
                catatan: catatan 
            },
            success     :   function(data){
                $('#NotifikasiEditCPPT').html(data);
                var NotifikasiEditCPPTBerhasil=$('#NotifikasiEditCPPTBerhasil').html();
                if(NotifikasiEditCPPTBerhasil=="Success"){
                    $('#KontenCPPT').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/ListCPPT.php',
                        data        : {id_kunjungan: id_kunjungan},
                        success     : function(data){
                            $('#KontenCPPT').html(data);
                            $("#ListCPPT").removeClass("btn-outline-dark");
                            $("#ListCPPT").addClass("btn-dark");
                            $("#TambahCPPT").removeClass("btn-dark");
                            $("#TambahCPPT").addClass("btn-outline-dark");
                        }
                    });
                    //Tampilkan Swal
                    Swal.fire({
                        title: 'Good Job!',
                        text: 'Edit CPPT Berhasil',
                        icon: 'success',
                        confirmButtonText: 'Tutup'
                    })
                }
            }
        });
    });
</script>