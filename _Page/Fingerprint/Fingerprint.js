$('#DataFingerprint').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Fingerprint/DataFingerprint.php',
    success     : function(data){
        $('#DataFingerprint').html(data);
    }
});

$('#ModalCariFingerPrint').on('show.bs.modal', function (e) {
    $('#FormCariFingerprint').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Fingerprint/FormCariFingerprint.php',
        success     : function(data){
            $('#FormCariFingerprint').html(data);
            //Proses Hapus SEP Internal
            $('#ProsesPencarianFingerprint').submit(function(){
                var ProsesPencarianFingerprint = $('#ProsesPencarianFingerprint').serialize();
                $('#NotifikasiHasilPencarian').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Fingerprint/ProsesPencarianFingerprint.php',
                    data 	    :  ProsesPencarianFingerprint,
                    success     : function(data){
                        $('#NotifikasiHasilPencarian').html(data);
                    }
                });
            });
        }
    });
});