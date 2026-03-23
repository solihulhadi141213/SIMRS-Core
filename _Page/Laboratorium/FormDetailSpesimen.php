<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_radiologi_file
    if(empty($_POST['id_laboratorium_sample'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center mb-3">';
        echo '         ID Spesimen Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_laboratorium_sample=$_POST['id_laboratorium_sample'];
        $id_lab=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'id_lab');
        $sumber=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'sumber');
        $waktu_pengambilan=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'waktu_pengambilan');
        $lokasi_pengambilan=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'lokasi_pengambilan');
        $jumlah_sample=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'jumlah_sample');
        $volume_sample=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'volume_sample');
        $metode=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'metode');
        $kondisi=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'kondisi');
        $waktu_fiksasi=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'waktu_fiksasi');
        $cairan_fiksasi=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'cairan_fiksasi');
        $volume_fiksasi=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'volume_fiksasi');
        $petugas_sample=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'petugas_sample');
        $petugas_pengantar=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'petugas_pengantar');
        $petugas_penerima=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'petugas_penerima');
        $status=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'status');
?>
        <div class="row mb-3">
            <div class="col-6"><dt>No.LAB/ID.Spesimen</dt></div>
            <div class="col-6 text-right"><?php echo "$id_lab/$id_laboratorium_sample";?></div>
        </div>
        <?php if(!empty($waktu_pengambilan)){ ?>
            <div class="row mb-3">
                <div class="col-6"><dt>Tanggal Pengambilan</dt></div>
                <div class="col-6 text-right"><?php echo "$waktu_pengambilan";?></div>
            </div>
        <?php }if(!empty($sumber)){ ?>
            <div class="row mb-3">
                <div class="col-6"><dt>Sumber Spesimen</dt></div>
                <div class="col-6 text-right"><?php echo "$sumber";?></div>
            </div>
        <?php }if(!empty($lokasi_pengambilan)){ ?>
            <div class="row mb-3">
                <div class="col-6"><dt>Lokasi Spesimen</dt></div>
                <div class="col-6 text-right"><?php echo "$lokasi_pengambilan";?></div>
            </div>
        <?php }if(!empty($jumlah_sample)){ ?>
            <div class="row mb-3">
                <div class="col-6"><dt>Jumlah Spesimen</dt></div>
                <div class="col-6 text-right"><?php echo "$jumlah_sample";?></div>
            </div>
        <?php }if(!empty($volume_sample)){ ?>
            <div class="row mb-3">
                <div class="col-6"><dt>Volume Spesimen</dt></div>
                <div class="col-6 text-right"><?php echo "$volume_sample";?></div>
            </div>
        <?php }if(!empty($metode)){ ?>
            <div class="row mb-3">
                <div class="col-6"><dt>Metode Pengambilan</dt></div>
                <div class="col-6 text-right"><?php echo "$metode";?></div>
            </div>
        <?php }if(!empty($kondisi)){ ?>
            <div class="row mb-3">
                <div class="col-6"><dt>Kondisi Spesimen</dt></div>
                <div class="col-6 text-right"><?php echo "$kondisi";?></div>
            </div>
        <?php }if(!empty($waktu_fiksasi)){ ?>
            <div class="row mb-3">
                <div class="col-6"><dt>Waktu Fiksasi</dt></div>
                <div class="col-6 text-right"><?php echo "$waktu_fiksasi";?></div>
            </div>
        <?php }if(!empty($cairan_fiksasi)){ ?>
            <div class="row mb-3">
                <div class="col-6"><dt>Cairan Fiksasi</dt></div>
                <div class="col-6 text-right"><?php echo "$cairan_fiksasi";?></div>
            </div>
        <?php }if(!empty($volume_fiksasi)){ ?>
            <div class="row mb-3">
                <div class="col-6"><dt>Volume Fiksasi</dt></div>
                <div class="col-6 text-right"><?php echo "$volume_fiksasi";?></div>
            </div>
        <?php }if(!empty($petugas_sample)){ ?>
            <div class="row mb-3">
                <div class="col-6"><dt>Petugas Spesimen</dt></div>
                <div class="col-6 text-right"><?php echo "$petugas_sample";?></div>
            </div>
        <?php }if(!empty($petugas_pengantar)){ ?>
            <div class="row mb-3">
                <div class="col-6"><dt>Petugas Pengantar</dt></div>
                <div class="col-6 text-right"><?php echo "$petugas_pengantar";?></div>
            </div>
        <?php }if(!empty($petugas_penerima)){ ?>
            <div class="row mb-3">
                <div class="col-6"><dt>Petugas Penerima</dt></div>
                <div class="col-6 text-right"><?php echo "$petugas_penerima";?></div>
            </div>
        <?php }if(!empty($status)){ ?>
            <div class="row mb-3">
                <div class="col-6"><dt>Status</dt></div>
                <div class="col-6 text-right"><?php echo "$status";?></div>
            </div>
        <?php } ?>
<?php } ?>