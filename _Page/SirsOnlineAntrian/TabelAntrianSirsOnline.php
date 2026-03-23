<?php
    //koneksi dan session
    ini_set("display_errors","off");
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //tanggal
    if(!empty($_POST['tanggal_antrian'])){
        $tanggal_antrian=$_POST['tanggal_antrian'];
    }else{
        $tanggal_antrian="";
    }
?>
<script>
    //Proses Tanggal
    $('#ShortingTanggalAntrian').click(function(){
        var tanggal_antrian = $('#tanggal_antrian').val();
        $('#MenampilkanKontenAntrian').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SirsOnlineAntrian/TabelAntrianSirsOnline.php',
            data 	    :  {tanggal_antrian: tanggal_antrian},
            success     : function(data){
                $('#MenampilkanKontenAntrian').html(data);
            }
        });
    });
</script>
<div class="card-body">
    <div class="row">
        <div class="col-md-8"></div>
        <div class="col-md-4">
            <label for="tanggal_antrian">Tanggal Antrian</label>
            <div class="input-group">
                <input type="date" class="form-control" id="tanggal_antrian" id="tanggal_antrian" value="<?php echo "$tanggal_antrian"; ?>">
                <button type="button" class="btn btn-sm btn-primary" id="ShortingTanggalAntrian">
                    <i class="ti ti-search"></i> Cari
                </button>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center">
                        <dt>No</dt>
                    </th>
                    <th class="text-center">
                        <dt>Kode Booking</dt>
                    </th>
                    <th class="text-center">
                        <dt>Nama Pasien</dt>
                    </th>
                    <th class="text-center">
                        <dt>Kunjungan</dt>
                    </th>
                    <th class="text-center">
                        <dt>Poliklinik</dt>
                    </th>
                    <th class="text-center">
                        <dt>Keterangan</dt>
                    </th>
                    <th class="text-center">
                        <dt>Option</dt>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //Buka Data SIRS Online
                    $response_sisrs_online=DataAntrianSirsOnline($x_id_rs,$password_sirs_online,$url_sirs_online,'GET',$tanggal_antrian);
                    $php_array = json_decode($response_sisrs_online, true);
                    $DataAntrianSirsOnline=$php_array['antrian'];
                    $JumlahData=count($DataAntrianSirsOnline);
                    if(empty($JumlahData)){
                        echo '<tr>';
                        echo '  <td class="text-center text-danger" colspan="7">';
                        echo '      Tidak Ada Data Antrian';
                        echo '  </td>';
                        echo '</tr>';
                    }else{
                        $no = 1;
                        //KONDISI PENGATURAN MASING FILTER
                        foreach ($DataAntrianSirsOnline as $item) {
                            $antrianid = $item['antrianid'];
                            $koders = $item['koders'];
                            $kodebooking = $item['kodebooking'];
                            $jenispasien = $item['jenispasien'];
                            $nik = $item['nik'];
                            $idpoli = $item['idpoli'];
                            $kodepoli = $item['kodepoli'];
                            $pasienbaru = $item['pasienbaru'];
                            $norm = $item['norm'];
                            $tanggalperiksa = $item['tanggalperiksa'];
                            $kodedokter = $item['kodedokter'];
                            $jampraktekawal = $item['jampraktekawal'];
                            $jampraktekakhir = $item['jampraktekakhir'];
                            $jeniskunjungan = $item['jeniskunjungan'];
                            $nomorantrean = $item['nomorantrean'];
                            $angkaantrean = $item['angkaantrean'];
                            $estimasidilayani = $item['estimasidilayani'];
                            $sisakuotajkn = $item['sisakuotajkn'];
                            $kuotajkn = $item['kuotajkn'];
                            $sisakuotanonjkn = $item['sisakuotanonjkn'];
                            $kuotanonjkn = $item['kuotanonjkn'];
                            $keterangan = $item['keterangan'];
                            $tglupdate = $item['tglupdate'];
                            //Buka Nama Pasien
                            $NamaPasien=getDataDetail($Conn,'pasien','id_pasien',$norm,'nama');
                            $NamaPoli=getDataDetail($Conn,'poliklinik','kode',$kodepoli,'nama');
                            $NamaDokter=getDataDetail($Conn,'dokter','kode',$kodedokter,'nama');
                            //Format Tanggal Update
                            $strtotime=strtotime($tglupdate);
                            $tglupdate=date('d/m/Y H:i',$strtotime);
                            //Format Tanggal Periksa
                            $strtotime2=strtotime($tanggalperiksa);
                            $tanggalperiksa=date('d/m/Y',$strtotime2);
                            $tanggalperiksa_real=date('Y-m-d',$strtotime2);
                            //Format Jam Praktek Awal
                            $strtotime3=strtotime($jampraktekawal);
                            $jampraktekawal=date('H:i',$strtotime3);
                            //Format Jam Praktek Akhir
                            $strtotime4=strtotime($jampraktekakhir);
                            $jampraktekakhir=date('H:i',$strtotime4);
                            //Format Estimasi Dilayani
                            $estimasidilayani=date('H:i',$estimasidilayani);
                    ?>
                        <tr class="table-light">
                            <td class="" align="center"><?php echo "$no";?></td>
                            <td class="" align="left">
                                <?php
                                    echo "<dt title='Kode Booking'><i class='ti ti-info-alt'></i> $kodebooking</dt>";
                                    echo "<small title='ID Antrian'><i class='ti ti-check'></i> ID.$antrianid</small><br>";
                                    echo "<small class='text-mutted' title='Nomor Antrian'><i class='icofont-ticket'></i> Antrian $angkaantrean</small><br>";
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php
                                    echo '<dt title="Nama Pasien"><i class="icofont-users-alt-3"></i> '.$NamaPasien.'</dt>';
                                    echo '<small title="ID Pasien/No.RM"><i class="icofont-medical-sign"></i> RM.'.$norm.'</small><br>';
                                    echo '<small title="ID Pasien/No.RM"><i class="icofont-ui-v-card"></i> NIK.'.$nik.'</small>';
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php
                                    echo '<dt title="Tanggal Kunjungan"><i class="icofont-ui-calendar"></i> '.$tanggalperiksa.'</dt>';
                                    echo '<small title="Jam Praktek"><i class="icofont-clock-time"></i> '.$jampraktekawal.' s/d '.$jampraktekakhir.'</small><br>';
                                    echo '<small title="Estimasi Dilayani"><i class="icofont-stethoscope-alt"></i> '.$estimasidilayani.'</small><br>';
                                    
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php
                                    echo '<dt title="Poliklinik"><i class="icofont-hospital"></i> '.$kodepoli.' - '.$NamaPoli.'</dt>';
                                    echo '<small title="Dokter"><i class="icofont-doctor-alt"></i> '.$kodedokter.' - '.$NamaDokter.'</small><br>';
                                    echo '<small title="Keterangan"><i class="ti ti-info-alt"></i> '.$keterangan.'</small><br>';
                                ?>
                            </td>
                            <td class="" align="left">
                                <?php
                                    echo '<dt title="Keterangan"><i class="icofont-question-circle"></i> '.$keterangan.'</dt>';
                                    echo "<small class='text-mutted' title='Tanggal Update'><i class='icofont-ui-calendar'></i> $tglupdate</small>";
                                ?>
                            </td>
                            <td class="" align="center">
                                <?php
                                    echo '<button type="button" title="Detail Booking Antrian" class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#ModalDetailAntrianSirsOnline" data-id="'.$kodebooking.','.$tanggalperiksa_real.'">';
                                    echo '  <i class="ti ti-info-alt"></i>';
                                    echo '</button>';
                                ?>
                            </td>
                        </tr>
                <?php
                    $no++; }}
                ?>
            </tbody>
        </table>
        
    </div>
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
                        echo '<button type="button" class="btn btn-sm btn-info" id="PageNumber'.$i.'" value="'.$i.'">';
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