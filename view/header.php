<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Sétima Filosofia</title>
    <link rel="stylesheet" type="text/css" href="../config/estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="container nav">
            <div class="brand">
                <div class="logo">SF</div>
                <div>
                    <div class="site-title">A Sétima Filosofia</div>
                    <div class="muted" style="font-size:13px">Arte • Cinema • Filosofia</div>
                </div>
            </div>

            <nav>
                <button class="menu-toggle" aria-expanded="false" id="menuToggle">Menu</button>
                <ul id="mainNav">
                    <li><a href="inicio.php">Home</a></li>
                    <li><a href="#portfolio">Categorias</a></li>
                    <li><a href="login.php">Login</a></li>

                    <?php if(isset($_SESSION['idUsuario'])): ?>
                        <li><a href="/cadastrarTexto.php">Escrever Texto</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
