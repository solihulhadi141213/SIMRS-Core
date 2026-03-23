//Fungsi Menampilkan Data API Key
function ShowTableApiKey() {
    var ProsesFilterApiKey = $('#ProsesFilterApiKey').serialize();
    $.ajax({
        type    : 'POST',
        url     : '_Page/Api/TabelApiKey.php',
        data    : ProsesFilterApiKey,
        success: function(data) {
            $('#MenampilkanTabelApiKey').html(data);
        }
    });
}
//Fungsi Melakukan Generate
function GenerateClinetId() {
    $.ajax({
        url     : '_Page/Api/GenerateRandomeString.php',
        type    : 'POST',
        dataType: 'json',
        success: function(response) {
            // Dapatkan data dari respons
            const RandomeString = response.string;
            // Periksa status respons
            $('.client_id').val(RandomeString);
        },
        error: function(error) {
            console.error("Error fetching data", error);
        }
    });
}
function GenerateClientKey() {
    $.ajax({
        url     : '_Page/Api/GenerateRandomeString.php',
        type    : 'POST',
        dataType: 'json',
        success: function(response) {
            // Dapatkan data dari respons
            const RandomeString = response.string;
            // Periksa status respons
            $('.client_key').val(RandomeString);
        },
        error: function(error) {
            console.error("Error fetching data", error);
        }
    });
}
//Menampilkan Data Pertama Kali
$(document).ready(function() {
    ShowTableApiKey();
    //Apabila Generate Clinet ID
    $('#GenerateClientId').click(function(){
        GenerateClinetId();
    });
    $('#GenerateClientKey').click(function(){
        GenerateClientKey();
    });
    // Ketika Form Tambah API Key
    $('#ProsesTambahApiKey').submit(function(){
        var ProsesTambahApiKey = $('#ProsesTambahApiKey').serialize();
        $('#TombolSimpanApiKey').html('Loading...').prop('disabled', true);
        $.ajax({
            url         : '_Page/Api/ProsesTambahApiKey.php',
            type        : 'POST',
            data        : ProsesTambahApiKey,
            dataType    : 'json',
            success: function(response) {
                // Dapatkan data dari respons
                const message = response.message || 'Simpan Data API Key Berhasil';
                const status = response.status;
                // Periksa status respons
                if (status === 200) {
                    $('#ModalTambahApiKey').modal('hide');
                    $('#ProsesTambahApiKey')[0].reset();
                    ShowTableApiKey();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Simpan Data API Key Berhasil',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#TombolSimpanApiKey').html('<i class="ti ti-save"></i> Simpan').prop('disabled', false); // Kembalikan tombol ke kondisi semula
                    });
                } else {
                    $('#NotifikasiTambahApiKey').html('<small class="text-danger">'+message+'</small>');
                    $('#TombolSimpanApiKey').html('<i class="ti ti-save"></i> Simpan').prop('disabled', false); // Kembalikan tombol ke kondisi semula
                }
            },
            error: function(error) {
                console.error("Error fetching data", error);
                // Tampilkan pesan error
                $('#NotifikasiTambahApiKey').html('<small class="text-danger">Terjadi kesalahan saat menyimpan data</small>');
                $('#TombolSimpanApiKey').html('<i class="ti ti-save"></i> Simpan').prop('disabled', false); // Kembalikan tombol ke kondisi semula
            }
        });
    });
    //Ketika Modal Edit Muncul
    $('#ModalEditApiKeyService').on('show.bs.modal', function (e) {
        var id_api_access = $(e.relatedTarget).data('id');
        $('#FormEditApiKeyService').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Api/FormEditApiKeyService.php',
            data 	    :  {id_api_access: id_api_access},
            success     : function(data){
                $('#FormEditApiKeyService').html(data);
                //Apabila Generate Clinet ID
                $('#GenerateClientIdEdit').click(function(){
                    GenerateClinetId();
                });
                $('#GenerateClientKeyEdit').click(function(){
                    GenerateClientKey();
                });
            }
        });
    });
    //Ketika Proses Edit Dimulai
    $('#ProsesEditApiKey').submit(function(){
        var ProsesEditApiKey = $('#ProsesEditApiKey').serialize();
        $('#TombolEditApiKey').html('Loading...').prop('disabled', true);
        $.ajax({
            url         : '_Page/Api/ProsesEditApiKey.php',
            type        : 'POST',
            data        : ProsesEditApiKey,
            dataType    : 'json',
            success: function(response) {
                // Dapatkan data dari respons
                const message = response.message || 'Simpan Data API Key Berhasil';
                const status = response.status;
                // Periksa status respons
                if (status === 200) {
                    $('#ModalEditApiKeyService').modal('hide');
                    $('#ProsesEditApiKey')[0].reset();
                    ShowTableApiKey();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Simpan Data API Key Berhasil',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#TombolEditApiKey').html('<i class="ti ti-save"></i> Simpan').prop('disabled', false); // Kembalikan tombol ke kondisi semula
                    });
                } else {
                    $('#NotifikasiEditApiKey').html('<small class="text-danger">'+message+'</small>');
                    $('#TombolEditApiKey').html('<i class="ti ti-save"></i> Simpan').prop('disabled', false); // Kembalikan tombol ke kondisi semula
                }
            },
            error: function(error) {
                console.error("Error fetching data", error);
                // Tampilkan pesan error
                $('#NotifikasiEditApiKey').html('<small class="text-danger">Terjadi kesalahan saat menyimpan data</small>');
                $('#TombolEditApiKey').html('<i class="ti ti-save"></i> Simpan').prop('disabled', false); // Kembalikan tombol ke kondisi semula
            }
        });
    });
    //Ketika Modal Hapus Muncul
    $('#ModalHapusApiKey').on('show.bs.modal', function (e) {
        var id_api_access = $(e.relatedTarget).data('id');
        $('#FormHapusApiKey').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Api/FormHapusApiKey.php',
            data 	    :  {id_api_access: id_api_access},
            success     : function(data){
                $('#FormHapusApiKey').html(data);
                $('#NotifikasiHapusApiKey').html('');
            }
        });
    });
    //Ketika Proses Hapus API key
    $('#ProsesHapusApiKey').submit(function(){
        var ProsesHapusApiKey = $('#ProsesHapusApiKey').serialize();
        $('#TombolHapusApiKey').html('Loading...').prop('disabled', true);
        $.ajax({
            url         : '_Page/Api/ProsesHapusApiKey.php',
            type        : 'POST',
            data        : ProsesHapusApiKey,
            dataType    : 'json',
            success: function(response) {
                // Dapatkan data dari respons
                const message = response.message || 'Hapus Data API Key Berhasil';
                const status = response.status;
                // Periksa status respons
                if (status === 200) {
                    $('#ModalHapusApiKey').modal('hide');
                    $('#ProsesEditApiKey')[0].reset();
                    ShowTableApiKey();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Hapus Data API Key Berhasil',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#TombolHapusApiKey').html('<i class="ti ti-check"></i> Ya, Hapus').prop('disabled', false);
                    });
                } else {
                    $('#NotifikasiHapusApiKey').html('<small class="text-danger">'+message+'</small>');
                    $('#TombolHapusApiKey').html('<i class="ti ti-check"></i> Ya, Hapus').prop('disabled', false);
                }
            },
            error: function(error) {
                console.error("Error fetching data", error);
                // Tampilkan pesan error
                $('#NotifikasiHapusApiKey').html('<small class="text-danger">Terjadi kesalahan saat menghapus data</small>');
                $('#TombolHapusApiKey').html('<i class="ti ti-check"></i> Ya, Hapus').prop('disabled', false);
            }
        });
    });
});

