<?php

if (!defined('ACCESS_ALLOWED')) die('Direct access not permitted');

require_once __DIR__ . '/../Models/PACRecordModel.php';

class DashboardUploadController {

    private $pacRecordModel;


    public function __construct() {
        $this->pacRecordModel = new PACRecordModel();
    }

    public function showUploadDashboard() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
    
        ini_set('post_max_size', '50M');
        ini_set('upload_max_filesize', '50M');
    
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['csv'])) {

            $fileName = $_FILES['csv']['name'];
            
            $this->pacRecordModel->saveCsvToPacRecord($_FILES['csv']['tmp_name'], $_SESSION['user_id'], $fileName);
            
            echo 'Saved successfully!';
            include __DIR__ . '/../Views/Dashboards/DashboardUpload.php';
            exit;
        }
        include __DIR__ . '/../Views/Dashboards/DashboardUpload.php';
    }
    
}
?>