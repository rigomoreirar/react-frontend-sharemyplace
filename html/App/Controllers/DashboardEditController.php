<?php

if (!defined('ACCESS_ALLOWED')) die('Direct access not permitted');

require_once __DIR__ . '/../Models/PACRecordModel.php';
require_once __DIR__ . '/../Models/PACRecordHistoryModel.php';
require_once __DIR__ . '/../Models/PACResponseModel.php';
require_once __DIR__ . '/../Models/BankModel.php';

class DashboardEditController {

    private $pacRecordModel;
    private $pacRecordHistoryModel;
    private $pacResponseModel;
    private $BankModel;


    public function __construct(/*$firstDate, $secondDate*/) {
        $this->pacRecordModel = new PACRecordModel();
        $this->pacRecordHistoryModel = new PACRecordHistoryModel();
        $this->BankModel = new BankModel();
        $this->pacResponseModel = new PACResponseModel();

    }


    public function showEditDashboard() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        
        $firstDate = $_GET['firstDate'] ?? null;
        $secondDate = $_GET['secondDate'] ?? null;
    
        $pacRecords = $this->pacRecordModel->getRecordsByDate($firstDate, $secondDate);  
        $responseNames = $this->pacResponseModel->getAllPACResponse();
        $bankNames = $this->BankModel->getAllBank();
            
        include __DIR__ . '/../Views/Dashboards/DashboardEdit.php';
    }
    

    public function showInputEditDashboard() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        
        include __DIR__ . '/../Views/Dashboards/DashboardInputEdit.php';
    }

    public function updatePACHistoryRecords() {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input) {
                throw new Exception('Invalid input received.');
            }
            
            $idPACRecordHistory = $this->pacRecordHistoryModel->saveValues($input['data'], $_SESSION['user_id']);;

            

            $resultUpdatePacRecord = $this->pacRecordModel->updatePacRecord($input['data'], $_SESSION['user_id']);
            

            $result = $resultUpdatePacRecord && $idPACRecordHistory;

            
            if ($result) {
                header('Content-Type: application/json');
                http_response_code(200);
                echo json_encode(['success' => true]);
            } else {
                $this->logError('Unable to update the record. Result was false.');
                throw new Exception('Unable to update the record. Result was false.');
            }

            
        } catch (Exception $e) {

            header('Content-Type: application/json', true, 500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);

        }
    }

    public function getBankCategoryName($bankName) {
        try {
            $result = $this->BankModel->getBankCategoryNameByBankName($bankName);
            if ($result) {
                header('Content-Type: application/json');
                http_response_code(200);
                echo json_encode(['name' => $result['Name']]);
            } else {
                throw new Exception('No bank category found for the given bank name.');
            }
        } catch (Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    

    private function logError($message) {
        $timestamp = date("Y-m-d H:i:s");
        $logMessage = "[{$timestamp}] - {$message}\n";
        file_put_contents(__DIR__ . '/error_log.txt', $logMessage, FILE_APPEND);
    }
}
?>