<?php
class Database {
    private $host = "localhost";
    private $dbname = "gym_app";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new mysqli(
                $this->host,
                $this->username,
                $this->password,
                $this->dbname
            );
        } catch (Exception $e) {
            die("Error de conexión: " . $e->getMessage());
        }

        return $this->conn;
    }
}
