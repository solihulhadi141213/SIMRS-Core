//PARAMETER LABORATORIUM PERTAMA KALI
var PencarianParameter = $('#PencarianParameter').serialize();
$('#TabelParameterLaboratorium').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Laboratorium/TabelParameterLaboratorium.php',
    data 	    :  PencarianParameter,
    success     : function(data){
        $('#TabelParameterLaboratorium').html(data);
    }
});
//Batas dan Pencarian
$('#batas_parameter').change(function(){
    var PencarianParameter = $('#PencarianParameter').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelParameterLaboratorium').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/TabelParameterLaboratorium.php',
        data 	    :  PencarianParameter,
        success     : function(data){
            $('#TabelParameterLaboratorium').html(data);
        }
    });
});
//Pencarian
$('#PencarianParameter').submit(function(){
    var PencarianParameter = $('#PencarianParameter').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelParameterLaboratorium').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/TabelParameterLaboratorium.php',
        data 	    :  PencarianParameter,
        success     : function(data){
            $('#TabelParameterLaboratorium').html(data);
        }
    });
});
//Ketika keyword_by diubah
$('#keyword_by_parameter').change(function(){
    var keyword_by_parameter = $('#keyword_by_parameter').val();
    $('#FormKeyword').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormKeywordParameter.php',
        data 	    :  {keyword_by_parameter: keyword_by_parameter},
        success     : function(data){
            $('#FormKeyword').html(data);
        }
    });
});
$('#AddAlternate').click(function(event){
    var TambahAlt = $('#ListFormAlternatif');
    event.preventDefault();	
    $('<div class="col-md-12"><div class="input-group"><input type="text" id="alternatif[]" name="alternatif[]" class="form-control" placeholder="Alternatif Jawaban"><button type="button" class="btn btn-sm btn-danger" id="HapusForm"><i class="ti ti-close"></i></button></div></div>').appendTo(TambahAlt);		
});
$('body').on('click','#HapusForm',function(){	
    $(this).parent('div').parent('div').remove();	
});	
//Proses Tambah Data Parameter
$('#ProsesTambahParameter').submit(function(){
    var ProsesTambahParameter = $('#ProsesTambahParameter').serialize();
    $('#NotifikasiTambahParameter').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/ProsesTambahParameter.php',
        data 	    :  ProsesTambahParameter,
        success     : function(data){
            $('#NotifikasiTambahParameter').html(data);
            var NotifikasiTambahParameterBerhasil=$('#NotifikasiTambahParameterBerhasil').html();
            if(NotifikasiTambahParameterBerhasil=="Success"){
                location.reload();
            }
        }
    });
});	
//Detail Parameter
$('#ModalDetailParameter').on('show.bs.modal', function (e) {
    var id_laboratorium_parameter = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#FormDetailParameterLaboratorium').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormDetailParameterLaboratorium.php',
        data 	    :  {id_laboratorium_parameter: id_laboratorium_parameter},
        success     : function(data){
            $('#FormDetailParameterLaboratorium').html(data);
        }
    });
});
//Edit Parameter
$('#ModalEditParameter').on('show.bs.modal', function (e) {
    var id_laboratorium_parameter = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#FormEditParameterLaboratorium').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormEditParameterLaboratorium.php',
        data 	    :  {id_laboratorium_parameter: id_laboratorium_parameter},
        success     : function(data){
            $('#FormEditParameterLaboratorium').html(data);
            //Dinamic parameter
            $('#AddAlternate2').click(function(event){
                var TambahAlt2 = $('#ListFormAlternatif2');
                event.preventDefault();	
                $('<div class="col-md-12"><div class="input-group"><input type="text" id="alternatif[]" name="alternatif[]" class="form-control" placeholder="Alternatif Jawaban"><button type="button" class="btn btn-sm btn-danger" id="HapusForm2"><i class="ti ti-close"></i></button></div></div>').appendTo(TambahAlt2);		
            });
            $('body').on('click','#HapusForm2',function(){	
                $(this).parent('div').parent('div').remove();	
            });	
        }
    });
});
$('#ProsesEditParameter').submit(function(){
    var ProsesEditParameter = $('#ProsesEditParameter').serialize();
    $('#NotifikasiEditParameterLaboratorium').html('Loading...');
    $.ajax({
        url     : "_Page/Laboratorium/ProsesEditParameter.php",
        method  : "POST",
        data    :  ProsesEditParameter,
        success : function (data) {
            $('#NotifikasiEditParameterLaboratorium').html(data);
            //Notifikasi Proses Edit Berhasil
            var NotifikasiEditParameterLaboratoriumBerhasil=$('#NotifikasiEditParameterLaboratoriumBerhasil').html();
            if(NotifikasiEditParameterLaboratoriumBerhasil=="Success"){
                var PencarianParameter = $('#PencarianParameter').serialize();
                $('#TabelParameterLaboratorium').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Laboratorium/TabelParameterLaboratorium.php',
                    data 	    :  PencarianParameter,
                    success     : function(data){
                        $('#TabelParameterLaboratorium').html(data);
                    }
                });
                $('#ModalEditParameter').modal('toggle');
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Data Parameter Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    })
});
//Hapus Parameter
$('#ModalHapusParameter').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_laboratorium_parameter = pecah[0];
    var keyword = pecah[1];
    var batas = pecah[2];
    var ShortBy = pecah[3];
    var OrderBy = pecah[4];
    var page = pecah[5];
    var posisi = pecah[6];
    var keyword_by = pecah[7];
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#FormHapusParameter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormHapusParameter.php',
        data 	    :  {id_laboratorium_parameter: id_laboratorium_parameter},
        success     : function(data){
            $('#FormHapusParameter').html(data);
            $('#KonfirmasiHapusParameter').click(function(){
                $('#NotifikasiHapusParameter').html('Loading...');
                $.ajax({
                    url     : "_Page/Laboratorium/ProsesHapusParameter.php",
                    method  : "POST",
                    data    :  {id_laboratorium_parameter: id_laboratorium_parameter},
                    success : function (data) {
                        $('#NotifikasiHapusParameter').html(data);
                        //Notifikasi Proses Hapus
                        var NotifikasiHapusParameterBerhasil=$('#NotifikasiHapusParameterBerhasil').html();
                        if(NotifikasiHapusParameterBerhasil=="Success"){
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/Laboratorium/TabelParameterLaboratorium.php',
                                data 	    :  {keyword: keyword, batas: batas, ShortBy: ShortBy, OrderBy: OrderBy, page: page, posisi: posisi, keyword_by: keyword_by},
                                success     : function(data){
                                    $('#TabelParameterLaboratorium').html(data);
                                    $('#ModalHapusParameter').modal('toggle');
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Hapus Data Parameter Berhasil',
                                        icon: 'success',
                                        confirmButtonText: 'Tutup'
                                    })
                                }
                            });
                        }
                    }
                })
            });
        }
    });
});

