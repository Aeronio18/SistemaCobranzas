<?php

class UserModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function authenticateUser($username, $password)
    {
        $query = "SELECT * FROM usuario WHERE nombre_usuario = :username AND password = :password";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'username' => $username,
            'password' => $password,
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers()
    {
        $query = "SELECT id, nombre_usuario, rol FROM usuario";
        $stmt = $this->pdo->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($username, $password, $role)
    {
        $query = "INSERT INTO usuario (nombre_usuario, password, rol) VALUES (:username, :password, :role)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            'username' => $username,
            'password' => $password,
            'role' => $role,
        ]);
    }

    public function updateUser($id, $username, $password, $role)
    {
        $query = "UPDATE usuario SET nombre_usuario = :username, password = :password, rol = :role WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            'id' => $id,
            'username' => $username,
            'password' => $password,
            'role' => $role,
        ]);
    }

    public function deleteUser($id)
    {
        $query = "DELETE FROM usuario WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}
