<?php include("header.php"); ?>

<?php
    if(isset($_GET["erroLogin"])){
        $erroLogin = $_GET["erroLogin"];

        if($erroLogin == "dadosInvalidos"){
            echo "<div class='alert alert-warning text-center'>
                <strong>Usuário</strong> ou <strong>SENHA</strong> inválidos!
            </div>";
        }
        
    }
?>

<div class="formLogin">
    <div class="form-Control">
        <div class="control"><a href="login.php">Entrar</a></div>
        <div class="control"><a href="cadastro.php">Cadastrar</a></div>
    </div>
    <div class="form">
            <form action="login.php" method="POST">
                <div class="formFloating">
                    <label for="emailUsuario">Email</label>
                    <input class="formInput" type="email" id="emailUsuario" placeholder="Informe o seu email" name="emailUsuario" required>
                </div>

                <div class="formFloating">
                    <label for="senhaUsuario">Senha</label>
                    <input class="formInput" type="password" id="senhaUsuario" placeholder="Informe a sua senha" name="senhaUsuario" required>   
                </div>
                
                <button type="submit">Fazer Login</button>
            </form>

            <?php if (!empty($erro)): ?>
                <p style="color:red; text-align:center;"><?php echo $erro; ?></p>
            <?php endif; ?>
    </div>
</div>

<?php include("footer.php"); ?>
