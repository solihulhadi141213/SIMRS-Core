<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Menangkap id_kunjungan
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="row">';
        echo '<div class="col-md-12 text-center"><span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span></div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        echo '<div class="row mb-3 mt-3 mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <button type="button" class="btn btn-sm btn-block btn-outline-dark" data-toggle="modal" data-target="#ModalTambahComposition" data-id="'.$id_kunjungan.'">';
        echo '          <i class="ti ti-plus"></i> Tambah Composition';
        echo '      </button>';
        echo '  </div>';
        echo '</div>';
        //Apakah Ada Data Comosition
        $id_kunjungan_composition=getDataDetail($Conn,"kunjungan_composition",'id_kunjungan',$id_kunjungan,'id_kunjungan_composition');
        if(empty($id_kunjungan_composition)){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <span class="text-danger">';
            echo '          Tidak Ada Data Composition, Silahkan Tambah Terlebih Dulu';
            echo '      </span>';
            echo '  </div>';
            echo '</div>';
        }else{
            $no=1;
            $query = mysqli_query($Conn, "SELECT*FROM kunjungan_composition WHERE id_kunjungan='$id_kunjungan' ORDER BY id_kunjungan_composition DESC");
            while ($data = mysqli_fetch_array($query)) {
                $id_kunjungan_composition= $data['id_kunjungan_composition'];
                $status= $data['status'];
                $title= $data['title'];
                $tanggal= $data['tanggal'];
                echo '<div class="row mb-2">';
                echo '  <div class="col-md-12">';
                echo '      <div class="card">';
                echo '          <div class="card-body">';
                if(!empty($data['id_composition'])){
                    $id_composition= $data['id_composition'];
                    echo '              <div class="row">';
                    echo '                  <div class="col-md-4"><dt>IHS Composition</dt></div>';
                    echo '                  <div class="col-md-8">';
                    echo '                      <a href="javascript:void(0);" class="text-info" data-toggle="modal" data-target="#ModalDetailComposition" data-id="'.$id_composition.'">';
                    echo '                          <small class="text-mutted">'.$id_composition.' <i class="ti ti-new-window"></i></small>';
                    echo '                      </a>';
                    echo '                  </div>';
                    echo '              </div>';
                }
                echo '              <div class="row">';
                echo '                  <div class="col-md-4"><dt>Title</dt></div>';
                echo '                  <div class="col-md-8"><small class="text-mutted">'.$title.'</small></div>';
                echo '              </div>';
                echo '              <div class="row">';
                echo '                  <div class="col-md-4"><dt>Tanggal</dt></div>';
                echo '                  <div class="col-md-8"><small class="text-mutted">'.$tanggal.'</small></div>';
                echo '              </div>';
                echo '          </div>';
                echo '          <div class="card-footer icon-btn">';
                echo '              <button class="btn waves-effect waves-dark btn-outline-dark btn-icon" data-toggle="modal" data-target="#ModalInfoComposition" data-id="'.$id_kunjungan_composition.'" title="Info Composition">';
                echo '                  <i class="icofont-info-circle"></i>';
                echo '              </button>';
                echo '              <button class="btn waves-effect waves-dark btn-outline-dark btn-icon" data-toggle="modal" data-target="#ModalEditComposition" data-id="'.$id_kunjungan_composition.'" title="Edit Composition">';
                echo '                  <i class="icofont icofont-edit"></i>';
                echo '              </button>';
                echo '              <button class="btn waves-effect waves-dark btn-outline-dark btn-icon" data-toggle="modal" data-target="#ModalHapusComposition" data-id="'.$id_kunjungan_composition.'" title="Hapus Composition">';
                echo '                  <i class="icofont icofont-trash"></i>';
                echo '              </button>';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
                $no++;
            }
        }
    }
?>