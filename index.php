
<?php
require_once 'includes/functions.php';

// Se NAO existir a sessao 'logado', manda para a pasta pages/login.php
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
    <input type="text" id="inputPesquisa" placeholder="Pesquisar por título...">
</div>
            
        </header>

        <section class="banner"></section>

        <section class="books-section">
    <h2>Livros</h2>
    
    <div class="livros-grid">
        <?php
        if (isset($_SESSION['meus_livros']) && !empty($_SESSION['meus_livros'])) {
            foreach ($_SESSION['meus_livros'] as $livro) { 
        ?>
                <div class="card-livro">
                    <div class="card-info">
                        <img src="<?php echo htmlspecialchars($livro['img_url']); ?>" alt="Capa">
                        <h3 class="titulo-livro"><?php echo htmlspecialchars($livro['titulo']); ?></h3>
                        <p class="autor-livro"><?php echo htmlspecialchars($livro['autor']); ?></p>
                        <span class="preco-livro">R$ <?php echo htmlspecialchars($livro['valor']); ?></span>
                    </div>
                    
                    <a href="pages/carrinho.php?add=<?php echo urlencode($livro['titulo']); ?>" class="btn-adicionar">
                       <i class="fas fa-shopping-cart"></i> Adicionar
                    </a>
                </div>
        <?php 
            } 
        } else { 
            echo "<p class='msg-vazia'>Nenhum livro cadastrado no momento.</p>";
        } 
        ?>
    </div>
</section>
    </main>
<script>
    const inputPesquisa = document.getElementById('inputPesquisa');
    
    inputPesquisa.addEventListener('keyup', function() {
        // Pega o valor digitado e transforma em minusculo
        let busca = inputPesquisa.value.toLowerCase();
        
        // Pega todos os cards de livros
        let cards = document.querySelectorAll('.card-livro');
        
        cards.forEach(card => {
            // Pega o texto do titulo dentro do card
            let titulo = card.querySelector('.titulo-livro').innerText.toLowerCase();
            
            // Se o titulo contiver o que foi digitado, vai mostrar os livros correspondentes, se nao tiver, nao mostra nada
            if (titulo.includes(busca)) {
                card.style.display = "flex";
            } else {
                card.style.display = "none";
            }
        });
    });
</script>
</body>
</html>