
<?php
class Database
{
    private $host = "localhost";
    private $db   = "vote_osismpk";
    private $user = "root";
    private $pass = "";
    public  $conn;

    public function connect()
    {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db}",
                $this->user,
                $this->pass
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "status" => false,
                "message" => $e->getMessage()
            ]);
            exit;
        }
    }
}
