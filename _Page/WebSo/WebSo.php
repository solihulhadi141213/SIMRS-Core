<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="index.php?Page=WebSo" class="h5"><i class="ti-medall"></i> Struktur Organisasi</a>
                    </h5>
                    <p class="m-b-0">Kelola Struktur Organisasi</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="card table-card">
                            <div class="card-header border-info">
                                <form action="javascript:void(0);" id="BatasPencarian">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <dt>List Struktur Organiasasi</dt>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-sm btn-block btn-primary" data-toggle="modal" data-target="#ModalTambahSo">
                                                <i class="ti-plus text-white"></i> Tambah
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="table table-responsive">
                                    <table class="table table-border table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center"><dt>Image</dt></th>
                                                <th class="text-center"><dt>Boss</dt></th>
                                                <th class="text-center"><dt>Key</dt></th>
                                                <th class="text-center"><dt>Nama</dt></th>
                                                <th class="text-center"><dt>Job Title</dt></th>
                                                <th class="text-center"><dt>NIP</dt></th>
                                                <th class="text-center"><dt>Update Time</dt></th>
                                                <th class="text-center"><dt>Option</dt></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                //Menampilkan data
                                                include "_Config/SettingKoneksiWeb.php";
                                                include "_Config/WebFunction.php";
                                                include "_Page/WebSo/FungsiSo.php";
                                                $url=urlService('List So');
                                                //Akses Data Dari Server Website
                                                $KirimData = array(
                                                    'api_key' => $api_key
                                                );
                                                $json = json_encode($KirimData);
                                                //Mulai CURL
                                                $ch = curl_init();
                                                curl_setopt($ch,CURLOPT_URL, "$url");
                                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                                curl_setopt($ch,CURLOPT_HEADER, 0);
                                                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                                                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                $content = curl_exec($ch);
                                                $err = curl_error($ch);
                                                curl_close($ch);
                                                if(!empty($err)){
                                                    echo '<tr>';
                                                    echo '  <td colspan="9">';
                                                    echo '      '.$err.'';
                                                    echo '  </td>';
                                                    echo '</tr>';
                                                }else{
                                                    $JsonData =json_decode($content, true);
                                                    if(!empty($JsonData['metadata']['massage'])){
                                                        $massage=$JsonData['metadata']['massage'];
                                                    }else{
                                                        $massage="Tidak Ada Pesan Response";
                                                    }
                                                    if(!empty($JsonData['metadata']['code'])){
                                                        $code=$JsonData['metadata']['code'];
                                                    }else{
                                                        $code="Kode Tidak Diketahui";
                                                    }
                                                    if($code!==200){
                                                        echo '<tr>';
                                                        echo '  <td colspan="9">';
                                                        echo '      '.$massage.'';
                                                        echo '  </td>';
                                                        echo '</tr>';
                                                    }else{
                                                        $JumlahBaris=count($JsonData['response']['list']);
                                                        if(empty($JumlahBaris)){
                                                            echo 'Tidak Ada Data Yang Ditampilkan';
                                                        }else{
                                                            $list_data=$JsonData['response']['list'];
                                                            //Nomor 1 Dst
                                                            foreach($list_data as $value){
                                                                $id_struktur_organisasi=$value['id_struktur_organisasi'];
                                                                $key_struktur_organisasi=$value['key_struktur_organisasi'];
                                                                $boss=$value['boss'];
                                                                $nama=$value['nama'];
                                                                $job_title=$value['job_title'];
                                                                $NIP=$value['NIP'];
                                                                $updatetime=$value['updatetime'];
                                                                $foto=$value['foto'];
                                                                $strtotime=strtotime($updatetime);
                                                                $updatetime=date('d/m/Y H:i',$strtotime);
                                            ?>
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            <img src="<?php echo "$foto"; ?>" alt="" width="50px">
                                                                        </td>
                                                                        <td class="text-center"><?php echo "$boss"; ?></td>
                                                                        <td class="text-center"><?php echo "$key_struktur_organisasi"; ?></td>
                                                                        <td class="text-left"><?php echo "$nama"; ?></td>
                                                                        <td class="text-left"><?php echo "$job_title"; ?></td>
                                                                        <td class="text-left"><?php echo "$NIP"; ?></td>
                                                                        <td class="text-left"><?php echo "$updatetime"; ?></td>
                                                                        <td class="text-center">
                                                                            <div class="btn-group dropdown-split-inverse">
                                                                                <button type="button" class="btn btn-sm btn-inverse dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                                                                                    <i class="ti ti-settings"></i>
                                                                                </button>
                                                                                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                                    <div class="dropdown-divider"></div>
                                                                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalEditSo" data-id="<?php echo $id_struktur_organisasi;?>" title="Edit Poliklinik">
                                                                                        <i class="ti-pencil"></i> Edit
                                                                                    </a>
                                                                                    <div class="dropdown-divider"></div>
                                                                                    <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapustSo" data-id="<?php echo "$id_struktur_organisasi"; ?>" title="Hapus Poliklinik">
                                                                                        <i class="ti-trash"></i> Hapus
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                            <?php
                                                            }
                                                        }
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>