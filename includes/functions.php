<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


 //Transforma em numero para somar o total do carrinho

function calcularTotalCarrinho() {
    $total = 0;
    if (isset($_SESSION['carrinho'])) {
        foreach ($_SESSION['carrinho'] as $item) {
            // Remove R$, espaços e pontos, troca vírgula por ponto
            $valorLimpo = str_replace(['R$', ' ', '.'], '', $item['valor']);
            $valorNumerico = (float)str_replace(',', '.', $valorLimpo);
            $total += $valorNumerico;
        }
    }
    return $total;
}


//Verifica se os campos enviados pelo formulario estao vazios

function validarCampos($dados) {
    foreach ($dados as $campo => $valor) {
        if (empty(trim($valor))) {
            return false;
        }
    }
    return true;
}

// funcao para add ao carrinho
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

// funcao para verificar o acesso 
function verificarLogado() {
    if (!isset($_SESSION['logado'])) {
        header("Location: login.php");
        exit();
    }
}
?>