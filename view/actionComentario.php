<?php
include("../config/conexaoBD.php");
session_start();

$idUsuario = intval($_SESSION['idUsuario'] ?? 0);

$idPost = intval($_POST['idPost'] ?? 0);
$texto = trim($_POST['comentario'] ?? '');

if ($idUsuario <= 0 || $idPost <= 0 || empty($texto)) {
    die("Erro: dados incompletos ou inválidos.");
}

$stmt = $conn->prepare("INSERT INTO comentarios (idPost, idUsuario, texto) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $idPost, $idUsuario, $texto);
$stmt->execute();

header("Location: post.php?id=$idPost");
exit;
?>
