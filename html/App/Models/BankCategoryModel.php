<?php

if (!defined('ACCESS_ALLOWED')) die('Direct access not permitted');

class BankCategoryModel {

    private $pdo;

    public function __construct() {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "Fw38!PhPs1stm";
        $dbname = "PACPaymentManagementSystemDB";
        $this->pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    }

    public function getBankCategoryIdByName($data) {

        $Name = $data['Category'];

        $stmt = $this->pdo->prepare("SELECT id FROM BankCategory WHERE Name = :Category");
        $result = $stmt->execute(['Category' => $Name]);
        return $result;
    }

    public function getAllBankCategory() {
        $stmt = $this->pdo->prepare("SELECT * FROM BankCategory");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSingleBankCategoryById($bankCategory) {
        $stmt = $this->pdo->prepare("SELECT Name FROM BankCategory WHERE id = :bankCategory");
        $stmt->bindParam(':bankCategory', $bankCategory, PDO::PARAM_INT);
        $stmt->execute();
        // $this->logError('This is the result: '.json_encode($stmt->fetch(PDO::FETCH_ASSOC)));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    
}
?>