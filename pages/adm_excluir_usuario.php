<?php
include '../includes/conexao.php';
require_once '../includes/functions.php';
verificarLogado();

// Segurança: Apenas administradores
if ($_SESSION['usuario_tipo'] !== 'adm') {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id_usuario = (int)$_GET['id'];

    // Segurança extrema: impede que o administrador exclua a si próprio por acidente
    if ($id_usuario === $_SESSION['usuario_id']) {
        header("Location: adm_dashboard.php?erro=autoeleminacao");
        exit();
    }

    // Exclusão lógica do usuário
    $stmt = $conn->prepare("UPDATE usuarios SET excluido_adm = 1 WHERE id = ?");
    $stmt->bind_param("i", $id_usuario);
    
    if ($stmt->execute()) {
        header("Location: adm_dashboard.php#usuarios");
    } else {
        echo "Erro ao excluir o usuário.";
    }
    exit();
} else {
    header("Location: adm_dashboard.php");
    exit();
}
?>