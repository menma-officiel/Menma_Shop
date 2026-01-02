<?php 
include 'includes/db.php'; 
include 'includes/header.php'; 

// Sécurisation de l'ID pour PostgreSQL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();

if (!$p) { 
    echo "<div class='container' style='padding:80px; text-align:center;'><h2>Produit introuvable.</h2></div>"; 
    include 'includes/footer.php'; exit; 
}
?>

<div class="container">
    <div class="product-detail-layout" style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px;">
        
        <div class="product-visuals" style="flex: 1; min-width: 320px;">
            <div id="main-display" style="width: 100%; aspect-ratio: 1/1; background: #fff; border-radius: 15px; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 1px solid #eee; position: relative;">
                <img src="<?= htmlspecialchars($p['image_url']) ?>" id="view-target" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                
                <?php if ($p['stock'] <= 0): ?>
                    <div style="position: absolute; top: 10px; left: 10px; background: #e74c3c; color: white; padding: 5px 15px; border-radius: 5px; font-weight: bold;">Rupture de stock</div>
                <?php endif; ?>
            </div>

            <div class="thumb-list" style="display: flex; gap: 10px; margin-top: 15px; overflow-x: auto; padding-bottom: 5px; -webkit-overflow-scrolling: touch;">
                <?php 
                $colonnes = ['image_url', 'image_url2', 'image_url3', 'image_url4', 'image_url5'];
                foreach($colonnes as $col): 
                    if(!empty($p[$col])): ?>
                        <img src="<?= htmlspecialchars($p[$col]) ?>" 
                             onclick="updateView(this.src)" 
                             style="width: 70px; height: 70px; flex-shrink: 0; object-fit: cover; border-radius: 8px; cursor: pointer; border: 2px solid #ddd;">
                    <?php endif; 
                endforeach; ?>
            </div>
        </div>

        <div class="product-info" style="flex: 1; min-width: 320px;">
            <div style="margin-bottom: 10px;">
                <span style="background: #e8f5e9; color: #2e7d32; padding: 5px 12px; border-radius: 20px; font-weight: bold; font-size: 0.8rem;">📦 LIVRAISON GRATUITE</span>
            </div>
            
            <h1 style="margin: 10px 0; font-size: 1.8rem; line-height: 1.2;"><?= htmlspecialchars($p['nom']) ?></h1>
            <p style="font-size: 1.8rem; color: #25D366; font-weight: 900; margin-bottom: 15px;">
                <?= number_format($p['prix'], 0, '.', ' ') ?> GNF
            </p>
            
            <div style="margin-bottom: 25px;">
                <h3 style="border-bottom: 2px solid #f4f7f6; padding-bottom: 8px; font-size: 1rem;">Description</h3>
                <p style="line-height: 1.6; color: #555; font-size: 0.95rem; padding-top: 10px;">
                    <?= nl2br(htmlspecialchars($p['description'])) ?>
                </p>
            </div>

            <div id="order-box" style="background: #fff; padding: 20px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid #e1e4e8;">
                <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 1.1rem;">📝 Commander maintenant</h3>
                <form onsubmit="event.preventDefault(); sendOrder();">
                    <input type="text" id="nom_client" placeholder="Votre Nom et Prénom" 
                           style="width: 100%; padding: 14px; margin-bottom: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px;" required>
                    
                    <input type="text" id="adresse_client" placeholder="Quartier / Ville de livraison" 
                           style="width: 100%; padding: 14px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px;" required>
                    
                    <button type="submit" style="width: 100%; background: #25D366; color: white; border: none; padding: 18px; border-radius: 10px; font-weight: 800; font-size: 1.1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; text-transform: uppercase;">
                         Commander sur WhatsApp
                    </button>
                </form>
                <p style="text-align: center; margin-top: 12px; font-size: 0.85rem; color: #777;">🤝 Paiement sécurisé à la livraison</p>
            </div>
        </div>
    </div>
</div>

<script>
    function updateView(src) {
        document.getElementById('view-target').src = src;
    }

    function sendOrder() {
        const nom = document.getElementById('nom_client').value;
        const adresse = document.getElementById('adresse_client').value;
        const produit = "<?= addslashes($p['nom']) ?>";
        const prix = "<?= number_format($p['prix'], 0, '.', ' ') ?> GNF";

        // Correction des guillemets pour le message WhatsApp
        const message = "Bonjour Menma Shop ! Je souhaite commander :\n\n" +
                        "🛍️ *Produit :* " + produit + "\n" +
                        "💰 *Prix :* " + prix + "\n" +
                        "🚚 *Livraison :* GRATUITE\n" +
                        "--------------------------\n" +
                        "👤 *Client :* " + nom + "\n" +
                        "📍 *Adresse :* " + adresse + "\n" +
                        "--------------------------\n" +
                        "_Paiement à la réception._";

        window.open(`https://wa.me/224625968097?text=${encodeURIComponent(message)}`, '_blank');
    }
</script>

<div class="container" style="margin-top: 40px;">
    <?php include 'includes/section_commentaire.php'; ?>
</div>

<?php include 'includes/footer.php'; ?>
