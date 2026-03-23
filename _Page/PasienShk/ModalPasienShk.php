<!--- Modal Tambah Pasien SHK---->
<div class="modal fade" id="ModalTambahPasienShk" tabindex="-1" role="dialog" aria-labelledby="ModalTambahPasienShk" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Pasien SHK</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        Untuk menambahkan pasien SHK, persiapkan data berikut ini:<br>
                        <ol>
                            <li>
                                Identias ibu (NIK, Nama dan No.RM)
                            </li>
                            <li>
                                Identias anak (NIK, Nama dan No.RM) apabila belum punya nik dan nama boleh dikosongkan
                            </li>
                            <li>
                                Tanggal pelaporan, pengiriman sample dan tanggal penerimaan sample (Apabila belum ada boleh dikosongkan)
                            </li>
                            <li>
                                Apabila data laporan sudah lengkap, anda bisa langsung mengirim ke SIRS online dengan memilih cheklist update ke SIRS online.
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="index.php?Page=PasienShk&Sub=TambahPasienShk" class="btn btn-sm btn-primary mt-2 ml-2">
                    <i class="ti ti-arrow-circle-right"></i> Lanjutkan
                </a>
                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Cari Faskes---->
<div class="modal fade" id="ModalCariFaskes" tabindex="-1" role="dialog" aria-labelledby="ModalCariFaskes" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-search"></i> Cari Faskes</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesCariFaskes">
                    <input type="hidden" name="tipe_faskes_ppk" id="tipe_faskes_ppk" class="form-control">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="KeywordPencarianPpk">Nama/Kode Faskes</label>
                            <div class="input-group">
                                <input type="text" name="KeywordPencarianPpk" id="KeywordPencarianPpk" class="form-control">
                                <button type="submit" class="btn btn-sm btn-info">
                                    <i class="ti-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="ListFaskes">

                        </div>
                    </div>   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Cari Pasien Ibu---->
<div class="modal fade" id="ModalCariPasienIbu" tabindex="-1" role="dialog" aria-labelledby="ModalCariPasienIbu" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-search"></i> Cari Pasien Ibu</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesCariPasienIbu">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="KeywordPencarianPasienIbu">Kata Kunci Pencarian</label>
                            <div class="input-group">
                                <input type="text" name="KeywordPencarianPasienIbu" id="KeywordPencarianPasienIbu" class="form-control" placeholder="Nama/No.RM/NIK">
                                <button type="submit" class="btn btn-sm btn-info">
                                    <i class="ti-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="ListPasienIbu">
                        <!-- List Pasien Ibu -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Cari Pasien Anak---->
<div class="modal fade" id="ModalCariPasienAnak" tabindex="-1" role="dialog" aria-labelledby="ModalCariPasienAnak" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-search"></i> Cari Pasien Anak</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesCariPasienAnak">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="KeywordPencarianPasienAnak">Kata Kunci Pencarian</label>
                            <div class="input-group">
                                <input type="text" name="KeywordPencarianPasienAnak" id="KeywordPencarianPasienAnak" class="form-control" placeholder="Nama/No.RM/NIK">
                                <button type="submit" class="btn btn-sm btn-info">
                                    <i class="ti-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="ListPasienAnak">
                        <!-- List Pasien Anak -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Cek Alamat Pasien---->
<div class="modal fade" id="ModalCekAlamatPasien" tabindex="-1" role="dialog" aria-labelledby="ModalCekAlamatPasien" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Cek Alamat Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormInformasiAlamatPasien">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <!-- Menampilkan Informasi Alamat Pasien Disini -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Pasien SHK SIRS Online---->
<div class="modal fade" id="ModalDetailPasienShkSirsOnline" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPasienShkSirsOnline" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Pasien SHK (SIRS Online)</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailPasienShkSirsOnline">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <!-- Menampilkan Informasi Pasien SHK SIRS Online Disini -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Detail Pasien SHK---->
<div class="modal fade" id="ModalDetailPasienShk" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPasienShk" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Pasien SHK</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FormDetailPasienShk">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <!-- Menampilkan Informasi Pasien SHK Disini -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!--- Modal Edit Pasien SHK---->
<div class="modal fade" id="ModalEditPasienShk" tabindex="-1" role="dialog" aria-labelledby="ModalEditPasienShk" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="index.php" method="GET">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Edit Pasien SHK</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="Sub" value="EditPasienShk">
                    <input type="hidden" name="Page" value="PasienShk">
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormEditPasienShk">
                            <!-- Menampilkan Form Edit Pasien SHK Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"  class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-close"></i> Ya, Lanjutkan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Pasien SHK---->
