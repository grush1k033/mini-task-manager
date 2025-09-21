<?php
class Database
{
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host .
                ";dbname=" . $this->db_name .
                ";charset=utf8mb4",
                $this->username,
                $this->password
            );

            // УСТАНАВЛИВАЕМ ПРАВИЛЬНУЮ ТИМЗОНУ ДЛЯ MySQL
            $this->conn->exec("SET time_zone = '+03:00';"); // Для Москвы
            // Или для других регионов:
            // $this->conn->exec("SET time_zone = '+04:00';"); // Для Самары, Баку
            // $this->conn->exec("SET time_zone = '+05:00';"); // Для Екатеринбурга, Алматы

        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

?>