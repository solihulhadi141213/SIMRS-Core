<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'APzGdlAT7w');
    if($StatusAkses=="Yes"){
        include "_Config/SimrsFunction.php";
        include "_Config/FungsiSirsOnline.php";
        //Buka Pengaturan SIRS Online
        $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
        $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
        $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
?>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <form action="javascript:void(0);" id="ProsesTambahPcrNakes">
                                <div class="card mb-2">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-10 mb-3">
                                                <h4>
                                                    <i class="icofont-search-document"></i> Form Tambah Laporan PCR Nakes
                                                </h4>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <a href="index.php?Page=SirsOnline&Sub=PcrNakes" type="button" class="btn btn-block btn-secondary btn-primary">
                                                    <i class="ti ti-angle-left"></i> Kembali
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="tanggal_laporan">Tanggal</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="date" name="tanggal_laporan" id="tanggal_laporan" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <dt>Dokter Umum</dt>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="jumlah_tenaga_dokter_umum">Jumlah</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="jumlah_tenaga_dokter_umum" id="jumlah_tenaga_dokter_umum" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="sudah_periksa_dokter_umum">Diperiksa</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="sudah_periksa_dokter_umum" id="sudah_periksa_dokter_umum" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="hasil_pcr_dokter_umum">Hasil PCR</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="hasil_pcr_dokter_umum" id="hasil_pcr_dokter_umum" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <dt>Dokter Spesialis</dt>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="jumlah_tenaga_dokter_spesialis">Jumlah</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="jumlah_tenaga_dokter_spesialis" id="jumlah_tenaga_dokter_spesialis" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="sudah_periksa_dokter_spesialis">Diperiksa</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="sudah_periksa_dokter_spesialis" id="sudah_periksa_dokter_spesialis" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="hasil_pcr_dokter_spesialis">Hasil PCR</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="hasil_pcr_dokter_spesialis" id="hasil_pcr_dokter_spesialis" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <dt>Dokter Gigi</dt>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="jumlah_tenaga_dokter_gigi">Jumlah</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="jumlah_tenaga_dokter_gigi" id="jumlah_tenaga_dokter_gigi" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="sudah_periksa_dokter_gigi">Diperiksa</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="sudah_periksa_dokter_gigi" id="sudah_periksa_dokter_gigi" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="hasil_pcr_dokter_gigi">Hasil PCR</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="hasil_pcr_dokter_gigi" id="hasil_pcr_dokter_gigi" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <dt>Tenaga Residen</dt>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="jumlah_tenaga_residen">Jumlah</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="jumlah_tenaga_residen" id="jumlah_tenaga_residen" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="sudah_periksa_residen">Diperiksa</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="sudah_periksa_residen" id="sudah_periksa_residen" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="hasil_pcr_residen">Hasil PCR</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="hasil_pcr_residen" id="hasil_pcr_residen" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <dt>Tenaga Perawat</dt>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="jumlah_tenaga_perawat">Jumlah</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="jumlah_tenaga_perawat" id="jumlah_tenaga_perawat" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="sudah_periksa_perawat">Diperiksa</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="sudah_periksa_perawat" id="sudah_periksa_perawat" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="hasil_pcr_perawat">Hasil PCR</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="hasil_pcr_perawat" id="hasil_pcr_perawat" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <dt>Bidan</dt>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="jumlah_tenaga_bidan">Jumlah</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="jumlah_tenaga_bidan" id="jumlah_tenaga_bidan" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="sudah_periksa_bidan">Diperiksa</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="sudah_periksa_bidan" id="sudah_periksa_bidan" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="hasil_pcr_bidan">Hasil PCR</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="hasil_pcr_bidan" id="hasil_pcr_bidan" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <dt>Apoteker</dt>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="jumlah_tenaga_apoteker">Jumlah</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="jumlah_tenaga_apoteker" id="jumlah_tenaga_apoteker" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="sudah_periksa_apoteker">Diperiksa</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="sudah_periksa_apoteker" id="sudah_periksa_apoteker" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="hasil_pcr_apoteker">Hasil PCR</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="hasil_pcr_apoteker" id="hasil_pcr_apoteker" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <dt>Radiografer</dt>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="jumlah_tenaga_radiografer">Jumlah</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="jumlah_tenaga_radiografer" id="jumlah_tenaga_radiografer" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="sudah_periksa_radiografer">Diperiksa</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="sudah_periksa_radiografer" id="sudah_periksa_radiografer" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="hasil_pcr_radiografer">Hasil PCR</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="hasil_pcr_radiografer" id="hasil_pcr_radiografer" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <dt>Analis Lab</dt>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="jumlah_tenaga_analis_lab">Jumlah</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="jumlah_tenaga_analis_lab" id="jumlah_tenaga_analis_lab" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="sudah_periksa_analis_lab">Diperiksa</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="sudah_periksa_analis_lab" id="sudah_periksa_analis_lab" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="hasil_pcr_analis_lab">Hasil PCR</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="hasil_pcr_analis_lab" id="hasil_pcr_analis_lab" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <dt>Co Ass</dt>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="jumlah_tenaga_co_ass">Jumlah</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="jumlah_tenaga_co_ass" id="jumlah_tenaga_co_ass" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="sudah_periksa_co_ass">Diperiksa</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="sudah_periksa_co_ass" id="sudah_periksa_co_ass" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="hasil_pcr_co_ass">Hasil PCR</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="hasil_pcr_co_ass" id="hasil_pcr_co_ass" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <dt>Tenaga Interenship</dt>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="jumlah_tenaga_internship">Jumlah</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="jumlah_tenaga_internship" id="jumlah_tenaga_internship" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="sudah_periksa_internship">Diperiksa</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="sudah_periksa_internship" id="sudah_periksa_internship" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="hasil_pcr_internship">Hasil PCR</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="hasil_pcr_internship" id="hasil_pcr_internship" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <dt>Tenaga Lainnya</dt>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="jumlah_tenaga_nakes_lainnya">Jumlah</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="jumlah_tenaga_nakes_lainnya" id="jumlah_tenaga_nakes_lainnya" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="sudah_periksa_nakes_lainnya">Diperiksa</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="sudah_periksa_nakes_lainnya" id="sudah_periksa_nakes_lainnya" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="hasil_pcr_nakes_lainnya">Hasil PCR</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="hasil_pcr_nakes_lainnya" id="hasil_pcr_nakes_lainnya" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <dt>Rekapitulasi</dt>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="rekap_jumlah_tenaga">Jumlah Tenaga</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="rekap_jumlah_tenaga" id="rekap_jumlah_tenaga" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="rekap_jumlah_sudah_diperiksa">Jumlah Diperiksa</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="rekap_jumlah_sudah_diperiksa" id="rekap_jumlah_sudah_diperiksa" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="rekap_jumlah_hasil_pcr">Jumlah Hasil PCR</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="rekap_jumlah_hasil_pcr" id="rekap_jumlah_hasil_pcr" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                Intergrasi SIRS Online
                                            </div>
                                            <div class="col-md-8">
                                                <input type="checkbox" id="update_sisrs_online" name="update_sisrs_online" value="Ya">
                                                <label for="update_sisrs_online">Update ke Aplikasi SIRS Online</label>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <dt>Keterangan : </dt>
                                            </div>
                                            <div class="col-md-8">
                                                <span id="NotifikasiTambahPcrNakes">Pastikan data laporan yang anda input sudah sesuai</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-md btn-primary mt-2 ml-2">
                                            <i class="ti-save"></i> Simpan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    }else{
        include "_Page/UnPage/ErrorPageSub.php";
    }
?>