<?php
// Liga o encanamento
include '../includes/conexao.php';
require_once '../includes/functions.php';
verificarLogado();

if (isset($_GET['id'])) {
    $id_livro = (int)$_GET['id'];
    $usuario_id = $_SESSION['usuario_id']; // Pega o ID da mochila do usuário logado

    // SEGURANÇA EXTREMA: Só muda o status para '2' (aviso visto) se o livro realmente pertencer a este usuário
    $stmt = $conn->prepare("UPDATE livros SET excluido_adm = 2 WHERE id = ? AND usuario_id = ?");
    $stmt->bind_param("ii", $id_livro, $usuario_id);
    
    if ($stmt->execute()) {
        header("Location: perfil.php"); // Recarrega o perfil sem o alerta vermelho
    }
    exit();
}
?>