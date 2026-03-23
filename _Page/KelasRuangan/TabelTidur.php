<?php
    include "../../_Config/Connection.php";
    //Menangkap kelas dan ruangan
    if(!empty($_POST['ruangan'])){
        $Getruangan=$_POST['ruangan'];
    }else{
        $Getruangan="";
    }
    if(!empty($_POST['kelas'])){
        $Getkelas=$_POST['kelas'];
    }else{
        $Getkelas="";
    }
?>
<script>
    $('#MenampilkanDataBed').load("_Page/KelasRuangan/DataBed.php");
    $('#PilihKelas').change(function(){
        var PilihKelas = $('#PilihKelas').val();
        $('#PilihRuangan').html("Loading..");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/KelasRuangan/PilihRuangan.php',
            data 	    :  {PilihKelas: PilihKelas},
            success     : function(data){
                $('#PilihRuangan').html(data);
            }
        });
    });
    $('#PilihRuangan').change(function(){
        var PilihKelas = $('#PilihKelas').val();
        var PilihRuangan = $('#PilihRuangan').val();
        $('#MenampilkanDataBed').html("Loading..");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/KelasRuangan/DataBed.php',
            data 	    :  {PilihRuangan: PilihRuangan, PilihKelas: PilihKelas},
            success     : function(data){
                $('#MenampilkanDataBed').html(data);
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
                                    //Koneksi
                                    
                                    //melakukan array kelas secara distinct dari database
                                    $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='kelas' ORDER BY kelas ASC");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $id_ruang_rawat = $data['id_ruang_rawat'];
                                        $kelas = $data['kelas'];
                                        $kodekelas = $data['kodekelas'];
                                        $updatetime = $data['updatetime'];
                                        if($Getkelas==$kelas){
                                            echo '<option selected value="'.$kelas.'">'.$kelas.'</option>';
                                        }else{
                                            echo '<option value="'.$kelas.'">'.$kelas.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                            <small>Pilih Kelas</small>
                        </div>
                        <div class="col-md-4">
                            <select name="ruangan" id="PilihRuangan" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    if(!empty($Getkelas)){
                                        $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='ruangan' AND kelas='$Getkelas' ORDER BY kelas ASC");
                                        while ($data = mysqli_fetch_array($query)) {
                                            $id_ruang_rawat = $data['id_ruang_rawat'];
                                            $kelas = $data['kelas'];
                                            $ruangan = $data['ruangan'];
                                            $updatetime = $data['updatetime'];
                                            if($Getruangan==$ruangan){
                                                echo '<option selected value="'.$ruangan.'">'.$ruangan.'</option>';
                                            }else{
                                                echo '<option value="'.$ruangan.'">'.$ruangan.'</option>';
                                            }
                                            
                                        }
                                    }
                                ?>
                            </select>
                            <small>Pilih Ruangan</small>
                        </div>
                        <div class="col-md-4 text-right">
                            <button type="button" class="btn btn-md btn-inverse" data-toggle="modal" data-target="#ModalTambahBed">
                                <i class="ti-plus"></i> Tambah Bed
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row" id="MenampilkanDataBed">

</div>

