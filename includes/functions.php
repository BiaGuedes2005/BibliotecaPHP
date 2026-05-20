<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se está logado, se não redireciona
function verificarLogado() {
    if (!isset($_SESSION['logado'])) {
        header("Location: login.php");
        exit();
    }
}

// Valida se campos estão vazios
function validarCampos($dados) {
    foreach ($dados as $campo => $valor) {
        if (empty(trim($valor))) {
            return false;
        }
    }
    return true;
}

// Calcula total do carrinho
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

// Faz o login consultando o banco
function fazerLogin($nome, $senha) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nome = ?");
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['logado'] = true;
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];
        return true;
    }
    return false;
}

// Cadastra novo usuário no banco
function cadastrarUsuario($nome, $senha, $tipo) {
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE nome = ?");
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado->num_rows > 0) {
        return "Nome já cadastrado.";
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, senha, tipo) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $senhaHash, $tipo);
    if ($stmt->execute()) {
        return true;
    }
    return "Erro ao cadastrar. Tente novamente.";
}

function verificarSenhaAdm($senhaDigitada) {
    return $senhaDigitada === "PROJETO2026";
}
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
function carregarTema($conn) {
    global $conn;
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