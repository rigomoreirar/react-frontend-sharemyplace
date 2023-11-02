<?php

if (!defined('ACCESS_ALLOWED')) die('Direct access not permitted');

class PermissionModel {

    private $pdo;

    public function __construct() {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "Fw38!PhPs1stm";
        $dbname = "PACPaymentManagementSystemDB";
        $this->pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    }

    public function getAllPermissions() {
        $stmt = $this->pdo->prepare("SELECT * FROM Permissions");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getSinglePermissionById($permissionId) {
        $stmt = $this->pdo->prepare("SELECT Name FROM Permissions WHERE id = :permissionId");
        $stmt->bindParam(':permissionId', $permissionId, PDO::PARAM_INT);
        $stmt->execute();
        // $this->logError('This is the result: '.json_encode($stmt->fetch(PDO::FETCH_ASSOC)));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getLevelPermissionById($permissionId) {
        $stmt = $this->pdo->prepare("SELECT Level FROM Permissions WHERE id = :permissionId");
        $stmt->bindParam(':permissionId', $permissionId, PDO::PARAM_INT);
        $stmt->execute();
        // $this->logError('This is the result: '.json_encode($stmt->fetch(PDO::FETCH_ASSOC)));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


}
