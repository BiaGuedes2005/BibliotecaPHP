<?php
include '../includes/conexao.php';
require_once '../includes/functions.php';
verificarLogado();

$tema = carregarTema($conn);
$usuario_id = $_SESSION['usuario_id'];
$usuario_nome = $_SESSION['usuario_nome'];
$inicial = strtoupper(mb_substr($usuario_nome, 0, 1));

// Busca livros excluídos pelo adm APENAS se o usuário ainda não tiver visto o aviso (excluido_adm = 1)
$stmt = $conn->prepare("SELECT id, titulo_original FROM livros WHERE usuario_id = ? AND excluido_adm = 1");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$livros_excluidos = $stmt->get_result();

// Busca os livros ativos do usuário
$stmt2 = $conn->prepare("SELECT * FROM livros WHERE usuario_id = ? AND excluido_adm = 0 ORDER BY created_at DESC");
$stmt2->bind_param("i", $usuario_id);
$stmt2->execute();
$meus_livros = $stmt2->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/perfil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="<?php echo $tema; ?>">

    <nav class="sidebar">
        <div class="icon-group">
            <a href="perfil.php"><i class="fas fa-user-circle"></i></a>
            <a href="../index.php"><i class="fas fa-home"></i></a>
            <a href="carrinho.php"><i class="fas fa-shopping-cart"></i></a>
            <a href="cadastrarlivro.php"><i class="fas fa-book-open"></i></a>
            <a href="logout.php" style="margin-top: auto; padding-bottom: 20px;">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </nav>

    <main class="content">
        <header class="top-bar perfil-topbar">
            <h1 class="titulo-pagina" style="border-left: 5px solid #F15256; padding-left: 15px; line-height: 1.2;">Meu Perfil</h1>
            <button class="btn-tema" id="btnTema" onclick="alternarTema()">
                <i class="fas <?php echo $tema === 'escuro' ? 'fa-sun' : 'fa-moon'; ?>" id="icone-tema"></i>
            </button>
        </header>

        <!-- Alertas de livros excluídos pelo adm -->
        <?php while ($lv = $livros_excluidos->fetch_assoc()): ?>
            <div class="alerta-exclusao" style="position: relative; background:#F15256; color:white; padding:14px 40px 14px 20px; border-radius:12px; margin-bottom:12px; font-weight:500;">
                <i class="fas fa-exclamation-triangle"></i>
                O livro <strong>"<?php echo htmlspecialchars($lv['titulo_original']); ?>"</strong> foi excluído por violar as diretrizes do site.
                
                <a href="limpar_alerta.php?id=<?php echo $lv['id']; ?>" style="
                    position: absolute;
                    top: 50%;
                    right: 15px;
                    transform: translateY(-50%);
                    background: none;
                    border: none;
                    color: white;
                    font-size: 1.2rem;
                    cursor: pointer;
                    opacity: 0.8;
                    text-decoration: none;
                " onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        <?php endwhile; ?>

        <!-- Card do usuário -->
        <div class="perfil-card">
            <div class="perfil-inicial"><?php echo $inicial; ?></div>
            <div class="perfil-info">
                <p class="perfil-ola">Olá, <strong><?php echo htmlspecialchars($usuario_nome); ?></strong></p>
                <p class="perfil-tipo">Conta: <?php echo ucfirst($_SESSION['usuario_tipo']); ?></p>
            </div>
        </div>

        <!-- Livros do usuário -->
        <section class="books-section">
            <h2>Meus Livros</h2>
            <div class="livros-grid">
                <?php if ($meus_livros->num_rows > 0): ?>
                    <?php while ($livro = $meus_livros->fetch_assoc()): ?>
                        <div class="card-livro">
                            <div class="card-info">
                                <img src="<?php echo htmlspecialchars($livro['img_url']); ?>" alt="Capa">
                                <h3 class="titulo-livro"><?php echo htmlspecialchars($livro['titulo']); ?></h3>
                                <p class="autor-livro"><?php echo htmlspecialchars($livro['autor']); ?></p>
                                <span class="preco-livro">R$ <?php echo htmlspecialchars($livro['valor']); ?></span>
                            </div>
                            <a href="editar_livro.php?id=<?php echo $livro['id']; ?>" class="btn-adicionar">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="msg-vazia">Você ainda não cadastrou nenhum livro.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <script>
        function aplicarTema(tema) {
            const icone = document.getElementById('icone-tema');
            if (tema === 'escuro') {
                document.body.classList.add('escuro');
                if (icone) { icone.classList.remove('fa-moon'); icone.classList.add('fa-sun'); }
            } else {
                document.body.classList.remove('escuro');
                if (icone) { icone.classList.remove('fa-sun'); icone.classList.add('fa-moon'); }
            }
        }

        function alternarTema() {
            const temaAtual = document.body.classList.contains('escuro') ? 'escuro' : 'claro';
            const novoTema = temaAtual === 'escuro' ? 'claro' : 'escuro';

            fetch('salvar_tema.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'tema=' + novoTema
            }).then(() => aplicarTema(novoTema));
        }

        aplicarTema('<?php echo $tema; ?>');
    </script>
</body>
</html>