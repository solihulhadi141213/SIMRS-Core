<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Menangkap id_kunjungan
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="row">';
        echo '<div class="col-md-12"><span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span></div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        //Apakah Ada Data Procedure
        $id_encounter=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_encounter');
        if(empty($id_encounter)){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <span class="text-danger">';
            echo '          Data Kunjungan Tidak Terdaftar Pada Encounter, Silahkan Tambah Encounter Terlebih Dulu';
            echo '      </span>';
            echo '  </div>';
            echo '</div>';
        }else{
            $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
            $Token=GenerateTokenSatuSehat($Conn);
            $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
            if(empty($SettingSatuSehat)){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <span class="text-danger">';
                echo '          Tidak Ada Setting Satu Sehat Yang Aktif!';
                echo '      </span>';
                echo '  </div>';
                echo '</div>';
            }else{
                if(empty($Token)){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-danger">';
                    echo '      Gagal Melakukan Generate Token!';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    if(empty($baseurl_satusehat)){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-danger">';
                        echo '      Tidak Ada Base URL Satu Sehat!';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        $response=ProcedurByEncounter($baseurl_satusehat,$Token,$id_encounter);
                        $json_decode =json_decode($response, true);
                        if(empty($json_decode['entry'])){
                            echo '<div class="row">';
                            echo '  <div class="col-md-12 text-danger">';
                            echo '      Belum Ada Data Procedur, Silahkan Tambahkan Terlebih Dulu';
                            echo '  </div>';
                            echo '</div>';
                        }else{
                            $entry=$json_decode['entry'];
                            if(empty(count($entry))){
                                echo '<div class="row">';
                                echo '  <div class="col-md-12 text-danger">';
                                echo '      Belum Ada Data Procedur, Silahkan Tambahkan Terlebih Dulu';
                                echo '  </div>';
                                echo '</div>';
                            }else{
                                foreach($entry as $entry_list){
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col-md-12">';
                                    echo '      <div class="card">';
                                    echo '          <div class="card-body">';
                                    if(!empty($entry_list['resource'])){
                                        $resource= $entry_list['resource'];
                                        $resourceId= $resource['id'];
                                        $status= $resource['status'];
                                        echo '              <div class="row">';
                                        echo '                  <div class="col-md-4"><dt>IHS Procedure</dt></div>';
                                        echo '                  <div class="col-md-8">';
                                        echo '                      <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailProcedure" data-id="'.$resourceId.'">';
                                        echo '                          <small class="text-mutted">'.$resourceId.' <i class="ti ti-new-window"></i></small>';
                                        echo '                      </a>';
                                        echo '                  </div>';
                                        echo '              </div>';
                                        if(!empty($resource['code']['coding'])){
                                            $ResourceCodeCoding=$resource['code']['coding'];
                                            foreach($ResourceCodeCoding as $ResourceCodeCodingList){
                                                $KodeProsedur=$ResourceCodeCodingList['code'];
                                                $NamaProsedur=$ResourceCodeCodingList['display'];
                                                echo '              <div class="row">';
                                                echo '                  <div class="col-md-4"><dt>Procedure</dt></div>';
                                                echo '                  <div class="col-md-8"><small class="text-mutted">'.$KodeProsedur.'|'.$NamaProsedur.'</small></div>';
                                                echo '              </div>';
                                            }
                                        }
                                        echo '              <div class="row">';
                                        echo '                  <div class="col-md-4"><dt>Status</dt></div>';
                                        echo '                  <div class="col-md-8"><small class="text-mutted">'.$status.'</small></div>';
                                        echo '              </div>';
                                        echo '          </div>';
                                        echo '          <div class="card-footer icon-btn">';
                                        echo '              <button class="btn waves-effect waves-dark btn-outline-dark btn-icon" data-toggle="modal" data-target="#ModalDetailProcedure" data-id="'.$resourceId.'" title="Detail Procedure">';
                                        echo '                  <i class="icofont-info-circle"></i>';
                                        echo '              </button>';
                                        echo '              <button class="btn waves-effect waves-dark btn-outline-dark btn-icon" data-toggle="modal" data-target="#ModalEditProcedure" data-id="'.$resourceId.'" title="Edit Procedure">';
                                        echo '                  <i class="icofont icofont-edit"></i>';
                                        echo '              </button>';
                                        // echo '              <button class="btn waves-effect waves-dark btn-outline-dark btn-icon" data-toggle="modal" data-target="#ModalHapusProcedure" data-id="'.$resourceId.'" title="Hapus Procedure">';
                                        // echo '                  <i class="icofont icofont-trash"></i>';
                                        // echo '              </button>';
                                        echo '          </div>';
                                        echo '      </div>';
                                        echo '  </div>';
                                        echo '</div>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>