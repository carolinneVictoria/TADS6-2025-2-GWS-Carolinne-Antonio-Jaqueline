<?php 
include("../config/conexaoBD.php");
include("header.php");


if (isset($_GET['id'])) {
    $idPost = intval($_GET['id']);
    
    $sql = "SELECT p.idPost, p.tituloPost, p.imagemPost, p.dataPublicacao, p.descricaoPost, p.idUsuario, u.nomeUsuario
            FROM posts p
            INNER JOIN usuario u ON p.idUsuario = u.idUsuario
            WHERE p.idPost = $idPost";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $post = $result->fetch_assoc();
    } else {
        die("Post não encontrado.");
    }
} else {
    die("ID não fornecido.");
}

$idUsuarioLogado = $_SESSION['idUsuario'] ?? null;

// Contar curtidas
$stmt = $conn->prepare("SELECT COUNT(*) AS totalCurtidas FROM curtidas WHERE idPost = ?");
$stmt->bind_param("i", $idPost);
$stmt->execute();
$totalCurtidas = $stmt->get_result()->fetch_assoc()['totalCurtidas'];

// Verificar se o usuário já curtiu
$jaCurtiu = false;
if ($idUsuarioLogado) {
    $stmt = $conn->prepare("SELECT * FROM curtidas WHERE idPost = ? AND idUsuario = ?");
    $stmt->bind_param("ii", $idPost, $idUsuarioLogado);
    $stmt->execute();
    $jaCurtiu = $stmt->get_result()->num_rows > 0;
}

// Pegar comentários
$stmt = $conn->prepare("SELECT c.texto, u.nomeUsuario, c.dataComentario 
                        FROM comentarios c 
                        INNER JOIN usuario u ON c.idUsuario = u.idUsuario
                        WHERE c.idPost = ? 
                        ORDER BY c.dataComentario ASC");
$stmt->bind_param("i", $idPost);
$stmt->execute();
$comentarios = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-4 bg-dark text-light p-4">
        <div>
            <div>
                <?php if (!empty($post['imagemPost'])): ?>
                    <img src="../img/<?php echo $post['imagemPost']; ?>" class="img-fluid rounded me-4 mb-3 float-start" style="max-width: 400px; height: auto;" alt="Imagem do Post">
                <?php endif; ?>
            </div>
            <div style="align-items: right; text-align: center; padding-top: 50px;">
                <h1 class="card-title oswald"><?php echo htmlspecialchars($post['tituloPost']); ?></h1>
                <p></p>
                <p class="text mb-1">
                    Publicado em <?php echo date("d/m/Y", strtotime($post['dataPublicacao'])); ?>
                    por <strong><?php echo htmlspecialchars($post['nomeUsuario']); ?></strong>
                </p>
            </div>
        </div>

        <hr>

        <p class="card-text">
            <?php echo nl2br(htmlspecialchars($post['descricaoPost'])); ?>
        </p>

        <div class="clearfix"></div>

        <?php if ($idUsuarioLogado && $idUsuarioLogado == $post['idUsuario']): ?>
            <div class="mt-3 d-flex gap-3">
                <a href="editarPost.php?id=<?php echo $post['idPost']; ?>" class="btn btn-outline-warning btn-sm">
                    <i class="bi bi-pencil-square"></i> Editar
                </a>
                <a href="actionExcluirPost.php?id=<?php echo $post['idPost']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este post?');">
                    <i class="bi bi-trash"></i> Excluir
                </a>
            </div>
        <?php endif; ?>

        <!-- Curtidas e Comentários -->
        <div class="mt-4 pt-3 border-top">
            <!-- Botão de Curtida -->
            <?php if ($idUsuarioLogado): ?>
                <form action="actionCurtir.php" method="POST" class="d-inline">
                    <input type="hidden" name="idPost" value="<?php echo $idPost; ?>">
                    <button type="submit" class="btn btn-sm btn-outline-light mb-3">
                        <i class="bi <?php echo $jaCurtiu ? 'bi-heart-fill text-danger' : 'bi-heart'; ?>"></i>
                        Curtir (<?php echo $totalCurtidas; ?>)
                    </button>
                </form>
            <?php else: ?>
                <button class="btn btn-sm btn-outline-light mb-3" disabled>
                    <i class="bi bi-heart"></i> Curtir (<?php echo $totalCurtidas; ?>)
                </button>
                <p class="text-muted">Faça login para curtir.</p>
            <?php endif; ?>

            <!-- Lista de Comentários -->
            <h5>Comentários</h5>
            <?php foreach ($comentarios as $comentario): ?>
                <div class="mb-2 p-2 bg-dark bg-opacity-50 rounded">
                    <strong><?php echo htmlspecialchars($comentario['nomeUsuario']); ?>:</strong>
                    <span><?php echo htmlspecialchars($comentario['texto']); ?></span>
                    <br><small class="text-muted"><?php echo date("d/m/Y H:i", strtotime($comentario['dataComentario'])); ?></small>
                </div>
            <?php endforeach; ?>

            <!-- Formulário para novo comentário -->
            <?php if ($idUsuarioLogado): ?>
                <form action="actionComentario.php" method="POST" class="mt-2">
                    <input type="hidden" name="idPost" value="<?php echo $idPost; ?>">
                    <div class="input-group">
                        <input type="text" name="comentario" class="form-control" placeholder="Escreva um comentário..." required>
                        <button class="btn btn-outline-light" type="submit">Enviar</button>
                    </div>
                </form>
            <?php else: ?>
                <p class="text-muted mt-2">Faça login para comentar.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
