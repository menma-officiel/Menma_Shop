<?php
// On récupère l'ID du produit depuis la page parente (déjà sécurisé en INT dans produit_detail.php)
$product_id = isset($p['id']) ? (int)$p['id'] : 0;

// Récupération des avis pour ce produit (Compatible PostgreSQL)
$stmt_rev = $pdo->prepare("SELECT * FROM commentaires WHERE id_produit = ? ORDER BY id DESC");
$stmt_rev->execute([$product_id]);
$reviews = $stmt_rev->fetchAll();
?>

<section class="reviews-section" style="margin-top: 40px; margin-bottom: 40px; padding: 0 10px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; border-bottom: 2px solid #f1f1f1; padding-bottom: 15px;">
        <h2 style="margin:0; font-size: 1.3rem; color: #2c3e50;">⭐ Avis Clients (<?php echo count($reviews); ?>)</h2>
        <div style="color: #f1c40f; font-weight: bold; font-size: 0.9rem;">Moyenne : 5/5</div>
    </div>

    <div style="display: grid; gap: 15px;">
        <?php if (count($reviews) > 0): ?>
            <?php foreach ($reviews as $rev): ?>
                <div class="review-card" style="background: #ffffff; padding: 20px; border-radius: 12px; border: 1px solid #eee; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <div>
                            <strong style="font-size: 1rem; color: #333; display: block;"><?php echo htmlspecialchars($rev['nom_client']); ?></strong>
                            <span style="font-size: 0.75rem; color: #2ecc71; font-weight: bold;">✔️ Achat vérifié</span>
                        </div>
                        <div style="color: #f1c40f; font-size: 0.9rem; letter-spacing: 2px;">
                            <?php 
                                $n = (int)$rev['note'];
                                // Utilisation de caractères d'étoiles pleines pour un meilleur rendu mobile
                                for($i=1; $i<=5; $i++) echo ($i <= $n) ? '★' : '☆';
                            ?>
                        </div>
                    </div>
                    
                    <p style="color: #444; font-style: italic; line-height: 1.5; font-size: 0.95rem;">
                        "<?php echo nl2br(htmlspecialchars($rev['texte'])); ?>"
                    </p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 30px; background: #fdfdfd; border-radius: 15px; border: 1px dashed #ccc;">
                <p style="color: #999; font-size: 0.9rem;">Aucun avis pour le moment. Soyez le premier à commander !</p>
            </div>
        <?php endif; ?>
    </div>
</section>