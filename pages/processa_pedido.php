<?php
/**
 * ARQUIVO: PROCESSA PEDIDO
 * Papel: O Caixa / Balcão de Checkout (Finalizar a Compra)
 */

// A COLA
include '../includes/conexao.php'; 

// livro de regras
require_once '../includes/functions.php';

// O SEGURANÇA DA PORTA
verificarLogado(); 

// O MOMENTO DO PAGAMENTO
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // MÁSCARA DE GÁS
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $endereco = trim($_POST['endereco']);
    $cartao = trim($_POST['cartao']);

    // CHECAGEM DA CESTA
    if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
        header("Location: carrinho.php"); 
        exit();
    }

    // CORREÇÃO DA VALIDAÇÃO
    
    if (empty($nome) || empty($email) || empty($endereco)) {
        echo "<script>alert('Por favor, preencha todos os campos de entrega (Nome, E-mail e Endereço)!'); window.history.back();</script>";
        exit();
    }

    //CORREÇÃO DA VALIDAÇÃO 

    if (strlen($cartao) !== 4) {
        echo "<script>alert('O cartão deve conter exatamente 4 dígitos!'); window.history.back();</script>";
        exit();
    }

    // SE PASSOU PELOS ALERTAS ACIMA, A COMPRA É APROVADA:
    
    // COMPRA REALIZADA!
    $_SESSION['carrinho'] = []; 

    // FLASH MESSAGE
    $_SESSION['sucesso_compra'] = "Obrigado pela compra, seu pedido será preparado em breve!";

    // ENCAMINHAMENTO
    header("Location: ../index.php"); 
    exit();
}
?>