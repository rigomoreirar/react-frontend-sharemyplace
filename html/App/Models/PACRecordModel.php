<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!defined('ACCESS_ALLOWED')) die('Direct access not permitted');

class PACRecordModel {

    private $pdo;

    public function __construct() {
        $host = '127.0.0.1';
        $db = 'PACPaymentManagementSystemDB';
        $user = 'root';
        $pass = 'Fw38!PhPs1stm';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function saveCsvToPacRecord($filename, $userId, $fileNumber) {  

        $csvData = file_get_contents($filename);
        $lines = explode(PHP_EOL, $csvData);
        $headers = str_getcsv(array_shift($lines));
        
        foreach ($lines as $line) {
            $data = str_getcsv($line);
            if (count($data) == count($headers)) {
                $record = array_combine($headers, $data);

                $urlParts = parse_url($record['Memo3'] ?? '');
                $hostParts = explode('.', $urlParts['host'] ?? '');
                $companyName = $hostParts[0] ?? 'AddValue';
    
                try {
                    $stmt = $this->pdo->prepare("INSERT INTO PACRecord (idUser, idResponse, idBank, Name, Address1, Address2, PhoneNumber, AccountNumber, RoutingNumber, Amount, CheckNumber, Memo1, Memo2, Memo3, Memo4, CompanyName, FileNumber, Outcome, CreatedAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    
                    $values = [
                        $userId,  
                        1,
                        1,
                        $record['Name'] ?? 'AddValue',
                        $record['Address1'] ?? 'AddValue',
                        $record['Address2'] ?? 'AddValue',
                        $record['PhoneNumber'] ?? 'AddValue',
                        $record['AccountNumber'] ?? 'AddValue',
                        $record['RoutingNumber'] ?? 'AddValue',
                        $record['Amount'] ?? 'AddValue',
                        $record['CheckNumber'] ?? 'AddValue',
                        $record['Memo1'] ?? 'AddValue',
                        $record['Memo2'] ?? 'AddValue',
                        $record['Memo3'] ?? 'AddValue',
                        $record['Memo4'] ?? 'AddValue',
                        $companyName,
                        $fileNumber,
                        $record['Outcome'] ?? 'AddValue'
                    ];
    
                    $stmt->execute($values);
                } catch (\PDOException $e) {
                    throw new \PDOException($e->getMessage(), (int)$e->getCode());
                }
            }
        }
    }
    
    public function updatePacRecord($data, $idUser) {
        try {
            $sql = "UPDATE PACRecord SET 
                idResponse = ?, 
                idBank = ?, 
                Name = ?, 
                Address1 = ?, 
                Address2 = ?, 
                PhoneNumber = ?, 
                AccountNumber = ?, 
                RoutingNumber = ?, 
                Amount = ?, 
                CheckNumber = ?, 
                Memo1 = ?, 
                Memo2 = ?, 
                Memo3 = ?, 
                Memo4 = ?, 
                CompanyName = ?, 
                FileNumber = ?, 
                Outcome = ?, 
                CreatedAt = NOW() 
                WHERE id = ?";
            
            $stmt = $this->pdo->prepare($sql);
    
            $values = [
                $data['ResponseName'],
                $data['BankName'],
                $data['Name'],
                $data['Address1'],
                $data['Address2'],
                $data['PhoneNumber'],
                $data['AccountNumber'],
                $data['RoutingNumber'],
                $data['Amount'],
                $data['CheckNumber'],
                $data['Memo1'],
                $data['Memo2'],
                $data['Memo3'],
                $data['Memo4'],
                $data['CompanyName'],
                $data['FileNumber'],
                $data['Outcome'],
                $data['id']
            ];
    
            $stmt->execute($values);
            return true; 
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    

    public function getAllRecords() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM PACRecord");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    

    public function getRecordsByDate($firstDate, $secondDate) {
        try {
            $query = "SELECT 
                         PR.*, 
                         PACR.Name as ResponseName, 
                         B.Name as BankName,
                         BC.Name as BankCategoryName
                      FROM 
                         PACRecord PR
                      LEFT JOIN 
                         PACResponse PACR ON PR.idResponse = PACR.id
                      LEFT JOIN 
                         Bank B ON PR.idBank = B.id
                      LEFT JOIN
                         BankCategory BC ON B.idBankCategory = BC.id
                      WHERE 
                         PR.CreatedAt >= :startDate AND PR.CreatedAt <= :endDate";
    
            $stmt = $this->pdo->prepare($query);
    
            $startDateWithTime = $firstDate . ' 00:00:00';
            $endDateWithTime = $secondDate . ' 23:59:59';
    
            $stmt->bindParam(':startDate', $startDateWithTime);
            $stmt->bindParam(':endDate', $endDateWithTime);
    
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    
    
    
    
}
