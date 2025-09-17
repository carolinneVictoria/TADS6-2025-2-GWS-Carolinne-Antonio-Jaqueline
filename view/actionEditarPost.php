<?php
include("../config/conexaoBD.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idPost   = intval($_POST['idPost']);
    $titulo   = trim($_POST['titulo']);
    $conteudo = trim($_POST['conteudo']);
    $data     = $_POST['data'];
    $idUsuario = intval($_POST['idUsuario']);
    $categoria = $_POST['categoria'];

    // Verifica se foi enviada uma nova imagem
    $nomeImagem = null;
    if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION);
        $nomeImagem = uniqid("img_", true) . "." . strtolower($ext);
        $destino = "../img/" . $nomeImagem;

        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $destino)) {
            // tudo certo
        } else {
            die("Erro ao salvar a nova imagem.");
        }
    }

    // Atualiza os dados no banco
    if ($nomeImagem) {
    $sql = "UPDATE posts 
            SET tituloPost = ?, descricaoPost = ?, dataPublicacao = ?, idCategoria = ?, imagemPost = ?, idUsuario = ?
            WHERE idPost = ?";
    if (!$stmt = $conn->prepare($sql)) {
        die("Erro ao preparar statement: " . $conn->error);
        }
        $stmt->bind_param("sssiiii", $titulo, $conteudo, $data, $categoria, $nomeImagem, $idUsuario, $idPost);
    } else {
        $sql = "UPDATE posts 
                SET tituloPost = ?, descricaoPost = ?, dataPublicacao = ?, idCategoria = ?, idUsuario = ?
                WHERE idPost = ?";
        if (!$stmt = $conn->prepare($sql)) {
            die("Erro ao preparar statement: " . $conn->error);
        }
        $stmt->bind_param("sssiii", $titulo, $conteudo, $data, $categoria, $idUsuario, $idPost);
    }



    if ($stmt->execute()) {
        header("Location: post.php?id=" . $idPost);
        exit();
    } else {
        echo "Erro ao atualizar o post: " . $stmt->error;
    }
} else {
    die("Requisição inválida.");
}
