<?php
session_start();
require '../database/db.php';
require '../models/UserModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        header('Location: ../view/login.php?error=1');
        exit();
    }

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
                header('Location: ../view/cobrador_dashboard.php');
                break;
            case 'asist':
                header('Location: ../view/asist_dashboard.php');
                break;
            default:
                header('Location: ../view/login.php?error=1');
                break;
        }
    } else {
        header('Location: ../view/login.php?error=1');
    }
}
