<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/viking.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';

header('Content-Type: application/json');

if (!methodIsAllowed('read')) {
    returnError(405, 'Method not allowed');
    return;
}

$name = '';
$limit = 10;
$offset = 0;

if(!isset($_GET['id'])) {
    returnError(400, 'Missing parameter : id');
}

$vikings = findVikingsByWeaponID($_GET['id'], $limit, $offset);

$result = [];

foreach ($vikings as $viking) {
    $result[] = [
        'name' => $viking['name'],
        'health' => $viking['health'],
        'attack' => $viking['attack'],
        'defense' => $viking['defense'],
        'weaponID' => $viking['weaponID']
    ];
}

echo json_encode($result, JSON_PRETTY_PRINT);