<?php
$host = "localhost"; // aquí localhost porque es en tu PC
$db   = "compras_ventas"; // el nombre que le pongas a la base local
$user = "root"; // usuario de MySQL local
$pass = ""; // contraseña vacía en XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>

