<?php

if (!defined('ACCESS_ALLOWED')) die('Direct access not permitted');

class UserModel {

    private $pdo;

    public function __construct() {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "Fw38!PhPs1stm";
        $dbname = "PACPaymentManagementSystemDB";
        $this->pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    public function getAllUsers() {
        $stmt = $this->pdo->prepare("SELECT * FROM User");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsers__2__3() {
        $stmt = $this->pdo->prepare("SELECT * FROM User WHERE PermissionID = 2 OR PermissionID = 3");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserId($username) {
        $stmt = $this->pdo->prepare("SELECT id FROM User WHERE Username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserActivated($userId) {
        $stmt = $this->pdo->prepare("SELECT Activated FROM User WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getUserPermission($userId) {
        $stmt = $this->pdo->prepare("SELECT PermissionID FROM User WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($data) {
        try {

            $activatedValue = 1;

            if ($data['Activated'] == 0){
                $activatedValue = 0;
            }

            $stmt = $this->pdo->prepare("UPDATE User SET Username = ?, Name = ?, Password = ?, Activated = ?, PermissionID = ? WHERE id = ?");
            $result = $stmt->execute([$data['Username'], $data['Name'], $data['Password'], $activatedValue, intval($data['Authorization']), intval($data['id'])]);
            
            return $result;
        } catch (PDOException $e) {
            $this->logError("PDO Error: " . $e->getMessage());
            return false;
        }
    }
    
    
    public function addUser($username, $password, $name) {
        $query = "INSERT INTO User (Username, Name, Password, Activated, CreatedAt, PermissionID) VALUES (?, ?, ?, ?, ?, ?)";
        
        $Activated = 1;
        $stmt = $this->pdo->prepare($query);
        $now = date("Y-m-d H:i:s");  
        $defaultPermission = 1;  
        return $stmt->execute([$username, $name, $password, $Activated, $now, $defaultPermission]);
    }
    

    private function logError($message) {
        $timestamp = date("Y-m-d H:i:s");
        $logMessage = "[{$timestamp}] - {$message}\n";
        file_put_contents(__DIR__ . '/error_log.txt', $logMessage, FILE_APPEND);
    }
}
    

