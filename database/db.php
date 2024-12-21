<?php
$host = 'localhost';
$dbname = 'u327767040_demosys';
$user = 'u327767040_Aeronio';
$pass = 'Z0b5tPQ4Fp^';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>
