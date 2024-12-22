<?php
$host = 'localhost';
$db = 'hoteltematico';
$user = 'root';
$pass = '';
$port = 3306; // El puerto, que generalmente es 3306 para MySQL

try {
    // Incluimos el puerto en la cadena de conexión
    $pdo = new PDO("mysql:host=$host;dbname=$db;port=$port", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    // Capturamos el error si hay una excepción
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
