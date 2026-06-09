<?php
/**
 * ARQUIVO: PAINEL ADMINISTRATIVO (DASHBOARD)
 * Papel: A Sala da Diretoria e o Painel Geral de Controle
 */

// A COLA 
include '../includes/conexao.php';

// AS FUNÇÕES DA BIBLIOTECA
require_once '../includes/functions.php';

// O SEGURANÇA DA PORTA
verificarLogado();

// --- BARREIRA DE PATENTE ---

if ($_SESSION['usuario_tipo'] !== 'adm') {
    header("Location: ../index.php");
    exit();
}

// O INTERRUPTOR 1
$tema = carregarTema($conn);

// IDENTIFICAÇÃO DO DIRETOR
$usuario_nome = $_SESSION['usuario_nome'];

// EMBLEMA EM INICIAL
$inicial = strtoupper(mb_substr($usuario_nome, 0, 1));

// --- CONSULTA DA PASTA 1 ---

$usuarios = $conn->query("SELECT id, nome, tipo, created_at FROM usuarios WHERE excluido_adm = 0 ORDER BY created_at DESC");

// --- CONSULTA DA PASTA 2---

$livros = $conn->query("SELECT livros.id, livros.titulo, livros.autor, livros.categoria, livros.valor, usuarios.nome AS cadastrado_por FROM livros JOIN usuarios ON livros.usuario_id = usuarios.id WHERE livros.excluido_adm = 0 ORDER BY livros.created_at DESC");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/perfil.css">
    <link rel="stylesheet" href="../assets/adm_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="<?php echo $tema; ?>">

    <nav class="sidebar">
        <div class="icon-group">
            <a href="adm_dashboard.php"><i class="fas fa-user-circle"></i></a>
            <a href="adm_dashboard.php#livros"><i class="fas fa-book"></i></a>
            <a href="adm_dashboard.php#usuarios"><i class="fas fa-users"></i></a>
            <a href="logout.php" style="margin-top: auto; padding-bottom: 20px;">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </nav>

    <main class="content">
        <header class="top-bar perfil-topbar">
            <h1 class="titulo-pagina" style="border-left: 5px solid #F15256; padding-left: 15px; line-height: 1.2;">Painel do Administrador</h1>            
            <button class="btn-tema" id="btnTema" onclick="alternarTema()">
                <i class="fas <?php echo $tema === 'escuro' ? 'fa-sun' : 'fa-moon'; ?>" id="icone-tema"></i>
            </button>
        </header>

        <div class="perfil-card">
            <div class="perfil-inicial"><?php echo $inicial; ?></div>
            <div class="perfil-info">
                <p class="perfil-ola">Olá, <strong><?php echo htmlspecialchars($usuario_nome); ?></strong></p>
                <p class="perfil-tipo">Conta: Administrador</p>
            </div>
        </div>

        <section class="adm-section" id="livros">
            <h2 class="adm-titulo"><i class="fas fa-book"></i> Livros Cadastrados</h2>
            <div class="tabela-wrapper">
                <table class="adm-tabela">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Categoria</th>
                            <th>Valor</th>
                            <th>Cadastrado por</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($livros->num_rows > 0): ?>
                            <?php while ($livro = $livros->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $livro['id']; ?></td>
                                    <td><?php echo htmlspecialchars($livro['titulo']); ?></td>
                                    <td><?php echo htmlspecialchars($livro['autor']); ?></td>
                                    <td><?php echo htmlspecialchars($livro['categoria']); ?></td>
                                    <td>R$ <?php echo htmlspecialchars($livro['valor']); ?></td>
                                    <td><?php echo htmlspecialchars($livro['cadastrado_por']); ?></td>
                                    <td class="acoes">
                                        <a href="adm_editar_livro.php?id=<?php echo $livro['id']; ?>" class="btn-acao btn-editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="adm_excluir_livro.php?id=<?php echo $livro['id']; ?>" 
                                           class="btn-acao btn-excluir-adm"
                                           onclick="return confirm('Excluir o livro \'<?php echo addslashes($livro['titulo']); ?>\'?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="tabela-vazia">Nenhum livro cadastrado.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="adm-section" id="usuarios">
            <h2 class="adm-titulo"><i class="fas fa-users"></i> Usuários Cadastrados</h2>
            <div class="tabela-wrapper">
                <table class="adm-tabela">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Cadastrado em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($usuarios->num_rows > 0): ?>
                            <?php while ($usuario = $usuarios->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $usuario['id']; ?></td>
                                    <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                                    <td>
                                        <span class="badge-tipo <?php echo $usuario['tipo'] === 'adm' ? 'badge-adm' : 'badge-usuario'; ?>">
                                            <?php echo ucfirst($usuario['tipo']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($usuario['created_at'])); ?></td>
                                    <td class="acoes">
                                        <?php if ($usuario['nome'] !== $_SESSION['usuario_nome']): ?>
                                            <a href="adm_excluir_usuario.php?id=<?php echo $usuario['id']; ?>"
                                               class="btn-acao btn-excluir-adm"
                                               onclick="return confirm('Excluir a conta de \'<?php echo addslashes($usuario['nome']); ?>\'?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        <?php else: ?>
                                            <span style="color:#999; font-size:0.8rem;">Você</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="tabela-vazia">Nenhum usuário cadastrado.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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

            // ENVIO ASSÍNCRONO
            fetch('salvar_tema.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'tema=' + novoTema
            }).then(() => aplicarTema(novoTema)); 
        }

        // START INICIAL
        aplicarTema('<?php echo $tema; ?>');
    </script>
</body>
</html>