<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!defined('ACCESS_ALLOWED')) die('Direct access not permitted');

class PACRecordHistoryModel {

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

    
    public function saveValues($data, $idUser) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM PACRecord WHERE id = :idPACRecord");
            $stmt->execute([':idPACRecord' => $data['id']]);
            $oldData = $stmt->fetch();
            
            $now = date('Y-m-d H:i:s');

            $newData = [
                'idUser' => $idUser,
                'idResponse' => $data['ResponseName'],
                'idBank' => $data['BankName'],
                'Name' => $data['Name'],
                'Address1' => $data['Address1'],
                'Address2' => $data['Address2'],
                'PhoneNumber' => $data['PhoneNumber'],
                'AccountNumber' => $data['AccountNumber'],
                'RoutingNumber' => $data['RoutingNumber'],
                'Amount' => $data['Amount'],
                'CheckNumber' => $data['CheckNumber'],
                'Memo1' => $data['Memo1'],
                'Memo2' => $data['Memo2'],
                'Memo3' => $data['Memo3'],
                'Memo4' => $data['Memo4'],
                'CompanyName' => $data['CompanyName'],
                'FileNumber' => $data['FileNumber'],
                'Outcome' => $data['Outcome'],
                'CreatedAt' => $now
            ];
    
            $newValues = json_encode($newData);
            $oldValuesJson = json_encode($oldData);
    
            $insertStmt = $this->pdo->prepare("
                INSERT INTO PACRecordHistory (idPACRecord, idUser, OldValues, NewValues, ModifiedAt) 
                VALUES (:idPACRecord, :idUser, :oldValues, :newValues, NOW())
            ");
            $insertStmt->execute([
                ':idPACRecord' => $data['id'],
                ':idUser' => $idUser,
                ':oldValues' => $oldValuesJson,
                ':newValues' => $newValues
            ]);
    
            return true;
    
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }    

    public function getLogsBetweenDates($firstDate, $secondDate) {
        try {
            // If both dates are the same, adjust the secondDate to include up to the end of that day.
            if ($firstDate === $secondDate) {
                $secondDate .= ' 23:59:59';
            }
    
            $stmt = $this->pdo->prepare("
                SELECT 
                    prh.ModifiedAt as Date, 
                    u.Username as User,
                    prh.OldValues as Modified,
                    prh.NewValues as New,
                    pr.*
                FROM PACRecordHistory prh
                JOIN User u ON prh.idUser = u.id
                JOIN PACRecord pr ON prh.idPACRecord = pr.id
                WHERE prh.ModifiedAt >= :firstDate AND prh.ModifiedAt <= :secondDate
            ");
            $stmt->execute([':firstDate' => $firstDate, ':secondDate' => $secondDate]);
            $logs = $stmt->fetchAll();
    
            foreach ($logs as &$log) {
                $log['Latest'] = json_encode($log);
            }
            
            foreach ($logs as &$log) {
                $log['Latest'] = json_encode([
                    'id' => $log['id'],
                    'idUser' => $log['idUser'],
                    'idResponse' => $log['idResponse'],
                    'idBank' => $log['idBank'],
                    'Name' => $log['Name'],
                    'Address1' => $log['Address1'],
                    'Address2' => $log['Address2'],
                    'PhoneNumber' => $log['PhoneNumber'],
                    'AccountNumber' => $log['AccountNumber'],
                    'RoutingNumber' => $log['RoutingNumber'],
                    'Amount' => $log['Amount'],
                    'CheckNumber' => $log['CheckNumber'],
                    'Memo1' => $log['Memo1'],
                    'Memo2' => $log['Memo2'],
                    'Memo3' => $log['Memo3'],
                    'Memo4' => $log['Memo4'],
                    'CompanyName' => $log['CompanyName'],
                    'FileNumber' => $log['FileNumber'],
                    'Outcome' => $log['Outcome'],
                    'CreatedAt' => $log['CreatedAt']                    
                ]);
            }

            return $logs;
    
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    

}
