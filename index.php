<?php
include("config/conexaoBD.php");
include("view/header.php");

$sql = "SELECT p.idPost, p.tituloPost, p.imagemPost, p.idUsuario, p.dataPublicacao, u.nomeUsuario
        FROM posts p
        INNER JOIN usuario u
            ON p.idUsuario = u.idUsuario
        ORDER BY p.dataPublicacao DESC
        LIMIT 6;
        ";
$result = $conn->query($sql);

if (!$result) {
    die("Erro na query: " . $conn->error);
}
?>

<div class="container">
    <section class="top">
        <div class="top-left" style="color: white">
            <h1>Seja Bem-Vindo(a) à Sétima Filosofia!</h1>
            <p>Aqui, a gente desvenda as grandes questões da vida, da arte e da existência, tudo isso por meio das histórias que a tela nos conta. Prepare-se para mergulhar em um mundo onde cada filme é um convite à reflexão e cada cena esconde um universo de ideias.</p>
            <p>Pega a pipoca e vem com a gente nessa jornada. A sua poltrona para o pensamento já está reservada!</p>
        </div>

        <div class="imagem-home">
            <img class="image" src="img/diasPerfeitos.jpg" alt="destaque">
        </div>
    </section>

    <section>
        <h2 class="h1 mb-4" style="color: white">Blog</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if ($result->num_rows > 0): ?>
                <?php while($post = $result->fetch_assoc()): ?>
                    <div class="col">
                        <div class="card h-100 bg-dark border-0 shadow-sm">
                            <img src="img/<?php echo $post['imagemPost'] ?: 'default.jpg'; ?>" class="card-img-top card-img-post" style="height: 250px" alt="<?php echo $post['tituloPost']; ?>">
                            <div class="card-body">
                                <h4 class="card-title text-light"><?php echo $post['tituloPost']; ?></h4>
                                <p class="card-text text-white-50">Por <?php echo $post['nomeUsuario']; ?></p>
                                <small class="d-block text-white-50">Publicado em <?php echo date("d/m/Y", strtotime($post['dataPublicacao'])); ?></small>
                                <a href="/TADS6-2025-2-GWS-Carolinne-Antonio-Jaqueline/TADS6-2025-2-GWS-Carolinne-Antonio-Jaqueline/view/post.php?id=<?php echo $post['idPost']; ?>" class="btn btn-danger mt-3">Ler mais</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col">
                    <p>Nenhum post publicado ainda.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php include("view/footer.php"); ?>