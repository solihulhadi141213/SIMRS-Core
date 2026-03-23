<?php
    //Koneksi
    include "../../_Config/Connection.php";
    //Menangkap kelas
    if(empty($_POST['PilihKelas'])){
        $PilihKelas="";
    }else{
        $PilihKelas=$_POST['PilihKelas'];
    }
?>
<script>
    $('#MenampilkanDataRuangan').load("_Page/KelasRuangan/DataRuangan.php");
    $('#PilihKelas').change(function(){
        var PilihKelas = $('#PilihKelas').val();
        $('#MenampilkanDataRuangan').html("Loading..");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/KelasRuangan/DataRuangan.php',
            data 	    :  {PilihKelas: PilihKelas},
            success     : function(data){
                $('#MenampilkanDataRuangan').html(data);
            }
        });
    });
</script>
<div class="row">
    <div class="col-xl-12 col-md-12">
        <div class="card table-card">
            <div class="card-header">
                <form action="javascript:void(0);" id="PencarianRuangan">
                    <div class="row">
                        <div class="col-md-4">
                            <select name="kelas" id="PilihKelas" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    //melakukan array kelas secara distinct dari database
                                    $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='kelas' ORDER BY kelas ASC");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_ruang_rawat = $data['id_ruang_rawat'];
                                        $kelas = $data['kelas'];
                                        $kodekelas = $data['kodekelas'];
                                        $updatetime = $data['updatetime'];
                                        if($PilihKelas==$kelas){
                                            echo '<option selected value="'.$kelas.'">'.$kelas.'</option>';
                                        }else{
                                            echo '<option value="'.$kelas.'">'.$kelas.'</option>';
                                        }
                                        
                                    }
                                ?>
                            </select>
                            <small>Pilih Kelas</small>
                        </div>
                        <div class="col-md-8 text-right">
                            <button type="button" class="btn btn-md btn-inverse" data-toggle="modal" data-target="#ModalTambahRuangan">
                                <i class="ti-plus"></i> Tambah Ruangan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row" id="MenampilkanDataRuangan">

</div>

