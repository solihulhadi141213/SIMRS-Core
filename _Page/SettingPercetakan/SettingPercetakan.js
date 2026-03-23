$('#tampilkan_logo').change(function(){
    var tampilkan_logo = $('#tampilkan_logo').val();
    if(tampilkan_logo == 'Ya'){
        //Delete disabled
        $('#panjang_logo').removeAttr('disabled');
        $('#lebar_logo').removeAttr('disabled');
    }else{
        //disabled form
        $('#panjang_logo').attr('disabled',true);
        $('#lebar_logo').attr('disabled',true);
    }
});
$('#tampilkan_foto').change(function(){
    var tampilkan_foto = $('#tampilkan_foto').val();
    if(tampilkan_foto == 'Ya'){
        //Delete disabled
        $('#panjang_foto').removeAttr('disabled');
        $('#lebar_foto').removeAttr('disabled');
    }else{
        //disabled form
        $('#panjang_foto').attr('disabled',true);
        $('#lebar_foto').attr('disabled',true);
    }
});
$('#tampilkan_barcode').change(function(){
    var tampilkan_barcode = $('#tampilkan_barcode').val();
    if(tampilkan_barcode == 'Ya'){
        $('#ukuran_barcode').removeAttr('disabled');
    }else{
        $('#ukuran_barcode').attr('disabled',true);
    }
});
$('#kutipan_bawah').change(function(){
    var kutipan_bawah = $('#kutipan_bawah').val();
    if(kutipan_bawah == 'Ya'){
        $('#isi_kutipan').removeAttr('disabled');
    }else{
        $('#isi_kutipan').attr('disabled',true);
    }
});
//Submit
$('#ProsesSimpanSetingLabel').submit(function(e){
    e.preventDefault();
    var form_data2 = $(this).serialize();
    $('#NotifikasiSimpanSettingLabel').html('Loading...');
    $.ajax({
        url: "_Page/SettingPercetakan/ProsesSimpanSetingLabel.php",
        type: "POST",
        data: form_data2,
        success: function(data){
            $('#NotifikasiSimpanSettingLabel').html(data);
            var NotifikasiSimpanSettingLabelBerhasil= $('#NotifikasiSimpanSettingLabelBerhasil').html();
            if(NotifikasiSimpanSettingLabelBerhasil=="Berhasil"){
                //redirect page
                window.location.href = "index.php?Page=SettingPercetakan&Subpage=LabelObat";
            }
        }
    });
}
);