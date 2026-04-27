
<?php
require_once 'includes/functions.php';

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
    <input type="text" id="inputPesquisa" placeholder="Pesquisar por título...">
</div>
            
        </header>

        <section class="banner"></section>

        <section class="books-section">
    <h2>Livros</h2>
    
    <div class="livros-grid" style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px;">
        <?php
        // 1. Verificamos se a sessão existe e se não está vazia
        if (isset($_SESSION['meus_livros']) && !empty($_SESSION['meus_livros'])) {
            
            // 2. Iniciamos o loop
            foreach ($_SESSION['meus_livros'] as $livro) { 
        ?>
                <div class="card-livro" style="width: 200px; border: 1px solid #ddd; border-radius: 10px; padding: 15px; background: #fff; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <img src="<?php echo htmlspecialchars($livro['img_url']); ?>" alt="Capa" style="width: 100%; height: 250px; object-fit: cover; border-radius: 5px;">
                        <h3 class="titulo-livro" style="font-size: 1.1rem; margin: 10px 0 5px;"><?php echo htmlspecialchars($livro['titulo']); ?></h3>
                        <p style="color: #666; font-size: 0.9rem; margin-bottom: 5px;"><?php echo htmlspecialchars($livro['autor']); ?></p>
                        <span style="font-weight: bold; color: #2ecc71; display: block; margin-bottom: 15px;">R$ <?php echo htmlspecialchars($livro['valor']); ?></span>
                    </div>
                    
                    <a href="pages/carrinho.php?add=<?php echo urlencode($livro['titulo']); ?>" 
                       style="background-color: #333; color: white; text-decoration: none; text-align: center; padding: 10px; border-radius: 5px; font-size: 0.9rem; transition: 0.3s;"
                       onmouseover="this.style.backgroundColor='#555'" 
                       onmouseout="this.style.backgroundColor='#333'">
                       <i class="fas fa-shopping-cart"></i> Adicionar
                    </a>
                </div>
        <?php 
            } // Fim do foreach
            
        } else { 
            // 3. Caso não existam livros
            echo "<p>Nenhum livro cadastrado.</p>";
        } 
        ?>
    </div>
</section>
    </main>
<script>
    const inputPesquisa = document.getElementById('inputPesquisa');
    
    inputPesquisa.addEventListener('keyup', function() {
        // Pega o valor digitado e transforma em minúsculo
        let busca = inputPesquisa.value.toLowerCase();
        
        // Pega todos os cards de livros
        let cards = document.querySelectorAll('.card-livro');
        
        cards.forEach(card => {
            // Pega o texto do título dentro do card
            let titulo = card.querySelector('.titulo-livro').innerText.toLowerCase();
            
            // Se o título contiver o que foi digitado, mostra. Senão, esconde.
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