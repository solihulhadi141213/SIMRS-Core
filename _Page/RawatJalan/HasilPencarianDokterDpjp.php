<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
        $Qry = mysqli_query($Conn, "SELECT*FROM dokter WHERE nama like '%$keyword%' OR kode like '%$keyword%' ORDER BY nama ASC");
    }else{
        $Qry = mysqli_query($Conn, "SELECT*FROM dokter ORDER BY nama ASC");
    }
    while ($Data = mysqli_fetch_array($Qry)) {
        $id_dokter= $Data['id_dokter'];
        $nama= $Data['nama'];
        $kode= $Data['kode'];
        $kategori= $Data['kategori'];
        $kontak= $Data['kontak'];
        $SIP= $Data['SIP'];
?>
    <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
            <dt class="fw-bold"><a href="javascript:void(0);" id="GetNamaDokter<?php echo $id_dokter; ?>" class="CheckPilihDokter" value="<?php echo $id_dokter; ?>"><?php echo $nama; ?></a></dt>
            <ol>
                <li>
                    Kode : <span id="GetKodeDokter<?php echo $id_dokter; ?>"><?php echo $kode; ?></span>
                </li>
                <li>
                    SIP : <span id="GetSipDokter<?php echo $id_dokter; ?>"><?php echo $SIP; ?></span>
                </li>
                <li>
                    Kontak : <span id="GetKontakDokter<?php echo $id_dokter; ?>"><?php echo $kontak; ?></span>
                </li>
            </ol>
        </div>
    </li>
<?php } ?>
<script>
    //Ketika Salah Satu Data Dipilih
    $('.CheckPilihDokter').click(function(){
        var id_dokter = $(this).attr("value");
        //Menangkap Nilai Pada Baris
        var NamaDokter=$('#GetNamaDokter'+id_dokter+'').html();
        var KodeDokter=$('#GetKodeDokter'+id_dokter+'').html();
        var SipDokter=$('#GetSipDokter'+id_dokter+'').html();
        var KontakDokter=$('#GetKontakDokter'+id_dokter+'').html();
        //Menambahkan Ke Form
        $('#nama_dokter').val(NamaDokter);
        $('#sip_dokter').val(SipDokter);
        $('#kontak_dokter').val(KontakDokter);
        //Menutup Modal
        $('#ModalCariDokter').modal('hide');
        $('#ModalCariDokterResume').modal('hide');
    });
</script>