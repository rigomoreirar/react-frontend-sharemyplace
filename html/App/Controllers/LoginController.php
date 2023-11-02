<?php

if(!defined('ACCESS_ALLOWED')) die('Direct access not permitted');

require_once __DIR__ . '/../Models/LoginModel.php';
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/PermissionModel.php';

class LoginController {

    private $loginModel;
    private $userModel;
    private $permissionModel;

    public function __construct() {
        $this->loginModel = new LoginModel();
        $this->userModel = new UserModel();
        $this->permissionModel = new PermissionModel();
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if($_POST['type'] === 'Login'){
                $username = $_POST["username"];
                $password = $_POST["password"];
                $user = $this->loginModel->validateCredentials($username, $password);
                
                if ($user) {
                    $userId = $this->userModel->getUserId($username);
                    $idValue = $userId['id'];

                    if ($this->userModel->getUserActivated($idValue)['Activated'] == 0){
                        $this->loginModel->recordUserLogin($idValue);  // Record the login
                    $userPermission = $this->userModel->getUserPermission($idValue);
                    $permissionValue = $userPermission['PermissionID'];
                    
                    $permissionLevel = $this->permissionModel->getLevelPermissionById($permissionValue);
                    $LevelValue = $permissionLevel['Level'];
                
                    if ($LevelValue === 0) {
                        header("Location: /dashboard_root");
                        exit;
                    }
                    if ($LevelValue === 1) {
                        header("Location: /dashboard_edit");
                        exit;
                    }
                    if ($LevelValue === 2) {
                        header("Location: /dashboard_upload");
                        exit;
                    }
                    if ($LevelValue === 3) {
                        header("Location: /dashboard_root");
                        exit;
                    }
                    // You can add more conditions for other permission levels in the future
                    } else {
                        echo "No permissions";
                    include __DIR__ . '/../Views/Login/Login.php';
                    }

                } else {
                    echo "Invalid username or password!";
                    include __DIR__ . '/../Views/Login/Login.php';
                }
            } else {
                include __DIR__ . '/../Views/Login/Login.php';
            }
        } else {
            include __DIR__ . '/../Views/Login/Login.php';
        }
    }


    public function logout() {
        session_destroy();
        
        header("Location: /login");
        exit;
    }
    
}
?>
