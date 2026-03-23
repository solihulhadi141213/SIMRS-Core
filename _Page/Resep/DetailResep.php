<?php
    //Inisiasi Fungsi
    include "_Config/SimrsFunction.php";
    if(empty($_GET['id'])){
        $id_resep="";
    }else{
        $id_resep=$_GET['id'];
    }
    //Buka Detail Resep
    $id_pasien=getDataDetail($Conn,'resep','id_resep',$id_resep,'id_pasien');
    $id_kunjungan=getDataDetail($Conn,'resep','id_resep',$id_resep,'id_kunjungan');
    $id_akses=getDataDetail($Conn,'resep','id_resep',$id_resep,'id_akses');
    $id_dokter=getDataDetail($Conn,'resep','id_resep',$id_resep,'id_dokter');
    $nama_pasien=getDataDetail($Conn,'resep','id_resep',$id_resep,'nama_pasien');
    $petugas_entry=getDataDetail($Conn,'resep','id_resep',$id_resep,'petugas_entry');
    $nama_dokter=getDataDetail($Conn,'resep','id_resep',$id_resep,'nama_dokter');
    $ttd_dokter=getDataDetail($Conn,'resep','id_resep',$id_resep,'ttd_dokter');
    $kontak_dokter=getDataDetail($Conn,'resep','id_resep',$id_resep,'kontak_dokter');
    $tanggal_entry=getDataDetail($Conn,'resep','id_resep',$id_resep,'tanggal_entry');
    $tanggal_resep=getDataDetail($Conn,'resep','id_resep',$id_resep,'tanggal_resep');
    $obat=getDataDetail($Conn,'resep','id_resep',$id_resep,'obat');
    $catatan=getDataDetail($Conn,'resep','id_resep',$id_resep,'catatan');
    $status=getDataDetail($Conn,'resep','id_resep',$id_resep,'status');
    $pengkajian=getDataDetail($Conn,'resep','id_resep',$id_resep,'pengkajian');
    //Decode pasien
    $Jsonpasien =json_decode($nama_pasien, true);
    $NamaPasien=$Jsonpasien['nama_pasien'];
    $tanggal_lahir=$Jsonpasien['tanggal_lahir'];
    $berat_badan=$Jsonpasien['berat_badan'];
    $tinggi_badan=$Jsonpasien['tinggi_badan'];
    $luas_tubuh=$Jsonpasien['luas_tubuh'];
    //Decode Kontak Dokter
    $JsonKontakDokter =json_decode($kontak_dokter, true);
    //Decode Obat
    $JsonObat =json_decode($obat, true);
    $JumlahItemObat=count($JsonObat);
    //Format Tanggal
    $strtotime= strtotime($tanggal_resep);
    $FormatTanggal= date('d/m/Y',$strtotime);
    //Routing Status
    if($status=="Pending"){
        $LabelStatus='<span class="text-warning">Pending</span>';
    }else{
        $LabelStatus='<span class="text-success">Selesai</span>';
    }
    //Routing Tanda Tangan
    if(empty($ttd_dokter)){
        $LabelTtdDokter='<span class="text-danger">Belum Ada</span>';
    }else{
        $LabelTtdDokter='<span class="text-success">Sudah Ada</span>';
    }
    //Routing Pengkajian
    if(empty($pengkajian)){
        $LabelPengkajian='<span class="text-danger">Belum Ada</span>';
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
        $ttd_pengkaji="";
        $LabelTandaTanganPengkaji='';
    }else{
        $LabelPengkajian='<span class="text-success">Sudah Ada</span>';
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
        if(!empty($JsonPengkajian['ttd_pengkaji'])){
            $ttd_pengkaji=$JsonPengkajian['ttd_pengkaji'];
            $LabelTandaTanganPengkaji='<br><img src="data:image/gif;base64,'. $ttd_pengkaji .'" width="150px">';
        }else{
            $ttd_pengkaji="";
            $LabelTandaTanganPengkaji='';
        }
    }
