<?php
session_start();
if (!isset($_SESSION['admin_loge'])) { header("Location: login.php"); exit; }

include '../includes/db.php';
// Correction du chemin pour Render
include 'header_admin.php'; 

// 1. Calculer les statistiques (Compatible PostgreSQL)
// Utilisation de COALESCE pour afficher 0 au lieu de vide si aucune vente
$query = $pdo->query("
    SELECT 
        COUNT(c.id) as total_ventes, 
        COALESCE(SUM(p.prix), 0) as chiffre_affaires 
    FROM commandes c 
    JOIN produits p ON c.id_produit = p.id
");
$stats = $query->fetch();

// 2. Top 5 des produits vendus
$top_ventes = $pdo->query("
    SELECT p.nom, COUNT(c.id) as nb 
    FROM commandes c 
    JOIN produits p ON c.id_produit = p.id 
    GROUP BY p.nom 
    ORDER BY nb DESC 
    LIMIT 5
")->fetchAll();
?>

<div class="container" style="padding: 15px;">
    <h2 style="margin: 20px 0; border-left: 5px solid #2ecc71; padding-left: 10px;">📊 Statistiques Business</h2>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 25px;">
        <div style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center; border-top: 4px solid #3498db;">
            <h4 style="color: #7f8c8d; font-size: 0.9rem; margin-bottom: 10px;">Ventes</h4>
            <p style="font-size: 1.8rem; font-weight: 800; color: #2c3e50;"><?= $stats['total_ventes'] ?></p>
        </div>
        <div style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center; border-top: 4px solid #2ecc71;">
            <h4 style="color: #7f8c8d; font-size: 0.9rem; margin-bottom: 10px;">Revenus GNF</h4>
            <p style="font-size: 1.5rem; font-weight: 800; color: #2ecc71;"><?= number_format($stats['chiffre_affaires'], 0, '.', ' ') ?></p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
        <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <h3 style="font-size: 1.1rem; margin-bottom: 15px;">🏆 Top des ventes</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <?php foreach($top_ventes as $v): ?>
                <tr style="border-bottom: 1px solid #f8f9fa;">
                    <td style="padding: 12px 0; font-size: 0.95rem; color: #34495e;"><?= htmlspecialchars($v['nom']) ?></td>
                    <td style="padding: 12px 0; text-align: right; font-weight: bold; color: #2ecc71;"><?= $v['nb'] ?> <span style="font-size: 0.7rem; font-weight: normal;">unités</span></td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($top_ventes)): ?>
                    <tr><td colspan="2" style="text-align: center; color: #999; padding: 20px;">Aucune vente enregistrée.</td></tr>
                <?php endif; ?>
            </table>
        </div>

        <div style="background: #2c3e50; padding: 25px; border-radius: 12px; color: white; text-align: center; display: flex; flex-direction: column; justify-content: center;">
            <p style="margin-bottom: 15px; font-size: 1rem;">Votre boutique est en ligne !</p>
            <a href="index.php" style="background: #2ecc71; color: white; text-decoration: none; padding: 12px; border-radius: 8px; font-weight: bold; transition: 0.3s;">
                🏠 RETOUR GESTION
            </a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
