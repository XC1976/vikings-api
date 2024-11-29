<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/viking.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/viking/service.php';

header('Content-Type: application/json');

if (!methodIsAllowed('update')) {
    returnError(405, 'Method not allowed');
    return;
}

$data = getBody();

if (validateMandatoryParams($data, ['weaponID', 'id'])) {

    if(verifyWeaponExists($data['weaponID']) == 0) {
        returnError(404, 'Weapon does not exist');
    }

    if(retrieveVikingWeapon($data['id']) == $data['weaponID']) {
        $string = 'The weaponID of viking id : ' . $data['id'] .  ' is already the value : ' . $data['weaponID'];
        echo json_encode(['message' => $string]);
        http_response_code(201);
        exit;
    }

    $updated = updateVikingWeapon($data['id'], $data['weaponID']);
    if ($updated == 1) {
        echo json_encode(['weaponId' => $data['weaponID']]);
        http_response_code(201);
    } elseif ($updated == 0) {
        returnError(404, 'The viking does not exist');
    } else {
        returnError(500, 'Could not update the viking');
    }
} else {
    returnError(412, 'Mandatory parameters : weaponID, id');
}