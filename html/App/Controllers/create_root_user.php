<?php
class resetRootUserController {
    function resetRoot() {
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
            $pdo = new PDO($dsn, $user, $pass, $options);

            // Insert 'root' user
            $stmt = $pdo->prepare("INSERT INTO User (Username, Name, Password, Activated, CreatedAt, PermissionID) VALUES ('root', 'root', 123, 0, NOW(), 1)");
            $stmt->execute();
            
            echo "User 'root' added successfully.<br>";

            // Insert 'edit' user
            $stmt = $pdo->prepare("INSERT INTO User (Username, Name, Password, Activated, CreatedAt, PermissionID) VALUES ('edit', 'edit', 123, 0, NOW(), 2)");
            $stmt->execute();
            
            echo "User 'edit' added successfully.<br>";

            // Insert 'upload' user
            $stmt = $pdo->prepare("INSERT INTO User (Username, Name, Password, Activated, CreatedAt, PermissionID) VALUES ('upload', 'upload', 123, 0, NOW(), 3)");
            $stmt->execute();
            
            echo "User 'upload' added successfully.<br>";

        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
