<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_resep'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Resep Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_resep=$_POST['id_resep'];
        //Buka Detail Pasien
        $pengkajian=getDataDetail($Conn,"resep",'id_resep',$id_resep,'pengkajian');
        if(!empty($pengkajian)){
            $JsonPengkajian=json_decode($pengkajian, true);
            //Buka data pengkajian
            $Pengkajian1=$JsonPengkajian['pengkajian1']['value'];
            $Pengkajian2=$JsonPengkajian['pengkajian2']['value'];
            $Pengkajian3=$JsonPengkajian['pengkajian3']['value'];
            $Pengkajian4=$JsonPengkajian['pengkajian4']['value'];
            $Pengkajian5=$JsonPengkajian['pengkajian5']['value'];
            $Pengkajian6=$JsonPengkajian['pengkajian6']['value'];
            $Pengkajian7=$JsonPengkajian['pengkajian7']['value'];
            $Pengkajian8=$JsonPengkajian['pengkajian8']['value'];
            $Pengkajian9=$JsonPengkajian['pengkajian9']['value'];
            $Pengkajian10=$JsonPengkajian['pengkajian10']['value'];
            $Pengkajian11=$JsonPengkajian['pengkajian11']['value'];
            $Pengkajian12=$JsonPengkajian['pengkajian12']['value'];
            $Pengkajian13=$JsonPengkajian['pengkajian13']['value'];
            $KeteranganPengkajian1=$JsonPengkajian['pengkajian1']['keterangan'];
            $KeteranganPengkajian2=$JsonPengkajian['pengkajian2']['keterangan'];
            $KeteranganPengkajian3=$JsonPengkajian['pengkajian3']['keterangan'];
            $KeteranganPengkajian4=$JsonPengkajian['pengkajian4']['keterangan'];
            $KeteranganPengkajian5=$JsonPengkajian['pengkajian5']['keterangan'];
            $KeteranganPengkajian6=$JsonPengkajian['pengkajian6']['keterangan'];
            $KeteranganPengkajian7=$JsonPengkajian['pengkajian7']['keterangan'];
            $KeteranganPengkajian8=$JsonPengkajian['pengkajian8']['keterangan'];
            $KeteranganPengkajian9=$JsonPengkajian['pengkajian9']['keterangan'];
            $KeteranganPengkajian10=$JsonPengkajian['pengkajian10']['keterangan'];
            $KeteranganPengkajian11=$JsonPengkajian['pengkajian11']['keterangan'];
            $KeteranganPengkajian12=$JsonPengkajian['pengkajian12']['keterangan'];
            $KeteranganPengkajian13=$JsonPengkajian['pengkajian13']['keterangan'];
            $petugas_pengkajian=$JsonPengkajian['petugas_pengkajian'];
        }else{
            $pengkajian="";
            $JsonPengkajian="";
            $Pengkajian1="";
            $Pengkajian2="";
            $Pengkajian3="";
            $Pengkajian4="";
            $Pengkajian5="";
            $Pengkajian6="";
            $Pengkajian7="";
            $Pengkajian8="";
            $Pengkajian9="";
            $Pengkajian10="";
            $Pengkajian11="";
            $Pengkajian12="";
            $Pengkajian13="";
            $KeteranganPengkajian1="";
            $KeteranganPengkajian2="";
            $KeteranganPengkajian3="";
            $KeteranganPengkajian4="";
            $KeteranganPengkajian5="";
            $KeteranganPengkajian6="";
            $KeteranganPengkajian7="";
            $KeteranganPengkajian8="";
            $KeteranganPengkajian9="";
            $KeteranganPengkajian10="";
            $KeteranganPengkajian11="";
            $KeteranganPengkajian12="";
            $KeteranganPengkajian13="";
            $petugas_pengkajian="";
        }
