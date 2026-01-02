<?php 
// Connexion à la base de données
include '../includes/db.php'; 
// Correction du chemin pour Render
include 'header_admin.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // On récupère les données proprement
    $nom = htmlspecialchars($_POST['nom']);
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];
    $desc = htmlspecialchars($_POST['description']);

    // Requête compatible MySQL et PostgreSQL (Supabase)
    $ins = $pdo->prepare("INSERT INTO produits (nom, prix, stock, description) VALUES (?, ?, ?, ?)");
    
    if($ins->execute([$nom, $prix, $stock, $desc])) {
        echo "<div style='padding:15px; background:#d4edda; color:#155724; border-radius:8px; margin:10px;'>
                ✅ Produit ajouté avec succès !
              </div>";
    }
}
?>

<style>
    .admin-form-container {
        max-width: 500px;
        margin: 20px auto;
        padding: 15px;
    }
    .admin-form input, .admin-form textarea {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 16px; /* Important pour éviter le zoom forcé sur mobile */
        font-family: sans-serif;
    }
    .btn-save {
        width: 100%;
        padding: 15px;
        background-color: #2ecc71;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
    }
    h2 { border-left: 5px solid #2ecc71; padding-left: 10px; margin-bottom: 20px; }
</style>

<div class="admin-form-container">
    <h2>📦 Nouveau produit</h2>
    
    <form method="POST" class="admin-form">
        <label>Nom de l'article</label>
        <input type="text" name="nom" placeholder="Ex: Montre de luxe" required>
        
        <label>Prix (en GNF ou Euros)</label>
        <input type="number" step="0.01" name="prix" placeholder="0.00" required>
        
        <label>Quantité disponible</label>
        <input type="number" name="stock" placeholder="Ex: 10" required>
        
        <label>Description</label>
        <textarea name="description" rows="5" placeholder="Détails du produit..."></textarea>
        
        <button type="submit" class="btn-save">🚀 ENREGISTRER LE PRODUIT</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
