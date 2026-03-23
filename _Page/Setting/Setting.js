//SETTING PROFILE FASKES
//Proses Simpan Setting Profile Faskes
$('#ProsesSettingProfileFaskes').submit(function(){
    $('#NotifikasiSimpanSettingProfileFaskes').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesSettingProfileFaskes')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/ProsesSettingProfileFaskes.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiSimpanSettingProfileFaskes').html(data);
            var NotifikasiSimpanSettingProfileFaskesBerhasil=$('#NotifikasiSimpanSettingProfileFaskesBerhasil').html();
            if(NotifikasiSimpanSettingProfileFaskesBerhasil=="Success"){
                location.reload();
            }
        }
    });
});
//Modal Hapus Setting Profle Faskes
$('#ModalHapusSettingProfileFaskes').on('show.bs.modal', function (e) {
    var id = $(e.relatedTarget).data('id');
    $('#FormHapusSettingProfileFaskes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/FormHapusSettingProfileFaskes.php',
        data 	    :  {id: id},
        success     : function(data){
            $('#FormHapusSettingProfileFaskes').html(data);
            $('#KonfirmasiHapusSettingProfileFaskes').click(function(){
                $('#NotifikasiHapusSettingProfileFaskes').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Setting/ProsesHapusSettingProfileFaskes.php',
                    data 	    :  { id: id },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusSettingProfileFaskes').html(data);
                        var NotifikasiHapusSettingProfileFaskesBerhasil=$('#NotifikasiHapusSettingProfileFaskesBerhasil').html();
                        if(NotifikasiHapusSettingProfileFaskesBerhasil=="Success"){
                            window.location.href='index.php?Page=Setting&Sub=SettingProfile';
                        }
                    }
                });
            });
        }
    });
});
//BRIDGING
//Proses Simpan Setting Bridging
$('#ProsesSettingBridging').submit(function(){
    $('#NotifikasiSimpanSettingBridging').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesSettingBridging')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/ProsesSettingBridging.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiSimpanSettingBridging').html(data);
            var NotifikasiSimpanSettingBridgingBerhasil=$('#NotifikasiSimpanSettingBridgingBerhasil').html();
            if(NotifikasiSimpanSettingBridgingBerhasil=="Success"){
                location.reload();
            }
        }
    });
});
$('#tipe_koneksi').change(function(){
    var tipe_koneksi=$('#tipe_koneksi').val();
    var consid=$('#consid').val();
    var cons_id_antrol=$('#cons_id_antrol').val();
    var user_key=$('#user_key').val();
    var user_key_antrol=$('#user_key_antrol').val();
    var secret_key=$('#secret_key').val();
    var secret_key_antrol=$('#secret_key_antrol').val();
    var kode_ppk=$('#kode_ppk').val();
    var url_vclaim=$('#url_vclaim').val();
    var url_aplicare=$('#url_aplicare').val();
    var url_antrol=$('#url_antrol').val();
    var url_faskes=$('#url_faskes').val();
    var kategori_ppk=$('#kategori_ppk').val();
    $('#NotifikasiTestKoneksiBridging').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/ProsesTestKoneksiBridging.php',
        data 	    :  { 
            tipe_koneksi: tipe_koneksi, 
            consid: consid, 
            cons_id_antrol: cons_id_antrol, 
            user_key: user_key, 
            user_key_antrol: user_key_antrol, 
            secret_key: secret_key, 
            secret_key_antrol: secret_key_antrol, 
            kode_ppk: kode_ppk, 
            url_vclaim: url_vclaim, 
            url_aplicare: url_aplicare, 
            url_antrol: url_antrol, 
            url_faskes: url_faskes, 
            kategori_ppk: kategori_ppk 
        },
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTestKoneksiBridging').html(data);
        }
    });
});
//Modal Hapus Setting Bridging
$('#ModalHapusSettingBridging').on('show.bs.modal', function (e) {
    var id_bridging = $(e.relatedTarget).data('id');
    $('#FormHapusSettingBridging').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/FormHapusSettingBridging.php',
        data 	    :  {id_bridging: id_bridging},
        success     : function(data){
            $('#FormHapusSettingBridging').html(data);
            $('#KonfirmasiHapusSettingBridging').click(function(){
                $('#NotifikasiHapusSettingBridging').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Setting/ProsesHapusSettingBridging.php',
                    data 	    :  { id_bridging: id_bridging },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusSettingBridging').html(data);
                        var NotifikasiHapusSettingBridgingBerhasil=$('#NotifikasiHapusSettingBridgingBerhasil').html();
                        if(NotifikasiHapusSettingBridgingBerhasil=="Success"){
                            window.location.href='index.php?Page=Setting&Sub=SettingBridging';
                        }
                    }
                });
            });
        }
    });
});
//EMAIL GATEWAY
//Proses Tambah Galeri
$('#ProsesSettingEmail').submit(function(){
    $('#NotifikasiSimpanSettingEmail').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesSettingEmail')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/ProsesSettingEmail.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiSimpanSettingEmail').html(data);
            var NotifikasiSimpanSettingEmailBerhasil=$('#NotifikasiSimpanSettingEmailBerhasil').html();
            if(NotifikasiSimpanSettingEmailBerhasil=="Success"){
                location.reload();
            }
        }
    });
});
//Modal Hapus Setting Email Gateway
$('#ModalHapusSettingEmailGateway').on('show.bs.modal', function (e) {
    var id_setting_email_gateway = $(e.relatedTarget).data('id');
    $('#FormHapusSettingEmailGateway').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/FormHapusSettingEmailGateway.php',
        data 	    :  {id_setting_email_gateway: id_setting_email_gateway},
        success     : function(data){
            $('#FormHapusSettingEmailGateway').html(data);
            $('#KonfirmasiHapusSettingEmailGateway').click(function(){
                $('#NotifikasiHapusSettingEmailGateway').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Setting/ProsesHapusSettingEmailGateway.php',
                    data 	    :  { id_setting_email_gateway: id_setting_email_gateway },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusSettingEmailGateway').html(data);
                        var NotifikasiHapusSettingEmailGatewayBerhasil=$('#NotifikasiHapusSettingEmailGatewayBerhasil').html();
                        if(NotifikasiHapusSettingEmailGatewayBerhasil=="Success"){
                            window.location.href='index.php?Page=Setting&Sub=Email';
                        }
                    }
                });
            });
        }
    });
});
//Proses Kirim Email
$('#ProsesKirimEmail').submit(function(){
    $('#NotifikasiKirimEmail').html('<span class="text-primary">Loading...</span>');
    var EmailGateway=$('#EmailGateway').val();
    var PasswordGateway=$('#PasswordGateway').val();
    var UrlProvider=$('#UrlProvider').val();
    var PortGateway=$('#PortGateway').val();
    var NamaPengirim=$('#NamaPengirim').val();
    var UrlService=$('#UrlService').val();
    var email_tujuan=$('#email_tujuan').val();
    var nama_tujuan=$('#nama_tujuan').val();
    var subjek=$('#subjek').val();
    var pesan=$('#pesan').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/ProsesKirimEmail.php',
        data 	    :  {
            EmailGateway: EmailGateway, 
            PasswordGateway: PasswordGateway, 
            UrlProvider: UrlProvider, 
            PortGateway: PortGateway, 
            NamaPengirim: NamaPengirim, 
            UrlService: UrlService, 
            email_tujuan: email_tujuan, 
            nama_tujuan: nama_tujuan, 
            subjek: subjek, 
            pesan: pesan
        },
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiKirimEmail').html(data);
            var NotifikasiKirimEmailBerhasil=$('#NotifikasiKirimEmailBerhasil').html();
            if(NotifikasiKirimEmailBerhasil=="Success"){
                location.reload();
            }
        }
    });
});

