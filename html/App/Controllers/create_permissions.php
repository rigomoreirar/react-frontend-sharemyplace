<?php
class resetPermissionsController {
    function resetPermissions() {
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

            // Insert root permission            
            $stmt = $pdo->prepare("INSERT INTO Permissions (Name, Level) VALUES ('root', '0')");
            $stmt->execute();

            echo "Permission 'root' added successfully.<br>";

            // Insert edit permission
            $stmt = $pdo->prepare("INSERT INTO Permissions (Name, Level) VALUES ('edit', '1')");
            $stmt->execute();

            echo "Permission 'edit' added successfully.<br>";

            // Insert upload permission
            $stmt = $pdo->prepare("INSERT INTO Permissions (Name, Level) VALUES ('upload', '2')");
            $stmt->execute();

            echo "Permission 'upload' added successfully.<br>";

            // Insert upload_edit permission
            $stmt = $pdo->prepare("INSERT INTO Permissions (Name, Level) VALUES ('upload_edit', '3')");
            $stmt->execute();

            echo "Permission 'upload_edit' added successfully.<br>";

            // Insert temporal PAC State 
            $stmt = $pdo->prepare("INSERT INTO PACResponse (Name, Description, PACStatus) VALUES ('editable', 'editable', 0)");
            $stmt->execute();

            echo "'temporal PAC State' added successfully.<br>";

            // Insert Category  
            $stmt = $pdo->prepare("INSERT INTO BankCategory (Name) VALUES ('editable')");
            $stmt->execute();

            echo "'editable' added successfully.<br>";

            // Insert Category  
            $stmt = $pdo->prepare("INSERT INTO BankCategory (Name) VALUES ('Do not call')");
            $stmt->execute();

            echo "'Do not call' added successfully.<br>";

            echo "'Bank' added successfully.<br>";

            // Insert Category  
            $stmt = $pdo->prepare("INSERT INTO BankCategory (Name) VALUES ('Do not take')");
            $stmt->execute();

            echo "'Do not call' added successfully.<br>";

            echo "'Bank' added successfully.<br>";

            // Insert Category  
            $stmt = $pdo->prepare("INSERT INTO BankCategory (Name) VALUES ('Valid')");
            $stmt->execute();

            echo "'Do not call' added successfully.<br>";

            // Insert temporal Bank  
            $stmt = $pdo->prepare("INSERT INTO Bank (idBankCategory, Name, Description, BankStatus) VALUES (1, 'editable', 'editable', 0)");
            $stmt->execute();

            echo "'Bank' added successfully.<br>";

            

        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
