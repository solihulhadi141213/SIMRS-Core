//Menampilkan Transaksi Pertama Kali
var CariFilterTransaksi = $('#CariFilterTransaksi').serialize();
$('#TabelTransaksi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Transaksi/TabelTransaksi.php',
    data 	    :  CariFilterTransaksi,
    success     : function(data){
        $('#TabelTransaksi').html(data);
    }
});
//Ketika Batas Data Diubah
$('#batas').change(function(){
    var CariFilterTransaksi = $('#CariFilterTransaksi').serialize();
    $('#TabelTransaksi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/TabelTransaksi.php',
        data 	    :  CariFilterTransaksi,
        success     : function(data){
            $('#TabelTransaksi').html(data);
        }
    });
});
//Ketika Dasar Urutan Diubah
$('#OrderBy').change(function(){
    var CariFilterTransaksi = $('#CariFilterTransaksi').serialize();
    $('#TabelTransaksi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/TabelTransaksi.php',
        data 	    :  CariFilterTransaksi,
        success     : function(data){
            $('#TabelTransaksi').html(data);
        }
    });
});
//Ketika Mode Urutan Diubah
$('#ShortBy').change(function(){
    var CariFilterTransaksi = $('#CariFilterTransaksi').serialize();
    $('#TabelTransaksi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/TabelTransaksi.php',
        data 	    :  CariFilterTransaksi,
        success     : function(data){
            $('#TabelTransaksi').html(data);
        }
    });
});
//Ketika Proses Pencarian Dimulai
$('#CariFilterTransaksi').submit(function(){
    $('#page').val('1');
    var CariFilterTransaksi = $('#CariFilterTransaksi').serialize();
    $('#TabelTransaksi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/TabelTransaksi.php',
        data 	    :  CariFilterTransaksi,
        success     : function(data){
            $('#TabelTransaksi').html(data);
        }
    });
});
//Modal Detail Transaksi
$('#ModalDetailTransaksi').on('show.bs.modal', function (e) {
    var id_transaksi = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormDetailTransaksi').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/FormDetailTransaksi.php',
        data 	    :  {id_transaksi: id_transaksi},
        success     : function(data){
            $('#FormDetailTransaksi').html(data);
        }
    });
});
//Modal Detail Pasien
$('#ModalDetailPasien').on('show.bs.modal', function (e) {
    var id_pasien = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormDetailPasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/FormDetailPasien.php',
        data 	    :  {id_pasien: id_pasien},
        success     : function(data){
            $('#FormDetailPasien').html(data);
        }
    });
});
//Modal Rincian Transaksi
$('#ModalRincianTransaksi').on('show.bs.modal', function (e) {
    var id_transaksi = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormRincianTransaksi').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/FormRincianTransaksi.php',
        data 	    :  {id_transaksi: id_transaksi},
        success     : function(data){
            $('#FormRincianTransaksi').html(data);
        }
    });
});

//TAMBAH TRANSAKSI
//menampilkan Tabel Rincian
var KodeTransaksi = $('#PutKode').val();
$('#TabelRincianTransaksi').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Transaksi/TabelRincianTransaksi.php',
    data 	    :  {kode: KodeTransaksi},
    success     : function(data){
        $('#TabelRincianTransaksi').html(data);
    }
});

