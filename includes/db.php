<?php
// Utilisation de getenv pour la sécurité sur Render
// Les valeurs après ?: sont celles utilisées par défaut sur ton PC (Wamp/Xampp)
$host = getenv('DB_HOST') ?: "aws-1-eu-west-1.pooler.supabase.com";
$port = getenv('DB_PORT') ?: "6543";
$dbname = getenv('DB_NAME') ?: "postgres";
$user = getenv('DB_USER') ?: "postgres.dfrpjeruixdozefzivro";
$password = getenv('DB_PASSWORD') ?: "q9*TKyBXVE#NXz";

try {
    // Connexion via l'extension PDO PostgreSQL (obligatoire pour Supabase)
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => true,
    ]);
} catch (PDOException $e) {
    // En production (Render), on ne montre pas l'erreur détaillée aux clients
    error_log("Erreur de connexion : " . $e->getMessage());
    die("Désolé, une erreur de connexion à la base de données est survenue.");
}
?>
