<?php 
include 'includes/db.php'; 
include 'includes/header.php'; 

// --- CONFIGURATION PAGINATION ---
$parPage = 6;
$pageActuelle = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($pageActuelle <= 0) $pageActuelle = 1;
$offset = ($pageActuelle - 1) * $parPage;

// Compter le total (Compatible Postgres)
$totalProduits = $pdo->query("SELECT COUNT(*) FROM produits")->fetchColumn();
$totalPages = ceil($totalProduits / $parPage);

// Correction pour PostgreSQL : on force le type INTEGER pour Limit et Offset
$query = $pdo->prepare("SELECT * FROM produits ORDER BY id DESC LIMIT :limit OFFSET :offset");
$query->bindValue(':limit', (int)$parPage, PDO::PARAM_INT);
$query->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
$query->execute();
?>

<style>
    .product-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* 2 produits par ligne sur mobile */
        gap: 15px;
        padding: 10px;
    }
    @media (max-width: 480px) {
        .product-grid { gap: 10px; }
        .product-content h3 { font-size: 0.9rem; }
        .product-price { font-size: 1rem; color: #25D366; font-weight: bold; }
    }
    .hero-section {
        background: #1a1a1a;
        color: white;
        text-align: center;
        padding: 40px 20px;
        border-bottom: 4px solid #25D366;
    }
    .badge-soldout {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #e74c3c;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 0.8rem;
    }
    .product-image { position: relative; }
</style>

<div class="hero-section">
    <h1>LIVRAISON GRATUITE</h1>
    <p>Commandez sur WhatsApp • Payez à la livraison</p>
</div>

<div class="container">
    <div class="product-grid">
        <?php while ($p = $query->fetch()): ?>
            <div class="product-card">
                <div class="product-image">
                    <?php if(!empty($p['image_url'])): ?>
                        <img src="<?= htmlspecialchars($p['image_url']) ?>" alt="<?= htmlspecialchars($p['nom']) ?>" style="width:100%; border-radius:10px 10px 0 0; aspect-ratio:1/1; object-fit:cover;">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/300?text=No+Image" alt="Indisponible" style="width:100%;">
                    <?php endif; ?>
                    
                    <?php if ($p['stock'] <= 0): ?>
                        <span class="badge-soldout">Rupture</span>
                    <?php endif; ?>
                </div>
                
                <div class="product-content" style="padding:10px;">
                    <h3><?= htmlspecialchars($p['nom']) ?></h3>
                    <p class="product-price"><?= number_format($p['prix'], 0, '.', ' ') ?> GNF</p>
                    
                    <div class="product-footer" style="margin-top:10px;">
                        <a href="produit_detail.php?id=<?= $p['id'] ?>" class="btn-view" style="display:block; background:#25D366; color:white; text-decoration:none; padding:10px; border-radius:5px; text-align:center; font-weight:bold;">
                            Commander
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <?php if ($totalPages > 1): ?>
    <div class="pagination" style="display:flex; justify-content:center; gap:10px; margin:30px 0;">
        <?php if($pageActuelle > 1): ?>
            <a href="index.php?page=<?= $pageActuelle - 1 ?>" class="page-link">«</a>
        <?php endif; ?>

        <?php for($i=1; $i<=$totalPages; $i++): ?>
            <a href="index.php?page=<?= $i ?>" class="page-link <?= ($i == $pageActuelle) ? 'active' : '' ?>" style="padding:10px 15px; border:1px solid #ddd; border-radius:5px; text-decoration:none; <?= ($i == $pageActuelle) ? 'background:#25D366; color:white; border-color:#25D366;' : 'color:#333;' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if($pageActuelle < $totalPages): ?>
            <a href="index.php?page=<?= $pageActuelle + 1 ?>" class="page-link">»</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
