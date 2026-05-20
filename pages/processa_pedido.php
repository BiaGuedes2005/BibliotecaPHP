<?php
include '../includes/conexao.php'; // Liga o encanamento
require_once '../includes/functions.php';
verificarLogado(); // O porteiro checa se a mochila existe

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 🛡️ MÁSCARA DE GÁS (Sanitização): Limpa os espaços que o usuário digitou sem querer
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $endereco = trim($_POST['endereco']);
    $cartao = trim($_POST['cartao']);

    // CHECAGEM DA CESTA: Se a Cesta de Compras estiver vazia, não faz sentido finalizar a compra!
    if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
        header("Location: carrinho.php"); // Manda de volta para a Cesta
        exit();
    }

    // VALIDAÇÃO: Se tudo estiver preenchido e o cartão tiver os 4 dígitos...
    if (!empty($nome) && !empty($email) && !empty($endereco) && strlen($cartao) === 4) {
        
        $_SESSION['carrinho'] = []; // COMPRA REALIZADA! Esvazia a Cesta de Compras

        // FLASH MESSAGE: Guarda o bilhete de agradecimento na mochila temporariamente
        $_SESSION['sucesso_compra'] = "Obrigado pela compra, seu pedido será preparado em breve!";

        header("Location: ../index.php"); // Redireciona para a Prateleira (index)
        exit();
    }
}
?>