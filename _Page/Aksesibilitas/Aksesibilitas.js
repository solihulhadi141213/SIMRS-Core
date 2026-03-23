$('#SelecAksesGroup').change(function(){
    var AksesGroup=$('#SelecAksesGroup').val();
    $('#MenampilkanTabelAkses').html('Loading...');
    $.ajax({
        url     : "_Page/Aksesibilitas/TabelAksesibilitas.php",
        method  : "POST",
        data    :  {AksesGroup: AksesGroup},
        success : function (data) {
            $('#MenampilkanTabelAkses').html(data);
        }
    });
});
//Modal Update Setting
$('#ModalUpdateSetting').on('show.bs.modal', function (e) {
    var DataGet = $(e.relatedTarget).data('id');
    var pecah = DataGet.split(",");
    var keterangan = pecah[0];
    var status = pecah[1];
    var AksesGroup=$('#SelecAksesGroup').val();
    $('#FormUpdateSetting').load('_Page/Aksesibilitas/ModalLoader.php');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Aksesibilitas/UpdateSetting.php',
        data        :  {AksesGroup: AksesGroup, keterangan: keterangan, status: status},
        success     : function(data){
            $('#FormUpdateSetting').html(data);
            var Notifikasi=$('#NotifikasiBerhasil').html();
            if(Notifikasi=="Setting berhasil"){
                $.ajax({
                    url     : "_Page/Aksesibilitas/TabelAksesibilitas.php",
                    method  : "POST",
                    data    :  {AksesGroup: AksesGroup},
                    success : function (data) {
                        $('#MenampilkanTabelAkses').html(data);
                    }
                });
                $('#FormUpdateSetting').load('_Page/Aksesibilitas/NotifikasiUpdateBerhasil.php');
                $('#ModalUpdateSetting').modal('hide');
            }
        }
    });
});