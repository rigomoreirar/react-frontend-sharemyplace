<?php

if (!defined('ACCESS_ALLOWED')) die('Direct access not permitted');

require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/PACResponseModel.php';
require_once __DIR__ . '/../Models/PermissionModel.php';
require_once __DIR__ . '/../Models/PACRecordHistoryModel.php';
require_once __DIR__ . '/../Models/AuthorizationModel.php';
require_once __DIR__ . '/../Models/BankModel.php';
require_once __DIR__ . '/../Models/BankCategoryModel.php';

class DashboardRootController {

    private $userModel;
    private $pacResponseModel;
    private $permissionModel;
    private $pacRecordHistoryModel;
    private $bankModel;
    private $bankCategoryModel;


    public function __construct() {
        $this->userModel = new UserModel();
        $this->pacResponseModel = new PACResponseModel();
        $this->permissionModel = new PermissionModel();
        $this->bankModel = new BankModel();
        $this->bankCategoryModel = new BankCategoryModel();
        $this->pacRecordHistoryModel = new PACRecordHistoryModel();
    }

    public function showDashboard() {

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['back'] != 1) {
            $option = $_POST["option"];
            
            switch ($option) {
                case 'UserTable':
                    header("Location: /dashboard_root/user_table");
                    exit;
                case 'PacResponseTable':
                    header("Location: /dashboard_root/pac_response_table");
                    exit;

                default:
                    echo 'CHOOSE AN OPTION';
                    break;

            }
        }

