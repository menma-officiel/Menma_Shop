<?php
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER'); // Doit être postgres.dfrpjeruixdozefzivro
$password = getenv('DB_PASSWORD');

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    echo "Détails de l'erreur : " . $e->getMessage();
    exit;
}
