<?php
  // Koneksi, Fungsi Pembantu, dan Sesi Pengguna
  include "../../_Config/Connection.php";
  include "../../_Config/SimrsFunction.php";
  include "../../_Config/Session.php";

  // Validasi Sesi Akses Pengguna
  if (empty($SessionIdAkses)) {
    echo '<div class="alert alert-danger"><small>Sesi akses sudah berakhir! Silahkan login ulang.</small></div>';
    exit;
  }

  // Validasi Metode Permintaan (Harus POST)
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo '<div class="alert alert-danger"><small>Metode request tidak valid.</small></div>';
    exit;
  }

  // Validasi dan Sanitasi Parameter ID Antrian
  $id_antrian = (int) ($_POST['id_antrian'] ?? 0);
  if (!$id_antrian) {
    echo '<div class="alert alert-danger"><small>ID antrian tidak valid atau kosong!</small></div>';
    exit;
  }

  // Ambil Data Antrean Berdasarkan ID Menggunakan Prepared Statement
  $stmt = mysqli_prepare(
    $Conn,
    "SELECT a.*, 
            p.id_pasien AS pasien_terdaftar, 
            p.nama AS nama_pasien_terdaftar,
            p.nik AS nik_pasien_terdaftar,
            p.no_bpjs AS no_bpjs_pasien_terdaftar,
            p.kontak AS kontak_pasien_terdaftar,
            p.gender AS gender_pasien_terdaftar
     FROM antrian a
     LEFT JOIN pasien p ON p.id_pasien = a.id_pasien
     WHERE a.id_antrian = ?
     LIMIT 1"
  );
  if (!$stmt) {
    echo '<div class="alert alert-danger"><small>Gagal menyiapkan data antrian.</small></div>';
    exit;
  }
  mysqli_stmt_bind_param($stmt, 'i', $id_antrian);
  if (!mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    echo '<div class="alert alert-danger"><small>Gagal mengambil data antrian.</small></div>';
    exit;
  }
  $result = mysqli_stmt_get_result($stmt);
  $data = mysqli_fetch_assoc($result);
  mysqli_stmt_close($stmt);

  if (!$data) {
    echo '<div class="alert alert-warning"><small>Data antrian tidak ditemukan.</small></div>';
    exit;
  }

  // Ekstraksi Nilai Data Antrean dan Pasien
  $id_pasien = !empty($data['id_pasien']) ? (int) $data['id_pasien'] : 0;
  $jenis_request = isset($data['jenis_request']) ? (int) $data['jenis_request'] : (!empty($id_pasien) ? 0 : 1);

  // Penentuan Nama Pasien Terdaftar vs Pasien Baru
  $nama_pasien_terdaftar = !empty($data['nama_pasien_terdaftar']) ? (string) $data['nama_pasien_terdaftar'] : (string) ($data['nama_pasien'] ?? '');
  $nama_pasien = (string) ($data['nama_pasien'] ?? '');
  $gender = !empty($data['gender']) ? (string) $data['gender'] : (string) ($data['gender_pasien_terdaftar'] ?? '');
  $nik = !empty($data['nik']) ? (string) $data['nik'] : (string) ($data['nik_pasien_terdaftar'] ?? '');
  $no_bpjs = !empty($data['no_bpjs']) ? (string) $data['no_bpjs'] : (string) ($data['no_bpjs_pasien_terdaftar'] ?? '');
  $kontak = !empty($data['kontak']) ? (string) $data['kontak'] : (string) ($data['kontak_pasien_terdaftar'] ?? '');

  // Parameter Data Antrean
  $tanggal_kunjungan = (string) ($data['tanggal_kunjungan'] ?? '');
  $id_poliklinik = (int) ($data['id_poliklinik'] ?? 0);
  $id_dokter = (int) ($data['id_dokter'] ?? 0);
  $id_jadwal = (int) ($data['id_jadwal'] ?? 0);
  $pembayaran = (string) ($data['pembayaran'] ?? 'UMUM');
  $jenis_referensi = (string) ($data['jenis_referensi'] ?? '');
  $nomor_referensi = (string) ($data['nomor_referensi'] ?? '');
  $keluhan = (string) ($data['keluhan'] ?? '');
  $status_antrian = (string) ($data['status_antrian'] ?? 'Terdaftar');

  // Query Daftar Poliklinik Aktif Serta Poliklinik Terpilih
  $listPoli = [];
  $stmtPoli = mysqli_prepare(
    $Conn,
    "SELECT id_poliklinik, poliklinik 
     FROM poliklinik 
     WHERE status = 1 OR id_poliklinik = ? 
     ORDER BY poliklinik ASC"
  );
  if ($stmtPoli) {
    mysqli_stmt_bind_param($stmtPoli, 'i', $id_poliklinik);
    if (mysqli_stmt_execute($stmtPoli)) {
      $resPoli = mysqli_stmt_get_result($stmtPoli);
      while ($rowPoli = mysqli_fetch_assoc($resPoli)) {
        $listPoli[] = $rowPoli;
      }
    }
    mysqli_stmt_close($stmtPoli);
  }

  // Query Daftar Dokter Aktif pada Poliklinik Terpilih
  $listDokter = [];
  if ($id_poliklinik) {
    $stmtDokter = mysqli_prepare(
      $Conn,
      "SELECT DISTINCT d.id_dokter, d.nama
       FROM jadwal_dokter jd
       INNER JOIN dokter d ON d.id_dokter = jd.id_dokter
       INNER JOIN poliklinik p ON p.id_poliklinik = jd.id_poliklinik
       WHERE (jd.id_poliklinik = ? AND jd.status <> 0 AND d.status = 1 AND p.status = 1)
          OR d.id_dokter = ?
       ORDER BY d.nama ASC"
    );
    if ($stmtDokter) {
      mysqli_stmt_bind_param($stmtDokter, 'ii', $id_poliklinik, $id_dokter);
      if (mysqli_stmt_execute($stmtDokter)) {
        $resDokter = mysqli_stmt_get_result($stmtDokter);
        while ($rowDokter = mysqli_fetch_assoc($resDokter)) {
          $listDokter[] = $rowDokter;
        }
      }
      mysqli_stmt_close($stmtDokter);
    }
  }

  // Query Daftar Jadwal Dokter Berdasarkan Hari dan Poliklinik/Dokter Terpilih
  $listJadwal = [];
  $dayNames = [
    'Monday'    => 'Senin',
    'Tuesday'   => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday'  => 'Kamis',
    'Friday'    => 'Jumat',
    'Saturday'  => 'Sabtu',
    'Sunday'    => 'Minggu',
  ];
  $dateObj = DateTime::createFromFormat('!Y-m-d', $tanggal_kunjungan);
  $dayName = ($dateObj && $dateObj->format('Y-m-d') === $tanggal_kunjungan) ? ($dayNames[$dateObj->format('l')] ?? '') : '';

  if ($id_poliklinik && $dayName) {
    $stmtJadwal = mysqli_prepare(
      $Conn,
      "SELECT jd.id_jadwal, jd.id_dokter, jd.hari, jd.jam_mulai, jd.jam_selesai, d.nama AS nama_dokter
       FROM jadwal_dokter jd
       INNER JOIN dokter d ON d.id_dokter = jd.id_dokter
       INNER JOIN poliklinik p ON p.id_poliklinik = jd.id_poliklinik
       WHERE jd.id_poliklinik = ?
         AND jd.hari = ?
         AND (? = 0 OR jd.id_dokter = ?)
         AND ((jd.status <> 0 AND d.status = 1 AND p.status = 1)
              OR (jd.id_jadwal = ? AND jd.id_poliklinik = ?))
       ORDER BY jd.jam_mulai ASC, d.nama ASC"
    );
    if ($stmtJadwal) {
      mysqli_stmt_bind_param($stmtJadwal, 'isiiii', $id_poliklinik, $dayName, $id_dokter, $id_dokter, $id_jadwal, $id_poliklinik);
      if (mysqli_stmt_execute($stmtJadwal)) {
        $resJadwal = mysqli_stmt_get_result($stmtJadwal);
        while ($rowJadwal = mysqli_fetch_assoc($resJadwal)) {
          $listJadwal[] = $rowJadwal;
        }
      }
      mysqli_stmt_close($stmtJadwal);
    }
  }
