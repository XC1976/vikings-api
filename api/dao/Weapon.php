<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/database.php';

function findOneWeapon(string $id) {
    $db = getDatabaseConnection();
    $sql = "SELECT id, type, damage FROM Weapon WHERE id = :id";
    $stmt = $db->prepare($sql);
    $res = $stmt->execute(['id' => $id]);
    if ($res) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return null;
}
function deleteWeapon(string $id) {
    $db = getDatabaseConnection();
    $sql = "DELETE FROM Weapon WHERE id = :id";
    $stmt = $db->prepare($sql);
    $res = $stmt->execute(['id' => $id]);
    if ($res) {
        return $stmt->rowCount();
    }
    return null;
}

function createWeapon(string $type, int $damage) {
    $db = getDatabaseConnection();
    $sql = "INSERT INTO Weapon (type, damage) VALUES (:type, :damage)";
    $stmt = $db->prepare($sql);
    $res = $stmt->execute(['type' => $type, 'damage' => $damage]);
    if ($res) {
        return $db->lastInsertId();
    }
    return null;
}
function updateWeapon(string $id, string $type, int $damage) {
    $db = getDatabaseConnection();
    $sql = "UPDATE Weapon SET type = :type, damage = :damage WHERE id = :id";
    $stmt = $db->prepare($sql);
    $res = $stmt->execute(['id' => $id, 'type' => $type, 'damage' => $damage]);
    if ($res) {
        return $stmt->rowCount();
    }
    return null;
}

function findAllWeapons(string $name = "", int $limit = 10, int $offset = 0) {
    $db = getDatabaseConnection();
    $params = [];
    $sql = "SELECT id, type, damage FROM Weapon";
    if ($name) {
        $sql .= " WHERE type LIKE :name";
        $params[':name'] = '%' . $name . '%';
    }
    $sql .= " LIMIT $limit OFFSET $offset ";
    $stmt = $db->prepare($sql);
    $res = $stmt->execute($params);
    if ($res) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return null;
}

function retrieveWeaponStats($weaponID) {
    $db = getDatabaseConnection();
    $sql = "SELECT type, damage FROM Weapon WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute(['id' => $weaponID]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $res;
}