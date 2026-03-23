<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="card">';
        echo '  <div class="card-body text-center text-danger">';
        echo '      ID Kunjungan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
?>
    <div class="card mb-2">
        <div class="card-header">
            A. Perencanaan Pemulangan Pasien 
            <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalTulisPerencanaanPasien" data-id="<?php echo ''.$id_kunjungan.',pemulangan_pasien'; ?>">
                <i class="ti ti-pencil"></i> Tulis
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 sub-title">
                    <small>
                        <dt>Keterangan</dt>
                        Discharge planning (perencanaan
                        pulang) adalah serangkaian
                        keputusan dan aktivitas-aktivitasnya
                        yang terlibat dalam pemberian
                        asuhan keperawatan yang kontinu
                        dan terkoordinasi ketika pasien
                        dipulangkan dari lembaga pelayanan
                        kesehatan
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php
                        //Cek apakah sudah ada data 
                        $QryRencanaPemulangan = mysqli_query($Conn,"SELECT * FROM perencanaan_pasien WHERE id_kunjungan='$id_kunjungan' AND kategori_perencanaan='pemulangan_pasien'")or die(mysqli_error($Conn));
                        $DataRencanaPemulangan = mysqli_fetch_array($QryRencanaPemulangan);
                        if(empty($DataRencanaPemulangan['id_perencanaan_pasien'])){
                            echo '<span class="text-danger">Belum Ada Perencanaan Pemulangan Pasien</span>';
                        }else{
                            $perencanaan = $DataRencanaPemulangan['perencanaan'];
                            $tanggal_entry = $DataRencanaPemulangan['tanggal_entry'];
                            $id_akses = $DataRencanaPemulangan['id_akses'];
                            $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
                            //Format Tanggal
                            $strtotime=strtotime($tanggal_entry);
                            $FormatTanggalEntry=date('d/m/Y H:i T', $strtotime);
                            echo '<i><small>Tgl/Jam: '.$FormatTanggalEntry.'</small></i><br>';
                            echo '<i><small>Petugas: '.$NamaPetugas.'</small></i><br>';
                            echo '<p>'.$perencanaan.'</p>';
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="card-footer icon-btn">
            <?php
                if(!empty($DataRencanaPemulangan['id_perencanaan_pasien'])){
                    $id_perencanaan_pasien=$DataRencanaPemulangan['id_perencanaan_pasien'];
                    echo '<button class="btn btn-icon btn-outline-secondary mr-2" data-toggle="modal" data-target="#ModalHapusPerencanaan" data-id="'.$id_perencanaan_pasien.'">';
                    echo '  <i class="ti ti-trash"></i>';
                    echo '</button>';
                    echo '<button class="btn btn-icon btn-outline-secondary" data-toggle="modal" data-target="#ModalCetakPerencanaan" data-id="'.$id_perencanaan_pasien.'">';
                    echo '  <i class="ti ti-printer"></i>';
                    echo '</button>';
                }
            ?>
        </div>
    </div>
    <div class="card mb-2">
        <div class="card-header">
            B. Rencana Rawat
            <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalTulisPerencanaanPasien" data-id="<?php echo ''.$id_kunjungan.',rencana_rawat'; ?>">
                <i class="ti ti-pencil"></i> Tulis
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 sub-title">
                    <small>
                        <dt>Keterangan</dt>
                        Rencana tata laksana perawatan
                        pasien, ringkasan cara rawatan
                        (rencana terapi, rencana tindakan,
                        rencana lama hari rawat)
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php
                        //Cek apakah sudah ada data 
                        $QryRencanaRawat = mysqli_query($Conn,"SELECT * FROM perencanaan_pasien WHERE id_kunjungan='$id_kunjungan' AND kategori_perencanaan='rencana_rawat'")or die(mysqli_error($Conn));
                        $DataRencanaRawat = mysqli_fetch_array($QryRencanaRawat);
                        if(empty($DataRencanaRawat['id_perencanaan_pasien'])){
                            echo '<span class="text-danger">Belum Ada Rencana Rawat</span>';
                        }else{
                            $perencanaan = $DataRencanaRawat['perencanaan'];
                            $tanggal_entry = $DataRencanaRawat['tanggal_entry'];
                            $id_akses = $DataRencanaRawat['id_akses'];
                            $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
                            //Format Tanggal
                            $strtotime=strtotime($tanggal_entry);
                            $FormatTanggalEntry=date('d/m/Y H:i T', $strtotime);
                            echo '<i><small>Tgl/Jam: '.$FormatTanggalEntry.'</small></i><br>';
                            echo '<i><small>Petugas: '.$NamaPetugas.'</small></i><br>';
                            echo '<p>'.$perencanaan.'</p>';
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="card-footer icon-btn">
            <?php
                if(!empty($DataRencanaRawat['id_perencanaan_pasien'])){
                    $id_perencanaan_pasien=$DataRencanaRawat['id_perencanaan_pasien'];
                    echo '<button class="btn btn-icon btn-outline-secondary mr-2" data-toggle="modal" data-target="#ModalHapusPerencanaan" data-id="'.$id_perencanaan_pasien.'">';
                    echo '  <i class="ti ti-trash"></i>';
                    echo '</button>';
                    echo '<button class="btn btn-icon btn-outline-secondary" data-toggle="modal" data-target="#ModalCetakPerencanaan" data-id="'.$id_perencanaan_pasien.'">';
                    echo '  <i class="ti ti-printer"></i>';
                    echo '</button>';
                }
            ?>
        </div>
    </div>
    <div class="card mb-2">
        <div class="card-header">
            C. Instruksi Medik dan Keperawatan
            <a href="javascript:void(0);" class="badge badge-primary" data-toggle="modal" data-target="#ModalTulisPerencanaanPasien" data-id="<?php echo ''.$id_kunjungan.',instruksi_medik'; ?>">
                <i class="ti ti-pencil"></i> Tulis
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 sub-title">
                    <small>
                        <dt>Keterangan</dt>
                        Penjabaran instruksi dari rencana
                        tata laksana perawatan pasien,
                        keterangan rinci terkait dengan
                        tindakan medis dan keperawatan
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php
                        //Cek apakah sudah ada data 
                        $QryInstruksiMedik = mysqli_query($Conn,"SELECT * FROM perencanaan_pasien WHERE id_kunjungan='$id_kunjungan' AND kategori_perencanaan='instruksi_medik'")or die(mysqli_error($Conn));
                        $DataInstruksiMedik = mysqli_fetch_array($QryInstruksiMedik);
                        if(empty($DataInstruksiMedik['id_perencanaan_pasien'])){
                            echo '<span class="text-danger">Belum Ada Instruksi Medik dan Keperawatan</span>';
                        }else{
                            $perencanaan = $DataInstruksiMedik['perencanaan'];
                            $tanggal_entry = $DataInstruksiMedik['tanggal_entry'];
                            $id_akses = $DataInstruksiMedik['id_akses'];
                            $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
                            //Format Tanggal
                            $strtotime=strtotime($tanggal_entry);
                            $FormatTanggalEntry=date('d/m/Y H:i T', $strtotime);
                            echo '<i><small>Tgl/Jam: '.$FormatTanggalEntry.'</small></i><br>';
                            echo '<i><small>Petugas: '.$NamaPetugas.'</small></i><br>';
                            echo '<p>'.$perencanaan.'</p>';
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="card-footer icon-btn">
            <?php
                if(!empty($DataInstruksiMedik['id_perencanaan_pasien'])){
                    $id_perencanaan_pasien=$DataInstruksiMedik['id_perencanaan_pasien'];
                    echo '<button class="btn btn-icon btn-outline-secondary mr-2" data-toggle="modal" data-target="#ModalHapusPerencanaan" data-id="'.$id_perencanaan_pasien.'">';
                    echo '  <i class="ti ti-trash"></i>';
                    echo '</button>';
                    echo '<button class="btn btn-icon btn-outline-secondary" data-toggle="modal" data-target="#ModalCetakPerencanaan" data-id="'.$id_perencanaan_pasien.'">';
                    echo '  <i class="ti ti-printer"></i>';
                    echo '</button>';
                }
            ?>
        </div>
    </div>
<?php } ?>
