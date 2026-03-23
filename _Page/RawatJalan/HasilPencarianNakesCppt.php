<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
        $Qry = mysqli_query($Conn, "SELECT*FROM referensi_practitioner WHERE nama like '%$keyword%' OR kode like '%$keyword%' ORDER BY nama ASC");
    }else{
        $Qry = mysqli_query($Conn, "SELECT*FROM referensi_practitioner ORDER BY nama ASC");
    }
    while ($Data = mysqli_fetch_array($Qry)) {
        $id_practitioner= $Data['id_practitioner'];
        $nama= $Data['nama'];
        $nik= $Data['nik'];
        $kategori= $Data['kategori'];
        $kontak= $Data['kontak'];
?>
    <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
            <dt class="fw-bold"><a href="javascript:void(0);" id="GetNamaNakes<?php echo $id_practitioner; ?>" class="CheckPilihNakes" value="<?php echo $id_practitioner; ?>"><?php echo $nama; ?></a></dt>
            <ol>
                <li>
                    NIK : <span id="GetNikNakes<?php echo $id_practitioner; ?>"><?php echo $nik; ?></span>
                </li>
                <li>
                    Kategori : <span id="GetKategoriNakes<?php echo $id_practitioner; ?>"><?php echo $kategori; ?></span>
                </li>
                <li>
                    Kontak : <span id="GetKontakNakes<?php echo $id_practitioner; ?>"><?php echo $kontak; ?></span>
                </li>
            </ol>
        </div>
    </li>
<?php } ?>
<script>
    //Ketika Salah Satu Data Dipilih
    $('.CheckPilihNakes').click(function(){
        var id_practitioner = $(this).attr("value");
        //Menangkap Nilai Pada Baris
        var NamaNakes=$('#GetNamaNakes'+id_practitioner+'').html();
        var NikNakes=$('#GetNikNakes'+id_practitioner+'').html();
        var KategoriNakes=$('#GetKategoriNakes'+id_practitioner+'').html();
        var KontakNakes=$('#GetKontakNakes'+id_practitioner+'').html();
        //Menambahkan Ke Form
        $('#kategori_nakes').val(KategoriNakes);
        $('#nama_nakes').val(NamaNakes);
        $('#kontak_nakes').val(KontakNakes);
        $('#identitas_nakes').val('NIK');
        $('#no_identitas_nakes').val(NikNakes);
        //Menutup Modal
        $('#ModalCariNakesCppt').modal('hide');
    });
</script>