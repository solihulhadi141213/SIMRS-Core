<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php"; 
    //Tangkap ID
    if(empty($_POST['id_kunjungan'])){
        echo '<span class="text-danger">Belum Ada Data Kunjungan Yang Dipilih</span>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        $JumlahDataEdukasi=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM edukasi WHERE id_kunjungan='$id_kunjungan'"));
        if(empty($JumlahDataEdukasi)){
            echo '<span class="text-danger">Belum Ada Data Edukasi Untuk Kunjungan Ini</span>';
        }else{
            $no=1;
            $query = mysqli_query($Conn, "SELECT*FROM edukasi WHERE id_kunjungan='$id_kunjungan'");
            while ($data = mysqli_fetch_array($query)) {
                $id_edukasi=$data['id_edukasi'];
                $id_pasien=$data['id_pasien'];
                $id_kunjungan=$data['id_kunjungan'];
                $id_akses=$data['id_akses'];
                $petugas_entry=$data['petugas_entry'];
                $tanggal_entry=$data['tanggal_entry'];
                $tanggal_edukasi=$data['tanggal_edukasi'];
                $kategori_edukasi=$data['kategori_edukasi'];
                $materi_edukasi=$data['materi_edukasi'];
                $pemberi_edukasi=$data['pemberi_edukasi'];
                $penerima_edukasi=$data['penerima_edukasi'];
                $keterangan_edukasi=$data['keterangan_edukasi'];
                $status_edukasi=$data['status_edukasi'];
                //Routing Status Edukasi
                if($status_edukasi=="Sudah Mengerti"){
                    $LabelStatus='<span class="text-primary">'.$status_edukasi.'</span>';
                }else{
                    if($status_edukasi=="Re Edukasi"){
                        $LabelStatus='<span class="text-danger">'.$status_edukasi.'</span>';
                    }else{
                        if($status_edukasi=="Re Demonstrasi"){
                            $LabelStatus='<span class="text-warning">'.$status_edukasi.'</span>';
                        }else{
                            $LabelStatus='<span class="text-dark">'.$status_edukasi.'</span>';
                        }
                    }
                }
                //Format Tanggal
                $strtotime1=strtotime($tanggal_entry);
                $strtotime2=strtotime($tanggal_edukasi);
                $TanggalEntry=date('d/m/Y H:i T',$strtotime1);
                $TanggalEdukasi=date('d/m/Y H:i T',$strtotime2);
                //Json 
                $JsonPemberiEdukasi =json_decode($pemberi_edukasi, true);
                $JsonPenerimaEdukasi =json_decode($penerima_edukasi, true);
                $JsonKeteranganEdukasi =json_decode($keterangan_edukasi, true);
                //Pemberi Edukasi
                $NamaPemberiEdukasi=$JsonPemberiEdukasi['nama'];
                $KontakPemberiEdukasi=$JsonPemberiEdukasi['kontak'];
                $IdentitasPemberiEdukasi=$JsonPemberiEdukasi['kategori_identitas'];
                $NomorIdentitasPemberiEdukasi=$JsonPemberiEdukasi['no_identitas'];
                $TtdPemberiEdukasi=$JsonPemberiEdukasi['ttd'];
                if(empty($TtdPemberiEdukasi)){
                    $LabelTtdPemberiEdukasi='<a href="javascript:void(0);" id="AddTtdPemberiEdukasi" class="AddTtdPemberiEdukasi" value="'.$id_edukasi.'">Belum Ada <i class="ti ti-pencil"></i></a>';
                }else{
                    $LabelTtdPemberiEdukasi='<br><img src="data:image/gif;base64,'. $TtdPemberiEdukasi .'" width="150px">';
                }
                //Penerima Edukasi
                $NamaPenerimaEdukasi=$JsonPenerimaEdukasi['nama'];
                $KontakPenerimaEdukasi=$JsonPenerimaEdukasi['kontak'];
                $IdentitasPenerimaEdukasi=$JsonPenerimaEdukasi['kategori_identitas'];
                $NomorIdentitasPenerimaEdukasi=$JsonPenerimaEdukasi['no_identitas'];
                $TtdPenerimaEdukasi=$JsonPenerimaEdukasi['ttd'];
                if(empty($TtdPenerimaEdukasi)){
                    $LabelTtdPenerimaEdukasi='<a href="javascript:void(0);" id="AddTtdPenerimaEdukasi" class="AddTtdPenerimaEdukasi" value="'.$id_edukasi.'">Belum Ada <i class="ti ti-pencil"></i></a>';
                }else{
                    $LabelTtdPenerimaEdukasi='<br><img src="data:image/gif;base64,'. $TtdPenerimaEdukasi .'" width="150px">';
                }
                //Keterangan Edukasi
                $Bahasa=$JsonKeteranganEdukasi['bahasa'];
                $Penerjemah=$JsonKeteranganEdukasi['penerjemah'];
                $Hambatan=$JsonKeteranganEdukasi['hambatan'];
                $jenis_hambatan=$JsonKeteranganEdukasi['jenis_hambatan'];
                $durasi=$JsonKeteranganEdukasi['durasi'];
                $kesediaan_edukasi=$JsonKeteranganEdukasi['kesediaan_edukasi'];
?>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <?php echo "<dt>$no. $kategori_edukasi</dt>"; ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="sub-title">
                                Info Pasien & Pendaftaran
                            </div>
                            <ol>
                                <li>
                                    ID Edukasi : <code class="text-secondary"><?php echo "$id_edukasi"; ?></code>
                                </li>
                                <li>
                                    No.RM : <code class="text-secondary"><?php echo "$id_pasien"; ?></code>
                                </li>
                                <li>
                                    ID.Kunjungan : <code class="text-secondary"><?php echo "$id_kunjungan"; ?></code>
                                </li>
                                <li>
                                    Petugas Entry : <code class="text-secondary"><?php echo "$petugas_entry"; ?></code>
                                </li>
                                <li>
                                    Tgl/Jam Entry : <code class="text-secondary"><?php echo "$TanggalEntry"; ?></code>
                                </li>
                                <li>
                                    Tgl/Jam Edukasi : <code class="text-secondary"><?php echo "$TanggalEdukasi"; ?></code>
                                </li>
                                <li>
                                    Durasi : <code class="text-secondary"><?php echo "$TanggalEdukasi"; ?></code>
                                </li>
                                <li>
                                    Status Edukasi : <code><?php echo "$LabelStatus"; ?></code>
                                </li>
                                <li>
                                    Kategori Edukasi: <code class="text-secondary"><?php echo "$kategori_edukasi"; ?></code>
                                </li>
                                <li>
                                    Materi Edukasi : <code class="text-secondary"><?php echo "$materi_edukasi"; ?></code>
                                </li>
                            </ol>
                        </div>
                        <div class="col-md-4">
                            <div class="sub-title">
                                Pemberi & Penerima Edukasi
                            </div>
                            <ol>
                                <li class="mb-3">
                                    Pemberi Edukasi
                                    <ul>
                                        <li>
                                            Nama : <code class="text-secondary"><?php echo "$NamaPemberiEdukasi"; ?></code>
                                        </li>
                                        <li>
                                            Kontak : <code class="text-secondary"><?php echo "$KontakPemberiEdukasi"; ?></code>
                                        </li>
                                        <li>
                                            Kategori Identitas : <code class="text-secondary"><?php echo "$IdentitasPemberiEdukasi"; ?></code>
                                        </li>
                                        <li>
                                            Identitas : <code class="text-secondary"><?php echo "$NomorIdentitasPemberiEdukasi"; ?></code>
                                        </li>
                                        <li>
                                            Ttd : <code><?php echo "$LabelTtdPemberiEdukasi"; ?></code> <div id="FormTtdPemberiEdukasi<?php echo "$id_edukasi"; ?>"></div>
                                        </li>
                                    </ul>
                                </li>
                                <li class="mb-3">
                                    Penerima Edukasi
                                    <ul>
                                        <li>
                                            Nama : <code class="text-secondary"><?php echo "$NamaPemberiEdukasi"; ?></code>
                                        </li>
                                        <li>
                                            Kontak : <code class="text-secondary"><?php echo "$KontakPemberiEdukasi"; ?></code>
                                        </li>
                                        <li>
                                            Kategori Identitas : <code class="text-secondary"><?php echo "$IdentitasPemberiEdukasi"; ?></code>
                                        </li>
                                        <li>
                                            Identitas : <code class="text-secondary"><?php echo "$NomorIdentitasPemberiEdukasi"; ?></code>
                                        </li>
                                        <li>
                                            Ttd : <code><?php echo "$LabelTtdPenerimaEdukasi"; ?></code> <div id="FormTtdPenerimaEdukasi<?php echo "$id_edukasi"; ?>"></div>
                                        </li>
                                    </ul>
                                </li>
                            </ol>
                            
                        </div>
                        <div class="col-md-4">
                            <div class="sub-title">
                                Keterangan Edukasi
                            </div>
                            <ol>
                                <li>
                                    Kesediaan Edukasi : <code class="text-secondary"><?php echo "$kesediaan_edukasi"; ?></code>
                                </li>
                                <li>
                                    Kemampuan Bahasa : <code class="text-secondary"><?php echo "$Bahasa"; ?></code>
                                </li>
                                <li>
                                    Perlu Penerjemah : <code class="text-secondary"><?php echo "$Penerjemah"; ?></code>
                                </li>
                                <li>
                                    Hambatan : <code class="text-secondary"><?php echo "$Hambatan"; ?></code>
                                </li>
                                <li>
                                    Jenis Hambatan : 
                                    <code class="text-secondary">
                                        <?php 
                                            if(!empty($jenis_hambatan)){
                                                echo '<ol>';
                                                foreach($jenis_hambatan as $DataHambatan){
                                                    $ListJenisHambatan=$DataHambatan['jenis'];
                                                    echo '<li>'.$ListJenisHambatan.'</li>'; 
                                                }
                                                echo '</ol>';
                                            }else{
                                                echo 'Tidak Ada';
                                            }
                                        ?>
                                    </code>
                                </li>
                                <li>
                                    Durasi Edukasi : <code class="text-secondary"><?php echo "$durasi"; ?></code>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 icon-btn">
                            <button type="button" class="btn btn-icon btn-outline-dark mr-2" data-toggle="modal" data-target="#ModalEditEdukasi" data-id="<?php echo $id_edukasi; ?>">
                                <i class="ti ti-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-icon btn-outline-dark mr-2" data-toggle="modal" data-target="#ModalHapusEdukasi" data-id="<?php echo $id_edukasi; ?>">
                                <i class="ti ti-trash"></i>
                            </button>
                            <button type="button" class="btn btn-icon btn-outline-dark mr-2" data-toggle="modal" data-target="#ModalCetakEdukasiParsial" data-id="<?php echo $id_edukasi; ?>">
                                <i class="ti ti-printer"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
                $no++;
            }
        }
    } 