?>

<!-- Hidden Input ID Antrian dan Nilai Pendukung Form Edit -->
<input type="hidden" name="id_antrian" id="id_antrian_edit" value="<?php echo (int) $id_antrian; ?>">
<input type="hidden" name="mode_pasien" id="mode_pasien_edit" value="<?php echo ($jenis_request === 1 ? 'baru' : 'lama'); ?>">
<input type="hidden" name="status_antrian" id="status_antrian_edit" value="<?php echo htmlspecialchars($status_antrian); ?>">
<input type="hidden" id="antrian_id_pasien_edit" value="<?php echo ($jenis_request === 0 && !empty($id_pasien) ? (int) $id_pasien : ''); ?>">

<!-- Bagian A: Data Pasien -->
<div class="row mb-3">
  <div class="col-12">
    <small>
      <b>A. Data Pasien</b>
    </small>
  </div>
</div>

<!-- Jenis Pasien (Lama / Baru) -->
<div class="row mb-3">
  <div class="col-md-4">
    <label><small>Jenis Pasien</small></label>
  </div>
  <div class="col-md-8">
    <div class="d-flex flex-wrap gap-2 pt-1">
      <div class="form-check form-check-inline mb-0">
        <input class="form-check-input js-mode-pasien-edit" type="radio" name="jenis_request" id="pasien_lama_edit" value="0" <?php echo ($jenis_request === 0 ? 'checked' : ''); ?>>
        <label class="form-check-label" for="pasien_lama_edit">
          <small>Pasien Lama</small>
        </label>
      </div>
      <div class="form-check form-check-inline mb-0">
        <input class="form-check-input js-mode-pasien-edit" type="radio" name="jenis_request" id="pasien_baru_edit" value="1" <?php echo ($jenis_request === 1 ? 'checked' : ''); ?>>
        <label class="form-check-label" for="pasien_baru_edit">
          <small>Pasien Baru</small>
        </label>
      </div>
    </div>
  </div>
