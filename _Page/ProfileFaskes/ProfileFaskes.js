$('#SettingProfileFaskes').submit(function(){
    var SettingProfileFaskes = $('#SettingProfileFaskes').serialize();
    $('#ClickSimpanSettingProfile').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ProfileFaskes/ProsesSettingFaskes.php',
        data 	    :  SettingProfileFaskes,
        success     : function(data){
            $('#ClickSimpanSettingProfile').html(data);
            var Notifikasi=$('#Notifikasi').html();
            if(Notifikasi=="Berhasil"){
                $('#ClickSimpanSettingProfile').html('<i class="ti-save"></i> Simpan');
                //Menampilkan sweet aleret
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Setting Profile Faskes Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }else{
                $('#ClickSimpanSettingProfile').html('<i class="ti-save"></i> Simpan');
                //Menampilkan sweet aleret
                Swal.fire({
                    title: 'Ops!',
                    text: 'Setting Profile Faskes Gagal!!',
                    icon: 'error',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});