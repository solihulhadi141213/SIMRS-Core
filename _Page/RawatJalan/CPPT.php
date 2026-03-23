<?php
    include "_Config/SimrsFunction.php"; 
    //Tangkap ID
    if(empty($_GET['id'])){
        echo '<span class="text-danger">Belum Ada Data Kunjungan Yang Dipilih</span>';
    }else{
        $id_kunjungan=$_GET['id'];
        if(empty($_SESSION['UrlBackCPPT'])){
            $UrlBack='index.php?Page=RawatJalan&Sub=DetailKunjungan&id='.$id_kunjungan.'';
        }else{
            $UrlBack=$_SESSION['UrlBackCPPT'];
        }
        $id_encounter=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_encounter');
        $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
        $no_antrian=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'no_antrian');
        $nik=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'nik');
        $no_bpjs=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'no_bpjs');
        $sep=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'sep');
        $noRujukan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'noRujukan');
        $skdp=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'skdp');
        $nama=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'nama');
        $tanggal=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'tanggal');
        $propinsi=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'propinsi');
        $kabupaten=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'kabupaten');
        $kecamatan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'kecamatan');
        $desa=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'desa');
        $alamat=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'alamat');
        $keluhan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'keluhan');
        $tujuan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'tujuan');
        $id_dokter=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_dokter');
        $dokter=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'dokter');
        $id_poliklinik=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_poliklinik');
        $poliklinik=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'poliklinik');
        $kelas=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'kelas');
        $ruangan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'ruangan');
        $id_kasur=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_kasur');
        $DiagAwal=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'DiagAwal');
        $rujukan_dari=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'rujukan_dari');
        $rujukan_ke=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'rujukan_ke');
        $pembayaran=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'pembayaran');
        $cara_keluar=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'cara_keluar');
        $tanggal_keluar=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'tanggal_keluar');
        $status=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'status');
        $id_akses=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_akses');
        $nama_petugas=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'nama_petugas');
        $updatetime=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'updatetime');
?>
    <input type="hidden" name="GetIdKunjunganCppt" id="GetIdKunjunganCppt" value="<?php echo "$id_kunjungan"; ?>">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <h4>
                                                <i class="ti ti-info-alt"></i> Catatan Perkembangan Pasien Terintegrasi (CPPT)
                                            </h4>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <a href="<?php echo $UrlBack;?>" class="btn btn-sm btn-block btn-secondary">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-dark" id="ListCPPT">
                                                    <i class="icofont-list"></i> List
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-dark" id="TambahCPPT">
                                                    <i class="ti ti-plus"></i> Tambah
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalDetailInfoKunjungan" data-id="<?php echo "$id_kunjungan"; ?>">
                                                    <i class="ti ti-layers"></i> Info
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalCetakCpptAll" data-id="<?php echo "$id_kunjungan"; ?>">
                                                    <i class="ti ti-printer"></i> Cetak
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" id="KontenCPPT">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>