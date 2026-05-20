<?php include 'includes/conexao.php'; ?>
<?php
require_once 'includes/functions.php';
$tema = carregarTema($conn);
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: pages/login.php");
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
<div id="lofi-player" style="
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 280px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    z-index: 999;
    border: 4px solid #FAA947; /* <--- A SUA BORDA AQUI */
">
    <iframe 
        width="280" 
        height="157" 
        src="https://www.youtube.com/embed/CFGLoQIhmow?autoplay=1&mute=1"
        title="Lofi Music"
        frameborder="0" 
        allow="autoplay; encrypted-media" 
        allowfullscreen>
    </iframe>
</div>
<body class="<?php echo $tema; ?>">

<?php if (isset($_SESSION['sucesso_compra'])): ?>
    <div id="alerta-compra" style="
        position: fixed;
        top: 20px;
        right: 20px;
        background: #2ecc71;
        color: white;
        padding: 16px 40px 16px 20px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        z-index: 1000;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    ">
        <i class="fas fa-check-circle" style="font-size: 1.3rem;"></i>
        <span><?php echo $_SESSION['sucesso_compra']; ?></span>
        
        <button onclick="this.parentElement.style.display='none'" style="
            background: none;
            border: none;
            color: white;
            font-size: 1.1rem;
            cursor: pointer;
            margin-left: 15px;
            opacity: 0.8;
        " onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <?php 
    // CRÍTICO: Limpa a mensagem da sessão para ela não aparecer de novo ao atualizar a index!
    unset($_SESSION['sucesso_compra']); 
    ?>
<?php endif; ?>

    <nav class="sidebar">
        <div class="icon-group">
            <a href="pages/perfil.php"><i class="fas fa-user-circle"></i></a>
            <a href="index.php"><i class="fas fa-home"></i></a>
            <a href="pages/carrinho.php"><i class="fas fa-shopping-cart"></i></a>
            <a href="pages/cadastrarlivro.php"><i class="fas fa-book-open"></i></a>
            <a href="pages/logout.php" style="margin-top: auto; padding-bottom: 20px;">
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
                $resultado = $conn->query("SELECT * FROM livros ORDER BY created_at DESC");
                if ($resultado && $resultado->num_rows > 0) {
                    while ($livro = $resultado->fetch_assoc()) {
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
            let busca = inputPesquisa.value.toLowerCase();
            let cards = document.querySelectorAll('.card-livro');
            cards.forEach(card => {
                let titulo = card.querySelector('.titulo-livro').innerText.toLowerCase();
                if (titulo.includes(busca)) {
                    card.style.display = "flex";
                } else {
                    card.style.display = "none";
                }
            });
        });
        
    function alternarTema() {
    const temaAtual = document.body.classList.contains('dark') ? 'escuro' : 'claro';
    const novoTema = temaAtual === 'escuro' ? 'claro' : 'escuro';

    fetch('pages/salvar_tema.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'tema=' + novoTema
    }).then(() => {
        document.body.classList.toggle('dark');
        const icone = document.getElementById('icone-tema');
        if (icone) {
            icone.classList.toggle('fa-moon');
            icone.classList.toggle('fa-sun');
        }
    });
}

    </script>
</body>
</html>