</div>

<!-- Form Pencarian Pasien Terdaftar (Select2) -->
<div class="row mb-3">
  <div class="col-md-4">
    <label for="id_pasien_edit"><small>No.RM</small></label>
  </div>
  <div class="col-md-8" id="select_id_pasien_edit">
    <select name="id_pasien" id="id_pasien_edit" class="form-control" <?php echo ($jenis_request === 1 ? 'disabled' : ''); ?>>
      <option value="">Pilih Pasien</option>
      <?php if ($jenis_request === 0 && !empty($id_pasien)): ?>
        <option value="<?php echo (int) $id_pasien; ?>" data-id-pasien="<?php echo (int) $id_pasien; ?>" data-nama="<?php echo htmlspecialchars($nama_pasien_terdaftar); ?>" selected>No. RM <?php echo (int) $id_pasien; ?> — <?php echo htmlspecialchars($nama_pasien_terdaftar); ?></option>
      <?php endif; ?>
    </select>
  </div>
</div>

<!-- Nama Pasien -->
<div class="row mb-3">
  <div class="col-md-4">
    <label for="nama_pasien_edit">
      <small>Nama Pasien</small> <span class="text-danger">*</span>
    </label>
  </div>
  <div class="col-md-8">
    <input type="text" name="nama_pasien" id="nama_pasien_edit" class="form-control" maxlength="255" value="<?php echo htmlspecialchars($nama_pasien); ?>" required>
  </div>
