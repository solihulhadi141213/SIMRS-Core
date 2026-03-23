//Inisiasi Id Storage Pertama Kali\
var GetIdPenyimpanan=$('#GetIdPenyimpanan').html();
//Kondisi Data List 
$('#TableSesiStokOpename').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/StokOpename/TableSesiStokOpename.php',
    data 	    :  {id_obat_storage: GetIdPenyimpanan},
    success     : function(data){
        $('#TableSesiStokOpename').html(data);
    }
});
//Kondisi saaat menampilkan modal buat sesi
$('#ModalTambahSesiStokOpename').on('show.bs.modal', function (e) {
    $('#PutIdStorage').val(GetIdPenyimpanan);
});
//Kondisi Data List Item
var ProsesBatasItemSo=$('#ProsesBatasItemSo').serialize();
$('#TableSesiStokOpenameItem').html("Loading...");
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/StokOpename/TableSesiStokOpenameItem.php',
    data 	    :  ProsesBatasItemSo,
    success     : function(data){
        $('#TableSesiStokOpenameItem').html(data);
    }
});
//Ketika Batas Diubah
$('#batas').change(function(){
    var ProsesBatasItemSo=$('#ProsesBatasItemSo').serialize();
    $('#TableSesiStokOpenameItem').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/StokOpename/TableSesiStokOpenameItem.php',
        data 	    :  ProsesBatasItemSo,
        success     : function(data){
            $('#TableSesiStokOpenameItem').html(data);
        }
    });
});
//Ketika Proses Pencarian
$('#ProsesBatasItemSo').submit(function(){
    var ProsesBatasItemSo=$('#ProsesBatasItemSo').serialize();
    $('#TableSesiStokOpenameItem').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/StokOpename/TableSesiStokOpenameItem.php',
        data 	    :  ProsesBatasItemSo,
        success     : function(data){
            $('#TableSesiStokOpenameItem').html(data);
        }
    });
});
//Ketika Modal Tambah SO muncul
$('#ModalTambahSo').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_obat = pecah[0];
    var id_obat_storage = pecah[1];
    var tanggal = pecah[2];
    $('#NotifikasiTambahSo').html('<span class="text-primary">Pastikan data informasi stok opename yang anda input sudah benar</span>');
    $('#FormTambahSo').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/StokOpename/FormTambahSo.php',
        data 	    :  {id_obat: id_obat, id_obat_storage: id_obat_storage, tanggal: tanggal},
        success     : function(data){
            $('#FormTambahSo').html(data);
            //Ketika Stok Akhir Diubah
            $('#stok_akhir').keyup(function(){
                var stok_akhir=$('#stok_akhir').val();
                var stok_awal=$('#stok_awal').val();
                var GetSatuan=$('#GetSatuan').html();
                if (/^\d+$/.test(stok_akhir)) {
                    var Selisih=stok_akhir-stok_awal;
                    if(Selisih<0){
                        var LabelSelisih='<span class="text-danger">'+Selisih+' '+GetSatuan+'</span>';
                    }else{
                        var LabelSelisih='<span class="text-dark">'+Selisih+' '+GetSatuan+'</span>';
                    }
                    $('#PusSelisih').html(LabelSelisih);
                }else{
                    var LabelSelisih='<span class="text-danger">Hanya boleh diisi dengan angka!</span>';
                    $('#PusSelisih').html(LabelSelisih);
                }
            });
        }
    });
});
//Ketika Proses Tambah SO
$('#ProsesTambahSo').submit(function(){
    var ProsesTambahSo=$('#ProsesTambahSo').serialize();
    $('#NotifikasiTambahSo').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/StokOpename/ProsesTambahSo.php',
        data 	    :  ProsesTambahSo,
        success     : function(data){
            $('#NotifikasiTambahSo').html(data);
            var NotifikasiTambahSoBerhasil=$('#NotifikasiTambahSoBerhasil').html();
            if(NotifikasiTambahSoBerhasil=="Success"){
                var ProsesBatasItemSo=$('#ProsesBatasItemSo').serialize();
                $('#TableSesiStokOpenameItem').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/StokOpename/TableSesiStokOpenameItem.php',
                    data 	    :  ProsesBatasItemSo,
                    success     : function(data){
                        $('#TableSesiStokOpenameItem').html(data);
                    }
                });
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Data Stok Opename Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
                //Sembunyikan Modal
                $('#ModalTambahSo').modal('hide');
            }
        }
    });
});
//Ketika Modal Menampilkan Detail Sesi Stok Opename
$('#ModalDetailSesiStokOpename').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_obat_storage = pecah[0];
    var tanggal = pecah[1];
    $('#FormDetailSesiStokOpename').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/StokOpename/FormDetailSesiStokOpename.php',
        data 	    :  {id_obat_storage: id_obat_storage, tanggal: tanggal},
        success     : function(data){
            $('#FormDetailSesiStokOpename').html(data);
        }
    });
});
//Ketika Modal Detail Stok Opename
$('#ModalDetailStokOpenameItem').on('show.bs.modal', function (e) {
    var id_obat_so = $(e.relatedTarget).data('id');
    $('#FormDetailStokOpename').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/StokOpename/FormDetailStokOpename.php',
        data 	    :  {id_obat_so: id_obat_so},
        success     : function(data){
            $('#FormDetailStokOpename').html(data);
        }
    });
});
//Ketika Modal Detail Stok Opename
$('#ModalHapusStokOpenameItem').on('show.bs.modal', function (e) {
    var id_obat_so = $(e.relatedTarget).data('id');
    $('#FormHapusItemStokOpename').html('Loading...');
    $('#NotifikasiHapusItemStokOpename').html('Apakah anda yakin akan menghapus item stok opename ini?');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/StokOpename/FormHapusItemStokOpename.php',
        data 	    :  {id_obat_so: id_obat_so},
        success     : function(data){
            $('#FormHapusItemStokOpename').html(data);
        }
    });
});
//Ketika Proses hapus
$('#ProsesHapusStokOpenameItem').submit(function(){
    var ProsesHapusStokOpenameItem=$('#ProsesHapusStokOpenameItem').serialize();
    $('#NotifikasiHapusItemStokOpename').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/StokOpename/ProsesHapusStokOpenameItem.php',
        data 	    :  ProsesHapusStokOpenameItem,
        success     : function(data){
            $('#NotifikasiHapusItemStokOpename').html(data);
            var NotifikasiHapusItemStokOpenameBerhasil=$('#NotifikasiHapusItemStokOpenameBerhasil').html();
            if(NotifikasiHapusItemStokOpenameBerhasil=="Success"){
                var ProsesBatasItemSo=$('#ProsesBatasItemSo').serialize();
                $('#TableSesiStokOpenameItem').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/StokOpename/TableSesiStokOpenameItem.php',
                    data 	    :  ProsesBatasItemSo,
                    success     : function(data){
                        $('#TableSesiStokOpenameItem').html(data);
                    }
                });
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Hapus Data Stok Opename Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
                //Sembunyikan Modal
                $('#ModalHapusStokOpenameItem').modal('hide');
                $('#ModalDetailStokOpenameItem').modal('hide');
            }
        }
    });
});
//Ketika Modal Edit Stok Opename Item
$('#ModalEditStokOpenameItem').on('show.bs.modal', function (e) {
    var id_obat_so = $(e.relatedTarget).data('id');
    $('#FormEditStokOpenameItem').html('Loading...');
    $('#NotifikasiEditStokOpenameItem').html('Pastikan perubahan data stok opename yang anda lakukan sudah sesuai');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/StokOpename/FormEditStokOpenameItem.php',
        data 	    :  {id_obat_so: id_obat_so},
        success     : function(data){
            $('#FormEditStokOpenameItem').html(data);
            //Ketika Stok Akhir Diubah
            $('#stok_akhir').keyup(function(){
                var stok_akhir=$('#stok_akhir').val();
                var stok_awal=$('#stok_awal').val();
                var GetSatuan=$('#GetSatuan').html();
                if (/^\d+$/.test(stok_akhir)) {
                    var Selisih=stok_akhir-stok_awal;
                    if(Selisih<0){
                        var LabelSelisih='<span class="text-danger">'+Selisih+' '+GetSatuan+'</span>';
                    }else{
                        var LabelSelisih='<span class="text-dark">'+Selisih+' '+GetSatuan+'</span>';
                    }
                    $('#PusSelisih').html(LabelSelisih);
                }else{
                    var LabelSelisih='<span class="text-danger">Hanya boleh diisi dengan angka!</span>';
                    $('#PusSelisih').html(LabelSelisih);
                }
            });
        }
    });
});
//Ketika Proses Edit SO
$('#ProsesEditStokOpenameItem').submit(function(){
    var ProsesEditStokOpenameItem=$('#ProsesEditStokOpenameItem').serialize();
    $('#NotifikasiEditStokOpenameItem').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/StokOpename/ProsesEditStokOpenameItem.php',
        data 	    :  ProsesEditStokOpenameItem,
        success     : function(data){
            $('#NotifikasiEditStokOpenameItem').html(data);
            var NotifikasiEditStokOpenameItemBerhasil=$('#NotifikasiEditStokOpenameItemBerhasil').html();
            if(NotifikasiEditStokOpenameItemBerhasil=="Success"){
                var ProsesBatasItemSo=$('#ProsesBatasItemSo').serialize();
                $('#TableSesiStokOpenameItem').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/StokOpename/TableSesiStokOpenameItem.php',
                    data 	    :  ProsesBatasItemSo,
                    success     : function(data){
                        $('#TableSesiStokOpenameItem').html(data);
                    }
                });
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Data Stok Opename Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
                //Sembunyikan Modal
                $('#ModalEditStokOpenameItem').modal('hide');
                $('#ModalDetailStokOpenameItem').modal('hide');
            }
        }
    });
});
//Ketika Modal Export Stok Opename Muncul
$('#ModalExportStokOpename').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_obat_storage = pecah[0];
    var tanggal = pecah[1];
    $('#FormExportStokOpename').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/StokOpename/FormExportStokOpename.php',
        data 	    :  {id_obat_storage: id_obat_storage, tanggal: tanggal},
        success     : function(data){
            $('#FormExportStokOpename').html(data);
        }
    });
});