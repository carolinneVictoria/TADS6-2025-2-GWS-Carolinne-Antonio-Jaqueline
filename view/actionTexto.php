<?php
session_start();

include("header.php");
include("../config/conexaoBD.php");

if (!isset($_SESSION['idUsuario'])) {
    header("Location: formLogin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo   = filtrar_entrada($_POST["titulo"]);
    $conteudo = filtrar_entrada($_POST["conteudo"]);
    $data     = date("Y-m-d H:i:s");
    $idUsuario = $_SESSION["idUsuario"];
    $idCategoria = intval($_POST['categoria'] ?? 0);

    $imagemPath = null;
    if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION);
        $nomeUnico = uniqid("img_", true) . "." . strtolower($ext);
        $destino = "../img/" . $nomeUnico;

        if (!is_dir("../img/")) {
            mkdir("../img/", 0755, true);
        }

        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $destino)) {
            $imagemPath = $nomeUnico;
        }
    }

    if (!empty($titulo) && !empty($conteudo)) {
        $stmt = $conn->prepare(
            "INSERT INTO posts (tituloPost, descricaoPost, imagemPost, dataPublicacao, idUsuario, idCategoria)
                VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ssssii", $titulo, $conteudo, $imagemPath, $data, $idUsuario, $idCategoria);

        if ($stmt->execute()) {
            header("Location: /TADS6-2025-2-GWS-Carolinne-Antonio-Jaqueline/TADS6-2025-2-GWS-Carolinne-Antonio-Jaqueline/index.php");
            exit();
        } else {
            echo "<div class='alert alert-danger text-center'>Erro ao cadastrar texto!</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert alert-warning text-center'>Preencha todos os campos obrigatórios.</div>";
    }
}

function filtrar_entrada($dado) {
    $dado = trim($dado);
    $dado = stripslashes($dado);
    $dado = htmlspecialchars($dado);
    return $dado;
}

include("footer.php");
?>
