<?php 
include("../view/header.php");

$autor = isset($_SESSION['nomeUsuario']) ? $_SESSION['nomeUsuario'] : "Anônimo";
?>

<div class="cadastrarTexto-container">
    <h1>Escrever Texto</h1>
    <form class="cadastrarTexto-form" action="actionTexto.php" method="POST" enctype="multipart/form-data">
        
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" required>

        <label for="conteudo">Conteúdo</label>
        <textarea name="conteudo" id="conteudo" required></textarea>

        <label for="imagem">Imagem</label>
        <input type="file" name="imagem" id="imagem" accept="image/*" required>

        <label for="data">Data</label>
        <input type="date" name="data" id="data" value="<?php echo date('Y-m-d'); ?>" required>

        <label for="autor">Autor</label>
        <input type="text" name="autor" id="autor" value="<?php echo $autor; ?>" readonly>

        <button type="submit">Publicar</button>
    </form>
</div>

<?php include("footer.php"); ?>