//SETTING SATU SEHAT
//Proses Simpan Pengaturan Satu Sehat
$('#ProsesSettingSatuSehat').submit(function(){
    $('#NotifikasiSimpanSettingSatuSehat').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesSettingSatuSehat')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/ProsesSettingSatuSehat.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiSimpanSettingSatuSehat').html(data);
            var NotifikasiSimpanSettingSatuSehatBerhasil=$('#NotifikasiSimpanSettingSatuSehatBerhasil').html();
            if(NotifikasiSimpanSettingSatuSehatBerhasil=="Success"){
                location.reload();
            }
        }
    });
});
//Modal Hapus Setting Satu Sehat
$('#ModalHapusSettingSatuSehat').on('show.bs.modal', function (e) {
    var id_setting_satusehat = $(e.relatedTarget).data('id');
    $('#FormHapusSettingSatuSehat').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/FormHapusSettingSatuSehat.php',
        data 	    :  {id_setting_satusehat: id_setting_satusehat},
        success     : function(data){
            $('#FormHapusSettingSatuSehat').html(data);
            $('#KonfirmasiHapusSettingSatuSehat').click(function(){
                $('#NotifikasiHapusSettingSatuSehat').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Setting/ProsesHapusSettingSatuSehat.php',
                    data 	    :  { id_setting_satusehat: id_setting_satusehat },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusSettingSatuSehat').html(data);
                        var NotifikasiHapusSettingSatuSehatBerhasil=$('#NotifikasiHapusSettingSatuSehatBerhasil').html();
                        if(NotifikasiHapusSettingSatuSehatBerhasil=="Success"){
                            window.location.href='index.php?Page=Setting&Sub=SatuSehat';
                        }
                    }
                });
            });
        }
    });
});
//Modal Uji Coba Setting Satu Sehat
$('#ModalUjiCobaSettingSatuSehat').on('show.bs.modal', function (e) {
    $('#FormUjiCobaKoneksiSatuSehat').html('Loading...');
    var form = $('#ProsesSettingSatuSehat')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/FormUjiCobaKoneksiSatuSehat.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#FormUjiCobaKoneksiSatuSehat').html(data);
        }
    });
});
//Modal Test Koneksi I-Care
$('#ModalTestIcare').on('show.bs.modal', function (e) {
    var consid=$('#consid').val();
    var cons_id_antrol=$('#cons_id_antrol').val();
    var user_key=$('#user_key').val();
    var user_key_antrol=$('#user_key_antrol').val();
    var secret_key=$('#secret_key').val();
    var secret_key_antrol=$('#secret_key_antrol').val();
    var kode_ppk=$('#kode_ppk').val();
    var url_vclaim=$('#url_vclaim').val();
    var url_aplicare=$('#url_aplicare').val();
    var url_antrol=$('#url_antrol').val();
    var url_faskes=$('#url_faskes').val();
    var url_icare=$('#url_icare').val();
    var kategori_ppk=$('#kategori_ppk').val();
    $('#FormTestIcare').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/FormTestIcare.php',
        data 	    :  { 
            consid: consid, 
            cons_id_antrol: cons_id_antrol, 
            user_key: user_key, 
            user_key_antrol: user_key_antrol, 
            secret_key: secret_key, 
            secret_key_antrol: secret_key_antrol, 
            kode_ppk: kode_ppk, 
            url_vclaim: url_vclaim, 
            url_aplicare: url_aplicare, 
            url_antrol: url_antrol, 
            url_faskes: url_faskes, 
            url_icare: url_icare, 
            kategori_ppk: kategori_ppk 
        },
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#FormTestIcare').html(data);
        }
    });
});
$('#ProsesTestIcare').submit(function(){
    var ProsesTestIcare = $('#ProsesTestIcare').serialize();
    $('#HasilProsesICare').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/ProsesDekrip.php',
        data 	    :  ProsesTestIcare,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#HasilProsesICare').html(data);
        }
    });
});
//SETTING SIRS ONLINE
//Proses Simpan Pengaturan Sirs Online
$('#ProsesSettingSirsOnline').submit(function(){
    $('#NotifikasiSimpanSettingSirsOnline').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesSettingSirsOnline')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/ProsesSettingSirsOnline.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiSimpanSettingSirsOnline').html(data);
            var NotifikasiSimpanSettingSirsOnlineBerhasil=$('#NotifikasiSimpanSettingSirsOnlineBerhasil').html();
            if(NotifikasiSimpanSettingSirsOnlineBerhasil=="Success"){
                location.reload();
            }
        }
    });
});
//Modal Hapus Setting SIRS Online
$('#ModalHapusSettingSirsOnline').on('show.bs.modal', function (e) {
    var id_setting_sirs_online = $(e.relatedTarget).data('id');
    $('#FormHapusSettingSSirsOnline').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/FormHapusSettingSSirsOnline.php',
        data 	    :  {id_setting_sirs_online: id_setting_sirs_online},
        success     : function(data){
            $('#FormHapusSettingSSirsOnline').html(data);
            $('#KonfirmasiHapusSettingSirsOnline').click(function(){
                $('#NotifikasiHapusSettingSirsOnline').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Setting/ProsesHapusSettingSirsOnline.php',
                    data 	    :  { id_setting_sirs_online: id_setting_sirs_online },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusSettingSirsOnline').html(data);
                        var NotifikasiHapusSettingSirsOnlineBerhasil=$('#NotifikasiHapusSettingSirsOnlineBerhasil').html();
                        if(NotifikasiHapusSettingSirsOnlineBerhasil=="Success"){
                            window.location.href='index.php?Page=Setting&Sub=SirsOnline';
                        }
                    }
                });
            });
        }
    });
});
//Modal Test Koneksi Sirs Online
$('#ModalTestKoneksiSirsOnline').on('show.bs.modal', function (e) {
    var url_sirs_online=$('#url_sirs_online').val();
    var id_rs=$('#id_rs').val();
    var password_sirs_online=$('#password_sirs_online').val();
    //Get Timestamp
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/ProsesGetTimestamp.php',
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#x_timestamp').val(data);
        }
    });
    //Tempel di form
    $('#x_id_rs').val(id_rs);
    $('#x_pass').val(password_sirs_online);
    $('#base_url').val(url_sirs_online);
});
//Reload Timestamp
$('#ReloadTimestamp').click(function(){
    $('#x_timestamp').val('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/ProsesGetTimestamp.php',
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#x_timestamp').val(data);
        }
    });
});
//Proses Kirim Test SIRS Online
$('#ProsesKirimTestSirsOnline').submit(function(){
    $('#response').val('Loading...');
    var form = $('#ProsesKirimTestSirsOnline')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/ProsesKirimTestSirsOnline.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#response').val(data);
        }
    });
});
//SISRUTE
//Proses Simpan Pengaturan sisrute
$('#ProsesSettingSisrute').submit(function(){
    $('#NotifikasiSimpanSettingSisrute').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesSettingSisrute')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/ProsesSettingSisrute.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiSimpanSettingSisrute').html(data);
            var NotifikasiSimpanSettingSisruteBerhasil=$('#NotifikasiSimpanSettingSisruteBerhasil').html();
            if(NotifikasiSimpanSettingSisruteBerhasil=="Success"){
                location.reload();
            }
        }
    });
});
//Modal Hapus Setting Sisrute
$('#ModalHapusSettingSisrute').on('show.bs.modal', function (e) {
    var id_setting_sisrute = $(e.relatedTarget).data('id');
    $('#FormHapusSettingSisrute').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/FormHapusSettingSisrute.php',
        data 	    :  {id_setting_sisrute: id_setting_sisrute},
        success     : function(data){
            $('#FormHapusSettingSisrute').html(data);
            $('#KonfirmasiHapusSettingSisrute').click(function(){
                $('#NotifikasiHapusSettingSisrute').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Setting/ProsesHapusSettingSisrute.php',
                    data 	    :  { id_setting_sisrute: id_setting_sisrute },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusSettingSisrute').html(data);
                        var NotifikasiHapusSettingSisruteBerhasil=$('#NotifikasiHapusSettingSisruteBerhasil').html();
                        if(NotifikasiHapusSettingSisruteBerhasil=="Success"){
                            window.location.href='index.php?Page=Setting&Sub=Sisrute';
                        }
                    }
                });
            });
        }
    });
});
//Modal Test Koneksi SISRUTE
$('#ModalTestKoneksiSisrute').on('show.bs.modal', function (e) {
    var url_sisrute=$('#url_sisrute').val();
    var id_rs=$('#id_rs').val();
    var password_sisrute=$('#password_sisrute').val();
    //Get Timestamp
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/ProsesGetTimestamp.php',
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#x_timestamp_sisrute').val(data);
        }
    });
    //Tempel di form
    $('#x_id_rs_sisrute').val(id_rs);
    $('#x_pass_sisrute').val(password_sisrute);
    $('#base_url_sisrute').val(url_sisrute);
});
//Reload Timestamp
$('#ReloadTimestampSisrute').click(function(){
    $('#x_timestamp_sisrute').val('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/ProsesGetTimestamp.php',
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#x_timestamp_sisrute').val(data);
        }
    });
});
//Reload x_signature
$('#GenerateSignatureSisrute').click(function(){
    $('#x_signature').val('Loading..');
    var form = $('#ProsesKirimTestSisrute')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/ProsesGenerateSignature.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            var trimmedString = $.trim(data);
            $('#x_signature').val(trimmedString);
        }
    });
});
//Proses Kirim Test SIRS Online
$('#ProsesKirimTestSisrute').submit(function(){
    $('#response_sisrute').val('Loading...');
    var form = $('#ProsesKirimTestSisrute')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Setting/ProsesKirimTestSisrute.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#response_sisrute').val(data);
        }
    });
});