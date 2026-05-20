<?php
include '../includes/conexao.php';
require_once '../includes/functions.php';
verificarLogado();

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $usuario_id = $_SESSION['usuario_id'];

    $stmt = $conn->prepare("DELETE FROM livros WHERE id = ? AND usuario_id = ?");
    $stmt->bind_param("ii", $id, $usuario_id);
    $stmt->execute();
}

header("Location: perfil.php");
exit();
?>