        include __DIR__ . '/../Views/Dashboards/DashboardRoot.php';
    }
    public function showUserDashboard() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
    
        $data = $this->fetchUserData();
        extract($data);  
    
        include __DIR__ . '/../Views/Dashboards/RootUsers.php';
    }
    
    

    public function showPacResponseDashboard() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
    
        $data = $this->fetchPacData();
        extract($data);  
    
        include __DIR__ . '/../Views/Dashboards/RootPacResponse.php';
    }

    public function showSearchInputDashboard() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        
        $data = $this->fetchUsers__2__3();
        extract($data);

        include __DIR__ . '/../Views/Dashboards/RootInputSearch.php';
    }

    public function showLogsBetweenDates() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        
        $firstDate = $_GET['firstDate'] ?? null;
        $secondDate = $_GET['secondDate'] ?? null;
        
        $rawLogs = $this->pacRecordHistoryModel->getLogsBetweenDates($firstDate, $secondDate);
        $Logs = $this->formatLogsForDisplay($rawLogs);
            
        include __DIR__ . '/../Views/Dashboards/RootShowLogsBetweenDates.php';
    }
    
    
    
    
    
    

    public function showBankDashboard() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
    
        $data = $this->fetchBankData();
        extract($data);  
    
        include __DIR__ . '/../Views/Dashboards/RootBank.php';
    }

    public function AddUserForm() {

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        include __DIR__ . '/../Views/Dashboards/RootAddUsers.php';
    }

    public function AddBankForm() {

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        include __DIR__ . '/../Views/Dashboards/RootAddBank.php';
    }

    public function AddPacResponseForm() {

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        include __DIR__ . '/../Views/Dashboards/RootAddPacResponse.php';
    }
    
    public function updateDataRoot() {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input) {
                throw new Exception('Invalid input received.');
            }
            
            switch ($input['type']) {
                case 'userTable':
                    $resultUpdateUser = $this->userModel->updateUser($input['data']);
                    $result = $resultUpdateUser;
                    break;

                case 'pacResponseTable':
                    $resultUpdatePacResponse = $this->pacResponseModel->updatePacResponse($input['data']);
                    $result = $resultUpdatePacResponse;
                    break;

                case 'bankTable':

                    $resultUpdateBank = $this->bankModel->updateBankCategory($input['data']);
                    
                    $result = $resultUpdateBank;
                    break;
                    
                default:
                    $result = false;
                    break;
            }
        
            if ($result) {
                header('Content-Type: application/json');
                http_response_code(200);
                echo json_encode(['success' => true]);
            } else {
                $this->logError('Unable to update the record. Result was false.');
                throw new Exception('Unable to update the record. Result was false.');
            }
        } catch (Exception $e) {
            $this->logError($e->getMessage());
            header('Content-Type: application/json', true, 500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    public function addDataRoot() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $name = $_POST["name"];
            $description = $_POST["description"];
            $input = $_POST['type'];
    
            switch ($input) {
                case 'userTable':
                    $result = $this->userModel->addUser($username, $password, $name);
    
                    if ($result) {
                        $data = $this->fetchUserData();
                        extract($data);  
                        include __DIR__ . '/../Views/Dashboards/RootUsers.php';  
                    } else {
                        echo 'there is something wrong';
                    }
                    break;
                case 'pacResponseTable':
                    $result = $this->pacResponseModel->addPacResponse($name, $description);
    
                    if ($result) {
                        $data = $this->fetchPacData();
                        extract($data);  
                        include __DIR__ . '/../Views/Dashboards/RootPacResponse.php';  
                    } else {
                        echo 'there is something wrong';
                    }
                    break;
                case 'bankTable':
                    $result = $this->bankModel->addBank($name, $description);
    
                    if ($result) {
                        $data = $this->fetchBankData();
                        extract($data);  
                        include __DIR__ . '/../Views/Dashboards/RootBank.php'; 
                    } else {
                        echo 'there is something wrong';
                    }
                    break;
    
                default:
                    $this->logError('Unable to add the record. Result was false.');
                    break;
            } 
        }
    }
    
    
    public function getUpdatedUsers() {
        $users = $this->userModel->getAllUsers();
        echo json_encode($users);
    }
    
    private function logError($message) {
        $timestamp = date("Y-m-d H:i:s");
        $logMessage = "[{$timestamp}] - {$message}\n";
        file_put_contents(__DIR__ . '/error_log.txt', $logMessage, FILE_APPEND);
    }
    
    private function fetchUserData() {
        $users = $this->userModel->getAllUsers();
        $permissions = $this->permissionModel->getAllPermissions();
    
        // Enhancing the user data with permission names:
        foreach ($users as &$user) {
            $permissionData = $this->permissionModel->getSinglePermissionById($user['PermissionID']);
            $user['Authorization'] = $permissionData['Name'];
        }
    
        return [
            'users' => $users,
            'permissions' => $permissions
        ];
    }
    private function fetchPacData() {
        $pacResponse = $this->pacResponseModel->getAllPACResponse();
    
        return [
            'pacResponses' => $pacResponse
        ];
    }
    private function fetchBankData() {
        $banks = $this->bankModel->getAllBank();
        $bankCategories = $this->bankCategoryModel->getAllBankCategory();

        foreach ($banks as &$bank) {
            $bankCategoryData = $this->bankCategoryModel->getSingleBankCategoryById($bank['idBankCategory']);
            $bank['Category'] = $bankCategoryData['Name'];
        }
    
        return [
            'Banks' => $banks,
            'Categories' => $bankCategories
        ];
    }
    private function fetchUsers__2__3() {

        $Users__1__2 = $this->userModel->getUsers__2__3();
        $permissions = $this->permissionModel->getAllPermissions();
    
        // Enhancing the user data with permission names:
        foreach ($Users__1__2 as &$user) {
            $permissionData = $this->permissionModel->getSinglePermissionById($user['PermissionID']);
            $user['Authorization'] = $permissionData['Name'];
        }
    
        return [
            'users' => $Users__1__2,
            'permissions' => $permissions
        ];
    }
    
    private function formatLogsForDisplay($Logs) {
        $formattedLogs = [];
    
        $displayNamesModifiedValues = [
            "idUser" => "Creator",
            "idResponse" => "Response",
            "idBank" => "Bank",
            "Name" => "Name",
            "Address1" => "Address 1",
            "Address2" => "Address 2",
            "PhoneNumber" => "Phone Number",
            "AccountNumber" => "Account Number",
            "RoutingNumber" => "Routing Number",
            "Amount" => "Amount",
            "CheckNumber" => "Check Number",
            "Memo1" => "Memo 1",
            "Memo2" => "Memo 2",
            "Memo3" => "Memo 3",
            "Memo4" => "Memo 4",
            "CompanyName" => "Company Name",
            "FileNumber" => "File Number",
            "Outcome" => "Outcome",
            "CreatedAt" => "Created At"            
        ];
    
        $displayNamesNewValues = [
            "idUser" => "Editor",
            "idResponse" => "Response",
            "idBank" => "Bank",
            "Name" => "Name",
            "Address1" => "Address 1",
            "Address2" => "Address 2",
            "PhoneNumber" => "Phone Number",
            "AccountNumber" => "Account Number",
            "RoutingNumber" => "Routing Number",
            "Amount" => "Amount",
            "CheckNumber" => "Check Number",
            "Memo1" => "Memo 1",
            "Memo2" => "Memo 2",
            "Memo3" => "Memo 3",
            "Memo4" => "Memo 4",
            "CompanyName" => "Company Name",
            "FileNumber" => "File Number",
            "Outcome" => "Outcome",      
            "CreatedAt" => "Modified At"       
        ];
    
        $displayNamesLatestValues = [
            "idUser" => "Creator",
            "idResponse" => "Response",
            "idBank" => "Bank",
            "Name" => "Name",
            "Address1" => "Address 1",
            "Address2" => "Address 2",
            "PhoneNumber" => "Phone Number",
            "AccountNumber" => "Account Number",
            "RoutingNumber" => "Routing Number",
            "Amount" => "Amount",
            "CheckNumber" => "Check Number",
            "Memo1" => "Memo 1",
            "Memo2" => "Memo 2",
            "Memo3" => "Memo 3",
            "Memo4" => "Memo 4",
            "CompanyName" => "Company Name",
            "FileNumber" => "File Number",
            "Outcome" => "Outcome",
            "CreatedAt" => "Created At"            
        ];
    
        foreach ($Logs as $Log) {
            $new = json_decode($Log['New'], true);
            $modified = json_decode($Log['Modified'], true);
            $latest = json_decode($Log['Latest'], true);
    
            unset($latest['id']);
            unset($modified['id']);
    
            $differingKeys = array_diff_assoc($new, $modified);
            $new = array_intersect_key($new, $differingKeys);
            $modified = array_intersect_key($modified, $differingKeys);
    
            $formattedLogs[] = [
                'Date' => $Log['Date'],
                'User' => $Log['User'],
                'Modified' => $this->formatLogArray($modified, $displayNamesModifiedValues),
                'New' => $this->formatLogArray($new, $displayNamesNewValues),
                'Latest' => $this->formatLogArray($latest, $displayNamesLatestValues)
            ];
        }
    
        return $formattedLogs;
    }
    
    private function formatLogArray($logArray, $displayNames) {
        $formattedArray = [];
        foreach ($logArray as $key => $value) {
            $displayName = $displayNames[$key] ?? $key; // Use custom display name if set, otherwise use the key itself
            $formattedArray[] = $displayName . ": " . $value;
        }
        return implode('<br>', $formattedArray);
    }
    
    

}
