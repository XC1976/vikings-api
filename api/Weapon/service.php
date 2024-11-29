<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';

function verifyWeapon($weapon): bool {
    $name = trim($weapon['type']);
    if (strlen($name) < 3) {
        returnError(412, 'Name must be at least 3 characters long');
    }

    $damage = intval($weapon['damage']);
    if ($damage < 1) {
        returnError(412, 'Health must be a positive and non zero number');
    }
    return true;
}