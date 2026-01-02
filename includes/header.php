<?php
// On détecte automatiquement si on est sur Render ou en local
// Si le dossier "boutique" n'existe pas dans l'URL, on utilise la racine /
$root = (strpos($_SERVER['REQUEST_URI'], '/boutique/') !== false) ? "/boutique/" : "/";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Menma Shop | Livraison Gratuite</title>
    
    <link rel="stylesheet" href="<?= $root ?>assets/css/style.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    
    <style>
        /* Quelques ajustements pour la barre de navigation mobile */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: #1a1a1a;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .logo {
            font-weight: 800;
            color: #fff;
            font-size: 1.2rem;
            text-transform: uppercase;
        }
        nav ul { list-style: none; display: flex; gap: 20px; }
        nav ul li a { 
            color: #fff; 
            text-decoration: none; 
            font-weight: 600; 
            font-size: 0.9rem;
        }
        .container { padding: 15px; max-width: 1200px; margin: 0 auto; }
    </style>
</head>
<body>
    <nav>
        <div class="logo">📱 Menma<span>Shop</span></div>
        <ul>
            <li><a href="<?= $root ?>index.php">Accueil</a></li>
            </ul>
    </nav>
    <main class="container">
