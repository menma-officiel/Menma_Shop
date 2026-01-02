<?php
session_start();
// Vérification de session admin
if (!isset($_SESSION['admin_loge'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';
// Corrigé : chemin relatif pour éviter les erreurs sur Render
include 'header_admin.php'; 

// Gestion de l'ajout du commentaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produit = $_POST['id_produit'];
    $nom_client = $_POST['nom_client'];
    $note = $_POST['note'];
    $texte = $_POST['texte'];

    // PostgreSQL est déjà prêt avec cette syntaxe
    $sql = "INSERT INTO commentaires (id_produit, nom_client, note, texte) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$id_produit, $nom_client, $note, $texte])) {
        echo "<script>alert('Avis ajouté avec succès !'); window.location.href='index.php';</script>";
    }
}
?>

<style>
    /* Optimisation pour ton "App" mobile */
    .edit-container { max-width: 600px; margin: 20px auto; padding: 15px; }
    .admin-form label { display: block; margin-top: 15px; font-weight: bold; }
    .admin-form input, .admin-form textarea, .admin-form select { 
        width: 100%; padding: 12px; margin-top: 5px; border-radius: 8px; border: 1px solid #ccc; font-size: 16px; /* Évite le zoom auto sur iPhone */
    }
    .btn-save { 
        width: 100%; padding: 15px; margin-top: 25px; border: none; border-radius: 8px; 
        font-weight: bold; cursor: pointer; font-size: 16px;
    }
</style>

<div class="edit-container">
    <h2 style="border-left: 5px solid #f1c40f; padding-left: 10px;">⭐ Ajouter un avis client</h2>
    <p style="margin-bottom: 20px; color: #666;">Ajoutez un témoignage pour booster vos ventes.</p>

    <form method="POST" class="admin-form">
        <label>Sélectionner le produit</label>
        <select name="id_produit" required>
            <?php
            // Commande compatible PostgreSQL
            $produits = $pdo->query("SELECT id, nom FROM produits ORDER BY nom ASC")->fetchAll();
            foreach($produits as $p): ?>
                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nom']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Note (1 à 5 étoiles)</label>
        <select name="note" required>
            <option value="5">⭐⭐⭐⭐⭐ (Excellent)</option>
            <option value="4">⭐⭐⭐⭐ (Très bien)</option>
            <option value="3">⭐⭐⭐ (Moyen)</option>
            <option value="2">⭐⭐ (Bof)</option>
            <option value="1">⭐ (Mauvais)</option>
        </select>

        <label>Nom du client</label>
        <input type="text" name="nom_client" placeholder="Ex: Moussa B." required>

        <label>Commentaire / Avis</label>
        <textarea name="texte" rows="4" placeholder="Ex: Produit de très bonne qualité !" required></textarea>

        <button type="submit" class="btn-save" style="background: #f1c40f; color: #000;">
            🚀 PUBLIER L'AVIS
        </button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