</div>

<!-- Jenis Kelamin -->
<div class="row mb-3">
  <div class="col-md-4">
    <label for="gender_antrian_edit">
      <small>Jenis Kelamin</small> <span class="text-danger">*</span>
    </label>
  </div>
  <div class="col-md-8">
    <select name="gender" id="gender_antrian_edit" class="form-select" required>
      <option value="">Pilih</option>
      <option value="Laki-laki" <?php echo ($gender === 'Laki-laki' ? 'selected' : ''); ?>>Laki-laki</option>
      <option value="Perempuan" <?php echo ($gender === 'Perempuan' ? 'selected' : ''); ?>>Perempuan</option>
    </select>
  </div>
</div>

<!-- NIK -->
<div class="row mb-3">
  <div class="col-md-4">
    <label for="nik_antrian_edit">
      <small>Nomor Induk Kependudukan (NIK)</small>
    </label>
  </div>
  <div class="col-md-8">
    <input type="text" name="nik" id="nik_antrian_edit" class="form-control" maxlength="16" inputmode="numeric" value="<?php echo htmlspecialchars($nik); ?>">
  </div>
</div>

<!-- Nomor BPJS -->
<div class="row mb-3">
  <div class="col-md-4">
    <label for="no_bpjs_antrian_edit">
      <small>Nomor BPJS</small>
    </label>
  </div>
  <div class="col-md-8">
    <input type="text" name="no_bpjs" id="no_bpjs_antrian_edit" class="form-control" maxlength="13" inputmode="numeric" value="<?php echo htmlspecialchars($no_bpjs); ?>">
  </div>
</div>

<!-- Kontak -->
<div class="row mb-3">
  <div class="col-md-4">
    <label for="kontak_antrian_edit">
      <small>Kontak</small>
    </label>
  </div>
  <div class="col-md-8">
    <input type="text" name="kontak" id="kontak_antrian_edit" class="form-control" maxlength="20" inputmode="tel" value="<?php echo htmlspecialchars($kontak); ?>">
  </div>
</div>

<!-- Bagian B: Data Antrian -->
<div class="row mb-3 mt-3">
  <div class="col-12">
    <small>
      <b>B. Data Antrian</b>
    </small>
  </div>
</div>

<!-- Tanggal Rencana Kunjungan -->
<div class="row mb-3">
  <div class="col-md-4">
    <label for="tanggal_kunjungan_edit">
      <small>Tanggal Rencana Kunjungan</small> <span class="text-danger">*</span>
    </label>
  </div>
  <div class="col-md-8">
    <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan_edit" class="form-control" value="<?php echo htmlspecialchars($tanggal_kunjungan); ?>" required>
  </div>
</div>

<!-- Poliklinik -->
<div class="row mb-3">
  <div class="col-md-4">
    <label for="id_poliklinik_edit">
      <small>Poliklinik</small> <span class="text-danger">*</span>
    </label>
  </div>
  <div class="col-md-8">
    <select name="id_poliklinik" id="id_poliklinik_edit" class="form-select" required>
      <option value="">Pilih poliklinik</option>
      <?php foreach ($listPoli as $poli): ?>
        <option value="<?php echo (int) $poli['id_poliklinik']; ?>" <?php echo ((int) $poli['id_poliklinik'] === $id_poliklinik ? 'selected' : ''); ?>>
          <?php echo htmlspecialchars($poli['poliklinik']); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
</div>

