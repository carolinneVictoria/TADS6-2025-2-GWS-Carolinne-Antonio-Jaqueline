<?php
include("../config/conexaoBD.php");
include("../view/header.php");

$autor = $_SESSION['nomeUsuario'] ?? "Anônimo";
$idUsuarioLogado = $_SESSION['idUsuario'] ?? null;

if (!isset($_GET['id'])) {
    die("ID do post não fornecido.");
}

$idPost = intval($_GET['id']);

$sqlPost = "SELECT * FROM posts WHERE idPost = ?";
$stmt = $conn->prepare($sqlPost);
$stmt->bind_param("i", $idPost);
$stmt->execute();
$resultPost = $stmt->get_result();

if ($resultPost->num_rows === 0) {
    die("Post não encontrado.");
}

$sqlPost = "SELECT p.*, c.descricaoCategoria
            FROM posts p
            LEFT JOIN categoria c ON p.idCategoria = c.idCategoria
            WHERE p.idPost = ?";

$post = $resultPost->fetch_assoc();

$queryCategorias = "SELECT idCategoria, descricaoCategoria FROM categoria";
$resultCategorias = mysqli_query($conn, $queryCategorias);
?>

<div class="container my-5">
    <div class="card shadow-lg border-0" style="background-color:#20293b; border-radius:16px;">
        <div class="card-body p-5">
            <h1 class="text-center mb-4 oswald text-white">✍️ Editar Texto</h1>

            <form action="actionEditarPost.php" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="idPost" value="<?php echo $post['idPost']; ?>">

                <div class="mb-3">
                    <label for="titulo" class="form-label text-light">Título</label>
                    <input type="text" name="titulo" id="titulo" class="form-control bg-dark text-light border-0 rounded-pill" required
                           value="<?php echo htmlspecialchars($post['tituloPost']); ?>">
                </div>

                <div class="mb-3">
                    <label for="conteudo" class="form-label text-light">Conteúdo</label>
                    <textarea name="conteudo" id="conteudo" rows="6" class="form-control bg-dark text-light border-0 rounded-4" required><?php echo htmlspecialchars($post['descricaoPost']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="imagem" class="form-label text-light">Imagem atual</label><br>
                    <?php if (!empty($post['imagemPost'])): ?>
                        <img src="../img/<?php echo $post['imagemPost']; ?>" style="max-width:200px; margin-bottom:10px;" alt="Imagem do Post">
                    <?php else: ?>
                        <p class="text-light">Nenhuma imagem cadastrada.</p>
                    <?php endif; ?>
                    <input type="file" name="imagem" id="imagem" accept="image/*" class="form-control bg-dark text-light border-0">
                    <small class="text-light">Selecione uma nova imagem apenas se quiser trocar a atual.</small>
                </div>

                <div class="mb-3">
                    <label for="data" class="form-label text-light">Data</label>
                    <input type="date" name="data" id="data" class="form-control bg-dark text-light border-0 rounded-pill" required
                           value="<?php echo date('Y-m-d', strtotime($post['dataPublicacao'])); ?>">
                </div>

                <input type="hidden" name="idUsuario" value="<?php echo $idUsuarioLogado; ?>">
                <div class="mb-3">
                    <label for="autor" class="form-label text-light">Autor</label>
                    <input type="text" id="autor" value="<?php echo $autor; ?>"
                        class="form-control bg-dark text-light border-0 rounded-pill" readonly>
                </div>


                <div class="mb-3">
                    <label for="categoria" class="form-label text-light">Categoria</label>
                    <select name="categoria" id="categoria" class="form-control bg-dark text-light border-0 rounded-pill">
                        <?php while ($cat = mysqli_fetch_assoc($resultCategorias)) : ?>
                            <option value="<?php echo $cat['idCategoria']; ?>" 
                                <?php echo ($cat['idCategoria'] == $post['idCategoria']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['descricaoCategoria']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn px-3" style="background-color: var(--accent); border-radius:25px; color:#fff; font-weight:500;">
                        Salvar Alterações
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
