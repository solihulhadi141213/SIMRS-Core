<?php
    // Koneksi, helper, dan session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    function escapeEncounterDetail($value){
        if(!is_scalar($value) && $value !== null){
            $value = json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        return htmlspecialchars((string)($value ?? '-'), ENT_QUOTES, 'UTF-8');
    }

    function showEncounterDetailAlert($message){
        echo '
            <div class="alert alert-danger text-center">
                <small>'.escapeEncounterDetail($message).'</small>
            </div>
        ';
        exit;
    }

    function rowEncounterDetail($label, $value){
        echo '
            <div class="row mb-2">
                <div class="col-4"><small>'.$label.'</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text-muted">'.escapeEncounterDetail($value).'</small></div>
            </div>
        ';
    }

    function getEncounterDetailCoding($codeableConcept){
        if(!is_array($codeableConcept)){
            $codeableConcept = [];
        }
        $coding = $codeableConcept['coding'][0] ?? [];
        if(!is_array($coding)){
            $coding = [];
        }

        return [
            'system'  => $coding['system'] ?? '-',
            'code'    => $coding['code'] ?? '-',
            'display' => $coding['display'] ?? ($codeableConcept['text'] ?? '-')
        ];
    }

    function getEncounterDetailOutcomeMessage($data){
        $diagnostics = $data['issue'][0]['diagnostics'] ?? '';
        $details = $data['issue'][0]['details']['text'] ?? '';
        if(is_scalar($diagnostics) && $diagnostics !== ''){
            return (string)$diagnostics;
        }
        if(is_scalar($details) && $details !== ''){
            return (string)$details;
        }
        return 'SATUSEHAT tidak mengembalikan detail error.';
    }

    function getEncounterDetailConceptValues($items){
        if(!is_array($items)){
            return '-';
        }

        $values = [];
        foreach($items as $item){
            $concept = getEncounterDetailCoding($item);
            $display = $concept['display'] ?? '-';
            if(is_scalar($display) && $display !== '-' && $display !== ''){
                $values[] = $display;
            }
        }

        return empty($values) ? '-' : implode(', ', $values);
    }

    function getEncounterDetailReferenceValues($items, $key){
        if(!is_array($items)){
            return '-';
        }

        $values = [];
        foreach($items as $item){
            if(!is_array($item)){
                continue;
            }
            $reference = $item[$key] ?? [];
            if(!is_array($reference)){
                continue;
            }
            $display = $reference['display'] ?? $reference['reference'] ?? '';
            if(is_scalar($display) && $display !== ''){
                $values[] = $display;
            }
        }

        return empty($values) ? '-' : implode(', ', $values);
    }

    function getEncounterDetailParticipantTypes($participants){
        if(!is_array($participants)){
            return '-';
        }

        $types = [];
        foreach($participants as $participant){
            if(!is_array($participant)){
                continue;
            }
            $participantTypes = $participant['type'] ?? [];
            if(!is_array($participantTypes)){
                continue;
            }
            foreach($participantTypes as $type){
                $concept = getEncounterDetailCoding($type);
                $display = $concept['display'] ?? '-';
                if(is_scalar($display) && $display !== '-' && $display !== ''){
                    $types[] = $display;
                }
            }
        }

        return empty($types) ? '-' : implode(', ', $types);
    }

    function getEncounterDetailParticipantActors($participants){
        if(!is_array($participants)){
            return '-';
        }

        $actors = [];
        foreach($participants as $participant){
            $actor = is_array($participant) ? ($participant['individual'] ?? []) : [];
            if(!is_array($actor)){
                continue;
            }
            $display = $actor['display'] ?? $actor['reference'] ?? '';
            if(is_scalar($display) && $display !== ''){
                $actors[] = $display;
            }
        }

        return empty($actors) ? '-' : implode(', ', $actors);
    }

    // Validasi sesi dan ID Encounter
    if(empty($SessionIdAkses)){
        showEncounterDetailAlert('Sesi Akses Berakhir, Silahkan Login Ulang!');
    }

    if(empty($_POST['id_encounter'])){
        showEncounterDetailAlert('ID Encounter Tidak Ditemukan, Silahkan Coba Lagi!');
    }

    if(!is_scalar($_POST['id_encounter'])){
        showEncounterDetailAlert('ID Encounter Tidak Valid!');
    }

    $id_encounter = trim((string)$_POST['id_encounter']);
    if(!preg_match('/^[A-Za-z0-9.-]{1,64}$/', $id_encounter)){
        showEncounterDetailAlert('ID Encounter Tidak Valid!');
    }

    // Ambil token SATUSEHAT
    $tokenResult = generateTokenSatuSehat($Conn);
    if(($tokenResult['status'] ?? 'error') !== 'success'){
        showEncounterDetailAlert(
            'Terjadi kesalahan generate token SATUSEHAT. ' .
            ($tokenResult['message'] ?? 'Generate token gagal.')
        );
    }

    $token = trim((string)($tokenResult['token'] ?? ''));
    if($token === ''){
        showEncounterDetailAlert('Token SATUSEHAT tidak tersedia.');
    }

    // Ambil URL SATUSEHAT yang aktif
    $baseurl_satusehat = rtrim(trim((string)getDataDetail(
        $Conn,
        'setting_satusehat',
        'status_setting_satusehat',
        1,
        'url_satusehat'
    )), '/');

    if($baseurl_satusehat === ''){
        showEncounterDetailAlert('Base URL SATUSEHAT Tidak Ditemukan, Silahkan Cek Konfigurasi!');
    }
    $url_encounter = "$baseurl_satusehat";

    // Buka detail Encounter dari SATUSEHAT
    $detail_encounter = EncounterById($url_encounter, $token, $id_encounter);
    if($detail_encounter === ''){
        showEncounterDetailAlert('Gagal menerima response Encounter dari SATUSEHAT.');
    }

    $data = json_decode($detail_encounter, true);
    if(json_last_error() !== JSON_ERROR_NONE || !is_array($data)){
        showEncounterDetailAlert('Response SATUSEHAT bukan JSON valid.');
    }

    if(($data['resourceType'] ?? '') === 'OperationOutcome'){
        showEncounterDetailAlert(getEncounterDetailOutcomeMessage($data));
    }

    if(($data['resourceType'] ?? '') !== 'Encounter'){
        showEncounterDetailAlert('Response SATUSEHAT tidak sesuai dengan Resource Encounter.');
    }

    // Pemetaan data Encounter
    $class             = getEncounterDetailCoding($data['class'] ?? []);
    $type              = getEncounterDetailCoding($data['type'][0] ?? []);
    $serviceType       = getEncounterDetailCoding($data['serviceType'] ?? []);
    $subject           = $data['subject'] ?? [];
    $serviceProvider   = $data['serviceProvider'] ?? [];
    $period             = $data['period'] ?? [];
    $status             = $data['status'] ?? '-';
    $id                 = $data['id'] ?? '-';
    $resourceType       = $data['resourceType'] ?? '-';
    $versionId          = $data['meta']['versionId'] ?? '-';
    $lastUpdated        = $data['meta']['lastUpdated'] ?? '-';
    $reasonText         = getEncounterDetailConceptValues($data['reasonCode'] ?? []);
    $diagnosisDisplay   = getEncounterDetailReferenceValues($data['diagnosis'] ?? [], 'condition');
    $locationDisplay    = getEncounterDetailReferenceValues($data['location'] ?? [], 'location');
    $participantDisplay = getEncounterDetailParticipantTypes($data['participant'] ?? []);
    $participantActors  = getEncounterDetailParticipantActors($data['participant'] ?? []);
    $rawJson            = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
