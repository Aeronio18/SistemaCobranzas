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
            header("Location: /admin_dashboard.php");
        } elseif ($row['role'] == 'cobrador') {
            header("Location: /cobrador_dashboard.php");
        } else {
            header("Location: /cliente_dashboard.php");
        }
    } else {
        echo "Usuario o contraseña incorrecta";
    }
} else {
    echo "Formulario no enviado correctamente.";
}
?>
