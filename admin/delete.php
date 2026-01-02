<?php
session_start();

// Vérification de sécurité
if (!isset($_SESSION['admin_loge'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

// On vérifie que l'ID est bien présent et qu'il s'agit d'un nombre
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM produits WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        
        // Optionnel : ajouter un message de succès en session pour l'afficher sur index.php
        $_SESSION['flash'] = "Produit supprimé avec succès.";
    } catch (PDOException $e) {
        // En cas d'erreur (ex: contrainte de clé étrangère bloquante)
        error_log($e->getMessage());
    }
}

// Redirection vers la liste
header("Location: index.php");
exit();
?>
