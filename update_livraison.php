<?php
session_start();
// 1. Sécurité : Seul l'admin peut changer les statuts
if (!isset($_SESSION['admin_loge'])) {
    header("Location: login.php");
    exit();
}

// 2. Correction du chemin pour Render
include '../includes/db.php'; 

if (isset($_GET['id']) && isset($_GET['statut'])) {
    // Forcer l'ID en nombre entier pour PostgreSQL
    $id = (int)$_GET['id'];
    $nouveau_statut = $_GET['statut'];

    // Liste des statuts autorisés (Sécurité pour éviter des données bizarres)
    $statuts_autorises = ['En attente', 'Expédié', 'Livré'];

    if (in_array($nouveau_statut, $statuts_autorises)) {
        try {
            $stmt = $pdo->prepare("UPDATE commandes SET statut_livraison = ? WHERE id = ?");
            $stmt->execute([$nouveau_statut, $id]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
    }

    // 3. Redirection vers ton tableau de bord admin
    header("Location: index.php?update=success");
    exit();
}
?>