?>
<script>
    var id_kunjungan="<?php echo "$id_kunjungan"; ?>";
    $('.AddTtdPemberiEdukasi').click(function(){
        var id_edukasi = $(this).attr("value");
        var kategori="Pemberi";
        $('#FormTtdPemberiEdukasi'+id_edukasi+'').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormTtdEdukasi.php',
            data        :   {id_edukasi: id_edukasi, kategori: kategori},
            success     : function(data){
                $('#FormTtdPemberiEdukasi'+id_edukasi+'').html(data);
                //Sembunyikan Form
                $('#HideFormTtdEdukasi'+kategori+''+id_edukasi+'').click(function(){
                    $('#FormTtdPemberiEdukasi'+id_edukasi+'').html('');
                });
                //Simpan TTD
                $('#ProsesTtdEdukasi'+kategori+''+id_edukasi+'').submit(function(){
                    var signature = signaturePad.toDataURL();
                    $('#NotifikasiTtdEdukasi'+kategori+''+id_edukasi+'').html('Loading...');
                    $.ajax({
                        type 	    :   'POST',
                        url 	    :   '_Page/RawatJalan/ProsesTtdEdukasi.php',
                        data        :   {id_edukasi: id_edukasi, kategori: kategori, signature: signature},
                        success     :   function(data){
                            $('#NotifikasiTtdEdukasi'+kategori+''+id_edukasi+'').html(data);
                            var NotifikasiTtdEdukasiBerhasil=$('#NotifikasiTtdEdukasiBerhasil'+kategori+''+id_edukasi+'').html();
                            if(NotifikasiTtdEdukasiBerhasil=="Success"){
                                $('#KontenEdukasi').html("Loading...");
                                $.ajax({
                                    type 	    : 'POST',
                                    url 	    : '_Page/RawatJalan/ListEdukasi.php',
                                    data        : {id_kunjungan: id_kunjungan},
                                    success     : function(data){
                                        $('#KontenEdukasi').html(data);
                                        $("#ListEdukasi").removeClass("btn-outline-dark");
                                        $("#ListEdukasi").addClass("btn-dark");
                                        $("#TambahEdukasi").removeClass("btn-dark");
                                        $("#TambahEdukasi").addClass("btn-outline-dark");
                                    }
                                });
                                //Tampilkan Swal
                                Swal.fire({
                                    title: 'Good Job!',
                                    text: 'Tanda Tangan Konsultasi Berhasil',
                                    icon: 'success',
                                    confirmButtonText: 'Tutup'
                                })
                            }
                        }
                    });
                });
            }
        });
    });
    $('.AddTtdPenerimaEdukasi').click(function(){
        var id_edukasi = $(this).attr("value");
        var kategori="Penerima";
        $('#FormTtdPenerimaEdukasi'+id_edukasi+'').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormTtdEdukasi.php',
            data        :   {id_edukasi: id_edukasi, kategori: kategori},
            success     : function(data){
                $('#FormTtdPenerimaEdukasi'+id_edukasi+'').html(data);
                //Sembunyikan Form
                $('#HideFormTtdEdukasi'+kategori+''+id_edukasi+'').click(function(){
                    $('#FormTtdPenerimaEdukasi'+id_edukasi+'').html('');
                });
                //Simpan TTD
                $('#ProsesTtdEdukasi'+kategori+''+id_edukasi+'').submit(function(){
                    var signature = signaturePad.toDataURL();
                    $('#NotifikasiTtdEdukasi'+kategori+''+id_edukasi+'').html('Loading...');
                    $.ajax({
                        type 	    :   'POST',
                        url 	    :   '_Page/RawatJalan/ProsesTtdEdukasi.php',
                        data        :   {id_edukasi: id_edukasi, kategori: kategori, signature: signature},
                        success     :   function(data){
                            $('#NotifikasiTtdEdukasi'+kategori+''+id_edukasi+'').html(data);
                            var NotifikasiTtdEdukasiBerhasil=$('#NotifikasiTtdEdukasiBerhasil'+kategori+''+id_edukasi+'').html();
                            if(NotifikasiTtdEdukasiBerhasil=="Success"){
                                $('#KontenEdukasi').html("Loading...");
                                $.ajax({
                                    type 	    : 'POST',
                                    url 	    : '_Page/RawatJalan/ListEdukasi.php',
                                    data        : {id_kunjungan: id_kunjungan},
                                    success     : function(data){
                                        $('#KontenEdukasi').html(data);
                                        $("#ListEdukasi").removeClass("btn-outline-dark");
                                        $("#ListEdukasi").addClass("btn-dark");
                                        $("#TambahEdukasi").removeClass("btn-dark");
                                        $("#TambahEdukasi").addClass("btn-outline-dark");
                                    }
                                });
                                //Tampilkan Swal
                                Swal.fire({
                                    title: 'Good Job!',
                                    text: 'Tanda Tangan Konsultasi Berhasil',
                                    icon: 'success',
                                    confirmButtonText: 'Tutup'
                                })
                            }
                        }
                    });
                });
            }
        });
    });
</script>