//Ketika Memilih Jenis Transaksi
$('#PutJenisTransaksi').change(function(){
    var JenisTransaksi = $('#PutJenisTransaksi').val();
    $('#PutKode').val('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/ReloadKodeTransaksi.php',
        data 	    :  {JenisTransaksi: JenisTransaksi},
        success     : function(data){
            var dataWithoutSpaces = data.replace(/\s/g, '');
            $('#PutKode').val(dataWithoutSpaces);
            $('#TabelRincianTransaksi').html('Loading...');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Transaksi/TabelRincianTransaksi.php',
                data 	    :  {kode: dataWithoutSpaces},
                success     : function(data){
                    $('#TabelRincianTransaksi').html(data);
                }
            });
        }
    });
});
//Modal List pasien
$('#ModalListPasien').on('show.bs.modal', function (e) {
    var ProsesPencarianPasien =$('#ProsesPencarianPasien').serialize();
    var Loading='<div class="row"><div class="col col-md-12">Loading..</div></div>';
    $('#FormListPasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/ListPasien.php',
        data 	    :  ProsesPencarianPasien,
        success     : function(data){
            $('#FormListPasien').html(data);
        }
    });
    //Ketika Dimulai Pencarian
    $('#ProsesPencarianPasien').submit(function(){
        var ProsesPencarianPasien =$('#ProsesPencarianPasien').serialize();
        var Loading='<div class="row"><div class="col col-md-12">Loading..</div></div>';
        $('#FormListPasien').html(Loading);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Transaksi/ListPasien.php',
            data 	    :  ProsesPencarianPasien,
            success     : function(data){
                $('#FormListPasien').html(data);
            }
        });
    });
});
//Modal Info Pasien
$('#ModalInfoPasien').on('show.bs.modal', function (e) {
    var id_pasien =$('#PutIdPasien').val();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormInfoPasien').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/FormDetailPasien.php',
        data 	    :  {id_pasien: id_pasien},
        success     : function(data){
            $('#FormInfoPasien').html(data);
        }
    });
});
//Ketika Remove Id Pasien
$('#RemoveIdPasien').click(function(){
    $('#PutIdPasien').html('<option value="">Pilih</option>');
    $('#ModalListPasien').modal('hide');
});
//Modal List Kunjungan
$('#ModalListKunjungan').on('show.bs.modal', function (e) {
    PutIdPasien=$('#PutIdPasien').val();
    var Loading='<div class="row"><div class="col col-md-12">Loading..</div></div>';
    $('#FormListKunjungan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/ListKunjungan.php',
        data 	    :  {id_pasien: PutIdPasien},
        success     : function(data){
            $('#FormListKunjungan').html(data);
        }
    });
});
//Ketika Remove Id Kunjungan
$('#RemoveIdKunjungan').click(function(){
    $('#PutIdKunjungan').html('<option value="">Pilih</option>');
    $('#ModalListKunjungan').modal('hide');
});
//Modal Info Kunjungan
$('#ModalInfoKunjungan').on('show.bs.modal', function (e) {
    var id_kunjungan =$('#PutIdKunjungan').val();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormInfoKunjungan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailInfoKunjungan.php',
        data 	    :  {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormInfoKunjungan').html(data);
        }
    });
});
//Modal List Dokter
$('#ModalListDokter').on('show.bs.modal', function (e) {
    var Loading='<div class="row"><div class="col col-md-12">Loading..</div></div>';
    $('#FormListDokter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/ListDokter.php',
        success     : function(data){
            $('#FormListDokter').html(data);
        }
    });
});
//Ketika Remove Id Dokter
$('#RemoveIdDokter').click(function(){
    $('#PutIdDokter').html('<option value="">Pilih</option>');
    $('#ModalListDokter').modal('hide');
});
//Modal List Supplier
$('#ModalListSupplier').on('show.bs.modal', function (e) {
    var ProsesPencarianSupplier =$('#ProsesPencarianSupplier').serialize();
    var Loading='<div class="row"><div class="col col-md-12">Loading..</div></div>';
    $('#FormListSupplier').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/ListSupplier.php',
        data 	    :  ProsesPencarianSupplier,
        success     : function(data){
            $('#FormListSupplier').html(data);
        }
    });
    //Ketika Dimulai Pencarian
    $('#ProsesPencarianSupplier').submit(function(){
        var ProsesPencarianSupplier =$('#ProsesPencarianSupplier').serialize();
        var Loading='<div class="row"><div class="col col-md-12">Loading..</div></div>';
        $('#FormListSupplier').html(Loading);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Transaksi/ListSupplier.php',
            data 	    :  ProsesPencarianSupplier,
            success     : function(data){
                $('#FormListSupplier').html(data);
            }
        });
    });
});
//Ketika Remove Id Supplier
$('#RemoveIdSupplier').click(function(){
    $('#PutIdSupplier').html('<option value="">Pilih</option>');
    $('#ModalListSupplier').modal('hide');
});
//Ketika Form Label Diketik Maka Akan Menampilkan Datalist label
$('#LabelTransaksi').keyup(function(){
    var DataLabel =$('#LabelTransaksi').val();
    var KarakterLabel = DataLabel.length;
    //Ketika Mengetik Lebih Dari 1 Karakter
    if(KarakterLabel>1){
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Transaksi/DataListLabel.php',
            data 	    :  {label: DataLabel},
            success     : function(data){
                $('#DataListLabel').html(data);
            }
        });
    }
});
//Ketika Form Karyawan Diketik Akan Menampilkan Datalist
$('#karyawan').keyup(function(){
    var karyawan =$('#karyawan').val();
    var KarakterKaryawan = karyawan.length;
    //Ketika Mengetik Lebih Dari 1 Karakter
    if(KarakterKaryawan>1){
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Transaksi/DataListKaryawan.php',
            data 	    :  {karyawan: karyawan},
            success     : function(data){
                $('#DataListKaryawan').html(data);
            }
        });
    }
});
//Ketika Tombol Data Obat Tindakan Ditampilkan
$('#FormCariDataObat').submit(function(){
    var ObatAtauTindakan =$('#ObatAtauTindakan').val();
    var KeywordObatAtauTindakan =$('#KeywordObatAtauTindakan').val();
    //Kondisi Apabila Obat Atau Tindakan Belum Diisi
    if(ObatAtauTindakan==""){
        $('#TabelObatAtauTindakan').html('<div class="row"><div class="col-md-12 text-center text-danger">Pilih Data Yang Ingin Ditampilkan Terlebih Dulu</div></div>');
    }else{
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Transaksi/TabelObatAtauTindakan.php',
            data 	    :  {ObatAtauTindakan: ObatAtauTindakan, KeywordObatAtauTindakan: KeywordObatAtauTindakan},
            success     : function(data){
                $('#TabelObatAtauTindakan').html(data);
            }
        });
    }
});
//Ketika Tombol ReloadRincianTransaksi Ditekan
$('#ReloadRincianTransaksi').click(function(){
    var KodeTransaksi = $('#PutKode').val();
    $('#TabelRincianTransaksi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/TabelRincianTransaksi.php',
        data 	    :  {kode: KodeTransaksi},
        success     : function(data){
            $('#TabelRincianTransaksi').html(data);
        }
    });
});
//Modal Tambah Rincian
$('#ModalTambahRincian').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var IdData = pecah[0];
    var ObatAtauTindakan = pecah[1];
    var KodeTransaksi=$('#PutKode').val();
    var id_kunjungan=$('#PutIdKunjungan').val();
    var transaksi=$('#PutJenisTransaksi').val();
    $('#FormTambahRincianTransaksi').html("Loading...");
    $('#NotifikasiTambahRincian').html('<span class="text-primary">Pastikan rincian transaksi sudah sesuai</span>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/FormTambahRincianTransaksi.php',
        data 	    :  {IdData: IdData, ObatAtauTindakan: ObatAtauTindakan, KodeTransaksi: KodeTransaksi, id_kunjungan: id_kunjungan, transaksi: transaksi},
        success     : function(data){
            $('#FormTambahRincianTransaksi').html(data);
        }
    });
});
//Ketika Proses Tambah Rincian
$('#ProsesTambahRincianTransaksi').submit(function(){
    var ProsesTambahRincianTransaksi =$('#ProsesTambahRincianTransaksi').serialize();
    $('#NotifikasiTambahRincian').html('<span class="text-primary">Loading...</span>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/ProsesTambahRincianTransaksi.php',
        data 	    :  ProsesTambahRincianTransaksi,
        success     : function(data){
            $('#NotifikasiTambahRincian').html(data);
            var NotifikasiTambahRincianBerhasil=$('#NotifikasiTambahRincianBerhasil').html();
            if(NotifikasiTambahRincianBerhasil=="Success"){
                //Reload Rincian
                var KodeTransaksi = $('#PutKode').val();
                $('#TabelRincianTransaksi').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Transaksi/TabelRincianTransaksi.php',
                    data 	    :  {kode: KodeTransaksi},
                    success     : function(data){
                        $('#TabelRincianTransaksi').html(data);
                    }
                });
                //Tutup Modal Form Tambah Rincian
                $('#ModalTambahRincian').modal('hide');
                //Menampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Rincian Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Tambah Rincian Manual
$('#ModalTambahRincianManual').on('show.bs.modal', function (e) {
    var KodeTransaksi=$('#PutKode').val();
    var transaksi=$('#PutJenisTransaksi').val();
    $('#NotifikasiTambahRincianManual').html('<span class="text-primary">Pastikan rincian transaksi sudah sesuai</span>');
    $('#JenisTransaksiManual').val(transaksi);
    $('#KodeTransaksiManual').val(KodeTransaksi);
    //Format Dot
    $( '#QtyRincianManual' ).mask('000.000.000.000.000', {reverse: true});
    $( '#HargaRincianManual' ).mask('000.000.000.000.000', {reverse: true});
    $( '#PpnRincianManual' ).mask('000.000.000.000.000', {reverse: true});
    $( '#DiskonRincianManual' ).mask('000.000.000.000.000', {reverse: true});
    $( '#JumlahRincianManual' ).mask('000.000.000.000.000', {reverse: true});
});
//Kondisi Ketika QTY Manual Diubah
$('#QtyRincianManual').keyup(function(){
    var ProsesTambahRincianTransaksiManual =$('#ProsesTambahRincianTransaksiManual').serialize();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/HitungJumlah.php',
        data 	    :  ProsesTambahRincianTransaksiManual,
        success     : function(data){
            $('#JumlahRincianManual').val(data);
        }
    });
});
//Kondisi Ketika Harga Manual Diubah
$('#HargaRincianManual').keyup(function(){
    var ProsesTambahRincianTransaksiManual =$('#ProsesTambahRincianTransaksiManual').serialize();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/HitungJumlah.php',
        data 	    :  ProsesTambahRincianTransaksiManual,
        success     : function(data){
            $('#JumlahRincianManual').val(data);
        }
    });
});
//Kondisi Ketika PPN Manual Diubah
$('#PpnRincianManual').keyup(function(){
    var ProsesTambahRincianTransaksiManual =$('#ProsesTambahRincianTransaksiManual').serialize();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/HitungJumlah.php',
        data 	    :  ProsesTambahRincianTransaksiManual,
        success     : function(data){
            $('#JumlahRincianManual').val(data);
        }
    });
});
//Kondisi Ketika Diskon Manual Diubah
$('#DiskonRincianManual').keyup(function(){
    var ProsesTambahRincianTransaksiManual =$('#ProsesTambahRincianTransaksiManual').serialize();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/HitungJumlah.php',
        data 	    :  ProsesTambahRincianTransaksiManual,
        success     : function(data){
            $('#JumlahRincianManual').val(data);
        }
    });
});
//Ketika Proses Tambah Rincian Manual
$('#ProsesTambahRincianTransaksiManual').submit(function(){
    var ProsesTambahRincianTransaksiManual =$('#ProsesTambahRincianTransaksiManual').serialize();
    $('#NotifikasiTambahRincianManual').html('<span class="text-primary">Loading...</span>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/ProsesTambahRincianTransaksiManual.php',
        data 	    :  ProsesTambahRincianTransaksiManual,
        success     : function(data){
            $('#NotifikasiTambahRincianManual').html(data);
            var NotifikasiTambahRincianManualBerhasil=$('#NotifikasiTambahRincianManualBerhasil').html();
            if(NotifikasiTambahRincianManualBerhasil=="Success"){
                //Reload Rincian
                var KodeTransaksi = $('#PutKode').val();
                $('#TabelRincianTransaksi').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Transaksi/TabelRincianTransaksi.php',
                    data 	    :  {kode: KodeTransaksi},
                    success     : function(data){
                        $('#TabelRincianTransaksi').html(data);
                    }
                });
                //Reset Form
                $('#ProsesTambahRincianTransaksiManual')[0].reset();
                //Tutup Modal Form Tambah Rincian
                $('#ModalTambahRincianManual').modal('hide');
                //Menampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Rincian Manual Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Edit Rincian
$('#ModalEditRincian').on('show.bs.modal', function (e) {
    var id_rincian = $(e.relatedTarget).data('id');
    $('#NotifikasiEditRincian').load('<span class="text-primary">Pastikan rincian transaksi sudah sesuai</span>');
    $('#FormEditRincian').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/FormEditRincian.php',
        data 	    :  {id_rincian: id_rincian},
        success     : function(data){
            $('#FormEditRincian').html(data);
        }
    });
});
//Modal Hapus Rincian
$('#ModalHapusRincian').on('show.bs.modal', function (e) {
    var id_rincian = $(e.relatedTarget).data('id');
    $('#NotifikasiHapusRincian').load('<span class="text-danger">Apakah anda yakin akan menghapus data rincian ini?</span>');
    $('#GetIdRincianForHapus').val(id_rincian);
});
//Ketika Proses Hapus Rincian
$('#ProsesHapusRincian').submit(function(){
    var ProsesHapusRincian =$('#ProsesHapusRincian').serialize();
    $('#NotifikasiHapusRincian').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Transaksi/ProsesHapusRincian.php',
        data 	    :  ProsesHapusRincian,
        success     : function(data){
            $('#NotifikasiHapusRincian').html(data);
            var NotifikasiHapusRincianBerhasil=$('#NotifikasiHapusRincianBerhasil').html();
            if(NotifikasiHapusRincianBerhasil=="Success"){
                //Reload Rincian
                var KodeTransaksi = $('#PutKode').val();
                $('#TabelRincianTransaksi').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Transaksi/TabelRincianTransaksi.php',
                    data 	    :  {kode: KodeTransaksi},
                    success     : function(data){
                        $('#TabelRincianTransaksi').html(data);
                    }
                });
                //Tutup Modal Form Hapus Rincian
                $('#ModalHapusRincian').modal('hide');
                //Menampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Hapus Rincian Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});