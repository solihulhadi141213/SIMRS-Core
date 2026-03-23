<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <?php
                            if(empty($_GET['id'])){
                                echo '  <div class="card table-card">';
                                echo '      <div class="row">';
                                echo '          <div class="col-md-12 text-center text-danger">';
                                echo '              ID Permintaan Lab Tidak Boleh Kosong!';
                                echo '          </div>';
                                echo '      </div>';
                                echo '  </div>';
                            }else{
                                if(empty($_GET['SignatureName'])){
                                    echo '  <div class="card table-card">';
                                    echo '      <div class="row">';
                                    echo '          <div class="col-md-12 text-center text-danger">';
                                    echo '              Nama Pihak Yang menandatangani Tidak Boleh Kosong!';
                                    echo '          </div>';
                                    echo '      </div>';
                                    echo '  </div>';
                                }else{
                                    $id_permintaan=$_GET['id'];
                                    $SignatureName=$_GET['SignatureName'];
                                    if(empty(getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'id_permintaan'))){
                                        echo '  <div class="card table-card">';
                                        echo '      <div class="row">';
                                        echo '          <div class="col-md-12 text-center text-danger">';
                                        echo '              ID Permintaan Pemeriksaan Lab Tidak Valid Atau Tidak Ada Pada Database!';
                                        echo '          </div>';
                                        echo '      </div>';
                                        echo '  </div>';
                                    }else{
                                        //Apakah Data Laboratorium Ada?
                                        $dokter_interpertasi=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'dokter_interpertasi');
                                        $dokter_validator=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'dokter_validator');
                                        $petugas_analis=getDataDetail($Conn,'laboratorium_pemeriksaan','id_permintaan',$id_permintaan,'petugas_analis');
                                        if($SignatureName=='sig_dokter_intr'){
                                            $NamaPenandatangan=$dokter_interpertasi;
                                        }
                                        if($SignatureName=='sig_dokter_validator'){
                                            $NamaPenandatangan=$dokter_validator;
                                        }
                                        if($SignatureName=='sig_petugas_analis'){
                                            $NamaPenandatangan=$petugas_analis;
                                        }
                        ?>
                        <form action="javascript:void(0);" id="ProsesVerifikasiLaboratorium">
                            <input type="hidden" id="GetIdPermintaan" name="GetIdPermintaan" value="<?php echo "$id_permintaan";?>">
                            <input type="hidden" id="SignatureName" name="SignatureName" value="<?php echo "$SignatureName"; ?>">
                            <div class="card table-card">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-10 mb-3">
                                            <h4 class="text-dark">
                                                <i class="icofont-prescription"></i> Form Verifikasi Hasil Analisis Laboratorium
                                            </h4>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <a href="index.php?Page=Laboratorium&Sub=DetailPermintaanLab&id=<?php echo "$id_permintaan";?>" class="btn btn-md btn-block btn-secondary" title="Kembali Ke Halaman Detail Permintaan Laboratorium">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    Saya atas nama <dt><?php echo $NamaPenandatangan;?></dt> pada hari ini tanggal <i><?php echo date('Y-m-d');?></i> 
                                                    telah menandatangani dokumen digital berupa <i>Hasil Pemeriksaan Laboratorium</i> dengan ID <i><?php echo $id_permintaan;?></i>--
                                                    dengan ketentuan sebagai berikut:
                                                    <p>
                                                        <ol>
                                                            <li>
                                                                Saya menyatakan bahwa tanda tangan digital ini sah dan sahih, 
                                                                karena memenuhi persyaratan hukum yang berlaku untuk tanda 
                                                                tangan elektronik sesuai dengan undang-undang yang berlaku di negara ini.
                                                            </li>
                                                            <li>
                                                                Saya mengakui bahwa data yang disajikan dalam dokumen ini adalah valid 
                                                                dan akurat berdasarkan analisa dan verifikasi yang dilakukan. 
                                                                Data tersebut telah dikumpulkan dari sumber yang terpercaya dan diperiksa 
                                                                untuk kesalahan atau ketidaksesuaian sebelum disajikan.
                                                            </li>
                                                            <li>
                                                                Tanda tangan digital ini telah dihasilkan menggunakan proses tanda tangan secara digital pada layar sebagai --
                                                                pengakuan yang sah atas dokumen dan dapat diverifikasi secara independen.
                                                            </li>
                                                        </ol>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="row mb-4">
                                                <div class="col-md-12">
                                                    <label for="signature"><dt>Tanda Tangan Disini</dt></label>
                                                    <canvas id="signature-pad" class="signature-pad" width="100%">
                                                        <!-- Konten Tanda Tangan Disimpan Disini -->
                                                    </canvas>
                                                </div>
                                                <div class="col-md-12 text-center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-outline-dark" id="change-color" title="Ubah Warna Tinta">
                                                            <span class="ti-palette"></span>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-dark" id="undo" title="Undo">
                                                            <span class="ti-back-left"></span>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-dark" id="clear" title="Batalkan Semua">
                                                            <span class="ti-eraser"></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="row mb-4">
                                        <div class="col-md-12" id="NotifikasiVerifikasiLaboratorium">
                                            <span class="text-primary">Pastikan Anda Telah Membaca Ketentuan Dan Berkas Yang Berkaitan Dengan Tanda Tangan Ini</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-md btn-primary mb-3">
                                        <i class="ti ti-save"></i> Simpan
                                    </button>
                                    <button type="reset" class="btn btn-md btn-inverse mb-3">
                                        <i class="ti ti-reload"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </form>
                        <?php }}} ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>