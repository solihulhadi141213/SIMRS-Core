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
        if(empty($_POST['kategori'])){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-danger text-center">';
            echo '          Nama Data Tidak Boleh Kosong!';
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
            $kategori=$_POST['kategori'];
            $riwayat_alergi=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_alergi');
            $JsonRiwayatAlergi =json_decode($riwayat_alergi, true);
            if($kategori=="Makanan"){
                $ListAlergi=$JsonRiwayatAlergi['makanan'];
            }else{
                if($kategori=="Minuman"){
                    $ListAlergi=$JsonRiwayatAlergi['minuman'];
                }else{
                    if($kategori=="Obat"){
                        $ListAlergi=$JsonRiwayatAlergi['obat'];
                    }else{
                        $ListAlergi=$JsonRiwayatAlergi['lainnya'];
                    }
                }
            }
?>
        <script>
            $(document).ready(function(){
				var no =1;
				$('#AddField').click(function(){
					no++;
					$('#MultiForm').append('<div class="row mb-3" id="row'+no+'"><div class="col-md-3 mb-2"><input type="text" class="form-control" id="JenisZat[]" name="JenisZat[]" placeholder="Jenis/Zat"></div><div class="col-md-7 mb-2"><input type="text" class="form-control" id="Reaksi[]" name="Reaksi[]" placeholder="Reaksi"></div><div class="col-md-2"><button type="button" class="btn btn-sm btn-danger btn-block btn_remove" id="'+no+'"><i class="ti ti-close"></i></button></div>');
				});

				$(document).on('click', '.btn_remove', function(){
					var button_id = $(this).attr("id"); 
					$('#row'+button_id+'').remove();
				});
			});
        </script>
        <input type="hidden" id="PutIdKunjungan" name="PutIdKunjungan" class="form-control" value="<?php echo "$id_kunjungan"; ?>">
        <input type="hidden" name="KategoriAlergy" id="KategoriAlergy" class="form-control" value="<?php echo "$kategori"; ?>">
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    Kategori Alergy : <?php echo "$kategori"; ?>
                </div>
            </div>
            <div class="row mb-3">
                <!-- <div class="col-md-3">
                    <input type="text" class="form-control" id="JenisZat[]" name="JenisZat[]" placeholder="Jenis/Zat">
                </div>
                <div class="col-md-7">
                    <input type="text" class="form-control" id="Reaksi[]" name="Reaksi[]" placeholder="Reaksi">
                </div> -->
                <div class="col-md-3">
                    <button type="button" class="btn btn-sm btn-block btn-outline-success" id="AddField">
                        <i class="ti ti-plus"></i> Add Form
                    </button>
                </div>
            </div>
            <div id="MultiForm">
                <?php
                    if(!empty($ListAlergi)){
                        $JumlahData=count($ListAlergi);
                        $no=1;
                        for($i=0; $i<$JumlahData; $i++){
                            $JenisZatList=$ListAlergi[$i]["JenisZat"];
                            $ReaksiList=$ListAlergi[$i]["Reaksi"];
                            echo '<div class="row mb-3" id="row'.$no.'a">';
                            echo '  <div class="col-md-3 mb-2">';
                            echo '      <input type="text" class="form-control" id="JenisZat[]" name="JenisZat[]" placeholder="Jenis/Zat" value="'.$ListAlergi[$i]["JenisZat"].'">';
                            echo '  </div>';
                            echo '  <div class="col-md-7 mb-2">';
                            echo '      <input type="text" class="form-control" id="Reaksi[]" name="Reaksi[]" placeholder="Jenis/Zat" value="'.$ListAlergi[$i]["Reaksi"].'">';
                            echo '  </div>';
                            echo '  <div class="col-md-2 mb-2">';
                            echo '      <button type="button" class="btn btn-sm btn-danger btn-block btn_remove" id="'.$no.'a"><i class="ti ti-close"></i></button>';
                            echo '  </div>';
                            echo '</div>';
                            $no++;
                        }
                    }
                ?>
            </div>
            
            <div class="row mt-4 mb-2">
                <div class="col-md-12" id="NotifikasiEditRiwayaAlergi">
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