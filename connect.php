<?php
// db_connection.php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "restaurant_db";
    public $conn;
    
    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    
    public function getConnection() {
        return $this->conn;
    }
    
    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}

// Create global database instance
$database = new Database();
$conn = $database->getConnection();
?>