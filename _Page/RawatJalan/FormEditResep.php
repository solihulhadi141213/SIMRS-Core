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
        $id_kunjungan=getDataDetail($Conn,"resep",'id_resep',$id_resep,'id_kunjungan');
        $id_pasien=getDataDetail($Conn,"resep",'id_resep',$id_resep,'id_pasien');
        $tanggal_lahir=getDataDetail($Conn,"resep",'id_resep',$id_resep,'tanggal_lahir');
        $nama_pasien=getDataDetail($Conn,"resep",'id_resep',$id_resep,'nama_pasien');
        $petugas_entry=getDataDetail($Conn,"resep",'id_resep',$id_resep,'petugas_entry');
        $tanggal_entry=getDataDetail($Conn,"resep",'id_resep',$id_resep,'tanggal_entry');
        $tanggal_resep=getDataDetail($Conn,"resep",'id_resep',$id_resep,'tanggal_resep');
        $IdDokter=getDataDetail($Conn,"resep",'id_resep',$id_resep,'id_dokter');
        $nama_dokter=getDataDetail($Conn,"resep",'id_resep',$id_resep,'nama_dokter');
        $kontak_dokter=getDataDetail($Conn,"resep",'id_resep',$id_resep,'kontak_dokter');
        //Json Decode
        $JsonNamaPasien=json_decode($nama_pasien, true);
        $JsonKontakDokter =json_decode($kontak_dokter, true);
        //Buka Pasien
        $NamaPasien=$JsonNamaPasien['nama_pasien'];
        $TanggalLahir=$JsonNamaPasien['tanggal_lahir'];
        $BeratBadan=$JsonNamaPasien['berat_badan'];
        $TinggiBadan=$JsonNamaPasien['tinggi_badan'];
        $LuasTubuh=$JsonNamaPasien['luas_tubuh'];
        //Format Tanggal
        $strtotime1=strtotime($tanggal_entry);
        $strtotime2=strtotime($tanggal_resep);
        $TanggalEntry=date('Y-m-d',$strtotime1);
        $JamEntry=date('H:i',$strtotime1);
        $TanggalResep=date('Y-m-d',$strtotime2);
        $JamResep=date('H:i',$strtotime2);
        
