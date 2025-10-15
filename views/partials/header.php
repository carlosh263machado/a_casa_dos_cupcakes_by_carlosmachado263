<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Casa dos Cupcakes</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Satisfy&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <div class="header-content">
            <h1><a href="index.php" class="header-link">A Casa dos Cupcakes</a></h1>
            <nav id="auth-links" style="<?= isset($_SESSION['user']) ? 'display: none;' : '' ?>">
                <button id="login-btn" class="auth-btn">Login</button>
                <button id="signup-btn" class="auth-btn secondary">Cadastre-se</button>
            </nav>
            <div id="user-info" style="<?= isset($_SESSION['user']) ? '' : 'display: none;' ?>">
                <span>Bem-vindo(a), <span id="user-name"><?= htmlspecialchars($_SESSION['user']['name'] ?? '') ?></span>!</span>
                <a href="index.php?action=logout" id="logout-btn" class="auth-btn secondary">Sair</a>
            </div>
        </div>
    </header>