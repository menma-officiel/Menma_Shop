<?php
session_start();
// 1. Sécurité : Vérifie que c'est bien l'admin qui modifie le stock
if (!isset($_SESSION['admin_loge'])) {
    header("Location: login.php");
    exit;
}

// 2. Correction du chemin pour Render
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Forcer le typage pour PostgreSQL (Supabase)
    $id = (int)$_POST['id'];
    $nouveau_stock = (int)$_POST['nouveau_stock'];

    try {
        $stmt = $pdo->prepare("UPDATE produits SET stock = ? WHERE id = ?");
        $stmt->execute([$nouveau_stock, $id]);
        
        // Redirection vers l'index de l'admin avec un message de succès
        header("Location: index.php?update=stock_ok");
        exit();
    } catch (PDOException $e) {
        // Log de l'erreur en cas de problème de connexion
        error_log("Erreur mise à jour stock : " . $e->getMessage());
        header("Location: index.php?error=sql");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>