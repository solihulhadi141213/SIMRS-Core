<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i:s');
    if(empty($_POST['keyword_organization'])){
        echo '<span class="text-danger">Kata Kunci Tidak Boleh Kosong!</span>';
    }else{
        $KywordOrganization=$_POST['keyword_organization'];
        //Inisiasi Setting
        $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
        if(empty($SettingSatuSehat)){
            echo '<span class="text-danger">Tidak Ada Setting Satu Sehat Yang Aktif!</span>';
        }else{
            $Token=GenerateTokenSatuSehat($Conn);
            if(empty($Token)){
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Melakukan Generate Token!</span>';
            }else{
                //Inisiasi BaseURL
                $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
                $SearchBy="name";
                //Pencarian Berdasarkan Nama Dan Part OF
                $response=organizationSearchBy($baseurl_satusehat,$Token,$SearchBy,$KywordOrganization);
                $JsonData =json_decode($response, true);
                if(empty($JsonData['entry'])){
                    echo '<span class="text-danger">Hasil Pencarian Tidak Ditemukan!</span>';
                }else{
                    if(empty($JsonData['total'])){
                        echo '<span class="text-danger">Hasil Pencarian Tidak Ditemukan!</span>';
                    }else{
                        if(empty($JsonData['entry'])){
                            echo '<span class="text-danger">Hasil Pencarian Tidak Ditemukan!</span>';
                        }else{
                            $entry=$JsonData['entry'];
                            $link=$JsonData['link'];
                            $resourceType=$JsonData['resourceType'];
                            $total=$JsonData['total'];
                            $type=$JsonData['type'];
                            $JumlahEntry=count($entry);
                            $JumlahLink=count($link);
                            if(!empty($JumlahEntry)){
                                $no=1;
                                foreach($entry as $value_entry){
                                    $fullUrl=$value_entry['fullUrl'];
                                    $resource=$value_entry['resource'];
                                    $active=$resource['active'];
                                    $id=$resource['id'];
                                    $identifier=$resource['identifier'];
                                    $lastUpdated=$resource['meta']['lastUpdated'];
                                    $versionId=$resource['meta']['versionId'];
                                    $name=$resource['name'];
                                    $resourceType=$resource['resourceType'];
                                    if(empty($resource['telecom'])){
                                        $telecom="";
                                    }else{
                                        $telecom=$resource['telecom'];
                                    }
                                    if(empty($resource['type'])){
                                        $type="";
                                    }else{
                                        $type=$resource['type'];
                                    }
                                    echo '<div class="row sub-title">';
                                    echo '  <div class="col-md-12">';
                                    echo '      <dt>';
                                    echo '          <a href="javascript:void(0);" class="text-primary PilihOrganization" value="'.$id.'">';
                                    echo '              '.$no.'. '.$name.'';
                                    echo '          </a>';
                                    echo '      </dt>';
                                    echo '      <ul class="ml-3">';
                                    echo '          <li>ID Org <code class="text-secondary" id="GetIdOrganization'.$id.'">'.$id.'</code></li>';
                                    echo '          <li>Update <code class="text-secondary">'.$lastUpdated.'</code></li>';
                                    echo '      </ul>';
                                    echo '  </div>';
                                    echo '</div>';
                                    $no++;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
<script>
    $(".PilihOrganization").click(function() {
        var id_organization = $(this).attr('value');
        $('#manufacturer').val(id_organization);
        $('#ModalCariOrganization').modal('hide');
    });

</script>