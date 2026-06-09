<?php
/**
 * ARQUIVO: EDITAR LIVRO (MODO ADM)
 * Papel: Intervenção de Cúpula e Moderação do Acervo
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

// --- BLOCO 1: RECOLHIMENTO DA FICHA ATUAL (GET) ---

if (isset($_GET['id'])) {
    $id_livro = (int)$_GET['id'];
    
    $stmt = $conn->prepare("SELECT * FROM livros WHERE id = ? AND excluido_adm = 0");
    $stmt->bind_param("i", $id_livro);
    $stmt->execute();
    $livro = $stmt->get_result()->fetch_assoc();

    if (!$livro) {
        header("Location: adm_dashboard.php");
        exit();
    }
}

// --- BLOCO 2: PROCESSAMENTO DA REFORMA (POST) ---

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // (MÁSCARA DE GÁS).
    $id = (int)$_POST['id'];
    $titulo = trim($_POST['titulo']);
    $autor = trim($_POST['autor']);
    $categoria = trim($_POST['categoria']);
    $valor = trim($_POST['valor']);

    // GARANTIA DE CAMPOS PREENCHIDOS
    if (!empty($titulo) && !empty($autor) && !empty($categoria) && !empty($valor)) {
        
        // O COMANDO DE ATUALIZAÇÃO RE REAL
     
        $stmt = $conn->prepare("UPDATE livros SET titulo = ?, autor = ?, categoria = ?, valor = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $titulo, $autor, $categoria, $valor, $id);
        
        if ($stmt->execute()) {
          
            header("Location: adm_dashboard.php#livros");
            exit();
        } else {
            $erro = "Erro ao atualizar o livro.";
        }
    } else {
        $erro = "Preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Livro (Modo Administrador)</title>
    <link rel="stylesheet" href="../assets/login.css"> 
</head>
<body class="<?php echo $tema; ?>" style="display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f4f7f6;">
    <div class="login-container" style="width: 100%; max-width: 500px;">
        <div class="login-box">
            <h1>EDITAR LIVRO (ADM)</h1>
            
            <?php if(isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

            <form action="adm_editar_livro.php?id=<?php echo $livro['id']; ?>" method="POST">
                
                <input type="hidden" name="id" value="<?php echo $livro['id']; ?>">
                
                <div class="input-group">
                    <label for="titulo">TÍTULO</label>
                    <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($livro['titulo']); ?>" required>
                </div>
                
                <div class="input-group">
                    <label for="autor">AUTOR</label>
                    <input type="text" id="autor" name="autor" value="<?php echo htmlspecialchars($livro['autor']); ?>" required>
                </div>

                <div class="input-group">
                    <label for="categoria">CATEGORIA</label>
                    <input type="text" id="categoria" name="categoria" value="<?php echo htmlspecialchars($livro['categoria']); ?>" required>
                </div>

                <div class="input-group">
                    <label for="valor">VALOR (Ex: 49.90)</label>
                    <input type="text" id="valor" name="valor" value="<?php echo htmlspecialchars($livro['valor']); ?>" required>
                </div>

                <div class="link-cadastro">
                    <a href="adm_dashboard.php">CANCELAR E VOLTAR</a>
                </div>
                <button type="submit" class="btn-entrar" style="background-color: #2ecc71;">SALVAR ALTERAÇÕES</button>
            </form>
        </div>
    </div>
</body>
</html>