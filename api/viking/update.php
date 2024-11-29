<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/viking.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/viking/service.php';

header('Content-Type: application/json');

if (!methodIsAllowed('create')) {
    returnError(405, 'Method not allowed');
    return;
}

$data = getBody();

if (!isset($_GET['id'])) {
    returnError(400, 'Missing parameter : id');
}

$id = intval($_GET['id']);

$res = retrieveVikingStats($id);

if($res['name'] == $data['name'] && $res['attack'] == $data['attack'] && $res['defense'] == $data['defense'] && $res['health'] == $data['health'] && 
$res['weaponID'] == $data['weaponID']) {
    echo json_encode(['message' => 'No changes were made']);
    http_response_code(201);
    exit;
}

if (validateMandatoryParams($data, ['name', 'health', 'attack', 'defense', 'weaponID'])) {
    verifyViking($data);
    if(verifyWeaponExists($data['weaponID']) == 0) {
        $weaponID = null;
    } else {
        $weaponID = $data['weaponID'];
    }

    $updated = updateViking($id, $data['name'], $data['health'], $data['attack'], $data['defense'], 
    $weaponID);
    if ($updated == 1) {
        http_response_code(204);
    } elseif ($updated == 0) {
        returnError(404, 'The viking was not found');
    } else {
        returnError(500, 'Could not update the viking');
    }
} else {
    returnError(412, 'Mandatory parameters : name, health, attack, defense');
}