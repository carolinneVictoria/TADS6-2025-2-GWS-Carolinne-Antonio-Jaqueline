<?php
session_start();
include("header.php");
include("../config/conexaoBD.php");

// Verifica se o usuário está logado
if (!isset($_SESSION['idUsuario'])) {
    header("Location: formLogin.php");
    exit();
}

$idUsuario = $_SESSION['idUsuario'];

// Pega os dados do usuário
$stmt = $conn->prepare("SELECT nomeUsuario, emailUsuario FROM usuario WHERE idUsuario = ?");
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Pega os posts do usuário
$stmt = $conn->prepare("SELECT p.idPost, p.tituloPost, p.imagemPost, p.dataPublicacao, c.descricaoCategoria
                        FROM posts p
                        LEFT JOIN categoria c ON p.idCategoria = c.idCategoria
                        WHERE p.idUsuario = ?
                        ORDER BY p.dataPublicacao DESC");
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$posts = $stmt->get_result();
$stmt->close();
?>

<div class="container my-5">
    <h1 class="text-light mb-4">Perfil de <?php echo htmlspecialchars($usuario['nomeUsuario']); ?></h1>

    <div class="card bg-dark text-light p-4 mb-5">
        <h3>Meus Dados</h3>
        <p><strong>Nome:</strong> <?php echo htmlspecialchars($usuario['nomeUsuario']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($usuario['emailUsuario']); ?></p>
    </div>

    <div class="card bg-dark text-light p-4">
        <h3>Meus Textos/Publicações</h3>

        <?php if ($posts->num_rows > 0): ?>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <?php while($post = $posts->fetch_assoc()): ?>
                    <div class="col">
                        <div class="card h-100 bg-secondary text-light">
                            <?php if (!empty($post['imagemPost'])): ?>
                                <img src="../img/<?php echo $post['imagemPost']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($post['tituloPost']); ?></h5>
                                <p class="card-text"><small>Publicado em <?php echo date("d/m/Y", strtotime($post['dataPublicacao'])); ?></small></p>
                                <p class="card-text"><small>Categoria: <?php echo htmlspecialchars($post['descricaoCategoria']); ?></small></p>
                                <a href="post.php?id=<?php echo $post['idPost']; ?>" class="btn btn-warning btn-sm">Ver Post</a>
                                <a href="actionExcluirPost.php?id=<?php echo $post['idPost']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este post?');">Excluir</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Você ainda não publicou nenhum texto.</p>
        <?php endif; ?>
    </div>
</div>

<?php include("footer.php"); ?>
