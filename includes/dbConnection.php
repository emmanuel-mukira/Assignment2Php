<?php
require 'constants.php';

class dbConnection {
    private $connection;
    private $db_type;
    private $db_host;
    private $db_port;
    private $db_user;
    private $db_pass;
    private $db_name;

    public function __construct($db_type, $db_host, $db_port, $db_user, $db_pass, $db_name) {
        $this->db_type = $db_type;
        $this->db_host = $db_host;
        $this->db_port = $db_port;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
        $this->connection();  // Call connection method
    }

    public function connection() {
        if ($this->db_type == 'PDO') {
            try {
                $this->connection = new PDO("mysql:host={$this->db_host};port={$this->db_port};dbname={$this->db_name}", $this->db_user, $this->db_pass);
                // Set the PDO error mode to exception
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "Connected successfully"; // Optionally remove or comment out for production
            } catch(PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
    }

    // Method to get the PDO connection
    public function getConnection() {
        if ($this->connection) {
            return $this->connection;
        } else {
            throw new Exception("Database connection is not established.");
        }
    }

    // Method to prepare SQL statements
    public function prepare($sql) {
        return $this->connection->prepare($sql);
    }

    public function insert($table, $data) {
        ksort($data);
        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));
        $sth = "INSERT INTO `$table` (`$fieldNames`) VALUES ($fieldValues)";
        $stmt = $this->connection->prepare($sth);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        try {
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return $sth . "<br>" . $e->getMessage();
        }
    }
}
