<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_p = isset($_POST['id_produit']) ? (int)$_POST['id_produit'] : 0;
    $nom = htmlspecialchars($_POST['nom_client']);
    $adr = htmlspecialchars($_POST['adresse']);

    if ($id_p <= 0) {
        header("Location: index.php");
        exit;
    }

    // Début de transaction (Indispensable pour la fiabilité du stock)
    $pdo->beginTransaction();

    try {
        // 1. Vérifier le stock avec verrouillage de ligne (FOR UPDATE)
        // Empêche un autre processus de modifier ce produit tant que la transaction n'est pas finie.
        $st = $pdo->prepare("SELECT stock FROM produits WHERE id = ? FOR UPDATE");
        $st->execute([$id_p]);
        $p = $st->fetch();

        if ($p && $p['stock'] > 0) {
            // 2. Créer la commande dans Supabase
            $ins = $pdo->prepare("INSERT INTO commandes (id_produit, nom_client, adresse_livraison, statut_livraison) VALUES (?, ?, ?, 'En attente')");
            $ins->execute([$id_p, $nom, $adr]);

            // 3. Réduire le stock
            $upd = $pdo->prepare("UPDATE produits SET stock = stock - 1 WHERE id = ?");
            $upd->execute([$id_p]);

            // Tout est bon, on valide
            $pdo->commit();
            header("Location: index.php?success=order");
            exit;
        } else {
            // Cas où le stock est tombé à 0 entre-temps
            throw new Exception("Stock insuffisant");
        }
    } catch (Exception $e) {
        // En cas de problème, on annule tout (la commande n'est pas créée et le stock ne bouge pas)
        $pdo->rollBack();
        error_log("Erreur commande : " . $e->getMessage());
        header("Location: produit_detail.php?id=$id_p&error=stock");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
