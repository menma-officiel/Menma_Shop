<?php
session_start();
// Sécurité Admin
if (!isset($_SESSION['admin_loge'])) {
    header("Location: login.php");
    exit;
}

include '../includes/db.php';
// Correction du chemin pour Render (retrait du / initial)
include 'header_admin.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nettoyage des entrées
    $nom = htmlspecialchars($_POST['nom']);
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];
    $desc = htmlspecialchars($_POST['description']);
    $img1 = $_POST['image_url'];
    $img2 = !empty($_POST['image_url2']) ? $_POST['image_url2'] : null;
    $img3 = !empty($_POST['image_url3']) ? $_POST['image_url3'] : null;
    $img4 = !empty($_POST['image_url4']) ? $_POST['image_url4'] : null;
    $img5 = !empty($_POST['image_url5']) ? $_POST['image_url5'] : null;
    $video = !empty($_POST['video_url']) ? $_POST['video_url'] : null;

    // Requête compatible Supabase/PostgreSQL
    $sql = "INSERT INTO produits (nom, prix, stock, description, image_url, image_url2, image_url3, image_url4, image_url5, video_url) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$nom, $prix, $stock, $desc, $img1, $img2, $img3, $img4, $img5, $video]);
        header("Location: index.php?success=1");
        exit();
    } catch (PDOException $e) {
        $error = "Erreur : " . $e->getMessage();
    }
}
?>

<style>
    /* Styles pour le mode Application Mobile */
    .edit-container { max-width: 700px; margin: 20px auto; padding: 15px; }
    .admin-form input, .admin-form textarea { 
        font-size: 16px !important; /* Anti-zoom mobile */
        margin-bottom: 10px;
    }
    .form-group-row { display: flex; gap: 10px; }
    .form-group-row > div { flex: 1; }
    .media-section { 
        background: #f8f9fa; 
        padding: 15px; 
        border-radius: 10px; 
        margin-top: 20px; 
        border: 1px solid #eee;
    }
    .media-section h3 { font-size: 1rem; margin-bottom: 10px; color: #2c3e50; }
    .btn-save { background: #25D366; color: white; border: none; padding: 15px; border-radius: 8px; font-weight: bold; font-size: 1rem; cursor: pointer; }
    @media (max-width: 600px) {
        .form-group-row { flex-direction: column; gap: 0; }
    }
</style>

<div class="edit-container">
    <h2>➕ Ajouter un Produit</h2>
    
    <?php if(isset($error)): ?>
        <p style="color:red; background:#ffdada; padding:10px; border-radius:5px;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" class="admin-form">
        <label>Nom du produit</label>
        <input type="text" name="nom" placeholder="Ex: iPhone 15 Pro Max" required>

        <div class="form-group-row">
            <div>
                <label>Prix (GNF)</label>
                <input type="number" step="0.01" name="prix" placeholder="0.00" required>
            </div>
            <div>
                <label>Stock</label>
                <input type="number" name="stock" value="10" required>
            </div>
        </div>

        <label>Description</label>
        <textarea name="description" rows="4" placeholder="Détails..."></textarea>

        <div class="media-section">
            <h3>🖼️ Galerie de Photos (URLs)</h3>
            <label>Image Principale (Obligatoire)</label>
            <input type="text" name="image_url" placeholder="Lien Catbox ou autre" required>
            
            <div class="form-group-row">
                <input type="text" name="image_url2" placeholder="Image 2">
                <input type="text" name="image_url3" placeholder="Image 3">
            </div>
            <div class="form-group-row">
                <input type="text" name="image_url4" placeholder="Image 4">
                <input type="text" name="image_url5" placeholder="Image 5">
            </div>

            <label style="color: #e74c3c; margin-top: 10px; display: block;">Lien Vidéo (YouTube/MP4)</label>
            <input type="text" name="video_url" placeholder="https://...">
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn-save" style="flex: 2;">🚀 PUBLIER</button>
            <a href="index.php" style="flex: 1; text-decoration: none; background: #95a5a6; color: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: bold;">RETOUR</a>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>