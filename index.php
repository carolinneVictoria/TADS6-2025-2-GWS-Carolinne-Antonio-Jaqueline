<?php
include("config/conexaoBD.php");
include("view/header.php");

$sql = "SELECT idPost, tituloPost, imagemPost, idUsuario, dataPublicacao
        FROM posts
        ORDER BY dataPublicacao DESC
        LIMIT 6";
$result = $conn->query($sql);

if (!$result) {
    die("Erro na query: " . $conn->error);
}
?>

<div class="container">
    <section class="top">
        <div class="top-left">
            <h1>Seja Bem-Vindo(a) à Sétima Filosofia!</h1>
            <p>Aqui, a gente desvenda as grandes questões da vida, da arte e da existência, tudo isso por meio das histórias que a tela nos conta. Prepare-se para mergulhar em um mundo onde cada filme é um convite à reflexão e cada cena esconde um universo de ideias.</p>
            <p>Pega a pipoca e vem com a gente nessa jornada. A sua poltrona para o pensamento já está reservada!</p>
        </div>

        <div class="imagem-home">
            <img class="image" src="img/diasPerfeitos.jpg" alt="destaque">
        </div>
    </section>

    <section>
        <h2>Blog</h2>
        <div class="cards">
            <?php if ($result->num_rows > 0): ?>
                <?php while($post = $result->fetch_assoc()): ?>
                    <div class="card">
                        <img src="img/<?php echo $post['imagemPost'] ?: 'default.jpg'; ?>" alt="<?php echo $post['tituloPost']; ?>">
                        <div class="card-body">
                            <h3><?php echo $post['tituloPost']; ?></h3>
                            <p><?php echo substr($post['idUsuario'], 0, 120) . '...'; ?></p>
                            <small>Por <?php echo $post['idUsuario']; ?> em <?php echo date("d/m/Y", strtotime($post['dataPublicacao'])); ?></small>
                            <br>
                            <a href="post.php?id=<?php echo $post['idPost']; ?>" class="btn">Ler mais</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Nenhum post publicado ainda.</p>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php include("view/footer.php"); ?>
