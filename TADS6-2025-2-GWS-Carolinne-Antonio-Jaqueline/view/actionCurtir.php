<?php
include("../config/conexaoBD.php");
session_start();

$idUsuario = intval($_SESSION['idUsuario'] ?? 0);

$idPost = intval($_POST['idPost'] ?? 0);

if ($idUsuario <= 0 || $idPost <= 0) {
    die("Erro: dados do usuário ou do post inválidos.");
}

$stmt = $conn->prepare("SELECT * FROM curtidas WHERE idPost = ? AND idUsuario = ?");
$stmt->bind_param("ii", $idPost, $idUsuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stmt = $conn->prepare("DELETE FROM curtidas WHERE idPost = ? AND idUsuario = ?");
    $stmt->bind_param("ii", $idPost, $idUsuario);
    $stmt->execute();
} else {
    $stmt = $conn->prepare("INSERT INTO curtidas (idPost, idUsuario) VALUES (?, ?)");
    $stmt->bind_param("ii", $idPost, $idUsuario);
    $stmt->execute();
}

header("Location: post.php?id=$idPost");
exit;
?>