?>
    <input type="hidden" name="id_resep" class="form-control" value="<?php echo "$id_resep"; ?>">
    <div class="modal-body">
        <div class="row mb-4">
            <div class="col-md-12">
                <ol>
                    <li class="mb-4">
                        <dt>Persyaratan Administrasi</dt>
                        <ol>
                            <li class="mb-4">
                                Nama, umur, jenis kelamin, berat badan dan tinggi badan Pasien
                                <ul>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian1=="Sesuai"){echo "checked";} ?> name="pengkajian1" id="pengkajian1_sesuai" value="Sesuai"> 
                                        <label for="pengkajian1_sesuai"><small>Sesuai</small></label>
                                    </li>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian1=="Tidak"){echo "checked";} ?> name="pengkajian1" id="pengkajian1_tidak" value="Tidak">
                                        <label for="pengkajian1_tidak"><small>Tidak</small></label>
                                    </li>
                                    <li>
                                        <input type="text" <?php if($Pengkajian1!=="Tidak"){echo "readonly";} ?> name="keterangan_pengkajian1" id="keterangan_pengkajian1" class="form-control" placeholder="Keterangan" value="<?php echo "$KeteranganPengkajian1"; ?>">
                                    </li>
                                </ul>
                            </li>
                            <li class="mb-4">
                                Nama, nomor ijin, alamat dan paraf dokter
                                <ul>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian2=="Sesuai"){echo "checked";} ?> name="pengkajian2" id="pengkajian2_sesuai" value="Sesuai"> 
                                        <label for="pengkajian2_sesuai"><small>Sesuai</small></label>
                                    </li>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian2=="Tidak"){echo "checked";} ?> name="pengkajian2" id="pengkajian2_tidak" value="Tidak">
                                        <label for="pengkajian2_tidak"><small>Tidak</small></label>
                                    </li>
                                    <li>
                                        <input type="text" <?php if($Pengkajian2!=="Tidak"){echo "readonly";} ?> name="keterangan_pengkajian2" id="keterangan_pengkajian2" class="form-control" placeholder="Keterangan" value="<?php echo "$KeteranganPengkajian2"; ?>">
                                    </li>
                                </ul>
                            </li>
                            <li class="mb-4">
                                Tanggal resep
                                <ul>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian3=="Sesuai"){echo "checked";} ?> name="pengkajian3" id="pengkajian3_sesuai" value="Sesuai"> 
                                        <label for="pengkajian3_sesuai"><small>Sesuai</small></label>
                                    </li>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian3=="Tidak"){echo "checked";} ?> name="pengkajian3" id="pengkajian3_tidak" value="Tidak">
                                        <label for="pengkajian3_tidak"><small>Tidak</small></label>
                                    </li>
                                    <li>
                                        <input type="text" <?php if($Pengkajian3!=="Tidak"){echo "readonly";} ?> name="keterangan_pengkajian3" id="keterangan_pengkajian3" class="form-control" placeholder="Keterangan" value="<?php echo "$KeteranganPengkajian3"; ?>">
                                    </li>
                                </ul>
                            </li>
                            <li class="mb-4">
                                Ruangan/unit asal resep
                                <ul>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian4=="Sesuai"){echo "checked";} ?> name="pengkajian4" id="pengkajian4_sesuai" value="Sesuai"> 
                                        <label for="pengkajian4_sesuai"><small>Sesuai</small></label>
                                    </li>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian4=="Tidak"){echo "checked";} ?> name="pengkajian4" id="pengkajian4_tidak" value="Tidak">
                                        <label for="pengkajian4_tidak"><small>Tidak</small></label>
                                    </li>
                                    <li>
                                        <input type="text" <?php if($Pengkajian4!=="Tidak"){echo "readonly";} ?> name="keterangan_pengkajian4" id="keterangan_pengkajian4" class="form-control" placeholder="Keterangan" value="<?php echo "$KeteranganPengkajian4"; ?>">
                                    </li>
                                </ul>
                            </li>
                        </ol>
                    </li>
                    <li class="mb-4">
                        <dt>Persyaratan Farmasetik</dt>
                        <ol>
                            <li class="mb-4">
                                Nama obat, bentuk dan kekuatan sediaan
                                <ul>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian5=="Sesuai"){echo "checked";} ?> name="pengkajian5" id="pengkajian5_sesuai" value="Sesuai"> 
                                        <label for="pengkajian5_sesuai"><small>Sesuai</small></label>
                                    </li>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian5=="Tidak"){echo "checked";} ?> name="pengkajian5" id="pengkajian5_tidak" value="Tidak">
                                        <label for="pengkajian5_tidak"><small>Tidak</small></label>
                                    </li>
                                    <li>
                                        <input type="text" <?php if($Pengkajian5!=="Tidak"){echo "readonly";} ?> name="keterangan_pengkajian5" id="keterangan_pengkajian5" class="form-control" placeholder="Keterangan" value="<?php echo "$KeteranganPengkajian5"; ?>">
                                    </li>
                                </ul>
                            </li>
                            <li class="mb-4">
                                Dosis dan jumlah obat
                                <ul>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian6=="Sesuai"){echo "checked";} ?> name="pengkajian6" id="pengkajian6_sesuai" value="Sesuai"> 
                                        <label for="pengkajian6_sesuai"><small>Sesuai</small></label>
                                    </li>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian6=="Tidak"){echo "checked";} ?> name="pengkajian6" id="pengkajian6_tidak" value="Tidak">
                                        <label for="pengkajian6_tidak"><small>Tidak</small></label>
                                    </li>
                                    <li>
                                        <input type="text" <?php if($Pengkajian6!=="Tidak"){echo "readonly";} ?> name="keterangan_pengkajian6" id="keterangan_pengkajian6" class="form-control" placeholder="Keterangan" value="<?php echo "$KeteranganPengkajian6"; ?>">
                                    </li>
                                </ul>
                            </li>
                            <li class="mb-4">
                                Stabilitas
                                <ul>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian7=="Sesuai"){echo "checked";} ?> name="pengkajian7" id="pengkajian7_sesuai" value="Sesuai"> 
                                        <label for="pengkajian7_sesuai"><small>Sesuai</small></label>
                                    </li>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian7=="Tidak"){echo "checked";} ?> name="pengkajian7" id="pengkajian7_tidak" value="Tidak">
                                        <label for="pengkajian7_tidak"><small>Tidak</small></label>
                                    </li>
                                    <li>
                                        <input type="text" <?php if($Pengkajian7!=="Tidak"){echo "readonly";} ?> name="keterangan_pengkajian7" id="keterangan_pengkajian7" class="form-control" placeholder="Keterangan" value="<?php echo "$KeteranganPengkajian7"; ?>">
                                    </li>
                                </ul>
                            </li>
                            <li class="mb-4">
                                Aturan dan cara penggunaan
                                <ul>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian8=="Sesuai"){echo "checked";} ?> name="pengkajian8" id="pengkajian8_sesuai" value="Sesuai"> 
                                        <label for="pengkajian8_sesuai"><small>Sesuai</small></label>
                                    </li>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian8=="Tidak"){echo "checked";} ?> name="pengkajian8" id="pengkajian8_tidak" value="Tidak">
                                        <label for="pengkajian8_tidak"><small>Tidak</small></label>
                                    </li>
                                    <li>
                                        <input type="text" <?php if($Pengkajian8!=="Tidak"){echo "readonly";} ?> name="keterangan_pengkajian8" id="keterangan_pengkajian8" class="form-control" placeholder="Keterangan" value="<?php echo "$KeteranganPengkajian8"; ?>">
                                    </li>
                                </ul>
                            </li>
                        </ol>
                    </li>
                    <li class="mb-4">
                        <dt>Persyaratan Klinis</dt>
                        <ol>
                            <li class="mb-4">
                                Ketepatan indikasi, dosis, dan waktu penggunaan obat
                                <ul>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian9=="Sesuai"){echo "checked";} ?> name="pengkajian9" id="pengkajian9_sesuai" value="Sesuai"> 
                                        <label for="pengkajian9_sesuai"><small>Sesuai</small></label>
                                    </li>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian9=="Tidak"){echo "checked";} ?> name="pengkajian9" id="pengkajian9_tidak" value="Tidak">
                                        <label for="pengkajian9_tidak"><small>Tidak</small></label>
                                    </li>
                                    <li>
                                        <input type="text" <?php if($Pengkajian9!=="Tidak"){echo "readonly";} ?> name="keterangan_pengkajian9" id="keterangan_pengkajian9" class="form-control" placeholder="Keterangan" value="<?php echo "$KeteranganPengkajian9"; ?>">
                                    </li>
                                </ul>
                            </li>
                            <li class="mb-4">
                                Duplikasi pengobatan
                                <ul>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian10=="Ada"){echo "checked";} ?> name="pengkajian10" id="pengkajian10_sesuai" value="Ada"> 
                                        <label for="pengkajian10_sesuai"><small>Ada</small></label>
                                    </li>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian10=="Tidak"){echo "checked";} ?> name="pengkajian10" id="pengkajian10_tidak" value="Tidak">
                                        <label for="pengkajian10_tidak"><small>Tidak</small></label>
                                    </li>
                                    <li>
                                        <input type="text" <?php if($Pengkajian10!=="Ada"){echo "readonly";} ?> name="keterangan_pengkajian10" id="keterangan_pengkajian10" class="form-control" placeholder="Keterangan" value="<?php echo "$KeteranganPengkajian10"; ?>">
                                    </li>
                                </ul>
                            </li>
                            <li class="mb-4">
                                Alergi dan Reaksi Obat yang Tidak Dikehendaki (ROTD)
                                <ul>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian11=="Ada"){echo "checked";} ?> name="pengkajian11" id="pengkajian11_sesuai" value="Ada"> 
                                        <label for="pengkajian11_sesuai"><small>Ada</small></label>
                                    </li>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian11=="Tidak"){echo "checked";} ?> name="pengkajian11" id="pengkajian11_tidak" value="Tidak">
                                        <label for="pengkajian11_tidak"><small>Tidak</small></label>
                                    </li>
                                    <li>
                                        <input type="text" <?php if($Pengkajian11!=="Ada"){echo "readonly";} ?> name="keterangan_pengkajian11" id="keterangan_pengkajian11" class="form-control" placeholder="Keterangan" value="<?php echo "$KeteranganPengkajian11"; ?>">
                                    </li>
                                </ul>
                            </li>
                            <li class="mb-4">
                                Kontraindikasi
                                <ul>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian12=="Ada"){echo "checked";} ?> name="pengkajian12" id="pengkajian12_sesuai" value="Ada"> 
                                        <label for="pengkajian12_sesuai"><small>Ada</small></label>
                                    </li>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian12=="Tidak"){echo "checked";} ?> name="pengkajian12" id="pengkajian12_tidak" value="Tidak">
                                        <label for="pengkajian12_tidak"><small>Tidak</small></label>
                                    </li>
                                    <li>
                                        <input type="text" <?php if($Pengkajian12!=="Ada"){echo "readonly";} ?> name="keterangan_pengkajian12" id="keterangan_pengkajian12" class="form-control" placeholder="Keterangan" value="<?php echo "$KeteranganPengkajian12"; ?>">
                                    </li>
                                </ul>
                            </li>
                            <li class="mb-4">
                                Interaksi obat
                                <ul>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian13=="Ada"){echo "checked";} ?> name="pengkajian13" id="pengkajian13_sesuai" value="Ada"> 
                                        <label for="pengkajian13_sesuai"><small>Ada</small></label>
                                    </li>
                                    <li>
                                        <input type="radio" <?php if($Pengkajian13=="Tidak"){echo "checked";} ?> name="pengkajian13" id="pengkajian13_tidak" value="Tidak">
                                        <label for="pengkajian13_tidak"><small>Tidak</small></label>
                                    </li>
                                    <li>
                                        <input type="text" <?php if($Pengkajian13!=="Ada"){echo "readonly";} ?> name="keterangan_pengkajian13" id="keterangan_pengkajian13" class="form-control" placeholder="Keterangan" value="<?php echo "$KeteranganPengkajian13"; ?>">
                                    </li>
                                </ul>
                            </li>
                        </ol>
                    </li>
                    <li>
                        <dt>Petugas Yang Melakukan Pengkajian</dt>
                        <input type="text" name="petugas_pengkajian" id="petugas_pengkajian" class="form-control" value="<?php echo $petugas_pengkajian;?>">
                    </li>
                </ol>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiPengkajianResep">
                <span class="text-primary">Pastikan informasi sudah terisi dengan lengkap dan benar.</span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-primary mr-3">
            <i class="ti ti-save"></i> Simpan
        </button>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>
