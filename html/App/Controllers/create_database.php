<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class resetDBController {

    private function executeSql($sql, $conn, $tableName) {
        if ($conn->query($sql) === TRUE) {
            echo "Table $tableName created successfully<br>";
        } else {
            echo "Error creating $tableName table: " . $conn->error . "<br>";
        }
    }

    function resetDB() {

        $servername = "127.0.0.1";
        $username = "root";
        $password = "Fw38!PhPs1stm";
        $conn = new mysqli($servername, $username, $password);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "DROP DATABASE IF EXISTS PACPaymentManagementSystemDB";
        $conn->query($sql);

        $sql = "CREATE DATABASE PACPaymentManagementSystemDB";
        $this->executeSql($sql, $conn, "Database PACPaymentManagementSystemDB");

        $conn->select_db("PACPaymentManagementSystemDB");

        // Start by creating the Permissions table
        $sql = "CREATE TABLE Permissions (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Name VARCHAR(50) NOT NULL,
            Level INT
        )";
        $this->executeSql($sql, $conn, "Permissions");

        // Then create the User table as it references the Permissions table
        $sql = "CREATE TABLE User (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Username VARCHAR(100) NOT NULL UNIQUE,
            Name VARCHAR(100) NOT NULL,
            Password VARCHAR(255) NOT NULL,
            Activated BOOLEAN,
            CreatedAt DATETIME,
            PermissionID INT(6) UNSIGNED,
            FOREIGN KEY (PermissionID) REFERENCES Permissions(id) ON DELETE CASCADE ON UPDATE CASCADE
        )";
        $this->executeSql($sql, $conn, "User");

        $sql = "CREATE TABLE PACResponse (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Name VARCHAR(50) NOT NULL UNIQUE,
            Description TEXT,
            PACStatus BOOLEAN
        )";
        $this->executeSql($sql, $conn, "PACStates");

        $sql = "CREATE TABLE BankCategory (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Name VARCHAR(50) NOT NULL UNIQUE
        )";
        $this->executeSql($sql, $conn, "PACStates");

        $sql = "CREATE TABLE Bank (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            idBankCategory INT(6) UNSIGNED,
            Name VARCHAR(50) NOT NULL UNIQUE,
            Description TEXT,
            BankStatus BOOLEAN,
            FOREIGN KEY (idBankCategory) REFERENCES BankCategory(id) ON DELETE CASCADE ON UPDATE CASCADE
        )";
        $this->executeSql($sql, $conn, "PACStates");

        

        $sql = "CREATE TABLE PACRecord (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            idUser INT(6) UNSIGNED,
            idResponse INT(6) UNSIGNED,
            idBank INT(6) UNSIGNED,
            Name VARCHAR(255),
            Address1 VARCHAR(255),
            Address2 VARCHAR(255),
            PhoneNumber VARCHAR(255),
            AccountNumber VARCHAR(255),
            RoutingNumber VARCHAR(255),
            Amount FLOAT,
            CheckNumber VARCHAR(255),
            Memo1 VARCHAR(255),
            Memo2 VARCHAR(255),
            Memo3 VARCHAR(255),
            Memo4 VARCHAR(255),
            CompanyName VARCHAR(255),
            FileNumber VARCHAR(255),
            Outcome VARCHAR(255),
            CreatedAt DATETIME,
            FOREIGN KEY (idUser) REFERENCES User(id) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (idResponse) REFERENCES PACResponse(id) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (idBank) REFERENCES Bank(id) ON DELETE CASCADE ON UPDATE CASCADE
        )";
        $this->executeSql($sql, $conn, "PACRecord");


        $sql = "CREATE TABLE PACRecordHistory (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            idPACRecord INT(6) UNSIGNED NOT NULL,
            idUser INT(6) UNSIGNED NOT NULL,
            OldValues TEXT,  
            NewValues TEXT,  
            ModifiedAt DATETIME NOT NULL,
            FOREIGN KEY (idPACRecord) REFERENCES PACRecord(id) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (idUser) REFERENCES User(id) ON DELETE CASCADE ON UPDATE CASCADE
        )";
        $this->executeSql($sql, $conn, "PACRecord");

        

        $sql = "CREATE TABLE Login (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            idUser INT(6) UNSIGNED,
            CreatedAt DATETIME,
            FOREIGN KEY (idUser) REFERENCES User(id) ON DELETE CASCADE ON UPDATE CASCADE
        )";
        $this->executeSql($sql, $conn, "Login");

        // Adding indexes for performance
        $conn->query("ALTER TABLE User ADD INDEX idx_permission (PermissionID)");
        $conn->query("ALTER TABLE Bank ADD INDEX idx_category (idBankCategory)");
        $conn->query("ALTER TABLE PACRecord ADD INDEX idx_user (idUser)");
        $conn->query("ALTER TABLE PACRecord ADD INDEX idx_state (idResponse)");
        $conn->query("ALTER TABLE PACRecord ADD INDEX idx_bank (idBank)");
        $conn->query("ALTER TABLE PACRecordHistory ADD INDEX idx_user (idUser)");
        $conn->query("ALTER TABLE PACRecordHistory ADD INDEX idx_state (idPACRecord)");
        $conn->query("ALTER TABLE Login ADD INDEX idx_user (idUser)");
       

        $conn->close();

    }
}
?>
