<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Seu Carrinho</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/carrinho.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <nav class="sidebar">
        <div class="icon-group">
            <a href="perfil.php"><i class="fas fa-user-circle"></i></a>
            <a href="../index.php"><i class="fas fa-home"></i></a>
            <a href="carrinho.php"><i class="fas fa-shopping-cart"></i></a>
            <a href="cadastrarlivro.php"><i class="fas fa-book-open"></i></a>
            <a href="logout.php" style="margin-top: auto; padding-bottom: 20px;"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </nav>

    <main class="content">
        <header class="top-bar">
            <h1>Seu carrinho</h1>
            <div class="profile-dot"></div>
        </header>

        <div class="carrinho-container">
            <div class="lista-itens">
                <div class="item-livro"></div>
                <div class="item-livro"></div>
                <div class="item-livro"></div>
            </div>

            <aside class="resumo-compra">
                <h3>Total da compra</h3>
                <p class="valor">931.00</p>
                
                <div class="info-cliente">
                    <p>Nome</p>
                    <p>endereço</p>
                    <p>Cartão</p>
                </div>

                <button class="btn-confirma">Confirma</button>
            </aside>
        </div>
    </main>

</body>
</html>