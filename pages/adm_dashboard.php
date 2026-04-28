<?php
session_start();
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'adm') {
    header("Location: login.php");
    exit();
}

// Garantir que os arrays existam para nao dar erro no JS
$usuarios_sessao = isset($_SESSION['usuarios_registrados']) ? $_SESSION['usuarios_registrados'] : [];
$livros_sessao = isset($_SESSION['meus_livros']) ? $_SESSION['meus_livros'] : [];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="../assets/style.css">
    
    <script src="https://bossanova.uk/jspreadsheet/v4/jexcel.js"></script>
    <script src="https://jsuites.net/v4/jsuites.js"></script>
    <link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />
    <link rel="stylesheet" href="https://bossanova.uk/jspreadsheet/v4/jexcel.css" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .admin-content {
            margin-left: 100px;
            padding: 40px;
            min-height: 100vh;
        }
        
        #minha-planilha {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            display: inline-block;
        }

        
    </style>
</head>
<body>

    <nav class="sidebar">
        <div class="icon-group">
            <a href="#"><i class="fas fa-user-circle"></i></a>
            <div style="margin-top: 40px; display: flex; flex-direction: column; gap: 20px;">
                <a href="javascript:void(0)" onclick="mostrarPlanilha('usuarios', meusUsuarios, meusProdutos)"><i class="fas fa-users"></i></a>
                <a href="javascript:void(0)" onclick="mostrarPlanilha('produtos', meusUsuarios, meusProdutos)"><i class="fas fa-book"></i></a>
            </div>
            <a href="logout.php" style="margin-top: auto; padding-bottom: 20px;"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </nav>

    <main class="admin-content">

        <header class="books-section" style="margin-top: 0; padding-left: 0;">
            <h2 style="margin-left: 0;">Painel do Administrador</h2>
        </header>
        <div id="minha-planilha"></div> 
    </main>

    <script src="../assets/scripts.js"></script>

<script>
    // Dados convertidos do PHP para JavaScript
    const meusUsuarios = [
        <?php 
        foreach($usuarios_sessao as $user) {
            echo "['" . addslashes($user['nome']) . "', '" . $user['tipo'] . "', true],";
        }
        ?>
    ];

    const meusProdutos = [
        <?php 
        foreach($livros_sessao as $livro) {
            // Tira o R$ e limpa o valor para o JS aceitar como número
            $valorLimpo = str_replace(['R$', ' ', '.'], '', $livro['valor']);
            $valorNumerico = str_replace(',', '.', $valorLimpo);
            echo "['" . addslashes($livro['titulo']) . "', '" . addslashes($livro['autor']) . "', " . $valorNumerico . "],";
        }
        ?>
    ];

    // inicia a planilha
    window.onload = function() {
        if (typeof mostrarPlanilha === 'function') {
            mostrarPlanilha('usuarios', meusUsuarios, meusProdutos);
        }
    };
</script>
</body>
</html>