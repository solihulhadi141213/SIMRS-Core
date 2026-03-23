<script>
    $("#kategori_id").change(function(e){
        $("#LabelPencarian").html('Loading...');
        var kategori_id=$("#kategori_id").val();
        if(kategori_id=="" || kategori_id==null){
            $("#LabelPencarian").html('<dt>Keyword Pencarian</dt>');
            $("#keyword").prop("disabled", true);
        }
        if(kategori_id=="id_pasien"){
            $("#LabelPencarian").html('<dt>Masukan No.RM</dt>');
            $("#keyword").prop("disabled", false);
        }
        if(kategori_id=="nik"){
            $("#LabelPencarian").html('<dt>Masukan No.KTP (NIK)</dt>');
            $("#keyword").prop("disabled", false);
        }
        if(kategori_id=="no_bpjs"){
            $("#LabelPencarian").html('<dt>Masukan No.Kartu BPJS</dt>');
            $("#keyword").prop("disabled", false);
        }
    });
    //Pencarian pasien lama umum
    $("#ProsesPencarianPasienLama").submit(function(e){
        $("#NotifikasiPencarianDataPasien").html('Loading...');
        var metode_pembayaran=$("#metode_pembayaran").val();
        var kategori_pendaftaran=$("#kategori_pendaftaran").val();
        var kategori_id=$("#kategori_id").val();
        var keyword = $("#keyword").val();
        $.ajax({
            url: "_Page/Pendaftaran/ProsesPencarianDataPasien.php",
            type: "POST",
            data: {metode_pembayaran: metode_pembayaran, kategori_pendaftaran: kategori_pendaftaran, kategori_id: kategori_id, keyword: keyword},
            success: function (data) {
                $("#NotifikasiPencarianDataPasien").html(data);
            },
        });
    });
    //Submit pendaftaran
    $("#ProsesPendaftaranPasienLama").submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $("#NotifikasiPendaftaranPasienLama").html("Loading....");
        $.ajax({
            url: "_Page/Pendaftaran/ProsesPendaftaranPasienLama.php",
            type: "POST",
            data: formData,
            success: function (data) {
                $("#NotifikasiPendaftaranPasienLama").html(data);
                //Menangkap variabel notifikasi
                var NotifikasiPendaftaranPasienLamaBerhasil = $("#NotifikasiPendaftaranPasienLamaBerhasil").html();
                var kodebooking = $("#kodebooking").html();
                if(NotifikasiPendaftaranPasienLamaBerhasil=="Pendaftaran Berhasil"){
                    $.ajax({
                        url: "_Page/Pendaftaran/DetailPendaftaran.php",
                        type: "POST",
                        data: {kodebooking: kodebooking},
                        success: function (data) {
                            $("#ProsesPendaftaranPasienLama").html(data);
                        },
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
    //Submit pendaftaran pasien baru
    $("#ProsesPendaftaranPasienBaru").submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $("#NotifikasiPendaftaranPasienBaru").html("Loading....");
        $.ajax({
            url: "_Page/Pendaftaran/ProsesPendaftaranPasienBaru.php",
            type: "POST",
            data: formData,
            success: function (data) {
                $("#NotifikasiPendaftaranPasienBaru").html(data);
                //Menangkap variabel notifikasi
                var NotifikasiPendaftaranPasienBaruBerhasil = $("#NotifikasiPendaftaranPasienBaruBerhasil").html();
                var kodebooking = $("#kodebooking").html();
                if(NotifikasiPendaftaranPasienBaruBerhasil=="Pendaftaran Berhasil"){
                    $.ajax({
                        url: "_Page/Pendaftaran/DetailPendaftaran.php",
                        type: "POST",
                        data: {kodebooking: kodebooking},
                        success: function (data) {
                            $("#ProsesPendaftaranPasienBaru").html(data);
                        },
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
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
        var tanggal=$("#tanggal").val();
        $("#jam").html('<option>Loading..</option>');
        $.ajax({
            url: "_Page/Pendaftaran/PilihJadwal.php",
            type: "POST",
            data: {poliklinik: poliklinik, dokter: dokter, tanggal: tanggal},
            success: function (data) {
                $("#jam").html(data);
            },
        });
    });
    //Submit pendaftaran
    $("#ProsesPencarian").submit(function(e){
        $("#HasilPencarianData").html('Loading...');
        var search_by=$("#search_by").val();
        var keyword = $("#keyword").val();
        $.ajax({
            url: "_Page/Pendaftaran/ProsesPencarian.php",
            type: "POST",
            data: {search_by: search_by, keyword: keyword},
            success: function (data) {
                $("#HasilPencarianData").html(data);
            },
        });
    });
</script>