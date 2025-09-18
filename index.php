<?php
include("config/conexaoBD.php");
include("view/header.php");

$sqlCat = "SELECT * FROM categoria";
$resCat = $conn->query($sqlCat);
?>

<div class="container my-5">

    <section class="top">
        <div class="top-left" style="color: white">
            <h1>Seja Bem-Vindo(a) à Sétima Filosofia!</h1>
            <p>Aqui, a gente desvenda as grandes questões da vida, da arte e da existência, tudo isso por meio das histórias que a tela nos conta.</p>
            <p>Pega a pipoca e vem com a gente nessa jornada. A sua poltrona para o pensamento já está reservada!</p>
        </div>

        <div class="imagem-home">
            <img class="image" src="img/diasPerfeitos.jpg" alt="destaque">
        </div>
    </section>

    <section class="mt-5">
        <h2 class="text-light mb-3">Categorias</h2>
        <div class="mb-4">
            <button class="btn btn-outline-light me-2 filtro-categoria" data-id="0">Todos</button>
            <?php while($cat = $resCat->fetch_assoc()): ?>
                <button class="btn btn-outline-light me-2 filtro-categoria" data-id="<?php echo $cat['idCategoria']; ?>">
                    <?php echo $cat['descricaoCategoria']; ?>
                </button>
            <?php endwhile; ?>
        </div>
    </section>

    <section>
        <h2 class="text-light mb-3">Filmes</h2>
        <div id="lista-posts" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        </div>
    </section>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const botoes = document.querySelectorAll(".filtro-categoria");
    const listaPosts = document.getElementById("lista-posts");

    function carregarPosts(idCategoria = 0) {
        fetch("getPosts.php?idCategoria=" + idCategoria)
            .then(res => res.text())
            .then(html => listaPosts.innerHTML = html)
            .catch(err => listaPosts.innerHTML = "<p class='text-danger'>Erro ao carregar posts.</p>");
    }

    carregarPosts();

    botoes.forEach(btn => {
        btn.addEventListener("click", function() {
            const id = this.dataset.id;
            carregarPosts(id);
        });
    });
});
</script>

<?php include("view/footer.php"); ?>
