<?php

if(!defined('ACCESS_ALLOWED')) die('Direct access not permitted');

class LoginModel {

    private $pdo;

    public function __construct() {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "Fw38!PhPs1stm";
        $dbname = "PACPaymentManagementSystemDB";
        $this->pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    }

    public function validateCredentials($username, $password) {
        $stmt = $this->pdo->prepare("SELECT id, Password FROM User WHERE Username = :username");
        $stmt->execute(['username' => $username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user != false){

            if ($user['Password'] === $password) {
                $_SESSION['user_id'] = $user['id'];
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
        
    }

    public function getUserPermissionLevel($userId) {
        $stmt = $this->pdo->prepare("SELECT p.Level FROM Authorization a JOIN Permissions p ON a.idPermissions = p.id WHERE a.idUser = :userId ORDER BY p.Level ASC LIMIT 1");
        $stmt->execute(['userId' => $userId]);

        return $stmt->fetchColumn();
    }

    public function recordUserLogin($userId) {
        $stmt = $this->pdo->prepare("INSERT INTO Login (idUser, CreatedAt) VALUES (:userId, NOW())");
        $stmt->execute(['userId' => $userId]);
    }
    
}
?>
