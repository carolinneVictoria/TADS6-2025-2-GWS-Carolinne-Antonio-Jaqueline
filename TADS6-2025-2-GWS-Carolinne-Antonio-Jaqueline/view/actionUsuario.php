<?php
session_start();

include("header.php");
include("../config/conexaoBD.php");

$erroPreenchimento = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeUsuario  = filtrar_entrada($_POST["nomeUsuario"]);
    $emailUsuario = filtrar_entrada($_POST["emailUsuario"]);
    $senhaUsuario = filtrar_entrada($_POST["senhaUsuario"]);

    $senhaHash = password_hash($senhaUsuario, PASSWORD_DEFAULT);

    if (!$erroPreenchimento) {
        $stmt = $conn->prepare("INSERT INTO Usuario (nomeUsuario, emailUsuario, senhaUsuario) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nomeUsuario, $emailUsuario, $senhaHash);

        if ($stmt->execute()) {
            $idUsuario = $stmt->insert_id;

            $_SESSION['idUsuario']  = $idUsuario;
            $_SESSION['nomeUsuario'] = $nomeUsuario;
            $_SESSION['emailUsuario'] = $emailUsuario;

            header("Location: ../index.php");
            exit();
        } else {
            echo "<div class='alert alert-danger text-center'>Erro ao tentar cadastrar usuário!</div>";
        }
        $stmt->close();
    }
}

function filtrar_entrada($dado){
    $dado = trim($dado);
    $dado = stripslashes($dado);
    $dado = htmlspecialchars($dado);
    return $dado;
}

include("footer.php");
?>
