<?php include("header.php"); ?>

<div class="formLogin">
    <div class="form-Control">
        <div class="control"><a href="login.php">Entrar</a></div>
        <div class="control"><a href="cadastro.php">Cadastrar</a></div>
    </div>
    <div class="form">
            <form action="actionUsuario.php" method="POST">

                <div class="formFloating">
                    <label for="nomeUsuario">Nome</label>
                    <input class="formInput" type="text" id="nomeUsuario" placeholder="Informe seu nome de Usuário" name="nomeUsuario" required>
                </div>

                <div class="formFloating">
                    <label for="emailUsuario">Email</label>
                    <input class="formInput" type="email" id="emailUsuario" placeholder="Informe o seu email" name="emailUsuario" required>
                </div>

                <div class="formFloating">
                    <label for="senhaUsuario">Senha</label>
                    <input class="formInput" type="password" id="senhaUsuario" placeholder="Informe a sua senha" name="senhaUsuario" required>
                </div>
                
                <button type="submit">Criar Conta</button>
            </form>
    </div>
</div>

<?php include("footer.php"); ?>
