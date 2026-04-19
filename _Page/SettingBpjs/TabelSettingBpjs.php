<?php
    // Inisiasai $JumlahSatuSehat
    $JumlahSatuSehat = 0;

    //Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Validasi Sessi Akses
    if(empty($SessionIdAkses)){
        echo '
            <tr>
                <td align="center" colspan="10">
                    <small class="text text-danger">Sesi Akses Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
        ';
        exit;
    }
    
    // Jumlah Data
    $QrySatuSehat = mysqli_query($Conn, "SELECT id_setting_bpjs FROM setting_bpjs");
    $JumlahSatuSehat = mysqli_num_rows($QrySatuSehat);
    if(empty($JumlahSatuSehat)){
        echo '
            <tr>
                <td align="center" colspan="10">
                    <small class="text text-danger">Setting Bridging BPJS Tidak Ditemukan</small>
                </td>
            </tr>
        ';
        exit;
    }
    $no = 1;
    $query = mysqli_query($Conn, "SELECT * FROM setting_bpjs ORDER BY id_setting_bpjs DESC");
    while ($data = mysqli_fetch_array($query)) {
        $id_setting_bpjs = $data['id_setting_bpjs'];
        $status          = $data['status'];

        // Routing Vclaim
        if(empty($data['url_vclaim'])){
            $label_vclaim = '<span class="px-2 py-1 bg-danger-subtle text-danger rounded-1"><i class="bi bi-x"></i></span>';
        }else{
            $label_vclaim = '<span class="px-2 py-1 bg-success-subtle text-success rounded-1" title="'.$data['url_vclaim'].'"><i class="bi bi-check"></i></span>';
        }

        // Routing Aplicare
        if(empty($data['url_aplicare'])){
            $label_aplicare = '<span class="px-2 py-1 bg-danger-subtle text-danger rounded-1"><i class="bi bi-x"></i></span>';
        }else{
            $label_aplicare = '<span class="px-2 py-1 bg-success-subtle text-success rounded-1" title="'.$data['url_aplicare'].'"><i class="bi bi-check"></i></span>';
        }

        // Routing Antrol
        if(empty($data['url_antrol'])){
            $label_antrol = '<span class="px-2 py-1 bg-danger-subtle text-danger rounded-1"><i class="bi bi-x"></i></span>';
        }else{
            $label_antrol = '<span class="px-2 py-1 bg-success-subtle text-success rounded-1" title="'.$data['url_antrol'].'"><i class="bi bi-check"></i></span>';
        }

        // Routing iCare
        if(empty($data['url_icare'])){
            $label_iCare = '<span class="px-2 py-1 bg-danger-subtle text-danger rounded-1"><i class="bi bi-x"></i></span>';
        }else{
            $label_iCare = '<span class="px-2 py-1 bg-success-subtle text-success rounded-1" title="'.$data['url_icare'].'"><i class="bi bi-check"></i></span>';
        }

        // Routing Status
        if($status==1){
            $label_status = '<span class="px-2 py-1 bg-success text-white rounded-1" title="Active"><i class="bi bi-check"></i></span>';
        }else{
            $label_status = '<span class="px-2 py-1 bg-danger text-white rounded-1" title="No Active"><i class="bi bi-x"></i></span>';
        }
        // Menampilkan Data
        echo '
            <tr>
                <td class="text-center">
                    <small class="text text-muted">'.$no.'</small>
                </td>
                <td class="text-left">
                    <a href="javascript:void(0);" class="modal_detail" data-id="'.$data['id_setting_bpjs'].'">
                        <small class="text text-primary text-decoration-underline">'.$data['nama_setting_bpjs'].'</small>
                    </a>
                </td>
                <td class="text-left">
                    <small class="text text-muted">'.$data['consid'].'</small>
                </td>
                <td class="text-left">
                    <small class="text text-muted">'.$data['kode_ppk'].'</small>
                </td>
                <td class="text-center"><small>'.$label_vclaim.'</small></td>
                <td class="text-center"><small>'.$label_aplicare.'</small></td>
                <td class="text-center"><small>'.$label_antrol.'</small></td>
                <td class="text-center"><small>'.$label_iCare.'</small></td>
                <td class="text-center"><small>'.$label_status.'</small></td>
                <td class="text-center">
                    <a href="javascript:void(0);" class="btn-sm btn-floating" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_detail" data-id="'.$data['id_setting_bpjs'].'">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_coba_koneksi" data-id="'.$data['id_setting_bpjs'].'">
                                <i class="bi bi-arrow-left-right"></i> Uji Coba Koneksi
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_edit" data-id="'.$data['id_setting_bpjs'].'">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_hapus" data-id="'.$data['id_setting_bpjs'].'">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
        ';
        $no++;
    }
?>
<script>
    var JumlahSatuSehat = <?php echo $JumlahSatuSehat; ?>;
    $('#page_info').html('Data : '+JumlahSatuSehat+' Record');
</script>