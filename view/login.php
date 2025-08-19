<?php
session_start();
include("../config/conexaoBD.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $emailUsuario = mysqli_real_escape_string($conn, $_POST['emailUsuario']);
    $senhaUsuario = $_POST['senhaUsuario']; // senha pura, sem hash aqui

    // Busca o usuário pelo email
    $query = "SELECT * FROM Usuario WHERE emailUsuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $emailUsuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Verifica a senha
        if (password_verify($senhaUsuario, $usuario['senhaUsuario'])) {
            // Senha correta
            $_SESSION['idUsuario'] = $usuario['idUsuario'];
            $_SESSION['emailUsuario'] = $usuario['emailUsuario'];
            $_SESSION['nomeUsuario'] = $usuario['nomeUsuario'];
            $_SESSION['logado'] = true;

            header('Location: inicio.php');
            exit();
        } else {
            // Senha incorreta
            header('Location: formLogin.php?erroLogin=dadosInvalidos');
            exit();
        }
    } else {
        // Usuário não encontrado
        header('Location: formLogin.php?erroLogin=dadosInvalidos');
        exit();
    }

} else {
    header('Location: formLogin.php');
    exit();
}
?>
