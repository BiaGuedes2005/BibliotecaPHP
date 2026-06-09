<?php
/**
 * ARQUIVO: LOGIN
 * Papel: Guarita de Identificação e Checagem de Lista Negra
 */

// A COLA
include '../includes/conexao.php';

// AS FUNÇÕES DA BIBLIOTECA
require_once '../includes/functions.php';

// A ENTREGA DOS DADOS
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // MÁSCARA DE GÁS
    $nome = trim($_POST['nome']);

    // CONSULTA À LISTA NEGRA
    $stmt = $conn->prepare("SELECT excluido_adm FROM usuarios WHERE nome = ?");
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    // CHECAGEM DE EXPULSÃO
    if ($res && $res['excluido_adm'] == 1) {
        $erro = "Sua conta foi excluída por violar as diretrizes do site.";
    } else {
        
        // CONFERÊNCIA DE SENHA
        $resultado = fazerLogin($_POST['nome'], $_POST['senha']);
        
        // ACESSO PERMITIDO
        if ($resultado === true) {
            
            // ENTREGA DO CRACHÁ E DIRECIONAMENTO:
            if ($_SESSION['usuario_tipo'] === 'adm') {
               // ADMINISTRADOR
                header("Location: adm_dashboard.php");
            } else {
                // USUÁRIO COMUM
                header("Location: ../index.php");
            }
            exit();
            
        } else {
            // ERRO DE AUTENTICAÇÃO
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
            
            <!-- ALERTA DE ERRO -->
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
                    <!-- BOTÃO "QUERO UM CRACHÁ" -->
                    <a href="cadastrarperfil.php">NÃO POSSUI CONTA?</a>
                </div>
                <button type="submit" class="btn-entrar">ENTRAR</button>
            </form>
        </div>
    </div>
</body>
</html>