<?php
// Liga o encanamento com o banco de dados
include '../includes/conexao.php';
require_once '../includes/functions.php';

// Ativa a verificação para saber se o usuário está com a mochila (sessão) ativa
verificarLogado();

// SEGURANÇA: O porteiro só deixa passar se quem estiver acessando for o 'adm'
if ($_SESSION['usuario_tipo'] !== 'adm') {
    header("Location: ../index.php"); // Expulsa para a Prateleira
    exit();
}

// Se o ID do livro veio na URL...
if (isset($_GET['id'])) {
    $id_livro = (int)$_GET['id'];

    // MÁSCARA DE GÁS (?): Prepara o comando com segurança
    // EXCLUSÃO LÓGICA: Não deleta, só esconde debaixo do tapete (excluido_adm = 1)
    $stmt = $conn->prepare("UPDATE livros SET excluido_adm = 1, titulo_original = titulo WHERE id = ?");
    $stmt->bind_param("i", $id_livro);
    
    if ($stmt->execute()) {
        // Deu certo! Manda de volta para a Sala do Chefe na seção de livros
        header("Location: adm_dashboard.php#livros");
    }
    exit();
}
?>