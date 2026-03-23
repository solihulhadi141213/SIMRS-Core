<form action="javascript:void(0);" id="ProsesSimpanAplicare">
    <div class="modal-body">
        <div class="row" >
            <div class="col-12 pre-scrollable" id="NotifikasiSimpanDataApliccare">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center"><dt>No</dt></th>
                            <th class="text-center"><dt>Kode</dt></th>
                            <th class="text-center"><dt>Kelas/Ruangan</dt></th>
                            <th class="text-center"><dt>Quota</dt></th>
                            <th class="text-center"><dt>Pria</dt></th>
                            <th class="text-center"><dt>Wanita</dt></th>
                            <th class="text-center"><dt>Bebas</dt></th>
                            <th class="text-center"><dt>Opt</dt></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //koneksi dan session
                            date_default_timezone_set('Asia/Jakarta');
                            include "../../_Config/Connection.php";
                            include "../../_Config/Session.php";
                            $no=1;
                            $query = mysqli_query($Conn, "SELECT*FROM ruang_rawat WHERE kategori='ruangan' AND status='Aktif' ORDER BY kelas ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_ruang_rawat = $data['id_ruang_rawat'];
                                $kelas = $data['kelas'];
                                $kodekelas = $data['kodekelas'];
                                $ruangan = $data['ruangan'];
                                $status = $data['status'];
                                $updatetime = $data['updatetime'];
                                //menghitung jumlah bed
                                $JumlahBedPria = mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND pria='1' AND kodekelas='$kodekelas' AND status='Aktif'"));
                                $JumlahBedWanita =mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND wanita='1' AND kodekelas='$kodekelas' AND status='Aktif'"));
                                $JumlahBedBebas =mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND bebas='1' AND kodekelas='$kodekelas' AND status='Aktif'"));
                                $JumlahTotal=mysqli_num_rows(mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND ruangan='$ruangan' AND status='Aktif'"));
                                $JumlahPasien = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE kelas='$kelas' AND status='Terdaftar'"));
                                //Menghitung Jumlah Pasien Pria
                                $TersediaBedPria=0;
                                $QryRoom1 = mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND pria='1' AND ruangan='$ruangan' AND status='Aktif' ORDER BY kelas ASC");
                                while ($DataRoom1 = mysqli_fetch_array($QryRoom1)) {
                                    $IdRoomPria = $DataRoom1['id_ruang_rawat'];
                                    //apakah ruangan tersebut ada yang isi?
                                    $ApakahDiisi1 = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE id_kasur='$IdRoomPria' AND status='Terdaftar'"));
                                    if(empty($ApakahDiisi1)){
                                        $JumlahPasienPriatersedia=1;
                                    }else{
                                        $JumlahPasienPriatersedia=0;
                                    }
                                    $TersediaBedPria=$TersediaBedPria+$JumlahPasienPriatersedia;
                                }
                                //Menghitung Jumlah Pasien Wanita
                                $TersediaBedWanita=0;
                                $QryRoom2= mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND wanita='1' AND ruangan='$ruangan' AND status='Aktif' ORDER BY kelas ASC");
                                while ($DataRoom2 = mysqli_fetch_array($QryRoom2)) {
                                    $IdRoomWanita = $DataRoom2['id_ruang_rawat'];
                                    //apakah ruangan tersebut ada yang isi?
                                    $ApakahDiisi2 = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE id_kasur='$IdRoomWanita' AND status='Terdaftar'"));
                                    if(empty($ApakahDiisi2)){
                                        $JumlahPasienWanitatersedia=1;
                                    }else{
                                        $JumlahPasienWanitatersedia=0;
                                    }
                                    $TersediaBedWanita=$TersediaBedWanita+$JumlahPasienWanitatersedia;
                                }
                                //Menghitung Jumlah Pasien Bebas
                                $TersediaBedBebas=0;
                                $QryRoom3= mysqli_query($Conn, "SELECT id_ruang_rawat FROM ruang_rawat WHERE kategori='bed' AND bebas='1' AND ruangan='$ruangan' AND status='Aktif' ORDER BY kelas ASC");
                                while ($DataRoom3 = mysqli_fetch_array($QryRoom3)) {
                                    $IdRoomBebas= $DataRoom3['id_ruang_rawat'];
                                    //apakah ruangan tersebut ada yang isi?
                                    $ApakahDiisi3 = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE id_kasur='$IdRoomBebas' AND status='Terdaftar'"));
                                    if(empty($ApakahDiisi3)){
                                        $JumlahPasienBebasTersedia=1;
                                    }else{
                                        $JumlahPasienBebasTersedia=0;
                                    }
                                    $TersediaBedBebas=$TersediaBedBebas+$JumlahPasienBebasTersedia;
                                }
                                echo '<tr>';
                                echo '  <td class="text-center">'.$no.'</td>';
                                echo '  <td class="text-left">'.$kodekelas.'</td>';
                                echo '  <td class="text-left">'.$ruangan.'</td>';
                                echo '  <td class="text-left">'.$JumlahTotal.'</td>';
                                echo '  <td class="text-left">'.$TersediaBedPria.'</td>';
                                echo '  <td class="text-left">'.$TersediaBedWanita.'</td>';
                                echo '  <td class="text-left">'.$TersediaBedBebas.'</td>';
                                echo '  <td class="center"><input class="form-check-input" type="checkbox" name="id_ruang_rawat[]" value="'.$id_ruang_rawat.'" ></td>';
                                echo '</tr>';
                            $no++;}
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-success">
        <button type="submit" class="btn btn-md btn-round btn-primary mt-2 ml-2">
            <i class="ti ti-save"></i> Simpan
        </button>
        <button type="button" class="btn btn-md btn-round btn-danger mt-2 ml-2" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
</form>