<!-- Dokter -->
<div class="row mb-3">
  <div class="col-md-4">
    <label for="id_dokter_edit">
      <small>Dokter</small> <span class="text-danger">*</span>
    </label>
  </div>
  <div class="col-md-8">
    <select name="id_dokter" id="id_dokter_edit" class="form-select" required <?php echo empty($listDokter) ? 'disabled' : ''; ?>>
      <option value=""><?php echo empty($listDokter) ? 'Pilih poliklinik terlebih dahulu' : 'Pilih Dokter'; ?></option>
      <?php foreach ($listDokter as $dok): ?>
        <option value="<?php echo (int) $dok['id_dokter']; ?>" <?php echo ((int) $dok['id_dokter'] === $id_dokter ? 'selected' : ''); ?>>
          <?php echo htmlspecialchars($dok['nama']); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
</div>

<!-- Jadwal Praktek -->
<div class="row mb-3">
  <div class="col-md-4">
    <label for="id_jadwal_edit">
      <small>Jadwal Praktek</small> <span class="text-danger">*</span>
    </label>
  </div>
  <div class="col-md-8">
    <select name="id_jadwal" id="id_jadwal_edit" class="form-select" data-selected="<?php echo (int) $id_jadwal; ?>" required <?php echo empty($listJadwal) ? 'disabled' : ''; ?>>
      <option value=""><?php echo empty($listJadwal) ? 'Jadwal tidak tersedia' : 'Pilih Jadwal'; ?></option>
      <?php foreach ($listJadwal as $jadwal): ?>
        <?php 
          $jam = substr((string) $jadwal['jam_mulai'], 0, 5) . ' - ' . substr((string) $jadwal['jam_selesai'], 0, 5);
          $jadwalText = $jadwal['nama_dokter'] . ' | ' . $jam;
        ?>
        <option value="<?php echo (int) $jadwal['id_jadwal']; ?>" <?php echo ((int) $jadwal['id_jadwal'] === $id_jadwal ? 'selected' : ''); ?>>
          <?php echo htmlspecialchars($jadwalText); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
</div>

<!-- Metode Pembayaran -->
<div class="row mb-3">
  <div class="col-md-4">
    <label for="pembayaran_edit">
      <small>Metode Pembayaran</small> <span class="text-danger">*</span>
    </label>
  </div>
  <div class="col-md-8">
    <select name="pembayaran" id="pembayaran_edit" class="form-select" required>
      <option value="UMUM" <?php echo ($pembayaran === 'UMUM' ? 'selected' : ''); ?>>UMUM</option>
      <option value="BPJS" <?php echo ($pembayaran === 'BPJS' ? 'selected' : ''); ?>>BPJS</option>
      <option value="ASURANSI" <?php echo ($pembayaran === 'ASURANSI' ? 'selected' : ''); ?>>ASURANSI</option>
    </select>
  </div>
</div>

<!-- Jenis Referensi -->
<div class="row mb-3">
  <div class="col-md-4">
    <label for="jenis_referensi_edit">
      <small>Jenis Referensi</small>
    </label>
  </div>
  <div class="col-md-8">
    <select name="jenis_referensi" id="jenis_referensi_edit" class="form-select">
      <option value="">Pilih Jenis Referensi</option>
      <option value="1" <?php echo ($jenis_referensi === '1' ? 'selected' : ''); ?>>Rujukan FKTP</option>
      <option value="2" <?php echo ($jenis_referensi === '2' ? 'selected' : ''); ?>>Rujukan Internal</option>
      <option value="3" <?php echo ($jenis_referensi === '3' ? 'selected' : ''); ?>>Kontrol</option>
      <option value="4" <?php echo ($jenis_referensi === '4' ? 'selected' : ''); ?>>Rujukan Antar RS</option>
    </select>
  </div>
</div>

<!-- Nomor Referensi -->
<div class="row mb-3">
  <div class="col-md-4">
    <label for="nomor_referensi_edit">
      <small>Nomor Referensi</small>
    </label>
  </div>
  <div class="col-md-8">
    <input type="text" <?php echo empty($jenis_referensi) ? 'readonly' : ''; ?> name="nomor_referensi" id="nomor_referensi_edit" class="form-control" maxlength="255" value="<?php echo htmlspecialchars($nomor_referensi); ?>">
  </div>
