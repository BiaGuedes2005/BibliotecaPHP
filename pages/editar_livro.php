<?php
/**
 * ARQUIVO: EDITAR LIVRO
 * Papel: Oficina de Restauro e Atualização do Livro
 */

// A COLA 
include '../includes/conexao.php';

// AS FUNÇÕES DA BIBLIOTECA
require_once '../includes/functions.php';

// O SEGURANÇA DA PORTA
verificarLogado();

// O INTERRUPTOR 1
$tema = carregarTema($conn);

// CONTROLE DE ENTRADA DA OFICINA
if (!isset($_GET['id'])) {
    header("Location: perfil.php");
    exit();
}

// CONVERSÃO DE SEGURANÇA
$id = (int)$_GET['id'];
$usuario_id = $_SESSION['usuario_id']; 

// --- SEGURANÇA EXTREMA (CHECAGEM DE PROPRIEDADE) ---
$stmt = $conn->prepare("SELECT * FROM livros WHERE id = ? AND usuario_id = ?");
$stmt->bind_param("ii", $id, $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
$livro = $resultado->fetch_assoc(); 

// SEGUNDA TRAVA DE SEGURANÇA
if (!$livro) {
    header("Location: perfil.php");
    exit();
}

// O PROCESSO DE REFORMA (ENVIO DO FORMULÁRIO)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // MÁSCARA DE GÁS
    $titulo    = trim($_POST['titulo']);
    $autor     = trim($_POST['autor']);
    $editora   = trim($_POST['editora']);
    $ano       = trim($_POST['ano']);
    $categoria = trim($_POST['categoria']);
    $sobre     = trim($_POST['sobre']);
    $descricao = trim($_POST['descricao']);
    $valor     = trim($_POST['valor']);
    $img_url   = trim($_POST['img_url']);

    // MANDANDO AS ATUALIZAÇÕES PARA A CAIXA (UPDATE):
    $stmt = $conn->prepare("UPDATE livros SET titulo=?, autor=?, editora=?, ano=?, categoria=?, sobre=?, descricao=?, valor=?, img_url=? WHERE id=? AND usuario_id=?");
    
    // CARIMBANDO OS DADOS COM OS TIPOS
    
    $stmt->bind_param("sssississii", $titulo, $autor, $editora, $ano, $categoria, $sobre, $descricao, $valor, $img_url, $id, $usuario_id);

    // EXECUTANDO A ATUALIZAÇÃO NO BANCO
    if ($stmt->execute()) {
        header("Location: perfil.php");
        exit();
    } else {
        // ALERTA DE REJEIÇÃO
        $erro = "Erro ao salvar. Tente novamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Livro</title>
    <link class="luz" rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/cadastrarlivro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<!-- O INTERRUPTOR 2 -->
<body class="<?php echo $tema; ?>">

    <nav class="sidebar">
        <div class="icon-group">
            <a href="perfil.php"><i class="fas fa-user-circle"></i></a>
            <a href="../index.php"><i class="fas fa-home"></i></a>
            <a href="carrinho.php"><i class="fas fa-shopping-cart"></i></a>
            <a href="cadastrarlivro.php"><i class="fas fa-book-open"></i></a>
            <a href="logout.php" style="margin-top: auto; padding-bottom: 20px;"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </nav>

    <main class="main-wrapper">
        <header class="top-bar">
            <h1 class="titulo-pagina">Editar Livro</h1>
        </header>

        <?php if (isset($erro)): ?>
            <p style="color:red; padding: 0 40px;"><?php echo $erro; ?></p>
        <?php endif; ?>

        <!-- FORMULÁRIO DE EXIBIÇÃO"<?php echo htmlspecialchars($livro['...']); ?>" -->
        <form action="editar_livro.php?id=<?php echo $id; ?>" method="POST" class="cadastro-container">

            <div class="form-content-wrapper">
                
                <!-- PREVIEW DA IMAGEM -->
                <div class="image-upload-section">
                    <label for="img_url">URL da Capa</label>
                    <div class="image-placeholder-container" id="preview-container">
                        <?php if ($livro['img_url']): ?>
                            <img id="preview-img" src="<?php echo htmlspecialchars($livro['img_url']); ?>" style="width:100%; height:100%; object-fit:cover; border-radius:12px;">
                        <?php else: ?>
                            <i class="fas fa-camera" id="camera-icon"></i>
                        <?php endif; ?>
                    </div>
                    <input type="text" id="img_url" name="img_url" oninput="previewImage()" placeholder="Cole a URL aqui..." value="<?php echo htmlspecialchars($livro['img_url']); ?>">
                </div>

                <!-- DEMAIS DADOS DA EMBALAGEM -->
                <div class="form-fields">
                    <div class="input-full">
                        <label>Título do Livro</label>
                        <input type="text" name="titulo" value="<?php echo htmlspecialchars($livro['titulo']); ?>">
                    </div>

                    <div class="input-row">
                        <div class="input-half">
                            <label>Autor</label>
                            <input type="text" name="autor" value="<?php echo htmlspecialchars($livro['autor']); ?>">
                        </div>
                        <div class="input-half">
                            <label>Editora</label>
                            <input type="text" name="editora" value="<?php echo htmlspecialchars($livro['editora']); ?>">
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-half">
                            <label>Ano</label>
                            <input type="number" name="ano" value="<?php echo htmlspecialchars($livro['ano']); ?>">
                        </div>
                        <div class="input-half">
                            <label>Categoria</label>
                            <input type="text" name="categoria" value="<?php echo htmlspecialchars($livro['categoria']); ?>">
                        </div>
                    </div>

                    <div class="input-full">
                        <label>Sobre o livro</label>
                        <input type="text" name="sobre" value="<?php echo htmlspecialchars($livro['sobre']); ?>">
                    </div>

                    <div class="input-row">
                        <div class="input-half">
                            <label>Descrição</label>
                            <input type="text" name="descricao" value="<?php echo htmlspecialchars($livro['descricao']); ?>">
                        </div>
                        <div class="input-half">
                            <label>Valor</label>
                            <input type="text" name="valor" value="<?php echo htmlspecialchars($livro['valor']); ?>">
                        </div>
                    </div>
                </div>

            </div> 
            
            <div class="button-container">
                <!-- ACCIONANDO O TRITURADOR EXTERNO-->
                <a href="excluir_livro.php?id=<?php echo $id; ?>" 
                   class="btn-excluir"
                   onclick="return confirm('Tem certeza que deseja excluir este livro?')">
                    <i class="fas fa-trash-alt"></i> Excluir
                </a>
                <button type="submit" class="btn-cadastrar">Salvar Alterações</button>
                <a href="perfil.php" class="btn-cadastrar btn-cancelar">Cancelar</a>
            </div>
            
        </form>
    </main>

    <script src="../assets/scripts.js"></script>
</body>
</html>