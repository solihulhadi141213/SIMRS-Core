<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_kunjungan
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-danger text-center">';
        echo '          Data Kunjungan Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12">';
        echo '          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '              <i class="ti-close"></i> Tutup';
        echo '          </button>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['kategori_perencanaan'])){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-danger text-center">';
            echo '          Kategori Perencanaan Tidak Boleh Kosong!';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-footer">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12">';
            echo '          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
            echo '              <i class="ti-close"></i> Tutup';
            echo '          </button>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_kunjungan=$_POST['id_kunjungan'];
            $kategori_perencanaan=$_POST['kategori_perencanaan'];
            $QryRencanaPemulangan = mysqli_query($Conn,"SELECT * FROM perencanaan_pasien WHERE id_kunjungan='$id_kunjungan' AND kategori_perencanaan='$kategori_perencanaan'")or die(mysqli_error($Conn));
            $DataRencanaPemulangan = mysqli_fetch_array($QryRencanaPemulangan);
            if(empty($DataRencanaPemulangan['id_perencanaan_pasien'])){
                $perencanaan ="";
            }else{
                $perencanaan = $DataRencanaPemulangan['perencanaan'];
            }
?>
        <input type="hidden" id="PutIdKunjunganPerencanaan" name="PutIdKunjunganPerencanaan" class="form-control" value="<?php echo "$id_kunjungan"; ?>">
        <input type="hidden" id="kategori_perencanaan" name="kategori_perencanaan" class="form-control" value="<?php echo "$kategori_perencanaan"; ?>">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        if($kategori_perencanaan=="pemulangan_pasien"){
                            echo '<dt>Perencanaan Pemulangan Pasien</dt>';
                            echo '<small>';
                            echo '  Discharge planning (perencanaan pulang) 
                            adalah serangkaian keputusan dan aktivitas-aktivitasnya 
                            yang terlibat dalam pemberian
                            asuhan keperawatan yang kontinu
                            dan terkoordinasi ketika pasien
                            dipulangkan dari lembaga pelayanan
                            kesehatan';
                            echo '</small>';
                        }else{
                            if($kategori_perencanaan=="rencana_rawat"){
                                echo '<dt>Rencana Rawat</dt>';
                                echo '<small>';
                                echo '  Rencana tata laksana perawatan
                                pasien, ringkasan cara rawatan
                                (rencana terapi, rencana tindakan,
                                rencana lama hari rawat)';
                                echo '</small>';
                            }else{
                                if($kategori_perencanaan=="instruksi_medik"){
                                    echo '<dt>Instruksi Medik dan Keperawatan</dt>';
                                    echo '<small>';
                                    echo '  Penjabaran instruksi dari rencana
                                    tata laksana perawatan pasien,
                                    keterangan rinci terkait dengan
                                    tindakan medis dan keperawatan';
                                    echo '</small>';
                                }else{
                                    
                                }
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="isi_perencanaan_pasien"><?php echo "$perencanaan"; ?></div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-12" id="NotifikasiTulisPerencanaanPasien">
                    <span>
                        Pastikan data yang anda input sudah benar!
                    </span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-primary mr-2">
                <i class="ti-save"></i> Simpan
            </button>
            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                <i class="ti-close"></i> Tutup
            </button>
        </div>
<?php }} ?>