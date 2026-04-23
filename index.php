<?php
session_start();

// Se NÃO existir a sessão 'logado', manda para a pasta pages/login.php
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: pages/login.php"); // Aqui estava index.php, mudei para o caminho do login
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Livraria da Bia</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <nav class="sidebar">
        <div class="icon-group">
                <i class="fas fa-user-circle"></i>
            <a href="index.php">
                <i class="fas fa-home"></i>
            </a>
            <a href="pages/carrinho.php">
                <i class="fas fa-shopping-cart"></i>
            </a>
            <a href="pages/cadastrarlivro.php">
                <i class="fas fa-book-open"></i>
            </a>
            <a href="pages/logout.php" title="Sair" style="margin-top: auto; padding-bottom: 20px;">
               <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </nav>

    <main class="content">
        <header class="top-bar">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Pesquisar...">
            </div>
            <div class="profile-dot"></div>
        </header>

        <section class="banner"></section>

        <section class="books-section">
            <h2>Livros</h2>
            <div class="books-grid">
                <div class="book-card">
                    <div class="book-cover"></div>
                    <span>Fairy Tale</span>
                </div>
                <div class="book-card">
                    <div class="book-cover"></div>
                    <span>Never After</span>
                </div>
                <div class="book-card">
                    <div class="book-cover"></div>
                    <span>Hamnet</span>
                </div>
                <div class="book-card">
                    <div class="book-cover"></div>
                    <span>Mist and fury</span>
                </div>
            </div>
        </section>
    </main>

</body>
</html>