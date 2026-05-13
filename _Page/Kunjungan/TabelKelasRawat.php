<?php
include "../../_Config/Connection.php";

$no = 1;

$query = "
    SELECT 
        kr.id_kelas_rawat,
        kr.kode_kelas,
        kr.kelas,
        kr.status,

        (
            SELECT COUNT(*)
            FROM rr_ruang_rawat rr
            WHERE rr.id_kelas_rawat = kr.id_kelas_rawat
        ) AS jumlah_ruangan,

        (
            SELECT COUNT(*)
            FROM rr_tempat_tidur tt
            WHERE tt.id_kelas_rawat = kr.id_kelas_rawat
        ) AS jumlah_tt

    FROM rr_kelas_rawat kr
    ORDER BY kr.kelas ASC
";

$result = mysqli_query($Conn, $query);

if(mysqli_num_rows($result) > 0){

    while($row = mysqli_fetch_assoc($result)){

        $id_kelas_rawat = $row['id_kelas_rawat'];
        $kode_kelas     = $row['kode_kelas'];
        $kelas          = $row['kelas'];
        $jumlah_ruangan = $row['jumlah_ruangan'];
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
                    <small>'.$kelas.'</small>
                </td>

                <td align="left">
                    <small>'.$kode_kelas.'</small>
                </td>

                <td align="left">
                    <small>'.$jumlah_ruangan.' Ruangan</small>
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
                        class="btn btn-sm btn-primary pilih-kelas"
                        data-id="'.$id_kelas_rawat.'"
                        data-kelas="'.$kelas.'">

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
            <td colspan="7" align="center">
                <small class="text-muted">Tidak ada data kelas rawat</small>
            </td>
        </tr>
    ';
}
?>