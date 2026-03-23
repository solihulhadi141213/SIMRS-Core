<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_radiologi_file
    if(empty($_POST['id_permintaan'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center mb-3">';
        echo '         ID Permintaan Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_permintaan=$_POST['id_permintaan'];
        $id_pasien=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'id_pasien');
        $id_kunjungan=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'id_kunjungan');
        $id_dokter=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'id_dokter');
        $tujuan=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'tujuan');
        $nama_pasien=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'nama_pasien');
        $nama_dokter=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'nama_dokter');
        $tanggal=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'tanggal');
        $faskes=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'faskes');
        $unit=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'unit');
        $prioritas=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'prioritas');
        $diagnosis=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'diagnosis');
        $keterangan_permintaan=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'keterangan_permintaan');
        $nama_signature=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'nama_signature');
        $signature=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'signature');
        $status=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'status');
        $keterangan_status=getDataDetail($Conn,'laboratorium_permintaan','id_permintaan',$id_permintaan,'keterangan_status');
?>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mb-4  table table-responsive pre-scrollable">
                <table  class="table table-hover">
                    <tbody>
                        <tr>
                            <td><dt>No.RM/ID.REG</dt></td>
                            <td><dt>:</dt></td>
                            <td><?php echo "$id_pasien/$id_kunjungan";?></td>
                        </tr>
                        <tr>
                            <td><dt>Tanggal</dt></td>
                            <td><dt>:</dt></td>
                            <td><?php echo "$tanggal";?></td>
                        </tr>
                        <tr>
                            <td><dt>Pasien</dt></td>
                            <td><dt>:</dt></td>
                            <td><?php echo "$nama_pasien";?></td>
                        </tr>
                        <tr>
                            <td><dt>Tujuan</dt></td>
                            <td><dt>:</dt></td>
                            <td><?php echo "$tujuan";?></td>
                        </tr>
                        <tr>
                            <td><dt>Dokter</dt></td>
                            <td><dt>:</dt></td>
                            <td><?php echo "$nama_dokter";?></td>
                        </tr>
                        <tr>
                            <td><dt>Faskes</dt></td>
                            <td><dt>:</dt></td>
                            <td><?php echo "$faskes";?></td>
                        </tr>
                        <tr>
                            <td><dt>Unit</dt></td>
                            <td><dt>:</dt></td>
                            <td><?php echo "$unit";?></td>
                        </tr>
                        <tr>
                            <td><dt>Prioritas</dt></td>
                            <td><dt>:</dt></td>
                            <td><?php echo "$prioritas";?></td>
                        </tr>
                        <tr>
                            <td><dt>Diagnosis</dt></td>
                            <td><dt>:</dt></td>
                            <td><?php echo "$diagnosis";?></td>
                        </tr>
                        <tr>
                            <td><dt>Keterangan</dt></td>
                            <td><dt>:</dt></td>
                            <td><?php echo "$keterangan_permintaan";?></td>
                        </tr>
                        <tr>
                            <td><dt>Status</dt></td>
                            <td><dt>:</dt></td>
                            <td><?php echo "$status";?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><dt>:</dt></td>
                            <td><?php echo "$keterangan_status";?></td>
                        </tr>
                        <tr>
                            <td><dt>Pemohon</dt></td>
                            <td><dt>:</dt></td>
                            <td><?php echo "$nama_signature";?></td>
                        </tr>
                        <tr>
                            <td colspan="3"><img src="<?php echo 'data:image/png;base64,' . $signature . ''; ?>" width="100%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-info">
        <div class="btn-group dropdown-split-inverse">
            <button type="button" class="btn btn-md btn-primary dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                <i class="ti ti-settings"></i> Option
            </button>
            <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                <a class="dropdown-item waves-effect waves-light" href="index.php?Page=Laboratorium&Sub=DetailPermintaanLab&id=<?php echo "$id_permintaan"; ?>">
                    <i class="ti ti-info-alt"></i> Selengkapnya
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item waves-effect waves-light" href="index.php?Page=Laboratorium&Sub=EditPermintaanLab&id=<?php echo "$id_permintaan"; ?>">
                    <i class="ti-pencil"></i> Edit
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusPermintaan" data-id="<?php echo "$id_permintaan"; ?>">
                    <i class="ti-trash"></i> Hapus
                </a>
            </div>
        </div>
        <button type="button" class="btn btn-md btn-inverse" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>