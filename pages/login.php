<?php
include '../includes/conexao.php';
require_once '../includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);

    // Verifica se a conta foi excluída pelo adm
    $stmt = $conn->prepare("SELECT excluido_adm FROM usuarios WHERE nome = ?");
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    if ($res && $res['excluido_adm'] == 1) {
        $erro = "Sua conta foi excluída por violar as diretrizes do site.";
    } else {
        $resultado = fazerLogin($_POST['nome'], $_POST['senha']);
        if ($resultado === true) {
            if ($_SESSION['usuario_tipo'] === 'adm') {
                header("Location: adm_dashboard.php");
            } else {
                header("Location: ../index.php");
            }
            exit();
        } else {
            $erro = "Nome ou senha incorretos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Bem-vindo</title>
    <link rel="stylesheet" href="../assets/login.css">
</head>
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