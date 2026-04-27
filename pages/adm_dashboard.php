<?php
session_start();
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'adm') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel ADM - Planilha Real</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://bossanova.uk/jspreadsheet/v4/jexcel.js"></script>
    <script src="https://jsuites.net/v4/jsuites.js"></script>
    <link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />
    <link rel="stylesheet" href="https://bossanova.uk/jspreadsheet/v4/jexcel.css" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <nav class="sidebar">
        <div class="icon-group">
            <a href="#"><i class="fas fa-user-circle"></i></a>
            <div style="margin-top: 40px; display: flex; flex-direction: column; gap: 20px;">
                <a href="javascript:void(0)" onclick="mostrarPlanilha('usuarios')"><i class="fas fa-users"></i></a>
                <a href="javascript:void(0)" onclick="mostrarPlanilha('produtos')"><i class="fas fa-book"></i></a>
            </div>
            <a href="logout.php" style="margin-top: auto; padding-bottom: 20px;"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </nav>

    <main class="admin-content" style="margin-left: 80px; padding: 20px;">
        <div id="minha-planilha"></div> </main>

    <script src="../assets/scripts.js"></script>

<script>
    // Geramos os dados aqui (onde o PHP funciona)
    const meusUsuarios = [
        <?php 
        foreach($_SESSION['usuarios_registrados'] as $user) {
            echo "['" . addslashes($user['nome']) . "', '" . $user['tipo'] . "', true],";
        }
        ?>
    ];

    const meusProdutos = [
        <?php 
        foreach($_SESSION['meus_livros'] as $livro) {
            echo "['" . addslashes($livro['titulo']) . "', '" . addslashes($livro['autor']) . "', " . $livro['valor'] . "],";
        }
        ?>
    ];

    // Chamamos a função passando os dados como "presente"
    // Exemplo: ao clicar no botão de usuários
    mostrarPlanilha('usuarios', meusUsuarios, meusProdutos);
</script>
</body>
</html>