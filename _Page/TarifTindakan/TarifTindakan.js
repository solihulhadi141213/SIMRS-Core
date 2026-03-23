//menampilkan Tarif dan Tindakan Pertama Kali
var BatasPencarian = $('#BatasPencarian').serialize();
$('#MenampilkanTabelTarifTindakan').html('<span class="text-primary">Loading...</span>');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/TarifTindakan/TabelTarifTindakan.php',
    data 	    :  BatasPencarian,
    success     : function(data){
        $('#MenampilkanTabelTarifTindakan').html(data);
    }
});
//Kondisi Ketika Batas Data Diubah
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    $('#MenampilkanTabelTarifTindakan').html('<span class="text-primary">Loading...</span>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/TarifTindakan/TabelTarifTindakan.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelTarifTindakan').html(data);
        }
    });
});
//Ketika Dasar Urutan Diubah
$('#OrderBy').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    $('#MenampilkanTabelTarifTindakan').html('<span class="text-primary">Loading...</span>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/TarifTindakan/TabelTarifTindakan.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelTarifTindakan').html(data);
        }
    });
});
//Ketika Mode Urutan Diubah
$('#ShortBy').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    $('#MenampilkanTabelTarifTindakan').html('<span class="text-primary">Loading...</span>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/TarifTindakan/TabelTarifTindakan.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelTarifTindakan').html(data);
        }
    });
});
//Ketika Keyword By Diubah
$('#keyword').keyup(function(){
    var keyword_by = $('#keyword_by').val();
    var keyword = $('#keyword').val();
    var length_keyword = keyword.length;
    if(keyword_by=="nama"||keyword_by=="kategori"){
        if(length_keyword>3){
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/TarifTindakan/keyword_list.php',
                data 	    :  {keyword: keyword, keyword_by: keyword_by},
                success     : function(data){
                    $('#keyword_list').html(data);
                }
            });
        }
    }
});
//ketika Pencarian Data Dimulai
$('#BatasPencarian').submit(function(){
    //Antisipasi Jika Posisi Halaman Tidak Di Halaman 1
    $('#page').val("1");
    var BatasPencarian = $('#BatasPencarian').serialize();
    $('#MenampilkanTabelTarifTindakan').html('<span class="text-primary">Loading...</span>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/TarifTindakan/TabelTarifTindakan.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelTarifTindakan').html(data);
        }
    });
});
//Ketika Form Tambah Tarif Tindakan Muncul
$('#ModalTambahTarifTindakan').on('show.bs.modal', function (e) {
    $('#NotifikasiTambahTarifTindakan').html('<small class="text-primary">Pastikan informasi tarif tindakan sudah terisi dengan benar.</small>');
});
//Ketika Kategori diketik
$('#kategori').keyup(function(){
    var kategori=$('#kategori').val();
    var charCount = kategori.length;
    if(charCount>1){
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/TarifTindakan/SelectKategori.php',
            data 	    :  {kategori: kategori},
            success     : function(data){
                $('#ListKategori').html(data);
            }
        });
    }
});
//Proses Simpan Tarif Tindakan Dimulai
$('#ProsesTambahTarifTindakan').submit(function(){
    var ProsesTambahTarifTindakan = $('#ProsesTambahTarifTindakan').serialize();
    $('#NotifikasiTambahTarifTindakan').html('<small class="text-primary">Loading...</small>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/TarifTindakan/ProsesTambahTarifTindakan.php',
        data 	    :  ProsesTambahTarifTindakan,
        success     : function(data){
            $('#NotifikasiTambahTarifTindakan').html(data);
            var NotifikasiTambahTarifTindakanBerhasil=$('#NotifikasiTambahTarifTindakanBerhasil').html();
            if(NotifikasiTambahTarifTindakanBerhasil=="Success"){
                //Reset Form
                $('#ProsesTambahTarifTindakan')[0].reset();
                //Tutup Modal
                $('#ModalTambahTarifTindakan').modal('hide');
                //Tampilkan Data
                $('#MenampilkanTabelTarifTindakan').html('<span class="text-primary">Loading...</span>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/TarifTindakan/TabelTarifTindakan.php',
                    success     : function(data){
                        $('#MenampilkanTabelTarifTindakan').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Tarif Tindakan Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Detail Tarif
$('#ModalDetailTarif').on('show.bs.modal', function (e) {
    var id_tarif = $(e.relatedTarget).data('id');
    $('#FormDetailTarif').html('<div class="modal-body">Loading...</div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/TarifTindakan/FormDetailTarif.php',
        data 	    :  {id_tarif: id_tarif},
        success     : function(data){
            $('#FormDetailTarif').html(data);
        }
    });
});
//Modal Edit Tarif
$('#ModalEditTarif').on('show.bs.modal', function (e) {
    var id_tarif = $(e.relatedTarget).data('id');
    $('#NotifikasiEditTarifTindakan').html('<small class="text-primary">Pastikan informasi tarif tindakan sudah terisi dengan benar.</small>');
    $('#FormEditTarifTindakan').html('<div class="modal-body">Loading...</div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/TarifTindakan/FormEditTarifTindakan.php',
        data 	    :  {id_tarif: id_tarif},
        success     : function(data){
            $('#FormEditTarifTindakan').html(data);
        }
    });
});
//Modal Edit Tarif 2 (Yang Berada Di Dalam Halaman Detail)
$('#ModalEditTarif2').on('show.bs.modal', function (e) {
    var id_tarif = $(e.relatedTarget).data('id');
    $('#NotifikasiEditTarifTindakan2').html('<small class="text-primary">Pastikan informasi tarif tindakan sudah terisi dengan benar.</small>');
    $('#FormEditTarifTindakan2').html('<div class="modal-body">Loading...</div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/TarifTindakan/FormEditTarifTindakan.php',
        data 	    :  {id_tarif: id_tarif},
        success     : function(data){
            $('#FormEditTarifTindakan2').html(data);
        }
    });
});
//Proses Edit Tarif Tindakan Dimulai
$('#ProsesEditTarifTindakan').submit(function(){
    var ProsesEditTarifTindakan = $('#ProsesEditTarifTindakan').serialize();
    $('#NotifikasiEditTarifTindakan').html('<small class="text-primary">Loading...</small>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/TarifTindakan/ProsesEditTarifTindakan.php',
        data 	    :  ProsesEditTarifTindakan,
        success     : function(data){
            $('#NotifikasiEditTarifTindakan').html(data);
            var NotifikasiEditTarifTindakanBerhasil=$('#NotifikasiEditTarifTindakanBerhasil').html();
            if(NotifikasiEditTarifTindakanBerhasil=="Success"){
                //Reset Form
                $('#ProsesEditTarifTindakan')[0].reset();
                //Tutup Modal
                $('#ModalEditTarif').modal('hide');
                //Tampilkan Data
                var BatasPencarian = $('#BatasPencarian').serialize();
                $('#MenampilkanTabelTarifTindakan').html('<span class="text-primary">Loading...</span>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/TarifTindakan/TabelTarifTindakan.php',
                    data 	    :  BatasPencarian,
                    success     : function(data){
                        $('#MenampilkanTabelTarifTindakan').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Tarif Tindakan Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Proses Edit Tarif2 Tindakan Dimulai
$('#ProsesEditTarifTindakan2').submit(function(){
    var ProsesEditTarifTindakan2 = $('#ProsesEditTarifTindakan2').serialize();
    $('#NotifikasiEditTarifTindakan2').html('<small class="text-primary">Loading...</small>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/TarifTindakan/ProsesEditTarifTindakan.php',
        data 	    :  ProsesEditTarifTindakan2,
        success     : function(data){
            $('#NotifikasiEditTarifTindakan2').html(data);
            var NotifikasiEditTarifTindakanBerhasil=$('#NotifikasiEditTarifTindakanBerhasil').html();
            if(NotifikasiEditTarifTindakanBerhasil=="Success"){
                //Reload Halaman
                location.reload();
            }
        }
    });
});
//Ketika Modal Hapus Muncul
$('#ModalHapusTarif').on('show.bs.modal', function (e) {
    var id_tarif = $(e.relatedTarget).data('id');
    $('#NotifikasiHapusTarif').html('');
    $('#PutIdTarifHapus').val(id_tarif);
});
//Proses Hapus Tarif Tindakan Dimulai
$('#ProsesHapusTarif').submit(function(){
    var ProsesHapusTarif = $('#ProsesHapusTarif').serialize();
    $('#NotifikasiHapusTarif').html('<small class="text-primary">Loading...</small>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/TarifTindakan/ProsesHapusTarif.php',
        data 	    :  ProsesHapusTarif,
        success     : function(data){
            $('#NotifikasiHapusTarif').html(data);
            var NotifikasiHapusTarifBerhasil=$('#NotifikasiHapusTarifBerhasil').html();
            if(NotifikasiHapusTarifBerhasil=="Success"){
                //Tutup Modal
                $('#ModalHapusTarif').modal('hide');
                //Tampilkan Data
                var BatasPencarian = $('#BatasPencarian').serialize();
                $('#MenampilkanTabelTarifTindakan').html('<span class="text-primary">Loading...</span>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/TarifTindakan/TabelTarifTindakan.php',
                    data 	    :  BatasPencarian,
                    success     : function(data){
                        $('#MenampilkanTabelTarifTindakan').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Hapus Tarif Tindakan Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Ketika Menampilkan Detail Tarif Dan Tindakan, Pada Kolom Unit Cost Menampilkan List Unit Cost
var PutIdTarifInDetail = $('#PutIdTarifInDetail').html();
$('#MenampilkanTabelUnitCost').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/TarifTindakan/TabelUnitCost.php',
    data 	    :  {id_tarif: PutIdTarifInDetail},
    success     : function(data){
        $('#MenampilkanTabelUnitCost').html(data);
    }
});
//Kondisi Ketika Modal Tambah Data Cost
$('#ModalTambahUnitCost').on('show.bs.modal', function (e) {
    var id_tarif =$('#PutIdTarifInDetail').html();
    $('#PutIdTarifForAddCost').val(id_tarif);
    $('#NotifikasiTambahUnitCost').html('<small class="text-primary">Pastikan Informasi Unit Cost Yang Anda masukan Sudah Benar</small>');
});
//Proses Tambah Data Cost
$('#ProsesTambahUnitCost').submit(function(){
    var ProsesTambahUnitCost = $('#ProsesTambahUnitCost').serialize();
    $('#NotifikasiTambahUnitCost').html('<small class="text-primary">Loading...</small>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/TarifTindakan/ProsesTambahUnitCost.php',
        data 	    :  ProsesTambahUnitCost,
        success     : function(data){
            $('#NotifikasiTambahUnitCost').html(data);
            var NotifikasiTambahUnitCostBerhasil=$('#NotifikasiTambahUnitCostBerhasil').html();
            if(NotifikasiTambahUnitCostBerhasil=="Success"){
                //Reset Form
                $('#ProsesTambahUnitCost')[0].reset();
                //Tutup Modal
                $('#ModalTambahUnitCost').modal('hide');
                //Tampilkan Data Unit Cost
                var PutIdTarifInDetail = $('#PutIdTarifInDetail').html();
                $('#MenampilkanTabelUnitCost').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/TarifTindakan/TabelUnitCost.php',
                    data 	    :  {id_tarif: PutIdTarifInDetail},
                    success     : function(data){
                        $('#MenampilkanTabelUnitCost').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Unit Cost Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Kondisi Ketika Modal Tambah Data Cost
$('#ModalEditUnitCost').on('show.bs.modal', function (e) {
    var id_cost = $(e.relatedTarget).data('id');
    $('#NotifikasiEditUnitCost').html('<small class="text-primary">Pastikan Informasi Unit Cost Yang Anda masukan Sudah Benar</small>');
    $('#FormEditUnitCost').html('<div class="row"><div class="col-md-12 text-center text-primary">Loading...</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/TarifTindakan/FormEditUnitCost.php',
        data 	    :  {id_cost: id_cost},
        success     : function(data){
            $('#FormEditUnitCost').html(data);
        }
    });
});
//Proses Edit Data Cost
$('#ProsesEditUnitCost').submit(function(){
    var ProsesEditUnitCost = $('#ProsesEditUnitCost').serialize();
    $('#NotifikasiEditUnitCost').html('<small class="text-primary">Loading...</small>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/TarifTindakan/ProsesEditUnitCost.php',
        data 	    :  ProsesEditUnitCost,
        success     : function(data){
            $('#NotifikasiEditUnitCost').html(data);
            var NotifikasiEditUnitCostBerhasil=$('#NotifikasiEditUnitCostBerhasil').html();
            if(NotifikasiEditUnitCostBerhasil=="Success"){
                //Reset Form
                $('#ProsesEditUnitCost')[0].reset();
                //Tutup Modal
                $('#ModalEditUnitCost').modal('hide');
                //Tampilkan Data Unit Cost
                var PutIdTarifInDetail = $('#PutIdTarifInDetail').html();
                $('#MenampilkanTabelUnitCost').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/TarifTindakan/TabelUnitCost.php',
                    data 	    :  {id_tarif: PutIdTarifInDetail},
                    success     : function(data){
                        $('#MenampilkanTabelUnitCost').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Unit Cost Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Ketika Modal Hapus Unit Cost Muncul
$('#ModalHapusUnitCost').on('show.bs.modal', function (e) {
    var id_cost = $(e.relatedTarget).data('id');
    $('#NotifikasiHapusUnitCost').html('');
    $('#PutIdCostHapus').val(id_cost);
});
//Proses Hapus Unit Cost
$('#ProsesHapusUnitCost').submit(function(){
    var ProsesHapusUnitCost = $('#ProsesHapusUnitCost').serialize();
    $('#NotifikasiHapusUnitCost').html('<small class="text-primary">Loading...</small>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/TarifTindakan/ProsesHapusUnitCost.php',
        data 	    :  ProsesHapusUnitCost,
        success     : function(data){
            $('#NotifikasiHapusUnitCost').html(data);
            var NotifikasiHapusUnitCostBerhasil=$('#NotifikasiHapusUnitCostBerhasil').html();
            if(NotifikasiHapusUnitCostBerhasil=="Success"){
                //Tutup Modal
                $('#ModalHapusUnitCost').modal('hide');
                //Tampilkan Data Unit Cost
                var PutIdTarifInDetail = $('#PutIdTarifInDetail').html();
                $('#MenampilkanTabelUnitCost').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/TarifTindakan/TabelUnitCost.php',
                    data 	    :  {id_tarif: PutIdTarifInDetail},
                    success     : function(data){
                        $('#MenampilkanTabelUnitCost').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Hapus Unit Cost Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});