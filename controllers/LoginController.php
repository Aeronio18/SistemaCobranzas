<?php
session_start();
require '../database/db.php';
require '../models/UserModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $userModel = new UserModel($pdo);
    $user = $userModel->authenticateUser($username, $password);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['nombre_usuario'];
        $_SESSION['role'] = $user['rol'];

        switch ($user['rol']) {
            case 'admin':
                header('Location: ../view/admin_dashboard.php');
                break;
            case 'cobrador':
                header('Location: ../view/collector_dashboard.php');
                break;
            case 'cliente':
                header('Location: ../view/client_dashboard.php');
                break;
        }
    } else {
        header('Location: ../view/login.php?error=1');
    }
}
?>
