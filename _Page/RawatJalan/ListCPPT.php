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
        $JumlahCppt=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM cppt WHERE id_kunjungan='$id_kunjungan'"));
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-dark sub-title">';
        echo '      <dt>Keterangan:</dt>';
        echo '      Setelah memperoleh validasi (Tanda Tangan) Dokter DPJP maka dokumen CPPT tidak dapat diubah.';
        echo '  </div>';
        echo '</div>';
        if(empty($JumlahCppt)){
            echo '<span class="text-danger">Belum Ada Data CPPT Untuk Kunjungan Ini</span>';
        }else{
            $no=1;
            $query = mysqli_query($Conn, "SELECT*FROM cppt WHERE id_kunjungan='$id_kunjungan' ORDER BY id_cppt DESC");
            while ($data = mysqli_fetch_array($query)) {
                $id_cppt=$data['id_cppt'];
                $id_pasien=$data['id_pasien'];
                $id_kunjungan=$data['id_kunjungan'];
                $id_akses=$data['id_akses'];
                $tanggal_entry=$data['tanggal_entry'];
                $nakes=$data['nakes'];
                $dokter=$data['dokter'];
                $subjective=$data['subjective'];
                $objective=$data['objective'];
                $assessment=$data['assessment'];
                $plan=$data['plan'];
                $catatan=$data['catatan'];
                $status=$data['status'];
                //Routing Status
                if($status=="Pending"){
                    $LabelStatus='<span class="text-danger">'.$status.'</span>';
                }else{
                    $LabelStatus='<span class="text-success">'.$status.'</span>';
                }
                //Format Tanggal
                $strtotime1=strtotime($tanggal_entry);
                $TanggalEntry=date('d/m/Y H:i T',$strtotime1);
                //Json 
                $JsonNakes =json_decode($nakes, true);
                $JsonDokter =json_decode($dokter, true);
                //Nakes
                $KategoriNakes=$JsonNakes['kategori'];
                $NamaNakes=$JsonNakes['nama'];
                $KontakNakes=$JsonNakes['kontak'];
                $KategoriIdentitasNakes=$JsonNakes['kategori_identitas'];
                $NomorIdentitasNakes=$JsonNakes['no_identitas'];
                $TtdNakes=$JsonNakes['ttd'];
                if(empty($TtdNakes)){
                    $LabelTtdNakesCppt='<a href="javascript:void(0);" id="AddTtdNakesCppt" class="AddTtdNakesCppt" value="'.$id_cppt.'">Belum Ada <i class="ti ti-pencil"></i></a>';
                }else{
                    $LabelTtdNakesCppt='<br><img src="data:image/gif;base64,'. $TtdNakes .'" width="150px">';
                }
                //Dokter
                $NamaDokter=$JsonDokter['nama'];
                $SipDokter=$JsonDokter['SIP'];
                $KontakDokter=$JsonDokter['kontak'];
                $KategoriIdentitasDokter=$JsonDokter['kategori_identitas'];
                $NomorIdentitasDokter=$JsonDokter['no_identitas'];
                $TtdDokter=$JsonDokter['ttd'];
                if(empty($TtdDokter)){
                    $LabelTtdDokter='<a href="javascript:void(0);" id="AddTtdDokterCppt" class="AddTtdDokterCppt" value="'.$id_cppt.'">Belum Ada <i class="ti ti-pencil"></i></a>';
                }else{
                    $LabelTtdDokter='<br><img src="data:image/gif;base64,'. $TtdDokter .'" width="150px">';
                }
?>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <dt>
                        <?php
                            echo "$no. CPPT/$id_cppt/$id_kunjungan/$id_pasien";
                        ?>
                    </dt>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="sub-title">Info Umum</div>
                            <ul>
                                <li>ID CPPT : <code class="text-secondary"><?php echo "$id_cppt"; ?></code></li>
                                <li>No.RM : <code class="text-secondary"><?php echo "$id_pasien"; ?></code></li>
                                <li>ID.Kunjungan : <code class="text-secondary"><?php echo "$id_kunjungan"; ?></code></li>
                                <li>Tgl/Jam Entry : <code class="text-secondary"><?php echo "$TanggalEntry"; ?></code></li>
                                <li>Status : <?php echo "$LabelStatus"; ?></li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <div class="sub-title">Nakes Yang Mengisi CPPT</div>
                            <ul>
                                <li>Kategori Nakes : <code class="text-secondary"><?php echo "$KategoriNakes"; ?></code></li>
                                <li>Nama : <code class="text-secondary"><?php echo "$NamaNakes"; ?></code></li>
                                <li>Kontak : <code class="text-secondary"><?php echo "$KontakNakes"; ?></code></li>
                                <li>Identitas : <code class="text-secondary"><?php echo "($KategoriIdentitasNakes) $NomorIdentitasNakes"; ?></code></li>
                                <li>Ttd : <code class="text-secondary"><?php echo "$LabelTtdNakesCppt"; ?></code><div id="FormTtdNakesCppt<?php echo $id_cppt; ?>"></div></li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <div class="sub-title">Dokter DPJP (Validator)</div>
                            <ul>
                                <li>Nama : <code class="text-secondary"><?php echo "$NamaDokter"; ?></code></li>
                                <li>SIP : <code class="text-secondary"><?php echo "$SipDokter"; ?></code></li>
                                <li>Kontak : <code class="text-secondary"><?php echo "$KontakDokter"; ?></code></li>
                                <li>Identitas : <code class="text-secondary"><?php echo "($KategoriIdentitasDokter) $NomorIdentitasDokter"; ?></code></li>
                                <li>Ttd : <code class="text-secondary"><?php echo "$LabelTtdDokter"; ?></code><div id="FormTtdDokterCppt<?php echo $id_cppt; ?>"></div></li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <div class="sub-title"> Catatan </div>
                            <small class="text-secondary"><?php echo "$catatan"; ?></small>
                        </div>
                        <div class="col-md-3">
                            <div class="sub-title"> Subjective (S) : </div>
                            <small class="text-secondary"><?php echo "$subjective"; ?></small>
                        </div>
                        <div class="col-md-3">
                            <div class="sub-title"> Objective (O) : </div>
                            <small class="text-secondary"><?php echo "$objective"; ?></small>
                        </div>
                        <div class="col-md-3">
                            <div class="sub-title"> Assessment (A) : </div>
                            <small class="text-secondary"><?php echo "$assessment"; ?></small>
                        </div>
                        <div class="col-md-3">
                            <div class="sub-title"> Plan (P) : </div>
                            <small class="text-secondary"><?php echo "$plan"; ?></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 icon-btn">
                            <?php if($status=="Pending"){ ?>
                                <button type="button" class="btn btn-icon btn-outline-dark mr-2" data-toggle="modal" data-target="#ModalEditCppt" data-id="<?php echo $id_cppt; ?>">
                                    <i class="ti ti-pencil"></i>
                                </button>
                            <?php }else{ ?>
                                <button type="button" class="btn btn-icon btn-outline-danger mr-2" disabled>
                                    <i class="ti ti-pencil"></i>
                                </button>
                            <?php } ?>
                            <button type="button" class="btn btn-icon btn-outline-dark mr-2" data-toggle="modal" data-target="#ModalHapusCppt" data-id="<?php echo $id_cppt; ?>">
                                <i class="ti ti-trash"></i>
                            </button>
                            <button type="button" class="btn btn-icon btn-outline-dark mr-2" data-toggle="modal" data-target="#ModalCetakCpptParsial" data-id="<?php echo $id_cppt; ?>">
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
    $('.AddTtdNakesCppt').click(function(){
        var id_cppt = $(this).attr("value");
        var kategori="Nakes";
        $('#FormTtdNakesCppt'+id_cppt+'').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormTtdCppt.php',
            data        :   {id_cppt: id_cppt, kategori: kategori},
            success     : function(data){
                $('#FormTtdNakesCppt'+id_cppt+'').html(data);
                //Sembunyikan Form
                $('#HideFormTtdCppt'+kategori+''+id_cppt+'').click(function(){
                    $('#FormTtdNakesCppt'+id_cppt+'').html('');
                });
                //Simpan TTD
                $('#ProsesTtdCppt'+kategori+''+id_cppt+'').submit(function(){
                    var signature = signaturePad.toDataURL();
                    $('#NotifikasiTtdCppt'+kategori+''+id_cppt+'').html('Loading...');
                    $.ajax({
                        type 	    :   'POST',
                        url 	    :   '_Page/RawatJalan/ProsesTtdCppt.php',
                        data        :   {id_cppt: id_cppt, kategori: kategori, signature: signature},
                        success     :   function(data){
                            $('#NotifikasiTtdCppt'+kategori+''+id_cppt+'').html(data);
                            var NotifikasiTtdCpptBerhasil2=$('#NotifikasiTtdCpptBerhasil'+kategori+''+id_cppt+'').html();
                            if(NotifikasiTtdCpptBerhasil2=="Success"){
                                $('#KontenCPPT').html("Loading...");
                                $.ajax({
                                    type 	    : 'POST',
                                    url 	    : '_Page/RawatJalan/ListCPPT.php',
                                    data        : {id_kunjungan: id_kunjungan},
                                    success     : function(data){
                                        $('#KontenCPPT').html(data);
                                        $("#ListCPPT").removeClass("btn-outline-dark");
                                        $("#ListCPPT").addClass("btn-dark");
                                        $("#TambahCPPT").removeClass("btn-dark");
                                        $("#TambahCPPT").addClass("btn-outline-dark");
                                    }
                                });
                                //Tampilkan Swal
                                Swal.fire({
                                    title: 'Good Job!',
                                    text: 'Tanda Tangan CPPT Oleh Nakes Berhasil',
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
    $('.AddTtdDokterCppt').click(function(){
        var id_cppt = $(this).attr("value");
        var kategori="Dokter";
        $('#FormTtdDokterCppt'+id_cppt+'').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormTtdCppt.php',
            data        :   {id_cppt: id_cppt, kategori: kategori},
            success     : function(data){
                $('#FormTtdDokterCppt'+id_cppt+'').html(data);
                //Sembunyikan Form
                $('#HideFormTtdCppt'+kategori+''+id_cppt+'').click(function(){
                    $('#FormTtdDokterCppt'+id_cppt+'').html('');
                });
                //Simpan TTD
                $('#ProsesTtdCppt'+kategori+''+id_cppt+'').submit(function(){
                    var signature = signaturePad.toDataURL();
                    $('#NotifikasiTtdCppt'+kategori+''+id_cppt+'').html('Loading...');
                    $.ajax({
                        type 	    :   'POST',
                        url 	    :   '_Page/RawatJalan/ProsesTtdCppt.php',
                        data        :   {id_cppt: id_cppt, kategori: kategori, signature: signature},
                        success     :   function(data){
                            $('#NotifikasiTtdCppt'+kategori+''+id_cppt+'').html(data);
                            var NotifikasiTtdCpptBerhasil=$('#NotifikasiTtdCpptBerhasil'+kategori+''+id_cppt+'').html();
                            if(NotifikasiTtdCpptBerhasil=="Success"){
                                $('#KontenCPPT').html("Loading...");
                                $.ajax({
                                    type 	    : 'POST',
                                    url 	    : '_Page/RawatJalan/ListCPPT.php',
                                    data        : {id_kunjungan: id_kunjungan},
                                    success     : function(data){
                                        $('#KontenCPPT').html(data);
                                        $("#ListCPPT").removeClass("btn-outline-dark");
                                        $("#ListCPPT").addClass("btn-dark");
                                        $("#TambahCPPT").removeClass("btn-dark");
                                        $("#TambahCPPT").addClass("btn-outline-dark");
                                    }
                                });
                                //Tampilkan Swal
                                Swal.fire({
                                    title: 'Good Job!',
                                    text: 'Tanda Tangan CPPT Dokter DPJP Berhasil',
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