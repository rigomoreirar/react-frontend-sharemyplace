<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


session_start();

define('ACCESS_ALLOWED', true);

require_once __DIR__ . '/../App/Controllers/DashboardRootController.php';
require_once __DIR__ . '/../App/Controllers/DashboardUploadController.php';
require_once __DIR__ . '/../App/Controllers/DashboardEditController.php';
require_once __DIR__ . '/../App/Controllers/LoginController.php';
require_once __DIR__ . '/../App/Controllers/create_database.php';
require_once __DIR__ . '/../App/Controllers/create_root_user.php';
require_once __DIR__ . '/../App/Controllers/create_permissions.php';

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$loginController = new LoginController();
$dashboardRootController = new DashboardRootController();
$dashboardUploadController = new DashboardUploadController();
$dashboardEditController = new DashboardEditController();
$resetDB = new resetDBController();
$resetRoot = new resetRootUserController();
$reset_permissions = new resetPermissionsController();

switch ($request) {
    case '/' :
    case '/login' :
        $loginController->login();
        break;

    case '/dashboard_root' :
        $dashboardRootController->showDashboard();
        break;

    case '/dashboard_root/search_input' :
        $dashboardRootController->showSearchInputDashboard();
        break;

    case '/dashboard_root/search_input/search_by_date' :
        $dashboardRootController->showLogsBetweenDates(); 
        break;

    case '/dashboard_root/user_table' :
        $dashboardRootController->showUserDashboard();
        break;

    case '/dashboard_root/pac_response_table' :
        $dashboardRootController->showPacResponseDashboard();
        break;

    case '/dashboard_root/bank_table' :
        $dashboardRootController->showBankDashboard();
        break;

    case '/dashboard_root/user_table/add_user' :
        $dashboardRootController->AddUserForm();
        break;

    case '/dashboard_root/pac_response_table/add_pac_response' :
        $dashboardRootController->AddPacResponseForm();
        break;

    case '/dashboard_root/user_table/add_user/add_request' :
        $dashboardRootController->addDataRoot();
        break;

    case '/dashboard_root/pac_response_table/add_pac_response/add_request' :
        $dashboardRootController->addDataRoot();
        break;

    case '/dashboard_root/bank_table/add_bank/add_request' :
        $dashboardRootController->addDataRoot();
        break;

    case '/dashboard_root/bank_table/add_bank' :
        $dashboardRootController->AddBankForm();
        break;

    case '/dashboard_upload' :
        $dashboardUploadController->showUploadDashboard();
        break;

    case '/dashboard_edit' :
        $dashboardEditController->showInputEditDashboard();
        break;

    case '/dashboard_edit/table' :
        $dashboardEditController->showEditDashboard();
        break;
    
    case '/updatePACHistoryRecords' :
        $dashboardEditController->updatePACHistoryRecords();
        break;

    case '/logout' :
        $loginController->logout();
        break;

    case '/updateDataRoot':
        $dashboardRootController->updateDataRoot();
        break;      

        // This goes first
    case '/reset_database_/p3DkibT5pVPhfnzlM3pw' :
        $resetDB->resetDB();
        break;

        // This goes third
    case '/reset_root_/p3DkibT5pVPhfnzlM3pw' :
        $resetRoot->resetRoot();
        break;

        // This goes second
    case '/reset_permissions_/p3DkibT5pVPhfnzlM3pw' :
        $reset_permissions->resetPermissions();
        break;

    default:
        if (preg_match('/^\/getBankCategoryName\/([^\/]+)$/', $request, $matches)) {
            $bankName = $matches[1]; 
            $dashboardEditController->getBankCategoryName(urldecode($bankName)); 
            break;
        }

        echo 'error 404';
        break;

}
?>
