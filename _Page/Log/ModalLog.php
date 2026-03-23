<!--- Modal User ---->
<div class="modal fade" id="ModalUser" tabindex="-1" role="dialog" aria-labelledby="ModalUser" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content" id="FormFilterUser">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti-filter"></i> Filter User</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <form action="javascript:void(0);" method="POST" id="ProsesFilterUser" autocomplete="off">
                    <div class="card-body border-0 pb-0">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Nama User</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="user" id="user" list="ListUser" class="form-control" required>
                                    <datalist id="ListUser">
                                        <?php
                                            $QryUser= mysqli_query($Conn, "SELECT DISTINCT nama FROM akses ORDER BY nama ASC");
                                            while ($DataUser=mysqli_fetch_array($QryUser)) {
                                                $nama = $DataUser['nama'];
                                                echo '<option value="'.$nama.'">';
                                            }
                                        ?>
                                    </datalist>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="ti-filter"></i> Filter
                                    </button>
                                </div>
                                ID: <small id="HasilCariUser"></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--- Modal Tanggal ---->
<div class="modal fade" id="ModalTanggal" tabindex="-1" role="dialog" aria-labelledby="ModalTanggal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content" id="FormFilterTanggal">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti-filter"></i> Filter Tanggal</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <form action="javascript:void(0);" method="POST" id="ProsesFilterTanggal" autocomplete="off">
                    <div class="card-body border-0 pb-0">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Tanggal</label>
                                <div class="input-group mb-3">
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="ti-filter"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--- Modal Kategori ---->
<div class="modal fade" id="ModalKategori" tabindex="-1" role="dialog" aria-labelledby="ModalKategori" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content" id="FormFilterKategori">
            <!---- Form Filter Kategori Disini------>
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti-filter"></i> Filter Kategori</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <form action="javascript:void(0);" method="POST" id="ProsesFilterKategori" autocomplete="off">
                    <div class="card-body border-0 pb-0">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Kategori</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="kategori" id="kategori" list="ListKelas" class="form-control" required>
                                    <datalist id="ListKelas">
                                        <?php
                                            $QryLogKategori= mysqli_query($Conn, "SELECT DISTINCT kategori FROM log ORDER BY kategori ASC");
                                            while ($DataLogKategori=mysqli_fetch_array($QryLogKategori)) {
                                                $DataKategoriLog = $DataLogKategori['kategori'];
                                                echo '<option value="'.$DataKategoriLog.'">';
                                            }
                                        ?>
                                    </datalist>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="ti-filter"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--- Modal Nama Log ---->
<div class="modal fade" id="ModalNamaLog" tabindex="-1" role="dialog" aria-labelledby="ModalNamaLog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content" id="FormFilterLog">
            <!---- Form Filter Log Disini------>
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti-filter"></i> Filter Keterangan</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <form action="javascript:void(0);" method="POST" id="ProsesFilterNamaLog" autocomplete="off">
                    <div class="card-body border-0 pb-0">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Keterangan Log</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="nama_log" id="nama_log" list="ListNamaLog" class="form-control" required>
                                    <datalist id="ListNamaLog">
                                        <?php
                                            $QryLogNama= mysqli_query($Conn, "SELECT DISTINCT nama_log FROM log ORDER BY nama_log ASC");
                                            while ($DataLogNama=mysqli_fetch_array($QryLogNama)) {
                                                $nama_log = $DataLogNama['nama_log'];
                                                echo '<option value="'.$nama_log.'">';
                                            }
                                        ?>
                                    </datalist>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="ti-filter"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--- Modal Cetak Log ---->
<div class="modal fade" id="ModalCetakLog" tabindex="-1" role="dialog" aria-labelledby="ModalCetakLog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-ld" role="document">
        <div class="modal-content" id="FormCetakLog">
            <!---- Form Cetak Log Disini------>
            <form action="_Page/Log/ProsesCetakLog.php" target="_blank" method="POST" utocomplete="off">
                <div class="modal-header">
                    <b cass="text-dark"><i class="ti-printer"></i> Cetak Log</b> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="">Periode Awal</label>
                                <input type="date" name="periode1" id="periode1" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="">Periode Akhir</label>
                                <input type="date" name="periode2" id="periode2" class="form-control" required>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label for="">Format</label>
                                <div class="input-group">
                                    <select name="format" id="format" class="form-control">
                                        <option value="HTML">HTML</option>
                                        <option value="Excel">Excel</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-round">
                        <i class="ti-printer"></i> Cetak
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-round" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--- Modal Filter Tabel---->
<div class="modal fade" id="ModalFilterTabel" tabindex="-1" role="dialog" aria-labelledby="ModalFilterTabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <b cass="text-light"><i class="ti-search"></i> Filter Tabel Log</b> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="FormFilterTabel">
                <!---- Form Filter Tabel Siswa ----->
            </div>
        </div>
    </div>
</div>