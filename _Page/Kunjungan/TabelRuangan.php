<?php
include "../../_Config/Connection.php";

$id_kelas_rawat = !empty($_POST['id_kelas_rawat']) ? $_POST['id_kelas_rawat'] : 0;

$no = 1;

$query = "
    SELECT 
        rr.id_ruang_rawat,
        rr.ruang_rawat,
        rr.status,

        (
            SELECT COUNT(*)
            FROM rr_tempat_tidur tt
            WHERE tt.id_ruang_rawat = rr.id_ruang_rawat
        ) AS jumlah_tt

    FROM rr_ruang_rawat rr
    WHERE rr.id_kelas_rawat = '$id_kelas_rawat'
    ORDER BY rr.ruang_rawat ASC
";

$result = mysqli_query($Conn, $query);

if(mysqli_num_rows($result) > 0){

    while($row = mysqli_fetch_assoc($result)){

        $id_ruang_rawat = $row['id_ruang_rawat'];
        $ruang_rawat    = $row['ruang_rawat'];
        $jumlah_tt      = $row['jumlah_tt'];
        $status         = $row['status'];

        if($status == 1){
            $label_status = '<span class="badge bg-success">Aktif</span>';
        } else {
            $label_status = '<span class="badge bg-danger">Nonaktif</span>';
        }

        echo '
            <tr>

                <td align="center">'.$no.'</td>

                <td align="left">
                    <small>'.$ruang_rawat.'</small>
                </td>

                <td align="left">
                    <small>'.$jumlah_tt.' Tempat Tidur</small>
                </td>

                <td align="center">
                    '.$label_status.'
                </td>

                <td align="center">
                    <button 
                        type="button"
                        class="btn btn-sm btn-success pilih-ruangan"
                        data-id="'.$id_ruang_rawat.'"
                        data-ruang="'.$ruang_rawat.'">

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
                <small class="text-muted">Tidak ada data ruangan</small>
            </td>
        </tr>
    ';
}
?>