<?php
    //Error Display dan koneksi database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
?>
<div class="row">
    <div class="col-xl-12 col-md-12">
        <div class="card table-card">
            <div class="card-header bg-dark text-light">
                <h4>Data Aplicare</h4>
                Berikut ini adalah data ketersediaan ruangan yang berasal dari <i>Aplicare</i>.
                Anda bisa melakukan pengelolaan data <i>Aplicare</i> secara manual disini. 
                Kami sarankan untuk periksa kembali kesesuaian data tersebut dengan data pada SIMRS.
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="">
                        <tr>
                            <th class="text-center"><dt>NO</dt></th>
                            <th class="text-center"><dt>UPDATE</dt></th>
                            <th class="text-center"><dt>RUANGAN</dt></th>
                            <th class="text-center"><dt>KELAS</dt></th>
                            <th class="text-center"><dt>KAPASITAS</dt></th>
                            <th class="text-center"><dt>PRIA</dt></th>
                            <th class="text-center"><dt>WANITA</dt></th>
                            <th class="text-center"><dt>BEBAS</dt></th>
                            <th class="text-center"><dt>OPT</dt></th>
                        </tr>
                    </thead>
                    
                    <?php
                        $url ="$url_aplicare/rest/bed/read/$kode_ppk/0/100";
                        //KONFIGURASI
                        date_default_timezone_set('UTC');
                        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                        //Creat Signature
                        $signature = hash_hmac('sha256', $consid."&".$timestamp, $secret_key, true);
                        // base64 encode…
                        $encodedSignature = base64_encode($signature);
                        $ch=curl_init();
                        $headers = array(
                            'X-signature: '.$encodedSignature.'',
                            'X-timestamp: '.$timestamp.'' ,
                            'X-cons-id: '.$consid .'',
                            'user_key: '.$user_key.'',
                            'Content-Type: Application/JSON',          
                            'Accept: Application/JSON'     
                        ); 
                        $headers = array(
                            'X-signature: '.$encodedSignature.'',
                            'X-timestamp: '.$timestamp.'' ,
                            'X-cons-id: '.$consid .'',
                            'user_key: '.$user_key.'',
                            'Content-Type: Application/JSON',          
                            'Accept: Application/JSON'
                        );
                        $ch = curl_init();
                        curl_setopt($ch,CURLOPT_URL, "$url");
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch,CURLOPT_HEADER, 0);
                        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $content = curl_exec($ch);
                        $err = curl_error($ch);
                        curl_close($ch);
                        $data =json_decode($content, true);
                        if(empty($data["response"]["list"])){
                            $list="";
                        }else{
                            $list=$data["response"]["list"];
                        }
                        $totalitems=$data["metadata"]["totalitems"];
                        if($content==false){
                            echo "Maaf, Tidak ada koneksi!! $send $data2 $data";
                        }else{
                            if(empty($totalitems)){
                            }else{
                                for($a=0; $a<$totalitems; $a++){
                                    $tersedia=$list[$a]['tersedia'];
                                    $kodekelas=$list[$a]['kodekelas'];
                                    $namakelas=$list[$a]['namakelas'];
                                    $tersediapria=$list[$a]['tersediapria'];
                                    $tersediawanita=$list[$a]['tersediawanita'];
                                    $koderuang=$list[$a]['koderuang'];
                                    $tersediapriawanita=$list[$a]['tersediapriawanita'];
                                    $namaruang=$list[$a]['namaruang'];
                                    $rownumber=$list[$a]['rownumber'];
                                    $kapasitas=$list[$a]['kapasitas'];
                                    $lastupdate=$list[$a]['lastupdate'];
                                    echo "<tr class='isi'>";
                                    echo "  <td align='center'>$rownumber</td>";
                                    echo "  <td align='left'>";
                                    echo '      <a href="javascript:void(0);" class="text-primary" data-toggle="modal" data-target="#ModalDetailRuanganBpjs" data-id="'.$namaruang.','.$namakelas.','.$kapasitas.','.$tersediapria.','.$tersediawanita.','.$tersediapriawanita.','.$lastupdate.','.$kodekelas.'">';
                                    echo "          $lastupdate";
                                    echo "      </a>";
                                    echo "  </td>";
                                    echo "  <td align='left'>$namaruang</td>";
                                    echo "  <td align='left'>$namakelas</td>";
                                    echo "  <td align='right'>$kapasitas</td>";
                                    echo "  <td align='right'>$tersediapria</td>";
                                    echo "  <td align='right'>$tersediawanita</td>";
                                    echo "  <td align='right'>$tersediapriawanita</td>";
                                    echo "  <td align='center'>";
                                    echo "          <button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#ModalDeleteRuanganBpjs' data-id='$kodekelas,$koderuang'><i class='ti ti-trash'></i></button>";
                                    echo "  </td>";
                                    echo "</tr>";
                                }
                            }
                        }
                    ?>
                </table>
            </div>
            <div class="card-footer bg-dark">
                <Button type="button" class="btn btn-md btn-round btn-success mt-2 mr-2" data-toggle="modal" data-target="#ModalTambahAaplicare">
                    <i class="ti ti-plus"></i> Tambah Ruangan
                </Button>
                <Button type="button" class="btn btn-md btn-round btn-danger mt-2 mr-2" data-toggle="modal" data-target="#ModalHapusSemuaAplicare">
                    <i class="ti ti-trash"></i> Hapus Semua Data Aplicare
                </Button>
                <a href="index.php?Page=KelasRuangan&Sub=Aplicare" class="btn btn-md btn-round btn-info mt-2 mr-2">
                    <i class="ti ti-reload"></i> Reload
                </a>
            </div>
        </div>
    </div>
</div>
