<?php
class Database {
    private $host = "localhost";
    private $dbname = "test_db";
    private $user = "root";
    private $pass = "";
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        } catch (PDOException $e) {
            die("Database Error: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
