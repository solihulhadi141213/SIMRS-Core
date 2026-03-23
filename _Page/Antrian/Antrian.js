$('#MenampilkanDataAntrian').load("_Page/Antrian/TabelAntrian.php");
//Batas dan Pencarian
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='Loading...';
    $('#MenampilkanDataAntrian').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/TabelAntrian.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanDataAntrian').html(data);
        }
    });
});
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
        }
    });
});
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='Loading...';
    $('#MenampilkanDataAntrian').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/TabelAntrian.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanDataAntrian').html(data);
        }
    });
});
//PENCARIAN ANTRIAN BPJS
$('#ModePencarianAntrian').change(function(){
    var ModePencarianAntrian = $('#ModePencarianAntrian').val();
    $('#FormLanjutanPencarianAntrianBpjs').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormLanjutanAntrianBpjs.php',
        data 	    :  {ModePencarianAntrian: ModePencarianAntrian},
        success     : function(data){
            $('#FormLanjutanPencarianAntrianBpjs').html(data);
            //Ketika Kode Poli Dipilih
            $('#KodePoli').change(function(){
                var KodePoli = $('#KodePoli').val();
                $('#KodeDokter').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Antrian/FormOptionDokter.php',
                    data 	    :  {KodePoli: KodePoli},
                    success     : function(data){
                        $('#KodeDokter').html(data);
                    }
                });
            });
            //Ketika Hari Dipilih Dipilih
            $('#KodeHari').change(function(){
                var KodePoli = $('#KodePoli').val();
                var KodeDokter = $('#KodeDokter').val();
                var KodeHari = $('#KodeHari').val();
                $('#JamPraktek').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Antrian/FormOptionJamPraktek.php',
                    data 	    :  {KodePoli: KodePoli, KodeDokter: KodeDokter, KodeHari: KodeHari},
                    success     : function(data){
                        $('#JamPraktek').html(data);
                    }
                });
            });
        }
    });
});
$('#PencarianAntrianBpjs').submit(function(){
    var PencarianAntrianBpjs = $('#PencarianAntrianBpjs').serialize();
    var Loading='Loading...';
    $('#MenampilkanDataAntrian').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/TabelAntrianBpjs.php',
        data 	    :  PencarianAntrianBpjs,
        success     : function(data){
            $('#MenampilkanDataAntrian').html(data);
        }
    });
});
//Menampilkan Form Tambah Antrian Manual (Versi Lama)
$('#ModalAddAntrianManual').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormTambahAntrianManual').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormTambahAntrianManual.php',
        success     : function(data){
            $('#FormTambahAntrianManual').html(data);
            var ProsesPencarianPasien = $('#ProsesPencarianPasien').serialize();
            $('#HasilPencarianPasien').html('Loading');
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Antrian/TabelhasilPencarianPasien.php',
                data 	    :  ProsesPencarianPasien,
                success     : function(data){
                    $('#HasilPencarianPasien').html(data);
                }
            });
            //pencarian
            $('#ProsesPencarianPasien').submit(function(){
                var ProsesPencarianPasien = $('#ProsesPencarianPasien').serialize();
                var Loading='Loading...';
                $('#HasilPencarianPasien').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Antrian/TabelhasilPencarianPasien.php',
                    data 	    :  ProsesPencarianPasien,
                    success     : function(data){
                        $('#HasilPencarianPasien').html(data);
                    }
                });
            });
        }
    });
});
//Modal Get Detail Pasien
$('#ModalGetDetailPasien').on('show.bs.modal', function (e) {
    var id_pasien = $('#id_pasien').val();
    $('#FormDetailIdpasien').html('<tr><td colspan="3"><div class="text-primary">Loading..</div></td></tr>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/DetailPasien.php',
        data 	    :  {id_pasien: id_pasien},
        success     : function(data){
            $('#FormDetailIdpasien').html(data);
        }
    });
});
$('#ModalGetDetailPasien2').on('show.bs.modal', function (e) {
    var id_pasien = $(e.relatedTarget).data('id');
    $('#FormDetailIdpasien2').html('<tr><td colspan="3"><div class="text-primary">Loading..</div></td></tr>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/DetailPasien.php',
        data 	    :  {id_pasien: id_pasien},
        success     : function(data){
            $('#FormDetailIdpasien2').html(data);
        }
    });
});
//Modal Get Detail Kunjungan
$('#ModalGetDetailKunjungan').on('show.bs.modal', function (e) {
    var id_kunjungan = $('#id_kunjungan').val();
    $('#FormDetailKunjungan').html('<tr><td colspan="3"><div class="text-primary">Loading..</div></td></tr>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/DetailKunjungan.php',
        data 	    :  {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormDetailKunjungan').html(data);
        }
    });
});
$('#ModalGetDetailKunjungan2').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormDetailKunjungan2').html('<tr><td colspan="3"><div class="text-primary">Loading..</div></td></tr>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/DetailKunjungan.php',
        data 	    :  {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormDetailKunjungan2').html(data);
        }
    });
});
//Modal Detail NIK Pasien
$('#ModalDetailNik').on('show.bs.modal', function (e) {
    var nik_pasien =  $('#nik').val();
    var DasarPencarianPasienSatuSehat="NIK";
    var DasarPencarianPasienBpjs="NIK";
    $('#FormDetailNik').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormDetailNik.php',
        data 	    :  {nik: nik_pasien},
        success     : function(data){
            $('#FormDetailNik').html(data);
            $('#FormDetailNikByIhs').html("Loading..");
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Pasien/FormHasilPencarianPasienSatuSehat.php',
                data 	    :  {DasarPencarianPasienSatuSehat: DasarPencarianPasienSatuSehat, nik_pasien: nik_pasien},
                success     : function(data){
                    $('#FormDetailNikByIhs').html(data);
                }
            });
            $('#FormDetailNikByBpjs').html("Loading..");
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Pasien/FormHasilPencarianPasienBpjs.php',
                data 	    :  {DasarPencarianPasienBpjs: DasarPencarianPasienBpjs, keyword: nik_pasien},
                success     : function(data){
                    $('#FormDetailNikByBpjs').html(data);
                }
            });
        }
    });
});
$('#ModalDetailNik2').on('show.bs.modal', function (e) {
    var nik_pasien = $(e.relatedTarget).data('id');
    var DasarPencarianPasienSatuSehat="NIK";
    var DasarPencarianPasienBpjs="NIK";
    $('#FormDetailNik2').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormDetailNik.php',
        data 	    :  {nik: nik_pasien},
        success     : function(data){
            $('#FormDetailNik2').html(data);
            $('#FormDetailNikByIhs').html("Loading..");
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Pasien/FormHasilPencarianPasienSatuSehat.php',
                data 	    :  {DasarPencarianPasienSatuSehat: DasarPencarianPasienSatuSehat, nik_pasien: nik_pasien},
                success     : function(data){
                    $('#FormDetailNikByIhs').html(data);
                }
            });
            $('#FormDetailNikByBpjs').html("Loading..");
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Pasien/FormHasilPencarianPasienBpjs.php',
                data 	    :  {DasarPencarianPasienBpjs: DasarPencarianPasienBpjs, keyword: nik_pasien},
                success     : function(data){
                    $('#FormDetailNikByBpjs').html(data);
                }
            });
        }
    });
});
//Modal Detail BPJS Pasien
$('#ModalDetailBpjs').on('show.bs.modal', function (e) {
    var no_bpjs = $('#nomorkartu').val();
    var DasarPencarianPasienBpjs="Noka";
    $('#FormDetailBPJS').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormHasilPencarianPasienBpjs.php',
        data 	    :  {DasarPencarianPasienBpjs: DasarPencarianPasienBpjs, keyword: no_bpjs},
        success     : function(data){
            $('#FormDetailBPJS').html(data);
        }
    });
});
$('#ModalDetailBpjs2').on('show.bs.modal', function (e) {
    var no_bpjs = $(e.relatedTarget).data('id');
    var DasarPencarianPasienBpjs="Noka";
    $('#FormDetailBPJS2').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Pasien/FormHasilPencarianPasienBpjs.php',
        data 	    :  {DasarPencarianPasienBpjs: DasarPencarianPasienBpjs, keyword: no_bpjs},
        success     : function(data){
            $('#FormDetailBPJS2').html(data);
        }
    });
});
//Modal Pencarian Kunjungan Pasien
$('#ModalCariKunjungan').on('show.bs.modal', function (e) {
    var id_pasien = $('#id_pasien').val();
    $('#FormPencarianKunjungan').html('<tr><td colspan="3"><div class="text-primary">Loading..</div></td></tr>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormPencarianKunjungan.php',
        data 	    :  {id_pasien: id_pasien},
        success     : function(data){
            $('#FormPencarianKunjungan').html(data);
        }
    });
});
//Proses Tambahkan Nomor Referensi Ke form
$("#AddKunjunganToForm").submit(function(){
    var AddKunjunganToForm = $('#AddKunjunganToForm').serialize();
    $('#NotifikasiTambahkanKunjunganKeForm').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/ProsesAddKunjunganToForm.php',
        data 	    :  AddKunjunganToForm,
        success     : function(data){
            $('#NotifikasiTambahkanKunjunganKeForm').html(data);
            var NotifikasiTambahkanKunjunganKeFormBerhasil=$('#NotifikasiTambahkanKunjunganKeFormBerhasil').html();
            var NomorKunjunganYangDipilih=$('#NomorKunjunganYangDipilih').html();
            if(NotifikasiTambahkanKunjunganKeFormBerhasil=="Berhasil"){
                $('#id_kunjungan').val(NomorKunjunganYangDipilih);
                $('#ModalCariKunjungan').modal('hide');
                Swal.fire({
                    title: 'Berhasil',
                    text: 'ID Kunjungan Berhasil Ditambahkan',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Pencarian Rujukan
$('#ModalCariRujukan').on('show.bs.modal', function (e) {
    var Loading='<div class="row"><div class="col-md-12"><div class="text-primary">Loading..</div></div></div>';
    var nomorkartu = $('#nomorkartu').val();
    var metode_pembayaran = $('#metode_pembayaran').val();
    var jeniskunjungan = $('#jeniskunjungan').val();
    var TanggalKunjungan = $('#tanggal1').val();
    $('#FormPencarianRujukan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormPencarianRujukan.php',
        data 	    :  {nomorkartu: nomorkartu, metode_pembayaran: metode_pembayaran, jeniskunjungan: jeniskunjungan, TanggalKunjungan: TanggalKunjungan},
        success     : function(data){
            $('#FormPencarianRujukan').html(data);
        }
    });
    //Event Ketika Reload
    $("#ReloadPencarianRujukan").click(function(){
        $('#FormPencarianRujukan').html(Loading);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Antrian/FormPencarianRujukan.php',
            data 	    :  {nomorkartu: nomorkartu, metode_pembayaran: metode_pembayaran, jeniskunjungan: jeniskunjungan, TanggalKunjungan: TanggalKunjungan},
            success     : function(data){
                $('#FormPencarianRujukan').html(data);
            }
        });
    });
});
//Proses Tambahkan Nomor Referensi Ke form
$("#TambahkanReferensiKeForm").click(function(){
    var AddReferensiToForm = $('#AddReferensiToForm').serialize();
    $('#NotifikasiTambahkanReferensiKeForm').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/ProsesAddReferensiToForm.php',
        data 	    :  AddReferensiToForm,
        success     : function(data){
            $('#NotifikasiTambahkanReferensiKeForm').html(data);
            var NotifikasiAddReferensiToFormBerhasil=$('#NotifikasiAddReferensiToFormBerhasil').html();
            var NomorReferensiYangDipilih=$('#NomorReferensiYangDipilih').html();
            if(NotifikasiAddReferensiToFormBerhasil=="Berhasil"){
                $('#nomorreferensi').val(NomorReferensiYangDipilih);
                $('#ModalCariRujukan').modal('hide');
                Swal.fire({
                    title: 'Berhasil',
                    text: 'Nomor Referensi Berhasil Ditambahkan',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//when focus dokter
$("#dokter").focus(function(){
    var poliklinik=$("#poliklinik").val();
    $("#dokter").html('<option>Loading..</option>');
    $.ajax({
        url: "_Page/Pendaftaran/PilihDokter.php",
        type: "POST",
        data: {poliklinik: poliklinik},
        success: function (data) {
            $("#dokter").html(data);
        },
    });
});
//when focus jam
$("#jam").focus(function(){
    var poliklinik=$("#poliklinik").val();
    var dokter=$("#dokter").val();
    var tanggal=$("#tanggal1").val();
    $("#jam").html('<option>Loading..</option>');
    $.ajax({
        url: "_Page/Antrian/PilihJadwal.php",
        type: "POST",
        data: {poliklinik: poliklinik, dokter: dokter, tanggal: tanggal},
        success: function (data) {
            $("#jam").html(data);
        },
    });
});
$("#metode_pembayaran").change(function(){
    var metode_pembayaran=$("#metode_pembayaran").val();
    if(metode_pembayaran=="BPJS"){
        $("#nomorkartu").prop("readonly", false);
        $("#jeniskunjungan").prop("disabled", false);
        $("#nomorreferensi").prop("disabled", false);
        $("#KirimKeWsBpjs").prop("checked", true);
    }
    if(metode_pembayaran=="UMUM"){
        $("#nomorkartu").prop("readonly", true);
        $("#jeniskunjungan").prop("disabled", true);
        $("#nomorreferensi").prop("disabled", true);
        $("#KirimKeWsBpjs").prop("checked", false);
    }
});
$("#ProsesTambahAntrianManual").submit(function(e){
    e.preventDefault();
    var formData = new FormData(this);
    $("#NotifikasTambahAntrianManual").html("Loading....");
    $.ajax({
        url: "_Page/Antrian/ProsesTambahAntrianManual.php",
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $("#NotifikasTambahAntrianManual").html(data);
            //Menangkap variabel notifikasi
            var NotifikasTambahAntrianManualBerhasil = $("#NotifikasTambahAntrianManualBerhasil").html();
            var UrlBack = $("#UrlBack").html();
            var URLBack2=UrlBack.replace(/&amp;/g, '&');
            if(NotifikasTambahAntrianManualBerhasil=="Success"){
                location.href = URLBack2;
            }
        }
    });
});
//Menampilkan antrian
$('#ModalDetailAntrian').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_antrian = pecah[0];
    var keyword = pecah[1];
    var batas = pecah[2];
    var ShortBy = pecah[3];
    var OrderBy = pecah[4];
    var page = pecah[5];
    var posisi = pecah[6];
    var keyword_by = pecah[7];
    var tanggal = pecah[8];
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormDetailAntrian').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormDetailAntrian.php',
        data 	    :  {id_antrian: id_antrian},
        success     : function(data){
            $('#FormDetailAntrian').html(data);
            //Panggil Antrian
            
            //Checkin
            
            //Terdaftar
            $('#ModalTerdaftarAntrian').on('show.bs.modal', function (e) {
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#FormTerdaftar').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Antrian/FormTerdaftar.php',
                    data        :  {id_antrian: id_antrian},
                    success     : function(data){
                        $('#FormTerdaftar').html(data);
                        //Konfirmasi Terdaftar
                        $('#KonfirmasiTerdaftar').click(function(){
                            $('#NotifikasiTerdaftarAntrian').html('Loading...');
                            $.ajax({
                                url     : "_Page/Antrian/ProsesTerdaftarAntrian.php",
                                method  : "POST",
                                data    :  {id_antrian: id_antrian},
                                success : function (data) {
                                    $('#NotifikasiTerdaftarAntrian').html(data);
                                    //Notifikasi Proses Hapus
                                    var NotifikasiTerdaftarAntrianBerhasil=$('#NotifikasiTerdaftarAntrianBerhasil').html();
                                    if(NotifikasiTerdaftarAntrianBerhasil=="Update Terdaftar Antrian Berhasil"){
                                        $.ajax({
                                            type 	    : 'POST',
                                            url 	    : '_Page/Antrian/TabelAntrian.php',
                                            data 	    :  {keyword: keyword, batas: batas, ShortBy: ShortBy, OrderBy: OrderBy, page: page, posisi: posisi, keyword_by: keyword_by, tanggal: tanggal},
                                            success     : function(data){
                                                $('#MenampilkanDataAntrian').html(data);
                                                $('#ModalTerdaftarAntrian').modal('toggle');
                                                $('#ModalDetailAntrian').modal('toggle');
                                                Swal.fire({
                                                    title: 'Good Job!',
                                                    text: 'Update Terdaftar Antrian Berhasil',
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
            
            //Hapus
            $('#ModalHapusAntrian').on('show.bs.modal', function (e) {
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#FormHapus').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Antrian/FormHapus.php',
                    data        :  {id_antrian: id_antrian},
                    success     : function(data){
                        $('#FormHapus').html(data);
                        //Konfirmasi Hapus
                        $('#KonfirmasiHapus').click(function(){
                            $('#NotifikasiHapusAntrian').html('Loading...');
                            $.ajax({
                                url     : "_Page/Antrian/ProsesHapusAntrian.php",
                                method  : "POST",
                                data    :  {id_antrian: id_antrian},
                                success : function (data) {
                                    $('#NotifikasiHapusAntrian').html(data);
                                    //Notifikasi Proses Hapus
                                    var NotifikasiHapusAntrianBerhasil=$('#NotifikasiHapusAntrianBerhasil').html();
                                    if(NotifikasiHapusAntrianBerhasil=="Hapus Antrian Berhasil"){
                                        $.ajax({
                                            type 	    : 'POST',
                                            url 	    : '_Page/Antrian/TabelAntrian.php',
                                            data 	    :  {keyword: keyword, batas: batas, ShortBy: ShortBy, OrderBy: OrderBy, page: page, posisi: posisi, keyword_by: keyword_by, tanggal: tanggal},
                                            success     : function(data){
                                                $('#MenampilkanDataAntrian').html(data);
                                                $('#ModalHapusAntrian').modal('toggle');
                                                $('#ModalDetailAntrian').modal('toggle');
                                                Swal.fire({
                                                    title: 'Good Job!',
                                                    text: 'Proses Hapus Antrian Berhasil',
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
            
            
            
            
            
        }
    });
});
//Modal Detail Kode Booking
$('#ModalDetailKodeBooking').on('show.bs.modal', function (e) {
    var KodeBooking = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormDetailKodeBooking').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormDetailKodeBooking.php',
        data 	    :  {KodeBooking: KodeBooking},
        success     : function(data){
            $('#FormDetailKodeBooking').html(data);
        }
    });
});
//Batal
$('#ModalBatalAntrian').on('show.bs.modal', function (e) {
    var KodeBooking = $(e.relatedTarget).data('id');
    $('#FormBatal').html('Loading');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormBatal.php',
        data        :  {KodeBooking: KodeBooking},
        success     : function(data){
            $('#FormBatal').html(data);
            //Konfirmasi Batal
            $('#ProsesBatalkanAntrian').submit(function(){
                var ProsesBatalkanAntrian = $('#ProsesBatalkanAntrian').serialize();
                $('#NotifikasiBatalAntrian').html('Loading...');
                $.ajax({
                    url     : "_Page/Antrian/ProsesBatalAntrian.php",
                    method  : "POST",
                    data    :  ProsesBatalkanAntrian,
                    success : function (data) {
                        $('#NotifikasiBatalAntrian').html(data);
                        //Notifikasi Proses Hapus
                        var NotifikasiBatalAntrianBerhasil=$('#NotifikasiBatalAntrianBerhasil').html();
                        if(NotifikasiBatalAntrianBerhasil=="Success"){
                            location.reload();
                        }
                    }
                })
            });
        }
    });
});
$('#ModalCheckinAntrian').on('show.bs.modal', function (e) {
    var KodeBooking = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormCheckin').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormCheckin.php',
        data        :  {KodeBooking: KodeBooking},
        success     : function(data){
            $('#FormCheckin').html(data);
            //Konfirmasi Checkin
            $('#KonfirmasiCheckin').click(function(){
                $('#NotifikasiCheckinAntrian').html('Loading...');
                $.ajax({
                    url     : "_Page/Antrian/ProsesCheckinAntrian.php",
                    method  : "POST",
                    data    :  {KodeBooking: KodeBooking},
                    success : function (data) {
                        $('#NotifikasiCheckinAntrian').html(data);
                        //Notifikasi Proses Hapus
                        var NotifikasiCheckinAntrianBerhasil=$('#NotifikasiCheckinAntrianBerhasil').html();
                        if(NotifikasiCheckinAntrianBerhasil=="Success"){
                            location.reload();
                        }
                    }
                })
            });
        }
    });
});
$('#ModalPangglAntrian').on('show.bs.modal', function (e) {
    var KodeBooking = $(e.relatedTarget).data('id');
    var GetNomorAntrian=$('#GetNomorAntrian').html();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormPanggilAntrian').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormPanggilAntrian.php',
        data 	    :  {KodeBooking: KodeBooking, GetNomorAntrian: GetNomorAntrian},
        success     : function(data){
            $('#FormPanggilAntrian').html(data);
            //Kondisi Ketika di panggil
            $("#Play").click(function(){
                document.getElementById('suarabel').pause();
                document.getElementById('suarabel').currentTime=0;
                document.getElementById('suarabel').play();
                //SET DELAY UNTUK MEMAINKAN REKAMAN NOMOR URUT		
                totalwaktu=document.getElementById('suarabel').duration*1000;	
                //MAINKAN SUARA NOMOR URUT		
                setTimeout(function() {
                        document.getElementById('suarabelnomorurut').pause();
                        document.getElementById('suarabelnomorurut').currentTime=0;
                        document.getElementById('suarabelnomorurut').play();
                }, totalwaktu);
                totalwaktu=totalwaktu+1500;
                //Mainkan Rekaman
                setTimeout(function() {
                        document.getElementById('SuaraNomor').pause();
                        document.getElementById('SuaraNomor').currentTime=0;
                        document.getElementById('SuaraNomor').play();
                    }, totalwaktu);
                
                totalwaktu=totalwaktu+1000;
            });
            //Update Panggil Pasien
            $('#UpdatePanggilAntrian').click(function(){
                $('#NotifikasiProsesUpdatePanggilAntrian').html('Loading...');
                $.ajax({
                    url     : "_Page/Antrian/ProsesUpdateAntrianPanggil.php",
                    method  : "POST",
                    data    :  {KodeBooking: KodeBooking},
                    success : function (data) {
                        $('#NotifikasiProsesUpdatePanggilAntrian').html(data);
                        //Notifikasi Proses Update
                        var NotifikasiProsesUpdatePanggilAntrianBerhasil=$('#NotifikasiProsesUpdatePanggilAntrianBerhasil').html();
                        if(NotifikasiProsesUpdatePanggilAntrianBerhasil=="Success"){
                            location.reload();
                        }
                    }
                })
            });
        }
    });
});
$('#ModalTungguPoli').on('show.bs.modal', function (e) {
    var KodeBooking = $(e.relatedTarget).data('id');
    $('#FormKonfirmasiWaktuTungguPoli').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormKonfirmasiWaktuTungguPoli.php',
        data        :  {KodeBooking: KodeBooking},
        success     : function(data){
            $('#FormKonfirmasiWaktuTungguPoli').html(data);
            $('#KonfirmasiWaktuTungguPoli').click(function(){
                $('#NotifikasiWaktuTungguPoli').html('Loading...');
                $.ajax({
                    url     : "_Page/Antrian/ProsesUpdateTungguPoli.php",
                    method  : "POST",
                    data    :  {KodeBooking: KodeBooking},
                    success : function (data) {
                        $('#NotifikasiWaktuTungguPoli').html(data);
                        var NotifikasiWaktuTungguPoliBerhasil=$('#NotifikasiWaktuTungguPoliBerhasil').html();
                        if(NotifikasiWaktuTungguPoliBerhasil=="Success"){
                            location.reload();
                        }
                    }
                })
            });
        }
    });
});
$('#ModalLayananPoli').on('show.bs.modal', function (e) {
    var KodeBooking = $(e.relatedTarget).data('id');
    var GetNomorAntrian=$('#GetNomorAntrian').html();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormKonfirmasiLayananPoli').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormKonfirmasiLayananPoli.php',
        data 	    :  {KodeBooking: KodeBooking, GetNomorAntrian: GetNomorAntrian},
        success     : function(data){
            $('#FormKonfirmasiLayananPoli').html(data);
            //Kondisi Ketika di panggil
            $("#PlayPoli").click(function(){
                document.getElementById('suarabel_poli').pause();
                document.getElementById('suarabel_poli').currentTime=0;
                document.getElementById('suarabel_poli').play();
                //SET DELAY UNTUK MEMAINKAN REKAMAN NOMOR URUT		
                totalwaktu=document.getElementById('suarabel_poli').duration*1000;	
                //MAINKAN SUARA NOMOR URUT		
                setTimeout(function() {
                        document.getElementById('suarabelnomorurut_poli').pause();
                        document.getElementById('suarabelnomorurut_poli').currentTime=0;
                        document.getElementById('suarabelnomorurut_poli').play();
                }, totalwaktu);
                totalwaktu=totalwaktu+1500;
                //Mainkan Rekaman
                setTimeout(function() {
                        document.getElementById('SuaraNomorPoli').pause();
                        document.getElementById('SuaraNomorPoli').currentTime=0;
                        document.getElementById('SuaraNomorPoli').play();
                    }, totalwaktu);
                
                totalwaktu=totalwaktu+1000;
            });
            //Update Panggil Pasien
            $('#UpdatePanggilAntrianPoli').click(function(){
                $('#NotifikasiProsesUpdatePanggilAntrianPoli').html('Loading...');
                $.ajax({
                    url     : "_Page/Antrian/ProsesUpdateLayananPoli.php",
                    method  : "POST",
                    data    :  {KodeBooking: KodeBooking},
                    success : function (data) {
                        $('#NotifikasiProsesUpdatePanggilAntrianPoli').html(data);
                        //Notifikasi Proses Update
                        var NotifikasiProsesUpdatePanggilAntrianPoliBerhasil=$('#NotifikasiProsesUpdatePanggilAntrianPoliBerhasil').html();
                        if(NotifikasiProsesUpdatePanggilAntrianPoliBerhasil=="Success"){
                            location.reload();
                        }
                    }
                })
            });
        }
    });
});
$('#ModalTungguFarmasi').on('show.bs.modal', function (e) {
    var KodeBooking = $(e.relatedTarget).data('id');
    var GetNomorAntrian=$('#GetNomorAntrian').html();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormTungguFarmasi').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormTungguFarmasi.php',
        data 	    :  {KodeBooking: KodeBooking, GetNomorAntrian: GetNomorAntrian},
        success     : function(data){
            $('#FormTungguFarmasi').html(data);
            $('#KonfirmasiTungguFarmasi').click(function(){
                $('#NotifikasiTungguFarmasi').html('Loading...');
                $.ajax({
                    url     : "_Page/Antrian/ProsesTungguFarmasi.php",
                    method  : "POST",
                    data    :  {KodeBooking: KodeBooking},
                    success : function (data) {
                        $('#NotifikasiTungguFarmasi').html(data);
                        var NotifikasiTungguFarmasiBerhasil=$('#NotifikasiTungguFarmasiBerhasil').html();
                        if(NotifikasiTungguFarmasiBerhasil=="Success"){
                            location.reload();
                        }
                    }
                })
            });
        }
    });
});
$('#ModalLayananFarmasi').on('show.bs.modal', function (e) {
    var KodeBooking = $(e.relatedTarget).data('id');
    var GetNomorAntrian=$('#GetNomorAntrian').html();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormLayananFarmasi').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormLayananFarmasi.php',
        data 	    :  {KodeBooking: KodeBooking, GetNomorAntrian: GetNomorAntrian},
        success     : function(data){
            $('#FormLayananFarmasi').html(data);
            $('#KonfirmasiLayananFarmasi').click(function(){
                $('#NotifikasiLayananFarmasi').html('Loading...');
                $.ajax({
                    url     : "_Page/Antrian/ProsesUpdateLayananFarmasi.php",
                    method  : "POST",
                    data    :  {KodeBooking: KodeBooking},
                    success : function (data) {
                        $('#NotifikasiLayananFarmasi').html(data);
                        var NotifikasiLayananFarmasiBerhasil=$('#NotifikasiLayananFarmasiBerhasil').html();
                        if(NotifikasiLayananFarmasiBerhasil=="Success"){
                            location.reload();
                        }
                    }
                })
            });
        }
    });
});
$('#ModalLayananSelesai').on('show.bs.modal', function (e) {
    var KodeBooking = $(e.relatedTarget).data('id');
    var GetNomorAntrian=$('#GetNomorAntrian').html();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormLayananSelesai').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormLayananSelesai.php',
        data 	    :  {KodeBooking: KodeBooking, GetNomorAntrian: GetNomorAntrian},
        success     : function(data){
            $('#FormLayananSelesai').html(data);
            $('#KonfirmasiLayananSelesai').click(function(){
                $('#NotifikasiLayananSelesai').html('Loading...');
                $.ajax({
                    url     : "_Page/Antrian/ProsesLayananSelesai.php",
                    method  : "POST",
                    data    :  {KodeBooking: KodeBooking},
                    success : function (data) {
                        $('#NotifikasiLayananSelesai').html(data);
                        var NotifikasiLayananSelesaiBerhasil=$('#NotifikasiLayananSelesaiBerhasil').html();
                        if(NotifikasiLayananSelesaiBerhasil=="Success"){
                            location.reload();
                        }
                    }
                })
            });
        }
    });
});
$('#ModalTambahKeKunjungan').on('show.bs.modal', function (e) {
    var id_antrian = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 mb-3 text-center">Loading..</div></div>';
    $('#FormPendaftaranKunjungan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormTambahKunjungan.php',
        data 	    :  {id_antrian: id_antrian},
        success     : function(data){
            $('#FormPendaftaranKunjungan').html(data);
        }
    });
});
$('#ModalDetailAntrian2').on('show.bs.modal', function (e) {
    var id_antrian = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 mb-3 text-center">Loading..</div></div>';
    $('#FormDetailAntrian2').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormDetailAntrian.php',
        data 	    :  {id_antrian: id_antrian},
        success     : function(data){
            $('#FormDetailAntrian2').html(data);
        }
    });
});
//Detail Referensi
$('#ModalDetailReferensi').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var jenisreferensi = pecah[0];
    var nomorreferensi = pecah[1];
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormDetailReferensi').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormDetailReferensi.php',
        data 	    :  {jenisreferensi: jenisreferensi, nomorreferensi: nomorreferensi},
        success     : function(data){
            $('#FormDetailReferensi').html(data);
        }
    });
});

//Modal Buat RM
$('#ModalBuatRm').on('show.bs.modal', function (e) {
    var id_antrian = $(e.relatedTarget).data('id');
    $('#FormBuatRm').html('<tr><td colspan="3"><div class="text-primary">Loading..</div></td></tr>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Antrian/FormBuatRm.php',
        data 	    :  {id_antrian: id_antrian},
        success     : function(data){
            $('#FormBuatRm').html(data);
        }
    });
});
//Proses Tambah Pasien Atau Buat Nomor RM
$('#ProsesBuatRm').submit(function (e) {
    e.preventDefault(); 
    // Mencegah form melakukan submit default
    var ProsesBuatRm = $('#ProsesBuatRm').serialize();
    $('#NotifikasiBuatRm').html('Loading...');
    $.ajax({
        url: "_Page/Antrian/ProsesBuatRm.php",
        method: "POST",
        data: ProsesBuatRm,
        success: function (data) {
            $('#NotifikasiBuatRm').html(data);
            var NotifikasiBuatRmBerhasil = $('#NotifikasiBuatRmBerhasil').html();
            if (NotifikasiBuatRmBerhasil == "Success") {
                //Tutup Modal
                $('#ModalBuatRm').modal('hide');
                //Tampilkan Swal
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data pasien berhasil ditambahkan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        //Reload Halaman
                        location.reload();
                    }
                });
            }
        }
    });
});