<div class="modal fade" id="ModalHapusPasienShk" tabindex="-1" role="dialog" aria-labelledby="ModalHapusPasienShk" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusPasienShk">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Pasien SHK</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" >
                    <div class="row mb-3">
                        <div class="col-md-12" id="FormHapusPasienShk">
                            <!-- Konfirmasi Hapus Pasien SHK Disini -->
                        </div>
                    </div>
                    <div class="row mb-3"> 
                        <div class="col col-md-12" id="NotifikasiHapusPasienShk">
                            Pastikan anda memilih data yang benar untuk dihapus.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Tambah Hasil Lab Pasien SHK---->
<div class="modal fade" id="ModalTambahLabShk" tabindex="-1" role="dialog" aria-labelledby="ModalTambahLabShk" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahLabShk">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-plus"></i> Tambah Hasil Lab Pasien SHK</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3"> 
                        <div class="col col-md-4">
                            <label for="id_shk">ID SHK</label>
                        </div>
                        <div class="col col-md-8 text-left">
                            <input type="text" readonly class="form-control" name="id_shk" id="put_id_shk">
                        </div>
                    </div>
                    <div class="row mb-3"> 
                        <div class="col col-md-4">
                            <label for="id_shk">Jenis Pmeriksaan</label>
                        </div>
                        <div class="col col-md-8">
                            <select name="jenis_pemeriksaan" id="jenis_pemeriksaan" class="form-control">
                                <option value="">Pilih</option>
                                <option value="1">Pemeriksaan TSH</option>
                                <option value="2">Pemeriksaan Tes Konfirmasi</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3"> 
                        <div class="col col-md-4">
                            <label for="hasil_pemeriksaan">Hasil Pmeriksaan</label>
                        </div>
                        <div class="col col-md-8" id="FormHasilPemeriksaan">
                            <select name="hasil_pemeriksaan" id="hasil_pemeriksaan" class="form-control">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3"> 
                        <div class="col col-md-4">
                            <label for="layak_sampel">Layak Sample</label>
                        </div>
                        <div class="col col-md-8">
                            <select name="layak_sampel" id="layak_sampel" class="form-control">
                                <option value="">Pilih</option>
                                <option value="1">Sample Riject</option>
                                <option value="2">Sample Layak Diperiksa</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3"> 
                        <div class="col col-md-4">
                            <label for="tgl_periksa">Tgl. Periksa</label>
                        </div>
                        <div class="col col-md-8">
                            <input type="date" class="form-control" name="tgl_periksa" id="tgl_periksa" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="row mb-3"> 
                        <div class="col col-md-4">
                            <label for="tgl_hasil">Tgl. Hasil</label>
                        </div>
                        <div class="col col-md-8">
                            <input type="date" class="form-control" name="tgl_hasil" id="tgl_hasil" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="row mb-3"> 
                        <div class="col col-md-4">
                            <label for="tgl_terima">Tgl. Terima</label>
                        </div>
                        <div class="col col-md-8">
                            <input type="date" class="form-control" name="tgl_terima" id="tgl_terima" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="row mb-3"> 
                        <div class="col col-md-4">
                            <label for="tgllapor">Tgl. Lapor</label>
                        </div>
                        <div class="col col-md-4">
                            <input type="date" class="form-control" name="tgllapor" id="tgllapor" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col col-md-4">
                            <input type="time" class="form-control" name="jamlapor" id="jamlapor" value="<?php echo date('H:i'); ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiTambahHasilLabPasienShk">
                            Pastikan Bahwa Data Hasil Lab Yang Anda Input Sudah Benar
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Hapus Lab Pasien SHK---->
<div class="modal fade" id="ModalHapusLabPasienShk" tabindex="-1" role="dialog" aria-labelledby="ModalHapusLabPasienShk" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusLabPasienShk">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-trash"></i> Hapus Lab Pasien SHK</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" >
                    <div class="row mb-3">
                        <div class="col-md-12 text-center" id="FormHapusLabPasienShk">
                            <!-- Konfirmasi Hapus Lab Pasien SHK Disini -->
                        </div>
                    </div>
                    <div class="row mb-3"> 
                        <div class="col col-md-12 text-center" id="NotifikasiHapusLabPasienShk">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Edit Hasil Lab Pasien SHK---->
<div class="modal fade" id="ModalEditLabPasienShk" tabindex="-1" role="dialog" aria-labelledby="ModalEditLabPasienShk" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditLabPasienShk">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti ti-pencil"></i> Edit Hasil Lab Pasien SHK</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="FormEditLabPasienShk">
                        <!-- Form Edit Lab Pasien Shk -->
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            Pastikan Bahwa Data Hasil Lab Yang Anda Input Sudah Benar
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" id="NotifikasiEditHasilLabPasienShk">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary mt-2 ml-2">
                        <i class="ti-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Detail Pasien By RM---->
<div class="modal fade" id="ModalDetailPasienByRm" tabindex="-1" role="dialog" aria-labelledby="ModalDetailPasienByRm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b cass="text-dark"><i class="ti ti-info-alt"></i> Detail Pasien</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="FormDetailPasienByRm">
                    <!-- Form Detail Pasien By RM -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>