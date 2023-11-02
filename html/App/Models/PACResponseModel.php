<?php

if (!defined('ACCESS_ALLOWED')) die('Direct access not permitted');

class PACResponseModel {

    private $pdo;

    public function __construct() {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "Fw38!PhPs1stm";
        $dbname = "PACPaymentManagementSystemDB";
        $this->pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    }

    public function getAllPACResponse() {
        $stmt = $this->pdo->prepare("SELECT * FROM PACResponse");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPACResponseByName($data) {
        $PACResponseName = $data['ResponseName'];
        $stmt = $this->pdo->prepare("SELECT id FROM PACResponse WHERE Name = :PACResponseName LIMIT 1");
        $stmt->execute([':PACResponseName' => $PACResponseName]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return $result['id'];
        } else {
            return null;  
        }
    }
    


    public function addPACResponse($name, $description) {
        $query = "INSERT INTO PACResponse (Name, Description, PACStatus) VALUES (?, ?, ?)";
        
        $status = true;
        $stmt = $this->pdo->prepare($query);

        return $stmt->execute([$name, $description, $status]);
    }

    public function updatePACResponse($data) {
        try {
            $pacStatus = ($data['PACStatus'] === "True") ? 1 : 0;
            $stmt = $this->pdo->prepare("UPDATE PACResponse SET Name = ?, Description = ?, PACStatus = ? WHERE id = ?");
            $result = $stmt->execute([$data['Name'], $data['Description'], $pacStatus, $data['id']]);
            
            return $result;
        } catch (PDOException $e) {
            $this->logError("PDO Error: " . $e->getMessage());
            return false;
        }
    }
    

    private function logError($message) {
        $timestamp = date("Y-m-d H:i:s");
        $logMessage = "[{$timestamp}] - {$message}\n";
        file_put_contents(__DIR__ . '/error_log.txt', $logMessage, FILE_APPEND);
    }
    
}
