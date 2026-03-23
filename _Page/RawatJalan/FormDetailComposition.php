<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Menangkap id_composition
    if(empty($_POST['id_composition'])){
        echo '<div class="row">';
        echo '<div class="col-md-12 text-center"><span class="text-danger">ID Composition Tidak Boleh Kosong!</span></div>';
        echo '</div>';
    }else{
        $id_composition=$_POST['id_composition'];
        $SettingSatuSehat=getDataDetail($Conn,' setting_satusehat','status','Active','id_setting_satusehat');
        $Token=GenerateTokenSatuSehat($Conn);
        $baseurl_satusehat=getDataDetail($Conn,'setting_satusehat','status','Active','baseurl');
        if(empty($SettingSatuSehat)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-danger text-center">';
            echo '      Tidak Ada Setting Satu Sehat Yang Aktif!';
            echo '  </div>';
            echo '</div>';
        }else{
            if(empty($Token)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-danger text-center">';
                echo '      Gagal Melakukan Generate Token!';
                echo '  </div>';
                echo '</div>';
            }else{
                if(empty($baseurl_satusehat)){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-danger text-center">';
                    echo '      Tidak Ada Base URL Satu Sehat!';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    $response=CompositionById($baseurl_satusehat,$Token,$id_composition);
                    $json_decode =json_decode($response, true);
                    if(empty($json_decode['id'])){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-danger text-center">';
                        echo '      ID Condition Tidak Ditemukan';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        if(!empty($json_decode['id'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>ID Composition</dt></div>';
                            echo '  <div class="col-md-8 text-left"><small>'.$json_decode['id'].'</small></div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['resourceType'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Resource Type</dt></div>';
                            echo '  <div class="col-md-8 text-left"><small>'.$json_decode['resourceType'].'</small></div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['title'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Title</dt></div>';
                            echo '  <div class="col-md-8 text-left"><small>'.$json_decode['title'].'</small></div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['status'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Status</dt></div>';
                            echo '  <div class="col-md-8 text-left"><small>'.$json_decode['status'].'</small></div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['date'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-4"><dt>Date</dt></div>';
                            echo '  <div class="col-md-8 text-left"><small>'.$json_decode['date'].'</small></div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['subject'])){
                            if(!empty($json_decode['subject']['display'])){
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-12"><dt>Patient</dt></div>';
                                echo '</div>';
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-4"><small>Nama</small></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['subject']['display'].'</small></div>';
                                echo '</div>';
                            }
                            if(!empty($json_decode['subject']['reference'])){
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-4"><small>Referensi</small></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['subject']['reference'].'</small></div>';
                                echo '</div>';
                            }
                        }
                        if(!empty($json_decode['encounter'])){
                            if(!empty($json_decode['encounter']['display'])){
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-12"><dt>Encounter</dt></div>';
                                echo '</div>';
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-4"><small>Display</small></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['encounter']['display'].'</small></div>';
                                echo '</div>';
                            }
                            if(!empty($json_decode['encounter']['reference'])){
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-4"><small>Referensi</small></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['encounter']['reference'].'</small></div>';
                                echo '</div>';
                            }
                        }
                        if(!empty($json_decode['custodian'])){
                            if(!empty($json_decode['custodian']['reference'])){
                                $IdOrg=$json_decode['custodian']['reference'];
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-12"><dt>Organization</dt></div>';
                                echo '</div>';
                                echo '<div class="row mb-3">';
                                echo '  <div class="col-md-4"><small>Referense</small></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$json_decode['custodian']['reference'].'</small></div>';
                                echo '</div>';
                                //Explode 
                                $exploded_array = explode('/', $IdOrg);
                                $IdOrg=$exploded_array[1];
                                //Buka Data ID ORG
                                $NamaOrg=getDataDetail($Conn,' referensi_organisasi','ID_Org',$IdOrg,'nama');
                                if(!empty($NamaOrg)){
                                    echo '<div class="row mb-3">';
                                    echo '  <div class="col-md-4"><small>Nama Organisasi</small></div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$NamaOrg.'</small></div>';
                                    echo '</div>';
                                }
                            }
                        }
                        if(!empty($json_decode['author'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-12 mb-2"><dt>Practitioner</dt></div>';
                            echo '  <div class="col-md-12 text-left">';
                            $author=$json_decode['author'];
                            foreach($author as $ValueAuthor){
                                if(!empty($ValueAuthor['display'])){
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col-md-4"><small>Display</small></div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$ValueAuthor['display'].'</small></div>';
                                    echo '</div>';
                                }
                                if(!empty($ValueAuthor['reference'])){
                                    echo '<div class="row mb-2">';
                                    echo '  <div class="col-md-4"><small>Reference</small></div>';
                                    echo '  <div class="col-md-8 text-left"><small>'.$ValueAuthor['reference'].'</small></div>';
                                    echo '</div>';
                                }
                            }
                            echo '  </div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['category'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-12 mb-2"><dt>Category</dt></div>';
                            echo '  <div class="col-md-12 text-left">';
                            $category=$json_decode['category'];
                            foreach($category as $VaueCategory){
                                if(!empty($VaueCategory['coding'])){
                                    $coding=$VaueCategory['coding'];
                                    foreach($coding as $ValueCoding){
                                        if(!empty($ValueCoding['code'])){
                                            echo '<div class="row mb-2">';
                                            echo '  <div class="col-md-4"><small>Code</small></div>';
                                            echo '  <div class="col-md-8 text-left"><small>'.$ValueCoding['code'].'</small></div>';
                                            echo '</div>';
                                        }
                                        if(!empty($ValueCoding['display'])){
                                            echo '<div class="row mb-2">';
                                            echo '  <div class="col-md-4"><small>Display</small></div>';
                                            echo '  <div class="col-md-8 text-left"><small>'.$ValueCoding['display'].'</small></div>';
                                            echo '</div>';
                                        }
                                        if(!empty($ValueCoding['system'])){
                                            echo '<div class="row mb-2">';
                                            echo '  <div class="col-md-4"><small>System</small></div>';
                                            echo '  <div class="col-md-8 text-left"><small>'.$ValueCoding['system'].'</small></div>';
                                            echo '</div>';
                                        }
                                    }
                                }
                            }
                            echo '  </div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['meta'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-12 mb-2"><dt>Meta</dt></div>';
                            echo '  <div class="col-md-12 text-left">';
                            $meta=$json_decode['meta'];
                            if(!empty($meta['lastUpdated'])){
                                echo '<div class="row mb-2">';
                                echo '  <div class="col-md-4"><small>Last Update</small></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$meta['lastUpdated'].'</small></div>';
                                echo '</div>';
                            }
                            if(!empty($meta['versionId'])){
                                echo '<div class="row mb-2">';
                                echo '  <div class="col-md-4"><small>Version ID</small></div>';
                                echo '  <div class="col-md-8 text-left"><small>'.$meta['versionId'].'</small></div>';
                                echo '</div>';
                            }
                            echo '  </div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['section'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-12 mb-2"><dt>Section</dt></div>';
                            echo '  <div class="col-md-12 text-left">';
                            $section=$json_decode['section'];
                            foreach($section as $VaueSection){
                                if(!empty($VaueSection['code'])){
                                    $VaueSectionCode=$VaueSection['code'];
                                    if(!empty($VaueSectionCode['coding'])){
                                        $CodingSection=$VaueSectionCode['coding'];
                                        foreach($CodingSection as $ValueCodingSection){
                                            if(!empty($ValueCodingSection['code'])){
                                                echo '<div class="row mb-2">';
                                                echo '  <div class="col-md-4"><small>Code</small></div>';
                                                echo '  <div class="col-md-8 text-left"><small>'.$ValueCodingSection['code'].'</small></div>';
                                                echo '</div>';
                                            }
                                            if(!empty($ValueCodingSection['display'])){
                                                echo '<div class="row mb-2">';
                                                echo '  <div class="col-md-4"><small>Display</small></div>';
                                                echo '  <div class="col-md-8 text-left"><small>'.$ValueCodingSection['display'].'</small></div>';
                                                echo '</div>';
                                            }
                                            if(!empty($ValueCodingSection['system'])){
                                                echo '<div class="row mb-2">';
                                                echo '  <div class="col-md-4"><small>System</small></div>';
                                                echo '  <div class="col-md-8 text-left"><small>'.$ValueCodingSection['system'].'</small></div>';
                                                echo '</div>';
                                            }
                                        }
                                    }
                                }
                                if(!empty($VaueSection['text'])){
                                    if(!empty($VaueSection['text']['div'])){
                                        echo '<div class="row mb-2">';
                                        echo '  <div class="col-md-4"><small>DIV</small></div>';
                                        echo '  <div class="col-md-8 text-left"><small>'.$VaueSection['text']['div'].'</small></div>';
                                        echo '</div>';
                                    }
                                    if(!empty($VaueSection['text']['status'])){
                                        echo '<div class="row mb-2">';
                                        echo '  <div class="col-md-4"><small>Status</small></div>';
                                        echo '  <div class="col-md-8 text-left"><small>'.$VaueSection['text']['status'].'</small></div>';
                                        echo '</div>';
                                    }
                                }
                            }
                            echo '  </div>';
                            echo '</div>';
                        }
                        if(!empty($json_decode['type'])){
                            echo '<div class="row mb-3">';
                            echo '  <div class="col-md-12 mb-2"><dt>Type</dt></div>';
                            echo '  <div class="col-md-12 text-left">';
                            $type=$json_decode['type'];
                            if(!empty($type['coding'])){
                                $TypeCoding=$type['coding'];
                                foreach($TypeCoding as $ValueTypeCoding){
                                    if(!empty($ValueTypeCoding['code'])){
                                        echo '<div class="row mb-2">';
                                        echo '  <div class="col-md-4"><small>Code</small></div>';
                                        echo '  <div class="col-md-8 text-left"><small>'.$ValueTypeCoding['code'].'</small></div>';
                                        echo '</div>';
                                    }
                                    if(!empty($ValueTypeCoding['display'])){
                                        echo '<div class="row mb-2">';
                                        echo '  <div class="col-md-4"><small>Display</small></div>';
                                        echo '  <div class="col-md-8 text-left"><small>'.$ValueTypeCoding['display'].'</small></div>';
                                        echo '</div>';
                                    }
                                    if(!empty($ValueTypeCoding['system'])){
                                        echo '<div class="row mb-2">';
                                        echo '  <div class="col-md-4"><small>System</small></div>';
                                        echo '  <div class="col-md-8 text-left"><small>'.$ValueTypeCoding['system'].'</small></div>';
                                        echo '</div>';
                                    }
                                }
                            }
                            echo '  </div>';
                            echo '</div>';
                        }
                    }
                }
            }
        }
    }
?>