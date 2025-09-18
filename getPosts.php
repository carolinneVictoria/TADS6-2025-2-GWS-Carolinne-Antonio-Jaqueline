<?php
include("config/conexaoBD.php");

$idCategoria = intval($_GET['idCategoria'] ?? 0);

if ($idCategoria > 0) {
    $sql = "SELECT p.idPost, p.tituloPost, p.imagemPost, p.idUsuario, p.dataPublicacao, u.nomeUsuario
            FROM posts p
            INNER JOIN usuario u ON p.idUsuario = u.idUsuario
            WHERE p.idCategoria = ?
            ORDER BY p.dataPublicacao DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idCategoria);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT p.idPost, p.tituloPost, p.imagemPost, p.idUsuario, p.dataPublicacao, u.nomeUsuario
            FROM posts p
            INNER JOIN usuario u ON p.idUsuario = u.idUsuario
            ORDER BY p.dataPublicacao DESC";
    $result = $conn->query($sql);
}

if ($result && $result->num_rows > 0) {
    while ($post = $result->fetch_assoc()) {
        ?>
        <div class="col">
            <div class="card h-100 bg-dark border-0 shadow-sm">
                <img src="img/<?php echo $post['imagemPost'] ?: 'default.jpg'; ?>" class="card-img-top card-img-post" style="height: 250px" alt="<?php echo htmlspecialchars($post['tituloPost']); ?>">
                <div class="card-body">
                    <h4 class="card-title text-light"><?php echo $post['tituloPost']; ?></h4>
                    <p class="card-text text-white-50">Por <?php echo $post['nomeUsuario']; ?></p>
                    <small class="d-block text-white-50">
                        Publicado em <?php echo date("d/m/Y", strtotime($post['dataPublicacao'])); ?>
                    </small>
                    <a href="view/post.php?id=<?php echo $post['idPost']; ?>" class="btn btn-danger mt-3">
                        Ler mais
                    </a>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo "<p class='text-light'>Nenhum post encontrado nesta categoria.</p>";
}