?>
    <input type="hidden" name="id_resep" id="id_resep" class="form-control" value="<?php echo "$id_resep"; ?>">
    <div class="modal-body">
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>A. Informasi Pasien & Kunjungan</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col col-md-4">A.1 ID.Kunjungan</div>
                    <div class="col col-md-8">
                        <input type="text" readonly name="id_kunjungan" id="id_kunjungan" class="form-control" value="<?php echo "$id_kunjungan"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">A.2 No.RM</div>
                    <div class="col col-md-8">
                        <input type="text" readonly name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$id_pasien"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">A.3 Nama Pasien</div>
                    <div class="col col-md-8">
                        <input type="text" readonly name="nama_pasien" id="nama_pasien" class="form-control" value="<?php echo "$NamaPasien"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">A.4 Tanggal Lahir</div>
                    <div class="col col-md-8">
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="<?php echo "$TanggalLahir"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">A.5 Tinggi Badan (m)</div>
                    <div class="col col-md-8">
                        <input type="number" min="0" step="0.01" name="tinggi_badan" id="tinggi_badan" class="form-control" value="<?php echo "$TinggiBadan"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4">A.6 Berat Badan (kg)</div>
                    <div class="col col-md-8">
                        <input type="number" min="0" step="0.01" name="berat_badan" id="berat_badan" class="form-control" value="<?php echo "$BeratBadan"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">A.7 Luas Tubuh (m<sup>2</sup>)</div>
                    <div class="col col-md-8 mb-2">
                        <input type="number" min="0" step="0.01" name="luas_tubuh" id="luas_tubuh" class="form-control" value="<?php echo "$LuasTubuh"; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>B. Pencatatan Resep</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">B.1 Tanggal</div>
                    <div class="col col-md-8 mb-2">
                        <input type="date" readonly name="tanggal_entry" id="tanggal_entry" class="form-control" value="<?php echo "$TanggalEntry"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">B.2 Jam</div>
                    <div class="col col-md-8 mb-2">
                        <input type="time" readonly name="jam_entry" id="jam_entry" class="form-control" value="<?php echo "$JamEntry"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">B.3 Petugas Entry</div>
                    <div class="col col-md-8 mb-2">
                        <input type="text" name="petugas_entry" id="petugas_entry" class="form-control" value="<?php echo "$petugas_entry"; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>C. Tanggal & Waktu Resep</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">C.1 Tanggal Resep</div>
                    <div class="col col-md-8 mb-2">
                        <input type="date" name="tanggal_resep" id="tanggal_resep" class="form-control" value="<?php echo "$TanggalResep"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">C.2 Jam Resep</div>
                    <div class="col col-md-8 mb-2">
                        <input type="time" name="jam_resep" id="jam_resep" class="form-control" value="<?php echo "$JamResep"; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>D. Dokter</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">D.1 Nama Dokter</div>
                    <div class="col col-md-8 mb-2">
                        <select name="id_dokter" id="id_dokter" class="form-control">
                            <option value="">Pilih</option>
                            <?php
                                $query = mysqli_query($Conn, "SELECT * FROM dokter ORDER BY nama ASC");
                                while ($data = mysqli_fetch_array($query)) {
                                    $id_dokter= $data['id_dokter'];
                                    $NamaDokter= $data['nama'];
                                    if($IdDokter==$id_dokter){
                                        echo '<option selected value="'.$id_dokter.'">'.$NamaDokter.'</option>';
                                    }else{
                                        echo '<option value="'.$id_dokter.'">'.$NamaDokter.'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col col-md-4 mb-2">D.2 Kontak Dokter</div>
                    <div class="col col-md-8 mb-2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="kategori_kontak" name="kategori_kontak" list="list_kategori_kontak" placeholder="Kantor, WA, HP">
                                    <input type="text" class="form-control" id="nomor_kontak" name="nomor_kontak" list="list_nomor_kontak" placeholder="62">
                                    <button type="button" class="btn btn-sm btn-outline-dark" id="TambahKontakDokter">
                                        <i class="ti ti-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="MultiFormKontakDokter">
                            <!-- Multi Form Kontak Dokter -->
                            <?php
                                $JumlahKontak=count($JsonKontakDokter);
                                $no=1;
                                for($i=0; $i<$JumlahKontak; $i++){
                                    $KategoriKontak=$JsonKontakDokter[$i]['kategori_kontak'];
                                    $NomorKontak=$JsonKontakDokter[$i]['nomor_kontak'];
                                    echo '<div class="row mb-3" id="BarisKontakDokter'.$no.'">';
                                    echo '  <div class="col-md-12 mb-2 input-group">';
                                    echo '      <input type="text" readonly class="form-control" id="isi_kategori[]" name="isi_kategori[]" value="'.$KategoriKontak.'">';
                                    echo '      <input type="text" readonly class="form-control" id="isi_nomor_kontak[]" name="isi_nomor_kontak[]" value="'.$NomorKontak.'">';
                                    echo '      <button type="button" class="btn btn-sm btn-outline-danger HapusFormKontakDokter" id="'.$no.'"><i class="ti ti-close"></i></button>';
                                    echo '  </div>';
                                    echo '</div>';
                                    $no++;
                                }
                            ?>
                        </div>
                        <datalist id="list_kategori_kontak">
                            <option value="Kantor">
                            <option value="HP">
                            <option value="Rumah">
                            <option value="WA">
                        </datalist>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiEditResep">
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
    $(document).ready(function(){
        var no =1;
        //Multi Form Kontak Dokter
        $('#TambahKontakDokter').click(function(){
            var kategori_kontak=$('#kategori_kontak').val(); 
            var nomor_kontak=$('#nomor_kontak').val(); 
            if(kategori_kontak!==""){
                no++;
                $('#MultiFormKontakDokter').append('<div class="row mb-3" id="BarisKontakDokter'+no+'"><div class="col-md-12 mb-2 input-group"><input type="text" readonly class="form-control" id="isi_kategori[]" name="isi_kategori[]" value="'+kategori_kontak+'"><input type="text" readonly class="form-control" id="isi_nomor_kontak[]" name="isi_nomor_kontak[]" value="'+nomor_kontak+'"><button type="button" class="btn btn-sm btn-outline-danger HapusFormKontakDokter" id="'+no+'"><i class="ti ti-close"></i></button></div></div>');
                $('#kategori_kontak').val(''); 
                $('#nomor_kontak').val(''); 
            }
        });
        $(document).on('click', '.HapusFormKontakDokter', function(){
            var button_id = $(this).attr("id"); 
            $('#BarisKontakDokter'+button_id+'').remove();
        });
    });
</script>