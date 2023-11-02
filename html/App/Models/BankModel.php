<?php

if (!defined('ACCESS_ALLOWED')) die('Direct access not permitted');

class BankModel {

    private $pdo;

    public function __construct() {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "Fw38!PhPs1stm";
        $dbname = "PACPaymentManagementSystemDB";
        $this->pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    }

    public function getAllBank() {
        $stmt = $this->pdo->prepare("SELECT * FROM Bank");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getBankByName($data) {
        
        $BankName = $data['BankName'];
        $stmt = $this->pdo->prepare("SELECT id FROM Bank WHERE Name = :BankName LIMIT 1");
        $stmt->execute([':BankName' => $BankName]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return $result['id'];
        } else {
            return null;  
        }
    }

    public function updateBankCategory($data) {
        try {
            $bankStatus = ($data['BankStatus'] === "True") ? 1 : 0;
            $stmt = $this->pdo->prepare("UPDATE Bank SET idBankCategory = ?, Name = ?, Description = ?, BankStatus = ? WHERE id = ?");
            $result = $stmt->execute([intval($data['Category']), $data['Name'], $data['Description'], $bankStatus, $data['id']]);
            
            return $result;
        } catch (PDOException $e) {
            $this->logError("PDO Error: " . $e->getMessage());
            return false;
        }
    }

    public function addBank($name, $description) {
        $query = "INSERT INTO Bank (idBankCategory, Name, Description, BankStatus) VALUES (1, ?, ?, ?)";
        
        $status = true;
        $stmt = $this->pdo->prepare($query);

        return $stmt->execute([$name, $description, $status]);
    }

    public function getBankCategoryNameByBankName($bankName) {
        $stmt = $this->pdo->prepare("
            SELECT bc.Name 
            FROM Bank b 
            JOIN BankCategory bc ON b.idBankCategory = bc.id 
            WHERE b.Name = :bankName
        ");
        $stmt->execute([':bankName' => $bankName]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function logError($message) {
        $timestamp = date("Y-m-d H:i:s");
        $logMessage = "[{$timestamp}] - {$message}\n";
        file_put_contents(__DIR__ . '/error_log.txt', $logMessage, FILE_APPEND);
    }
    
}
?>