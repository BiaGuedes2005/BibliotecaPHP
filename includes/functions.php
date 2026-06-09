<?php
/**
 * ARQUIVO: FUNÇÕES GERAIS DO SISTEMA
 * Papel: O Manual de Regras, Protocolos e Ferramentas Coletivas
 */

// O ACIONADOR DE MOCHILAS (Sessão):

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. O PORTAL DE SEGURANÇA:

function verificarLogado() {
    if (!isset($_SESSION['logado'])) {
        header("Location: login.php");
        exit();
    }
}

// 2. O DETECTOR DE ESPAÇOS EM BRANCO:

function validarCampos($dados) {
    foreach ($dados as $campo => $valor) {
        if (empty(trim($valor))) {
            return false; 
        }
    }
    return true; 
}

// 3. A MAQUININHA DE CALCULAR DO CAIXA:

function calcularTotalCarrinho() {
    $total = 0;
    if (isset($_SESSION['carrinho'])) {
        foreach ($_SESSION['carrinho'] as $item) {
            $valorLimpo = str_replace(['R$', ' ', '.'], '', $item['valor']);
            $valorNumerico = (float)str_replace(',', '.', $valorLimpo);
            $total += $valorNumerico;
        }
    }
    return $total;
}

// 4. O VALIDADOR DE CREDENCIAIS (LOGIN):

function fazerLogin($nome, $senha) {
    global $conn; // Puxa o encanamento do banco para dentro da função
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nome = ?");
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    // Compara a senha digitada com o hash ultra seguro salvo no cofre
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Preenche a mochila do usuário com seus dados de identificação
        $_SESSION['logado'] = true;
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];
        return true;
    }
    return false; 
}

// 5. O ESCREVENTE DE NOVOS MEMBROS (CADASTRO):

function cadastrarUsuario($nome, $senha, $tipo) {
    global $conn;
    
    // Verifica duplicidade
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE nome = ?");
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado->num_rows > 0) {
        return "Nome já cadastrado."; // Nome indisponível
    }

    // Cria o escudo de criptografia na senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    
    // Grava a nova ficha no cofre do banco
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, senha, tipo) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $senhaHash, $tipo);
    if ($stmt->execute()) {
        return true;
    }
    return "Erro ao cadastrar. Tente novamente.";
}

// 6. A PALAVRA-PASSE DA DIRETORIA:

function verificarSenhaAdm($senhaDigitada) {
    return $senhaDigitada === "PROJETO2026";
}

// 7. O INSERSOR DE ITENS NA CESTA:

function adicionarAoCarrinho($titulo) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM livros WHERE titulo = ?");
    $stmt->bind_param("s", $titulo);
    $stmt->execute();
    $livro = $stmt->get_result()->fetch_assoc();

    if ($livro) {
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }
        $_SESSION['carrinho'][] = [
            'titulo'  => $livro['titulo'],
            'autor'   => $livro['autor'],
            'valor'   => $livro['valor'],
            'img_url' => $livro['img_url']
        ];
        return true;
    }
    return false;
}

// 8. O MEMORIZADOR DE AMBIENTE (TEMA):

function carregarTema($conn) {
    if (!isset($_SESSION['tema']) && isset($_SESSION['usuario_id'])) {
        $stmt = $conn->prepare("SELECT tema FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['usuario_id']);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        $_SESSION['tema'] = $resultado['tema'] ?? 'claro';
    }
    return $_SESSION['tema'] ?? 'claro';
}
?>