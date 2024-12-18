<?php
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/UserModel.php';
session_start();

$database = new Database();
$db = $database->getConnection();
$user = new UserModel($db);

if (isset($_POST['login'])) {
    $user->username = $_POST['username'];
    $user->password = $_POST['password'];
    $stmt = $user->login();
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        if ($row['role'] == 'admin') {
            header("Location: /sandbox/admin_dashboard");
        } elseif ($row['role'] == 'cobrador') {
            header("Location: /sandbox/cobrador_dashboard");
        } else {
            header("Location: /sandbox/cliente_dashboard");
        }
    } else {
        echo "Usuario o contraseña incorrecta";
    }
}
?>
