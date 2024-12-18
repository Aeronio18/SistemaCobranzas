<?php
/*class Database {
    private $host = "localhost";
    private $db_name = "demosys";
    private $username = "Aeronio";
    private $password = "48/!L9*iun_]TKst";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
*/
class Database {
    private $host = "tetsaservices";
    private $db_name = "u327767040_demosys";
    private $username = "u327767040_Aeronio";
    private $password = "48/!L9*iun_]TKst";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
