<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //keyword
    if(empty($_POST['GetIdPasien'])){
        echo '<div class="modal-body"><div class="row"><div class="col col-md-12 text-center">ID Pasien Tidak Boleh Kosong!</div></div></div>';
    }else{
        $GetIdPasien=$_POST['GetIdPasien'];
        $batas="10";
        $ShortBy="DESC";
        $OrderBy="id_kunjungan";
        //Atur Page
        if(!empty($_POST['page'])){
            $page=$_POST['page'];
            $posisi = ( $page - 1 ) * $batas;
        }else{
            $page="1";
            $posisi = 0;
        }
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE id_pasien='$GetIdPasien'"));
?>
    <script>
        //ketika klik next
        $('#NextPage').click(function() {
            var valueNext=$('#NextPage').val();
            var batas=$('#batas').val();
            var GetIdPasien="<?php echo "$GetIdPasien"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            $.ajax({
                url     : "_Page/Pasien/TabelKunjunganPasien.php",
                method  : "POST",
                data 	:  { page: valueNext, batas: batas, GetIdPasien: GetIdPasien, OrderBy: OrderBy, ShortBy: ShortBy },
                success: function (data) {
                    $('#MenampilkanTabelRiwayatKunjungan').html(data);

                }
            })
        });
        //Ketika klik Previous
        $('#PrevPage').click(function() {
            var ValuePrev = $('#PrevPage').val();
            var batas=$('#batas').val();
            var GetIdPasien="<?php echo "$GetIdPasien"; ?>";
            var OrderBy="<?php echo "$OrderBy"; ?>";
            var ShortBy="<?php echo "$ShortBy"; ?>";
            $.ajax({
                url     : "_Page/Pasien/TabelKunjunganPasien.php",
                method  : "POST",
                data 	:  { page: ValuePrev,batas: batas, GetIdPasien: GetIdPasien, OrderBy: OrderBy, ShortBy: ShortBy },
                success : function (data) {
                    $('#MenampilkanTabelRiwayatKunjungan').html(data);
                }
            })
        });
        <?php 
            $JmlHalaman =ceil($jml_data/$batas); 
            $a=1;
            $b=$JmlHalaman;
            for ( $i =$a; $i<=$b; $i++ ){
        ?>
            //ketika klik page number
            $('#PageNumber<?php echo $i;?>').click(function() {
                var PageNumber = $('#PageNumber<?php echo $i;?>').val();
                var batas=$('#batas').val();
                var GetIdPasien="<?php echo "$GetIdPasien"; ?>";
                var OrderBy="<?php echo "$OrderBy"; ?>";
                var ShortBy="<?php echo "$ShortBy"; ?>";
                $.ajax({
                    url     : "_Page/Pasien/TabelKunjunganPasien.php",
                    method  : "POST",
                    data 	:  { page: PageNumber, batas: batas, GetIdPasien: GetIdPasien, OrderBy: OrderBy, ShortBy: ShortBy },
                    success: function (data) {
                        $('#MenampilkanTabelRiwayatKunjungan').html(data);
                    }
                })
            });
        <?php } ?>  
    </script>
    <div class="card-body bg-light">
        <?php
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            $query = mysqli_query($Conn, "SELECT*FROM kunjungan_utama WHERE id_pasien='$GetIdPasien' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
            while ($data = mysqli_fetch_array($query)) {
                $id_kunjungan= $data['id_kunjungan'];
                $sep= $data['sep'];
                $noRujukan= $data['noRujukan'];
                $skdp= $data['skdp'];
                $nama= $data['nama'];
                $tanggal= $data['tanggal'];
                $keluhan= $data['keluhan'];
                $tujuan= $data['tujuan'];
                $id_dokter= $data['id_dokter'];
                $dokter= $data['dokter'];
                $id_poliklinik= $data['id_poliklinik'];
                $poliklinik= $data['poliklinik'];
                $kelas= $data['kelas'];
                $ruangan= $data['ruangan'];
                $id_kasur= $data['id_kasur'];
                $DiagAwal= $data['DiagAwal'];
                $rujukan_dari= $data['rujukan_dari'];
                $rujukan_ke= $data['rujukan_ke'];
                $pembayaran= $data['pembayaran'];
                $cara_keluar= $data['cara_keluar'];
                $tanggal_keluar= $data['tanggal_keluar'];
                $status= $data['status'];
                $id_akses= $data['id_akses'];
                $nama_petugas= $data['nama_petugas'];
                //Membuka data dokter
                $QryDokter = mysqli_query($Conn,"SELECT * FROM dokter WHERE id_dokter='$id_dokter'")or die(mysqli_error($Conn));
                $DataDokter = mysqli_fetch_array($QryDokter);
                $NamaDokter= $DataDokter['nama'];
                $KodeDokter= $DataDokter['kode'];
                if($status=="Antrian"){
                    $LabelData='<label class="label label-inverse-warning"><i class="icofont-clock-time"></i> Antrian</label>';
                }else{
                    if($status=="Meninggal"){
                        $LabelData='<label class="label label-danger"><i class="icofont-close-circled"></i> Meninggal</label>';
                    }else{
                        if($status=="Terdaftar"){
                            $LabelData='<label class="label label-primary"><i class="icofont-edit"></i> Terdaftar</label>';
                        }else{
                            if($status=="Pulang"){
                                $LabelData='<label class="label label-success"><i class="icofont-checked"></i> Pulang</label>';
                            }else{
                                $LabelData='<label class="label label-dark">'.$status.'</label>';
                            }
                        }
                    }
                }
                //Inisiasi tujuan
                if($tujuan=="Rajal"){
                    $LabelTujuan='<dt class="text-info"><i class="icofont-foot-print"></i> RAJAL</dt>';
                }else{
                    $LabelTujuan='<dt class="text-danger"><i class="icofont-building-alt"></i> RANAP</dt>';
                }
                //Format Tanggal
                $strtotime=strtotime($tanggal);
                $TanggalFormat=date('d/m/Y H:i:s', $strtotime);
            ?>
                <input type="hidden" name="UrlBackPasien" id="UrlBackPasien" value="index.php?Page=Pasien&Sub=DetailPasien&id=<?php echo "$GetIdPasien"; ?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <dt>
                                    <a href="javascript:void(0);" class="text-success" data-toggle="modal" data-target="#ModalDetailKunjungan" data-id="<?php echo "$id_kunjungan"; ?>">
                                        <?php echo "ID.REG $id_kunjungan"; ?> <i class="ti ti-new-window"></i>
                                    </a>
                                </dt>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4"><dt>Tanggal</dt></div>
                                    <div class="col-md-8"><small><?php echo "$TanggalFormat"; ?></small></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"><dt>Tujuan Kunjungan</dt></div>
                                    <div class="col-md-8"><small><?php echo "$tujuan"; ?></small></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"><dt>Dokter/Poli</dt></div>
                                    <div class="col-md-8"><small><?php echo "$dokter/$poliklinik"; ?></small></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"><dt>Status Kunjungan</dt></div>
                                    <div class="col-md-8"><small><?php echo "$LabelData"; ?></small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            $no++; }
        ?>
    </div>
    <?php
        //Mengatur Halaman
        $JmlHalaman = ceil($jml_data/$batas); 
        $JmlHalaman_real = ceil($jml_data/$batas); 
        $prev=$page-1;
        $next=$page+1;
        if($next>$JmlHalaman){
            $next=$page;
        }else{
            $next=$page+1;
        }
        if($prev<"1"){
            $prev="1";
        }else{
            $prev=$page-1;
        }
    ?>
    <div class="card-footer text-center">
        <div class="btn-group">
            <a href="javascript:void(0);" class="b-b-primary text-primary">
                <button type="button" class="btn btn-sm btn-outline-secondary" id="PrevPage" value="<?php echo $prev;?>">
                    <i class="ti-angle-left"></i>
                </button>
                <?php 
                    //Navigasi nomor
                    if($JmlHalaman>5){
                        if($page>=3){
                            $a=$page-2;
                            $b=$page+2;
                            if($JmlHalaman<=$b){
                                $a=$page-2;
                                $b=$JmlHalaman;
                            }
                        }else{
                            $a=1;
                            $b=$page+2;
                            if($JmlHalaman<=$b){
                                $a=1;
                                $b=$JmlHalaman;
                            }
                        }
                    }else{
                        $a=1;
                        $b=$JmlHalaman;
                    }
                    for ( $i =$a; $i<=$b; $i++ ){
                        if($page=="$i"){
                            echo '<button type="button" class="btn btn-sm btn-outline-info" id="PageNumber'.$i.'" value="'.$i.'">';
                        }else{
                            echo '<button type="button" class="btn btn-sm btn-outline-secondary" id="PageNumber'.$i.'" value="'.$i.'">';
                        }
                        echo ''.$i.'';
                        echo '</button>';
                    }
                ?>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="NextPage" value="<?php echo $next;?>">
                    <i class="ti-angle-right"></i>
                </button>
            </a>
        </div>
    </div>
<?php   } ?>