//PERMINTAAN PELAYANAN LAB
$('#TabelPermintaanLaboratorium').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Laboratorium/TabelPermintaanLaboratorium.php',
    success     : function(data){
        $('#TabelPermintaanLaboratorium').html(data);
    }
});
//Batas dan Pencarian
$('#batas_permintaan').change(function(){
    var PencarianPermintaanLab = $('#PencarianPermintaanLab').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelPermintaanLaboratorium').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/TabelPermintaanLaboratorium.php',
        data 	    :  PencarianPermintaanLab,
        success     : function(data){
            $('#TabelPermintaanLaboratorium').html(data);
        }
    });
});
//Pencarian
$('#PencarianPermintaanLab').submit(function(){
    var PencarianPermintaanLab = $('#PencarianPermintaanLab').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelPermintaanLaboratorium').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/TabelPermintaanLaboratorium.php',
        data 	    :  PencarianPermintaanLab,
        success     : function(data){
            $('#TabelPermintaanLaboratorium').html(data);
        }
    });
});
//Ketika keyword_by diubah
$('#keyword_by_permintaan').change(function(){
    var keyword_by_permintaan = $('#keyword_by_permintaan').val();
    $('#FormKeywordPermintaan').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormKeywordPermintaan.php',
        data 	    :  {keyword_by_permintaan: keyword_by_permintaan},
        success     : function(data){
            $('#FormKeywordPermintaan').html(data);
        }
    });
});
//Modal Pilih Pasien
$('#ModalPilihPasien').on('show.bs.modal', function (e) {
    var ProsesCariPasien = $('#ProsesCariPasien').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelPasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/TabelPasien.php',
        data 	    :  ProsesCariPasien,
        success     : function(data){
            $('#TabelPasien').html(data);
        }
    });
    $('#ProsesCariPasien').submit(function(){
        var ProsesCariPasien = $('#ProsesCariPasien').serialize();
        var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
        $('#TabelPasien').html(Loading);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Laboratorium/TabelPasien.php',
            data 	    :  ProsesCariPasien,
            success     : function(data){
                $('#TabelPasien').html(data);
            }
        });
    });
});
//Modal Konfirmasi Pilih Pasien
$('#ModalKonfirmasiPilihPasien').on('show.bs.modal', function (e) {
    var id_pasien = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormKonfirmasiPilihPasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormKonfirmasiPilihPasien.php',
        data 	    :  {id_pasien: id_pasien},
        success     : function(data){
            $('#FormKonfirmasiPilihPasien').html(data);
            //Ketika tombol konfirmasi di pilih
            $('#KonfirmasiPilihPasien').click(function(){
                var NamaPasien = $('#GetPutName').val();
                $('#id_pasien').val(id_pasien);
                $('#nama_pasien').val(NamaPasien);
                $('#ModalKonfirmasiPilihPasien').modal('hide');
                $('#ModalPilihPasien').modal('hide');
            });
        }
    });
});
//Modal Pilih Kunjungan
$('#ModalPilihKunjungan').on('show.bs.modal', function (e) {
    var id_pasien = $('#id_pasien').val();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelKunjungan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/TabelKunjungan.php',
        data 	    :  {id_pasien: id_pasien},
        success     : function(data){
            $('#TabelKunjungan').html(data);
        }
    });
});
//Modal Konfirmasi Pilih Kunjungan
$('#ModalKonfirmasiPilihKunjungan').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormKonfirmasiKunjungan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormKonfirmasiPilihKunjungan.php',
        data 	    :  {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormKonfirmasiKunjungan').html(data);
            //Ketika tombol konfirmasi di pilih
            $('#KonfirmasiPilihKunjungan').click(function(){
                var GetPutTujuan = $('#GetPutTujuan').val();
                $('#id_kunjungan').val(id_kunjungan);
                $('#jenis_kunjungan').val(GetPutTujuan);
                $('#ModalKonfirmasiPilihKunjungan').modal('hide');
                $('#ModalPilihKunjungan').modal('hide');
            });
        }
    });
});
//Ketika ID Dokter Lainnya
$('#id_dokter').change(function(){
    var id_dokter = $('#id_dokter').val();
    if(id_dokter=="Lainnya"){
        $("#dokter").prop("readonly", false);
    }else{
        $('#dokter').val('');
        $("#dokter").prop("readonly", true);
    }
});
//Proses Tambah Permintaan Lab
$('#ProsesTambahPermintaanLab').submit(function(){
    var tanggal = $('#tanggal').val();
    var waktu = $('#waktu').val();
    var id_pasien = $('#id_pasien').val();
    var nama_pasien = $('#nama_pasien').val();
    var id_kunjungan = $('#id_kunjungan').val();
    var jenis_kunjungan = $('#jenis_kunjungan').val();
    var id_dokter = $('#id_dokter').val();
    var dokter = $('#dokter').val();
    var faskes = $('#faskes').val();
    var unit = $('#unit').val();
    var prioritas = $('#prioritas').val();
    var diagnosis = $('#diagnosis').val();
    var keterangan_permintaan = $('#keterangan_permintaan').val();
    var nama_signature = $('#nama_signature').val();
    var signature = signaturePad.toDataURL();
    $('#NotifikasiTambahPermintaan').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/ProsesTambahPermintaanLab.php',
        data 	    : { 
            tanggal: tanggal,
            waktu: waktu,
            id_pasien: id_pasien,
            nama_pasien: nama_pasien,
            id_kunjungan: id_kunjungan,
            jenis_kunjungan: jenis_kunjungan,
            id_dokter: id_dokter,
            dokter: dokter,
            faskes: faskes,
            unit: unit,
            prioritas: prioritas,
            diagnosis: diagnosis,
            keterangan_permintaan: keterangan_permintaan,
            nama_signature: nama_signature,
            signature: signature
        },
        success     : function(data){
            $('#NotifikasiTambahPermintaan').html(data);
            var NotifikasiTambahPermintaanBerhasil=$('#NotifikasiTambahPermintaanBerhasil').html();
            if(NotifikasiTambahPermintaanBerhasil=="Success"){
                window.location.href='index.php?Page=Laboratorium&Sub=TambahPermintaanLab';
            }
        }
    });
});	
//Moedal Detail Permintaan Pemerikswaan Lab
$('#ModalDetailPermintaanLab').on('show.bs.modal', function (e) {
    var id_permintaan = $(e.relatedTarget).data('id');
    $('#FormDetailPermintaanLab').html('<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormDetailPermintaanLab.php',
        data 	    :  {id_permintaan: id_permintaan},
        success     : function(data){
            $('#FormDetailPermintaanLab').html(data);
        }
    });
});
//Hapus Permintaan Lab
$('#ModalHapusPermintaan').on('show.bs.modal', function (e) {
    var id_permintaan = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#FormHapusPermintaan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormHapusPermintaan.php',
        data 	    :  {id_permintaan: id_permintaan},
        success     : function(data){
            $('#FormHapusPermintaan').html(data);
            $('#KonfirmasiHapusPermintaan').click(function(){
                $('#NotifikasiHapusPermintaanLab').html('Loading...');
                $.ajax({
                    url     : "_Page/Laboratorium/ProsesHapusPermintaanLab.php",
                    method  : "POST",
                    data    :  {id_permintaan: id_permintaan},
                    success : function (data) {
                        $('#NotifikasiHapusPermintaanLab').html(data);
                        //Notifikasi Proses Hapus
                        var NotifikasiHapusPermintaanLabBerhasil=$('#NotifikasiHapusPermintaanLabBerhasil').html();
                        if(NotifikasiHapusPermintaanLabBerhasil=="Success"){
                            window.location.href='index.php?Page=Laboratorium&Sub=PermintaanLab';
                        }
                    }
                })
            });
        }
    });
});
//Proses Edit Permintaan Lab
$('#ProsesEditPermintaanLab').submit(function(){
    var id_permintaan = $('#id_permintaan').val();
    var tanggal = $('#tanggal').val();
    var waktu = $('#waktu').val();
    var id_pasien = $('#id_pasien').val();
    var nama_pasien = $('#nama_pasien').val();
    var id_kunjungan = $('#id_kunjungan').val();
    var jenis_kunjungan = $('#jenis_kunjungan').val();
    var id_dokter = $('#id_dokter').val();
    var dokter = $('#dokter').val();
    var faskes = $('#faskes').val();
    var unit = $('#unit').val();
    var prioritas = $('#prioritas').val();
    var diagnosis = $('#diagnosis').val();
    var keterangan_permintaan = $('#keterangan_permintaan').val();
    var nama_signature = $('#nama_signature').val();
    var signature = signaturePad.toDataURL();
    $('#NotifikasiEditPermintaan').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/ProsesEditPermintaanLab.php',
        data 	    : { 
            id_permintaan: id_permintaan,
            tanggal: tanggal,
            waktu: waktu,
            id_pasien: id_pasien,
            nama_pasien: nama_pasien,
            id_kunjungan: id_kunjungan,
            jenis_kunjungan: jenis_kunjungan,
            id_dokter: id_dokter,
            dokter: dokter,
            faskes: faskes,
            unit: unit,
            prioritas: prioritas,
            diagnosis: diagnosis,
            keterangan_permintaan: keterangan_permintaan,
            nama_signature: nama_signature,
            signature: signature
        },
        success     : function(data){
            $('#NotifikasiEditPermintaan').html(data);
            var NotifikasiEditPermintaanBerhasil=$('#NotifikasiEditPermintaanBerhasil').html();
            if(NotifikasiEditPermintaanBerhasil=="Success"){
                location.reload();
            }
        }
    });
});
//Modal Konfirmasi Pemeriksaan Lab
$('#ModalKonfirmasiPermintaan').on('show.bs.modal', function (e) {
    var id_permintaan = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#FormKonfirmasiPermintaan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormKonfirmasiPermintaan.php',
        data 	    :  {id_permintaan: id_permintaan},
        success     : function(data){
            $('#FormKonfirmasiPermintaan').html(data);
            //Kondisi memilih status permintaan
            $('#status_permintaan').change(function(){
                var status_permintaan = $('#status_permintaan').val();
                $('#LanjutanKonfirmasiPermintaan').html('Loading...');
                if(status_permintaan==""){
                    $('#LanjutanKonfirmasiPermintaan').html('');
                }
                if(status_permintaan=="Ditolak"){
                    $('#LanjutanKonfirmasiPermintaan').load('_Page/Laboratorium/FormLanjutanDitolak.php');
                }
                if(status_permintaan=="Diterima"){
                    $('#LanjutanKonfirmasiPermintaan').load('_Page/Laboratorium/FormLanjutanDiterima.php');
                }
            });
            //Submit Konfirmasi Permintaan
            $('#ProsesKonfirmasiPermintaan').submit(function(){
                var ProsesKonfirmasiPermintaan = $('#ProsesKonfirmasiPermintaan').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#NotifikasiKonfirmasiPermintaan').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Laboratorium/ProsesKonfirmasiPermintaan.php',
                    data 	    :  ProsesKonfirmasiPermintaan,
                    success     : function(data){
                        $('#NotifikasiKonfirmasiPermintaan').html(data);
                        var NotifikasiKonfirmasiPermintaanBerhasil=$('#NotifikasiKonfirmasiPermintaanBerhasil').html();
                        if(NotifikasiKonfirmasiPermintaanBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Update Pemeriksaan
$('#ModalUpdatePemeriksaan').on('show.bs.modal', function (e) {
    var id_permintaan = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#FormUpdatePemeriksaan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormUpdatePemeriksaan.php',
        data 	    :  {id_permintaan: id_permintaan},
        success     : function(data){
            $('#FormUpdatePemeriksaan').html(data);
            //Submit Update Pemeriksaan
            $('#ProsesUpdatePemeriksaan').submit(function(){
                var ProsesUpdatePemeriksaan = $('#ProsesUpdatePemeriksaan').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#NotifikasiUpdatePemeriksaan').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Laboratorium/ProsesUpdatePemeriksaan.php',
                    data 	    :  ProsesUpdatePemeriksaan,
                    success     : function(data){
                        $('#NotifikasiUpdatePemeriksaan').html(data);
                        var NotifikasiUpdatePemeriksaanBerhasil=$('#NotifikasiUpdatePemeriksaanBerhasil').html();
                        if(NotifikasiUpdatePemeriksaanBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Tambah Spesimen
$('#ModalTambahSpesiemen').on('show.bs.modal', function (e) {
    var id_lab = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#FormTambahSpesimen').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormTambahSpesimen.php',
        data 	    :  {id_lab: id_lab},
        success     : function(data){
            $('#FormTambahSpesimen').html(data);
            //Submit Update Pemeriksaan
            $('#ProsesTambahSpesimen').submit(function(){
                var ProsesTambahSpesimen = $('#ProsesTambahSpesimen').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#NotifikasiTambahSpesimen').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Laboratorium/ProsesTambahSpesimen.php',
                    data 	    :  ProsesTambahSpesimen,
                    success     : function(data){
                        $('#NotifikasiTambahSpesimen').html(data);
                        var NotifikasiTambahSpesimenBerhasil=$('#NotifikasiTambahSpesimenBerhasil').html();
                        if(NotifikasiTambahSpesimenBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Detail Spesimen
$('#ModalDetailSpesimen').on('show.bs.modal', function (e) {
    var id_laboratorium_sample = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#FormDetailSpesimen').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormDetailSpesimen.php',
        data 	    :  {id_laboratorium_sample: id_laboratorium_sample},
        success     : function(data){
            $('#FormDetailSpesimen').html(data);
        }
    });
});
//Modal Edit Spesimen
$('#ModalEditSpesimen').on('show.bs.modal', function (e) {
    var id_laboratorium_sample = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#FormEditSpesimen').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormEditSpesimen.php',
        data 	    :  {id_laboratorium_sample: id_laboratorium_sample},
        success     : function(data){
            $('#FormEditSpesimen').html(data);
            //Submit Edit Pemeriksaan
            $('#ProsesEditSpesimen').submit(function(){
                var ProsesEditSpesimen = $('#ProsesEditSpesimen').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#NotifikasiEditSpesimen').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Laboratorium/ProsesEditSpesimen.php',
                    data 	    :  ProsesEditSpesimen,
                    success     : function(data){
                        $('#NotifikasiEditSpesimen').html(data);
                        var NotifikasiEditSpesimenBerhasil=$('#NotifikasiEditSpesimenBerhasil').html();
                        if(NotifikasiEditSpesimenBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Hapus Spesimen Lab
$('#ModalHapusSpesimen').on('show.bs.modal', function (e) {
    var id_laboratorium_sample = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#FormHapusSpesimen').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormHapusSpesimen.php',
        data 	    :  {id_laboratorium_sample: id_laboratorium_sample},
        success     : function(data){
            $('#FormHapusSpesimen').html(data);
            $('#KonfirmasiHapusSpesimen').click(function(){
                $('#NotifikasiHapusSpesiemen').html('Loading...');
                $.ajax({
                    url     : "_Page/Laboratorium/ProsesHapusSpesimen.php",
                    method  : "POST",
                    data    :  {id_laboratorium_sample: id_laboratorium_sample},
                    success : function (data) {
                        $('#NotifikasiHapusSpesiemen').html(data);
                        //Notifikasi Proses Hapus
                        var NotifikasiHapusSpesiemenBerhasil=$('#NotifikasiHapusSpesiemenBerhasil').html();
                        if(NotifikasiHapusSpesiemenBerhasil=="Success"){
                            location.reload();
                        }
                    }
                })
            });
        }
    });
});
//Modal Cetak Spesimen Lab
$('#ModaCetakLabelSpesimen').on('show.bs.modal', function (e) {
    var id_laboratorium_sample = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#FormCetakLabelSpesimen').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormCetakLabelSpesimen.php',
        data 	    :  {id_laboratorium_sample: id_laboratorium_sample},
        success     : function(data){
            $('#FormCetakLabelSpesimen').html(data);
        }
    });
});
$('#ProsesVerifikasiLaboratorium').submit(function(){
    var id_permintaan = $('#GetIdPermintaan').val();
    var SignatureName = $('#SignatureName').val();
    var signature = signaturePad.toDataURL();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#NotifikasiVerifikasiLaboratorium').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/ProsesVerifikasiLaboratorium.php',
        data 	    :  {id_permintaan: id_permintaan, SignatureName: SignatureName, signature: signature},
        success     : function(data){
            $('#NotifikasiVerifikasiLaboratorium').html(data);
            var NotifikasiVerifikasiLaboratoriumBerhasil=$('#NotifikasiVerifikasiLaboratoriumBerhasil').html();
            var UrlBack=$('#UrlBack').html();
            var UrlBack=UrlBack.replace(/&amp;/g, '&');
            if(NotifikasiVerifikasiLaboratoriumBerhasil=="Success"){
                window.location.href=UrlBack;
            }
        }
    });
});
//Modal Cetak Spesimen Lab
$('#ModalTambahHasilPemeriksaan').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_laboratorium_sample = pecah[0];
    var id_laboratorium_parameter = pecah[1];
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#FormHasilPemeriksaan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormHasilPemeriksaan.php',
        data 	    :  {id_laboratorium_sample: id_laboratorium_sample, id_laboratorium_parameter: id_laboratorium_parameter},
        success     : function(data){
            $('#FormHasilPemeriksaan').html(data);
            //Proses Simpan hasil Pemeriksaan
            $('#ProsesTambahHasilPemeriksaan').submit(function(){
                var ProsesTambahHasilPemeriksaan = $('#ProsesTambahHasilPemeriksaan').serialize();
                $('#NotifikasiTambahHasilPemeriksaan').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Laboratorium/ProsesTambahHasilPemeriksaan.php',
                    data 	    :  ProsesTambahHasilPemeriksaan,
                    success     : function(data){
                        $('#NotifikasiTambahHasilPemeriksaan').html(data);
                        var NotifikasiTambahHasilPemeriksaanBerhasil=$('#NotifikasiTambahHasilPemeriksaanBerhasil').html();
                        if(NotifikasiTambahHasilPemeriksaanBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Hapus Spesimen Lab
$('#ModalHapusHasilPemeriksaan').on('show.bs.modal', function (e) {
    var id_rincian_lab = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#FormHapusHasilPemeriksaan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormHapusHasilPemeriksaan.php',
        data 	    :  {id_rincian_lab: id_rincian_lab},
        success     : function(data){
            $('#FormHapusHasilPemeriksaan').html(data);
            $('#KonfirmasiHapusHasilPemeriksaan').click(function(){
                $('#NotifikasiHapusHasilPemeriksaan').html('Loading...');
                $.ajax({
                    url     : "_Page/Laboratorium/ProsesHapusHasilPemeriksaan.php",
                    method  : "POST",
                    data    :  {id_rincian_lab: id_rincian_lab},
                    success : function (data) {
                        $('#NotifikasiHapusHasilPemeriksaan').html(data);
                        //Notifikasi Proses Hapus
                        var NotifikasiHapusHasilPemeriksaanBerhasil=$('#NotifikasiHapusHasilPemeriksaanBerhasil').html();
                        if(NotifikasiHapusHasilPemeriksaanBerhasil=="Success"){
                            location.reload();
                        }
                    }
                })
            });
        }
    });
});
//Modal Cetak Hasil Pemeriksaan
$('#ModalCetakHasilPemeriksaan').on('show.bs.modal', function (e) {
    var id_lab = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#FormCetakHasilPemeriksaan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Laboratorium/FormCetakHasilPemeriksaan.php',
        data 	    :  {id_lab: id_lab},
        success     : function(data){
            $('#FormCetakHasilPemeriksaan').html(data);
        }
    });
});
//Modal Export Permintaan Laboratorium
$('#ModalExportPermintaanLab').on('show.bs.modal', function (e) {
    $('#periode').change(function(){
        $('#KeteranganWaktu').html('Loading...');
        var periode=$('#periode').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Laboratorium/FormKeteranganWaktu.php',
            data 	    :  {periode: periode},
            success     : function(data){
                $('#KeteranganWaktu').html(data);
            }
        });
    });
});
//Default Setting Waktu Data
var PeriodeDataExport = $('#PeriodeDataExport').val();
var GetTahunForm = $('#GetTahunForm').val();
var GetBulanForm = $('#GetBulanForm').val();
var GetWaktu = $('#GetWaktu').val();
$('#SwitchKeteranganWaktu').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Radiologi/SwitchKeteranganWaktu.php',
    data 	    :  {PeriodeDataExport: PeriodeDataExport, GetTahunForm: GetTahunForm, GetBulanForm: GetBulanForm, GetWaktu: GetWaktu},
    success     : function(data){
        $('#SwitchKeteranganWaktu').html(data);
    }
});
//Ketika Perubahan Periode Data Export
$('#PeriodeDataExport').change(function(){
    var PeriodeDataExport = $('#PeriodeDataExport').val();
    $('#SwitchKeteranganWaktu').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Radiologi/SwitchKeteranganWaktu.php',
        data 	    :  {PeriodeDataExport: PeriodeDataExport},
        success     : function(data){
            $('#SwitchKeteranganWaktu').html(data);
        }
    });
});
//Default Grafik
var NamaData="Grafik Layanan Laboratorium";
var GetTahunForm = $('#GetTahunForm').val();
var GetBulanForm = $('#GetBulanForm').val();
var GetWaktu = $('#GetWaktu').val();
var PeriodeDataExport = $('#PeriodeDataExport').val();
var Loading='Loading..';
$('#GrafikData').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Laboratorium/GrafikLaboratorium.php',
    data 	    :  {GetTahunForm: GetTahunForm, GetBulanForm: GetBulanForm, GetWaktu: GetWaktu, PeriodeDataExport:PeriodeDataExport},
    enctype     : 'multipart/form-data',
    success     : function(data){
        var options = {
            chart: {
                height: 400,
                type: 'bar',
            },
            dataLabels: {
                enabled: false
            },
            series: [],
            title: {
                text: NamaData,
            },
            noData: {
                text: 'Loading...'
            }
        }
        
        var chart = new ApexCharts(
            document.querySelector("#GrafikData"),
            options
        );
        var UrlData = '_Page/Laboratorium/GrafikLaboratorium.json';
        $.getJSON(UrlData, function(response) {
            chart.updateSeries([{
                name: NamaData,
                data: response
            }])
        });
        chart.render();
    }
});
//SIGNATURE PAD
// script di dalam ini akan dijalankan pertama kali saat dokumen dimuat
document.addEventListener('DOMContentLoaded', function () {
    resizeCanvas();
})
//script ini berfungsi untuk menyesuaikan tanda tangan dengan ukuran canvas
function resizeCanvas() {
    var ratio = Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}
var canvas = document.getElementById('signature-pad');

//warna dasar signaturepad
var signaturePad = new SignaturePad(canvas, {
    backgroundColor: 'rgb(255, 255, 255)'
});
//saat tombol clear diklik maka akan menghilangkan seluruh tanda tangan
document.getElementById('clear').addEventListener('click', function () {
    signaturePad.clear();
});

//saat tombol undo diklik maka akan mengembalikan tanda tangan sebelumnya
document.getElementById('undo').addEventListener('click', function () {
    var data = signaturePad.toData();
    if (data) {
        data.pop(); // remove the last dot or line
        signaturePad.fromData(data);
    }
});

//saat tombol change color diklik maka akan merubah warna pena
document.getElementById('change-color').addEventListener('click', function () {
    //jika warna pena biru maka buat menjadi hitam dan sebaliknya
    if(signaturePad.penColor == "rgba(0, 0, 255, 1)"){
        signaturePad.penColor = "rgba(0, 0, 0, 1)";
    }else{
        if(signaturePad.penColor == "rgba(0, 0, 0, 1)"){
            signaturePad.penColor = "rgba(255, 99, 71)";
        }else{
            signaturePad.penColor = "rgba(0, 0, 255, 1)";
        }
    }
});

