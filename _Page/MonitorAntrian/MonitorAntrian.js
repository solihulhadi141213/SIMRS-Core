setInterval(function() { 
    $('#TimeDate').load('_Page/MonitorAntrian/TimeSetting.php');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/MonitorAntrian/DataAntrianPanggil.php',
        success     : function(data){
            $('#TampilkanDataAtrianDisini').html(data);
            var PanggilNoAntrian=$('#PanggilNoAntrian').html();
            var PanggiKodePoli=$('#PanggiKodePoli').html();
            var PanggilNamaPoli=$('#PanggilNamaPoli').html();
            var PanggilNamaDokter=$('#PanggilNamaDokter').html();
            var PanggilKodeBooking=$('#PanggilKodeBooking').html();
            //Masukan ke dalam k0lom
            $('#TampilkanNomorAntrian').html(PanggilNoAntrian);
            $('#TampilkanKodePoli').html(PanggilNamaPoli);
            $('#TampilanNamaDokter').html(PanggilNamaDokter);
            $('#TampilkanKodebooking').html(PanggilKodeBooking);
        }
    });
}, 100);