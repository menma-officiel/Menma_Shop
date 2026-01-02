<?php
session_start();

// 1. Détection dynamique du dossier pour le lien de retour
$root = (strpos($_SERVER['REQUEST_URI'], '/boutique/') !== false) ? "/boutique/" : "/";

// Si déjà connecté, on va direct à l'index admin
if (isset($_SESSION['admin_loge']) && $_SESSION['admin_loge'] === true) {
    header("Location: index.php");
    exit();
}

$erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    
    // SÉCURITÉ : On peut utiliser une variable d'environnement sur Render pour le mot de passe
    // Sinon, on garde ton mot de passe par défaut
    $admin_password = getenv('ADMIN_PASS') ?: "admin123"; 

    if ($password === $admin_password) { 
        $_SESSION['admin_loge'] = true;
        // Régénérer l'ID de session pour éviter les fixations de session
        session_regenerate_id(true);
        header("Location: index.php");
        exit();
    } else {
        $erreur = "Mot de passe incorrect !";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administration | Menma Shop</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1a1a1a, #2c3e50);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 20px;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }
        h2 { margin-bottom: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 3px; font-size: 1.5rem; }
        p.subtitle { color: rgba(255,255,255,0.6); font-size: 0.9rem; margin-bottom: 30px; }
        
        input[type="password"] {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 16px; /* Anti-zoom mobile */
            outline: none;
            transition: 0.3s;
        }
        input[type="password"]:focus { background: rgba(255,255,255,0.2); border-color: #2ecc71; }

        button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            background: #2ecc71; /* Vert pour correspondre à ton thème WhatsApp */
            color: white;
            font-weight: 800;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
        }
        button:hover { background: #27ae60; transform: translateY(-2px); }
        button:active { transform: translateY(0); }

        .error { background: rgba(231, 76, 60, 0.2); color: #ff7675; padding: 10px; border-radius: 8px; margin-top: 15px; font-size: 0.85rem; border: 1px solid rgba(231, 76, 60, 0.3); }
        .back-home { margin-top: 25px; display: block; color: rgba(255,255,255,0.4); text-decoration: none; font-size: 0.85rem; transition: 0.3s; }
        .back-home:hover { color: white; }
    </style>
</head>
<body>

    <div class="login-card">
        <h2>🛠️ ADMIN</h2>
        <p class="subtitle">Connectez-vous pour gérer vos ventes</p>
        
        <form method="POST">
            <input type="password" name="password" placeholder="Mot de passe secret" required autofocus>
            <button type="submit">ENTRER DANS L'ACCÈS</button>
        </form>

        <?php if ($erreur): ?>
            <p class="error">❌ <?php echo $erreur; ?></p>
        <?php endif; ?>

        <a href="<?= $root ?>index.php" class="back-home">← Retour à la boutique</a>
    </div>

</body>
</html>
