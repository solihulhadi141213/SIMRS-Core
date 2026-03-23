<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // Validasi Session
    if(empty($_SESSION['id_akses'])){
        echo '
            <tr>
                <td colspan="9" class="text-center text-danger">Sesi Akses Sudah Berakhir! Silahkan Login Ulang</td>
            </tr>
            <script>
                $("#page_info").html("Data Count : 0");
            </script>
        ';
        exit;
    }
    
    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_setting_analyza FROM setting_analyza"));

    if(empty($jml_data)){
        echo '
            <tr>
                <td colspan="9" class="text-center text-danger">Belum Ada Data Yang Ditampilkan</td>
            </tr>
            <script>
                $("#page_info").html("Data Count : 0");
            </script>
        ';
        exit;
    }

    // Tampilkan Data
    $no = 1;
    $query = mysqli_query($Conn, "SELECT*FROM setting_analyza ORDER BY id_setting_analyza DESC");
    while ($data = mysqli_fetch_array($query)) {
        $id_setting_analyza= $data['id_setting_analyza'];
        $token= $data['token'] ?? '-';
        $creat_at= $data['creat_at'] ?? '-';
        $expired_at= $data['expired_at'] ?? '-';
        if(empty($data['status'])){
            $label_status = '<div class="badge bg-inverse">None</div>';
        }else{
            $label_status = '<div class="badge bg-success">Active</div>';
        }

        echo '
            <tr>
                <td class="text-center">'.$no.'</td>
                <td class="text-start">'.$data['setting_name'].'</td>
                <td class="text-start">'.$data['base_url'].'</td>
                <td class="text-start">'.$data['username'].'</td>
                <td class="text-start">'.$data['password'].'</td>
                <td class="text-start"><code>'.$token.'</code></td>
                <td class="text-start">'.$expired_at.'</td>
                <td class="text-center">'.$label_status.'</td>
                <td class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalDetail" data-id="'.$id_setting_analyza.'">
                            <i class="ti ti-info"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalEdit" data-id="'.$id_setting_analyza.'">
                            <i class="ti ti-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#ModalHapus" data-id="'.$id_setting_analyza.'">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        ';

        $no++;
    }

    echo '
        <script>
            $("#page_info").html("Data Count : '.$jml_data.'");
        </script>
    ';
?>
