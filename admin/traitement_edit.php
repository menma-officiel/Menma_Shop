<?php
session_start();
// Sécurité : Vérifie que l'admin est connecté
if (!isset($_SESSION['admin_loge'])) {
    header("Location: login.php");
    exit;
}

include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // On récupère toutes les données, y compris les images additionnelles
    $id = (int)$_POST['id'];
    $nom = htmlspecialchars($_POST['nom']);
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];
    $desc = htmlspecialchars($_POST['description']);
    
    // Gestion des URLs d'images (Catbox)
    $img1 = $_POST['image_url'];
    $img2 = !empty($_POST['image_url2']) ? $_POST['image_url2'] : null;
    $img3 = !empty($_POST['image_url3']) ? $_POST['image_url3'] : null;
    $img4 = !empty($_POST['image_url4']) ? $_POST['image_url4'] : null;
    $img5 = !empty($_POST['image_url5']) ? $_POST['image_url5'] : null;
    $video = !empty($_POST['video_url']) ? $_POST['video_url'] : null;

    // Requête SQL complète pour PostgreSQL (Supabase)
    $sql = "UPDATE produits SET 
            nom=?, prix=?, stock=?, description=?, 
            image_url=?, image_url2=?, image_url3=?, image_url4=?, image_url5=?, 
            video_url=? 
            WHERE id=?";
            
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$nom, $prix, $stock, $desc, $img1, $img2, $img3, $img4, $img5, $video, $id]);
        header("Location: index.php?update=success");
        exit();
    } catch (PDOException $e) {
        error_log($e->getMessage());
        header("Location: index.php?error=update_failed");
        exit();
    }
}
?>
