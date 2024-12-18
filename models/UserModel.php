<?php
class UserModel {
    private $conn;
    private $table_name = "usuarios";  // Asegúrate de que este nombre coincida con tu tabla en la base de datos

    public $id;
    public $username;
    public $password;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = ? AND password = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->username);
        $stmt->bindParam(2, $this->password);
        $stmt->execute();
        return $stmt;
    }
}
?>
