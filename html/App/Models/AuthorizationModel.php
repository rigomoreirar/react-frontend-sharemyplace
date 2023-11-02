<?php

if (!defined('ACCESS_ALLOWED')) die('Direct access not permitted');

class AuthorizationModel {

    private $pdo;

    public function __construct() {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "Fw38!PhPs1stm";
        $dbname = "PACPaymentManagementSystemDB";
        $this->pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    }

    public function getAuthorizationByUserId($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM Authorization WHERE idUser = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        // $this->logError('This is the result: '.json_encode($stmt->fetch(PDO::FETCH_ASSOC)));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addNewAuthorization($userId, $permissionId) {
        $stmt = $this->pdo->prepare("INSERT INTO Authorization (idUser, idPermissions, CreatedAt) VALUES (:userId, :permissionId, NOW())");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':permissionId', $permissionId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // public function updateAthorization($data){
    //     $stmt = $this->pdo->prepare("UPDATE Authorization SET idPermissions = ? WHERE idUser = ?");
    //     return $stmt->execute([$data['Authorization'], , $data['id']]);
    // }

    private function logError($message) {
        $timestamp = date("Y-m-d H:i:s");
        $logMessage = "[{$timestamp}] - {$message}\n";
        file_put_contents(__DIR__ . '/error_log.txt', $logMessage, FILE_APPEND);
    }

}
