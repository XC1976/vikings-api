<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/database.php';

function findOneViking(string $id) {
    $db = getDatabaseConnection();
    $sql = "SELECT id, name, health, attack, defense, COALESCE(CONCAT('/Weapon/findOne.php?id=', weaponID), '') AS weaponID 
    FROM viking WHERE id = :id";
    $stmt = $db->prepare($sql);
    $res = $stmt->execute(['id' => $id]);
    if ($res) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return null;
}

function findAllVikings (string $name = "", int $limit = 10, int $offset = 0) {
    $db = getDatabaseConnection();
    $params = [];
    $sql = "SELECT id, name, health, attack, defense, COALESCE(CONCAT('/Weapon/findOne.php?id=', weaponID), '') AS weaponID FROM viking";
    if ($name) {
        $sql .= " WHERE name LIKE :name";
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

function findVikingsByWeaponID(int $weaponID, int $limit = 10, int $offset = 0) {
    $db = getDatabaseConnection();
    $sql = "SELECT id, name, health, attack, defense, COALESCE(CONCAT('/Weapon/findOne.php?id=', weaponID), '') AS weaponID 
            FROM viking 
            WHERE weaponID = :weaponID 
            LIMIT :limit OFFSET :offset";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':weaponID', $weaponID, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $res = $stmt->execute();
    if ($res) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return null;
}

function createViking(string $name, int $health, int $attack, int $defense, int $weaponID) {
    $db = getDatabaseConnection();
    $sql = "INSERT INTO viking (name, health, attack, defense, weaponID) VALUES (:name, :health, :attack, :defense, :weaponID)";
    $stmt = $db->prepare($sql);
    $res = $stmt->execute(['name' => $name, 'health' => $health, 'attack' => $attack, 'defense' => $defense, 
    'weaponID' => $weaponID]);
    if ($res) {
        return $db->lastInsertId();
    }
    return null;
}

function updateViking(string $id, string $name, int $health, int $attack, int $defense, $weaponID) {
    $db = getDatabaseConnection();
    $sql = "UPDATE viking SET name = :name, health = :health, attack = :attack, defense = :defense, weaponID = :weaponID WHERE id = :id";
    $stmt = $db->prepare($sql);
    $res = $stmt->execute(['id' => $id, 'name' => $name, 'health' => $health, 'attack' => $attack, 'defense' => $defense, 
    'weaponID' => $weaponID]);
    if ($res) {
        return $stmt->rowCount();
    }
    return null;
}

function updateVikingWeapon(int $id, int $weaponID) {
    $db = getDatabaseConnection();
    $sql = "UPDATE viking SET weaponID = :weaponID WHERE id = :id";
    $stmt = $db->prepare($sql);
    $res = $stmt->execute(['weaponID' => $weaponID, 'id' => $id]);
    if($stmt->rowCount() > 0) {
        return 1;
    } else {
        return 0;
    }
}

function retrieveVikingWeapon($vikingID) {
    $db = getDatabaseConnection();
    $sql = "SELECT weaponID FROM viking WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute(['id' => $vikingID]);
    $res = $stmt->fetchColumn();
    
    return $res;
}

function retrieveVikingStats($vikingID) {
    $db = getDatabaseConnection();
    $sql = "SELECT name, attack, defense, health, weaponID FROM viking WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute(['id' => $vikingID]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $res;
}


function deleteViking(string $id) {
    $db = getDatabaseConnection();
    $sql = "DELETE FROM viking WHERE id = :id";
    $stmt = $db->prepare($sql);
    $res = $stmt->execute(['id' => $id]);
    if ($res) {
        return $stmt->rowCount();
    }
    return null;
}