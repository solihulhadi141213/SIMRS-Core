<?php
    //Koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
?>
<div class="card">
    <form action="javascript:void(0);" id="ProsesCariSuratKontrol">
        <div class="card-header border-info">
            <div class="row mt-2 mb-2"> 
                <div class="col-md-3 mt-2">
                    <small for="tanggal1">Tanggal Awal</small>
                    <input type="date" name="tanggal1" id="tanggal1" class="form-control form-control-lg" required>
                </div>
                <div class="col-md-3 mt-2">
                    <small for="tanggal2">Tanggal Akhir</small>
                    <input type="date" name="tanggal2" id="tanggal2" class="form-control form-control-lg" required>
                </div>
                <div class="col-md-4 mt-3">
                    <select name="FormatFilter" id="FormatFilter" class="form-control form-control-default form-control-sm">
                        <option value="1">Tanggal Entry</option>
                        <option value="2">Tanggal Rencana Kontrol</option>
                    </select>
                </div>
                <div class="col-md-2 mt-3">
                    <button type="submit" class="btn btn-md btn-outline-dark"><i class="icofont-search-2"></i> Tampilkan</button>
                </div>
            </div>
        </div>
    </form>
    <div class="card-body">
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 mt-3">
                <div class="table table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center"><dt>No</dt></th>
                                <th class="text-center"><dt>No.Surat</dt></th>
                                <th class="text-center"><dt>Kategori</dt></th>
                                <th class="text-center"><dt>Tanggal</dt></th>
                                <th class="text-center"><dt>Poli</dt></th>
                                <th class="text-center"><dt>Dokter</dt></th>
                            </tr>
                        </thead>
                        <tbody id="MenampilkanPencarianSuratKontrol">
                            <tr>
                                <td class="text-center" colspan="7">
                                    <dt>Keterangan :</dt>
                                    Belum ada data hasil pencarian yang bisa ditampilkan
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>