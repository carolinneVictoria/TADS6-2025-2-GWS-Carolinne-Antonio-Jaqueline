<?php
include("../config/conexaoBD.php");
session_start();

$idUsuario = intval($_SESSION['idUsuario'] ?? 0);
$idComentario = intval($_GET['idComentario'] ?? 0);
$idPost = intval($_GET['idPost'] ?? 0);

if ($idUsuario <= 0 || $idComentario <= 0 || $idPost <= 0) {
    die("Erro: dados incompletos ou inválidos.");
}

// Verifica se o comentário pertence ao usuário logado
$stmt = $conn->prepare("SELECT idUsuario FROM comentarios WHERE idComentario = ?");
$stmt->bind_param("i", $idComentario);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Comentário não encontrado.");
}
$comentario = $result->fetch_assoc();
if ($comentario['idUsuario'] != $idUsuario) {
    die("Você não tem permissão para excluir este comentário.");
}

// Exclui o comentário
$stmt = $conn->prepare("DELETE FROM comentarios WHERE idComentario = ?");
$stmt->bind_param("i", $idComentario);
$stmt->execute();

header("Location: post.php?id=$idPost");
exit;
?>
