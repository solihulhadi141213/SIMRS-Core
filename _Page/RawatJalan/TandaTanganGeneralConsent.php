<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <?php
                    include "_Config/SimrsFunction.php"; 
                    if(empty($_GET['id_kunjungan'])){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12">';
                        echo '      <div class="card">';
                        echo '          <div class="card-body text-danger text-center">';
                        echo '              ID Kunjungan Tidak Boleh Kosong';
                        echo '          </div>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        if(empty($_GET['kategori'])){
                            echo '<div class="row">';
                            echo '  <div class="col-md-12">';
                            echo '      <div class="card">';
                            echo '          <div class="card-body text-danger text-center">';
                            echo '              Kategori Tanda Tangan General Consent Tidak Boleh Kosong';
                            echo '          </div>';
                            echo '      </div>';
                            echo '  </div>';
                            echo '</div>';
                        }else{
                            $id_kunjungan=$_GET['id_kunjungan'];
                            $kategori=$_GET['kategori'];
                            //Validasi Data
                            $id_kunjungan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_kunjungan');
                            if(empty($id_kunjungan)){
                                echo '<div class="row">';
                                echo '  <div class="col-md-12">';
                                echo '      <div class="card">';
                                echo '          <div class="card-body text-danger text-center">';
                                echo '              ID Kunjungan Tidak Valid/Tidak Terdaftar Pada Database Kunjungan';
                                echo '          </div>';
                                echo '      </div>';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <form action="javascript:void(0);" id="ProsesTandaTanganGeneralConsent" autocomplete="off">
                            <input type="hidden" name="id_kunjungan" id="id_kunjungan" value="<?php echo "$id_kunjungan"; ?>">
                            <input type="hidden" name="KategoriTandaTangan" id="KategoriTandaTangan" value="<?php echo "$kategori"; ?>">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-10 mb-2">
                                            <h4>
                                                <i class="ti ti-plus"></i> Form Tanda Tangan General Consent
                                            </h4>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <a href="index.php?Page=RawatJalan&Sub=DetailKunjungan&id=<?php echo $id_kunjungan;?>" class="btn btn-sm btn-secondary btn-block">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" id="FormSignaturePadGeneralConsent">
                                    <div class="row mb-3 mt-3">
                                        <div class="col-md-6">
                                            <?PHP
                                                if($kategori=="Petugas"){
                                                    //Membuka Detail Petugas
                                                    $id_general_consent=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'id_general_consent');
                                                    $tanggal=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'tanggal');
                                                    $nama_petugas=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'nama_petugas');
                                                    $JsonPetugas =json_decode($nama_petugas, true);
                                                    $NamaPetugas=$JsonPetugas['nama'];
                                                    $NikPetugas=$JsonPetugas['nik'];
                                                    $KontakPetugas=$JsonPetugas['kontak'];
                                                    $AlamatPetugas=$JsonPetugas['alamat'];
                                                    echo '      <div class="row mt-3">';
                                                    echo '          <div class="col col-md-12 mb-2"><dt>A. Informasi Dokumen</dt></div>';
                                                    echo '      </div>';
                                                    echo '      <div class="row">';
                                                    echo '          <div class="col col-md-6 mb-2">1. Nama Dokumen</div>';
                                                    echo '          <div class="col col-md-6 mb-2">General Consent</div>';
                                                    echo '      </div>';
                                                    echo '      <div class="row">';
                                                    echo '          <div class="col col-md-6 mb-2">2. ID Dokumen</div>';
                                                    echo '          <div class="col col-md-6 mb-2">'.$id_general_consent.'</div>';
                                                    echo '      </div>';
                                                    echo '      <div class="row">';
                                                    echo '          <div class="col col-md-6 mb-2">3. Tanggal</div>';
                                                    echo '          <div class="col col-md-6 mb-2">'.$tanggal.'</div>';
                                                    echo '      </div>';
                                                    echo '      <div class="row mt-3">';
                                                    echo '          <div class="col col-md-12 mb-2"><dt>B. Informasi Pihak Yang Menandatangani Dokumen</dt></div>';
                                                    echo '      </div>';
                                                    echo '      <div class="row">';
                                                    echo '          <div class="col col-md-6 mb-2">1. Nama</div>';
                                                    echo '          <div class="col col-md-6 mb-2">'.$NamaPetugas.'</div>';
                                                    echo '      </div>';
                                                    echo '      <div class="row">';
                                                    echo '          <div class="col col-md-6 mb-2">2. NIK</div>';
                                                    echo '          <div class="col col-md-6 mb-2">'.$NikPetugas.'</div>';
                                                    echo '      </div>';
                                                    echo '      <div class="row">';
                                                    echo '          <div class="col col-md-6 mb-2">3. Kontak</div>';
                                                    echo '          <div class="col col-md-6 mb-2">'.$KontakPetugas.'</div>';
                                                    echo '      </div>';
                                                    echo '      <div class="row">';
                                                    echo '          <div class="col col-md-6 mb-2">4. Alamat</div>';
                                                    echo '          <div class="col col-md-6 mb-2">'.$AlamatPetugas.'</div>';
                                                    echo '      </div>';
                                                }else{
                                                    if($kategori=="Penanggung Jawab"){
                                                        //Membuka Detail Petugas
                                                        $id_general_consent=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'id_general_consent');
                                                        $tanggal=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'tanggal');
                                                        $penanggung_jawab=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'penanggung_jawab');
                                                        $JsonPenanggungJawab =json_decode($penanggung_jawab, true);
                                                        $NamaPenanggungJawab=$JsonPenanggungJawab['nama'];
                                                        $NikPenanggungJawab=$JsonPenanggungJawab['nik'];
                                                        $KontakPenanggungJawab=$JsonPenanggungJawab['kontak'];
                                                        $AlamatPenanggungJawab=$JsonPenanggungJawab['alamat'];
                                                        echo '      <div class="row mt-3">';
                                                        echo '          <div class="col col-md-12 mb-2"><dt>A. Informasi Dokumen</dt></div>';
                                                        echo '      </div>';
                                                        echo '      <div class="row">';
                                                        echo '          <div class="col col-md-6 mb-2">1. Nama Dokumen</div>';
                                                        echo '          <div class="col col-md-6 mb-2">General Consent</div>';
                                                        echo '      </div>';
                                                        echo '      <div class="row">';
                                                        echo '          <div class="col col-md-6 mb-2">2. ID Dokumen</div>';
                                                        echo '          <div class="col col-md-6 mb-2">'.$id_general_consent.'</div>';
                                                        echo '      </div>';
                                                        echo '      <div class="row">';
                                                        echo '          <div class="col col-md-6 mb-2">3. Tanggal</div>';
                                                        echo '          <div class="col col-md-6 mb-2">'.$tanggal.'</div>';
                                                        echo '      </div>';
                                                        echo '      <div class="row mt-3">';
                                                        echo '          <div class="col col-md-12 mb-2"><dt>B. Informasi Pihak Yang Menandatangani Dokumen</dt></div>';
                                                        echo '      </div>';
                                                        echo '      <div class="row">';
                                                        echo '          <div class="col col-md-6 mb-2">1. Nama</div>';
                                                        echo '          <div class="col col-md-6 mb-2">'.$NamaPenanggungJawab.'</div>';
                                                        echo '      </div>';
                                                        echo '      <div class="row">';
                                                        echo '          <div class="col col-md-6 mb-2">2. NIK</div>';
                                                        echo '          <div class="col col-md-6 mb-2">'.$NikPenanggungJawab.'</div>';
                                                        echo '      </div>';
                                                        echo '      <div class="row">';
                                                        echo '          <div class="col col-md-6 mb-2">3. Kontak</div>';
                                                        echo '          <div class="col col-md-6 mb-2">'.$KontakPenanggungJawab.'</div>';
                                                        echo '      </div>';
                                                        echo '      <div class="row">';
                                                        echo '          <div class="col col-md-6 mb-2">4. Alamat</div>';
                                                        echo '          <div class="col col-md-6 mb-2">'.$AlamatPenanggungJawab.'</div>';
                                                        echo '      </div>';
                                                    }
                                                }
                                            ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="signature-pad">Tanda Tangan Disini</label>
                                            <canvas id="signature-pad" class="signature-pad" width="100%">
                                                <!-- Menampilkan signature pad disini -->
                                            </canvas>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12" id="NotifikasiTandaTanganGeneralConsent">
                                            <span class="text-primary">
                                                <dt>Keterangan : </dt> Dengan menandatangani dokumen ini maka anda mengakui validitas informasi yang ada di dalamnya.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="ti-save"></i> Simpan Tanda Tangan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php }}} ?>
            </div>
        </div>
    </div>
</div>