?>
<div class="row mb-2">
    <div class="col-12"><small><b><i>A. Informasi Resource</i></b></small></div>
</div>
<?php
    rowEncounterDetail('ID Encounter', $id);
    rowEncounterDetail('Resource Type', $resourceType);
    rowEncounterDetail('Status', $status);
    rowEncounterDetail('Version ID', $versionId);
    rowEncounterDetail('Last Updated', $lastUpdated);
?>
<hr>
<div class="row mb-2">
    <div class="col-12"><small><b><i>B. Klasifikasi Encounter</i></b></small></div>
</div>
<?php
    rowEncounterDetail('Class System', $class['system']);
    rowEncounterDetail('Class Code', $class['code']);
    rowEncounterDetail('Class Display', $class['display']);
    rowEncounterDetail('Type', $type['display']);
    rowEncounterDetail('Service Type', $serviceType['display']);
?>
<hr>
<div class="row mb-2">
    <div class="col-12"><small><b><i>C. Pasien dan Pelayanan</i></b></small></div>
</div>
<?php
    rowEncounterDetail('Subject Reference', $subject['reference'] ?? '-');
    rowEncounterDetail('Subject Display', $subject['display'] ?? '-');
    rowEncounterDetail('Service Provider Reference', $serviceProvider['reference'] ?? '-');
    rowEncounterDetail('Service Provider Display', $serviceProvider['display'] ?? '-');
    rowEncounterDetail('Participant Type', $participantDisplay);
    rowEncounterDetail('Participant', $participantActors);
?>
<hr>
<div class="row mb-2">
    <div class="col-12"><small><b><i>D. Periode dan Detail Klinis</i></b></small></div>
</div>
<?php
    rowEncounterDetail('Periode Mulai', $period['start'] ?? '-');
    rowEncounterDetail('Periode Selesai', $period['end'] ?? '-');
    rowEncounterDetail('Alasan', $reasonText);
    rowEncounterDetail('Diagnosis', $diagnosisDisplay);
    rowEncounterDetail('Lokasi', $locationDisplay);
?>
<hr>
<div class="row mb-2">
    <div class="col-12">
        <small><b><i>E. Raw JSON Response</i></b></small>
        <pre class="small bg-light p-3 rounded border mt-2" style="max-height:300px; overflow:auto;"><?php echo escapeEncounterDetail($rawJson); ?></pre>
    </div>
</div>
