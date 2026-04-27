<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// FUNÇÃO PARA ADICIONAR AO CARRINHO
function adicionarAoCarrinho($titulo) {
    $tituloLivro = trim($titulo);
    if (isset($_SESSION['meus_livros'])) {
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }
        foreach ($_SESSION['meus_livros'] as $livro) {
            if (trim($livro['titulo']) === $tituloLivro) {
                $_SESSION['carrinho'][] = $livro;
                return true; 
            }
        }
    }
    return false;
}

// FUNÇÃO PARA VERIFICAR ACESSO
function verificarLogado() {
    if (!isset($_SESSION['logado'])) {
        header("Location: login.php");
        exit();
    }
}
// O arquivo termina aqui! Não coloque JS aqui dentro.
?>