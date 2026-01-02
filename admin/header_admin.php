<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin | Menma Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="admin_style.css">
    
    <style>
        /* Micro-ajustement pour les badges de notifications ou alertes */
        .menu-admin a { position: relative; padding: 10px; }
        .menu-admin a:active { transform: scale(0.9); }
        .nav-admin { border-bottom: 3px solid #25D366; }
    </style>
</head>
<body>

<nav class="nav-admin">
    <a href="index.php" class="logo">MENMA<span>ADMIN</span></a>
    
    <div class="menu-admin">
        <a href="dashboard.php" title="Statistiques"><i class="fas fa-chart-line"></i></a>
        
        <a href="index.php" title="Inventaire"><i class="fas fa-box"></i></a>
        
        <a href="add_product.php" title="Ajouter"><i class="fas fa-plus-circle"></i></a>
        
        <a href="add_comment.php" title="Avis Clients"><i class="fas fa-comment-dots"></i></a>
        
        <a href="../index.php" target="_blank" title="Boutique en ligne"><i class="fas fa-external-link-alt"></i></a>
        
        <a href="logout.php" class="logout" title="Quitter"><i class="fas fa-sign-out-alt"></i></a>
    </div>
</nav>

<div class="admin-wrapper">
