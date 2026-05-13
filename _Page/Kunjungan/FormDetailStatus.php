<?php
    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // Validasi ID Kunjungan
    if (empty($_POST['id_kunjungan'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Kunjungan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // Sanitasi Input
    $id_kunjungan = validateAndSanitizeInput($_POST['id_kunjungan']);

    // Buka Data Dengan Prepared Statement + JOIN
    $sql = "SELECT status FROM kunjungan WHERE id_kunjungan = ?";
    $stmt = $Conn->prepare($sql);

    // Bind parameter
    $stmt->bind_param("i", $id_kunjungan);

    // Eksekusi
    $stmt->execute();

    // Ambil hasil
    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();

    // Simpan hasil ke variabel
    $status = $Data['status'] ?? null;

    // Tutup statement
    $stmt->close();

    // Routing Status
    if($status == "Terdaftar"){
        $status_terdaftar = 'bg-primary-subtle';
        $status_selesai   = 'bg-secondary-subtle';
        $status_batal     = 'bg-secondary-subtle';
        $status_meninggal = 'bg-secondary-subtle';
    }else{
        if($status == "Selesai"){
            $status_terdaftar = 'bg-secondary-subtle';
            $status_selesai   = 'bg-success-subtle';
            $status_batal     = 'bg-secondary-subtle';
            $status_meninggal = 'bg-secondary-subtle';
        }else{
            if($status == "Batal"){
                $status_terdaftar = 'bg-secondary-subtle';
                $status_selesai   = 'bg-secondary-subtle';
                $status_batal     = 'bg-warning-subtle';
                $status_meninggal = 'bg-secondary-subtle';
            }else{
                if($status == "Meninggal"){
                    $status_terdaftar = 'bg-secondary-subtle';
                    $status_selesai   = 'bg-secondary-subtle';
                    $status_batal     = 'bg-secondary-subtle';
                    $status_meninggal = 'bg-danger-subtle';
                }else{
                    $status_terdaftar = 'bg-secondary-subtle';
                    $status_selesai   = 'bg-secondary-subtle';
                    $status_batal     = 'bg-secondary-subtle';
                    $status_meninggal = 'bg-secondary-subtle';
                }
            }
        }
    }

    
?>
<ul class="timeline">

    <!-- Terdaftar -->
    <li class="timeline-item">
        <div class="timeline-icon <?php echo $status_terdaftar; ?>">
            <i class="bi bi-person-plus"></i>
        </div>
        <div class="activity-title">Terdaftar</div>
        <div class="activity-desc">
            Pasien didaftarkan oleh petugas pada saat pertama kali kunjungan. 
            Status kunjungan tidak akan berubah sampai petugas melakukan update pada data kunjungan sesuai pelayanan yang diterima.
        </div>
    </li>

    <!-- Selesai -->
    <li class="timeline-item">
        <div class="timeline-icon <?php echo $status_selesai; ?>">
            <i class="bi bi-check"></i>
        </div>
        <div class="activity-title">Selesai</div>
        <div class="activity-desc">
            Pasien telah menerima pelayanan dan diijinkan pulang. 
            Untuk pasien rawat inap, petugas akan membuatkan resume pulang beserta keterangan status kepulangan pasien.
        </div>
    </li>

    <!-- Batal -->
    <li class="timeline-item">
        <div class="timeline-icon <?php echo $status_batal; ?>">
            <i class="bi bi-x"></i>
        </div>
        <div class="activity-title">Batal</div>
        <div class="activity-desc">
            Pasien telah menerima pelayanan dan diijinkan pulang. 
            Untuk pasien rawat inap, petugas akan membuatkan resume pulang beserta keterangan status kepulangan pasien.
        </div>
    </li>

    <!-- Meninggal -->
    <li class="timeline-item">
        <div class="timeline-icon <?php echo $status_meninggal; ?>">
            <i class="bi bi-repeat"></i>
        </div>
        <div class="activity-title">Meninggal</div>
        <div class="activity-desc">
            Pasien telah meninggal dunia. 
            Petugas akan membuatkan informasi tanggal, jam meninggal dunia dan keterangan lainnya berdasarkan pernyataan dokter.
        </div>
    </li>
</ul>