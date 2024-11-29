<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/Weapon.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/Weapon/service.php';

header('Content-Type: application/json');

if (!methodIsAllowed('update')) {
    returnError(405, 'Method not allowed');
    return;
}

$data = getBody();

if (!isset($_GET['id'])) {
    returnError(400, 'Missing parameter : id');
}

$id = intval($_GET['id']);

if (validateMandatoryParams($data, ['type', 'damage'])) {
    verifyWeapon($data);

    $res = retrieveWeaponStats($id);
    if($res['type'] == $data['type'] && $res['damage'] == $data['damage']) {
        $string = 'No values were changed for viking id : ' . $id;
        echo json_encode(['message' => $string]);
        http_response_code(201);
        return;
    }

    $updated = updateWeapon($id, $data['type'], $data['damage']);
    if ($updated == 1) {
        http_response_code(204);
    } elseif ($updated == 0) {
        returnError(404, 'Weapon not found');
    } else {
        returnError(500, 'Could not update the weapon');
    }
} else {
    returnError(412, 'Mandatory parameters : type, damage');
}