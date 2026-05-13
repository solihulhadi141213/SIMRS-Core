<?php
include "../../_Config/Connection.php";

$id_kelas_rawat = !empty($_POST['id_kelas_rawat']) ? $_POST['id_kelas_rawat'] : 0;
$id_ruang_rawat = !empty($_POST['id_ruang_rawat']) ? $_POST['id_ruang_rawat'] : 0;

$no = 1;

$query = "
    SELECT 
        tt.id_tempat_tidur,
        tt.tempat_tidur,
        tt.pria,
        tt.wanita,
        tt.bebas,
        tt.status

    FROM rr_tempat_tidur tt

    WHERE 
        tt.id_kelas_rawat = '$id_kelas_rawat'
        AND tt.id_ruang_rawat = '$id_ruang_rawat'

    ORDER BY tt.tempat_tidur ASC
";

$result = mysqli_query($Conn, $query);

if(mysqli_num_rows($result) > 0){

    while($row = mysqli_fetch_assoc($result)){

        $id_tempat_tidur = $row['id_tempat_tidur'];
        $tempat_tidur    = $row['tempat_tidur'];
        $pria            = $row['pria'];
        $wanita          = $row['wanita'];
        $bebas           = $row['bebas'];
        $status          = $row['status'];

        // Kategori
        if($pria == 1){
            $kategori = 'Pria';
        } elseif($wanita == 1){
            $kategori = 'Wanita';
        } elseif($bebas == 1){
            $kategori = 'Bebas';
        } else {
            $kategori = '-';
        }

        // Status
        if($status == 1){
            $label_status = '<span class="badge bg-success">Aktif</span>';
        } else {
            $label_status = '<span class="badge bg-danger">Nonaktif</span>';
        }

        echo '
            <tr>

                <td align="center">'.$no.'</td>

                <td align="left">
                    <small>'.$tempat_tidur.'</small>
                </td>

                <td align="left">
                    <small>'.$kategori.'</small>
                </td>

                <td align="center">
                    '.$label_status.'
                </td>

                <td align="center">

                    <button 
                        type="button"
                        class="btn btn-sm btn-warning pilih-tempat-tidur"
                        data-id="'.$id_tempat_tidur.'"
                        data-tempat_tidur="'.$tempat_tidur.'">

                        Pilih
                    </button>

                </td>

            </tr>
        ';

        $no++;
    }

} else {

    echo '
        <tr>
            <td colspan="5" align="center">
                <small class="text-muted">Tidak ada tempat tidur</small>
            </td>
        </tr>
    ';
}
?>