</div>

<!-- Keluhan Pasien -->
<div class="row">
  <div class="col-md-4">
    <label for="keluhan_antrian_edit">
      <small>Keluhan</small> <span class="text-danger">*</span>
    </label>
  </div>
  <div class="col-md-8">
    <textarea name="keluhan" id="keluhan_antrian_edit" class="form-control" rows="3" required><?php echo htmlspecialchars($keluhan); ?></textarea>
  </div>
</div>

<!-- Script Inisialisasi dan Interaksi Dinamis Form Edit -->
<script>
$(document).ready(function() {
  const modalEdit = $('#ModalEdit');
  const selectPasienEdit = $('#id_pasien_edit');
  const parentSelectPasienEdit = $('#select_id_pasien_edit');

  // Inisialisasi Select2 Pencarian Pasien Terdaftar
  function initSelect2PasienEdit() {
    if (!selectPasienEdit.length || typeof $.fn.select2 !== 'function') {
      return;
    }
    if (selectPasienEdit.hasClass('select2-hidden-accessible')) {
      selectPasienEdit.select2('destroy');
    }

    function templatePasienEdit(item) {
      if (item.loading || !item.id) {
        return item.text || '';
      }
      const el = item.element ? $(item.element) : null;
      const idVal = item.id_pasien || (el ? el.data('id-pasien') : null) || item.id;
      const textVal = item.text || '';
      let namaVal = item.nama || (el ? el.data('nama') : null);
      if (!namaVal) {
        namaVal = textVal.indexOf('—') > -1 ? textVal.split('—')[1].trim() : textVal;
      }

      const row = $('<div>', {class: 'antrian-select2-pasien'});
      $('<div>', {class: 'antrian-select2-pasien-id'}).text(idVal).appendTo(row);
      $('<div>', {class: 'antrian-select2-pasien-nama'}).text(namaVal).appendTo(row);
      return row;
    }

    selectPasienEdit.select2({
      theme: 'bootstrap-5',
      dropdownParent: parentSelectPasienEdit.length ? parentSelectPasienEdit : modalEdit,
      placeholder: 'Cari Pasien',
      allowClear: true,
      width: '100%',
      templateResult: templatePasienEdit,
      templateSelection: templatePasienEdit,
      ajax: {
        url: '_Page/Antrian/ListPasien.php',
        type: 'GET',
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            term: params.term || '',
            page: params.page || 1
          };
        },
        processResults: function(response) {
          return {
            results: Array.isArray(response.results) ? response.results : [],
            pagination: {
              more: Boolean(response.pagination && response.pagination.more)
            }
          };
        },
        cache: true
      }
    });
  }

  initSelect2PasienEdit();

  // Event Pemilihan Pasien Dari Select2
  selectPasienEdit.on('select2:select', function(e) {
    const selectedData = e.params.data;
    if (!selectedData || !selectedData.id) {
      return;
    }
    $('#antrian_id_pasien_edit').val(selectedData.id);
    $('#nama_pasien_edit').val(selectedData.nama || '');
    if (selectedData.gender) {
      $('#gender_antrian_edit').val(selectedData.gender).trigger('change');
    }
    $('#nik_antrian_edit').val(selectedData.nik || '');
    $('#no_bpjs_antrian_edit').val(selectedData.no_bpjs || '');
    $('#kontak_antrian_edit').val(selectedData.kontak || '');
  });

  // Event Pembersihan Pilihan Pasien
  selectPasienEdit.on('select2:clear', function() {
    $('#antrian_id_pasien_edit').val('');
    $('#nama_pasien_edit').val('');
    $('#gender_antrian_edit').val('').trigger('change');
    $('#nik_antrian_edit').val('');
    $('#no_bpjs_antrian_edit').val('');
    $('#kontak_antrian_edit').val('');
  });

  // Event Pergantian Radio Jenis Pasien (Pasien Lama vs Pasien Baru)
  $('#ModalEdit').on('change', 'input[name="jenis_request"].js-mode-pasien-edit', function() {
    const pasienBaru = $(this).val() === '1';
    $('#mode_pasien_edit').val(pasienBaru ? 'baru' : 'lama');

    if (pasienBaru) {
      selectPasienEdit.val(null).trigger('change');
      $('#antrian_id_pasien_edit').val('');
      $('#nama_pasien_edit').val('');
      $('#gender_antrian_edit').val('').trigger('change');
      $('#nik_antrian_edit').val('');
      $('#no_bpjs_antrian_edit').val('');
      $('#kontak_antrian_edit').val('');
    }

    selectPasienEdit.prop('disabled', pasienBaru);
  });

  // Pengendali Request Select Dinamis
  const antrianEditSelectRequestId = { dokter: 0, jadwal: 0 };
  const antrianEditSelectRequest = { dokter: null, jadwal: null };

  function batalkanRequestEditSelect(jenis) {
    antrianEditSelectRequestId[jenis] += 1;
    if (antrianEditSelectRequest[jenis]) {
      antrianEditSelectRequest[jenis].abort();
      antrianEditSelectRequest[jenis] = null;
    }
  }

  // Muat Daftar Dokter Saat Poliklinik Berubah
  function muatOptionDokterEdit(poliklinikId) {
    const selectDokter = $('#id_dokter_edit');
    const selectJadwal = $('#id_jadwal_edit');
    batalkanRequestEditSelect('dokter');
    batalkanRequestEditSelect('jadwal');

    selectDokter.empty().append(new Option('Memuat dokter...', '')).val('').prop('disabled', true);
    selectJadwal.empty().append(new Option('Pilih dokter terlebih dahulu', '')).val('').prop('disabled', true);
    selectJadwal.removeAttr('data-selected');

    if (!poliklinikId) {
      selectDokter.empty().append(new Option('Pilih poliklinik terlebih dahulu', '')).val('').prop('disabled', true);
      return;
    }

    const reqId = antrianEditSelectRequestId.dokter;
    function muatHalaman(page) {
      antrianEditSelectRequest.dokter = $.ajax({
        url: '_Page/Antrian/ListDokter.php',
        type: 'GET',
        dataType: 'json',
        data: { id_poliklinik: poliklinikId, term: '', page: page }
      }).done(function(response) {
        if (reqId !== antrianEditSelectRequestId.dokter) {
          return;
        }
        const results = Array.isArray(response.results) ? response.results : [];
        results.forEach(function(item) {
          selectDokter.append(new Option(item.text || '', item.id || ''));
        });

        if (response.pagination && response.pagination.more) {
          muatHalaman(page + 1);
          return;
        }

        if (selectDokter.find('option').length > 1) {
          selectDokter.find('option').first().text('Pilih Dokter');
          selectDokter.prop('disabled', false);
        } else {
          selectDokter.empty().append(new Option('Dokter tidak tersedia pada poliklinik ini', '')).val('').prop('disabled', true);
        }
        antrianEditSelectRequest.dokter = null;
      }).fail(function(xhr, status) {
        if (status === 'abort' || reqId !== antrianEditSelectRequestId.dokter) {
          return;
        }
        selectDokter.empty().append(new Option('Gagal memuat dokter', '')).val('').prop('disabled', true);
        antrianEditSelectRequest.dokter = null;
      });
    }
    muatHalaman(1);
  }

  // Muat Daftar Jadwal Dokter Saat Dokter atau Tanggal Kunjungan Berubah
  function muatOptionJadwalEdit() {
    const selectJadwal = $('#id_jadwal_edit');
    const idPoliklinik = $('#id_poliklinik_edit').val();
    const idDokter = $('#id_dokter_edit').val();
    const tanggal = $('#tanggal_kunjungan_edit').val();
    const savedJadwal = selectJadwal.attr('data-selected') || '';

    batalkanRequestEditSelect('jadwal');

    if (!idPoliklinik) {
      selectJadwal.empty().append(new Option('Pilih poliklinik terlebih dahulu', '')).val('').prop('disabled', true);
      return;
    }
    if (!idDokter) {
      selectJadwal.empty().append(new Option('Pilih dokter terlebih dahulu', '')).val('').prop('disabled', true);
      return;
    }
    if (!tanggal) {
      selectJadwal.empty().append(new Option('Pilih tanggal kunjungan terlebih dahulu', '')).val('').prop('disabled', true);
      return;
    }

    const reqId = antrianEditSelectRequestId.jadwal;
    selectJadwal.empty().append(new Option('Memuat jadwal...', '')).val('').prop('disabled', true);

    antrianEditSelectRequest.jadwal = $.ajax({
      url: '_Page/Antrian/ListJadwal.php',
      type: 'GET',
      dataType: 'json',
      data: {
        id_poliklinik: idPoliklinik,
        id_dokter: idDokter,
        tanggal_kunjungan: tanggal,
        selected_id: savedJadwal
      }
    }).done(function(response) {
      if (reqId !== antrianEditSelectRequestId.jadwal) {
        return;
      }
      const jadwal = Array.isArray(response.results) ? response.results : [];
      if (jadwal.length === 0) {
        selectJadwal.empty().append(new Option('Jadwal tidak tersedia pada tanggal ini', '')).val('').prop('disabled', true);
        antrianEditSelectRequest.jadwal = null;
        return;
      }

      selectJadwal.empty().append(new Option('Pilih Jadwal', ''));
      jadwal.forEach(function(item) {
        const opt = new Option(item.text || '', item.id || '');
        if (savedJadwal && String(item.id) === String(savedJadwal)) {
          $(opt).prop('selected', true);
        }
        selectJadwal.append(opt);
      });
      selectJadwal.prop('disabled', false);
      antrianEditSelectRequest.jadwal = null;
    }).fail(function(xhr, status) {
      if (status === 'abort' || reqId !== antrianEditSelectRequestId.jadwal) {
        return;
      }
      selectJadwal.empty().append(new Option('Gagal memuat jadwal', '')).val('').prop('disabled', true);
      antrianEditSelectRequest.jadwal = null;
    });
  }

  // Event Perubahan Poliklinik, Dokter, dan Tanggal Kunjungan
  $('#id_poliklinik_edit').on('change', function() {
    muatOptionDokterEdit($(this).val());
  });

  $('#id_dokter_edit').on('change', function() {
    muatOptionJadwalEdit();
  });

  $('#tanggal_kunjungan_edit').on('change', function() {
    muatOptionJadwalEdit();
  });

  // Atur Status Readonly Nomor Referensi Berdasarkan Pilihan Jenis Referensi
  function aturInputNomorReferensiEdit() {
    const jenisDipilih = Boolean($('#jenis_referensi_edit').val());
    $('#nomor_referensi_edit').prop('readonly', !jenisDipilih);
    if (!jenisDipilih) {
      $('#nomor_referensi_edit').val('');
    }
  }
  $('#jenis_referensi_edit').on('change', aturInputNomorReferensiEdit);

  // Bersihkan Resource Saat Modal Ditutup
  $('#ModalEdit').one('hidden.bs.modal', function() {
    batalkanRequestEditSelect('dokter');
    batalkanRequestEditSelect('jadwal');
    if (selectPasienEdit.hasClass('select2-hidden-accessible')) {
      selectPasienEdit.select2('destroy');
    }
  });

  // Autofocus Pada Kontrol Sesuai Jenis Pasien
  setTimeout(function() {
    if ($('#pasien_baru_edit').is(':checked')) {
      $('#nama_pasien_edit').focus();
    } else {
      $('#id_pasien_edit').focus();
    }
  }, 250);
});
</script>