<script>
    $('input[type=radio][name=pengkajian1]').change(function() {
        if (this.value == 'Sesuai') {
            $("#keterangan_pengkajian1").val("");
            $("#keterangan_pengkajian1").prop('readonly', true);
        }
        else if (this.value == 'Tidak') {
            $("#keterangan_pengkajian1").val("");
            $("#keterangan_pengkajian1").prop('readonly', false);
        }
    });
    $('input[type=radio][name=pengkajian2]').change(function() {
        if (this.value == 'Sesuai') {
            $("#keterangan_pengkajian2").val("");
            $("#keterangan_pengkajian2").prop('readonly', true);
        }
        else if (this.value == 'Tidak') {
            $("#keterangan_pengkajian2").val("");
            $("#keterangan_pengkajian2").prop('readonly', false);
        }
    });
    $('input[type=radio][name=pengkajian3]').change(function() {
        if (this.value == 'Sesuai') {
            $("#keterangan_pengkajian3").val("");
            $("#keterangan_pengkajian3").prop('readonly', true);
        }
        else if (this.value == 'Tidak') {
            $("#keterangan_pengkajian3").val("");
            $("#keterangan_pengkajian3").prop('readonly', false);
        }
    });
    $('input[type=radio][name=pengkajian4]').change(function() {
        if (this.value == 'Sesuai') {
            $("#keterangan_pengkajian4").val("");
            $("#keterangan_pengkajian4").prop('readonly', true);
        }
        else if (this.value == 'Tidak') {
            $("#keterangan_pengkajian4").val("");
            $("#keterangan_pengkajian4").prop('readonly', false);
        }
    });
    $('input[type=radio][name=pengkajian5]').change(function() {
        if (this.value == 'Sesuai') {
            $("#keterangan_pengkajian5").val("");
            $("#keterangan_pengkajian5").prop('readonly', true);
        }
        else if (this.value == 'Tidak') {
            $("#keterangan_pengkajian5").val("");
            $("#keterangan_pengkajian5").prop('readonly', false);
        }
    });
    $('input[type=radio][name=pengkajian6]').change(function() {
        if (this.value == 'Sesuai') {
            $("#keterangan_pengkajian6").val("");
            $("#keterangan_pengkajian6").prop('readonly', true);
        }
        else if (this.value == 'Tidak') {
            $("#keterangan_pengkajian6").val("");
            $("#keterangan_pengkajian6").prop('readonly', false);
        }
    });
    $('input[type=radio][name=pengkajian7]').change(function() {
        if (this.value == 'Sesuai') {
            $("#keterangan_pengkajian7").val("");
            $("#keterangan_pengkajian7").prop('readonly', true);
        }
        else if (this.value == 'Tidak') {
            $("#keterangan_pengkajian7").val("");
            $("#keterangan_pengkajian7").prop('readonly', false);
        }
    });
    $('input[type=radio][name=pengkajian8]').change(function() {
        if (this.value == 'Sesuai') {
            $("#keterangan_pengkajian8").val("");
            $("#keterangan_pengkajian8").prop('readonly', true);
        }
        else if (this.value == 'Tidak') {
            $("#keterangan_pengkajian8").val("");
            $("#keterangan_pengkajian8").prop('readonly', false);
        }
    });
    $('input[type=radio][name=pengkajian9]').change(function() {
        if (this.value == 'Sesuai') {
            $("#keterangan_pengkajian9").val("");
            $("#keterangan_pengkajian9").prop('readonly', true);
        }
        else if (this.value == 'Tidak') {
            $("#keterangan_pengkajian9").val("");
            $("#keterangan_pengkajian9").prop('readonly', false);
        }
    });
    $('input[type=radio][name=pengkajian10]').change(function() {
        if (this.value == 'Tidak') {
            $("#keterangan_pengkajian10").val("");
            $("#keterangan_pengkajian10").prop('readonly', true);
        }
        else if (this.value == 'Ada') {
            $("#keterangan_pengkajian10").val("");
            $("#keterangan_pengkajian10").prop('readonly', false);
        }
    });
    $('input[type=radio][name=pengkajian11]').change(function() {
        if (this.value == 'Tidak') {
            $("#keterangan_pengkajian11").val("");
            $("#keterangan_pengkajian11").prop('readonly', true);
        }
        else if (this.value == 'Ada') {
            $("#keterangan_pengkajian11").val("");
            $("#keterangan_pengkajian11").prop('readonly', false);
        }
    });
    $('input[type=radio][name=pengkajian12]').change(function() {
        if (this.value == 'Tidak') {
            $("#keterangan_pengkajian12").val("");
            $("#keterangan_pengkajian12").prop('readonly', true);
        }
        else if (this.value == 'Ada') {
            $("#keterangan_pengkajian12").val("");
            $("#keterangan_pengkajian12").prop('readonly', false);
        }
    });
    $('input[type=radio][name=pengkajian13]').change(function() {
        if (this.value == 'Tidak') {
            $("#keterangan_pengkajian13").val("");
            $("#keterangan_pengkajian13").prop('readonly', true);
        }
        else if (this.value == 'Ada') {
            $("#keterangan_pengkajian13").val("");
            $("#keterangan_pengkajian13").prop('readonly', false);
        }
    });
</script>