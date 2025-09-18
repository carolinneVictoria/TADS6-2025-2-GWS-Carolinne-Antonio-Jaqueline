<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Sétima Filosofia</title>
    <link rel="stylesheet" type="text/css" href="/TADS6-2025-2-GWS-Carolinne-Antonio-Jaqueline/TADS6-2025-2-GWS-Carolinne-Antonio-Jaqueline/config/estilo.css">
    <link rel="stylesheet" type="text/css" href="/TADS6-2025-2-GWS-Carolinne-Antonio-Jaqueline/TADS6-2025-2-GWS-Carolinne-Antonio-Jaqueline/config/estilosDois.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <header>
        <div class="container nav">
            <div class="brand">
                <div class="logo">SF</div>
                <div>
                    <div class="site-title">A Sétima Filosofia</div>
                    <div class="muted" style="font-size:13px; color: white">Arte • Cinema • Filosofia</div>
                </div>
            </div>

            <nav>
                <button class="menu-toggle" aria-expanded="false" id="menuToggle">Menu</button>
                <ul id="mainNav" class="nav fs-6">
                    <li class="nav-item">
                    <a class="nav-link text-white text-decoration-none" href="/TADS6-2025-2-GWS-Carolinne-Antonio-Jaqueline/TADS6-2025-2-GWS-Carolinne-Antonio-Jaqueline/index.php">Home</a>
                    </li>
                    <?php if (isset($_SESSION['idUsuario'])): ?>
                        <li class="nav-item"><a class="nav-link text-white text-decoration-none" href="/TADS6-2025-2-GWS-Carolinne-Antonio-Jaqueline/TADS6-2025-2-GWS-Carolinne-Antonio-Jaqueline/view/cadastrarTexto.php">Escrever Texto</a></li>
                        <li class="nav-item"><a class="nav-link text-white text-decoration-none" href="/TADS6-2025-2-GWS-Carolinne-Antonio-Jaqueline/TADS6-2025-2-GWS-Carolinne-Antonio-Jaqueline/view/perfil.php">Perfil</a></li>
                        <li class="nav-item"><a class="nav-link text-white text-decoration-none" href="/TADS6-2025-2-GWS-Carolinne-Antonio-Jaqueline/TADS6-2025-2-GWS-Carolinne-Antonio-Jaqueline/view/logout.php">Sair</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link text-white text-decoration-none" href="/TADS6-2025-2-GWS-Carolinne-Antonio-Jaqueline/TADS6-2025-2-GWS-Carolinne-Antonio-Jaqueline/view/formLogin.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