?>
<div class="row">
    <div class="col-md-4">
        <div class="card mb-2">
            <div class="card-header">
                <div class="row mb-3">
                    <div class="col-md-12 text-center">
                        <dt><i class="ti ti-info-alt"></i> Informasi Resep</dt>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <a href="index.php?Page=Resep" class="btn btn-sm btn-block btn btn-dark btn-round">
                            <i class="ti ti-arrow-circle-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">No.RM</div>
                    <div class="col-md-8">
                        <code>
                            <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailPasien" data-id="<?php echo "$id_pasien"; ?>">
                                <?php echo "$id_pasien"; ?> <i class="ti ti-layers"></i>
                            </a>
                        </code>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">No.Reg</div>
                    <div class="col-md-8">
                        <code>
                            <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailKunjungan" data-id="<?php echo "$id_kunjungan"; ?>">
                                <?php echo "$id_kunjungan"; ?> <i class="ti ti-layers"></i>
                            </a>
                        </code>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">Nama Pasien</div>
                    <div class="col-md-8"><span class="text-secondary"><?php echo "$NamaPasien"; ?></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">Tanggal Lahir</div>
                    <div class="col-md-8"><span class="text-secondary"><?php echo "$tanggal_lahir"; ?></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">Berat Badan</div>
                    <div class="col-md-8"><span class="text-secondary"><?php echo "$berat_badan"; ?></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">Tinggi Badan</div>
                    <div class="col-md-8"><span class="text-secondary"><?php echo "$tinggi_badan"; ?></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">Luas Tubuh</div>
                    <div class="col-md-8"><span class="text-secondary"><?php echo "$luas_tubuh"; ?></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">Nama Dokter</div>
                    <div class="col-md-8"><span class="text-secondary"><?php echo "$nama_dokter"; ?></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">kontak Dokter</div>
                    <div class="col-md-8">
                        <span class="text-secondary">
                            <?php
                                $JumlahKontak=count($JsonKontakDokter);
                                if(!empty($JumlahKontak)){
                                    for($i=0; $i<$JumlahKontak; $i++){
                                        $KategoriKontak=$JsonKontakDokter[$i]['kategori_kontak'];
                                        $NomorKontak=$JsonKontakDokter[$i]['nomor_kontak'];
                                        echo '<span class="text-secondary">- '.$NomorKontak.' ('.$KategoriKontak.')</span><br>';
                                    }
                                }
                            ?>
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">Tanggal Resep</div>
                    <div class="col-md-8"><span class="text-secondary"><?php echo "$tanggal_resep"; ?></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">Status Resep</div>
                    <div class="col-md-8"><span class="text-secondary"><?php echo "$LabelStatus"; ?></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">Catatan</div>
                    <div class="col-md-8"><span class="text-secondary"><?php echo "$catatan"; ?></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 text-center">
                        Tanda Tangan Dokter :<br>
                        <?php
                            if(!empty($ttd_dokter)){
                                echo '<img src="data:image/gif;base64,'. $ttd_dokter .'" width="150px"><br>';
                                echo '('.$nama_dokter.')';
                            }else{
                                echo '<span class="text-danger">Belum Ada</span>';
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <button type="button" class="btn btn-sm btn-block btn-round btn-outline-dark" data-toggle="modal" data-target="#ModalCetakResep" data-id="<?php echo "$id_resep"; ?>">
                            <i class="icofont-printer"></i> Cetak Resep
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <dt><i class="icofont-notepad"></i> Uraian Resep</dt>
            </div>
            <div class="card-block accordion-block">
                <div id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="accordion-panel">
                        <div class="accordion-heading" role="tab" id="headingOne">
                            <h3 class="card-title accordion-title">
                                <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <?php
                                        if(!empty($pengkajian)){
                                            echo '<dt class="text-success">A. Pengkajian Resep <i class="ti ti-check"></i></dt>';
                                        }else{
                                            echo '<dt class="text-dark">A. Pengkajian Resep </dt>';
                                        }
                                    ?>
                                    
                                </a>
                            </h3>
                        </div>
                        <div id="collapseOne" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingOne" style="">
                            <div class="accordion-content accordion-desc">
                                <ul>
                                    <li class="mb-4">
                                        A.1. Persyaratan Administrasi
                                        <?php
                                            echo '<ol>';
                                            echo '  <li>';
                                            echo '      Nama, umur, jenis kelamin, berat badan dan tinggi badan Pasien : <span class="text-secondary">'.$Pengkajian1.'</span><br>';
                                                if(!empty($KeteranganPengkajian1)){
                                                    echo '(<span class="text-secondary">'.$KeteranganPengkajian1.'</span>)';
                                                }
                                            echo '  </li>';
                                            echo '  <li>';
                                            echo '      Nama, nomor ijin, alamat dan paraf dokter : <span class="text-secondary">'.$Pengkajian2.'</span><br>';
                                                if(!empty($KeteranganPengkajian2)){
                                                    echo '(<span class="text-secondary">'.$KeteranganPengkajian2.'</span>)';
                                                }
                                            echo '  </li>';
                                            echo '  <li>';
                                            echo '      Tanggal resep : <span class="text-secondary">'.$Pengkajian3.'</span><br>';
                                                if(!empty($KeteranganPengkajian3)){
                                                    echo '(<span class="text-secondary">'.$KeteranganPengkajian3.'</span>)';
                                                }
                                            echo '  </li>';
                                            echo '  <li>';
                                            echo '      Ruangan/unit asal resep : <span class="text-secondary">'.$Pengkajian4.'</span><br>';
                                                if(!empty($KeteranganPengkajian4)){
                                                    echo '(<span class="text-secondary">'.$KeteranganPengkajian4.'</span>)';
                                                }
                                            echo '  </li>';
                                            echo '</ol>';
                                        ?>
                                    </li>
                                    <li class="mb-4">
                                        A.2. Persyaratan Farmasetik
                                        <?php
                                                echo '<ol>';
                                                echo '  <li>';
                                                echo '      Nama obat, bentuk dan kekuatan sediaan : <span class="text-secondary">'.$Pengkajian5.'</span><br>';
                                                    if(!empty($KeteranganPengkajian5)){
                                                        echo '(<span class="text-secondary">'.$KeteranganPengkajian5.'</span>)';
                                                    }
                                                echo '  </li>';
                                                echo '  <li>';
                                                echo '      Dosis dan jumlah obat : <span class="text-secondary">'.$Pengkajian6.'</span><br>';
                                                    if(!empty($KeteranganPengkajian6)){
                                                        echo '(<span class="text-secondary">'.$KeteranganPengkajian6.'</span>)';
                                                    }
                                                echo '  </li>';
                                                echo '  <li>';
                                                echo '      Stabilitas : <span class="text-secondary">'.$Pengkajian7.'</span><br>';
                                                    if(!empty($KeteranganPengkajian7)){
                                                        echo '(<span class="text-secondary">'.$KeteranganPengkajian7.'</span>)';
                                                    }
                                                echo '  </li>';
                                                echo '  <li>';
                                                echo '      Aturan dan cara penggunaan <span class="text-secondary">'.$Pengkajian8.'</span><br>';
                                                    if(!empty($KeteranganPengkajian8)){
                                                        echo '(<span class="text-secondary">'.$KeteranganPengkajian8.'</span>)';
                                                    }
                                                echo '  </li>';
                                                echo '</ol>';
                                        ?>
                                    </li>
                                    <li class="mb-4">
                                        A.3. Persyaratan Klinis
                                        <?php
                                            echo '<ol>';
                                            echo '  <li>';
                                            echo '      Ketepatan indikasi, dosis, dan waktu penggunaan obat  <span class="text-secondary">'.$Pengkajian9.'</span><br>';
                                                if(!empty($KeteranganPengkajian9)){
                                                    echo '(<span class="text-secondary">'.$KeteranganPengkajian9.'</span>)';
                                                }
                                            echo '  </li>';
                                            echo '  <li>';
                                            echo '      Duplikasi pengobatan  <span class="text-secondary">'.$Pengkajian10.'</span><br>';
                                                if(!empty($KeteranganPengkajian10)){
                                                    echo '(<span class="text-secondary">'.$KeteranganPengkajian10.'</span>)';
                                                }
                                            echo '  </li>';
                                            echo '  <li>';
                                            echo '      Alergi dan Reaksi Obat yang Tidak Dikehendaki (ROTD)  <span class="text-secondary">'.$Pengkajian11.'</span><br>';
                                                if(!empty($KeteranganPengkajian11)){
                                                    echo '(<span class="text-secondary">'.$KeteranganPengkajian11.'</span>)';
                                                }
                                            echo '  </li>';
                                            echo '  <li>';
                                            echo '      Kontraindikasi  <span class="text-secondary">'.$Pengkajian12.'</span><br>';
                                                if(!empty($KeteranganPengkajian12)){
                                                    echo '(<span class="text-secondary">'.$KeteranganPengkajian12.'</span>)';
                                                }
                                            echo '  </li>';
                                            echo '  <li>';
                                            echo '      Interaksi obat   <span class="text-secondary">'.$Pengkajian13.'</span><br>';
                                                if(!empty($KeteranganPengkajian13)){
                                                    echo '(<span class="text-secondary">'.$KeteranganPengkajian13.'</span>)';
                                                }
                                            echo '  </li>';
                                            echo '</ol>';
                                        ?>
                                    </li>
                                </ul>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <?php
                                            if(!empty($pengkajian)){
                                                echo "Tanda Tangan Pengkajian <br>";
                                                echo ''.$LabelTandaTanganPengkaji.'<br>';
                                                echo '('.$petugas_pengkajian.')';
                                            }else{
                                                echo "Belum Ada";
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-panel">
                        <div class="accordion-heading" role="tab" id="headingTwo">
                            <h3 class="card-title accordion-title">
                                <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <?php
                                        if(!empty($JumlahItemObat)){
                                            echo '<dt class="text-success">B. Rincian Resep <i class="ti ti-check"></i></dt>';
                                        }else{
                                            echo '<dt class="text-dark">B. Rincian Resep </dt>';
                                        }
                                    ?>
                                </a>
                            </h3>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" style="">
                            <div class="accordion-content accordion-desc">
                                <?php
                                    if(!empty($JumlahItemObat)){
                                        if(!empty($JsonObat)){
                                            $JumlahObat=count($JsonObat);
                                            $no=1;
                                            for($i=0; $i<$JumlahObat; $i++){
                                                $id=$JsonObat[$i]['id'];
                                                $id_obat=$JsonObat[$i]['id_obat'];
                                                $nama_obat=$JsonObat[$i]['nama_obat'];
                                                $bentuk_sediaan=$JsonObat[$i]['bentuk_sediaan'];
                                                $jumlah_obat=$JsonObat[$i]['jumlah_obat'];
                                                $metode=$JsonObat[$i]['metode'];
                                                $dosis=$JsonObat[$i]['dosis'];
                                                $unit=$JsonObat[$i]['unit'];
                                                $frekuensi=$JsonObat[$i]['frekuensi'];
                                                $aturan_tambahan=$JsonObat[$i]['aturan_tambahan'];
                                                echo '<div class="row mb-4">';
                                                echo '  <div class="col-md-12 mb-2 sub-title">';
                                                echo '      '.$no.'. '.$nama_obat.'';
                                                echo '  </div>';
                                                echo '  <div class="col-md-6 mb-2">';
                                                echo '      <ul>';
                                                echo '          <li>Sediaan: <code class="text-secondary">'.$bentuk_sediaan.'</code></li>';
                                                echo '          <li>Metode: <code class="text-secondary">'.$metode.'</code></li>';
                                                echo '          <li>Jumlah: <code class="text-secondary">'.$jumlah_obat.'</code></li>';
                                                echo '      </ul>';
                                                echo '  </div>';
                                                echo '  <div class="col-md-6 mb-2">';
                                                echo '      <ul>';
                                                echo '          <li>Dosis: <code class="text-secondary">'.$dosis.' '.$unit.'</code></li>';
                                                echo '          <li>Frekuansi: <code class="text-secondary">'.$frekuensi.'</code></li>';
                                                echo '          <li>Aturan: <code class="text-secondary">'.$aturan_tambahan.'</code></li>';
                                                echo '      </ul>';
                                                echo '  </div>';
                                                echo '  <div class="col-md-12 mb-3 icon-btn">';
                                                echo '      <button class="btn btn-icon btn-outline-dark" title="Tambahkan Ke Billing">';
                                                echo '          <i class="ti-bag"></i>';
                                                echo '      </button>';
                                                echo '      <button class="btn btn-icon btn-outline-dark" data-toggle="modal" data-target="#ModalCetakEtiket" data-id="'.$id_resep.','.$id.'" title="Cetak E-Tiket">';
                                                echo '          <i class="icofont-printer"></i>';
                                                echo '      </button>';
                                                echo '  </div>';
                                                echo '</div>';
                                                $no++;
                                            }
                                        }
                                    }else{
                                        echo "Belum Ada";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-panel">
                        <div class=" accordion-heading" role="tab" id="headingThree">
                            <h3 class="card-title accordion-title">
                                <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <dt>C. Biling Transaksi</dt>
                                </a>
                            </h3>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" style="">
                            <div class="accordion-content accordion-desc">
                                <p>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-center">
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>