<?php
    /* Koneksi Database */
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/SettingFaskes.php";
    include "FungsiLaboratorium.php";
?>

<div class="row">
    <div class="col-xl-12 col-md-12">
        <form action="javascript:void(0);" id="ProsesPendaftaranLaboratorium">
            <div class="card table-card">
                <div class="card-header border-info">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <h4 class="text-dark">
                                <i class="icofont-prescription"></i> Form Pendaftaran Pemeriksaan Laboratorium
                            </h4>
                        </div>
                        <div class="col-md-2 mb-3">
                            <a href="javascript:void(0);" class="btn btn-sm btn-block btn-secondary kembali_ke_data_laboratorium" title="Kembali Ke Halaman Data Laboratorium">
                                <i class="ti ti-angle-left"></i> Kembali
                            </a>
                        </div>
                        <div class="col-md-2 mb-3">
                            <button type="button" class="btn btn-sm btn-block btn-primary" id="PilihKunjunganPasien" title="Pilih Kunjungan Pasien">
                                <i class="ti ti-search"></i> Cari & Pilih Pasien
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="id_pasien"><dt>No.RM (Nomor Rekam Medis)</dt></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="id_pasien" id="id_pasien" class="form-control" placeholder="Nomor RM">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="ihs_pasien"><dt>IHS pasien (SATUSEHAT)</dt></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="ihs_pasien" id="ihs_pasien" class="form-control" placeholder="IHS Satu Sehat">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="id_pasien"><dt>ID REG (Nomor Kunjungan)</dt></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="id_kunjungan" id="id_kunjungan" class="form-control" placeholder="ID Kunjungan">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="id_encounter"><dt>ID Encounter</dt></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="id_encounter" id="id_encounter" class="form-control" placeholder="Encounter Satu Sehat">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="nama"><dt>Nama Lengkap Pasien</dt></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="nama" id="nama" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="gender"><dt>Gender</dt></label>
                        </div>
                        <div class="col-md-9">
                            <select name="gender" id="gender" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="tanggal_lahir"><dt>Tanggal Lahir</dt></label>
                        </div>
                        <div class="col-md-9">
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3 mb-2">
                            <label for="tanggal"><dt>Tanggal & Waktu Permintaan</dt></label>
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="date" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                            <small>Tanggal</small>
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="time" name="jam" id="jam" class="form-control" value="<?php echo date('H:i'); ?>">
                            <small>Waktu/Jam</small>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="tujuan"><dt>Kategori Kunjungan</dt></label>
                        </div>
                        <div class="col-md-9">
                            <select name="tujuan" id="tujuan" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Rajal">Rajal</option>
                                <option value="Ranap">Ranap</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="fakses"><dt>Nama Faskes</dt></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="fakses" id="fakses" class="form-control" value="<?php echo $NamaFaskes; ?>">
                            <span class="text-muted">Nama Fasilitas Kesehatan Yang Mengirimkan Permintaan Pemeriksaan</span>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="unit"><dt>Unit / Instalasi</dt></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="unit" id="unit" class="form-control">
                            <span class="text-muted">Nama Unit/Instalasi yang meminta pemeriksaan</span>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="pembayaran"><dt>Metode Pembayaran</dt></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="pembayaran" id="pembayaran" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="dokter_pengirim"><dt>Dokter Pengirim</dt></label>
                        </div>
                        <div class="col-md-9">
                            <select name="dokter_pengirim" id="dokter_pengirim" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    //menampilkan list dokter
                                    $QryDokter = mysqli_query($Conn, "SELECT id_dokter, nama FROM dokter ORDER BY nama ASC");
                                    while ($DataDokter = mysqli_fetch_array($QryDokter)) {
                                        if(!empty($DataDokter['nama'])){
                                            echo '<option value="'.$DataDokter['id_dokter'].'">'.$DataDokter['nama'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                            <span class="text text-muted">
                                Permintaan pemeriksaan laboratorium harus melalui rekomendasi dokter.
                            </span>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="priority"><dt><i>Priority</i></dt></label>
                        </div>
                        <div class="col-md-9">
                            <select name="priority" id="priority" class="form-control">
                                <option value="">Pilih</option>
                                <?php
                                    $priority_list = [
                                        'routine' => 'Biasa',
                                        'urgent'  => 'Segera',
                                        'stat'    => 'Gawat'
                                    ];
                                    foreach($priority_list as $kode_p => $nama_p){
                                        echo '<option value="'.$kode_p.'">'.$nama_p.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="diagnosis"><dt><i>Diagnosis</i></dt></label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" name="diagnosis" id="diagnosis" class="form-control">
                                <button type="button" class="btn btn-sm btn-primary" id="CariDiagnosa">
                                    <i class="ti ti-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="keterangan"><dt>Keterangan Lainnya</dt></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="keterangan" id="keterangan" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="pemeriksaan"><dt>Parameter Pemeriksaan</dt></label>
                        </div>
                        <div class="col-md-9">
                            <div class="table table-responsive">
                                <table class="table table-bordered table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <td><dt>No</dt></td>
                                            <td colspan="2"><dt>Pemeriksaan</dt></td>
                                            <td><dt><i>Description</i></dt></td>
                                            <td><dt><i>Code</i></dt></td>
                                            <td><dt><i>Opsi</i></dt></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // Ambil token Analyza
                                            $tokenData = getAnalyzaToken($Conn);

                                            if ($tokenData['status'] !== 'success') {
                                                echo '<tr><td colspan="6" class="text-center text-danger">'.$tokenData['message'].'</td></tr>';
                                                exit;
                                            }
                                            $token   = $tokenData['token'];
                                            $baseUrl = $tokenData['base_url'];
                                            // Call API Pemeriksaan
                                            $curl = curl_init();
                                            curl_setopt_array($curl, [
                                                CURLOPT_URL => $baseUrl . "/_API/ReferensiPemeriksaan.php",
                                                CURLOPT_RETURNTRANSFER => true,
                                                CURLOPT_HTTPHEADER => [
                                                    "Authorization: Bearer $token"
                                                ],
                                            ]);
                                            $response = curl_exec($curl);
                                            curl_close($curl);
                                            $result = json_decode($response, true);

                                            // Validasi API Response
                                            if (empty($result)) {
                                                echo '<tr><td colspan="6" class="text-center text-danger">Terjadi Kesalahan pada saat meminta data dari Analyza</td></tr>';
                                                exit;
                                            }

                                            if ($result['status'] !== 'success') {
                                                echo '<tr><td colspan="6" class="text-center text-danger">Terjadi Kesalahan pada saat meminta data dari Analyza <br> <i>'.$result['message'].'</i></td></tr>';
                                                exit;
                                            }
                                            $data = $result['data'] ?? [];
                                            
                                            // Jika kosong
                                            if (count($data) === 0) {
                                                echo '<tr><td colspan="6" class="text-center text-danger">Data ATidak Ditemukan</td></tr>';
                                                exit;
                                            }

                                            // Render Table Rows
                                            $no = 1;
                                            foreach ($data as $row) {
                                                $category_pemeriksaan = $row['category_pemeriksaan'];
                                                $list_by_category = $row['list_by_category'];
                                                echo '
                                                    <tr>
                                                        <td class="text-center">'.$no.'</td>
                                                        <td colspan="5">'.$category_pemeriksaan.'</td>
                                                    </tr>
                                                ';

                                                $no2 = 1;
                                                foreach ($list_by_category as $row2) {
                                                    $id_referensi_pemeriksaan = $row2['id_referensi_pemeriksaan'];
                                                    $nama_pemeriksaan = $row2['nama_pemeriksaan'];
                                                    $code_pemeriksaan = $row2['code_pemeriksaan'];
                                                    $display_pemeriksaan = $row2['display_pemeriksaan'];
                                                    echo '
                                                        <tr class="row-pemeriksaan" data-target="id_referensi_pemeriksaan'.$no.'_'.$no2.'">
                                                            <td class="text-center"></td>
                                                            <td class="text-center text-muted">'.$no.'.'.$no2.'</td>
                                                            <td class="text-left text-muted">'.$nama_pemeriksaan.'</td>
                                                            <td class="text-left text-muted">'.$display_pemeriksaan.'</td>
                                                            <td class="text-left text-muted">'.$code_pemeriksaan.'</td>
                                                            <td class="text-center">
                                                                <input type="checkbox" name="id_referensi_pemeriksaan[]" id="id_referensi_pemeriksaan'.$no.'_'.$no2.'" class="form-check-input" value="'.$id_referensi_pemeriksaan.'|'.$nama_pemeriksaan.'|'.$category_pemeriksaan.'">
                                                            </td>
                                                        </tr>
                                                    ';
                                                    $no2++;
                                                }
                                                $no++;
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 col-form-label"></div>
                        <div class="col-md-9">
                            <div class="form-check">
                                <input type="checkbox" checked name="pernyataan" id="pernyataan" value="Ya" class="form-check-input" required>
                                <label for="pernyataan" class="form-check-label text-muted">
                                    Dengan ini saya menyatakan bahwa seluruh data pasien yang tercantum 
                                    dalam formulir permintaan pemeriksaan telah diisi secara 
                                    benar, lengkap, dan sesuai dengan kebutuhan pemeriksaan pasien.
                                </label>
                            </div>
                            <div class="invalid-feedback">
                                Anda harus menyetujui pernyataan ini sebelum melanjutkan.
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 col-form-label"></div>
                        <div class="col-md-9" id="NotifikasiPendaftaranLaboratorium">
                            <!-- Notifikasi Proses Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-md btn-primary mb-3" id="TombolSimpanLab">
                        <i class="ti ti-save"></i> Simpan
                    </button>
                    <button type="reset" class="btn btn-md btn-inverse mb-3">
                        <i class="ti ti-reload"></i> Reset
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>