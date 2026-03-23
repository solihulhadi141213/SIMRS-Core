<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_tindakan'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Tindakan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_tindakan=$_POST['id_tindakan'];
        $id_pasien=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'id_pasien');
        $id_kunjungan=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'id_kunjungan');
        $id_akses=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'id_akses');
        $nama_pasien=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'nama_pasien');
        $nama_petugas=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'nama_petugas');
        $tanggal_entry=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'tanggal_entry');
        $tanggal_pelaksanaan=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'tanggal_pelaksanaan');
        $waktu_mulai=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'waktu_mulai');
        $waktu_selesai=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'waktu_selesai');
        $kode_tindakan=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'kode_tindakan');
        $nama_tindakan=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'nama_tindakan');
        $alat_medis=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'alat_medis');
        $bmhp=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'bmhp');
        $nakes=getDataDetail($Conn,"tindakan",'id_tindakan',$id_tindakan,'nakes');
        //Json Decode
        $JsonAlatMedis=json_decode($alat_medis, true);
        $JsonBmhp =json_decode($bmhp, true);
        $JsonNakes=json_decode($nakes, true);
        //Format Tanggal
        $strtotime1=strtotime($tanggal_entry);
        $strtotime2=strtotime($tanggal_pelaksanaan);
        $FormatTanggalEntry=date('d/m/Y H:i T',$strtotime1);
        $FormatTanggalPelaksanaan=date('d/m/Y',$strtotime2);
?>
<div class="modal-body">
    <div class="row mb-2">
        <div class="col col-md-4">ID Tindakan</div>
        <div class="col col-md-8"><?php echo "$id_tindakan"; ?></div>
    </div>
    <div class="row mb-2">
        <div class="col col-md-4">ID Kunjungan</div>
        <div class="col col-md-8"><?php echo "$id_kunjungan"; ?></div>
    </div>
    <div class="row mb-2">
        <div class="col col-md-4">No.RM</div>
        <div class="col col-md-8"><?php echo "$id_pasien"; ?></div>
    </div>
    <div class="row mb-2">
        <div class="col col-md-4">Nama Pasien</div>
        <div class="col col-md-8"><?php echo "$nama_pasien"; ?></div>
    </div>
    <div class="row mb-2">
        <div class="col col-md-4">Tanggal Entry</div>
        <div class="col col-md-8"><?php echo "$FormatTanggalEntry"; ?></div>
    </div>
    <div class="row mb-2">
        <div class="col col-md-4">Petugas Entry</div>
        <div class="col col-md-8"><?php echo "$nama_petugas"; ?></div>
    </div>
    <div class="row mb-2">
        <div class="col col-md-4">Tanggal Pelaksanaan</div>
        <div class="col col-md-8"><?php echo "$FormatTanggalPelaksanaan"; ?></div>
    </div>
    <div class="row mb-2">
        <div class="col col-md-4">Waktu Pelaksanaan</div>
        <div class="col col-md-8"><?php echo "$waktu_mulai s/d $waktu_selesai"; ?></div>
    </div>
    <div class="row mb-2">
        <div class="col col-md-4">Kode Tindakan</div>
        <div class="col col-md-8"><?php echo "$kode_tindakan"; ?></div>
    </div>
    <div class="row mb-2">
        <div class="col col-md-4">Nama Tindakan</div>
        <div class="col col-md-8"><?php echo "$nama_tindakan"; ?></div>
    </div>
    <div class="row mb-2">
        <div class="col col-md-4">Alat Medis</div>
        <div class="col col-md-8">
            <?php
                echo '<ol>';
                $JumlahAlkes=count($JsonAlatMedis);
                for($i=0; $i<$JumlahAlkes; $i++){
                    echo '<li class="text-muted"><small>'.$JsonAlatMedis[$i]['alkes'].'</small></li>';
                }
                echo '</ol>';
            ?>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col col-md-4">BMHP</div>
        <div class="col col-md-8">
            <?php
                echo '<ol>';
                $JumlahBmhp=count($JsonBmhp);
                for($i=0; $i<$JumlahBmhp; $i++){
                    echo '<li class="text-muted"><small>'.$JsonBmhp[$i]['bmhp'].'</small></li>';
                }
                echo '</ol>';
            ?>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col col-md-4">Tenaga Medis</div>
        <div class="col col-md-8">
            <?php
                echo '<ol>';
                $JumlahNakes=count($JsonNakes);
                for($i=0; $i<$JumlahNakes; $i++){
                    echo '<li class="text-muted"><small>'.$JsonNakes[$i]['nama'].' ('.$JsonNakes[$i]['kategori'].')</small></li>';
                }
                echo '</ol>';
            ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
        <i class="ti ti-close"></i> Tutup
    </button>
</div>
<?php } ?>