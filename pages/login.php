<?php
require_once '../includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erro = verificarLogado($_POST['nome'], $_POST['senha']); // Chama a função
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Bem-vindo</title>
    <link rel="stylesheet" href="../assets/login.css"> </head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>BEM-VINDO!</h1>
            
            <?php if(isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

            <form action="login.php" method="POST">
                <div class="input-group">
                    <label for="nome">NOME</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                <div class="input-group">
                    <label for="senha">SENHA</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                <div class="link-cadastro">
                    <a href="cadastrarperfil.php">NÃO POSSUI CONTA?</a>
                </div>
                <button type="submit" class="btn-entrar">ENTRAR</button>
            </form>
        </div>
    </div>
</body>
</html>