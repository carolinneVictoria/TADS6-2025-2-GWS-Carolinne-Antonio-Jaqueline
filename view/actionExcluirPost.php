<?php
include("../config/conexaoBD.php");
session_start();

if (!isset($_SESSION['idUsuario'])) {
    die("Você precisa estar logado para excluir um post.");
}

if (isset($_GET['id'])) {
    $idPost = intval($_GET['id']);
    $idUsuarioLogado = $_SESSION['idUsuario'];

    $sql = "SELECT imagemPost, idUsuario FROM posts WHERE idPost = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idPost);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Post não encontrado.");
    }

    $post = $result->fetch_assoc();

    if ($post['idUsuario'] != $idUsuarioLogado) {
        die("Você não tem permissão para excluir este post.");
    }

    if (!empty($post['imagemPost'])) {
        $caminhoImagem = "../img/" . $post['imagemPost'];
        if (file_exists($caminhoImagem)) {
            unlink($caminhoImagem);
        }
    }

    $stmt = $conn->prepare("DELETE FROM posts WHERE idPost = ?");
    $stmt->bind_param("i", $idPost);

    if ($stmt->execute()) {
        header("Location: ../index.php?msg=Post+excluido+com+sucesso");
        exit();
    } else {
        echo "Erro ao excluir post: " . $stmt->error;
    }
} else {
    die("ID do post não fornecido.");
}
